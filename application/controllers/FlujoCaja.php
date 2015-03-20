<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FlujoCaja extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_TipoMovimiento','',TRUE);
		$this->load->model('M_Evento','',TRUE);
		$this->load->model('M_Movimiento','',TRUE);
	}

	public function index()
	{
		$out = $this->load->view('view_calendarCaja.php', NULL, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function getMovimientosDelMes(){
		$movimientosDelMes = $this->M_Movimiento->get_saldoCalendario($this->input->post('mes'),$this->input->post('anio'));
		$dato = "";
		foreach ($movimientosDelMes as $key => $value) {
			$objeto = new M_Evento();
			$objeto->title= number_format(  $value->acumulado, 2, ".", "," );
			//echo $this->input->post('anio') .'-' . $this->input->post('mes') . '-1';
			$primerDiaDelMes = DateTime::createFromFormat('Y-m-d',$this->input->post('anio') .'-' . $this->input->post('mes') . '-1');
			$primerDiaDelMes->modify('first day of this month');

			$ultimoDiaDelMes = DateTime::createFromFormat('Y-m-d',$this->input->post('anio') .'-' . $this->input->post('mes') . '-1');
			$ultimoDiaDelMes->modify('last day of this month');

			$fechaBd = new DateTime(date("Y-m-d",strtotime($value->fechaPago)));
			$fechaBd->modify('first day of this month');



			if ($key == 0 &&  $primerDiaDelMes->format('Y-m-d')  != $fechaBd->format('Y-m-d'))
				$objeto->start = $primerDiaDelMes->format('Y-m-d'); //$value->fechaPago;
			else
				$objeto->start = $value->fechaPago;

			if (sizeof($movimientosDelMes) > $key +1 ){
				$proximo = $movimientosDelMes[$key+1];
				$objeto->end= strtotime ( '-1 day' , strtotime ( $proximo->fechaPago) ) ;	
			}else{
				//$objeto->end=$value->fechaPago;
				$objeto->end=$ultimoDiaDelMes->format('Y-m-d');
			}
			if ($value->acumulado > 0)
				$objeto->backgroundColor= "#33C276";
			else 
				$objeto->backgroundColor= "#D23C25";

			$objeto->url = base_url() . 'index.php/movimiento/traerMovimientos/' . date("Y-m-d",strtotime($objeto->start)) . '/' . date("Y-m-d",strtotime($objeto->start)) ;

			$dato[$key] = $objeto;
		}
		if ($dato != NULL)
			echo json_encode($dato);
		else 
			echo '';
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */