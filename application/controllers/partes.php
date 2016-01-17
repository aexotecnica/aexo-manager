<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partes extends MY_Controller {

	private $permiso_autorizaPago;
	function __construct()
	{
		parent::__construct();
		$this->config->load('config_user');
		$this->load->library('Datatables');
		$this->load->model('M_Parte','',TRUE);
		$this->load->model('M_Producto','',TRUE);
		$this->load->model('M_Despiece','',TRUE);
		$this->load->model('M_DespieceEntidad','',TRUE);
		$this->load->model('M_Notificacion','',TRUE);
		$this->load->model('M_EstadoParte','',TRUE);

		$permisos = $this->session->userdata('permisos');
		$this->permiso_autorizaPago = array_filter($permisos,
			function ($e) {
				return $e->label == '[AUTORIZAPAGO]';
			});

	}

	public function index()
	{

		$partes = $this->M_Parte->get_paged_list(30, 0)->result();
		$estadosPartes = $this->M_EstadoParte->get_paged_list(30, 0)->result();

		$data['estadosPartes'] = $estadosPartes;
		$data['actionDelForm'] = 'partes/traerPartes';
		$data['partes'] = $partes;

		$modalImportarPartes = $this->load->view('partial/view_modalPartesImportar.php', $data, TRUE);

		$data['modalImportarPartes'] = $modalImportarPartes;

		$out = $this->load->view('view_partesList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";

		parent::cargarTemplate($data);
	}

	public function loadPartes()
	{
		$keyword = $this->input->get('sSearch');
		if (strlen($keyword) > 2){
	        $this->datatables->select('idParte,descripcion,codigo')
	        ->from('parte')
	        ->where("descripcion like '%" . $keyword ."%'")
	        ->or_where("codigo like '%" . $keyword ."%'");
	        
	        $this->datatables->iDisplayLength=5;
	        echo $this->datatables->generate();

		}else{
			echo "{}";
		}

	}

	public function nuevo(){
		//$tiposPagos = $this->M_TipoComprobante->get_paged_list(30, 0)->result();
		//$estadosPartes = $this->M_EstadoParte->get_paged_list(30, 0)->result();
		$estadosPartes = $this->M_EstadoParte->get_estadosConfigurados(NULL);

		$data['estadosPartes'] = $estadosPartes;
		$data['parte'] =  NULL;
		$out = $this->load->view('view_partesDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";

		parent::cargarTemplate($data);
	}

	public function guardar(){

		$data['codigo'] = 				$this->input->post('txtCodigo');
		$data['descripcion'] = 			$this->input->post('txtDescripcion');
		$data['esParteFinal'] = 		($this->input->post('chkEsFinal') != null) ? 1 : 0;


		//var_dump($data['descripcion']); die();

		if ($this->input->post('txtIdParte') != null){
			$idParte = $this->input->post('txtIdParte');
			$data['idParte'] = 	$this->input->post('txtIdParte');
			$this->M_Parte->update($data['idParte'],$data);	
		}else {
			$idParte = $this->M_Parte->insert($data);
		}

		$this->M_EstadoParte->deleteEstadosConf($idParte);
		$cantTotal = count($this->input->post('mselEstadosParte'));
		if ($this->input->post('mselEstadosParte') != NULL){
			foreach($this->input->post('mselEstadosParte') as $key => $idEstado){
				$dataEstadoConf["idParte"] = $idParte;
				$dataEstadoConf["idEstadoParte"] = $idEstado;
				$dataEstadoConf["orden"] = $key;
				if ($cantTotal-1 == $key)
					$dataEstadoConf["esFinal"] = 1;
				else
					$dataEstadoConf["esFinal"] = 0;

			    $this->M_EstadoParte->insertEstadosConf($dataEstadoConf);
			}
		}
		

		/***************************************/
		$result = $this->M_Producto->get_by_codigo($data['codigo']);
		//var_dump($result);
		///var_dump($result->num_rows());die();
		if ($data['esParteFinal'] == 1 && $result->num_rows() == 0){
			$this->agregarComoProducto($data['codigo'], $data['descripcion'], $idParte);
		}
			
		/***************************************/

		redirect(base_url(). 'index.php/partes', 'index');
		
	}

	public function agregarComoProducto($codigo, $descripcion, $idParte){
		$dataProducto['codigo'] = 				$codigo;
		$dataProducto['descripcion'] = 			$descripcion;
		$dataProducto['idParteFinal'] = 		$idParte;

		$idPartePadre = $this->config->item('idDespieceRoot');
		$idProducto = $this->M_Producto->insert($dataProducto);
		//var_dump($idProducto); //die();
		$cantidad = 1;
		$idParteFinal = $dataProducto['idParteFinal'];

		if ($cantidad > 0 && $idParteFinal != 0){
			//var_dump("Entro");
			$nuevoHijo = new M_DespieceEntidad();
			$nuevoHijo->idProducto = $idProducto;
			$nuevoHijo->idParte = $idParteFinal;
			$nuevoHijo->cantidad = $cantidad;

			$this->M_Despiece->guardarHijo($nuevoHijo, $idPartePadre);
		}
	}

	public function modificar($idParte=NULL){
		if ($idParte == NULL)
			$idParte  =  $this->input->post('idParte');

		$parte = $this->M_Parte->get_by_id($idParte);
		$estadosPartes = $this->M_EstadoParte->get_estadosConfigurados($idParte);

		$data['estadosPartes'] = $estadosPartes;

		$data['parte'] 	= $parte[0];
		
		$out = $this->load->view('view_partesDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";
		
		parent::cargarTemplate($data);
	}

	public function eliminar(){
		
		$idParte = $this->input->post('idParte');
		$this->M_Parte->delete($idParte);
		
		redirect(base_url(). 'index.php/partes', 'index');

	}

	public function existeParte(){
		$codigoParte = $this->input->post("codigo");

		$query = $this->M_Parte->get_by_codigo($codigoParte);

		if($query->num_rows() > 0){
		    echo 1;
		} else {
		    echo 0;
		}
	}


}