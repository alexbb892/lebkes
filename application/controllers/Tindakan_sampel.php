<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tindakan_sampel extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tindakan_sampel_model');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index()
    {
        $data['title'] = 'Master Tindakan Sampel';
        $data['tindakan_sampel_list'] = $this->Tindakan_sampel_model->list_tindakan_sampel();
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('tindakan_sampel/list', $data);
        $this->load->view('layout/footer');
    }

    public function add()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|is_unique[kesmas_tindakan_sampel.nama]');

        if ($this->form_validation->run() == FALSE)
        {
            $data['title'] = 'Tambah Master Tindakan Sampel';
            $this->load->view('layout/header', $data);
            $this->load->view('layout/sidebar');
            $this->load->view('tindakan_sampel/form', $data);
            $this->load->view('layout/footer');
        }
        else
        {
            $data = array(
                'nama' => $this->input->post('nama'),
            );

            if ($this->Tindakan_sampel_model->add_tindakan_sampel($data))
            {
                $this->session->set_flashdata('success', 'Tindakan Sampel berhasil ditambahkan.');
                redirect('tindakan_sampel');
            }
            else
            {
                $this->session->set_flashdata('error', 'Gagal menambahkan Tindakan Sampel.');
                redirect('tindakan_sampel/add');
            }
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Master Tindakan Sampel';
        $tindakan_sampel = $this->Tindakan_sampel_model->get_tindakan_sampel_by_id($id);

        if (!$tindakan_sampel) {
            $this->session->set_flashdata('error', 'Tindakan Sampel tidak ditemukan.');
            redirect('tindakan_sampel');
        }

        $this->form_validation->set_rules('nama', 'Nama', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['tindakan_sampel'] = $tindakan_sampel;
            $this->load->view('layout/header', $data);
            $this->load->view('layout/sidebar');
            $this->load->view('tindakan_sampel/form', $data);
            $this->load->view('layout/footer');
        } else {
            $update_data = array(
                'nama' => $this->input->post('nama'),
            );

            if ($this->Tindakan_sampel_model->update_tindakan_sampel($id, $update_data)) {
                $this->session->set_flashdata('success', 'Tindakan Sampel berhasil diperbarui.');
                redirect('tindakan_sampel');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui Tindakan Sampel.');
                redirect('tindakan_sampel/edit/' . $id);
            }
        }
    }

    public function delete($id)
    {
        if ($this->Tindakan_sampel_model->delete_tindakan_sampel($id)) {
            $this->session->set_flashdata('success', 'Tindakan Sampel berhasil dihapus (dinonaktifkan).');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus Tindakan Sampel.');
        }
        redirect('tindakan_sampel');
    }
}
