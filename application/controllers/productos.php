<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productos extends MY_Controller {

	private $permiso_autorizaPago;
	function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
		$this->load->model('M_Producto','',TRUE);
		$this->load->model('M_Parte','',TRUE);
		$this->load->model('M_Notificacion','',TRUE);

		$permisos = $this->session->userdata('permisos');
		$this->permiso_autorizaPago = array_filter($permisos,
			function ($e) {
				return $e->label == '[AUTORIZAPAGO]';
			});

	}

	public function index()
	{

		$productos = $this->M_Producto->get_paged_list(30, 0)->result();

		$data['actionDelForm'] = 'productos/traerproductos';
		$data['productos'] = $productos;
		$out = $this->load->view('view_productosList.php', $data, TRUE);
		$data['cuerpo'] = $out;

		parent::cargarTemplate($data);
	}

	public function nuevo(){
		$partes = $this->M_Parte->get_partesFinales()->result();

		$data['producto'] =  NULL;
		$data['partes'] =  $partes;
		$out = $this->load->view('view_productosDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function guardar(){

		$data['codigo'] = 				$this->input->post('txtCodigo');
		$data['descripcion'] = 			$this->input->post('txtDescripcion');

		if ($this->input->post('txtIdParte') != null){
			$data['idParte'] = 	$this->input->post('txtIdParte');
			$this->M_Producto->update($data['idParte'],$data);	
		}else {
			$this->M_Producto->insert($data);	
		}

		redirect(base_url(). 'index.php/productos', 'index');
		
	}

	public function modificar($idParte=NULL){
		if ($idParte == NULL)
			$idParte  =  $this->input->post('idParte');

		$parte = $this->M_Producto->get_by_id($idParte)->result();

		$data['parte'] 	= $parte[0];
		
		$out = $this->load->view('view_productosDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function eliminar(){
		
		$idParte = $this->input->post('idParte');
		$this->M_Producto->delete($idParte);
		
		redirect(base_url(). 'index.php/productos', 'index');

	}


}