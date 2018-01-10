<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ebook extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('perpustakaan/ebook_model','ebook');
		$this->load->library(array('template'));
	}

	public function index()
	{
		//$this->load->helper('url');
		$data['kategori'] = $this->ebook->get_kategori();
		$this->template->display('perpustakaan/ebook_view', $data);
	}

	public function show_ebook_DT()
	{
		$this->load->helper('url');

		$list = $this->ebook->show_ebook_DT();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $ebook) {
			$no++;
			$row = array();
			$row[] = "<div class='text-center'>".$no."</div>";
			$row[] = $ebook->id_ebook;
			$row[] = $ebook->judul;
			$row[] = $ebook->deskripsi;
			$row[] = $ebook->kategori;
			if($ebook->gambar != ''){
				$gambar = '<a href="'.base_url('ebook/'.$ebook->gambar).'" data-fancybox="images"><img style="width: 100px; height:125px"  src="'.base_url('ebook/'.$ebook->gambar).'" class="img-responsive" /></a>';
			}
			else
			{
				$gambar = '(No file)';
			}
			
			$row[] = $gambar;
			
			if($ebook->file != ''){
				$file = '<a href="'.base_url('ebook/'.$ebook->file).'" target="_blank">Lihat File</a>';
			}
			else
			{
				$file = '(No file)';
			}
			
			$row[] = $file;
			//add html for action
			$row[] = '<a class="btn btn-warning" onclick="update_ebook('."'".$ebook->id_ebook."'".')">Edit</a>
				  <a class="btn  btn-danger" onclick="hapus_ebook('."'".$ebook->id_ebook."'".')">Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->ebook->count_all_show_ebook_DT(),
						"recordsFiltered" => $this->ebook->count_filtered_show_ebook_DT(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->ebook->get_by_id($id);
		echo json_encode($data);
	}

	public function tambah_ebook()
	{
		$this->_validate();
		
		$data = array(
				'judul'				=> $this->input->post('judul'),
				'deskripsi' 		=> $this->input->post('deskripsi'),
				'id_kategori' 		=> $this->input->post('id_kategori'),
			);
		if(!empty($_FILES['gambar']['name']))
		{
			$upload = $this->_do_upload_gambar();
			$data['gambar'] = $upload;
		}
		
		if(!empty($_FILES['file']['name']))
		{
			$upload = $this->_do_upload_file();
			$data['file'] = $upload;
		}

		$insert = $this->ebook->tambah_ebook($data);

		echo json_encode(array("status" => TRUE));
	}

	public function update_ebook()
	{
		$this->_validate();
		$data = array(
				'judul'				=> $this->input->post('judul'),
				'deskripsi' 		=> $this->input->post('deskripsi'),
				'id_kategori' 		=> $this->input->post('id_kategori'),
			);

		if($this->input->post('remove_photo')) // if remove photo checked
		{
			if(file_exists('ebook/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
				unlink('ebook/'.$this->input->post('remove_photo'));
			$data['gambar'] = '';
		}

		if(!empty($_FILES['gambar']['name']))
		{
			$upload = $this->_do_upload_gambar();
			
			//delete file
			$ebook = $this->ebook->get_by_id($this->input->post('id_ebook'));
			if(file_exists('ebook/'.$ebook->gambar) && $ebook->gambar)
				unlink('ebook/'.$ebook->gambar);

			$data['gambar'] = $upload;
		}
		
		if($this->input->post('remove_pdf')) // if remove photo checked
		{
			if(file_exists('ebook/'.$this->input->post('remove_pdf')) && $this->input->post('remove_pdf'))
				unlink('ebook/'.$this->input->post('remove_pdf'));
			$data['file'] = '';
		}

		if(!empty($_FILES['file']['name']))
		{
			$upload = $this->_do_upload_file();
			
			//delete file
			$ebook = $this->ebook->get_by_id($this->input->post('id_ebook'));
			if(file_exists('ebook/'.$ebook->file) && $ebook->file)
				unlink('ebook/'.$ebook->file);

			$data['file'] = $upload;
		}

		$this->ebook->update_ebook(array('id_ebook' => $this->input->post('id_ebook')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function hapus_ebook($id)
	{
		//delete file
		$gambar = $this->ebook->get_by_id($id);
		if(file_exists('ebook/'.$gambar->gambar) && $gambar->gambar)
			unlink('ebook/'.$gambar->gambar);
		
		$ebook = $this->ebook->get_by_id($id);
		if(file_exists('ebook/'.$ebook->file) && $ebook->file)
			unlink('ebook/'.$ebook->file);
		
		$this->ebook->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _do_upload_gambar()
	{
		$config['upload_path']          = 'ebook/';
        $config['allowed_types']        = 'gif|jpg|png|pdf';
        $config['max_size']             = 100000; //set max size allowed in Kilobyte
        $config['max_width']            = 2000; // set max width image allowed
        $config['max_height']           = 3000; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('gambar')) //upload and validate
        {
            $data['inputerror'][] = 'gambar';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
		
		if(!$this->upload->do_upload('gambar')) //upload and validate
        {
            $data['inputerror'][] = 'gambar';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}
	
	private function _do_upload_file()
	{
		$config['upload_path']          = 'ebook/';
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

		if($this->input->post('judul') == '')
		{
			$data['inputerror'][] = 'judul';
			$data['error_string'][] = 'Judul Ebook harus diisi';
			$data['status'] = FALSE;
		}

		if($this->input->post('deskripsi') == '')
		{
			$data['inputerror'][] = 'deskripsi';
			$data['error_string'][] = 'Deskripsi harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('id_kategori') == '')
		{
			$data['inputerror'][] = 'id_kategori';
			$data['error_string'][] = 'Kategori harus dipilih';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}
