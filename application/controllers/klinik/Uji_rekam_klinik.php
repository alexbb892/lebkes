<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uji_rekam_klinik extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function index()
    {
        $data['title'] = 'Data Pasien - Riwayat Kunjungan Klinik';
        
        // Ambil input pencarian dengan pengamanan XSS
        $search = $this->input->get('search', TRUE);

        // Ambil daftar pasien unik yang memiliki riwayat uji klinik
        $this->db->select('p.id_pasien, p.no_rm, p.nama_pasien, p.nik, p.gender, COUNT(f.id) as total_uji');
        $this->db->from('pasien p');
        $this->db->join('form_permintaan_klinik f', 'f.id_pasien = p.id_pasien', 'inner');
        
        if (!empty($search)) {
            // Jika ada kata kunci pencarian, cari di seluruh tanggal
            $this->db->group_start();
            $this->db->like('p.nama_pasien', $search);
            $this->db->or_like('p.nik', $search);
            $this->db->group_end();
        } else {
            // Jika pencarian kosong, tampilkan data kunjungan hari ini saja
            $this->db->where('DATE(f.tgl_form)', date('Y-m-d'));
        }

        $this->db->group_by(['p.id_pasien', 'p.no_rm', 'p.nama_pasien', 'p.nik', 'p.gender']);
        $this->db->order_by('p.nama_pasien', 'ASC');
        
        $data['pasien'] = $this->db->get()->result();

        $this->load->view('klinik/layout/header', $data);
        $this->load->view('klinik/layout/sidebar');
        $this->load->view('klinik/uji_rekam_klinik/index', $data);
        $this->load->view('klinik/layout/footer');
    }

    public function detail($id_pasien)
    {
        $data['title'] = 'Riwayat Uji Klinik Pasien';

        // Ambil data identitas pasien
        $this->db->where('id_pasien', $id_pasien);
        $data['pasien'] = $this->db->get('pasien')->row();

        if (!$data['pasien']) {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan.');
            redirect('uji_rekam_klinik');
        }

        // Ambil riwayat formulir permintaan klinik untuk pasien ini
        // Serta hitung detail yang sudah diinput hasil lab-nya
        $this->db->select('f.*, 
            (SELECT COUNT(*) FROM form_permintaan_klinik_detail fd WHERE fd.id_form = f.id AND fd.hasil IS NOT NULL AND fd.hasil != "") as hasil_diisi,
            (SELECT COUNT(*) FROM form_permintaan_klinik_detail fd WHERE fd.id_form = f.id) as total_detail');
        $this->db->from('form_permintaan_klinik f');
        $this->db->where('f.id_pasien', $id_pasien);
        $this->db->order_by('f.tgl_form', 'DESC');
        
        $data['riwayat'] = $this->db->get()->result();

        $this->load->view('klinik/layout/header', $data);
        $this->load->view('klinik/layout/sidebar');
        $this->load->view('klinik/uji_rekam_klinik/detail', $data);
        $this->load->view('klinik/layout/footer');
    }
}
