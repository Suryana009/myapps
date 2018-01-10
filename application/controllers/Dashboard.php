<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dashboard extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
		$this->load->library(array('template'));
        $this->load->library(array('form_validation','template'));
        
        if(!$this->session->userdata('nama_lengkap')){
            redirect('login');
        }
	}

	public function index()
	{
		$this->template->display('dashboard/dashboard');
	}
}