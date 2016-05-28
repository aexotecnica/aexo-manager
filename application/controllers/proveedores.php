<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proveedores extends MY_Controller {

	private $permiso_autorizaPago;
	function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
		$this->load->model('M_Proveedor','',TRUE);
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
		$proveedores = $this->M_Proveedor->get_paged_list(NULL, 0)->result();

		$data['actionDelForm'] = 'proveedores/traerproveedores';
		$data['proveedores'] = $proveedores;
		$out = $this->load->view('view_proveedoresList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";


		parent::cargarTemplate($data);
	}

	public function mostrarMapa(){
		$data['actionDelForm'] = '';
		$out = $this->load->view('view_clienteMapa.php',$data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";

		parent::cargarTemplate($data);
	}

	function getMapa($lat,$lng, $radio){
	
		// Start XML file, create parent node
		$dom = new DOMDocument("1.0");
		$node = $dom->createElement("instituciones");
		$parnode = $dom->appendChild($node);
		
		$proveedores = $this->M_Proveedor->getMapa($lat,$lng, $radio)->result();
		foreach ($proveedores as $val){
			  $node = $dom->createElement("inst");
			  $newnode = $parnode->appendChild($node);
			  $newnode->setAttribute("nombre", utf8_encode($val->nombre));
			  $newnode->setAttribute("address", utf8_encode($val->address));
			  $newnode->setAttribute("lat", $val->calle_lat);
			  $newnode->setAttribute("lng", $val->calle_lng);
			  $newnode->setAttribute("distance", $val->distance);
			  $newnode->setAttribute("idTipoCliente", $val->idTipoCliente);
		}
		
		echo $dom->saveXML();
	}
	
	public function loadproveedores()
	{
		$keyword = $this->input->get('sSearch');
		if (strlen($keyword) > 2){
	        $this->datatables->select('idProveedor,nombre,responsable')
	        ->from('proveedor')
	        ->where("nombre like '%" . $keyword ."%'");
	        
	        $this->datatables->iDisplayLength=5;
	        echo $this->datatables->generate();

		}else{
			echo "{}";
		}

	}

	public function nuevo(){
		$tiposproveedores = $this->M_TipoCliente->get_paged_list(NULL, 0)->result();
		$categoriasIva = $this->M_CategoriaIva->get_paged_list(NULL, 0)->result();
		$provincias = $this->M_Provincia->get_paged_list(NULL, 0)->result();

		$data['proveedor'] =  NULL;
		$data['tiposproveedores'] =  $tiposproveedores;
		$data['categoriasIva'] =  $categoriasIva;
		$data['provincias'] =  $provincias;
		
		
		$out = $this->load->view('view_proveedoresDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";

		parent::cargarTemplate($data);
	}

	public function guardar(){

		$data['nombre'] = 			$this->input->post('txtNombre');
		$data['idTipoProveedor'] = 	($this->input->post('selTipoProveedor') == "0" ? null : $this->input->post('selTipoProveedor'));
		$data['idCategoriaIVA'] = 	($this->input->post('selCategoriaIVA') == "0" ? null : $this->input->post('selCategoriaIVA'));
		$data['cuit'] = 			$this->input->post('txtCuit');
		$data['domicilio'] = 		$this->input->post('txtDomicilio');
		$data['idProvincia'] = 		($this->input->post('selProvincia') == "0" ? null : $this->input->post('selProvincia'));
		$data['localidad'] = 		$this->input->post('txtLocalidad');
		$data['partido'] = 			$this->input->post('txtPartido');
		$data['codPostal'] = 		$this->input->post('txtCodigoPostal');
		$data['responsable'] = 		$this->input->post('txtResponsable');
		$data['email'] = 			$this->input->post('txtEmail');
		$data['latitud'] = 			$this->input->post('txtLatitud');
		$data['longitud'] = 		$this->input->post('txtLongitud');
		$data['comentarios'] = 		$this->input->post('txtComentarios');

		if ($this->input->post('txtidProveedor') != null){
			$this->M_Proveedor->update($this->input->post('txtidProveedor'),$data);	
		}else {
			$this->M_Proveedor->insert($data);	
		}

		redirect(base_url(). 'index.php/proveedores', 'index');
		
	}

	public function modificar($idProveedor=NULL){
		$tiposproveedores = $this->M_TipoCliente->get_paged_list(30, 0)->result();
		$categoriasIva = $this->M_CategoriaIva->get_paged_list(30, 0)->result();
		$provincias = $this->M_Provincia->get_paged_list(30, 0)->result();

		if ($idProveedor == NULL)
			$idProveedor  =  $this->input->post('idProveedor');

		$proveedor = $this->M_Proveedor->get_by_id($idProveedor)->result();

		$data['proveedor'] 	= $proveedor[0];
		$data['tiposproveedores'] =  $tiposproveedores;
		$data['categoriasIva'] =  $categoriasIva;
		$data['provincias'] =  $provincias;
		
		$out = $this->load->view('view_proveedoresDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";
		
		parent::cargarTemplate($data);
	}

	public function eliminar(){
		
		$idProveedor = $this->input->post('idProveedor');
		$this->M_Proveedor->delete($idProveedor);
		
		redirect(base_url(). 'index.php/proveedores', 'index');

	}

	public function existeParte(){
		$codigoParte = $this->input->post("codigo");

		$query = $this->M_Proveedor->get_by_codigo($codigoParte);

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
			$proveedores = $this->M_Proveedor->filter_proveedores($keyword)->result();
			echo json_encode($proveedores);
		}else{
			echo "";
		}

	}


}