<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Insumos extends MY_Controller {

	private $permiso_autorizaPago;
	function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
		$this->load->model('M_Insumo','',TRUE);
		$this->load->model('M_InsumoEntidad','',TRUE);
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

		$insumos = $this->M_Insumo->get_paged_list(30, 0)->result();

		$data['actionDelForm'] = 'insumos/traer';
		$data['insumos'] = $insumos;
		$out = $this->load->view('view_insumosList.php', $data, TRUE);
		$data['cuerpo'] = $out;

		parent::cargarTemplate($data);
	}

	public function arbol()
	{

		$idInsumo = $this->input->post('idInsumo');
		$arbolInsumo = $this->M_Insumo->obtenerArbol(null, $idInsumo);

		//var_dump($arbolInsumo);
		//die();
		$data['actionDelForm'] = '';
		$data['idInsumo'] = $idInsumo;
		
		$arbolString = $this->buildItem($arbolInsumo);
		$data['arbolInsumo'] = $arbolInsumo;
		$data['arbolString'] = $arbolString;
		//print_r($arbolInsumo);
		//echo $this->buildItem($arbolInsumo);
		
		 $out = $this->load->view('view_insumoArbol.php', $data, TRUE);
		 $data['cuerpo'] = $out;

		 parent::cargarTemplate($data);

	}

	public function buildItem($arbolInsumo){
		$retorno = "<li class='dd-item' data-id='" . $arbolInsumo->idInsumo . "' id='" . $arbolInsumo->idInsumo . "'>"
		. "<div class='dd3-content'>"
		//. "<a href='javascript:detalleDespiece(" . $arbolInsumo->parte->idParte . "," . $arbolInsumo->idProducto . ");'>" . $arbolInsumo->parte->descripcion . " / Cantidad: " . $arbolInsumo->cantidad . "  " . $insumo . "</a>"
		. "<a href=\"javascript:detalleDespiece(" . $arbolInsumo->parte->idParte . "," . $arbolInsumo->idInsumo . ",'" . str_replace("\"", "", $arbolInsumo->parte->descripcion ) . "');\">" . $arbolInsumo->parte->descripcion . " / Cantidad: " . $arbolInsumo->cantidad . " </a>"
		. "</div>";
		if (!empty($arbolInsumo->child)){
			$retorno .= "<ol class='dd-list'>";
			foreach ($arbolInsumo->child as $key => $value) {
				$retorno .= $this->buildItem($value);
			}
			$retorno .= "</ol>";
		}
		$retorno .= "</li>";

		return $retorno;

	}

	public function agregarHijo(){
		$idPartePadre = $this->input->post('idPartePadre');
		$idParte = $this->input->post('idParte');
		$idInsumoPadre = $this->input->post('idInsumo');
		$cantidad = $this->input->post('txtCantidad');

		$parte = $this->M_Parte->get_by_id($idParte)->result();

		$nuevoHijo = new M_InsumoEntidad();
		$nuevoHijo->idParte = $idParte;
		$nuevoHijo->cantidad = $cantidad;

		$this->M_Insumo->guardarHijo($nuevoHijo, $idInsumoPadre);

		$this->session->set_flashdata('idPartePadre', $idPartePadre);
		$this->session->set_flashdata('idProducto', $idProducto);
		$this->session->set_flashdata('idInsumo', $idInsumoPadre);

		redirect(base_url(). 'index.php/insumos/arbol', null);	

	}

	public function nuevo(){
		//$tiposPagos = $this->M_TipoComprobante->get_paged_list(30, 0)->result();

		$data['insumo'] =  NULL;
		$out = $this->load->view('view_insumosDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function guardar(){

		$data['codigo'] = 				$this->input->post('txtCodigo');
		$data['descripcion'] = 			$this->input->post('txtDescripcion');

		if ($this->input->post('txtIdParte') != null){
			$data['idParte'] = 	$this->input->post('txtIdParte');
			$this->M_Parte->update($data['idParte'],$data);	
		}else {
			$this->M_Parte->insert($data);	
		}

		redirect(base_url(). 'index.php/partes', 'index');
		
	}

	public function modificar($idParte=NULL){
		if ($idParte == NULL)
			$idParte  =  $this->input->post('idParte');

		$parte = $this->M_Parte->get_by_id($idParte)->result();

		$data['parte'] 	= $parte[0];
		
		$out = $this->load->view('view_partesDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function eliminar(){
		
		$idParte = $this->input->post('idParte');
		$this->M_Parte->delete($idParte);
		
		redirect(base_url(). 'index.php/partes', 'index');

	}


}