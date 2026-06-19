<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verifikator extends MY_KlinikController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('klinik/Verifikator_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('session');
    }

    public function index()
    {
        $data['title'] = 'Data Verifikator Klinik';
        $data['petugas'] = $this->Verifikator_model->get_all();

        $this->load->view('klinik/layout/header', $data);
        $this->load->view('klinik/layout/sidebar');
        $this->load->view('klinik/verifikator/index', $data);
        $this->load->view('klinik/layout/footer');
    }

    public function create()
    {
        $data['title'] = 'Tambah Verifikator';
        $data['action'] = site_url('klinik/verifikator/create_action');
        $data['petugas'] = (object)[
            'id_petugas' => '',
            'nama_petugas' => '',
            'jabatan' => '',
        ];

        $this->load->view('klinik/layout/header', $data);
        $this->load->view('klinik/layout/sidebar');
        $this->load->view('klinik/verifikator/form', $data);
        $this->load->view('klinik/layout/footer');
    }

    public function create_action()
    {
        $data = [
            'nama_petugas' => $this->input->post('nama_petugas', TRUE),
            'jabatan'      => $this->input->post('jabatan', TRUE),
        ];

        $this->Verifikator_model->insert($data);
        $this->session->set_flashdata('success', 'Data verifikator berhasil ditambahkan.');
        redirect('klinik/verifikator');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Verifikator';
        // Action tanpa ID di URL, karena ID dikirim lewat hidden input POST
        $data['action'] = site_url('klinik/verifikator/edit_action');
        $data['petugas'] = $this->Verifikator_model->get_by_id($id);

        if (!$data['petugas']) show_404();

        $this->load->view('klinik/layout/header', $data);
        $this->load->view('klinik/layout/sidebar');
        $this->load->view('klinik/verifikator/form', $data);
        $this->load->view('klinik/layout/footer');
    }

    public function edit_action()
    {
        $id = $this->input->post('id_petugas');
        if (empty($id)) {
            $this->session->set_flashdata('error', 'ID verifikator tidak ditemukan.');
            redirect('klinik/verifikator');
        }

        $data = [
            'nama_petugas' => $this->input->post('nama_petugas',TRUE),
            'jabatan'      => $this->input->post('jabatan',TRUE),
        ];

        $this->Verifikator_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data verifikator berhasil diperbarui.');
        redirect('klinik/verifikator');
    }

    public function delete($id)
    {
        $this->Verifikator_model->delete($id);
        $this->session->set_flashdata('success', 'Data verifikator berhasil dihapus.');
        redirect('klinik/verifikator');
    }
}
