<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AjaxTemplate extends CI_Controller {

	private $permiso_autorizaPago;
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('M_MedioPago','',TRUE);
		$this->load->model('M_Notificacion','',TRUE);
		$this->load->library('session');
		date_default_timezone_set("America/Argentina/Buenos_Aires");

		$permisos = $this->session->userdata('permisos');
		$this->permiso_autorizaPago = array_filter($permisos,
			function ($e) {
				return $e->label == '[AUTORIZAPAGO]';
			});


	}

	public function traerNotificaciones(){

		$mensajes = array();
		$notificacion = $this->getPagosPendientesAutorizar();
		if ($notificacion != NULL)
			array_push($mensajes, $notificacion);

		$notificaciones = array("cantidad" => count($mensajes), "mensajes"=> $mensajes);
		echo json_encode($notificaciones);
	}

	function getPagosPendientesAutorizar(){
		$notificacion = NULL;
		if ($this->permiso_autorizaPago != NULL) {
			$pagos = $this->M_MedioPago->find(NULL,NULL,ESTADOPAGO_PENDAUTORIZAR)->result();
			if (count($pagos)> 0){
				$notificacion = new M_Notificacion();
				$notificacion->mensaje = "Posee ". count($pagos) ." pagos para autorizar";
				$notificacion->url = base_url() . "index.php/mediosDePago/traerPendientesAutorizar";
			}
		}

		return $notificacion;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */