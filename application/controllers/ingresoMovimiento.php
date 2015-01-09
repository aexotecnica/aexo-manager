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

	public function listarMovimientos()
	{
		$tiposMovimiento = $this->TipoMovimiento->get_paged_list(30, 0)->result();
		
		$data['movimientos'] = NULL;
		$data['tiposMovimiento'] = $tiposMovimiento;
		$out = $this->load->view('view_listarMovimiento.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$this->load->view('view_template.php', $data);
	}

public function traerMovimientos($fechaPago =NULL)
	{
		$tiposMovimiento = $this->TipoMovimiento->get_paged_list(30, 0)->result();
		
		if ($fechaPago == NULL){
			$fechaPago = date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('txtFechaPago'))));
			$fechaText = $this->input->post('txtFechaPago');
		}
		else 
		{
			$fechaPago = date_create_from_format('Y-m-d', $fechaPago); //date("Y-m-d H:i:s", $fechaPago);
			$fechaText =  date_format($fechaPago, 'd/m/Y');
			$fechaPago = date_format($fechaPago, 'Y-m-d');
			
		}
		$movimientos = $this->Movimiento->get_porFecha($fechaPago)->result();

		$data['tiposMovimiento'] = $tiposMovimiento;
		$data['movimientos'] = $movimientos;
		$data['fechaPago'] = $fechaText;
		$out = $this->load->view('view_listarMovimiento.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$this->load->view('view_template.php', $data);
	}

	public function guardar(){
		echo $this->input->post('txtFechaPago');

		$data['fechaPago'] = 			date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('txtFechaPago')))); //DateTime::createFromFormat('dd/mm/yyyy', $this->input->post('txtFechaPago'));
		$data['idTipoMovimiento'] = 	$this->input->post('selTipoMovimiento');
		
		if ($data['idTipoMovimiento']  == 1)
			$data['importeIngreso'] = 	$this->input->post('txtImporte');
		else
			$data['importeEgreso'] = 	$this->input->post('txtImporte');

		$data['nroOrden'] = 			$this->input->post('txtNroOrden');
		$data['descripcion'] = 			$this->input->post('txtDescripcion');
		$data['fechaCreacion'] = 		date("Y-m-d H:i:s");

		$this->Movimiento->insert($data);

		redirect(base_url(). 'index.php/ingresoMovimiento', 'index');

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */