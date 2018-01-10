<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class berita extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('akademik/berita_model','berita');
		$this->load->library(array('template'));
	}

	public function index()
	{
		//$this->load->helper('url');
		$this->template->display('akademik/berita_view');
	}

	public function show_berita_DT()
	{
		$this->load->helper('url');

		$list = $this->berita->show_berita_DT();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $berita) {
			$no++;
			$row = array();
			$row[] = "<div class='text-center'>".$no."</div>";
			$row[] = $berita->id_berita;
			$row[] = $berita->judul_berita;
			$row[] = $berita->deskripsi;
			$row[] = $berita->tgl_posting;
			if($berita->file != ''){
				$file = '<a href="'.base_url('berita/'.$berita->file).'" data-fancybox="images"><img style="width: 100px; height:125px"  src="'.base_url('berita/'.$berita->file).'" class="img-responsive" /></a>';
			}
			else
			{
				$file = '(No file)';
			}
			
			$row[] = $file;
			//add html for action
			$row[] = '<a class="btn btn-warning" onclick="update_berita('."'".$berita->id_berita."'".')">Edit</a>
				  <a class="btn  btn-danger" onclick="hapus_berita('."'".$berita->id_berita."'".')">Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->berita->count_all_show_berita_DT(),
						"recordsFiltered" => $this->berita->count_filtered_show_berita_DT(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->berita->get_by_id($id);
		//$data->tgl_posting = ($data->tgl_posting == '0000-00-00') ? '' : $data->tgl_posting; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	public function tambah_berita()
	{
		$this->_validate();
		
		$data = array(
				'judul_berita' => $this->input->post('judul_berita'),
				'deskripsi' => $this->input->post('deskripsi'),
				'tgl_posting' => strtotime('now'),
			);

		if(!empty($_FILES['file']['name']))
		{
			$upload = $this->_do_upload();
			$data['file'] = $upload;
		}

		$insert = $this->berita->tambah_berita($data);

		echo json_encode(array("status" => TRUE));
	}

	public function update_berita()
	{
		$this->_validate();
		$data = array(
				'judul_berita' => $this->input->post('judul_berita'),
				'deskripsi' => $this->input->post('deskripsi'),
				'tgl_posting' => $this->input->post('tgl_posting'),
			);

		if($this->input->post('remove_photo')) // if remove photo checked
		{
			if(file_exists('berita/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
				unlink('berita/'.$this->input->post('remove_photo'));
			$data['file'] = '';
		}

		if(!empty($_FILES['file']['name']))
		{
			$upload = $this->_do_upload();
			
			//delete file
			$berita = $this->berita->get_by_id($this->input->post('id_berita'));
			if(file_exists('berita/'.$berita->file) && $berita->file)
				unlink('berita/'.$berita->file);

			$data['file'] = $upload;
		}

		$this->berita->update_berita(array('id_berita' => $this->input->post('id_berita')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function hapus_berita($id)
	{
		//delete file
		$berita = $this->berita->get_by_id($id);
		if(file_exists('berita/'.$berita->file) && $berita->file)
			unlink('berita/'.$berita->file);
		
		$this->berita->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _do_upload()
	{
		$config['upload_path']          = 'berita/';
        $config['allowed_types']        = 'gif|jpg|png|pdf';
        $config['max_size']             = 100000; //set max size allowed in Kilobyte
        $config['max_width']            = 2000; // set max width image allowed
        $config['max_height']           = 3000; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('file')) //upload and validate
        {
            $data['inputerror'][] = 'file';
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

		if($this->input->post('judul_berita') == '')
		{
			$data['inputerror'][] = 'judul_berita';
			$data['error_string'][] = 'Judul Berita harus diisi';
			$data['status'] = FALSE;
		}

		if($this->input->post('deskripsi') == '')
		{
			$data['inputerror'][] = 'deskripsi';
			$data['error_string'][] = 'Deskripsi harus diisi';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}
