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
		
		

		$this->M_StockPartes->actualizarStock($data);	

		redirect(base_url(). 'index.php/stock', 'index');

	}

	public function modificar($idParte=NULL){
		if ($idParte == NULL)
			$idParte  =  $this->input->post('idParte');

		$almacenes = $this->M_Almacen->get_paged_list(30, 0)->result();
		$estadosPartes = $this->M_EstadoParte->get_paged_list(30, 0)->result();
		$stockParte = $this->M_StockPartes->get_by_parte($idParte)->result();
		
		$data['stockParte'] = $stockParte[0];
		$data['estados'] = $estadosPartes;
		$data['almacenes'] = $almacenes;

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

		$data['actionDelForm'] = 'stock';
		$data['stock'] = $stockPartes;

		$out = $this->load->view('view_faltantesList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";

		parent::cargarTemplate($data);
	}



	public function loadFaltanteXProducto($idProducto=0)
	{
	        $this->datatables->select('idParte, descripcion, cantidadStock, cantidadFaltante')
	        ->from('vwfaltantes_producto')
	        //->where("(descripcion like '%" . $keyword ."%' or codigo like '%" . $keyword ."%')")
	        ->where("idproducto", $idProducto);
	        //->or_where("");
	        $this->datatables->iDisplayLength=5;
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