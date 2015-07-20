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
		$this->load->model('M_EstadoParte','',TRUE);
		$this->load->model('M_StockPartes','',TRUE);
		
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
		$this->load->view('view_ordenPedidoList.php', $data);
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
		$data["precioTotal"] = 		$this->input->post('precioTotal');
		$data["costoTotal"] = 		$this->input->post('costoTotal');

		$respuesta = $this->M_OrdenPedido->guardar($data);

		$productos = json_decode($this->input->post('productos'));

		$estadoOrden = $this->M_OrdenPedidoEstado->get_by_id($data["idEstadoPedido"])->result();

		$this->M_OrdenPedidoDetalle->delete($respuesta->idUltimoPedido);
		$this->M_NecesidadPedido->delete($respuesta->idUltimoPedido);

		foreach ($productos as $key => $value) {
			$dataDetalle["idOrdenPedido"] = $respuesta->idUltimoPedido;
			$dataDetalle["idProducto"] = $value->Id;
			$dataDetalle["cantidad"] = $value->Cant;
			$dataDetalle["costo"] = $value->Costo;
			$dataDetalle["costoUnitario"] = $value->CostoUnitario;
			$dataDetalle["precio"] = $value->PrecioHide;
			$dataDetalle["margen"] = $value->MargenHide;

			$despieceProducto = $this->M_OrdenPedidoDetalle->get_by_idProducto($value->Id, $value->Cant);

			foreach ($despieceProducto->result() as $k => $val) {

				$parteEstadoTerm = $this->M_EstadoParte->getEstadoTerminal($val->idParte)->result();

				$dataNecesidad["idOrdenPedido"] = $respuesta->idUltimoPedido;
				$dataNecesidad["idProducto"] = $val->idProducto;
				$dataNecesidad["idParte"] = $val->idParte;
				$dataNecesidad["cantidad"] = $val->cantidad;

				// si el estado del pedido es final, tengo que multiplicar por -1 la cantidad.
				if ($estadoOrden[0]->esFinal == 1)
					$cantidadStock = $val->cantidad * -1;
				else
					$cantidadStock = $val->cantidad;

				$dataStock['p_idParte'] = 			$val->idParte;
				$dataStock['p_cantidad'] = 			$cantidadStock; 
				$dataStock['p_idAlmacen'] = 		1;
				$dataStock['p_idEstadoParte'] = 	$parteEstadoTerm[0]->idEstadoParte;// BUSCAR EL ESTADO TERMINAL DE ESTA PARTE---$this->input->post('selEstadoParte');
				$dataStock['p_descripcion'] = 		"Orden de pedido nro: " . $this->input->post('nroPedido');
				$dataStock['p_fechaIngreso|'] =		date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('fechaPedido'))));
				$this->M_StockPartes->actualizarStock($dataStock);

				$this->M_NecesidadPedido->insert($dataNecesidad);

			}

			$this->M_OrdenPedidoDetalle->insert($dataDetalle);
		}

		echo json_encode($respuesta);
	}

	public function necesidad()
	{
		$necesidad = $this->M_NecesidadPedido->getNecesidades(800, 0)->result();

		$data['actionDelForm'] = 'necesidad/detalle';
		$data['necesidad'] = $necesidad;
		$out = $this->load->view('view_necesidad.php', $data, TRUE);
		$data['cuerpo'] = $out;

		parent::cargarTemplate($data);
	}

	public function reporteOrdenPedido($idOrdenPedido)
	{
		$orden = $this->M_OrdenPedido->get_by_id($idOrdenPedido)->result();
		$productos = $this->M_OrdenPedidoDetalle->get_paged_list($idOrdenPedido)->result();
		$cliente = $this->M_Cliente->get_by_id($orden[0]->idCliente)->result();

		$data['ordenPedido'] =  $orden[0];
		$data['productos'] =  $productos;
		$data['cliente'] =  $cliente[0];

		$data['actionDelForm'] = 'necesidad/detalle';

	 	$data["estilos"] = "";
	 	$html = $this->load->view('reportes/view_rptOrdenPedido.php', $data, TRUE);
	 	$data["reporteHTML"] = $html;
	 	$reporteHTML = $this->load->view('view_ordenPedidoReporte', $data, TRUE);
		$data['cuerpo'] = $reporteHTML;

		parent::cargarTemplate($data);
	}

	public function reporteImprimir($idOrdenPedido){
		$orden = $this->M_OrdenPedido->get_by_id($idOrdenPedido)->result();
		$productos = $this->M_OrdenPedidoDetalle->get_paged_list($idOrdenPedido)->result();
		$cliente = $this->M_Cliente->get_by_id($orden[0]->idCliente)->result();
		
		$data['ordenPedido'] =  $orden[0];
		$data['productos'] =  $productos;
		$data['cliente'] =  $cliente[0];
		// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
		$pdfFilePath = FCPATH."assets/aexo-manager/downloads/ordenes/orden_" . $orden[0]->nroPedido . ".pdf";
		// if (file_exists($pdfFilePath) == FALSE)
		// {
		    ini_set('memory_limit','32M'); // boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
		 	$estilos = $this->load->view('reportes/view_estilos_reportesDoc.php', $data, TRUE);
		 	$data["estilos"] = $estilos;
		 	$html = $this->load->view('reportes/view_rptOrdenPedido.php', $data, TRUE);
		    
		    $this->load->library('pdf');
		    $pdf = $this->pdf->load();
		    $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date("Y-m-d H:i:s")); // Add a footer for good measure <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
		    $pdf->WriteHTML($html); // write the HTML into the PDF
		    $pdf->Output($pdfFilePath, 'F'); // save to file because we can
		//}
		 
		redirect(base_url() . "assets/aexo-manager/downloads/ordenes/orden_" . $orden[0]->nroPedido . ".pdf");

	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */