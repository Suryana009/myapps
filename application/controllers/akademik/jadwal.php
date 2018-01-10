<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class jadwal extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('akademik/jadwal_model','jadwal');
		$this->load->library(array('template'));
	}

	public function index()
	{
		$this->load->helper('url');
		$data['guru'] = $this->jadwal->get_guru();
		$data['kelas'] = $this->jadwal->get_kelas();
		$this->template->display('akademik/jadwal_view', $data);
	}

	public function show_jadwal_DT()
	{
		$this->load->helper('url');

		$list = $this->jadwal->show_jadwal_DT();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $jadwal) {
			$no++;
			$row = array();
			$row[] = "<div class='text-center'>".$no."</div>";
			$row[] = $jadwal->id_jadwal;
			$row[] = $jadwal->nama_lengkap;
			$row[] = $jadwal->mapel;
			$row[] = $jadwal->kelas;
			$row[] = $jadwal->hari;
			$row[] = $jadwal->jam;
			$row[] = '<a class="btn btn-warning" onclick="update_jadwal('."'".$jadwal->id_jadwal."'".')">Edit</a>
				  <a class="btn  btn-danger" onclick="hapus_jadwal('."'".$jadwal->id_jadwal."'".')">Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->jadwal->count_all_show_jadwal_DT(),
						"recordsFiltered" => $this->jadwal->count_filtered_show_jadwal_DT(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->jadwal->get_by_id($id);
		echo json_encode($data);
	}

	public function tambah_jadwal()
	{
		$this->_validate();
		
		$data = array(
				'id_guru'		=> $this->input->post('id_guru'),
				'id_kelas' 		=> $this->input->post('id_kelas'),
				'hari' 			=> $this->input->post('hari'),
				'jam' 			=> $this->input->post('jam'),
			);

		$insert = $this->jadwal->tambah_jadwal($data);

		echo json_encode(array("status" => TRUE));
	}

	public function update_jadwal()
	{
		$this->_validate();
		$data = array(
				'id_guru'		=> $this->input->post('id_guru'),
				'id_kelas' 		=> $this->input->post('id_kelas'),
				'hari' 			=> $this->input->post('hari'),
				'jam' 			=> $this->input->post('jam'),
			);

		$this->jadwal->update_jadwal(array('id_jadwal' => $this->input->post('id_jadwal')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function hapus_jadwal($id)
	{	
		$this->jadwal->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('id_guru') == '')
		{
			$data['inputerror'][] = 'id_guru';
			$data['error_string'][] = 'Nama guru harus dipilih';
			$data['status'] = FALSE;
		}

		if($this->input->post('id_kelas') == '')
		{
			$data['inputerror'][] = 'id_kelas';
			$data['error_string'][] = 'Nama kelas harus dipilih';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('hari') == '')
		{
			$data['inputerror'][] = 'hari';
			$data['error_string'][] = 'Hari harus diisi';
			$data['status'] = FALSE;
		}

		if($this->input->post('jam') == '')
		{
			$data['inputerror'][] = 'jam';
			$data['error_string'][] = 'Hari harus diisi';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}
