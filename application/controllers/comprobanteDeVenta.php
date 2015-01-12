<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ComprobanteDeVenta extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('TipoComprobante','',TRUE);
		$this->load->model('ComprobanteVenta','',TRUE);
	}

	public function index()
	{
		$tiposComprobantes = $this->TipoComprobante->get_paged_list(30, 0)->result();

		$data['tiposComprobantes'] = $tiposComprobantes;
		$data['comprobantes'] = NULL;
		$data['fecha'] = NULL;
		$out = $this->load->view('view_comprobanteVtaList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$this->load->view('view_template.php', $data);
	}

	public function traerComprobantes($fecha =NULL)
	{
		
		$tiposComprobantes = $this->TipoComprobante->get_paged_list(30, 0)->result();
		
		if ($fecha == NULL){
			$fecha = date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('txtfecha'))));
			$fechaText = $this->input->post('txtfecha');
		}
		else 
		{
			$fecha = date_create_from_format('Y-m-d', $fecha); //date("Y-m-d H:i:s", $fecha);
			$fechaText =  date_format($fecha, 'd/m/Y');
			$fecha = date_format($fecha, 'Y-m-d');
			
		}
		$comprobantes = $this->ComprobanteVenta->find()->result();

		$data['tiposComprobantes'] = $tiposComprobantes;
		$data['comprobantes'] = $comprobantes;
		$data['fecha'] = $fechaText;
		$out = $this->load->view('view_comprobanteVtaList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$this->load->view('view_template.php', $data);
		
	}


	public function nuevo(){
		$tiposComprobantes = $this->TipoComprobante->get_paged_list(30, 0)->result();

		$data['tiposComprobantes'] = $tiposComprobantes;
		$data['fecha'] = NULL;
		$out = $this->load->view('view_comprobanteVtaDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$this->load->view('view_template.php', $data);
	}

	public function guardar(){
		/*

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

		redirect(base_url(). 'index.php/comprobanteVenta', 'index');
		*/
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */