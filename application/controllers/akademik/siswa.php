<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class siswa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('akademik/siswa_model','siswa');
		$this->load->library(array('template'));
	}

	public function index()
	{
		//$this->load->helper('url');
		$data['kelas'] = $this->siswa->get_all_kelas();
		$this->template->display('akademik/siswa_view', $data);
	}

	public function show_siswa_DT()
	{
		$this->load->helper('url');

		$list = $this->siswa->show_siswa_DT();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $siswa) {
			$no++;
			$row = array();
			$row[] = "<div class='text-center'>".$no."</div>";
			$row[] = $siswa->id_siswa;
			$row[] = $siswa->nip;
			$row[] = $siswa->nama_lengkap;
			$row[] = substr($siswa->alamat, 0, 20);
			$row[] = $siswa->kelas;
			$row[] = $siswa->email;
			
			$row[] = '<a class="btn btn-warning" onclick="update_siswa('."'".$siswa->id_siswa."'".')">Edit</a>
				  <a class="btn  btn-danger" onclick="hapus_siswa('."'".$siswa->id_siswa."'".')">Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->siswa->count_all_show_siswa_DT(),
						"recordsFiltered" => $this->siswa->count_filtered_show_siswa_DT(),
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
		//$this->_validate();
		
		$data = array(
				'nip' 				=> $this->input->post('nip'),
				'nama_lengkap' 		=> $this->input->post('nama_lengkap'),
				'alamat' 			=> $this->input->post('alamat'),
				'tempat_lahir' 		=> $this->input->post('tempat_lahir'),
				'tanggal_lahir' 	=> $this->input->post('tanggal_lahir'),
				'agama' 			=> $this->input->post('agama'),
				'telp'	 			=> $this->input->post('telp'),
				'email' 			=> $this->input->post('email'),
				'password' 			=> $this->input->post('password'),
				'id_kelas' 			=> $this->input->post('id_kelas'),
				'status_siswa' 		=> $this->input->post('status_siswa'),
			);

		if(!empty($_FILES['foto_siswa']['name']))
		{
			$upload = $this->_do_upload();
			$data['foto_siswa'] = $upload;
		}

		$insert = $this->siswa->tambah_siswa($data);

		echo json_encode(array("status" => TRUE));
	}

	public function update_siswa()
	{
		$this->_validate();
		$data = array(
				'nip' 				=> $this->input->post('nip'),
				'nama_lengkap' 		=> $this->input->post('nama_lengkap'),
				'alamat' 			=> $this->input->post('alamat'),
				'tempat_lahir' 		=> $this->input->post('tempat_lahir'),
				'tanggal_lahir' 	=> $this->input->post('tanggal_lahir'),
				'agama' 			=> $this->input->post('agama'),
				'hobby' 			=> $this->input->post('hobby'),
				'telp'	 			=> $this->input->post('telp'),
				'email' 			=> $this->input->post('email'),
				'password' 			=> $this->input->post('password'),
				'id_kelas' 			=> $this->input->post('id_kelas'),
				'status_siswa' 		=> $this->input->post('status_siswa'),
			);

		if($this->input->post('remove_photo')) // if remove photo checked
		{
			if(file_exists('foto_siswa/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
				unlink('foto_siswa/'.$this->input->post('remove_photo'));
			$data['foto_siswa'] = '';
		}

		if(!empty($_FILES['foto_siswa']['name']))
		{
			$upload = $this->_do_upload();
			
			//delete file
			$siswa = $this->siswa->get_by_id($this->input->post('id_siswa'));
			if(file_exists('foto_siswa/'.$siswa->foto_siswa) && $siswa->foto_siswa)
				unlink('foto_siswa/'.$siswa->foto_siswa);

			$data['foto_siswa'] = $upload;
		}

		$this->siswa->update_siswa(array('id_siswa' => $this->input->post('id_siswa')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function hapus_siswa($id)
	{
		//delete file
		$siswa = $this->siswa->get_by_id($id);
		if(file_exists('foto_siswa/'.$siswa->foto_siswa) && $siswa->foto_siswa)
			unlink('siswa/'.$siswa->foto_siswa);
		
		$this->siswa->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _do_upload()
	{
		$config['upload_path']          = 'foto_siswa/';
        $config['allowed_types']        = 'gif|jpg|png|pdf';
        $config['max_size']             = 100000; //set max size allowed in Kilobyte
        $config['max_width']            = 2000; // set max width image allowed
        $config['max_height']           = 3000; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('foto_siswa')) //upload and validate
        {
            $data['inputerror'][] = 'foto_siswa';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nip') == '')
		{
			$data['inputerror'][] = 'nip';
			$data['error_string'][] = 'Nomor Induk harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('nama_lengkap') == '')
		{
			$data['inputerror'][] = 'nama_lengkap';
			$data['error_string'][] = 'Nama Lengkap Siswa harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('alamat') == '')
		{
			$data['inputerror'][] = 'alamat';
			$data['error_string'][] = 'Alamat harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('tempat_lahir') == '')
		{
			$data['inputerror'][] = 'tempat_lahir';
			$data['error_string'][] = 'Tempat Lahir harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('tanggal_lahir') == '')
		{
			$data['inputerror'][] = 'tanggal_lahir';
			$data['error_string'][] = 'Tanggal Lahir harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('agama') == '')
		{
			$data['inputerror'][] = 'agama';
			$data['error_string'][] = 'Agama harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('hobby') == '')
		{
			$data['inputerror'][] = 'hobby';
			$data['error_string'][] = 'Hobby harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('telp') == '')
		{
			$data['inputerror'][] = 'telp';
			$data['error_string'][] = 'Nomor Telepon Siswa harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('email') == '')
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('password') == '')
		{
			$data['inputerror'][] = 'password';
			$data['error_string'][] = 'Password harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('id_kelas') == '')
		{
			$data['inputerror'][] = 'id_kelas';
			$data['error_string'][] = 'Kelas harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('status_siswa') == '')
		{
			$data['inputerror'][] = 'status_siswa';
			$data['error_string'][] = 'Status Siswa harus diisi';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}
