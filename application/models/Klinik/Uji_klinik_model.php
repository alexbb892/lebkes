<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uji_klinik_model extends CI_Model {

    // Ambil semua formulir yang BELUM diinput hasilnya
    public function get_formulir_belum_input() {
        $this->db->select('f.id, f.no_register, p.nik, p.nama_pasien, p.gender, f.tgl_form, f.nama_dokter');
        $this->db->from('form_permintaan_klinik f');
        $this->db->join('pasien p', 'p.id_pasien = f.id_pasien', 'left');

        // Gabung ke detail pemeriksaan (form_permintaan_klinik_detail)
        $this->db->join('(SELECT id_form, COUNT(hasil) AS total_hasil 
                          FROM form_permintaan_klinik_detail 
                          WHERE hasil IS NOT NULL AND hasil <> "" 
                          GROUP BY id_form) d', 'f.id = d.id_form', 'left');

        // Hanya ambil yang belum punya hasil sama sekali
        $this->db->where('d.id_form IS NULL');

        $this->db->order_by('f.id', 'DESC');
        return $this->db->get()->result();
    }

    // Ambil formulir yang BELUM diinput hasilnya UNTUK HARI INI
    public function get_today_formulir_belum_input() {
        $this->db->select('f.id, f.no_register, p.nik, p.nama_pasien, p.gender, f.tgl_form, f.nama_dokter');
        $this->db->from('form_permintaan_klinik f');
        $this->db->join('pasien p', 'p.id_pasien = f.id_pasien', 'left');

        // Gabung ke detail pemeriksaan
        $this->db->join('(SELECT id_form, COUNT(hasil) AS total_hasil 
                          FROM form_permintaan_klinik_detail 
                          WHERE hasil IS NOT NULL AND hasil <> "" 
                          GROUP BY id_form) d', 'f.id = d.id_form', 'left');

        // Hanya ambil yang belum punya hasil sama sekali dan HARI INI
        $this->db->where('d.id_form IS NULL');
        $this->db->where('DATE(f.tgl_form)', date('Y-m-d'));

        $this->db->order_by('f.id', 'DESC');
        return $this->db->get()->result();
    }

}
