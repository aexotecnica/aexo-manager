<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FacturaVenta extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_Cliente','',TRUE);
		$this->load->model('M_OrdenPedido','',TRUE);
		$this->load->model('M_OrdenPedidoDetalle','',TRUE);
		$this->load->model('M_Despiece','',TRUE);
		$this->load->model('M_NecesidadPedido','',TRUE);
		$this->load->model('M_EstadoParte','',TRUE);
		$this->load->model('M_StockPartes','',TRUE);
		
	}

	public function index()
	{
		$facturas = $this->M_OrdenPedido->get_paged_list(30, 0)->result();
		$data['actionDelForm'] = 'facturaVenta/traerFacturas';
		$data['facturas'] = $facturas;
		$out = $this->load->view('view_facturasVentaList.php', $data, TRUE);
		$data['cuerpo'] = $out;

		parent::cargarTemplate($data);
	}

	public function nuevo(){
		$data['facturaVenta'] =  NULL;
		$data['ordenes'] =  NULL;
		$out = $this->load->view('view_facturaVentaDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;

		parent::cargarTemplate($data);
	}
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */