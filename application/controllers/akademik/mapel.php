<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mapel extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('akademik/mapel_model','mapel');
		$this->load->library(array('template'));
	}

	public function index()
	{
		$this->load->helper('url');
		//$data['guru'] = $this->jadwal->get_guru();
		//$data['kelas'] = $this->jadwal->get_kelas();
		$this->template->display('akademik/mapel_view');
	}

	public function show_mapel_DT()
	{
		$this->load->helper('url');

		$list = $this->mapel->show_mapel_DT();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $mapel) {
			$no++;
			$row = array();
			$row[] = "<div class='text-center'>".$no."</div>";
			$row[] = $mapel->id_mapel;
			$row[] = $mapel->mapel;
			$row[] = '<a class="btn btn-warning" onclick="update_mapel('."'".$mapel->id_mapel."'".')">Edit</a>
				  <a class="btn  btn-danger" onclick="hapus_mapel('."'".$mapel->id_mapel."'".')">Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->mapel->count_all_show_mapel_DT(),
						"recordsFiltered" => $this->mapel->count_filtered_show_mapel_DT(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->mapel->get_by_id($id);
		echo json_encode($data);
	}

	public function tambah_mapel()
	{
		$this->_validate();
		
		$data = array(
				'mapel'		=> $this->input->post('mapel'),
			);

		$insert = $this->mapel->tambah_mapel($data);

		echo json_encode(array("status" => TRUE));
	}

	public function update_mapel()
	{
		$this->_validate();

		$data = array(
				'mapel'		=> $this->input->post('mapel'),
			);

		$this->mapel->update_mapel(array('id_mapel' => $this->input->post('id_mapel')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function hapus_mapel($id)
	{	
		$this->mapel->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('mapel') == '')
		{
			$data['inputerror'][] = 'mapel';
			$data['error_string'][] = 'Mata Pelajaran harus dipilih';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}
