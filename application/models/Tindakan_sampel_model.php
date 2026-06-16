<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tindakan_sampel_model extends CI_Model
{
    private $table = 'kesmas_tindakan_sampel';

    public function list_tindakan_sampel(): array
    {
        $this->db->where('is_active', 1)->order_by('nama','ASC');
        return $this->db->get($this->table)->result_array();
    }

    public function add_tindakan_sampel($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function get_tindakan_sampel_by_id(int $id)
    {
        return $this->db->get_where($this->table, array('id' => $id))->row_array();
    }

    public function update_tindakan_sampel(int $id, array $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete_tindakan_sampel(int $id)
    {
        // Instead of deleting, we can just deactivate
        $this->db->where('id', $id);
        return $this->db->update($this->table, ['is_active' => 0]);
    }

    public function get_tindakan_sampel_name_by_id(int $id): ?string
    {
        $result = $this->db->select('nama')->get_where($this->table, ['id' => $id])->row_array();
        return $result['nama'] ?? null;
    }
}
