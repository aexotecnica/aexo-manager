<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ComprobanteDeCompra extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('M_TipoComprobante','',TRUE);
		$this->load->model('M_ComprobanteCompra','',TRUE);
		$this->load->model('M_Movimiento','',TRUE);
		date_default_timezone_set('America/Los_Angeles');
	}

	public function index()
	{
		$tiposComprobantes = $this->M_TipoComprobante->get_paged_list(30, 0)->result();

		$data['tiposComprobantes'] = $tiposComprobantes;
		$data['comprobantes'] = NULL;
		$data['fecha'] = NULL;
		$out = $this->load->view('view_comprobanteCprList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$this->load->view('view_template.php', $data);
	}

	public function traerComprobantes($fecha =NULL)
	{
		
		$tiposComprobantes = $this->M_TipoComprobante->get_paged_list(30, 0)->result();
		
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
		$comprobantes = $this->M_ComprobanteCompra->find()->result();

		$data['tiposComprobantes'] = $tiposComprobantes;
		$data['comprobantes'] = $comprobantes;
		$data['fecha'] = $fechaText;
		$out = $this->load->view('view_comprobanteCprList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$this->load->view('view_template.php', $data);
		
	}


	public function nuevo(){
		$tiposComprobantes = $this->M_TipoComprobante->get_paged_list(30, 0)->result();

		$data['comprobanteCpr'] =  NULL;
		$data['tiposComprobantes'] = $tiposComprobantes;
		$data['fecha'] = NULL;
		$out = $this->load->view('view_comprobanteCprDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$this->load->view('view_template.php', $data);
	}

	public function modificar($idComprobante=NULL){
		$tiposComprobantes = $this->M_TipoComprobante->get_paged_list(30, 0)->result();

		if ($idComprobante==NULL)
			$idComprobante = $this->input->post('idComprobanteCpr');
		
		$comprobanteCpr = $this->M_ComprobanteCompra->get_by_id($idComprobante )->result();

		$data['tiposComprobantes'] 		= $tiposComprobantes;
		$data['comprobanteCpr'] 		= $comprobanteCpr[0];

		$out = $this->load->view('view_comprobanteCprDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$this->load->view('view_template.php', $data);
	}

	public function guardar(){
		

		$data['fecha'] = 			date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('txtFecha')))); //DateTime::createFromFormat('dd/mm/yyyy', $this->input->post('txtFechaPago'));
		$data['idTipoComprobante'] = 	$this->input->post('selTipoComprobante');

		$data['nroComprobante'] = 			$this->input->post('txtNroComprobante');
		$data['nroSerie'] = 			$this->input->post('txtSerie');
		
		$data['importeTotal'] = 		$this->input->post('txtImporte');
		$data['importeSiva'] = 			$this->input->post('txtImporteSiva');
		
		$data['nombreProveedor'] = 			$this->input->post('txtProveedor');
		$data['cuitProveedor'] = 			$this->input->post('txtProveedor');
		$data['descripcion'] = 			$this->input->post('txtDescripcion');


		$data['fechaCreacion'] = 		date("Y-m-d H:i:s");

		$this->M_ComprobanteCompra->insert($data);

		redirect(base_url(). 'index.php/comprobanteDeCompra', 'index');
		
	}

	public function crearMovimiento(){
		
		$comprobanteCpr = $this->M_ComprobanteCompra->get_by_id($this->input->post('idComprobanteCpr'))->result();
		$comprobanteCpr = $comprobanteCpr[0];

		$data['idComprobanteCpr'] = 		$comprobanteCpr->idComprobanteCpr;
		$data['fechaPago'] = 			$comprobanteCpr->fecha;
		$data['idTipoMovimiento'] = 	2;
		$data['importeEgreso'] = 		$comprobanteCpr->importeTotal;

		$data['nroOrden'] = 			$comprobanteCpr->nroComprobante;
		$data['descripcion'] = 			$comprobanteCpr->descripcion;
		$data['fechaCreacion'] = 		date("Y-m-d H:i:s");

		$this->M_Movimiento->insert($data);
		
		redirect(base_url(). 'index.php/comprobanteDeVenta', 'index');
		
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */