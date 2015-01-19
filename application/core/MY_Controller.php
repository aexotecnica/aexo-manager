<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

	private $data;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');

		$this->load->model('M_ComprobanteVenta','',TRUE);
		$this->load->model('M_ComprobanteCompra','',TRUE);

		date_default_timezone_set("America/Argentina/Buenos_Aires");

		if ($this->session->userdata('usuario') == FALSE)
			redirect(base_url(). 'index.php/login', 'refresh');

		$saldoVta = $this->M_ComprobanteVenta->get_saldoVenta();
		$saldoVta= $saldoVta[0];

		$saldoCpr = $this->M_ComprobanteCompra->get_saldoCompra();
		$saldoCpr = $saldoCpr[0];

		$this->data['saldoVenta'] = $saldoVta->saldoVenta;
		$this->data['saldoCompra'] = $saldoCpr->saldoCompra;
    }

    public function get_saldoVenta(){
    	return $this->data['saldoVenta'];
    }

    public function cargarTemplate($data){
    	$data['saldoVenta'] = $this->data['saldoVenta'];
    	$data['saldoCompra'] = $this->data['saldoCompra'];

		$usuario = $this->session->userdata('usuario');
		$data['nombreUsuario'] = $usuario[0]->nombre;
		$data['apellidoUsuario']= $usuario[0]->apellido;
		$data['usuario']= $usuario[0]->username;
    	//$data['nombreUsuario'] = $this->data['nombreUsuario'];
    	//$data['apellidoUsuario'] = $this->data['apellidoUsuario'];
		$this->load->view('view_template.php', $data);
    }
    
} 