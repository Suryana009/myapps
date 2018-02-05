<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class siswa extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('absensi/siswa_model','siswa');
		$this->load->library(array('template'));
	}

	public function index()
	{
		$this->load->helper('url');
		$data['kelas'] = $this->siswa->get_kelas();
		$data['siswa'] = $this->siswa->get_siswa();
		$this->template->display('absensi/siswa_view', $data);
	}

	public function show_absen_siswa_DT()
	{
		$this->load->helper('url');

		$list = $this->siswa->show_absen_siswa_DT();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $siswa) {
			$no++;
			$row = array();
			$row[] = "<div class='text-center'>".$no."</div>";
			$row[] = $siswa->id_absen;
			$row[] = $siswa->nama_lengkap;
			$row[] = $siswa->kelas;
			$row[] = $siswa->tanggal;
			$row[] = $siswa->absen;
			$row[] = '<a class="btn btn-warning" onclick="update_siswa('."'".$siswa->id_absen."'".')">Edit</a>
				  <a class="btn  btn-danger" onclick="hapus_siswa('."'".$siswa->id_absen."'".')">Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->siswa->count_all_show_absen_siswa_DT(),
						"recordsFiltered" => $this->siswa->count_filtered_show_absen_siswa_DT(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->siswa->get_by_id($id);
		echo json_encode($data);
	}

	public function tambah_siswa()
	{
		$this->_validate();
		
		$data = array(
				'id_siswa'		=> $this->input->post('id_siswa'),
				'id_kelas' 		=> $this->input->post('id_kelas'),
				'tanggal' 		=> $this->input->post('tanggal'),
				'absen' 		=> $this->input->post('absen'),
			);

		$insert = $this->siswa->tambah_siswa($data);

		echo json_encode(array("status" => TRUE));
	}

	public function get_siswa_data()
	{
		$modul=$this->input->post('modul');
		$id=$this->input->post('id');

		if($modul=="siswa"){
			$this->siswa->get_siswa_data($id);
		}
	}

	public function update_siswa()
	{
		$this->_validate();
		$data = array(
				'id_siswa'		=> $this->input->post('id_siswa'),
				'id_kelas' 		=> $this->input->post('id_kelas'),
				'tanggal' 		=> $this->input->post('tanggal'),
				'absen' 		=> $this->input->post('absen'),
			);

		$this->siswa->update_siswa(array('id_absen' => $this->input->post('id_absen')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function hapus_siswa($id)
	{	
		$this->siswa->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('id_kelas') == '')
		{
			$data['inputerror'][] = 'id_kelas';
			$data['error_string'][] = 'Kelas harus dipilih';
			$data['status'] = FALSE;
		}

		if($this->input->post('id_siswa') == '')
		{
			$data['inputerror'][] = 'id_siswa';
			$data['error_string'][] = 'Siswa harus dipilih';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('tanggal') == '')
		{
			$data['inputerror'][] = 'tanggal';
			$data['error_string'][] = 'Tanggal harus diisi';
			$data['status'] = FALSE;
		}

		if($this->input->post('absen') == '')
		{
			$data['inputerror'][] = 'absen';
			$data['error_string'][] = 'Absen harus diisi';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}
