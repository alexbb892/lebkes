<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_KlinikController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $today = date('Y-m-d');

        $query = $this->db->query("
            SELECT COUNT(*) as total FROM (
                SELECT nik FROM pasien 
                WHERE DATE(created_at) = '$today' AND nik IS NOT NULL AND nik != ''
                UNION
                SELECT p.nik FROM form_permintaan_klinik f
                JOIN pasien p ON f.id_pasien = p.id_pasien
                WHERE DATE(f.tgl_form) = '$today' AND p.nik IS NOT NULL AND p.nik != ''
                UNION
                SELECT p.nik FROM kunjungan_rm k 
                JOIN pasien p ON k.no_rm = p.no_rm 
                WHERE DATE(k.tanggal_kunjungan) = '$today' AND p.nik IS NOT NULL AND p.nik != ''
            ) as total_unik
        ");

        $data['total_pasien'] = $query->row()->total;

        $query_terbaru = $this->db->query("
            SELECT COALESCE(updated_at, created_at) as tgl_daftar, no_rm as no_registrasi, nama_pasien, gender as jenis_kelamin, no_rm, nik, umur 
            FROM pasien
            WHERE DATE(created_at) = '$today' OR DATE(updated_at) = '$today'
            ORDER BY tgl_daftar DESC
            LIMIT 10
        ");
        $data['pasien_terbaru'] = $query_terbaru->result();

        // Ambil total pembayaran hari ini
        $query_pembayaran = $this->db->query("
            SELECT SUM(total_biaya) as total_pendapatan 
            FROM pembayaran 
            WHERE DATE(created_at) = '$today'
        ");
        $data['total_pendapatan'] = $query_pembayaran->row()->total_pendapatan ?? 0;

        $this->load->view('klinik/layout/header', $data);
        $this->load->view('klinik/layout/sidebar');
        
        if (strtolower($this->session->userdata('role')) == 'petugas pendaftaran') {
            $this->load->view('klinik/dashboard_klinik/Dashboard_pendaftaran', $data);
        } elseif (strtolower($this->session->userdata('role')) == 'pemeriksa sampel') {
            $this->load->model('klinik/Uji_klinik_model');
            $this->load->model('klinik/Hasil_laporan_model');
            $data['formulir'] = $this->Uji_klinik_model->get_today_formulir_belum_input();
            $data['hasil_lab_siap'] = count($this->Hasil_laporan_model->get_pasien_dengan_soap());
            $this->load->view('klinik/dashboard_klinik/Dashboard_klinik', $data);
        } elseif (strtolower($this->session->userdata('role')) == 'petugas rm') {
            $this->load->view('klinik/dashboard_klinik/Dashboard_dokter', $data);
        } else {
            $this->load->view('klinik/dashboard_klinik/dashboard', $data);
        }
        
        $this->load->view('klinik/layout/footer');
    }

    public function get_demographic_data()
    {
        $today = date('Y-m-d');

        $query = $this->db->query("
            SELECT gender, COUNT(*) as jumlah FROM (
                SELECT gender, nik FROM pasien 
                WHERE DATE(created_at) = '$today' AND gender IS NOT NULL AND gender != '' AND nik IS NOT NULL AND nik != ''
                UNION
                SELECT p.gender, p.nik FROM form_permintaan_klinik f
                JOIN pasien p ON f.id_pasien = p.id_pasien
                WHERE DATE(f.tgl_form) = '$today' AND p.gender IS NOT NULL AND p.gender != '' AND p.nik IS NOT NULL AND p.nik != ''
                UNION
                SELECT p.gender, p.nik FROM kunjungan_rm k 
                JOIN pasien p ON k.no_rm = p.no_rm 
                WHERE DATE(k.tanggal_kunjungan) = '$today' AND p.gender IS NOT NULL AND p.gender != '' AND p.nik IS NOT NULL AND p.nik != ''
            ) as pasien_unik 
            GROUP BY gender
        ");

        $counts = ['Laki-laki' => 0, 'Perempuan' => 0];
        foreach ($query->result() as $row) {
            if ($row->gender == 'Laki-laki') {
                $counts['Laki-laki'] = (int) $row->jumlah;
            } else if ($row->gender == 'Perempuan') {
                $counts['Perempuan'] = (int) $row->jumlah;
            }
        }

        echo json_encode([
            'labels' => ['Laki-laki', 'Perempuan'],
            'data' => [$counts['Laki-laki'], $counts['Perempuan']]
        ]);
    }

    public function get_monthly_kunjungan_data()
    {
        $tahun = date('Y');
        // Inisialisasi data 12 bulan dengan nilai 0
        $kunjungan_data = array_fill(1, 12, 0);

        // Kueri gabungan: Menghitung pasien unik berdasarkan NIK per bulan[cite: 2, 4, 5]
        $query = $this->db->query("
            SELECT bulan, COUNT(*) as jumlah FROM (
                SELECT MONTH(f.tgl_form) as bulan, p.nik FROM form_permintaan_klinik f
                JOIN pasien p ON f.id_pasien = p.id_pasien
                WHERE YEAR(f.tgl_form) = '$tahun' AND p.nik IS NOT NULL AND p.nik != ''
                UNION
                SELECT MONTH(k.tanggal_kunjungan) as bulan, p.nik FROM kunjungan_rm k 
                JOIN pasien p ON k.no_rm = p.no_rm 
                WHERE YEAR(k.tanggal_kunjungan) = '$tahun' AND p.nik IS NOT NULL AND p.nik != ''
            ) as gabungan_bulanan 
            GROUP BY bulan
        ");

        foreach ($query->result() as $row) {
            $kunjungan_data[(int)$row->bulan] = (int)$row->jumlah;
        }

        echo json_encode([
            'labels' => ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
            'data' => array_values($kunjungan_data)
        ]);
    }
}