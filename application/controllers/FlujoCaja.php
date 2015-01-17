<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FlujoCaja extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('M_TipoMovimiento','',TRUE);
		$this->load->model('M_Evento','',TRUE);
		$this->load->model('M_Movimiento','',TRUE);

	}

	public function index()
	{
		$out = $this->load->view('view_calendarCaja.php', NULL, TRUE);
		$data['cuerpo'] = $out;
		$this->load->view('view_template.php', $data);
	}

	public function getMovimientosDelMes(){
		date_default_timezone_set('America/Los_Angeles');
		$movimientosDelMes = $this->M_Movimiento->get_saldoCalendario(1,2015);

		foreach ($movimientosDelMes as $key => $value) {
			$objeto = new M_Evento();
			$objeto->title= $value->acumulado;
			$objeto->start = $value->fechaPago;
			
			

			if (sizeof($movimientosDelMes) > $key +1 ){
				$proximo = $movimientosDelMes[$key+1];
				$objeto->end= strtotime ( '-1 day' , strtotime ( $proximo->fechaPago) ) ;	
			}else{
				$objeto->end=$value->fechaPago;
			}
			if ($value->acumulado > 0)
				$objeto->backgroundColor= "#33C276";
			else 
				$objeto->backgroundColor= "#D23C25";

			$objeto->url = base_url() . 'index.php/ingresoMovimiento/traerMovimientos/' . date("Y-m-d",strtotime($objeto->start));

			$dato[$key] = $objeto;
		}

		echo json_encode($dato);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */