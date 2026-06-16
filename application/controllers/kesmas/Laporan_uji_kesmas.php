<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Kesmas_model $Kesmas_model
 * @property Verifikator_model $Verifikator_model
 * @property Penanggung_jawab_teknis_model $Penanggung_jawab_teknis_model
 */
class Laporan_uji_kesmas extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kesmas_model');
        $this->load->helper('report'); // Load the new helper
    }

    public function index()
    {
        $filters = array(
            'q' => $this->input->get('q', true),
            'dari' => $this->input->get('dari', true),
            'sampai' => $this->input->get('sampai', true),
            'is_diterima' => 1,
            'status_laporan' => $this->input->get('status', true),
        );

        // Fetch all permintaan data
        $permintaan_list = $this->Kesmas_model->list_permintaan($filters);

        // Enhance with petugas name for display in list
        foreach ($permintaan_list as &$p) {
            $p['petugas_pengambil_nama'] = '-';
            if (!empty($p['petugas_pengambil_id'])) {
                $p['petugas_pengambil_nama'] = $this->Kesmas_model->get_petugas_name_by_id($p['petugas_pengambil_id']) ?: '-';
            }
        }
        unset($p); // Break the reference

        $data = array(
            'title' => 'Laporan Uji Kesmas',
            'rows' => $permintaan_list,
            'filters' => $filters,
        );
        $this->render('kesmas/laporan_list', $data);
    }

    private function _build_laporan_data($permintaan_id)
    {
        $permintaan_id = (int)$permintaan_id;
        if ($permintaan_id <= 0) {
            show_404();
        }

        $permintaan = $this->Kesmas_model->get_permintaan($permintaan_id);
        if (!$permintaan) {
            show_404();
        }

        // 1. Get ordered items from master
        $items = $this->Kesmas_model->get_permintaan_items_with_master($permintaan_id);
        
        // 2. Get results separately
        $hasil_rows = $this->Kesmas_model->get_hasil_by_permintaan($permintaan_id);

        // 3. Create a map of results for efficient merging
        $hasil_map = [];
        foreach ($hasil_rows as $row) {
            $hasil_map[$row['permintaan_item_id']] = $row;
        }

        // 4. Merge results into items
        foreach ($items as &$item) {
            if (isset($hasil_map[$item['permintaan_item_id']])) {
                // Merge all fields from hasil_map into item
                $item = array_merge($item, $hasil_map[$item['permintaan_item_id']]);
            }
        }
        unset($item); // break the reference

        // Get other display values. These are stored per-item in 'kesmas_hasil',
        // but are the same for the whole report. We find the first available value.
        $tgl_jam_pengambilan = $permintaan['tgl_pengambilan'] && $permintaan['jam_pengambilan'] ? $permintaan['tgl_pengambilan'] . ' ' . $permintaan['jam_pengambilan'] : null;
        $tgl_jam_pemeriksaan = null;
        $tgl_jam_selesai = null;
        $tgl_jam_lapor = null;
        $petugas_pengambil_spesimen_id = $permintaan['petugas_pengambil_id'] ?? null;

        // Find the first available value from any of the result rows
        if (!empty($hasil_rows)) {
            foreach ($hasil_rows as $h) {
                if (!$tgl_jam_pemeriksaan && !empty($h['tgl_jam_pemeriksaan'])) $tgl_jam_pemeriksaan = $h['tgl_jam_pemeriksaan'];
                if (!$tgl_jam_selesai && !empty($h['tgl_jam_selesai'])) $tgl_jam_selesai = $h['tgl_jam_selesai'];
                if (!$tgl_jam_lapor && !empty($h['tgl_jam_lapor'])) $tgl_jam_lapor = $h['tgl_jam_lapor'];
                if ($tgl_jam_pemeriksaan && $tgl_jam_selesai && $tgl_jam_lapor) break;
            }
        }

        $petugas_pengambil_nama = $petugas_pengambil_spesimen_id ? $this->Kesmas_model->get_petugas_name_by_id($petugas_pengambil_spesimen_id) : '-';

        // Group items by 'kelompok' for the view
        $grouped_items = [];
        foreach ($items as $item) {
            $kel = $item['kelompok'] ?? 'LAINNYA';
            $grouped_items[$kel][] = $item;
        }

        return [
            'permintaan' => $permintaan,
            'items' => $items, // Pass the merged and ordered items
            'grouped_items' => $grouped_items,
            'tgl_jam_pengambilan_display' => $tgl_jam_pengambilan,
            'tgl_jam_pemeriksaan_display' => $tgl_jam_pemeriksaan,
            'tgl_jam_selesai_display' => $tgl_jam_selesai,
            'tgl_jam_lapor_display' => $tgl_jam_lapor,
            'petugas_pengambil_spesimen_nama' => $petugas_pengambil_nama,
        ];
    }

    public function detail($permintaan_id)
    {
        $data = $this->_build_laporan_data($permintaan_id);
        $data['title'] = 'Laporan Hasil Uji Laboratorium Kesmas';
        
        $this->load->model('Verifikator_model');
        $this->load->model('Penanggung_jawab_teknis_model');
        $data['petugas_list'] = $this->Kesmas_model->list_petugas();
        $data['verifikator_list'] = $this->Verifikator_model->list_verifikator();
        $data['penanggung_jawab_teknis_list'] = $this->Penanggung_jawab_teknis_model->list_penanggung_jawab_teknis();

        $this->render('kesmas/laporan_detail', $data);
    }

    public function print($permintaan_id)
    {
        $data = $this->_build_laporan_data($permintaan_id);
        
        $petugas_id = $this->input->get('petugas_id');
        $verifikator_id = $this->input->get('verifikator_id');
        $penanggung_jawab_id = $this->input->get('penanggung_jawab_id');

        $this->load->model('Verifikator_model');
        $this->load->model('Penanggung_jawab_teknis_model');

        $petugas = $petugas_id ? $this->Kesmas_model->get_petugas_by_id($petugas_id) : null;
        $verifikator = $verifikator_id ? $this->Verifikator_model->get_verifikator_by_id($verifikator_id) : null;
        $penanggung_jawab = $penanggung_jawab_id ? $this->Penanggung_jawab_teknis_model->get_penanggung_jawab_teknis_by_id($penanggung_jawab_id) : null;

        $data['petugas_pemeriksa'] = $petugas;
        $data['verifikator'] = $verifikator;
        $data['penanggung_jawab_teknis'] = $penanggung_jawab;

        $this->load->view('kesmas/print_laporan', $data);
    }

    /**
     * AJAX endpoint to set MS/TMS status per permintaan_item_id.
     * Expects POST: permintaan_item_id, status (MS|TMS)
     */
    public function set_status()
    {
        if ($this->input->method() !== 'post') {
            show_404();
        }

        $permintaan_item_id = (int)$this->input->post('permintaan_item_id', true);
        $status = $this->input->post('status', true);
        $user_id = $this->session->userdata('user_id') ?: null;

        if ($permintaan_item_id <= 0 || empty($status)) {
            $resp = ['ok' => false, 'message' => 'Invalid input'];
            $resp[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
            header('Content-Type: application/json');
            echo json_encode($resp);
            return;
        }

        $ok = $this->Kesmas_model->set_hasil_tms_status($permintaan_item_id, $status, $user_id);
        $resp = ['ok' => $ok];
        // include refreshed CSRF token so client can update it
        $resp[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
        header('Content-Type: application/json');
        echo json_encode($resp);
    }

    /**
     * Parameter summary report: aggregate MS/TMS counts per master pemeriksaan.
     */
    public function parameter()
    {
        $search_query = $this->input->get('q', true);
        $dari = $this->input->get('dari', true);
        $sampai = $this->input->get('sampai', true);

        // Jika user tidak mencari apapun dan tidak set tanggal, default ke bulan ini.
        // Jika user mencari (mengisi `q`), kita cari ke semua bulan jika `dari`/`sampai` kosong.
        if (empty($dari) && empty($sampai) && empty($search_query)) {
            $d = date('Y-m');
            $s = date('Y-m');
        } else {
            $d = !empty($dari) ? $dari : '2000-01';
            $s = !empty($sampai) ? $sampai : date('Y-m', strtotime('+10 years'));
        }

        $month_expr = "COALESCE(DATE_FORMAT(h.tgl_jam_lapor, '%Y-%m'), DATE_FORMAT(h.tgl_jam_selesai, '%Y-%m'), DATE_FORMAT(h.tgl_jam_pemeriksaan, '%Y-%m'), DATE_FORMAT(h.input_at, '%Y-%m'))";

        $sql = "SELECT {$month_expr} AS bulan, 
                m.id AS master_id,
                m.nama_pemeriksaan,
                m.satuan,
                m.baku_mutu,
                p.jenis_sampel,
                COUNT(h.id) AS total_tested,
                SUM(CASE WHEN UPPER(TRIM(h.keterangan)) = 'MS' THEN 1 ELSE 0 END) AS ms_count,
                SUM(CASE WHEN UPPER(TRIM(h.keterangan)) = 'TMS' THEN 1 ELSE 0 END) AS tms_count
            FROM kesmas_hasil h
            JOIN kesmas_permintaan_item i ON i.id = h.permintaan_item_id
            JOIN kesmas_permintaan p ON p.id = i.permintaan_id
            JOIN kesmas_master_pemeriksaan m ON m.id = i.master_pemeriksaan_id
            WHERE ({$month_expr} BETWEEN ? AND ?)
            AND UPPER(TRIM(h.keterangan)) IN ('MS', 'TMS')
            " . (!empty($search_query) ? "AND m.nama_pemeriksaan LIKE ?" : "") . "
            GROUP BY bulan, m.id, m.nama_pemeriksaan, m.satuan, m.baku_mutu, p.jenis_sampel
            ORDER BY bulan DESC, m.nama_pemeriksaan ASC, p.jenis_sampel ASC";

        $params = [$d, $s];
        if (!empty($search_query)) {
            $params[] = '%' . $search_query . '%';
        }

        $rows = $this->db->query($sql, $params)->result_array();

        // Build grouped_rows keyed by bulan
        $grouped_rows = [];
        foreach ($rows as $row) {
            $bulan_key = $row['bulan'] ?: date('Y-m');
            $key = $row['nama_pemeriksaan'];
            if (!isset($grouped_rows[$bulan_key])) $grouped_rows[$bulan_key] = [];
            if (!isset($grouped_rows[$bulan_key][$key])) {
                $grouped_rows[$bulan_key][$key] = [
                    'nama_pemeriksaan' => $row['nama_pemeriksaan'],
                    'master_id' => $row['master_id'],
                    'satuan' => $row['satuan'],
                    'baku_mutu' => $row['baku_mutu'],
                    'total_ms' => 0,
                    'total_tms' => 0,
                    'sampel_sumber' => [],
                ];
            }
            $grouped_rows[$bulan_key][$key]['sampel_sumber'][] = [
                'jenis_sampel' => $row['jenis_sampel'],
                'total_tested' => (int)$row['total_tested'],
                'ms_count' => (int)$row['ms_count'],
                'tms_count' => (int)$row['tms_count'],
            ];
            $grouped_rows[$bulan_key][$key]['total_ms'] += (int)$row['ms_count'];
            $grouped_rows[$bulan_key][$key]['total_tms'] += (int)$row['tms_count'];
        }

        foreach ($grouped_rows as $m => $groups) {
            $grouped_rows[$m] = array_values($groups);
        }

        $data = [
            'title' => 'Laporan Parameter (MS/TMS)',
            'grouped_rows' => $grouped_rows,
            'bulan' => date('Y-m'),
        ];

        $this->render('kesmas/laporan_parameter', $data);
    }

    /**
     * AJAX: return list of permintaan (id, no_registrasi) for a given master_pemeriksaan and month
     * GET params: master_id, bulan (YYYY-MM)
     */
    public function parameter_samples()
    {
        if ($this->input->method() !== 'get') {
            show_404();
        }

        $master_id = (int)$this->input->get('master_id', true);
        $bulan = $this->input->get('bulan', true) ?: date('Y-m');
        $status = strtoupper(trim($this->input->get('status', true)));
        $search_query = $this->input->get('q', true);

        // Pagination params
        $page = max(1, (int)$this->input->get('page', true) ?: 1);
        $per_page = max(10, min(500, (int)$this->input->get('per_page', true) ?: 100));
        $offset = ($page - 1) * $per_page;

        // Build base where clause for reuse: match any relevant timestamp in the given month
        $month_expr = "COALESCE(DATE_FORMAT(h.tgl_jam_lapor, '%Y-%m'), DATE_FORMAT(h.tgl_jam_selesai, '%Y-%m'), DATE_FORMAT(h.tgl_jam_pemeriksaan, '%Y-%m'), DATE_FORMAT(h.input_at, '%Y-%m'))";
        $status_filter = in_array($status, ['MS', 'TMS']) ? "UPPER(TRIM(h.keterangan)) = '{$status}'" : "UPPER(TRIM(h.keterangan)) IN ('MS', 'TMS')";
        $where_clause = "{$status_filter} AND {$month_expr} = ?";

        $params = array($bulan);
        if ($master_id > 0) {
            $where_clause .= " AND i.master_pemeriksaan_id = ?";
            $params[] = $master_id;
        }
        if (!empty($search_query)) {
            $where_clause .= " AND m.nama_pemeriksaan LIKE ?";
            $params[] = '%' . $search_query . '%';
        }

        // Total distinct permintaan count
        $count_sql = "SELECT COUNT(h.id) AS total FROM kesmas_hasil h 
            JOIN kesmas_permintaan_item i ON i.id = h.permintaan_item_id 
            JOIN kesmas_permintaan p ON p.id = h.permintaan_id 
            JOIN kesmas_master_pemeriksaan m ON m.id = i.master_pemeriksaan_id
            WHERE {$where_clause}";
        $count_row = $this->db->query($count_sql, $params)->row_array();
        $total = (int)($count_row['total'] ?? 0);

        // Fetch paginated rows with aggregated status per permintaan (prefer TMS if any, else MS)
        $sql = "SELECT p.id, p.no_registrasi, p.jenis_sampel, p.tgl_permintaan, m.nama_pemeriksaan, h.keterangan as status
            FROM kesmas_hasil h
            JOIN kesmas_permintaan_item i ON i.id = h.permintaan_item_id
            JOIN kesmas_permintaan p ON p.id = h.permintaan_id
            JOIN kesmas_master_pemeriksaan m ON m.id = i.master_pemeriksaan_id
            WHERE {$where_clause}
            ORDER BY p.tgl_permintaan DESC, p.id DESC
            LIMIT ? OFFSET ?";
        
        $params[] = $per_page;
        $params[] = $offset;

        $rows = $this->db->query($sql, $params)->result_array();

        $resp = [
            'ok' => true,
            'rows' => $rows,
            'total' => $total,
            'page' => $page,
            'per_page' => $per_page,
        ];
        $resp[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
}
