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
		$this->load->model('M_FacturaVenta','',TRUE);
		$this->load->model('M_FacturaVtaDetalle','',TRUE);
		
		
	}
	public function index()
	{
		$facturas = $this->M_FacturaVenta->get_paged_list(30, 0)->result();
		$data['actionDelForm'] = 'facturaVenta/traerFacturas';
		$data['facturas'] = $facturas;
		$out = $this->load->view('view_facturaVentaList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}
	public function nuevo(){
		$data['facturaVenta'] =  NULL;
		$data['facturaDetalle'] =  NULL;
		
		$data['ordenes'] =  NULL;
		$nroFactura = $this->M_FacturaVenta->get_proximoNumFactura();
		$data['nroFactura'] =  $nroFactura;
		$out = $this->load->view('view_facturaVentaDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function modificar(){
		$idFactura = $this->input->post('idFactura');
		$factura = $this->M_FacturaVenta->get_by_id($idFactura)->result();
		$detalle = $this->M_FacturaVtaDetalle->get_paged_list($idFactura)->result();

		$data['facturaVenta'] =  $factura[0];
		$data['facturaDetalle'] =  $detalle;
		
		$data['ordenes'] =  NULL;
		$nroFactura = $this->M_FacturaVenta->get_proximoNumFactura();
		$data['nroFactura'] =  $nroFactura;
		$out = $this->load->view('view_facturaVentaDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function guardarFactura(){
		$precioTotal = 0;
		$costoTotal = 0;
		$data["idCliente"] = 		$this->input->post('idCliente');
		$data["fechaVencimiento"] = date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('fechaVencimiento'))));
		$data["fechaFactura"] =  	date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('fechaFactura')))); 
		$data["nroFactura"] =  		$this->input->post('nroFactura');
		$data["importe"] =  		$this->input->post('importe');
		$data["iva"] =  			$this->input->post('iva');
		$respuesta = $this->M_FacturaVenta->guardar($data);
		$productos = json_decode($this->input->post('productos'));
		//$estadoOrden = $this->M_OrdenPedidoEstado->get_by_id($data["idEstadoPedido"])->result();
		$this->M_FacturaVtaDetalle->delete($respuesta->idFactura);

		$indice = 1;
		foreach ($productos as $key => $value) {
			$dataDetalle["idFactura"] 		= $respuesta->idFactura;
			$dataDetalle["idLinea"] 		= $indice;
			$dataDetalle["idProducto"] 		= $value->IdProd;
			$dataDetalle["cantidad"] 		= $value->Cantidad_hide;
			$dataDetalle["importeUnitario"] = $value->PrecioUnit;
			$dataDetalle["importeTotal"] 	= $value->Precio;
			$dataDetalle["porcPago"] 		= 0;
			$dataDetalle["idOrdenPedido"] 	= $value->IdOrden;
			$dataDetalle["idOrdenPedidoDetalle"] = $value->IdOrdenDetalle;

			$this->M_FacturaVtaDetalle->insert($dataDetalle);
			$indice +=1;
		}
		echo json_encode($respuesta);
	}
	
	public function cambiarEstado(){
		$idFactura 					= $this->input->post('idFactura');
		$data["idEstadoFactura"]	= $this->input->post('idEstadoEntregado');

		$respuesta = $this->M_FacturaVenta->update($idFactura, $data);

		redirect(base_url(). 'index.php/facturaVenta', 'index');
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */