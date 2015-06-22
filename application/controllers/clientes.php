<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clientes extends MY_Controller {

	private $permiso_autorizaPago;
	function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
		$this->load->model('M_Cliente','',TRUE);
		$this->load->model('M_TipoCliente','',TRUE);
		$this->load->model('M_CategoriaIva','',TRUE);
		$this->load->model('M_Provincia','',TRUE);
		$this->load->model('M_Notificacion','',TRUE);

		$permisos = $this->session->userdata('permisos');
		$this->permiso_autorizaPago = array_filter($permisos,
			function ($e) {
				return $e->label == '[AUTORIZAClIENTE]';
			});

		// echo " a "; var_dump($this->permiso_autorizaPago) ;

	}

	public function index()
	{
		$clientes = $this->M_Cliente->get_paged_list(500, 0)->result();

		$data['actionDelForm'] = 'clientes/traerClientes';
		$data['clientes'] = $clientes;
		$out = $this->load->view('view_clientesList.php', $data, TRUE);
		$data['cuerpo'] = $out;

		parent::cargarTemplate($data);
	}

	public function loadClientes()
	{
		$keyword = $this->input->get('sSearch');
		if (strlen($keyword) > 2){
	        $this->datatables->select('idCliente,nombre,responsable')
	        ->from('cliente')
	        ->where("nombre like '%" . $keyword ."%'");
	        
	        $this->datatables->iDisplayLength=5;
	        echo $this->datatables->generate();

		}else{
			echo "{}";
		}

	}

	public function nuevo(){
		$tiposClientes = $this->M_TipoCliente->get_paged_list(30, 0)->result();
		$categoriasIva = $this->M_CategoriaIva->get_paged_list(30, 0)->result();
		$provincias = $this->M_Provincia->get_paged_list(30, 0)->result();

		$data['cliente'] =  NULL;
		$data['tiposClientes'] =  $tiposClientes;
		$data['categoriasIva'] =  $categoriasIva;
		$data['provincias'] =  $provincias;
		
		
		$out = $this->load->view('view_clientesDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function guardar(){

		$data['nombre'] = 			$this->input->post('txtNombre');
		$data['idTipoCliente'] = 	$this->input->post('selTipoCliente');
		$data['idCategoriaIVA'] = 	$this->input->post('selCategoriaIVA');
		$data['cuit'] = 			$this->input->post('txtCuit');
		$data['domicilio'] = 		$this->input->post('txtDomicilio');
		$data['calle'] = 			$this->input->post('txtCalle');
		$data['numero'] = 			$this->input->post('txtNumero');
		$data['idProvincia'] = 		$this->input->post('selProvincia');
		$data['localidad'] = 		$this->input->post('txtLocalidad');
		$data['partido'] = 			$this->input->post('txtPartido');
		$data['codigoPostal'] = 	$this->input->post('txtCodigoPostal');
		$data['responsable'] = 		$this->input->post('txtResponsable');
		$data['email'] = 			$this->input->post('txtEmail');
		$data['latitud'] = 			$this->input->post('txtLatitud');
		$data['longitud'] = 		$this->input->post('txtLongitud');

		if ($this->input->post('txtIdCliente') != null){
			$this->M_Cliente->update($this->input->post('txtIdCliente'),$data);	
		}else {
			$this->M_Cliente->insert($data);	
		}

		redirect(base_url(). 'index.php/clientes', 'index');
		
	}

	public function modificar($idCliente=NULL){
		$tiposClientes = $this->M_TipoCliente->get_paged_list(30, 0)->result();
		$categoriasIva = $this->M_CategoriaIva->get_paged_list(30, 0)->result();
		$provincias = $this->M_Provincia->get_paged_list(30, 0)->result();

		if ($idCliente == NULL)
			$idCliente  =  $this->input->post('idCliente');

		$cliente = $this->M_Cliente->get_by_id($idCliente)->result();

		$data['cliente'] 	= $cliente[0];
		$data['tiposClientes'] =  $tiposClientes;
		$data['categoriasIva'] =  $categoriasIva;
		$data['provincias'] =  $provincias;
		
		$out = $this->load->view('view_clientesDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function eliminar(){
		
		$idCliente = $this->input->post('idCliente');
		$this->M_Cliente->delete($idCliente);
		
		redirect(base_url(). 'index.php/clientes', 'index');

	}

	public function existeParte(){
		$codigoParte = $this->input->post("codigo");

		$query = $this->M_Cliente->get_by_codigo($codigoParte);

		if($query->num_rows() > 0){
		    echo 1;
		} else {
		    echo 0;
		}
	}

	public function jsonConsultarCliente($query=null)
	{
		$keyword = $this->input->post('query');

		if (strlen($keyword) > 2){
			$clientes = $this->M_Cliente->filter_clientes($keyword)->result();
			echo json_encode($clientes);
		}else{
			echo "";
		}

	}


}