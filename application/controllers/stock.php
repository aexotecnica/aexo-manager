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
		parent::cargarTemplate($data);
	}

	public function guardar(){

		$data['idParte'] = 				$this->input->post('idParte');
		$data['cantidad'] = 			$this->input->post('txtCantidad');
		$data['idAlmacen'] = 			$this->input->post('selAlmacen');
		$data['idEstadoParte'] = 		$this->input->post('selEstadoParte');
		$data['fechaIngreso'] =			date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('txtFechaIngreso'))));
		$data['descripcion'] = 			($data['cantidad'] > 0) ? "Ingreso de Stock" : "Retiro de stock por ajuste";
		

		$this->M_StockPartes->actualizarStock($data);	

		redirect(base_url(). 'index.php/stock', 'index');

	}

	public function modificar($idParte=NULL){
		if ($idParte == NULL)
			$idParte  =  $this->input->post('idParte');

		$parte = $this->M_Parte->get_by_id($idParte);

		$data['parte'] 	= $parte[0];
		
		$out = $this->load->view('view_partesDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
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