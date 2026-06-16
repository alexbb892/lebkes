<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kesmas_model extends CI_Model
{
    public function gen_no_registrasi(): string
    {
        $ymd = date('Ymd');
        $prefix = 'KESMAS.' . $ymd . '.';

        $this->db->like('no_registrasi', $prefix, 'after');
        $this->db->from('kesmas_permintaan');
        $count = $this->db->count_all_results();

        $num = $count + 1;
        return $prefix . str_pad((string)$num, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Simple heuristic to determine MS/TMS from master `baku_mutu` and result `hasil`.
     * Returns 'MS' or 'TMS' or null if undetermined.
     */
    private function determine_keterangan_from_baku(?string $baku, $hasil): ?string
    {
        if ($hasil === null || $hasil === '') return null;
        $baku_norm = mb_strtolower(trim((string)$baku));
        $hasil_norm = mb_strtolower(trim((string)$hasil));

        // Normalize decimal comma to dot for numbers like '6,5' -> '6.5'
        $baku_norm = preg_replace_callback('/(?<=\d),(?=\d)/u', function($m){ return '.'; }, $baku_norm);
        $hasil_norm = preg_replace_callback('/(?<=\d),(?=\d)/u', function($m){ return '.'; }, $hasil_norm);

        // Handle scientific notation patterns in baku like '1,0 x 10^2' or '1.0 x 10^2'
        if (preg_match('/(maks|maksimum)\s*[:\-\s]*([0-9\.,]+)\s*[x×]\s*10\^?\s*(\-?\d+)/i', $baku_norm, $msci)) {
            $base = (float)str_replace(',', '.', $msci[2]);
            $exp = (int)$msci[3];
            $limit = $base * pow(10, $exp);
            // 'Maks' means <= limit
            if (preg_match('/-?\d+[\d\.]*?/', $hasil_norm, $hm)) {
                $val = (float)$hm[0];
                return ($val <= $limit) ? 'MS' : 'TMS';
            }
        }

        // Handle 'maks' simple form 'Maks 100' or 'Maks. 1,0'
        if (preg_match('/\b(maks|maksimum)\b\s*[:\-\s]*([0-9\.,]+)/i', $baku_norm, $m_maks)) {
            $limit = (float)str_replace(',', '.', $m_maks[2]);
            if (preg_match('/-?\d+[\d\.]*?/', $hasil_norm, $hm)) {
                $val = (float)$hm[0];
                return ($val <= $limit) ? 'MS' : 'TMS';
            }
        }

        // Operators: <=, >=, <, >, =, ≤, ≥
        if (preg_match('/([<>≤≥]=?|=)\s*([0-9\.]+)/u', $baku_norm, $m)) {
            $op = $m[1];
            // normalize operators
            $op = str_replace(['≤','≥'], ['<=','>='], $op);
            $limit = (float)$m[2];
            if (preg_match('/-?\d+[\d\.]*?/', $hasil_norm, $hm)) {
                $val = (float)$hm[0];
                $ok = false;
                switch ($op) {
                    case '<': $ok = ($val < $limit); break;
                    case '<=': $ok = ($val <= $limit); break;
                    case '>': $ok = ($val > $limit); break;
                    case '>=': $ok = ($val >= $limit); break;
                    case '=': $ok = (abs($val - $limit) < 1e-9); break;
                }
                return $ok ? 'MS' : 'TMS';
            }
        }

        // Range like 'x - y' or 'x – y'
        if (preg_match('/([0-9\.]+)\s*[-–]\s*([0-9\.]+)/u', $baku_norm, $m2)) {
            $low = (float)$m2[1];
            $high = (float)$m2[2];
            if (preg_match('/-?\d+[\d\.]*?/', $hasil_norm, $hm2)) {
                $val = (float)$hm2[0];
                return ($val >= $low && $val <= $high) ? 'MS' : 'TMS';
            }
        }

        // Exact zero or '0 cfu/ml' or '0' means result must be zero (or negative/absent)
        if (preg_match('/\b0\b/', $baku_norm) || strpos($baku_norm, 'negatif') !== false) {
            // if hasil contains any positive numeric value or 'positif' -> TMS
            if (preg_match('/\d+/', $hasil_norm, $hm) && (int)$hm[0] > 0) {
                // numeric > 0
            }
            if (preg_match('/\d+/', $hasil_norm, $hm3)) {
                $val = (int)$hm3[0];
                return ($val === 0) ? 'MS' : 'TMS';
            }
            if (strpos($hasil_norm, 'positif') !== false) return 'TMS';
            return 'MS';
        }

        // Textual checks: 'tidak berbau' vs 'berbau'
        if (strpos($baku_norm, 'tidak berbau') !== false || strpos($baku_norm, 'tidak bau') !== false) {
            if (strpos($hasil_norm, 'bau') !== false || strpos($hasil_norm, 'berbau') !== false) return 'TMS';
            return 'MS';
        }

        // Appearance checks: 'bening','jernih' vs 'keruh','berwarna'
        if (strpos($baku_norm, 'bening') !== false || strpos($baku_norm, 'jernih') !== false) {
            if (strpos($hasil_norm, 'keruh') !== false || strpos($hasil_norm, 'berwarna') !== false) return 'TMS';
            return 'MS';
        }

        // Presence checks like 'negatif/25g' or 'negatif' -> if hasil contains digits or 'positif' then TMS
        if (strpos($baku_norm, 'negatif') !== false || strpos($baku_norm, 'tidak ada') !== false) {
            if (strpos($hasil_norm, 'positif') !== false || preg_match('/\d+/', $hasil_norm)) return 'TMS';
            return 'MS';
        }

        // Unable to determine automatically
        return null;
    }

    /**
     * Determine MS/TMS from structured baku fields.
     * $type: 'numeric_limit','numeric_range','text','qualitative', etc.
     */
    private function determine_keterangan_from_structured(?string $type, ?string $operator, $min, $max, ?string $text, $hasil): ?string
    {
        if ($hasil === null || $hasil === '') return null;
        $type = $type ? strtolower(trim($type)) : null;

        // Numeric limit: operator + max
        if ($type === 'numeric_limit' || $type === 'numeric') {
            $limit = is_numeric($max) ? (float)$max : (is_numeric($min) ? (float)$min : null);
            if ($limit !== null) {
                $op = $operator ?: '<=';
                $val = null;
                if (preg_match('/-?\d+[\d\.]*?/', (string)$hasil, $hm)) $val = (float)$hm[0];
                if ($val === null) return null;
                switch ($op) {
                    case '<': return ($val < $limit) ? 'MS' : 'TMS';
                    case '<=': return ($val <= $limit) ? 'MS' : 'TMS';
                    case '>': return ($val > $limit) ? 'MS' : 'TMS';
                    case '>=': return ($val >= $limit) ? 'MS' : 'TMS';
                    case '=': return (abs($val - $limit) < 1e-9) ? 'MS' : 'TMS';
                }
            }
        }

        if ($type === 'numeric_range' && is_numeric($min) && is_numeric($max)) {
            if (preg_match('/-?\d+[\d\.]*?/', (string)$hasil, $hm)) {
                $val = (float)$hm[0];
                return ($val >= (float)$min && $val <= (float)$max) ? 'MS' : 'TMS';
            }
        }

        if ($type === 'text' || $type === 'qualitative') {
            $baku_text = strtolower(trim((string)$text));
            $hasil_norm = strtolower(trim((string)$hasil));
            if (strpos($baku_text, 'tidak berbau') !== false || strpos($baku_text, 'tidak bau') !== false) {
                return (strpos($hasil_norm, 'bau') !== false || strpos($hasil_norm, 'berbau') !== false) ? 'TMS' : 'MS';
            }
            if (strpos($baku_text, 'negatif') !== false) {
                if (strpos($hasil_norm, 'positif') !== false || preg_match('/\d+/', $hasil_norm)) return 'TMS';
                return 'MS';
            }
            // fallback: if texto contains delimiter like 'negatif/25g' treat as negative
            if (preg_match('/negatif/i', $baku_text)) {
                if (preg_match('/\d+/', $hasil_norm) || strpos($hasil_norm, 'positif') !== false) return 'TMS';
                return 'MS';
            }
        }

        // Fallback to textual baku parsing if structured didn't match
        if (!empty($text)) {
            return $this->determine_keterangan_from_baku($text, $hasil);
        }

        return null;
    }

    public function list_permintaan(array $filters = [])
    {
        $this->db->select('kesmas_permintaan.*, COUNT(DISTINCT kesmas_permintaan_item.id) as jumlah_pemeriksaan');
        $this->db->from('kesmas_permintaan');
        $this->db->join('kesmas_permintaan_item', 'kesmas_permintaan_item.permintaan_id = kesmas_permintaan.id', 'left');

        if (!empty($filters['q'])) {
            $q = $filters['q'];
            $this->db->group_start()
                ->like('kesmas_permintaan.no_registrasi', $q)
                ->or_like('kesmas_permintaan.nama_sampel', $q)
                ->or_like('kesmas_permintaan.jenis_sampel', $q)
                ->or_like('kesmas_permintaan.nama_pengirim', $q)
                ->or_like('kesmas_permintaan.instansi', $q)
                ->group_end();
        }
        if (!empty($filters['dari'])) $this->db->where('kesmas_permintaan.tgl_permintaan >=', $filters['dari']);
        if (!empty($filters['sampai'])) $this->db->where('kesmas_permintaan.tgl_permintaan <=', $filters['sampai']);

        if (isset($filters['is_diterima'])) {
            $this->db->where('kesmas_permintaan.is_diterima', (int)$filters['is_diterima']);
        }

        // Exclude rejected samples (is_diterima = 2) if specified
        if (!empty($filters['exclude_ditolak'])) {
            $this->db->where('kesmas_permintaan.is_diterima !=', 2);
        }

        // Optional: only return requests that passed kaji ulang (status_kelayakan = 'Layak')
        if (!empty($filters['only_layak'])) {
            $this->db->where('kesmas_permintaan.status_kelayakan', 'Layak');
        }
        
        // Optional: only return requests that already have input hasil timestamp (kk_input_hasil not null)
        if (!empty($filters['only_with_input_hasil'])) {
            $this->db->where('kesmas_permintaan.kk_input_hasil IS NOT NULL', null, false);
        }

        $this->db->group_by('kesmas_permintaan.id');
        $this->db->order_by('kesmas_permintaan.id','DESC');
        return $this->db->get()->result_array();
    }

    public function get_permintaan(int $id)
    {
        return $this->db->get_where('kesmas_permintaan', array('id' => $id))->row_array();
    }

    public function get_permintaan_by_no_registrasi(string $no_registrasi)
    {
        return $this->db->get_where('kesmas_permintaan', array('no_registrasi' => $no_registrasi))->row_array();
    }

    public function get_master_grouped(string $kategori)
    {
        $this->db->where('kategori', $kategori);
        $this->db->where('is_active', 1);
        $this->db->order_by($this->_get_kelompok_order_case_sql($kategori), 'ASC');
        $this->db->order_by('urutan','ASC');
        $rows = $this->db->get('kesmas_master_pemeriksaan')->result_array();

        $out = array();
        foreach ($rows as $r) {
            $out[$r['kelompok']][] = $r;
        }
        return $out;
    }

    public function get_selected_master_ids(int $permintaan_id): array
    {
        $this->db->select('master_pemeriksaan_id');
        $rows = $this->db->get_where('kesmas_permintaan_item', array('permintaan_id' => $permintaan_id))->result_array();
        return array_map(function($r){ return (int)$r['master_pemeriksaan_id']; }, $rows);
    }

    public function save_permintaan(array $header, array $master_ids, ?int $user_id): int
    {
        $this->db->trans_start();

        $header['created_by'] = $user_id;
        $header['created_at'] = date('Y-m-d H:i:s');

        $this->db->insert('kesmas_permintaan', $header);
        $permintaan_id = (int)$this->db->insert_id();

        foreach ($master_ids as $mid) {
            $this->db->insert('kesmas_permintaan_item', array(
                'permintaan_id' => $permintaan_id,
                'master_pemeriksaan_id' => (int)$mid,
                'created_at' => date('Y-m-d H:i:s'),
            ));
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) return 0;
        return $permintaan_id;
    }

    public function update_permintaan(int $id, array $header, array $master_ids, ?int $user_id): bool
    {
        $this->db->trans_start();

        $header['updated_by'] = $user_id;
        $header['updated_at'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id)->update('kesmas_permintaan', $header);

        // Get current item master IDs from the database
        $current_item_master_ids = $this->get_selected_master_ids($id);

        // Find items to delete (present in DB but not in new master_ids)
        $master_ids_to_delete = array_diff($current_item_master_ids, $master_ids);
        if (!empty($master_ids_to_delete)) {
            $this->db->where('permintaan_id', $id);
            $this->db->where_in('master_pemeriksaan_id', $master_ids_to_delete);
            $this->db->delete('kesmas_permintaan_item');
            // This delete will trigger ON DELETE CASCADE for kesmas_hasil entries,
            // which is correct for master items that are no longer part of the request.
        }

        // Find items to add (present in new master_ids but not in DB)
        $master_ids_to_add = array_diff($master_ids, $current_item_master_ids);
        foreach ($master_ids_to_add as $mid) {
            $this->db->insert('kesmas_permintaan_item', array(
                'permintaan_id' => $id,
                'master_pemeriksaan_id' => (int)$mid,
                'created_at' => date('Y-m-d H:i:s'),
            ));
        }

        $this->db->trans_complete();
        return $this->db->trans_status() !== FALSE;
    }

    public function get_items_with_result(int $permintaan_id): array
    {
        // Get the category from the kesmas_permintaan table
        $permintaan = $this->db->select('jenis_sampel')->get_where('kesmas_permintaan', array('id' => $permintaan_id))->row_array();
        $jenis_sampel_raw = $permintaan['jenis_sampel'] ?? '';
        // Convert to slug format for use with _get_kelompok_order_case_sql
        $kategori = strtolower(str_replace(' ', '_', $jenis_sampel_raw));

        $kelompok_order_sql = $this->_get_kelompok_order_case_sql($kategori, 'm');

        $sql = "SELECT i.id AS permintaan_item_id, m.*
                , h.hasil, h.keterangan, h.tgl_jam_pemeriksaan, h.tgl_jam_selesai, h.tgl_jam_lapor, h.petugas_pengambilan_spesimen_id
                FROM kesmas_permintaan_item i
                JOIN kesmas_master_pemeriksaan m ON m.id = i.master_pemeriksaan_id
                LEFT JOIN kesmas_hasil h ON h.permintaan_item_id = i.id
                WHERE i.permintaan_id = ?
                ORDER BY {$kelompok_order_sql} ASC, m.urutan ASC";
        return $this->db->query($sql, array($permintaan_id))->result_array();
    }

    public function get_permintaan_items_with_master($permintaan_id)
    {
        // Get the category from the kesmas_permintaan table
        $permintaan = $this->db->select('jenis_sampel')->get_where('kesmas_permintaan', array('id' => $permintaan_id))->row_array();
        $jenis_sampel_raw = $permintaan['jenis_sampel'] ?? '';
        // Convert to slug format for use with _get_kelompok_order_case_sql
        $kategori = strtolower(str_replace(' ', '_', $jenis_sampel_raw));

        $kelompok_order_sql = $this->_get_kelompok_order_case_sql($kategori, 'm');

        $sql = "SELECT 
                    i.id AS permintaan_item_id,
                    m.nama_pemeriksaan,
                    m.kelompok,
                    m.satuan,
                    m.baku_mutu,
                    m.metode,
                    m.urutan
                FROM kesmas_permintaan_item i
                JOIN kesmas_master_pemeriksaan m ON m.id = i.master_pemeriksaan_id
                WHERE i.permintaan_id = ?
                ORDER BY {$kelompok_order_sql} ASC, m.urutan ASC";
        return $this->db->query($sql, array($permintaan_id))->result_array();
    }

    public function get_hasil_by_permintaan($permintaan_id)
    {
        $this->db->select('permintaan_item_id, hasil, keterangan, tgl_jam_pemeriksaan, tgl_jam_selesai, tgl_jam_lapor, petugas_pengambilan_spesimen_id');
        $this->db->where('permintaan_id', $permintaan_id);
        return $this->db->get('kesmas_hasil')->result_array();
    }

    /**
     * Set TMS status per permintaan_item_id.
     * Status expected values: 'MS' or 'TMS' (string).
     */
    public function set_hasil_tms_status(int $permintaan_item_id, string $status, ?int $user_id = null): bool
    {
        $status = strtoupper(trim($status));
        if ($status !== 'MS' && $status !== 'TMS') return false;

        // Fetch existing hasil row (to get permintaan_id)
        $exists = $this->db->get_where('kesmas_hasil', array('permintaan_item_id' => $permintaan_item_id))->row_array();
        $now = date('Y-m-d H:i:s');
        if ($exists) {
            $update = array(
                'keterangan' => $status,
                'input_by' => $user_id,
                'input_at' => $now,
            );
            // If there is no pemeriksaan timestamp, set it to now so monthly reports include this status change
            if (empty($exists['tgl_jam_pemeriksaan'])) {
                $update['tgl_jam_pemeriksaan'] = $now;
            }
            $this->db->where('permintaan_item_id', $permintaan_item_id)->update('kesmas_hasil', $update);
            return $this->db->affected_rows() >= 0;
        }

        // If no existing hasil row, try to find permintaan_id from permintaan_item
        $item = $this->db->get_where('kesmas_permintaan_item', array('id' => $permintaan_item_id))->row_array();
        if (!$item) return false;
        $permintaan_id = (int)($item['permintaan_id'] ?? 0);

        $insert = array(
            'permintaan_id' => $permintaan_id,
            'permintaan_item_id' => $permintaan_item_id,
            'hasil' => null,
            'keterangan' => $status,
            'tgl_jam_pemeriksaan' => $now, // record pemeriksaan time when status created via set_status
            'tgl_jam_selesai' => null,
            'tgl_jam_lapor' => null,
            'petugas_pengambilan_spesimen_id' => null,
            'input_by' => $user_id,
            'input_at' => $now,
        );
        $this->db->insert('kesmas_hasil', $insert);
        return $this->db->affected_rows() > 0;
    }

    public function list_petugas(): array
    {
        $this->db->where('is_active', 1)->order_by('nama','ASC');
        return $this->db->get('kesmas_petugas_sampel')->result_array();
    }

    public function save_hasil(int $permintaan_id, array $hasil_items, array $keterangan_items, array $payload_permintaan, ?int $user_id): bool
    {
        $this->db->trans_start();

        // Extract values for kesmas_hasil updates from payload_permintaan
        $petugas_id = isset($payload_permintaan['petugas_pengambilan_spesimen_id']) && $payload_permintaan['petugas_pengambilan_spesimen_id'] !== ''
            ? (int)$payload_permintaan['petugas_pengambilan_spesimen_id'] : null;

        $tgl_pemeriksaan = $payload_permintaan['tgl_jam_pemeriksaan'] ?? null;
        $tgl_selesai = $payload_permintaan['tgl_jam_selesai'] ?? null;
        $tgl_lapor = $payload_permintaan['tgl_jam_lapor'] ?? null;

        // Process items with hasil values
        foreach ($hasil_items as $permintaan_item_id => $hasil_value) {
            // Tarik data yang ada di DB untuk mencegah penimpaan (stale form)
            $exists = $this->db->get_where('kesmas_hasil', array('permintaan_item_id' => (int)$permintaan_item_id))->row_array();

            // Attempt to auto-determine keterangan (MS/TMS) if not provided
            $provided_ket = $keterangan_items[$permintaan_item_id] ?? null;
            $auto_ket = null;
            if (empty($provided_ket) && $hasil_value !== '' && $hasil_value !== null) {
                // fetch master baku_mutu for this permintaan_item
                $item_row = $this->db->select('master_pemeriksaan_id')->get_where('kesmas_permintaan_item', ['id' => (int)$permintaan_item_id])->row_array();
                if (!empty($item_row['master_pemeriksaan_id'])) {
                    $master_row = $this->db->select('baku_type,baku_operator,baku_min,baku_max,baku_text,baku_mutu')->get_where('kesmas_master_pemeriksaan', ['id' => (int)$item_row['master_pemeriksaan_id']])->row_array();
                    if (!empty($master_row['baku_type'])) {
                        $auto_ket = $this->determine_keterangan_from_structured(
                            $master_row['baku_type'] ?? null,
                            $master_row['baku_operator'] ?? null,
                            $master_row['baku_min'] ?? null,
                            $master_row['baku_max'] ?? null,
                            $master_row['baku_text'] ?? null,
                            $hasil_value
                        );
                    } else {
                        $baku = $master_row['baku_mutu'] ?? null;
                        if (!empty($baku)) {
                            $auto_ket = $this->determine_keterangan_from_baku($baku, $hasil_value);
                        }
                    }
                }
            }

            // Amankan keterangan & tanggal. Jika isian form kosong, pertahankan nilai di DB (jika ada)
            $final_ket = $provided_ket ?: $auto_ket ?: ($exists['keterangan'] ?? null);

            $row = array(
                'permintaan_id' => $permintaan_id,
                'permintaan_item_id' => (int)$permintaan_item_id,
                'hasil' => ($hasil_value === '' ? null : $hasil_value),
                'keterangan' => $final_ket,
                'tgl_jam_pemeriksaan' => $tgl_pemeriksaan ?: ($exists['tgl_jam_pemeriksaan'] ?? null),
                'tgl_jam_selesai' => $tgl_selesai ?: ($exists['tgl_jam_selesai'] ?? null),
                'tgl_jam_lapor' => $tgl_lapor ?: ($exists['tgl_jam_lapor'] ?? null),
                'petugas_pengambilan_spesimen_id' => $petugas_id ?: ($exists['petugas_pengambilan_spesimen_id'] ?? null),
                'input_by' => $user_id,
                'input_at' => date('Y-m-d H:i:s'),
            );

            // upsert by permintaan_item_id (unique)
            if ($exists) {
                $this->db->where('permintaan_item_id', (int)$permintaan_item_id)->update('kesmas_hasil', $row);
            } else {
                $this->db->insert('kesmas_hasil', $row);
            }
        }

        // Even if no hasil items were submitted, ensure petugas and dates are saved for all items
        // This handles the case where user only wants to set these fields without entering results yet
        if (($petugas_id || $tgl_pemeriksaan || $tgl_selesai || $tgl_lapor) && empty($hasil_items)) {
            $all_items = $this->db->select('id')->get_where('kesmas_permintaan_item', ['permintaan_id' => $permintaan_id])->result_array();
            foreach ($all_items as $item) {
                $permintaan_item_id = (int)$item['id'];
                $exists = $this->db->get_where('kesmas_hasil', array('permintaan_item_id' => $permintaan_item_id))->row_array();

                $row = array(
                    'permintaan_id' => $permintaan_id,
                    'permintaan_item_id' => $permintaan_item_id,
                    'hasil' => null,
                    'keterangan' => $exists['keterangan'] ?? null,
                    'tgl_jam_pemeriksaan' => $tgl_pemeriksaan ?: ($exists['tgl_jam_pemeriksaan'] ?? null),
                    'tgl_jam_selesai' => $tgl_selesai ?: ($exists['tgl_jam_selesai'] ?? null),
                    'tgl_jam_lapor' => $tgl_lapor ?: ($exists['tgl_jam_lapor'] ?? null),
                    'petugas_pengambilan_spesimen_id' => $petugas_id ?: ($exists['petugas_pengambilan_spesimen_id'] ?? null),
                    'input_by' => $user_id,
                    'input_at' => date('Y-m-d H:i:s'),
                );

                if ($exists) {
                    $this->db->where('permintaan_item_id', $permintaan_item_id)->update('kesmas_hasil', $row);
                } else {
                    $this->db->insert('kesmas_hasil', $row);
                }
            }
        }

        // Build the data payload for the kesmas_permintaan table update.
        // This should only include fields that are meant to be updated at this stage.
        $update_permintaan_data = [
            'kk_input_hasil' => date('Y-m-d H:i:s'),
        ];

        // Only add fields to the update array if they are present in the payload from the controller.
        // This prevents accidentally nullifying existing data.
        if (array_key_exists('info_tambahan', $payload_permintaan)) {
            $update_permintaan_data['info_tambahan'] = $payload_permintaan['info_tambahan'] ?? null;
        }

        // The status_kelayakan and alasan_tidak_layak fields are intentionally NOT updated here.
        // They are set during the kaji_ulang step.

        $this->db->where('id', $permintaan_id)->update('kesmas_permintaan', $update_permintaan_data);

        $this->db->trans_complete();
        return $this->db->trans_status() !== FALSE;
    }

    /**
     * Generates a SQL CASE statement string for ordering 'kelompok' based on 'kategori'.
     *
     * @param string $kategori The category of the examination.
     * @param string $table_alias Optional alias for the 'kelompok' column, e.g., 'm'.
     * @return string The SQL CASE statement.
     */
    private function _get_kelompok_order_case_sql(string $kategori, string $table_alias = ''): string
    {
        $col = empty($table_alias) ? 'kelompok' : $table_alias . '.kelompok';
        $case_sql = "CASE {$col} ";

        switch ($kategori) {
            case 'air_minum':
                $case_sql .= "WHEN 'Fisika' THEN 1 ";
                $case_sql .= "WHEN 'Kimia Wajib' THEN 2 ";
                $case_sql .= "WHEN 'Kimia Khusus' THEN 3 ";
                $case_sql .= "WHEN 'Bakteriologi' THEN 4 ";
                break;
            case 'air_bersih':
                $case_sql .= "WHEN 'Fisika' THEN 1 ";
                $case_sql .= "WHEN 'Kimia' THEN 2 ";
                $case_sql .= "WHEN 'Bakteriologi' THEN 3 ";
                break;
            case 'makanan':
                $case_sql .= "WHEN 'Kimia' THEN 1 ";
                $case_sql .= "WHEN 'Bakteriologi' THEN 2 ";
                $case_sql .= "WHEN 'Parasitologi' THEN 3 ";
                break;
            case 'lingkungan':
                // For 'lingkungan', all groups have the same precedence, 'urutan' will handle the internal order.
                // So, assign a single order value to all groups within this category.
                $case_sql .= "WHEN 'Fisika' THEN 1 "; // Example groups for lingkungan, if specific ones exist and need to be ordered before 99
                $case_sql .= "WHEN 'Kimia' THEN 1 ";
                $case_sql .= "WHEN 'Bakteriologi' THEN 1 ";
                $case_sql .= "WHEN 'Pemeriksaan' THEN 1 "; // Assuming 'Pemeriksaan' is a common group for lingkungan
                // Add other potential 'lingkungan' groups here if known and needed.
                break;
            default:
                // Fallback for unknown categories or groups not explicitly listed
                break;
        }

        $case_sql .= "ELSE 99 END"; // Default for unlisted groups/categories
        return $case_sql;
    }
    public function terima_sampel(int $id, ?int $user_id): bool
    {
        $this->db->where('id', $id);
        return $this->db->update('kesmas_permintaan', array(
            'is_diterima' => 1,
            'updated_by' => $user_id,
            'updated_at' => date('Y-m-d H:i:s')
        ));
    }

    public function tolak_sampel(int $id, ?int $user_id): bool
    {
        // Requirement: if sample is rejected, it must not remain in the database as a pending/active record.
        // Approach: delete the whole request and its related hasil/items.
        // This prevents rejected samples from being included in subsequent input_hasil flows.
        return $this->delete_permintaan((int)$id);
    }


    public function delete_permintaan(int $permintaan_id): bool
    {
        $this->db->trans_start();

        // Delete related records from kesmas_hasil first
        $this->db->delete('kesmas_hasil', array('permintaan_id' => $permintaan_id));

        // Delete related records from kesmas_permintaan_item
        $this->db->delete('kesmas_permintaan_item', array('permintaan_id' => $permintaan_id));

        // Finally, delete the main record from kesmas_permintaan
        $this->db->delete('kesmas_permintaan', array('id' => $permintaan_id));

        $this->db->trans_complete();
        $ok = $this->db->trans_status() !== FALSE;

        if (!$ok) {
            $db_error = $this->db->error();
            log_message('error', 'delete_permintaan failed. permintaan_id='.(int)$permintaan_id.' error='.json_encode($db_error));
        } else {
            log_message('debug', 'delete_permintaan success. permintaan_id='.(int)$permintaan_id);
        }

        return $ok;
    }


    public function add_petugas($data)
    {
        return $this->db->insert('kesmas_petugas_sampel', $data);
    }

    public function get_petugas_by_id(int $id)
    {
        return $this->db->get_where('kesmas_petugas_sampel', array('id' => $id))->row_array();
    }

    public function update_petugas(int $id, array $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('kesmas_petugas_sampel', $data);
    }

    public function delete_petugas(int $id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('kesmas_petugas_sampel');
    }

    public function get_petugas_name_by_id(int $petugas_id): ?string
    {
        $result = $this->db->select('nama')->get_where('kesmas_petugas_sampel', ['id' => $petugas_id])->row_array();
        return $result['nama'] ?? null;
    }

    public function update_kaji_ulang(int $id, array $kaji_ulang_data): bool
    {
        // Konversi alasan_tidak_layak array menjadi JSON
        if (array_key_exists('alasan_tidak_layak', $kaji_ulang_data)) {
            $alasan_array = is_array($kaji_ulang_data['alasan_tidak_layak']) 
                ? $kaji_ulang_data['alasan_tidak_layak'] 
                : array();
            $kaji_ulang_data['alasan_tidak_layak'] = !empty($alasan_array) ? json_encode($alasan_array) : null;
        }

        // Convert datetime-local format ke database format
        if (isset($kaji_ulang_data['kk_pengambilan']) && !empty($kaji_ulang_data['kk_pengambilan'])) {
            $kaji_ulang_data['kk_pengambilan'] = str_replace('T', ' ', $kaji_ulang_data['kk_pengambilan']);
        }
        if (isset($kaji_ulang_data['kk_sampel_diterima_lab']) && !empty($kaji_ulang_data['kk_sampel_diterima_lab'])) {
            $kaji_ulang_data['kk_sampel_diterima_lab'] = str_replace('T', ' ', $kaji_ulang_data['kk_sampel_diterima_lab']);
        }
        if (isset($kaji_ulang_data['kk_pengerjaan_sampel']) && !empty($kaji_ulang_data['kk_pengerjaan_sampel'])) {
            $kaji_ulang_data['kk_pengerjaan_sampel'] = str_replace('T', ' ', $kaji_ulang_data['kk_pengerjaan_sampel']);
        }
        if (isset($kaji_ulang_data['kk_input_hasil']) && !empty($kaji_ulang_data['kk_input_hasil'])) {
            $kaji_ulang_data['kk_input_hasil'] = str_replace('T', ' ', $kaji_ulang_data['kk_input_hasil']);
        }
        if (isset($kaji_ulang_data['kk_cetak_hasil']) && !empty($kaji_ulang_data['kk_cetak_hasil'])) {
            $kaji_ulang_data['kk_cetak_hasil'] = str_replace('T', ' ', $kaji_ulang_data['kk_cetak_hasil']);
        }

        // Add timestamp
        $kaji_ulang_data['updated_at'] = date('Y-m-d H:i:s');

        // Update database
        $this->db->where('id', $id);
        return $this->db->update('kesmas_permintaan', $kaji_ulang_data);
    }
}
