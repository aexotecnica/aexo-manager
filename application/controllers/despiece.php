<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Despiece extends MY_Controller {
	private $permiso_autorizaPago;
	function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
		$this->load->model('M_Parte','',TRUE);
		$this->load->model('M_Despiece','',TRUE);
		$this->load->model('M_DespieceEntidad','',TRUE);

		$permisos = $this->session->userdata('permisos');
		$this->permiso_autorizaPago = array_filter($permisos,
			function ($e) {
				return $e->label == '[DESPIECE]';
			});

	}

	public function ver(){
		$idProducto = $this->input->post('idProducto');
		$arbolDespiece = M_Despiece::ConstruirArbol($idProducto);
		//var_dump($arbolDespiece);
		$data['actionDelForm'] = 'partes/traerPartes';
		$arbolString = $this->buildItem($arbolDespiece);
		$data['arbolDespiece'] = $arbolDespiece;
		$data['arbolString'] = $arbolString;
		//print_r($arbolDespiece);
		//echo $this->buildItem($arbolDespiece);
		
		 $out = $this->load->view('view_despieceArbol.php', $data, TRUE);
		 $data['cuerpo'] = $out;

		 parent::cargarTemplate($data);
	}

	public function index(){
		$despieces = $this->M_Despiece->get_paged_list(30, 0)->result();

		$data['actionDelForm'] = 'partes/traerDespieces';
		$data['despieces'] = $despieces;
		$out = $this->load->view('view_despieceList.php', $data, TRUE);
		$data['cuerpo'] = $out;

		parent::cargarTemplate($data);
	}


	public function nuevo(){
		//$tiposPagos = $this->M_TipoComprobante->get_paged_list(30, 0)->result();

		$data['producto'] =  NULL;
		$out = $this->load->view('view_productosDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}


	public function buildItem($arbolDespiece){
		$insumo = ($arbolDespiece->esInsumo == 1) ? "{<span style='float:right' class='label label-primary'>Insumo</span>}" : "";

		$retorno = "<li class='dd-item' data-id='" . $arbolDespiece->idParte . "' id='" . $arbolDespiece->idParte . "'>"
		. "<div class='dd3-content'>"
		. "<a href='javascript:detalleDespiece(" . $arbolDespiece->idParte . "," . $arbolDespiece->idProducto . ");'>" . $arbolDespiece->parte->descripcion . " / Cantidad: " . $arbolDespiece->cantidad . "  " . $insumo . "</a>"
		. "</div>";
		
		if (!empty($arbolDespiece->child)){
			$retorno .= "<ol class='dd-list'>";
			foreach ($arbolDespiece->child as $key => $value) {
				$retorno .= $this->buildItem($value);
			}
			$retorno .= "</ol>";
		}
		$retorno .= "</li>";

		return $retorno;

	}

	function contieneSecuencia($sequencia, $origen){
		$haystack = join('', $origen);
		//echo $haystack . "------";
		//var_dump( $sequencia);
		//echo "<br><br><br>";
		if ($sequencia == null){
			return false;
		}else {
			preg_match_all('/' . implode('',$sequencia) . '/', $haystack , $matches, PREG_OFFSET_CAPTURE);
			return isset($matches[0][0]);	
		}
		
	}




}