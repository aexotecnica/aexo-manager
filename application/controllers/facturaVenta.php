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

		$this->M_FacturaVentaDetalle->delete($respuesta->idUltimaFactura);

		echo $productos;
		die();

		foreach ($productos as $key => $value) {
			$dataDetalle["idOrdenPedido"] = $respuesta->idUltimaFactura;
			$dataDetalle["idProducto"] = $value->Id;
			$dataDetalle["cantidad"] = $value->Cant;
			$dataDetalle["costo"] = $value->Costo;
			$dataDetalle["costoUnitario"] = $value->CostoUnitario;
			$dataDetalle["precio"] = $value->PrecioHide;
			$dataDetalle["margen"] = $value->MargenHide;

			$despieceProducto = $this->M_OrdenPedidoDetalle->get_by_idProducto($value->Id, $value->Cant);

			foreach ($despieceProducto->result() as $k => $val) {

				$parteEstadoTerm = $this->M_EstadoParte->getEstadoTerminal($val->idParte)->result();

				$dataNecesidad["idOrdenPedido"] = $respuesta->idUltimaFactura;
				$dataNecesidad["idProducto"] = $val->idProducto;
				$dataNecesidad["idParte"] = $val->idParte;
				$dataNecesidad["cantidad"] = $val->cantidad;

				// si el estado del pedido es final, tengo que multiplicar por -1 la cantidad.
				if ($estadoOrden[0]->esFinal == 1){
					$cantidadStock = $val->cantidad * -1;
					// else
					// 	$cantidadStock = $val->cantidad;

					$dataStock['p_idParte'] = 			$val->idParte;
					$dataStock['p_cantidad'] = 			$cantidadStock; 
					$dataStock['p_idAlmacen'] = 		1;
					$dataStock['p_idEstadoParte'] = 	$parteEstadoTerm[0]->idEstadoParte;// BUSCAR EL ESTADO TERMINAL DE ESTA PARTE---$this->input->post('selEstadoParte');
					$dataStock['p_descripcion'] = 		"Orden de pedido nro: " . $this->input->post('nroPedido');
					$dataStock['p_fechaIngreso|'] =		date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('fechaPedido'))));
					$this->M_StockPartes->actualizarStock($dataStock);
				}else{
					//Si el estado de la orden no es final entonces vuelvo agregar la necesidad. Sino no.
					$this->M_NecesidadPedido->insert($dataNecesidad);
				}
					

			}

			$this->M_OrdenPedidoDetalle->insert($dataDetalle);
		}

		echo json_encode($respuesta);
	}
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */