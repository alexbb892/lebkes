<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_permintaan_kesmas extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kesmas_model');
        $this->load->model('Tindakan_sampel_model');
    }

    public function index()
    {
        $filters = array(
            'q' => $this->input->get('q', true),
            'dari' => $this->input->get('dari', true),
            'sampai' => $this->input->get('sampai', true),
            'is_diterima' => 1,
        );

        

        $data = array(
            'title' => 'Pendaftaran Kesmas',
            'rows' => $this->Kesmas_model->list_permintaan($filters),
            'filters' => $filters,
        );
        $this->render('kesmas/permintaan_list', $data);
    }

    public function create()
    {
        // Initialize empty permintaan array with default values for form fields
        $empty_permintaan = array(
            'id' => '',
            'no_registrasi' => '',
            'nama_sampel' => '',
            'kategori_sample' => '',
            'jenis_sampel' => '',
            'volume_ml' => '',
            'tgl_pengambilan' => '',
            'jam_pengambilan' => '',
            'lokasi_pengambilan' => '',
            'petugas_pengambil_id' => '',
            'info_tambahan' => '',
            'tindakan_sampel' => '',
            'nama_pengirim' => '',
            'alamat_pengirim' => '',
            'telp_pengirim' => '',
            'instansi' => '',
            'tgl_permintaan' => '',
            'ttd_pengirim' => '',
            'jumlah_biaya' => 0,
            'cara_bayar' => '',
            'cara_bayar_lainnya' => '',
            'catatan' => '',
        );

        $data = array(
            'title' => 'Tambah Permintaan',
            'mode' => 'create',
            'no_registrasi' => '',
            'permintaan' => $empty_permintaan,
            'selected_ids' => array(),
            'petugas' => $this->Kesmas_model->list_petugas(),
            'tindakan_sampel' => $this->Tindakan_sampel_model->list_tindakan_sampel(),
        );

        // default tampilkan master untuk 4 kategori di tab
        $data['master_air_minum'] = $this->Kesmas_model->get_master_grouped('air_minum');
        $data['master_air_bersih'] = $this->Kesmas_model->get_master_grouped('air_bersih');
        $data['master_makanan'] = $this->Kesmas_model->get_master_grouped('makanan');
        $data['master_lingkungan'] = $this->Kesmas_model->get_master_grouped('lingkungan');

        $this->render('kesmas/permintaan_form', $data);
    }

    public function store()
    {
        try {
            $this->form_validation->set_rules('no_registrasi', 'Nomor Registrasi', 'trim');
            $this->form_validation->set_rules('nama_sampel', 'Nama Sampel', 'required|trim');
            $this->form_validation->set_rules('kategori_sample', 'Kategori Sample', 'required');
            $this->form_validation->set_rules('jenis_sampel', 'Jenis Sampel', 'required');
            if (!$this->form_validation->run()) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('kesmas/form_permintaan_kesmas/create');
            }

            $header = $this->_collect_header(true);
            $master_ids = $this->input->post('pemeriksaan', true);
            if (!is_array($master_ids) || empty($master_ids)) {
                $this->session->set_flashdata('error', 'Minimal satu jenis pemeriksaan harus dipilih.');
                redirect('kesmas/form_permintaan_kesmas/create');
                return;
            }

            log_message('debug', 'Header: ' . json_encode($header));
            log_message('debug', 'Master IDs: ' . json_encode($master_ids));
            log_message('debug', 'User ID: ' . $this->session->userdata('user_id'));

            $permintaan_id = $this->Kesmas_model->save_permintaan($header, $master_ids, $this->session->userdata('user_id'));
            if (!$permintaan_id) {
                log_message('error', 'Failed to save permintaan. DB Error: ' . $this->db->error()['message']);
                $this->session->set_flashdata('error', 'Gagal simpan data. Pastikan isian valid.');
                redirect('kesmas/form_permintaan_kesmas/create');
                return;
            }

            $this->session->set_flashdata('success', 'Berhasil simpan.');
            // After creating a new permintaan, go directly to kaji ulang for review
            redirect('kesmas/form_permintaan_kesmas/kaji_ulang/'.$permintaan_id);
        } catch (Exception $e) {
            log_message('error', 'Error in store: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
            redirect('kesmas/form_permintaan_kesmas/create');
        }
    }

    public function edit($id)
    {
        $id = (int)$id;
        $permintaan = $this->Kesmas_model->get_permintaan($id);
        if (!$permintaan) show_404();

        $data = array(
            'title' => 'Edit Permintaan',
            'mode' => 'edit',
            'no_registrasi' => $permintaan['no_registrasi'],
            'permintaan' => $permintaan,
            'selected_ids' => $this->Kesmas_model->get_selected_master_ids($id),
            'petugas' => $this->Kesmas_model->list_petugas(),
            'tindakan_sampel' => $this->Tindakan_sampel_model->list_tindakan_sampel(),
        );

        $data['master_air_minum'] = $this->Kesmas_model->get_master_grouped('air_minum');
        $data['master_air_bersih'] = $this->Kesmas_model->get_master_grouped('air_bersih');
        $data['master_makanan'] = $this->Kesmas_model->get_master_grouped('makanan');
        $data['master_lingkungan'] = $this->Kesmas_model->get_master_grouped('lingkungan');

        $this->render('kesmas/permintaan_form', $data);
    }

    public function update($id)
    {
        $id = (int)$id;
        $permintaan = $this->Kesmas_model->get_permintaan($id);
        if (!$permintaan) show_404();

        $this->form_validation->set_rules('no_registrasi', 'Nomor Registrasi', 'trim');
        $this->form_validation->set_rules('nama_sampel', 'Nama Sampel', 'required|trim');
        $this->form_validation->set_rules('kategori_sample', 'Kategori Sample', 'required');
        $this->form_validation->set_rules('jenis_sampel', 'Jenis Sampel', 'required');
        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('kesmas/form_permintaan_kesmas/edit/'.$id);
        }

        $header = $this->_collect_header(true);
        $master_ids = $this->input->post('pemeriksaan', true);
        if (!is_array($master_ids) || empty($master_ids)) {
            $this->session->set_flashdata('error', 'Minimal satu jenis pemeriksaan harus dipilih.');
            redirect('kesmas/form_permintaan_kesmas/edit/'.$id);
            return;
        }

        $ok = $this->Kesmas_model->update_permintaan($id, $header, $master_ids, $this->session->userdata('user_id'));
        if (!$ok) {
            $this->session->set_flashdata('error', 'Gagal update data.');
            redirect('kesmas/form_permintaan_kesmas/edit/'.$id);
        }

        // Pembayaran module removed: no recalculation performed here

        $this->session->set_flashdata('success', 'Berhasil update.');
        redirect('kesmas/form_permintaan_kesmas/detail/'.$id);
    }

    public function detail($id)
    {
        $id = (int)$id;
        $permintaan = $this->Kesmas_model->get_permintaan($id);
        if (!$permintaan) show_404();

        // Resolve petugas names from IDs
        if (!empty($permintaan['petugas_pengambil_id'])) {
            $permintaan['petugas_pengambil'] = $this->Kesmas_model->get_petugas_name_by_id($permintaan['petugas_pengambil_id']) ?: '-';
        } else if (empty($permintaan['petugas_pengambil'])) {
            $permintaan['petugas_pengambil'] = '-';
        }

        // Resolve petugas kaji ulang names
        if (!empty($permintaan['petugas_pendaftaran_id'])) {
            $permintaan['petugas_pendaftaran_name'] = $this->Kesmas_model->get_petugas_name_by_id($permintaan['petugas_pendaftaran_id']) ?: '-';
        } else {
            $permintaan['petugas_pendaftaran_name'] = '-';
        }

        if (!empty($permintaan['petugas_pengambil_id'])) {
            $permintaan['petugas_pengambil_ttd_name'] = $this->Kesmas_model->get_petugas_name_by_id($permintaan['petugas_pengambil_id']) ?: '-';
        } else {
            $permintaan['petugas_pengambil_ttd_name'] = '-';
        }

        if (!empty($permintaan['petugas_verifikasi_id'])) {
            $permintaan['petugas_verifikasi_name'] = $this->Kesmas_model->get_petugas_name_by_id($permintaan['petugas_verifikasi_id']) ?: '-';
        } else {
            $permintaan['petugas_verifikasi_name'] = '-';
        }

        if (!empty($permintaan['petugas_validasi_id'])) {
            $permintaan['petugas_validasi_name'] = $this->Kesmas_model->get_petugas_name_by_id($permintaan['petugas_validasi_id']) ?: '-';
        } else {
            $permintaan['petugas_validasi_name'] = '-';
        }

        $permintaan['alasan_tidak_layak'] = json_decode($permintaan['alasan_tidak_layak'] ?? '[]', true);

        $items = $this->Kesmas_model->get_items_with_result($id);

        $data = array(
            'title' => 'Detail Pendaftaran',
            'pendaftaran' => (object)$permintaan,
            'pemeriksaan' => json_decode(json_encode($items)),
        );
        $this->render('kesmas/permintaan_detail', $data);
    }

    public function print($id)
    {
        $id = (int)$id;
        $permintaan = $this->Kesmas_model->get_permintaan($id);
        if (!$permintaan) {
            show_404();
        }

        // Resolve petugas names from IDs
        if (!empty($permintaan['petugas_pengambil_id'])) {
            $permintaan['petugas_pengambil'] = $this->Kesmas_model->get_petugas_name_by_id($permintaan['petugas_pengambil_id']) ?: '-';
        } else if (empty($permintaan['petugas_pengambil'])) {
            $permintaan['petugas_pengambil'] = '-';
        }

        // Resolve petugas kaji ulang names
        if (!empty($permintaan['petugas_pendaftaran_id'])) {
            $permintaan['petugas_pendaftaran_name'] = $this->Kesmas_model->get_petugas_name_by_id($permintaan['petugas_pendaftaran_id']) ?: '-';
        } else {
            $permintaan['petugas_pendaftaran_name'] = '-';
        }

        if (!empty($permintaan['petugas_pengambil_ttd_id'])) {
            $permintaan['petugas_pengambil_ttd_name'] = $this->Kesmas_model->get_petugas_name_by_id($permintaan['petugas_pengambil_ttd_id']) ?: '-';
        } else {
            $permintaan['petugas_pengambil_ttd_name'] = '-';
        }

        if (!empty($permintaan['petugas_verifikasi_id'])) {
            $permintaan['petugas_verifikasi_name'] = $this->Kesmas_model->get_petugas_name_by_id($permintaan['petugas_verifikasi_id']) ?: '-';
        } else {
            $permintaan['petugas_verifikasi_name'] = '-';
        }

        if (!empty($permintaan['petugas_validasi_id'])) {
            $permintaan['petugas_validasi_name'] = $this->Kesmas_model->get_petugas_name_by_id($permintaan['petugas_validasi_id']) ?: '-';
        } else {
            $permintaan['petugas_validasi_name'] = '-';
        }

        $permintaan['alasan_tidak_layak'] = json_decode($permintaan['alasan_tidak_layak'] ?? '[]', true);

        $items = $this->Kesmas_model->get_items_with_result($id);

        $data = array(
            'title' => 'Cetak Pendaftaran',
            'pendaftaran' => (object)$permintaan,
            'pemeriksaan' => json_decode(json_encode($items)),
        );

        $this->load->view('kesmas/print_pendaftaran', $data);
    }

    /* ============= INPUT HASIL ============= */

    public function uji_index()
    {
        $filters = array(
            'q' => $this->input->get('q', true),
            'dari' => $this->input->get('dari', true),
            'sampai' => $this->input->get('sampai', true),
            'is_diterima' => 1,
        );

        // By default show only permintaan that have been reviewed and marked 'Layak'.
        // If the user requests to show all (GET show_all=1), do not apply the 'only_layak' filter.
        $show_all = $this->input->get('show_all', true);
        if (empty($show_all) || $show_all !== '1') {
            $filters['only_layak'] = true;
        }

        $data = array(
            'title' => 'Input Hasil Uji',
            'rows' => $this->Kesmas_model->list_permintaan($filters),
            'filters' => $filters,
        );
        $this->render('kesmas/uji_list', $data);
    }

    public function input_hasil($permintaan_id)
    {
        $permintaan_id = (int)$permintaan_id;
        $permintaan = $this->Kesmas_model->get_permintaan($permintaan_id);
        if (!$permintaan) show_404();

        // Prepare $kaji_ulang data
        $kaji_ulang = [
            'status_kelayakan' => $permintaan['status_kelayakan'] ?? '',
            'alasan_tidak_layak' => json_decode($permintaan['alasan_tidak_layak'] ?? '[]', true),
            'jumlah_biaya' => $permintaan['jumlah_biaya'] ?? '',
            'cara_bayar' => $permintaan['cara_bayar'] ?? '',
            'cara_bayar_lainnya' => $permintaan['cara_bayar_lainnya'] ?? '',
            
            'petugas_pendaftaran_id' => $permintaan['petugas_pendaftaran_id'] ?? '',
            'petugas_pengambil_ttd_id' => $permintaan['petugas_pengambil_ttd_id'] ?? '',
            'petugas_verifikasi_id' => $permintaan['petugas_verifikasi_id'] ?? '',
            'petugas_validasi_id' => $permintaan['petugas_validasi_id'] ?? '',
        ];

        // Prepare $kartu_kendali data
        // For now, these are direct fields in $permintaan, or will be added there
        $kartu_kendali = [
            'pengambilan_sampel_tgl_jam' => $permintaan['pengambilan_sampel_tgl_jam'] ?? '',
            'pengambilan_sampel_paraf' => $permintaan['pengambilan_sampel_paraf'] ?? ($this->session->userdata('user_name') ?? ''),
            'sampel_diterima_lab_tgl_jam' => $permintaan['sampel_diterima_lab_tgl_jam'] ?? '',
            'sampel_diterima_lab_paraf' => $permintaan['sampel_diterima_lab_paraf'] ?? ($this->session->userdata('user_name') ?? ''),
            'pengerjaan_sampel_tgl_jam' => $permintaan['pengerjaan_sampel_tgl_jam'] ?? '',
            'pengerjaan_sampel_paraf' => $permintaan['pengerjaan_sampel_paraf'] ?? ($this->session->userdata('user_name') ?? ''),
            'input_hasil_pemeriksaan_tgl_jam' => $permintaan['input_hasil_pemeriksaan_tgl_jam'] ?? '',
            'input_hasil_pemeriksaan_paraf' => $permintaan['input_hasil_pemeriksaan_paraf'] ?? ($this->session->userdata('user_name') ?? ''),
            'cetak_lembar_hasil_uji_tgl_jam' => $permintaan['cetak_lembar_hasil_uji_tgl_jam'] ?? '',
            'cetak_lembar_hasil_uji_paraf' => $permintaan['cetak_lembar_hasil_uji_paraf'] ?? ($this->session->userdata('user_name') ?? ''),
        ];

        $data = array(
            'title' => 'Input Hasil',
            'permintaan' => $permintaan,
            'items' => $this->Kesmas_model->get_items_with_result($permintaan_id),
            'petugas' => $this->Kesmas_model->list_petugas(),
            'kaji_ulang' => $kaji_ulang, // Pass kaji_ulang data
            'kartu_kendali' => $kartu_kendali, // Pass kartu_kendali data
            'current_user_name' => $this->session->userdata('user_name') ?? '', // For potential JS auto-fill or display
        );
        $this->render('kesmas/input_hasil', $data);
    }

    public function simpan_hasil($permintaan_id)
    {
        try {
            $permintaan_id = (int)$permintaan_id;
            $permintaan = $this->Kesmas_model->get_permintaan($permintaan_id);
            if (!$permintaan) show_404();

            // Collect item results. Disable XSS (false) pada hasil agar simbol "<" / ">" tidak dihapus paksa oleh CodeIgniter
            $hasil_items = $this->input->post('hasil', false) ?: [];
            $keterangan_items = $this->input->post('keterangan', true) ?: [];

            // The 'status_kelayakan' and 'alasan_tidak_layak' are no longer submitted from this form.
            // They are set during the "kaji ulang" step and should not be modified here.
            
            $tjp = $this->input->post('tgl_jam_pemeriksaan', true);
            $tjs = $this->input->post('tgl_jam_selesai', true);
            $tjl = $this->input->post('tgl_jam_lapor', true);
            $petugas_id = $this->input->post('petugas_pengambilan_spesimen_id', true);

            $payload_permintaan = array(
                'petugas_pengambilan_spesimen_id' => empty($petugas_id) ? null : $petugas_id,
                'tgl_jam_pemeriksaan' => $tjp ? str_replace('T', ' ', $tjp) : null,
                'tgl_jam_selesai' => $tjs ? str_replace('T', ' ', $tjs) : null,
                'tgl_jam_lapor' => $tjl ? str_replace('T', ' ', $tjl) : null,
            );

            $ok = $this->Kesmas_model->save_hasil(
                $permintaan_id,
                $hasil_items,
                $keterangan_items,
                $payload_permintaan, // Pass new payload for permintaan table
                $this->session->userdata('user_id')
            );

            if (!$ok) {
                $this->session->set_flashdata('error', 'Gagal simpan hasil.');
            } else {
                $this->session->set_flashdata('success', 'Hasil tersimpan.');
            }
            redirect('kesmas/uji/input/'.$permintaan_id);
        } catch (Exception $e) {
            log_message('error', 'Error in simpan_hasil: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
            redirect('kesmas/uji/input/'.$permintaan_id);
        }
    }

    public function delete($id)
    {
        // Only allow POST requests for deletion (good practice for security)
        if ($this->input->method() !== 'post') {
            show_404();
        }

        $id = (int)$id;
        $permintaan = $this->Kesmas_model->get_permintaan($id);
        if (!$permintaan) {
            $this->session->set_flashdata('error', 'Permintaan tidak ditemukan.');
            redirect('kesmas/form_permintaan_kesmas');
        }

        $ok = $this->Kesmas_model->delete_permintaan($id);
        if (!$ok) {
            $this->session->set_flashdata('error', 'Gagal menghapus permintaan.');
        } else {
            $this->session->set_flashdata('success', 'Permintaan berhasil dihapus.');
        }

        redirect('kesmas/form_permintaan_kesmas'); // Redirect back to the list
    }

    /* ============= KAJI ULANG PERMINTAAN PEMERIKSAAN ============= */

    public function kaji_ulang($id)
    {
        $id = (int)$id;
        $permintaan = $this->Kesmas_model->get_permintaan($id);
        if (!$permintaan) {
            show_404();
        }

        // Resolve petugas name from ID
        if (!empty($permintaan['petugas_pengambil_id'])) {
            $permintaan['petugas_pengambil_name'] = $this->Kesmas_model->get_petugas_name_by_id($permintaan['petugas_pengambil_id']) ?: '-';
        } else {
            $permintaan['petugas_pengambil_name'] = '-';
        }

        $data = array(
            'title' => 'Kaji Ulang Permintaan Pemeriksaan',
            'permintaan' => $permintaan,
            'petugas' => $this->Kesmas_model->list_petugas(),
        );
        $this->render('kesmas/kaji_ulang_form', $data);
    }

    public function kaji_ulang_update($id)
    {
        if ($this->input->method() !== 'post') {
            show_404();
        }

        $id = (int)$id;
        $permintaan = $this->Kesmas_model->get_permintaan($id);
        if (!$permintaan) {
            $this->session->set_flashdata('error', 'Permintaan tidak ditemukan.');
            redirect('kesmas/form_permintaan_kesmas');
        }

        // Handle nullable dates securely to prevent PHP 8 TypeErrors
        $kk_peng = $this->input->post('kk_pengambilan', true);
        $kk_terima = $this->input->post('kk_sampel_diterima_lab', true);
        $kk_kerja = $this->input->post('kk_pengerjaan_sampel', true);
        $kk_input = $this->input->post('kk_input_hasil', true);
        $kk_cetak = $this->input->post('kk_cetak_hasil', true);

        // Kumpulkan data kaji ulang
        $kaji_ulang_data = array(
            'status_kelayakan' => $this->input->post('status_kelayakan', true),
            'alasan_tidak_layak' => $this->input->post('alasan_tidak_layak', true),
            'tgl_pengambilan' => $this->input->post('tgl_pengambilan', true) ?: null,
            'jam_pengambilan' => $this->input->post('jam_pengambilan', true) ?: null,
            'jumlah_biaya' => $this->input->post('jumlah_biaya', true) ?: 0,
            'cara_bayar' => $this->input->post('cara_bayar', true),
            'cara_bayar_lainnya' => $this->input->post('cara_bayar_lainnya', true),
            'petugas_pendaftaran_id' => $this->input->post('petugas_pendaftaran_id', true) ?: null,
            'petugas_pengambil_ttd_id' => $this->input->post('petugas_pengambil_ttd_id', true) ?: null,
            'petugas_verifikasi_id' => $this->input->post('petugas_verifikasi_id', true) ?: null,
            'petugas_validasi_id' => $this->input->post('petugas_validasi_id', true) ?: null,
            'kk_pengambilan' => !empty($kk_peng) ? str_replace('T', ' ', $kk_peng) : null,
            'kk_sampel_diterima_lab' => !empty($kk_terima) ? str_replace('T', ' ', $kk_terima) : null,
            'kk_pengerjaan_sampel' => !empty($kk_kerja) ? str_replace('T', ' ', $kk_kerja) : null,
            'kk_input_hasil' => !empty($kk_input) ? str_replace('T', ' ', $kk_input) : null,
            'kk_cetak_hasil' => !empty($kk_cetak) ? str_replace('T', ' ', $kk_cetak) : null,
            'catatan' => $this->input->post('catatan', true),
            'info_tambahan' => $this->input->post('info_tambahan', true),
        );

        // Update data kaji ulang di database
        if ($this->Kesmas_model->update_kaji_ulang($id, $kaji_ulang_data)) {
            $this->session->set_flashdata('success', 'Kaji ulang permintaan berhasil disimpan.');
            
            // After successful kaji ulang, show completion page with survey
            redirect('kesmas/form_permintaan_kesmas/selesai/' . $id);
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan kaji ulang permintaan.');
            redirect('kesmas/form_permintaan_kesmas/kaji_ulang/' . $id);
        }
    }

    /**
     * Halaman selesai pendaftaran dengan survei kepuasan
     */
    public function selesai($id)
    {
        $id = (int)$id;
        $permintaan = $this->Kesmas_model->get_permintaan($id);
        if (!$permintaan) {
            show_404();
        }

        $data = array(
            'title' => 'Pendaftaran Selesai',
            'permintaan' => $permintaan,
            'permintaan_id' => $id,
            'survey_exists' => false,
            'survey_link' => site_url('kesmas/survei/form')
        );

        $this->render('kesmas/pendaftaran_selesai', $data);
    }

    private function _collect_header($with_no_reg)
    {
        $petugas_pengambil_id = $this->input->post('petugas_pengambil_id', true);

        $header = array(
            'is_diterima' => 1,
            'nama_sampel' => $this->input->post('nama_sampel', true),
            'kategori_sample' => $this->input->post('kategori_sample', true),
            'jenis_sampel' => $this->input->post('jenis_sampel', true),
            'volume_ml' => $this->input->post('volume_ml', true) ?: null,
            'tgl_pengambilan' => $this->input->post('tgl_pengambilan', true) ?: null,
            'jam_pengambilan' => $this->input->post('jam_pengambilan', true) ?: null,
            'lokasi_pengambilan' => $this->input->post('lokasi_pengambilan', true),
            'petugas_pengambil_id' => !empty($petugas_pengambil_id) ? (int)$petugas_pengambil_id : null, // Use the ID directly
            'tindakan_sampel' => $this->input->post('tindakan_sampel', true),
            'info_tambahan' => $this->input->post('info_tambahan', true),

            'nama_pengirim' => $this->input->post('nama_pengirim', true),
            'alamat_pengirim' => $this->input->post('alamat_pengirim', true),
            'telp_pengirim' => $this->input->post('telp_pengirim', true),
            'instansi' => $this->input->post('instansi', true),
            'tgl_permintaan' => $this->input->post('tgl_permintaan', true) ?: null,
            'ttd_pengirim' => $this->input->post('ttd_pengirim', true),

            'jumlah_biaya' => $this->input->post('jumlah_biaya', true) ?: 0,
            'cara_bayar' => $this->input->post('cara_bayar', true),
            'cara_bayar_lainnya' => $this->input->post('cara_bayar_lainnya', true),
            

            'catatan' => $this->input->post('catatan', true),
        );

        if ($with_no_reg) {
            $no_reg_input = $this->input->post('no_registrasi', true);
            $header['no_registrasi'] = empty($no_reg_input) ? null : $no_reg_input;
        }

        return $header;
    }
}
