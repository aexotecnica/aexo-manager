<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Despiece extends MY_Controller {
	private $permiso_autorizaPago;
	function __construct()
	{
		parent::__construct();
		$this->config->load('config_user');
		$this->load->library('Datatables');
		$this->load->model('M_Parte','',TRUE);
		$this->load->model('M_Insumo','',TRUE);
		$this->load->model('M_Despiece','',TRUE);
		$this->load->model('M_DespieceEntidad','',TRUE);

		$permisos = $this->session->userdata('permisos');
		$this->permiso_autorizaPago = array_filter($permisos,
			function ($e) {
				return $e->label == '[DESPIECE]';
			});

	}

	public function index(){
		$despieces = $this->M_Despiece->get_paged_list(30, 0)->result();

		$data['actionDelForm'] = 'partes/traerDespieces';
		$data['despieces'] = $despieces;
		$out = $this->load->view('view_despieceList.php', $data, TRUE);
		$data['cuerpo'] = $out;

		parent::cargarTemplate($data);
	}

	public function ver(){
		$idProducto = $this->input->post('idProducto');
		$arbolDespiece = $this->M_Despiece->obtenerArbol($idProducto);
		//var_dump($arbolDespiece);
		$data['actionDelForm'] = 'partes/traerPartes';
		$data['idProducto'] = $idProducto;
		
		$arbolString = $this->buildItem($arbolDespiece);
		$data['arbolDespiece'] = $arbolDespiece;
		$data['arbolString'] = $arbolString;
		//print_r($arbolDespiece);
		//echo $this->buildItem($arbolDespiece);
		
		 $out = $this->load->view('view_despieceArbol.php', $data, TRUE);
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

	public function parte(){
		$data['actionDelForm'] = 'despiece/agregarHijo';

		$idPartePadre = ($this->input->post('idPartePadre') != null) ? $this->input->post('idPartePadre') : $this->session->flashdata('idPartePadre');
		$idProducto = ($this->input->post('idProducto') != null) ? $this->input->post('idProducto') : $this->session->flashdata('idProducto');
		$idDespiece = ($this->input->post('idDespiece') != null) ? $this->input->post('idDespiece') : $this->session->flashdata('idDespiece');

		if ($idPartePadre != null){
			$partePadre = $this->M_Parte->get_by_id($idPartePadre)->result();
			$hijos  = $this->M_Despiece->obtenerHijos($idDespiece);
			$arbolDeParte = $this->M_Despiece->obtenerArbol($idProducto,$idPartePadre);

			//print_r($arbolDeParte);die();
			$arbolString = $this->buildItem($arbolDeParte);

			$data['partePadre'] = $partePadre[0];
			$data['hijos'] = $hijos;
			$data['arbolString'] = $arbolString;
			$data['idDespiece'] = $idDespiece;
			$data['idPartePadre'] = $idPartePadre;
			$data['idProducto'] = $idProducto;

			$out = $this->load->view('view_despieceParte.php', $data, TRUE);
			$data['cuerpo'] = $out;
			parent::cargarTemplate($data);
		}
		
	}

	public function importarParte(){
		$idParteTemporal = $this->input->post('idParteTemporal');
		$this->M_Parte->importarParteTemp($idParteTemporal);
		echo 1;
	}

	public function convertirInsumo(){
		$idDespiece = $this->input->post('idDespiece');
		$idPartePadre = $this->input->post('idPartePadre');
		$idProducto = $this->input->post('idProducto');
		$idParte = $this->input->post('idParte');

		$arbolDeParte = $this->M_Despiece->obtenerArbolXidDespiece($idDespiece);
		$this->guardarInsumoRecursivo($arbolDeParte, null, '/', 1);

		$this->session->set_flashdata('idPartePadre', $idPartePadre);
		$this->session->set_flashdata('idProducto', $idProducto);
		$this->session->set_flashdata('idDespiece', $idDespiecePadre);

		redirect(base_url(). 'index.php/despiece/parte', null);	


	}

	public function guardarInsumoRecursivo($arbolDespiece, $idInsumoPadre = null, $jerarquia= "/", $nivel){
		//echo $arbolDespiece->parte->idParte . "," . $arbolDespiece->cantidad . "," ;
		$idInsumoNuevo = $this->M_Insumo->insert($arbolDespiece,$idInsumoPadre, $jerarquia, $nivel);
		$jerarquia .= $idInsumoNuevo . "/" ;
		if (!empty($arbolDespiece->child)){
			foreach ($arbolDespiece->child as $key => $value) {
				$this->guardarInsumoRecursivo($value, $idInsumoNuevo, $jerarquia, $nivel+1);
			}
		}
	}

	public function jsonConsultarParteTemp($query=null)
	{
		$keyword = $this->input->post('query');

		if (strlen($keyword) > 2){
			$partes = $this->M_Parte->filter_partes_temp($keyword)->result();
			echo json_encode($partes);
		}else{
			echo "";
		}

	}


	public function loadPartes()
	{
		$keyword = $this->input->get('sSearch');
		if (strlen($keyword) > 2){
	        $this->datatables->select('idParteTemp,descripcionTemp,codigoTemp')
	        ->from('parte_temp')
	        ->where("descripcionTemp like '%" . $keyword ."%'");
	        
	        $this->datatables->iTotalDisplayRecords=10;
	        echo $this->datatables->generate();

		}else{
			echo "{}";
		}

	}

	public function jsonConsultarParte($query=null)
	{
		$keyword = $this->input->post('query');

		if (strlen($keyword) > 2){
			$partes = $this->M_Parte->filter_partes($keyword)->result();
			echo json_encode($partes);
	        // $this->datatables->select('idParte,descripcion,codigo')
	        // ->from('parte')
	        // ->where("descripcion like '%" . $keyword ."%'");
	        
	        // $this->datatables->iTotalDisplayRecords=10;
	        // echo $this->datatables->generate();

		}else{
			echo "";
		}

	}

	public function agregarHijo(){
		$idPartePadre = $this->input->post('idPartePadre');
		$idProducto = $this->input->post('idProducto');
		$idParte = $this->input->post('idParte');
		$idDespiecePadre = $this->input->post('idDespiece');
		$cantidad = $this->input->post('txtCantidad');
		$esInsumo = $this->input->post('esInsumo');

		$parte = $this->M_Parte->get_by_id($idParte)->result();

		//var_dump($parte);
		if ($parte[0]->esInsumo != null){
			//obtener los insumos en forma de arbol.
			$arbolInsumo = $this->M_Insumo->construirArbol($idParte);
			//var_dump($arbolInsumo);
			$idInsumoNuevo = $this->guardarHijoDeInsumo($arbolInsumo,$idProducto,$idDespiecePadre);

		} elseif ($cantidad > 0 && $idParte != 0){
			$nuevoHijo = new M_DespieceEntidad();
			$nuevoHijo->idProducto = $idProducto;
			$nuevoHijo->idParte = $idParte;
			$nuevoHijo->cantidad = $cantidad;

			$this->M_Despiece->guardarHijo($nuevoHijo, $idDespiecePadre);
		}

		$this->session->set_flashdata('idPartePadre', $idPartePadre);
		$this->session->set_flashdata('idProducto', $idProducto);
		$this->session->set_flashdata('idDespiece', $idDespiecePadre);

		redirect(base_url(). 'index.php/despiece/parte', null);	

	}

	public function guardarHijoDeInsumo($arbolInsumo, $idProducto, $idDespiecePadre){
		$nuevoHijo = new M_DespieceEntidad();
		$nuevoHijo->idProducto = $idProducto;
		$nuevoHijo->idParte = $arbolInsumo->parte->idParte;
		$nuevoHijo->cantidad = $arbolInsumo->cantidad;

		$idDespiecePadre = $this->M_Despiece->guardarHijo($nuevoHijo, $idDespiecePadre);
		if (!empty($arbolInsumo->child)){
			foreach ($arbolInsumo->child as $key => $value) {
				$this->guardarHijoDeInsumo($value, $idProducto, $idDespiecePadre);
			}
		}
	}

	public function buildItem($arbolDespiece){
		$insumo = ($arbolDespiece->esInsumo == 1) ? "{<span style='float:right' class='label label-primary'>Insumo</span>}" : "";

		$retorno = "<li class='dd-item' data-id='" . $arbolDespiece->parte->idParte . "' id='" . $arbolDespiece->parte->idParte . "'>"
		. "<div class='dd3-content'>"
		//. "<a href='javascript:detalleDespiece(" . $arbolDespiece->parte->idParte . "," . $arbolDespiece->idProducto . ");'>" . $arbolDespiece->parte->descripcion . " / Cantidad: " . $arbolDespiece->cantidad . "  " . $insumo . "</a>"
		. "<a href='javascript:detalleDespiece(" . $arbolDespiece->parte->idParte . "," . $arbolDespiece->idProducto . "," . $arbolDespiece->idDespiece . ");'>" . $arbolDespiece->parte->descripcion . " / Cantidad: " . $arbolDespiece->cantidad . "  " . $insumo . "</a>"
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

	public function buildItemInsumo($arbolDespiece){
		$insumo = ($arbolDespiece->esInsumo == 1) ? "{<span style='float:right' class='label label-primary'>Insumo</span>}" : "";

		$retorno = "<li class='dd-item' data-id='" . $arbolDespiece->parte->idParte . "' id='" . $arbolDespiece->parte->idParte . "'>"
		. "<div class='dd3-content'>"
		. "<a href='javascript:detalleDespiece(" . $arbolDespiece->parte->idParte . "," . $arbolDespiece->idProducto . "," . $arbolDespiece->idDespiece . ");'>" . $arbolDespiece->parte->descripcion . " / Cantidad: " . $arbolDespiece->cantidad . "  " . $insumo . "</a>"
		
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