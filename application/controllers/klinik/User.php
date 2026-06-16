<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('klinik/User_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('session');

        // Cek login dan role admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('klinik/auth/login');
        }   
    }

    // Tampilkan daftar user
    public function index() {
        $data['title'] = 'Data User';
        $data['users'] = $this->User_model->get_all();

        $this->load->view('klinik/layout/header', $data);
        $this->load->view('klinik/layout/sidebar');
        $this->load->view('klinik/user/index', $data);
        $this->load->view('klinik/layout/footer');
    }

    // Tampilkan form tambah user
    public function add() {
        $data['title'] = 'Tambah User';
        $this->load->view('klinik/layout/header', $data);
        $this->load->view('klinik/layout/sidebar');
        $this->load->view('klinik/user/form', $data); // pastikan form ada di user/form.php
        $this->load->view('klinik/layout/footer');
    }

    // Proses tambah user
    public function create() {
        if ($this->input->post()) {
            $data = [
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'), // di-hash di model
                'nama' => $this->input->post('nama'),
                'role' => $this->input->post('role')
            ];

            $this->User_model->insert($data);
            $this->session->set_flashdata('success', 'User berhasil ditambahkan');
            redirect('klinik/user');
        } else {
            redirect('klinik/user/add');
        }
    }

    // Tampilkan form edit user
    public function edit($id) {
        $data['title'] = 'Edit User';
        $data['user'] = $this->User_model->get_by_id($id);

        if (!$data['user']) show_404();

        $this->load->view('klinik/layout/header', $data);
        $this->load->view('klinik/layout/sidebar');
        $this->load->view('klinik/user/edit', $data);
        $this->load->view('klinik/layout/footer');
    }

    // Proses update user
    public function update($id) {
        $data = [
            'username' => $this->input->post('username'),
            'nama' => $this->input->post('nama'),
            'role' => $this->input->post('role')
        ];

        // Cek apakah password baru diisi
        $password = $this->input->post('password');
        if (!empty($password)) {
            $data['password'] = $password; // di-hash di model
        }

        $this->User_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data user berhasil diperbarui.');
        redirect('klinik/user');
    }

    // Hapus user
    public function delete($id) {
        $this->User_model->delete($id);
        $this->session->set_flashdata('success', 'User berhasil dihapus.');
        redirect('klinik/user');
    }

    // Reset password user ke default 123456
    public function reset_password($id) {
        $new_password = '123456';
        $this->User_model->reset_password($id, $new_password);
        $this->session->set_flashdata('success', 'Password direset ke 123456');
        redirect('klinik/user');
    }
}
