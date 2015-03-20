<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partes extends MY_Controller {

	private $permiso_autorizaPago;
	function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
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

		$partes = $this->M_Parte->get_paged_list(30, 0)->result();

		$data['actionDelForm'] = 'partes/traerPartes';
		$data['partes'] = $partes;
		$out = $this->load->view('view_partesList.php', $data, TRUE);
		$data['cuerpo'] = $out;

		parent::cargarTemplate($data);
	}

	public function loadPartes()
	{
		$keyword = $this->input->get('sSearch');
		if (strlen($keyword) > 2){
	        $this->datatables->select('idParte,descripcion,codigo')
	        ->from('parte')
	        ->where("descripcion like '%" . $keyword ."%'");
	        
	        $this->datatables->iTotalDisplayRecords=10;
	        echo $this->datatables->generate();

		}else{
			echo "{}";
		}

	}

	public function nuevo(){
		//$tiposPagos = $this->M_TipoComprobante->get_paged_list(30, 0)->result();

		$data['parte'] =  NULL;
		$out = $this->load->view('view_partesDetalle.php', $data, TRUE);
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