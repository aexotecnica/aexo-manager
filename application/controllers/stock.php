<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock extends MY_Controller {

	private $permiso_autorizaPago;
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_StockPartes','',TRUE);
		$this->load->model('M_Almacen','',TRUE);
		$this->load->model('M_EstadoParte','',TRUE);
		$this->load->model('M_Notificacion','',TRUE);
		$this->load->model('M_Parte','',TRUE);
		$this->load->model('M_Insumo','',TRUE);
		$this->load->library('Datatables');

		$permisos = $this->session->userdata('permisos');
		$this->permiso_autorizaPago = array_filter($permisos,
			function ($e) {
				return $e->label == '[AUTORIZASTOCK]';
			});

	}

	public function index()
	{

		$stockPartes = $this->M_StockPartes->get_paged_list(30, 0)->result();

		$data['actionDelForm'] = 'stock';
		$data['stock'] = $stockPartes;

		$out = $this->load->view('view_stockList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";

		parent::cargarTemplate($data);
	}

	public function nuevo(){
		$almacenes = $this->M_Almacen->get_paged_list(30, 0)->result();
		$estadosPartes = $this->M_EstadoParte->get_paged_list(30, 0)->result();

		$data['actionDelForm'] = 'stock/guardar';
		$data['estados'] = $estadosPartes;
		$data['esInsumo'] = 0;
		$data['almacenes'] = $almacenes;
		$data['stockParte'] =  NULL;
		$out = $this->load->view('view_stockDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";

		parent::cargarTemplate($data);
	}

	public function guardar(){

		$data['idParte'] = 				$this->input->post('idParte');
		$data['cantidad'] = 			$this->input->post('txtCantidad');
		$data['idAlmacen'] = 			$this->input->post('selAlmacen');
		$data['idEstadoParte'] = 		$this->input->post('selEstadoParte');
		$data['descripcion'] = 			($data['cantidad'] > 0) ? "Ingreso de Stock" : "Retiro de stock por ajuste";
		$data['fechaIngreso'] =			date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('txtFechaIngreso'))));
		$data['cantUsadaInsumo'] = 		0;
		$esInsumo = 			$this->input->post('esInsumo');
		
		if ($esInsumo == "1"){
			$despieceInsumo = $this->M_Insumo->obtenerInsumos($data['idParte'],NULL);
			foreach ($despieceInsumo as $key => $insumo) {
				if ($insumo->idPartePadre != NULL){
					//echo $insumo->descripcion . "<br>";
					$stockParte = $this->M_StockPartes->get_by_parte($insumo->idParte)->result();

					if ($insumo->cantidad > 0) { // Se suman cantidades de un insumo. Se debe restar las partes que componene el insumo
						if ($stockParte == NULL || ($stockParte[0]->cantidad < ($insumo->cantidad * $data['cantidad']))) {
							$dataHijo['idParte'] = 	$insumo->idParte;
							$dataHijo['cantidad'] = ($insumo->cantidad * $data['cantidad']) - ($stockParte !=  NULL ? $stockParte[0]->cantidad : 0);
							$dataHijo['idAlmacen'] = $this->input->post('selAlmacen');
							$dataHijo['idEstadoParte'] = $this->input->post('selEstadoParte');
							$dataHijo['descripcion'] = "Ingreso de Stock";
							$dataHijo['fechaIngreso'] =	date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('txtFechaIngreso'))));
							$dataHijo['cantUsadaInsumo'] = ($stockParte !=  NULL ? $stockParte[0]->cantUsadaInsumo : 0); //dejar igual o poner en 0
							$this->M_StockPartes->actualizarStock($dataHijo);
						} 

						// //resto del stock
						$dataHijo['idParte'] = 	$insumo->idParte;
						$dataHijo['cantidad'] = -1 * ($insumo->cantidad * $data['cantidad']); //restar
						$dataHijo['idAlmacen'] = 1;
						$dataHijo['idEstadoParte'] = $this->input->post('selEstadoParte');
						$dataHijo['descripcion'] = "Resto de Stock por uso en insumos";
						$dataHijo['fechaIngreso'] =	date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('txtFechaIngreso'))));
						$dataHijo['cantUsadaInsumo'] = ($insumo->cantidad * $data['cantidad']); //Sumar
						$this->M_StockPartes->actualizarStock($dataHijo);							
					} else { // Se resta insumos del stock. Esto puede ser porque se vendio. Por ende, habria que restar de la cantUsadaInsumo.
						// Generar codigo aca. 
					}

				}
			}
		}

		$this->M_StockPartes->actualizarStock($data);	

		redirect(base_url(). 'index.php/stock', 'index');

	}

	public function modificar($idParte=NULL){
		if ($idParte == NULL)
			$idParte  =  $this->input->post('idParte');

		$almacenes = $this->M_Almacen->get_paged_list(30, 0)->result();
		$estadosPartes = $this->M_EstadoParte->get_paged_list(30, 0)->result();
		$stockParte = $this->M_StockPartes->get_by_parte($idParte)->result();
		
		//var_dump($idParte );die();

		$data['stockParte'] = $stockParte[0];
		$data['estados'] = $estadosPartes;
		$data['almacenes'] = $almacenes;
		$data['esInsumo'] = 0;

		$out = $this->load->view('view_stockDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";

		parent::cargarTemplate($data);
	}

	public function eliminar(){
		
		$idStockParte = $this->input->post('idStockParte');
		$this->M_StockPartes->delete($idStockParte);
		
		redirect(base_url(). 'index.php/stock', 'index');

	}

	public function faltantes()
	{

		$stockPartes = $this->M_StockPartes->getFaltantes();
		$stockFalanteGral = $this->M_StockPartes->getFaltantesGral();

		$data['actionDelForm'] = 'stock';
		$data['stock'] = $stockPartes;
		$data['stockFalanteGral'] = $stockFalanteGral;
		

		$out = $this->load->view('view_faltantesList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";

		parent::cargarTemplate($data);
	}



	public function loadFaltanteXProducto($idProducto=0, $porParte=0)
	{
	        $this->datatables->select('vwfaltantes_producto.idParte, descripcion, cantidadStock, cantidadFaltante');
	        $this->datatables->from('vwfaltantes_producto');
	        if ($porParte == 1)
				$this->datatables->join('insumo', 'vwfaltantes_producto.idParte = insumo.idParte and idInsumoParent IS NULL','left');
	        else
	        	$this->datatables->join('insumo', 'vwfaltantes_producto.idParte = insumo.idParte','left');
	        //->where("(descripcion like '%" . $keyword ."%' or codigo like '%" . $keyword ."%')")
	        $this->datatables->where("idproducto", $idProducto);
	        $this->datatables->where("cantidadFaltante >", 0); 
	        
	        if ($porParte == 1)
	        	$this->datatables->where("insumo.idParte IS NULL"); 
	        else {
	        	$this->datatables->where("idInsumoParent is NULL");
	        	$this->datatables->where("insumo.idParte IS not NULL");
	        }
	        //->or_where("");
	        $this->datatables->iDisplayLength=15;
	        echo $this->datatables->generate();


	}

	public function faltantesDetalle()
	{
		//TENGO QUE RECIBIR EL ID DE PRODUCTO Y PODER LISTAR EL DESPIECE CON LA CANTIDAD DE FALTANTES.
		//ESTO LO HAGO CON EL METODO QUE TENGO ACA ABAJO. eN ERALIDAD TENGO QEUE PROBARLO. pUEDE QUE NECESITE
		//ARMAR OTRO. 
		$despieceProducto = $this->M_OrdenPedidoDetalle->get_by_idProducto($value->Id, $value->Cant);
		
		$stockPartes = $this->M_StockPartes->getFaltantes();

		$data['actionDelForm'] = 'stock';
		$data['stock'] = $stockPartes;

		$out = $this->load->view('view_faltantesList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";

		parent::cargarTemplate($data);
	}


	

	// public function existeParte(){
	// 	$codigoParte = $this->input->post("codigo");

	// 	$query = $this->M_Parte->get_by_codigo($codigoParte);

	// 	if($query->num_rows() > 0){
	// 	    echo 1;
	// 	} else {
	// 	    echo 0;
	// 	}
	// }


}