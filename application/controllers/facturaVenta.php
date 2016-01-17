<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class FacturaVenta extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
		$this->load->model('M_Cliente','',TRUE);
		$this->load->model('M_OrdenPedido','',TRUE);
		$this->load->model('M_OrdenPedidoDetalle','',TRUE);
		$this->load->model('M_Despiece','',TRUE);
		$this->load->model('M_NecesidadPedido','',TRUE);
		$this->load->model('M_EstadoParte','',TRUE);
		$this->load->model('M_StockPartes','',TRUE);
		$this->load->model('M_FacturaVenta','',TRUE);
		$this->load->model('M_FacturaVtaDetalle','',TRUE);
		$this->load->model('M_EstadoFactura','',TRUE);
		
		
		
	}
	public function index()
	{
		$facturas = $this->M_FacturaVenta->get_list(1)->result();
		$estadosFactura = $this->M_EstadoFactura->get_paged_list(30, 0)->result();


		$data['actionDelForm'] = 'facturaVenta/buscar';
		$data['facturas'] = $facturas;
		$data['estadosFactura'] = $estadosFactura;
		$out = $this->load->view('view_facturaVentaList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";

		parent::cargarTemplate($data);
	}

	public function buscar()
	{
		$idEstadoFactura = $this->input->post('selEstadoFactura');
		$facturas = $this->M_FacturaVenta->get_list($idEstadoFactura)->result();
		$estadosFactura = $this->M_EstadoFactura->get_paged_list(30, 0)->result();


		$data['actionDelForm'] = 'facturaVenta/buscar';
		$data['facturas'] = $facturas;
		$data['estadosFactura'] = $estadosFactura;
		$out = $this->load->view('view_facturaVentaList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";

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
		$data['permiso'] = "[PERMISOGENERAL]";

		parent::cargarTemplate($data);
	}

	public function modificar(){
		$idFactura = $this->input->post('idFactura');
		$factura = $this->M_FacturaVenta->get_by_id($idFactura)->result();
		$detalle = $this->M_FacturaVtaDetalle->get_paged_list($idFactura)->result();

		$data['facturaVenta'] =  $factura[0];
		$data['facturaDetalle'] =  $detalle;

		$fecha = date_create_from_format('Y-m-d', $data['facturaVenta']->fechaFactura); //date("Y-m-d H:i:s", $fecha);
		$data['facturaVenta']->fechaFactura =  date_format($fecha, 'd/m/Y');
		$fecha = date_create_from_format('Y-m-d', $data['facturaVenta']->fechaVencimiento); //date("Y-m-d H:i:s", $fecha);
		$data['facturaVenta']->fechaVencimiento =  date_format($fecha, 'd/m/Y');
		
		
		$data['ordenes'] =  NULL;
		$nroFactura = $this->M_FacturaVenta->get_proximoNumFactura();
		$data['nroFactura'] =  $nroFactura;
		$out = $this->load->view('view_facturaVentaDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";
		
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
		
		$data["idEstadoFactura"] =  1;

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

		$detalle = $this->M_FacturaVtaDetalle->get_paged_list($idFactura)->result();

		foreach ($detalle as $key => $value) {

			$despieceProducto = $this->M_OrdenPedidoDetalle->get_by_idProducto($value->idProducto, $value->cantidad);

			foreach ($despieceProducto->result() as $k => $val) {

				$parteEstadoTerm = $this->M_EstadoParte->getEstadoTerminal($val->idParte)->result();

				$dataNecesidad["idOrdenPedido"] = $value->idOrdenPedido;
				$dataNecesidad["idProducto"] = $val->idProducto;
				$dataNecesidad["idParte"] = $val->idParte;
				// PARA QUE INSERTE EN LA TABLA DE NECESIDAD CON CANTIDAD NEGATIVA Y ASI EN EL SUM RESTA LO QUE YA SE ENTREGO.
				$dataNecesidad["cantidad"] = $val->cantidad * -1;

				// si el estado del pedido es final, tengo que multiplicar por -1 la cantidad.
				$cantidadStock = $val->cantidad * -1;
				$dataStock['p_idParte'] = 			$val->idParte;
				$dataStock['p_cantidad'] = 			$cantidadStock; 
				$dataStock['p_idAlmacen'] = 		1;
				$dataStock['p_idEstadoParte'] = 	$parteEstadoTerm[0]->idEstadoParte;// BUSCAR EL ESTADO TERMINAL DE ESTA PARTE---$this->input->post('selEstadoParte');
				$dataStock['p_descripcion'] = 		"Por factura nro: " . $this->input->post('idFactura');
				$dataStock['p_fechaIngreso|'] =		date("Y-m-d H:i:s");
				

				$this->M_StockPartes->actualizarStock($dataStock);
				//Si el estado de la orden no es final entonces vuelvo agregar la necesidad. Sino no.
				$this->M_NecesidadPedido->insert($dataNecesidad);
					

			}

		}

		$respuesta = $this->M_FacturaVenta->update($idFactura, $data);
		redirect(base_url(). 'index.php/facturaVenta', 'index');
	}

	public function loadFacturas()
	{
		$idCliente = $this->input->get('idCliente');
		// if (strlen($keyword) > 2){
		$this->datatables->select('facturavta.idFactura, 
									nroFactura, 
									fechaFactura,
									fechaVencimiento,
									iva,
									(ROUND(importe,2) + ROUND(iva,2))- ROUND(SUM(IFNULL(`mediocobro_facturavta`.`importePagado`,0)),2) AS importeApagar,
									idEstadoFactura', false)
		->from('facturavta')
		//->join('ordenPedidoDetalle', 'ordenPedido.idOrdenPedido = ordenPedidoDetalle.idOrdenPedido')
		//->join('producto', 'ordenPedidoDetalle.idProducto = producto.idProducto')
		->join('cliente', 'facturavta.idCliente = cliente.idCliente')
		->join('mediocobro_facturavta', 'mediocobro_facturavta.idFactura = facturavta.idFactura', 'left')
		->where("facturavta.idCliente", $idCliente)
        ->group_by("mediocobro_facturavta.idFactura")
        ->having("importeApagar >", "0")
		;


		$this->datatables->iDisplayStart=0;
		$this->datatables->iDisplayLength=100;
		echo $this->datatables->generate();

		// }else{
		// 	echo "{}";
		// }

	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */