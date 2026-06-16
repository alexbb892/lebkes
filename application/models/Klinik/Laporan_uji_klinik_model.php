<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_uji_klinik_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        $this->db->select('f.id, f.no_register, p.nama_pasien, p.nik, p.gender, f.tgl_permintaan AS tgl_form, f.nama_dokter');
        $this->db->from('form_permintaan_klinik f');
        $this->db->join('pasien p', 'p.id_pasien = f.id_pasien', 'left');
        $this->db->join('form_permintaan_klinik_detail d', 'd.id_form = f.id', 'left');
        $this->db->where('d.hasil IS NOT NULL'); // hanya yang sudah ada hasil pemeriksaan
        $this->db->group_by('f.id');
        $this->db->order_by('f.tgl_permintaan', 'DESC');
        return $this->db->get()->result();
    }


    /**
     * Ambil daftar form yang sudah punya minimal 1 hasil (d.hasil IS NOT NULL)
     */
    public function get_data_hasil()
{
    $this->db->select('f.id, f.no_register, p.nama_pasien, p.nik, p.gender, f.tgl_form, f.nama_dokter');
    $this->db->from('form_permintaan_klinik f');
    $this->db->join('pasien p', 'p.id_pasien = f.id_pasien', 'left');
    $this->db->join('form_permintaan_klinik_detail d', 'd.id_form = f.id', 'left');
    $this->db->where('d.hasil IS NOT NULL');
    $this->db->group_by('f.id');
    $this->db->order_by('f.tgl_form', 'DESC');
    $query = $this->db->get();
    return $query->result();
}


    /**
     * Ambil detail hasil pemeriksaan per form (untuk halaman detail)
     */
    public function get_detail($id_form) {
        $this->db->select('
            d.id_detail,
            d.nama_jenis,
            d.hasil,
            COALESCE(j.satuan, d.satuan) AS satuan,
            COALESCE(j.nilai_rujukan, d.nilai_rujukan) AS nilai_rujukan,
            COALESCE(j.metode, d.metode) AS metode
        ');
        $this->db->from('form_permintaan_klinik_detail d');
        $this->db->join('jenis_pemeriksaan j', 'j.id_jenis = d.id_jenis', 'left'); // jika id_jenis ada
        $this->db->where('d.id_form', $id_form);
        $this->db->order_by('d.id_detail', 'ASC');
        return $this->db->get()->result();
    }
}
