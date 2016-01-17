<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');
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
		$user = $this->M_Usuario->login($this->input->post('username'), $this->input->post('password'));

		if (count($user) == 1){
			$this->session->set_userdata('usuario',$user);
			

			$acciones = $this->M_Usuario->get_acciones($user[0]->idRol)->result();

			$this->session->set_userdata('permisos',$acciones);

			if (ENVIRONMENT == 'testing') return true;
			redirect(base_url(). 'index.php/flujoCaja/', 'refresh');
		} else 
			$this->load->view('view_login', '');
			return false;
		
	}

	function remover($offset = 0){
		$this->session->unset_userdata('usuario');
		$this->session->unset_userdata('permisos');
		$this->load->view('view_login', '');
	}

	function sinPermisos(){
		$out = $this->load->view('view_sinPermisos.php', NULL, TRUE);
		$data['cuerpo'] = $out;

    	$data['saldoVenta'] = "";
    	$data['saldoCompra'] = "";
    	$this->data['permiso'] = "";

		$usuario = $this->session->userdata('usuario');

		//var_dump($permisos); 

		$data['nombreUsuario'] = $usuario[0]->nombre;
		$data['apellidoUsuario']= $usuario[0]->apellido;
		$data['usuario']= $usuario[0]->username;


		$this->load->view('view_template.php', $data);
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */