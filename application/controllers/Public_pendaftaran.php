<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Public_pendaftaran Controller
 *
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Security $security
 * @property Kesmas_model $Kesmas_model
 * @property Tindakan_sampel_model $Tindakan_sampel_model
 * @property Survei_kepuasan_model $Survei_kepuasan_model
 */
class Public_pendaftaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kesmas_model');
        $this->load->model('Tindakan_sampel_model');
        $this->load->helper('security'); // Load security helper for CSRF
    }

    public function index()
    {
        $data = array(
            'title' => 'Layanan Pendaftaran Sampel',
        );
        $this->load->view('public/header', $data);
        $this->load->view('public/landing', $data);
        $this->load->view('public/footer', $data);
    }

    public function form()
    {
        $data = array(
            'title' => 'Formulir Pendaftaran Sampel',
            'mode' => 'create',
            'no_registrasi' => $this->Kesmas_model->gen_no_registrasi(),
            'permintaan' => null,
            'selected_ids' => array(),
            'petugas' => $this->Kesmas_model->list_petugas(),
            'tindakan_sampel' => $this->Tindakan_sampel_model->list_tindakan_sampel(),
        );

        // default tampilkan master untuk 4 kategori di tab
        $data['master_air_minum'] = $this->Kesmas_model->get_master_grouped('air_minum');
        $data['master_air_bersih'] = $this->Kesmas_model->get_master_grouped('air_bersih');
        $data['master_makanan'] = $this->Kesmas_model->get_master_grouped('makanan');
        $data['master_lingkungan'] = $this->Kesmas_model->get_master_grouped('lingkungan');

        $this->load->view('public/header', $data);
        $this->load->view('public/permintaan_form', $data);
        $this->load->view('public/footer', $data);
    }

    public function store()
    {
        try {
            $this->form_validation->set_rules('nama_sampel', 'Nama Sampel', 'required|trim');
            $this->form_validation->set_rules('kategori_sample', 'Kategori Sample', 'required');
            $this->form_validation->set_rules('jenis_sampel', 'Jenis Sampel', 'required');
            $this->form_validation->set_rules('disclaimer', 'Syarat dan Ketentuan', 'required', array('required' => 'Anda harus menyetujui Syarat dan Ketentuan untuk melanjutkan.'));
            
            if (!$this->form_validation->run()) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('public_pendaftaran/form');
            }

            $header = $this->_collect_header(true);
            $master_ids = $this->input->post('pemeriksaan', true);
            if (!is_array($master_ids)) $master_ids = array();

            // null user_id since it's public
            $permintaan_id = $this->Kesmas_model->save_permintaan($header, $master_ids, null);
            if (!$permintaan_id) {
                $this->session->set_flashdata('error', 'Gagal menyimpan pendaftaran. Silakan coba lagi.');
                redirect('public_pendaftaran/form');
            }

            $no_reg = $header['no_registrasi'];
            $this->session->set_flashdata('success', 'Berhasil melakukan pendaftaran sampel. Menunggu petugas untuk memproses.');
            redirect('public_pendaftaran/success/'.$no_reg);
        } catch (Exception $e) {
            log_message('error', 'Error in store: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
            redirect('public_pendaftaran/form');
        }
    }

    public function success($no_registrasi = null)
    {
        if (!$no_registrasi) show_404();

        $permintaan = $this->Kesmas_model->get_permintaan_by_no_registrasi($no_registrasi);
        if (!$permintaan) show_404();

        // Cek ketersediaan survei
        $this->load->model('Survei_kepuasan_model');
        $survey_exists = $this->Survei_kepuasan_model->check_exists($permintaan['id']);

        $data = array(
            'title' => 'Pendaftaran Berhasil',
            'permintaan' => $permintaan,
            'survey_exists' => $survey_exists,
            'survey_link' => site_url('kesmas/survei/form?permintaan_id=' . $permintaan['id'])
        );
        $this->load->view('public/header', $data);
        $this->load->view('public/success', $data);
        $this->load->view('public/footer', $data);
    }

    public function print_bukti($no_registrasi = null)
    {
        if (!$no_registrasi) show_404();

        $permintaan = $this->Kesmas_model->get_permintaan_by_no_registrasi($no_registrasi);
        if (!$permintaan) show_404();

        $items = $this->Kesmas_model->get_items_with_result($permintaan['id']);

        $data = array(
            'title' => 'Bukti Pendaftaran - ' . $no_registrasi,
            'pendaftaran' => (object)$permintaan,
            'pemeriksaan' => json_decode(json_encode($items)),
        );

        // Can reuse the print_pendaftaran view or create a simplified public one
        $this->load->view('public/print_bukti', $data);
    }

    private function _collect_header($with_no_reg)
    {
        $petugas_pengambil_id = $this->input->post('petugas_pengambil_id', true);

        $header = array(
            'is_diterima' => 0,
            'nama_sampel' => $this->input->post('nama_sampel', true),
            'kategori_sample' => $this->input->post('kategori_sample', true),
            'jenis_sampel' => $this->input->post('jenis_sampel', true),
            'volume_ml' => $this->input->post('volume_ml', true) ?: null,
            'tgl_pengambilan' => $this->input->post('tgl_pengambilan', true) ?: null,
            'jam_pengambilan' => $this->input->post('jam_pengambilan', true) ?: null,
            'lokasi_pengambilan' => $this->input->post('lokasi_pengambilan', true),
            'petugas_pengambil_id' => !empty($petugas_pengambil_id) ? (int)$petugas_pengambil_id : null,
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
