<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verifikator extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Verifikator_model');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['title'] = 'Daftar Verifikator';
        $data['verifikator_list'] = $this->Verifikator_model->list_verifikator();
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('verifikator/list', $data);
        $this->load->view('layout/footer');
    }

    public function add()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $data['title'] = 'Tambah Verifikator';
            $this->load->view('layout/header', $data);
            $this->load->view('layout/sidebar');
            $this->load->view('verifikator/add', $data);
            $this->load->view('layout/footer');
        }
        else
        {
            $data = array(
                'nama' => $this->input->post('nama'),
                'jabatan' => $this->input->post('jabatan'),
            );

            if ($this->Verifikator_model->add_verifikator($data))
            {
                $this->session->set_flashdata('success', 'Verifikator berhasil ditambahkan.');
                redirect('verifikator');
            }
            else
            {
                $this->session->set_flashdata('error', 'Gagal menambahkan verifikator.');
                redirect('verifikator/add');
            }
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Verifikator';
        $verifikator = $this->Verifikator_model->get_verifikator_by_id($id);

        if (!$verifikator) {
            $this->session->set_flashdata('error', 'Verifikator tidak ditemukan.');
            redirect('verifikator');
        }

        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['verifikator'] = $verifikator;
            $this->load->view('layout/header', $data);
            $this->load->view('layout/sidebar');
            $this->load->view('verifikator/add', $data); // Reuse the add view for editing
            $this->load->view('layout/footer');
        } else {
            $update_data = array(
                'nama' => $this->input->post('nama'),
                'jabatan' => $this->input->post('jabatan'),
            );

            if ($this->Verifikator_model->update_verifikator($id, $update_data)) {
                $this->session->set_flashdata('success', 'Verifikator berhasil diperbarui.');
                redirect('verifikator');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui verifikator.');
                redirect('verifikator/edit/' . $id);
            }
        }
    }

    public function delete($id)
    {
        if ($this->Verifikator_model->delete_verifikator($id)) {
            $this->session->set_flashdata('success', 'Verifikator berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus verifikator.');
        }
        redirect('verifikator');
    }
}
