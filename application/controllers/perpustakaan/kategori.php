<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kategori extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('perpustakaan/kategori_model');
		$this->load->library(array('template'));
	}

	public function index()
	{
		$data['kategori'] = $this->kategori_model->get_all_kategori();
		$this->template->display('perpustakaan/kategori_view', $data);
	}

	public function tambah_kategori()
	{
		$data = array(
				'kategori' => $this->input->post('kategori'),
				'berita' => $this->input->post('berita'),
				'buku' => $this->input->post('buku'),
				'ebook' => $this->input->post('ebook'),
				'id_kategori' => $this->input->post('id_kategori'),
			);

		$insert = $this->kategori_model->tambah_kategori($data);
		echo json_encode(array("status" => true));
	}

	public function ajax_edit($id)
	{
		$data = $this->kategori_model->get_by_id($id);
		echo json_encode($data);
	}

	public function update_kategori()
	{
		$data = array(
				'kategori' => $this->input->post('kategori'),
				'berita' => $this->input->post('berita'),
				'buku' => $this->input->post('buku'),
				'ebook' => $this->input->post('ebook'),
			);
		$this->kategori_model->update_kategori(array('id_kategori' => $this->input->post('id_kategori')), $data);
		echo json_encode(array("status" => true));
	}

	public function hapus_kategori($id_kategori)
	{
		$this->kategori_model->delete_by_id($id_kategori);
		echo json_encode(array("status" => true));
	}

}