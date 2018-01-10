<?php
class login extends CI_Controller{
    
    function __construct(){
		parent::__construct();		
		$this->load->model('login_model');
 
	}
 
	function index(){
		$this->load->view('login');
	}
 
	function proses(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$where = array(
			'username' => $username,
			'password' => md5($password)
			);
		$cek = $this->login_model->cek_login("admin",$where)->num_rows();
		if($cek > 0){
 
			$data_session = array(
				'nama_lengkap' => $username,
				'status' => "login"
				);
 
			$this->session->set_userdata($data_session);
 
			redirect(base_url("dashboard"));
 
		}else{
			echo "Username dan password salah !";
		}
	}
 
	function logout(){
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}
}