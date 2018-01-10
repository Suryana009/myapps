<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class siswa_model extends CI_Model {

	var $table = 'absen_siswa';
	var $column_order = array('null','id_absen', 'nama_lengkap','kelas','tanggal','absen'); //set column field database for datatable orderable
	var $column_search = array('id_absen', 'nama_lengkap','kelas','tanggal','absen'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('id_absen' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _show_absen_siswa_DT()
	{
		
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('siswa', 'siswa.id_siswa = absen_siswa.id_siswa', 'left');
		$this->db->join('kelas', 'kelas.id_kelas = absen_siswa.id_kelas', 'left');

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function show_absen_siswa_DT()
	{
		$this->_show_absen_siswa_DT();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_show_absen_siswa_DT()
	{
		$this->_show_absen_siswa_DT();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_show_absen_siswa_DT()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_absen',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function tambah_siswa($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update_siswa($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id_absen', $id);
		$this->db->delete($this->table);
	}

	public function get_kelas()
	{
		$this->db->from('kelas');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_siswa()
	{
		$this->db->from('siswa');
		$query = $this->db->get();
		return $query->result();
	}

}
