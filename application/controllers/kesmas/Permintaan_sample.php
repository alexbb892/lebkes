<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permintaan_sample extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kesmas_model');
    }

    public function index()
    {
        $filters = array(
            'q' => $this->input->get('q', true),
            'dari' => $this->input->get('dari', true),
            'sampai' => $this->input->get('sampai', true),
            'is_diterima' => 0,
            'exclude_ditolak' => true,  // Exclude rejected samples (is_diterima = 2)
        );

        $data = array(
            'title' => 'Terima Sample',
            'rows' => $this->Kesmas_model->list_permintaan($filters),
            'filters' => $filters,
        );

        $this->render('kesmas/permintaan_list', $data);
    }

    public function verifikasi($id)
    {
        try {
            $id = (int)$id;
            $permintaan = $this->Kesmas_model->get_permintaan($id);
            if (!$permintaan) show_404();

            // Reject if sample has already been rejected (is_diterima = 2)
            if ($permintaan['is_diterima'] == 2) {
                $this->session->set_flashdata('error', 'Sample ini sudah ditolak dan tidak dapat diproses lebih lanjut.');
                redirect('kesmas/permintaan_sample');
                return;
            }

            if ($this->input->method() === 'post') {
                $no_registrasi = $this->input->post('no_registrasi', true);

                // Update no_registrasi
                if (!empty($no_registrasi)) {
                    // Pengecekan duplikat sebelum update untuk menghindari database error (1062)
                    $existing = $this->db->get_where('kesmas_permintaan', ['no_registrasi' => $no_registrasi, 'id !=' => $id])->row();
                    if ($existing) {
                        $this->session->set_flashdata('error', 'Gagal menyimpan. Nomor Registrasi "' . htmlspecialchars($no_registrasi) . '" sudah digunakan oleh sampel lain.');
                        redirect('kesmas/permintaan_sample/verifikasi/'.$id);
                        return;
                    }

                    $this->db->where('id', $id);
                    if (!$this->db->update('kesmas_permintaan', ['no_registrasi' => $no_registrasi])) {
                        $db_error = $this->db->error();
                        $this->session->set_flashdata('error', 'Gagal menyimpan Nomor Registrasi. Pastikan nomor unik dan belum digunakan. ' . ($db_error['message'] ?? ''));
                        redirect('kesmas/permintaan_sample/verifikasi/'.$id);
                        return;
                    }
                }

                $ok = $this->Kesmas_model->terima_sampel($id, $this->session->userdata('user_id'));
                if ($ok) {
                    $this->session->set_flashdata('success', 'Sample berhasil diverifikasi dan diterima.');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menerima sample.');
                }
                redirect('kesmas/permintaan_sample');
            }

            $data = array(
                'title' => 'Verifikasi Sample',
                'permintaan' => $permintaan,
            );
            $this->render('kesmas/verifikasi_sample_form', $data);
        } catch (Exception $e) {
            log_message('error', 'Error in verifikasi: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
            redirect('kesmas/permintaan_sample');
        }
    }

    public function tolak($id)
    {
        $id = (int)$id;
        $permintaan = $this->Kesmas_model->get_permintaan($id);
        if (!$permintaan) show_404();

        $ok = $this->Kesmas_model->tolak_sampel($id, $this->session->userdata('user_id'));
        if ($ok) {
            $this->session->set_flashdata('success', 'Sample ditolak dan dihapus dari database.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menolak sample.');
        }
        redirect('kesmas/permintaan_sample');

    }
}
