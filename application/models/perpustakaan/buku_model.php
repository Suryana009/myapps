<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class buku_model extends CI_Model{

	var $table = 'buku';

	public function tambah_buku($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function get_all_buku()
	{
		$this->db->from('buku');
		$this->db->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left');
		$this->db->join('lokasi', 'lokasi.id_lokasi = buku.id_lokasi', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_kategori()
	{
		$this->db->from('kategori');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_lokasi()
	{
		$this->db->from('lokasi');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_buku', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function update_buku($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id_buku)
	{
		$this->db->where('id_buku', $id_buku);
		$this->db->delete($this->table);
	}
}
