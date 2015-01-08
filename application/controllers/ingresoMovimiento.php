<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class IngresoMovimiento extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('TipoMovimiento','',TRUE);
		$this->load->model('Evento','',TRUE);
		$this->load->model('Movimiento','',TRUE);

	}

	public function index()
	{
		$tiposMovimiento = $this->TipoMovimiento->get_paged_list(30, 0)->result();

		$data['tiposMovimiento'] = $tiposMovimiento;
		$out = $this->load->view('view_ingresoMovimiento.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$this->load->view('view_template.php', $data);
	}

	public function guardar(){
		echo $this->input->post('txtFechaPago');

		$data['fechaPago'] = 			date("Y-m-d", strtotime($this->input->post('txtFechaPago'))); //DateTime::createFromFormat('dd/mm/yyyy', $this->input->post('txtFechaPago'));
		$data['idTipoMovimiento'] = 	$this->input->post('selTipoMovimiento');
		
		if ($data['idTipoMovimiento']  == 1)
			$data['importeIngreso'] = 	$this->input->post('txtImporte');
		else
			$data['importeEgreso'] = 	$this->input->post('txtImporte');

		$data['nroOrden'] = 			$this->input->post('txtNroOrden');
		$data['descripcion'] = 			$this->input->post('txtDescripcion');
		$data['fechaCreacion'] = 		date("Y-m-d H:i:s");

		$this->Movimiento->insert($data);

	}

	public function getMovimientosDelMes(){
		$movimientosDelMes = $this->Movimiento->get_saldoCalendario(1,2015);

		foreach ($movimientosDelMes as $key => $value) {
			$objeto = new Evento();
			$objeto->title= $value->acumulado;
			$objeto->start = $value->fechaPago;
			
			

			if (sizeof($movimientosDelMes) > $key +1 ){
				$proximo = $movimientosDelMes[$key+1];
				$objeto->end= strtotime ( '-0 day' , strtotime ( $proximo->fechaPago) ) ;	
			}else{
				$objeto->end=$value->fechaPago;
			}
			if ($value->acumulado > 0)
				$objeto->backgroundColor= "#33C276";
			else 
				$objeto->backgroundColor= "#D23C25";
			$dato[$key] = $objeto;
		}

		echo json_encode($dato);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */