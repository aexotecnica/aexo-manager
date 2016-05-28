<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OrdenCompra extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
		$this->load->model('M_Cliente','',TRUE);
		$this->load->model('M_OrdenPedidoEstado','',TRUE);
		$this->load->model('M_OrdenCompra','',TRUE);
		$this->load->model('M_OrdenPedidoDetalle','',TRUE);
		$this->load->model('M_Despiece','',TRUE);
		$this->load->model('M_NecesidadPedido','',TRUE);
		$this->load->model('M_EstadoParte','',TRUE);
		$this->load->model('M_StockPartes','',TRUE);
		$this->load->model('M_Producto','',TRUE);
		
	}

	public function index()
	{
		//Esto es para que lo suba.
		$ordenes = $this->M_OrdenCompra->get_paged_list(30, 0)->result();

		$data['actionDelForm'] = 'ordenPedido/traerpedidos';
		$data['ordenes'] = $ordenes;
		$out = $this->load->view('view_ordenCompraList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";

		parent::cargarTemplate($data);
	}
	
	public function nuevo(){
		$estadosOrdenPedido = $this->M_OrdenPedidoEstado->get_paged_list(30, 0)->result();

		$data['ordenCompra'] =  NULL;
		$data['productos'] =  NULL;
		$data['estadosOrdenCompra'] = $estadosOrdenPedido;
		$out = $this->load->view('view_ordenCompraDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";

		parent::cargarTemplate($data);
	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */