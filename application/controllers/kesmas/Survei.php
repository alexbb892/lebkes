<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Survei extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Survei_kepuasan_model');
        // Note: require_login() removed from constructor to allow public access to survey form
    }

    /**
     * Check if user is logged in, redirect if not
     */
    protected function require_login(): void
    {
        if (!is_logged_in()) {
            redirect('petugaslogin');
            exit;
        }
    }

    /**
     * Check if user has one of the required roles, redirect if not.
     * @param array $roles Array of allowed roles (e.g., ['admin', 'petugas'])
     */
    protected function require_role(array $roles): void
    {
        $this->require_login(); // Ensure user is logged in first
        $user_role = $this->session->userdata('role');

        // Allow if user has any of the specified roles
        if (!in_array($user_role, $roles)) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            redirect('dashboard'); // Redirect to a safe, default page
            exit;
        }
    }

    /**
     * Halaman list survei (Admin only)
     */
    public function index()
    {
        $this->require_login();
        $this->require_role(['admin', 'petugas']);

        $data['title'] = 'Survei Kepuasan Pelanggan';
        $data['survei'] = $this->Survei_kepuasan_model->get_all();
        $data['stats'] = $this->Survei_kepuasan_model->get_rating_stats();

        $this->load->view('layout/header', $data);
        $this->load->view('kesmas/survei/index', $data);
        $this->load->view('layout/footer');
    }

    /**
     * Halaman form survei (untuk pelanggan)
     */
    public function form()
    {
        $data['title'] = 'Survei Kepuasan Masyarakat';
        $data['permintaan_id'] = $this->input->get('permintaan_id', true);

        $this->load->view('public/header', $data);
        $this->load->view('kesmas/survei/form', $data);
        $this->load->view('public/footer');
    }

    /**
     * Store survei baru
     */
    public function store()
    {
        // Allow public access for survey submission
        // Temporarily disable login requirement for this method

        $post = $this->input->post();

        $validation_rules = array(
            array('field' => 'usia', 'label' => 'Usia', 'rules' => 'required|numeric'),
            array('field' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'rules' => 'required'),
            array('field' => 'pendidikan', 'label' => 'Pendidikan', 'rules' => 'required'),
            array('field' => 'pekerjaan', 'label' => 'Pekerjaan', 'rules' => 'required'),
            array('field' => 'jenis_layanan', 'label' => 'Jenis Layanan yang diterima', 'rules' => 'required'),
        );

        for ($i = 1; $i <= 9; $i++) {
            $validation_rules[] = array('field' => 'q' . $i, 'label' => 'Unsur Pelayanan ' . $i, 'rules' => 'required|numeric|greater_than_equal_to[1]|less_than_equal_to[4]');
        }

        $this->form_validation->set_rules($validation_rules);

        if (!$this->form_validation->run()) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            return;
        }

        $insert_id = $this->Survei_kepuasan_model->create($post);

        if ($insert_id) {
            echo json_encode(['status' => 'success', 'message' => 'Terima kasih atas umpan balik Anda!', 'id' => $insert_id]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan survei']);
        }
    }

    /**
     * View survei (Public access)
     */
    public function view($id)
    {
        $data['title'] = 'Detail Survei';
        $data['survei'] = $this->Survei_kepuasan_model->get_by_id($id);

        if (!$data['survei']) {
            show_404();
        }

        $this->load->view('public/header', $data);
        $this->load->view('kesmas/survei/view', $data);
        $this->load->view('public/footer');
    }

    /**
     * Detail survei (Admin access)
     */
    public function detail($id)
    {
        $this->require_login();
        $this->require_role(['admin', 'petugas']);

        $data['title'] = 'Detail Kuesioner SKM';
        $data['survei'] = $this->Survei_kepuasan_model->get_by_id($id);

        if (!$data['survei']) {
            show_404();
        }

        $this->load->view('layout/header', $data);
        $this->load->view('kesmas/survei/detail', $data);
        $this->load->view('layout/footer');
    }

    /**
     * Halaman edit survei (admin only)
     */
    public function edit($id)
    {
        $this->require_login();
        $this->require_role(['admin', 'petugas']);

        $data['title'] = 'Edit Survei';
        $data['item'] = $this->Survei_kepuasan_model->get_by_id($id);

        if (!$data['item']) {
            show_404();
        }

        $this->load->view('layout/header', $data);
        $this->load->view('kesmas/survei/form_edit', $data);
        $this->load->view('layout/footer');
    }

    /**
     * Update survei (admin only)
     */
    public function update($id)
    {
        $this->require_login();
        $this->require_role(['admin', 'petugas']);

        $post = $this->input->post();

        $validation_rules = array(
            array('field' => 'usia', 'label' => 'Usia', 'rules' => 'required|numeric'),
            array('field' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'rules' => 'required'),
            array('field' => 'pendidikan', 'label' => 'Pendidikan', 'rules' => 'required'),
            array('field' => 'pekerjaan', 'label' => 'Pekerjaan', 'rules' => 'required'),
            array('field' => 'jenis_layanan', 'label' => 'Jenis Layanan yang diterima', 'rules' => 'required'),
        );

        for ($i = 1; $i <= 9; $i++) {
            $validation_rules[] = array('field' => 'q' . $i, 'label' => 'Unsur Pelayanan ' . $i, 'rules' => 'required|numeric|greater_than_equal_to[1]|less_than_equal_to[4]');
        }

        $this->form_validation->set_rules($validation_rules);

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('kesmas/survei/edit/' . $id);
        }

        if ($this->Survei_kepuasan_model->update($id, $post)) {
            $this->session->set_flashdata('success', 'Survei berhasil diupdate');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengupdate survei');
        }

        redirect('kesmas/survei');
    }

    /**
     * Delete survei (admin only)
     */
    public function delete($id)
    {
        $this->require_login();
        $this->require_role(['admin', 'petugas']);

        if ($this->Survei_kepuasan_model->delete($id)) {
            $this->session->set_flashdata('success', 'Survei berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus survei');
        }

        redirect($_SERVER['HTTP_REFERER'] ?? 'kesmas/survei');
    }

    /**
     * Laporan survei dengan detail (admin only)
     */
    public function laporan()
    {
        $this->require_login();
        $this->require_role(['admin', 'petugas']);

        $data['title'] = 'Laporan Survei Kepuasan';
        $data['stats'] = $this->Survei_kepuasan_model->get_rating_stats();
        $data['low_ratings'] = $this->Survei_kepuasan_model->get_low_ratings();
        $data['with_comments'] = $this->Survei_kepuasan_model->get_with_comments();
        $data['semua_survei'] = $this->Survei_kepuasan_model->get_all();

        $this->load->view('layout/header', $data);
        $this->load->view('kesmas/survei/laporan', $data);
        $this->load->view('layout/footer');
    }

    /**
     * Laporan by date range (admin only)
     */
    public function laporan_by_date()
    {
        $this->require_login();
        $this->require_role(['admin', 'petugas']);

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $data['title'] = 'Laporan Survei by Tanggal';

        if ($start_date && $end_date) {
            $data['survei'] = $this->Survei_kepuasan_model->get_by_date_range($start_date, $end_date);
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
        } else {
            $data['survei'] = array();
        }

        $this->load->view('layout/header', $data);
        $this->load->view('kesmas/survei/laporan_date', $data);
        $this->load->view('layout/footer');
    }
}
