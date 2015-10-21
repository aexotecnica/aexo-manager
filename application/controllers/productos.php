<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productos extends MY_Controller {

	private $permiso_autorizaPago;
	function __construct()
	{
		parent::__construct();
		$this->config->load('config_user');
		$this->load->library('Datatables');
		$this->load->model('M_Producto','',TRUE);
		$this->load->model('M_Despiece','',TRUE);
		$this->load->model('M_DespieceEntidad','',TRUE);
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

		$productos = $this->M_Producto->get_paged_list(500, 0)->result();

		$data['actionDelForm'] = 'productos/traerproductos';
		$data['productos'] = $productos;
		$out = $this->load->view('view_productosList.php', $data, TRUE);
		$data['cuerpo'] = $out;

		parent::cargarTemplate($data);
	}

	public function nuevo(){
		$partes = $this->M_Parte->get_partesFinales()->result();

		$data['producto'] =  NULL;
		$data['costos'] =  NULL;
		$data['partes'] =  $partes;
		$out = $this->load->view('view_productosDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function loadProductos()
	{
		$keyword = $this->input->get('sSearch');
		if (strlen($keyword) >= 0){
	        $this->datatables->select('producto.idProducto idProducto,descripcion,codigo,costo')
	        ->from('producto')
	        ->join('productoprecio', 'producto.idProducto = productoprecio.idProducto','left')
	        //->where("(descripcion like '%" . $keyword ."%' or codigo like '%" . $keyword ."%')")
	        ->where("((fechaInicio < curdate() and fechaFin > curdate()) or (fechaFin is null))");
	        //->or_where("");
	        $this->datatables->iDisplayLength=5;
	        echo $this->datatables->generate();

		}else{
			echo "{}";
		}

	}

	public function modificar($idProducto=NULL){
		if ($idProducto == NULL)
			$idProducto  =  $this->input->post('idProducto');

		$producto 	= $this->M_Producto->get_by_id($idProducto)->result();
		$partes 	= $this->M_Parte->get_partesFinales()->result();
		$costos 	= $this->M_Producto->get_productoPrecios($idProducto)->result();

		//var_dump($costos);
		
		$data['producto'] 	= $producto[0];
		$data['partes'] =  $partes;
		$data['costos'] =  $costos;
		$out = $this->load->view('view_productosDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function guardar(){

		$data['codigo'] = 				$this->input->post('txtCodigo');
		$data['descripcion'] = 			$this->input->post('txtDescripcion');
		$data['idParteFinal'] = 			$this->input->post('selParteFinal');

		if ($this->input->post('txtIdProducto') != null){
			$idProducto = 	$this->input->post('txtIdProducto');
			$data['idProducto'] = 	$this->input->post('txtIdProducto');
			$this->M_Producto->update($data['idProducto'],$data);	
		}else {
			$idPartePadre = $this->config->item('idDespieceRoot');
			$idProducto = $this->M_Producto->insert($data);
			$cantidad = 1;
			$idParteFinal = $data['idParteFinal'];

			if ($cantidad > 0 && $idParteFinal != 0){
				$nuevoHijo = new M_DespieceEntidad();
				$nuevoHijo->idProducto = $idProducto;
				$nuevoHijo->idParte = $idParteFinal;
				$nuevoHijo->cantidad = $cantidad;

				$this->M_Despiece->guardarHijo($nuevoHijo, $idPartePadre);
			}
		}

		$costos = json_decode($this->input->post('txtJsonCosto'));
		$this->M_Producto->deleteCostos($idProducto);
		foreach ($costos as $key => $value) {
			
			$dataCosto["idProducto"] = $idProducto;
			$dataCosto["fechaInicio"] = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $value->FechaDesde)));
			$dataCosto["fechaFin"] =  date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $value->FechaHasta)));
			$dataCosto["costo"] = $value->Costo;

			$this->M_Producto->insertCostos($dataCosto);
		}
		

		redirect(base_url(). 'index.php/productos', 'index');
		
	}

	public function eliminar(){
		
		$idProducto = $this->input->post('idProducto');
		$this->M_Producto->deleteCostos($idProducto);
		$this->M_Producto->delete($idProducto);
		
		redirect(base_url(). 'index.php/productos', 'index');

	}


}