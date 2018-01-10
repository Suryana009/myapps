<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kelas extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('akademik/kelas_model');
		$this->load->library(array('template'));
	}

	public function index()
	{
		$data['kelas'] = $this->kelas_model->get_all_kelas();
		$this->template->display('akademik/kelas_view', $data);
	}

	public function tambah_kelas()
	{
		$data = array(
				'kelas' => $this->input->post('kelas'),
				'id_kelas' => $this->input->post('id_kelas'),
			);

		$insert = $this->kelas_model->tambah_kelas($data);
		echo json_encode(array("status" => true));
	}

	public function ajax_edit($id)
	{
		$data = $this->kelas_model->get_by_id($id);
		echo json_encode($data);
	}

	public function update_kelas()
	{
		$data = array(
			'kelas' => $this->input->post('kelas'),
			);
		$this->kelas_model->update_kelas(array('id_kelas' => $this->input->post('id_kelas')), $data);
		echo json_encode(array("status" => true));
	}

	public function hapus_kelas($id_kelas)
	{
		$this->kelas_model->delete_by_id($id_kelas);
		echo json_encode(array("status" => true));
	}

}