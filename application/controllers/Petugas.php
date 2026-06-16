<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Petugas extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load necessary models, helpers, libraries
        $this->load->model('User_model');
        $this->load->model('Kesmas_model'); // Assuming User_model handles petugas
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function add()
    {
        // Form validation rules
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            // If validation fails or form is not submitted, show the form
            $data['title'] = 'Tambah Petugas';
            $this->load->view('layout/header', $data);
            $this->load->view('layout/sidebar');
            $this->load->view('petugas/add', $data); // Assuming view path application/views/petugas/add.php
            $this->load->view('layout/footer');
        }
        else
        {
            // If validation passes, process the form
            $data = array(
                'nama' => $this->input->post('nama'),
                'jabatan' => $this->input->post('jabatan'),
                // Add any other necessary fields, e.g., 'created_at', 'updated_at'
            );

            // Assuming a method in Kesmas_model to add petugas
            if ($this->Kesmas_model->add_petugas($data))
            {
                $this->session->set_flashdata('success', 'Petugas berhasil ditambahkan.');
                redirect('petugas/add'); // Redirect back to the form or a list page
            }
            else
            {
                $this->session->set_flashdata('error', 'Gagal menambahkan petugas.');
                redirect('petugas/add');
            }
        }
    }

    // You might want a list method as well
    public function index()
    {
        $data['title'] = 'Daftar Petugas';
        $data['petugas'] = $this->Kesmas_model->list_petugas(); // Assuming this method exists
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('petugas/list', $data); // Assuming view path application/views/petugas/list.php
        $this->load->view('layout/footer');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Petugas';
        $petugas = $this->Kesmas_model->get_petugas_by_id($id);

        if (!$petugas) {
            $this->session->set_flashdata('error', 'Petugas tidak ditemukan.');
            redirect('petugas');
        }

        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['petugas'] = $petugas;
            $this->load->view('layout/header', $data);
            $this->load->view('layout/sidebar');
            $this->load->view('petugas/add', $data); // Reuse the add view for editing
            $this->load->view('layout/footer');
        } else {
            $update_data = array(
                'nama' => $this->input->post('nama'),
                'jabatan' => $this->input->post('jabatan'),
            );

            if ($this->Kesmas_model->update_petugas($id, $update_data)) {
                $this->session->set_flashdata('success', 'Petugas berhasil diperbarui.');
                redirect('petugas');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui petugas.');
                redirect('petugas/edit/' . $id);
            }
        }
    }

    public function delete($id)
    {
        if ($this->Kesmas_model->delete_petugas($id)) {
            $this->session->set_flashdata('success', 'Petugas berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus petugas.');
        }
        redirect('petugas');
    }
}