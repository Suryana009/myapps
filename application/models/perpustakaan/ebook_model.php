<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ebook_model extends CI_Model {

	var $table = 'ebook';
	var $column_order = array('null','id_ebook', 'judul','deskripsi','kategori','gambar','file'); //set column field database for datatable orderable
	var $column_search = array('id_ebook', 'judul','deskripsi','kategori','gambar','file'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('id_ebook' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _show_ebook_DT()
	{
		
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('kategori', 'kategori.id_kategori = ebook.id_kategori', 'left');

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

	function show_ebook_DT()
	{
		$this->_show_ebook_DT();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_show_ebook_DT()
	{
		$this->_show_ebook_DT();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_show_ebook_DT()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_ebook',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function tambah_ebook($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update_ebook($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id_ebook', $id);
		$this->db->delete($this->table);
	}

	public function get_kategori()
	{
		$this->db->from('kategori');
		$this->db->where('ebook', 1);
		$query = $this->db->get();
		return $query->result();
	}

}
