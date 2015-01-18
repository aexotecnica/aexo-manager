<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('M_Usuario','',TRUE);
		date_default_timezone_set("America/Argentina/Buenos_Aires");

	}

	public function index()
	{
		$this->load->view('view_login.php', NULL);
	}

	function autenticar($offset = 0){
		$uri_segment = 3;
		$offset = $this->uri->segment($uri_segment);
		$valido = false;
		$user = $this->M_Usuario->login($this->input->post('username'), $this->input->post('password'))->result();
		//var_dump($user);
//		echo count($user);
		if (count($user) == 1){
			$this->session->set_userdata('usuario',$user);
			redirect(base_url(). 'index.php/flujoCaja/', 'refresh');
		} else 
			$this->load->view('view_login', '');
		
	}

	function remover($offset = 0){
		$this->session->unset_userdata('usuario');
		$this->load->view('view_login', '');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */