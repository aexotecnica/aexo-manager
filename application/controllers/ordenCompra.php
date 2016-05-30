<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OrdenCompra extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
		$this->load->model('M_Cliente','',TRUE);
		$this->load->model('M_OrdenPedidoEstado','',TRUE);
		$this->load->model('M_OrdenCompra','',TRUE);
		$this->load->model('M_OrdenCompraDetalle','',TRUE);
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
		$data['partes'] =  NULL;
		$data['estadosOrdenCompra'] = $estadosOrdenPedido;
		$out = $this->load->view('view_ordenCompraDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";

		parent::cargarTemplate($data);
	}

	public function guardarOrden(){

		$precioTotal = 0;
		$costoTotal = 0;
		$data["idProveedor"] = 		$this->input->post('idProveedor');
		$data["fechaPedido"] =  	date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('fechaPedido'))));
		$data["fechaEntrega"] =  	date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('fechaEntrega')))); 
		$data["idEstadoPedido"] =  	$this->input->post('estadoOrden');
		$data["nroPedido"] = 		$this->input->post('nroPedido');

		$respuesta = $this->M_OrdenCompra->guardar($data);

		$partes = json_decode($this->input->post('partes'));

		$estadoOrden = $this->M_OrdenPedidoEstado->get_by_id($data["idEstadoPedido"])->result();

		$this->M_OrdenCompraDetalle->delete($respuesta->idUltimoPedido);
		//$this->M_NecesidadPedido->delete($respuesta->idUltimoPedido);

		foreach ($partes as $key => $value) 

			$dataDetalle["idOrdenCompra"] = $respuesta->idUltimoPedido;
			$dataDetalle["idParte"] = $value->Id;

			$dataDetalle["cantidad"] = $value->Cant;
			//$dataDetalle["costo"] = $value->Costo;
			//$dataDetalle["costoUnitario"] = $value->CostoUnitario;
			$dataDetalle["precioUnitario"] = $value->PrecioHide;
			$dataDetalle["precio"] = $value->PrecioXCantHide;
			// $dataDetalle["margen"] = $value->MargenHide;

			// si el estado del pedido es final, tengo que multiplicar por -1 la cantidad.
			if ($estadoOrden[0]->esFinal == 1){
				$parteEstadoTerm = $this->M_EstadoParte->getEstadoTerminal($val->idParte)->result();
				$cantidadStock = $val->cantidad * -1;
				// else
				// 	$cantidadStock = $val->cantidad;

				$dataStock['p_idParte'] = 			$producto[0]->idParteFinal;
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

			$this->M_OrdenCompraDetalle->insert($dataDetalle);
		}

		echo json_encode($respuesta);
	}


}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */