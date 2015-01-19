<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ComprobanteDeCompra extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_TipoComprobante','',TRUE);
		$this->load->model('M_ComprobanteCompra','',TRUE);
		$this->load->model('M_Movimiento','',TRUE);

	}

	public function index()
	{
		$tiposComprobantes = $this->M_TipoComprobante->get_paged_list(30, 0)->result();

		$data['tiposComprobantes'] = $tiposComprobantes;
		$data['comprobantes'] = NULL;
		$data['fecha'] = NULL;
		$out = $this->load->view('view_comprobanteCprList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function traerComprobantes($soloPendientes = NULL)
	{
		$tiposComprobantes = $this->M_TipoComprobante->get_paged_list(30, 0)->result();
		$fecha = $this->input->post('txtFecha');
		
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
		$comprobantes = $this->M_ComprobanteCompra->find(NULL,$soloPendientes)->result();

		$data['tiposComprobantes'] = $tiposComprobantes;
		$data['comprobantes'] = $comprobantes;
		$data['fecha'] = $fechaText;
		$out = $this->load->view('view_comprobanteCprList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
		
	}


	public function nuevo(){
		$tiposComprobantes = $this->M_TipoComprobante->get_paged_list(30, 0)->result();

		$data['comprobanteCpr'] =  NULL;
		$data['tiposComprobantes'] = $tiposComprobantes;
		$data['fecha'] = NULL;
		$out = $this->load->view('view_comprobanteCprDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function modificar($idComprobante=NULL){
		$tiposComprobantes = $this->M_TipoComprobante->get_paged_list(30, 0)->result();

		if ($idComprobante==NULL)
			$idComprobante = $this->input->post('idComprobanteCpr');
		
		$comprobanteCpr = $this->M_ComprobanteCompra->get_by_id($idComprobante )->result();

		$data['tiposComprobantes'] 		= $tiposComprobantes;
		$data['comprobanteCpr'] 		= $comprobanteCpr[0];

		$fecha = date_create_from_format('Y-m-d', $data['comprobanteCpr']->fecha); //date("Y-m-d H:i:s", $fecha);
		$data['comprobanteCpr']->fecha =  date_format($fecha, 'd/m/Y');

		$out = $this->load->view('view_comprobanteCprDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function guardar(){
		
		echo $this->input->post('txtImporte');

		$data['fecha'] = 			date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('txtFecha')))); //DateTime::createFromFormat('dd/mm/yyyy', $this->input->post('txtFechaPago'));
		$data['idTipoComprobante'] = 	$this->input->post('selTipoComprobante');

		$data['nroComprobante'] = 			$this->input->post('txtNroComprobante');
		$data['nroSerie'] = 			$this->input->post('txtSerie');
		
		$data['importeTotal'] = 		str_replace(',', '', $this->input->post('txtImporte'));
		$data['importeSiva'] = 			str_replace(',', '', $this->input->post('txtImporteSiva'));
		
		$data['nombreProveedor'] = 			$this->input->post('txtProveedor');
		$data['cuitProveedor'] = 			$this->input->post('txtCuit');
		$data['descripcion'] = 			$this->input->post('txtDescripcion');


		$data['fechaCreacion'] = 		date("Y-m-d H:i:s");

		if ($this->input->post('idComprobanteCpr') != null){
			$this->M_ComprobanteCompra->update($this->input->post('idComprobanteCpr'),$data);	
		}else {
			$this->M_ComprobanteCompra->insert($data);	
		}

		redirect(base_url(). 'index.php/comprobanteDeCompra', 'index');
		
	}

	public function eliminar(){
		
		$idComprobanteCpr = $this->input->post('idComprobanteCpr');
		$movimiento = $this->M_Movimiento->get_by_idComprobanteCpr($idComprobanteCpr);
		if ($movimiento->num_rows() > 0){
		   foreach ($movimiento->result() as $row)
		   {
			//$movimiento = $movimiento->result();
			$this->M_Movimiento->delete($row->idMovimiento);
		   }

		}
		
		$this->M_ComprobanteCompra->delete($idComprobanteCpr );

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
		
		redirect(base_url(). 'index.php/comprobanteDeCompra', 'index');
		
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */