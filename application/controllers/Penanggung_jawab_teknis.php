<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penanggung_jawab_teknis extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Penanggung_jawab_teknis_model', 'pjt_model');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index()
    {
        $data['title'] = 'Daftar Penanggung Jawab Teknis';
        $data['penanggung_jawab_teknis_list'] = $this->pjt_model->list_penanggung_jawab_teknis();
        
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('penanggung_jawab_teknis/list', $data);
        $this->load->view('layout/footer');
    }

    public function add()
    {
        $data['title'] = 'Tambah Penanggung Jawab Teknis';

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('nip', 'NIP', 'trim');

        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/sidebar');
            $this->load->view('penanggung_jawab_teknis/add', $data);
            $this->load->view('layout/footer');
        }
        else
        {
            $post_data = array(
                'nama' => $this->input->post('nama'),
                'nip' => $this->input->post('nip'),
                'is_active' => 1,
            );

            if ($this->pjt_model->add_penanggung_jawab_teknis($post_data))
            {
                $this->session->set_flashdata('success', 'Data berhasil ditambahkan.');
                redirect('penanggung_jawab_teknis');
            }
            else
            {
                $this->session->set_flashdata('error', 'Gagal menambahkan data.');
                $this->load->view('layout/header', $data);
                $this->load->view('layout/sidebar');
                $this->load->view('penanggung_jawab_teknis/add', $data);
                $this->load->view('layout/footer');
            }
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Penanggung Jawab Teknis';
        $data['pjt'] = $this->pjt_model->get_penanggung_jawab_teknis_by_id($id);

        if (empty($data['pjt'])) {
            show_404();
        }

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('nip', 'NIP', 'trim');

        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/sidebar');
            $this->load->view('penanggung_jawab_teknis/edit', $data);
            $this->load->view('layout/footer');
        }
        else
        {
            $post_data = array(
                'nama' => $this->input->post('nama'),
                'nip' => $this->input->post('nip'),
            );

            if ($this->pjt_model->update_penanggung_jawab_teknis($id, $post_data))
            {
                $this->session->set_flashdata('success', 'Data berhasil diupdate.');
                redirect('penanggung_jawab_teknis');
            }
            else
            {
                $this->session->set_flashdata('error', 'Gagal mengupdate data.');
                $this->load->view('layout/header', $data);
                $this->load->view('layout/sidebar');
                $this->load->view('penanggung_jawab_teknis/edit', $data);
                $this->load->view('layout/footer');
            }
        }
    }

    public function delete($id)
    {
        if ($this->pjt_model->delete_penanggung_jawab_teknis($id))
        {
            $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        }
        else
        {
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }
        redirect('penanggung_jawab_teknis');
    }
}
