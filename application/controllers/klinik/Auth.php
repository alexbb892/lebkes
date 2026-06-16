<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('klinik/User_model');
    }

    public function index() {
        $this->load->view('klinik/auth/login');
    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Ambil user berdasarkan username
        $user = $this->User_model->get_by_username($username);

        if ($user && password_verify($password, $user->password)) {
            $this->session->set_userdata([
                'id_user'   => $user->id_user,
                'username'  => $user->username,
                'nama'      => $user->nama,
                'role'      => $user->role,
                'logged_in' => TRUE
            ]);

            // Redirect sesuai role
            switch ($user->role) {
                case 'admin': redirect('klinik/dashboard'); break;
                case 'petugas': redirect('klinik/dashboard'); break;
                case 'dokter': redirect('klinik/dashboard'); break;
                case 'pemeriksa sampel': redirect('klinik/dashboard'); break;
                case 'petugas pendaftaran': redirect('klinik/dashboard'); break;
                case 'petugas rm': redirect('klinik/dashboard'); break;
                default: redirect('klinik/dashboard'); break;
            }
        } else {
            $this->session->set_flashdata('error', 'Username atau password salah!');
            redirect('klinik/petugas_klinik');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('klinik/petugas_klinik');
    }
}
