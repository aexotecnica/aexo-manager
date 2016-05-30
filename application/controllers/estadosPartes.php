<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EstadosPartes extends MY_Controller {

	private $permiso_autorizaPago;
	function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
		$this->load->model('M_Notificacion','',TRUE);
		$this->load->model('M_EstadoParte','',TRUE);

		$permisos = $this->session->userdata('permisos');
		$this->permiso_autorizaPago = array_filter($permisos,
			function ($e) {
				return $e->label == '[AUTORIZAERESTADOPAGO]';
			});

	}

	public function index()
	{

		$estadosPartes = $this->M_EstadoParte->get_paged_list(30, 0)->result();

		$data['estadosPartes'] = $estadosPartes;
		$data['actionDelForm'] = 'estadosPartes/index';

		$out = $this->load->view('view_estadoParteList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";

		parent::cargarTemplate($data);
	}

	public function nuevo(){

		$data['estadoParte'] = NULL;
		$out = $this->load->view('view_estadoParteDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";

		parent::cargarTemplate($data);
	}

	public function guardar(){
		$data['descripcion'] = 		$this->input->post('txtDescripcion');
		
		if ($this->input->post('txtIdEstadoParte') != null){
			$idEstadoParte = 			$this->input->post('txtIdEstadoParte');
			$data['idEstadoParte'] = 	$this->input->post('txtIdEstadoParte');
			$this->M_EstadoParte->update($data['idEstadoParte'],$data);	
		}else {
			$idEstadoParte = $this->M_EstadoParte->insert($data);
		}

		redirect(base_url(). 'index.php/estadosPartes', 'index');
		
	}

	public function modificar($idEstadoParte=NULL){
		if ($idEstadoParte == NULL)
			$idEstadoParte  =  $this->input->post('idEstadoParte');

		$estadoParte = $this->M_EstadoParte->get_by_id($idEstadoParte);
		$data['estadoParte'] 	=$estadoParte->first_row();
		
		$out = $this->load->view('view_estadoParteDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";
		
		parent::cargarTemplate($data);
	}

	public function eliminar(){
		
		$idEstadoParte = $this->input->post('idEstadoParte');
		$this->M_EstadoParte->delete($idEstadoParte);
		
		redirect(base_url(). 'index.php/estadosPartes', 'index');

	}

	public function loadJsonEstados(){
		$estadosPartes = $this->M_EstadoParte->get_paged_list(30, 0)->result();
		echo json_encode($estadosPartes);
		return 0;
	}

}