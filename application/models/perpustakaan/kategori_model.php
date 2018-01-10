<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kategori_model extends CI_Model{

	var $table = 'kategori';

	public function tambah_kategori($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function get_all_kategori()
	{
		$this->db->from('kategori');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_kategori', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function update_kategori($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id_kategori)
	{
		$this->db->where('id_kategori', $id_kategori);
		$this->db->delete($this->table);
	}
}
