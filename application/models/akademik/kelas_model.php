<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kelas_model extends CI_Model{

	var $table = 'kelas';

	public function tambah_kelas($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function get_all_kelas()
	{
		$this->db->from('kelas');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_kelas', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function update_kelas($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id_kelas)
	{
		$this->db->where('id_kelas', $id_kelas);
		$this->db->delete($this->table);
	}
}
