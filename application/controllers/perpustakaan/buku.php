<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class buku extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('perpustakaan/buku_model');
		$this->load->library(array('template'));
	}

	public function index()
	{
		$data['buku'] = $this->buku_model->get_all_buku();
		$data['kategori'] = $this->buku_model->get_kategori();
		$data['lokasi'] = $this->buku_model->get_lokasi();
		$this->template->display('perpustakaan/buku_view', $data);
	}

	public function tambah_buku()
	{
		$data = array(
				'judul' => $this->input->post('judul'),
				'pengarang' => $this->input->post('pengarang'),
				'id_kategori' => $this->input->post('id_kategori'),
				'id_lokasi' => $this->input->post('id_lokasi'),
				'isbn' => $this->input->post('isbn'),
				'id_buku' => $this->input->post('id_buku'),
			);

		$insert = $this->buku_model->tambah_buku($data);
		echo json_encode(array("status" => true));
	}

	public function ajax_edit($id)
	{
		$data = $this->buku_model->get_by_id($id);
		echo json_encode($data);
	}

	public function update_buku()
	{
		$data = array(
			'judul' => $this->input->post('judul'),
			'pengarang' => $this->input->post('pengarang'),
			'id_kategori' => $this->input->post('id_kategori'),
			'id_lokasi' => $this->input->post('id_lokasi'),
			'isbn' => $this->input->post('isbn'),
			);
		$this->buku_model->update_buku(array('id_buku' => $this->input->post('id_buku')), $data);
		echo json_encode(array("status" => true));
	}

	public function hapus_buku($id_buku)
	{
		$this->buku_model->delete_by_id($id_buku);
		echo json_encode(array("status" => true));
	}

}