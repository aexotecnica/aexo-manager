<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OrdenPedido extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_Cliente','',TRUE);
		$this->load->model('M_OrdenPedidoEstado','',TRUE);
		$this->load->model('M_OrdenPedido','',TRUE);
		$this->load->model('M_OrdenPedidoDetalle','',TRUE);
		$this->load->model('M_Despiece','',TRUE);
		$this->load->model('M_NecesidadPedido','',TRUE);
	}

	public function index()
	{
		$ordenes = $this->M_OrdenPedido->get_paged_list(30, 0)->result();

		$data['actionDelForm'] = 'ordenPedido/traerpedidos';
		$data['ordenes'] = $ordenes;
		$out = $this->load->view('view_ordenPedidoList.php', $data, TRUE);
		$data['cuerpo'] = $out;

		parent::cargarTemplate($data);
	}
	
	public function eliminar(){
		$this->M_NecesidadPedido->delete($this->input->post('idOrdenPedido'));
		$this->M_OrdenPedidoDetalle->delete($this->input->post('idOrdenPedido'));
		$this->M_OrdenPedido->delete($this->input->post('idOrdenPedido'));

		$ordenes = $this->M_OrdenPedido->get_paged_list(30, 0)->result();

		$data['actionDelForm'] = 'ordenPedido/traerpedidos';
		$data['ordenes'] = $ordenes;
		$out = $this->load->view('view_ordenPedidoList.php', $data, TRUE);
		$data['cuerpo'] = $out;

		parent::cargarTemplate($data);
	}

	public function nuevo(){
		$estadosOrdenPedido = $this->M_OrdenPedidoEstado->get_paged_list(30, 0)->result();

		$data['ordenPedido'] =  NULL;
		$data['productos'] =  NULL;
		$data['estadosOrdenPedido'] = $estadosOrdenPedido;
		$out = $this->load->view('view_ordenPedidoDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;

		parent::cargarTemplate($data);
	}

	public function modificar(){
		
		$estadosOrdenPedido = $this->M_OrdenPedidoEstado->get_paged_list(30, 0)->result();
		$orden = $this->M_OrdenPedido->get_by_id($this->input->post('idOrdenPedido'))->result();
		$productos = $this->M_OrdenPedidoDetalle->get_paged_list($this->input->post('idOrdenPedido'))->result();
		
		$data['ordenPedido'] =  $orden[0];
		$data['productos'] =  $productos;
		$data['estadosOrdenPedido'] = $estadosOrdenPedido;
		$out = $this->load->view('view_ordenPedidoDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;

		parent::cargarTemplate($data);
	}

	public function guardarOrden(){

		$precioTotal = 0;
		$costoTotal = 0;
		$data["idCliente"] = 		$this->input->post('idCliente');
		$data["fechaPedido"] =  	date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('fechaPedido'))));
		$data["fechaEntrega"] =  	date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('fechaEntrega')))); 
		$data["idEstadoPedido"] =  	$this->input->post('estadoOrden');
		$data["nroPedido"] = 		$this->input->post('nroPedido');

		$respuesta = $this->M_OrdenPedido->guardar($data);

		$productos = json_decode($this->input->post('productos'));

		$this->M_OrdenPedidoDetalle->delete($respuesta->idUltimoPedido);
		$this->M_NecesidadPedido->delete($respuesta->idUltimoPedido);

		foreach ($productos as $key => $value) {
			//var_dump($value);
			$dataDetalle["idOrdenPedido"] = $respuesta->idUltimoPedido;
			$dataDetalle["idProducto"] = $value->Id;
			$dataDetalle["cantidad"] = $value->Cant;
			$dataDetalle["costo"] = $value->Costo;
			$dataDetalle["costoUnitario"] = $value->CostoUnitario;

			$despieceProducto = $this->M_OrdenPedidoDetalle->get_by_idProducto($value->Id, $value->Cant);

			foreach ($despieceProducto->result() as $k => $val) {
				$dataNecesidad["idOrdenPedido"] = $respuesta->idUltimoPedido;
				$dataNecesidad["idProducto"] = $val->idProducto;
				$dataNecesidad["idParte"] = $val->idParte;

				$this->M_NecesidadPedido->insert($dataNecesidad);
			}

			$this->M_OrdenPedidoDetalle->insert($dataDetalle);
		}

		//$this->ajax->output_ajax($respuesta, 'json', TRUE);
		echo json_encode($respuesta);
	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */