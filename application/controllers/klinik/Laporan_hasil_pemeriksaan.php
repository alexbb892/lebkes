<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_hasil_pemeriksaan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('klinik/Laporan_hasil_pemeriksaan_model');
        $this->load->database();
        $this->load->library('session');
    }

    public function index()
    {
        $data['title'] = 'Laporan Pasien';

        $data['registrations'] = $this->Laporan_hasil_pemeriksaan_model->get_daily_registrations();
        $data['visits'] = $this->Laporan_hasil_pemeriksaan_model->get_daily_visits();
        $data['klinik'] = $this->Laporan_hasil_pemeriksaan_model->get_daily_klinik();
        $data['uji_klinik'] = $this->Laporan_hasil_pemeriksaan_model->get_daily_uji_klinik();

        // Helper array for indonesian days
        $data['hari_indo'] = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        $this->load->view('klinik/layout/header', $data);
        $this->load->view('klinik/layout/sidebar');
        $this->load->view('klinik/laporan_rekam_medis/index', $data);
        $this->load->view('klinik/layout/footer');
    }

    public function detail_pasien($date = null)
    {
        $this->load->model('klinik/Pasien_model');
        $this->load->model('klinik/Laporan_hasil_pemeriksaan_model');
        
        $data['tanggal'] = $date;

        if ($date) {
            // Convert to nice format
            $timestamp = strtotime($date);
            $hari_en = date('l', $timestamp);
            $hari_indo = [
                'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
            ];
            $data['title'] = 'Identitas Pasien Klinik - ' . $hari_indo[$hari_en] . ', ' . date('d-m-Y', $timestamp);
            $data['pasien'] = $this->Laporan_hasil_pemeriksaan_model->get_patients_by_date($date);
        } else {
            $data['title'] = 'Identitas Pasien Klinik';
            $data['pasien'] = $this->Pasien_model->get_all();
        }

        $this->load->view('klinik/layout/header', $data);
        $this->load->view('klinik/layout/sidebar');
        $this->load->view('klinik/laporan_rekam_medis/detail_pasien', $data);
        $this->load->view('klinik/layout/footer');
    }

    public function print_pasien_pdf($date)
    {
        $data['tanggal'] = $date;
        $timestamp = strtotime($date);
        $hari_en = date('l', $timestamp);
        $hari_indo = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        $data['title'] = 'Laporan Pasien Klinik - ' . $hari_indo[$hari_en] . ', ' . date('d-m-Y', $timestamp);
        $this->load->model('klinik/Laporan_hasil_pemeriksaan_model');
        $data['pasien'] = $this->Laporan_hasil_pemeriksaan_model->get_patients_by_date($date);
        $data['is_pdf'] = true;

        $this->load->library('pdf');
        $this->pdf->generate_view('klinik/laporan_rekam_medis/print_pasien', $data, 'klinik/Laporan_Pasien_Klinik_' . $date . '.pdf', 'I');
    }

    public function detail_uji_klinik($date = null)
    {
        $this->load->model('klinik/Uji_klinik_model');
        $this->load->model('klinik/Laporan_hasil_pemeriksaan_model');
        
        if ($date) {
            $timestamp = strtotime($date);
            $hari_en = date('l', $timestamp);
            $hari_indo = [
                'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
            ];
            $data['title'] = 'Laporan Uji Laboratorium Klinik - ' . $hari_indo[$hari_en] . ', ' . date('d-m-Y', $timestamp);
            $data['formulir'] = $this->Laporan_hasil_pemeriksaan_model->get_uji_klinik_by_date($date);
        } else {
            $data['title'] = 'Laporan Keseluruhan Uji Laboratorium Klinik';
            $data['formulir'] = []; // If needed, can add get_all_uji_klinik
        }

        $this->load->view('klinik/layout/header', $data);
        $this->load->view('klinik/layout/sidebar');
        $this->load->view('klinik/laporan_rekam_medis/detail_uji_klinik', $data);
        $this->load->view('klinik/layout/footer');
    }

    public function detail_pendaftaran($date)
    {
        // $date is in Y-m-d format
        $data['tanggal'] = $date;

        // Convert to nice format
        $timestamp = strtotime($date);
        $hari_en = date('l', $timestamp);
        $hari_indo = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        $data['title'] = 'Detail Pasien Terdaftar - ' . $hari_indo[$hari_en] . ', ' . date('d-m-Y', $timestamp);
        $data['pasien'] = $this->Laporan_hasil_pemeriksaan_model->get_patients_by_date($date);

        $this->load->view('klinik/layout/header', $data);
        $this->load->view('klinik/layout/sidebar');
        $this->load->view('klinik/laporan_rekam_medis/detail_pendaftaran', $data);
        $this->load->view('klinik/layout/footer');
    }

    public function detail_kunjungan($date)
    {
        // $date is in Y-m-d format
        $data['tanggal'] = $date;

        // Convert to nice format
        $timestamp = strtotime($date);
        $hari_en = date('l', $timestamp);
        $hari_indo = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        $data['title'] = 'Detail Kunjungan Pasien - ' . $hari_indo[$hari_en] . ', ' . date('d-m-Y', $timestamp);
        $data['kunjungan'] = $this->Laporan_hasil_pemeriksaan->get_visits_by_date($date);

        $this->load->view('klinik/layout/header', $data);
        $this->load->view('klinik/layout/sidebar');
        $this->load->view('klinik/laporan_rekam_medis/detail_kunjungan', $data);
        $this->load->view('klinik/layout/footer');
    }
    public function print_pendaftaran_pdf($date)
    {
        $data['tanggal'] = $date;
        $timestamp = strtotime($date);
        $hari_en = date('l', $timestamp);
        $hari_indo = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        $data['title'] = 'Laporan Pendaftaran Pasien - ' . $hari_indo[$hari_en] . ', ' . date('d-m-Y', $timestamp);
        $data['pasien'] = $this->Laporan_hasil_pemeriksaan_model->get_patients_by_date($date);
        $data['is_pdf'] = true;

        $this->load->library('pdf');
        $this->pdf->generate_view('klinik/laporan_rekam_medis/print_pendaftaran', $data, 'Laporan_Pendaftaran_' . $date . '.pdf', 'I');
    }

    public function print_kunjungan_pdf($date)
    {
        $data['tanggal'] = $date;
        $timestamp = strtotime($date);
        $hari_en = date('l', $timestamp);
        $hari_indo = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        $data['title'] = 'Laporan Kunjungan Pasien - ' . $hari_indo[$hari_en] . ', ' . date('d-m-Y', $timestamp);
        $data['kunjungan'] = $this->Laporan_hasil_pemeriksaan_model->get_visits_by_date($date);
        $data['is_pdf'] = true;

        $this->load->library('pdf');
        $this->pdf->generate_view('klinik/laporan_rekam_medis/print_kunjungan', $data, 'Laporan_Kunjungan_' . $date . '.pdf', 'I');
    }
    public function laporan_hasil_uji_soap()
    {
        $data['title'] = 'Laporan Hasil Uji dan SOAP';

        // Ambil data harian gabungan (tanggal yang memiliki SOAP atau Hasil Lab)
        $sql = "SELECT tanggal, COUNT(DISTINCT id_gabungan) as total_aktivitas
                FROM (
                    SELECT DATE(tanggal_kunjungan) as tanggal, CONCAT('SOAP-', id) as id_gabungan 
                    FROM kunjungan_rm 
                    WHERE tanggal_kunjungan IS NOT NULL
                    UNION
                    SELECT DATE(f.tgl_form) as tanggal, CONCAT('LAB-', f.id) as id_gabungan
                    FROM form_permintaan_klinik f
                    JOIN form_permintaan_klinik_detail d ON f.id = d.id_form
                    WHERE f.tgl_form IS NOT NULL AND d.hasil IS NOT NULL AND d.hasil <> ''
                ) as combined
                GROUP BY tanggal
                ORDER BY tanggal DESC";
        
        $data['combined_data'] = $this->db->query($sql)->result();

        $data['hari_indo'] = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];

        $this->load->view('klinik/layout/header', $data);
        $this->load->view('klinik/layout/sidebar');
        $this->load->view('klinik/laporan_rekam_medis/laporan_hasil_uji_soap', $data);
        $this->load->view('klinik/layout/footer');
    }

    public function detail_hasil_uji_soap($date)
    {
        $data['title'] = 'Daftar Laporan Pasien Rekam Medis & klinik';
        $data['date'] = $date;

        // Helper array for indonesian days
        $hari_indo_map = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $timestamp = strtotime($date);
        $data['formatted_date'] = $hari_indo_map[date('l', $timestamp)] . ', ' . date('j F Y', $timestamp);

        // Ambil daftar pasien unik yang memiliki aktivitas (SOAP atau Lab) pada tanggal tersebut
        $sql = "SELECT DISTINCT 
                    p.no_rm, 
                    p.nama_pasien, 
                    p.gender, 
                    p.umur,
                    COALESCE(k.waktu, f.waktu) as waktu_terdaftar,
                    k.id as soap_id,
                    k.status_soap,
                    f.id as lab_id,
                    f.has_results
                FROM pasien_rm p
                LEFT JOIN (
                    SELECT id, no_rm, status_soap, DATE(tanggal_kunjungan) as tgl, TIME(tanggal_kunjungan) as waktu 
                    FROM kunjungan_rm
                ) k ON p.no_rm = k.no_rm AND k.tgl = ?
                LEFT JOIN (
                    SELECT f.id, f.nik, DATE(f.tgl_form) as tgl, TIME(f.tgl_form) as waktu,
                           (SELECT COUNT(*) FROM form_permintaan_klinik_detail d2 WHERE d2.id_form = f.id AND d2.hasil IS NOT NULL AND d2.hasil <> '') as has_results
                    FROM form_permintaan_klinik f
                ) f ON p.nik = f.nik AND f.tgl = ?
                WHERE k.id IS NOT NULL OR f.id IS NOT NULL
                ORDER BY waktu_terdaftar ASC";
        
        $data['patients'] = $this->db->query($sql, [$date, $date])->result();

        $this->load->view('klinik/layout/header', $data);
        $this->load->view('klinik/layout/sidebar');
        $this->load->view('klinik/laporan_rekam_medis/detail_hasil_uji_soap', $data);
        $this->load->view('klinik/layout/footer');
    }

    public function get_lab_details_ajax($id)
    {
        $this->db->select('f.*');
        $this->db->from('form_permintaan_klinik f');
        $this->db->where('f.id', $id);
        $form = $this->db->get()->row();

        $details = $this->db->get_where('form_permintaan_klinik_detail', ['id_form' => $id])->result();

        if (!$form) {
            echo "Data tidak ditemukan.";
            return;
        }

        echo '<h6><strong>Pasien:</strong> ' . $form->nama_pasien . '</h6>';
        echo '<h6><strong>Dokter:</strong> ' . $form->nama_dokter . '</h6>';
        echo '<hr>';
        echo '<table class="table table-sm table-striped">';
        echo '<thead class="table-dark"><tr><th>Pemeriksaan</th><th>Hasil</th><th>Satuan</th></tr></thead>';
        echo '<tbody>';
        foreach ($details as $d) {
            if ($d->hasil) {
                echo '<tr>';
                echo '<td>' . $d->nama_jenis . '</td>';
                echo '<td><strong>' . $d->hasil . '</strong></td>';
                echo '<td>' . $d->satuan . '</td>';
                echo '</tr>';
            }
        }
        echo '</tbody></table>';
    }

    public function get_soap_details_ajax($id)
    {
        $this->db->select('k.*, p.nama_pasien');
        $this->db->from('kunjungan_rm k');
        $this->db->join('pasien_rm p', 'p.no_rm = k.no_rm', 'left');
        $this->db->where('k.id', $id);
        $visit = $this->db->get()->row();

        if (!$visit) {
            echo "Data tidak ditemukan.";
            return;
        }

        echo '<div class="row">';
        echo '<div class="col-md-6"><strong>No. RM:</strong> ' . $visit->no_rm . '</div>';
        echo '<div class="col-md-6"><strong>Nama Pasien:</strong> ' . $visit->nama_pasien . '</div>';
        echo '</div><hr>';
        echo '<div class="mb-2"><strong>Subjective (S):</strong><br>' . nl2br($visit->subjective) . '</div>';
        echo '<div class="mb-2"><strong>Objective (O):</strong><br>' . nl2br($visit->objective) . '</div>';
        echo '<div class="mb-2"><strong>Assessment (A):</strong><br>' . nl2br($visit->assessment) . '</div>';
        echo '<div class="mb-2"><strong>Planning (P):</strong><br>' . nl2br($visit->planning) . '</div>';
    }

    public function laporan_bulanan_tahunan($bulan = null, $tahun = null)
    {
        // jika kosong gunakan bulan & tahun sekarang
        $bulan = $bulan ?? date('m');
        $tahun = $tahun ?? date('Y');

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $this->load->model('klinik/Laporan_hasil_pemeriksaan_model');

        $data['hematologi'] =
            $this->Laporan_hasil_pemeriksaan_model
            ->get_kategori_bulan('HEMATOLOGI', $bulan, $tahun);

        $data['kimia_darah'] =
            $this->Laporan_hasil_pemeriksaan_model
            ->get_kategori_bulan('KIMIA DARAH', $bulan, $tahun);

        $data['urinalisis'] =
            $this->Laporan_hasil_pemeriksaan_model
            ->get_kategori_bulan('URINALISA', $bulan, $tahun);

        $data['hemostasis'] =
            $this->Laporan_hasil_pemeriksaan_model
            ->get_kategori_bulan('HEMOSTASIS', $bulan, $tahun);

        $data['biomolekuler'] =
            $this->Laporan_hasil_pemeriksaan_model
            ->get_kategori_bulan('BIOMOLEKULER', $bulan, $tahun);

        $data['imunologi'] =
            $this->Laporan_hasil_pemeriksaan_model
            ->get_kategori_bulan('IMUNOLOGI', $bulan, $tahun);

        $data['mikrobiologi'] =
            $this->Laporan_hasil_pemeriksaan_model
            ->get_kategori_bulan('MIKROBIOLOGI', $bulan, $tahun);

        $data['toksikologi'] =
            $this->Laporan_hasil_pemeriksaan_model
            ->get_kategori_bulan('TOKSIKOLOGI', $bulan, $tahun);

        $data['jumlah_pasien'] = 
            $this->Laporan_hasil_pemeriksaan_model
            ->get_jumlah_pasien_bulan($bulan, $tahun);

        $data['puskesmas_wilayah'] = 
            $this->Laporan_hasil_pemeriksaan_model
            ->get_jumlah_puskesmas_bulan($bulan, $tahun);

        $this->load->view('klinik/layout/header', $data);
        $this->load->view('klinik/layout/sidebar');
        $this->load->view('klinik/laporan_bulanan_tahunan/index', $data);
        $this->load->view('klinik/layout/footer');
    }
    // ================= LAPORAN TAHUNAN =================
    public function laporan_tahunan()
    {
        $tahun = $this->input->get('tahun');

        if(!$tahun){
            $tahun = date('Y');
        }

        $data['tahun'] = $tahun;

        $this->load->model('klinik/Laporan_hasil_pemeriksaan_model');

        $data['laporan_tahunan'] =
            $this->Laporan_hasil_pemeriksaan_model
            ->get_laporan_tahunan($tahun);

        $this->load->view('klinik/layout/header', $data);
        $this->load->view('klinik/layout/sidebar');
        $this->load->view('klinik/laporan_bulanan_tahunan/laporan_tahunan', $data);
        $this->load->view('klinik/layout/footer');
    }

    public function export_excel_tahunan()
    {
        $tahun = $this->input->get('tahun');

        if(!$tahun){
            $tahun = date('Y');
        }

        $data['tahun'] = $tahun;

        $this->load->model('klinik/Laporan_hasil_pemeriksaan_model');

        $data['laporan_tahunan'] =
            $this->Laporan_hasil_pemeriksaan_model
            ->get_laporan_tahunan($tahun);

        // Header for Excel file
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Tahunan_" . $tahun . ".xls");

        $this->load->view('klinik/laporan_bulanan_tahunan/excel_laporan_tahunan', $data);
    }
}
