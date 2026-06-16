<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_uji_klinik extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('klinik/Form_permintaan_klinik_model');
        $this->load->database();
    }

    // Halaman utama laporan
    public function index() {
        $data['title'] = 'Laporan Uji Klinik';

        // Ambil data form yang SUDAH diinput hasilnya
        $this->db->select('f.id, f.no_register, p.nama_pasien, p.nik, p.gender, f.tgl_form, f.nama_dokter');
        $this->db->from('form_permintaan_klinik f');
        $this->db->join('pasien p', 'p.id_pasien = f.id_pasien', 'left');
        $this->db->join('form_permintaan_klinik_detail d', 'f.id = d.id_form');
        $this->db->where('d.hasil IS NOT NULL');
        $this->db->where('DATE(f.tgl_form)', date('Y-m-d')); // Filter perhari saja
        $this->db->group_by('f.id');
        $this->db->order_by('f.tgl_form', 'DESC');
        $data['laporan'] = $this->db->get()->result();

        $this->load->view('klinik/layout/header', $data);
        $this->load->view('klinik/layout/sidebar');
        $this->load->view('klinik/laporan_uji_klinik/index', $data);
        $this->load->view('klinik/layout/footer');
    }

    // Detail laporan hasil uji
    public function detail($id_form)
{
    $data['title'] = 'Detail Laporan Uji Klinik';

    // Ambil data form
    $data['form'] = $this->Form_permintaan_klinik_model->get_by_id($id_form);

    // Ambil hasil pemeriksaan
    $this->db->select('
    d.*,
    COALESCE(j.satuan, d.satuan) AS satuan,
    COALESCE(j.nilai_rujukan, d.nilai_rujukan) AS nilai_rujukan,
    COALESCE(j.metode, d.metode) AS metode
');
    $this->db->from('form_permintaan_klinik_detail d');
    $this->db->join('jenis_pemeriksaan j', 'd.id_jenis = j.id_jenis', 'left');
    $this->db->where('d.id_form', $id_form);
    $data['detail'] = $this->db->get()->result();

    // Ambil data petugas pengambilan (join dengan tabel petugas_sampel_klinik)
    $data['pengambilan'] = $this->db
        ->select('pk.*, ps.nama_petugas')
        ->from('form_pengambilan_klinik pk')
        ->join('petugas_sampel_klinik ps', 'pk.id_petugas = ps.id_petugas', 'left')
        ->where('pk.id_form', $id_form)
        ->get()
        ->row();

    // Kirim juga ID form agar tidak undefined di view
    $data['id_form'] = $id_form;

    $this->load->view('klinik/layout/header', $data);
    $this->load->view('klinik/layout/sidebar');
    $this->load->view('klinik/laporan_uji_klinik/detail', $data);
    $this->load->view('klinik/layout/footer');
}


    public function export_pdf($id_form)
{

    $form = $this->Form_permintaan_klinik_model->get_by_id($id_form);
    $pengambilan = $this->db->select('pk.*, ps.nama_petugas')
                        ->from('form_pengambilan_klinik pk')
                        ->join('petugas_sampel_klinik ps', 'pk.id_petugas = ps.id_petugas', 'left')
                        ->where('pk.id_form', $id_form)
                        ->get()
                        ->row();


    $detail = $this->db->select('
        d.*,
        j.nama_jenis,
        j.satuan,
        j.nilai_rujukan,
        j.metode,
        j.kategori AS kategori,
        j.sub_kategori AS sub_kategori
    ')
    ->from('form_permintaan_klinik_detail d')
    ->join('jenis_pemeriksaan j', 'd.id_jenis = j.id_jenis', 'left')
    ->where('d.id_form', $id_form)
    ->order_by('j.kategori', 'ASC')
    ->order_by('j.sub_kategori', 'ASC')
    ->order_by('j.nama_jenis', 'ASC')
    ->get()
    ->result();


    $data = [
        'form' => $form,
        'pengambilan' => $pengambilan,
        'detail' => $detail
    ];

    $this->load->library('Pdf');
    $filename = 'laporan_klinik_' . str_replace('/', '_', $form->no_register) . '.pdf';
    $this->pdf->generate_view('klinik/laporan_uji_klinik/print', $data, $filename, 'I');
}


}
