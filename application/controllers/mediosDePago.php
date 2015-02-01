<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MediosDePago extends MY_Controller {

	private $permiso_autorizaPago;
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_TipoComprobante','',TRUE);
		$this->load->model('M_MedioPago','',TRUE);
		$this->load->model('M_Movimiento','',TRUE);

		$permisos = $this->session->userdata('permisos');
		$this->permiso_autorizaPago = array_filter($permisos,
			function ($e) {
				return $e->label == '[AUTORIZAPAGO]';
			});

	}

	public function index()
	{
		$tiposPagos = $this->M_TipoComprobante->get_paged_list(30, 0)->result();

		$data['tiposPagos'] = $tiposPagos;
		$data['pagos'] = NULL;
		$data['actionDelForm'] = 'mediosDePago/traerPagos';
		$data['fecha'] = NULL;
		$out = $this->load->view('view_mediosPagoList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function traerPagos($soloPendientesDePasar = NULL)
	{
		$tiposPagos = $this->M_TipoComprobante->get_paged_list(30, 0)->result();
		$fecha = $this->input->post('txtFecha');
		
		if ($fecha == NULL){
			$fecha = date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('txtfecha'))));
			$fechaText = $this->input->post('txtfecha');
		}
		else 
		{
			$fecha = date_create_from_format('Y-m-d', $fecha); //date("Y-m-d H:i:s", $fecha);
			$fechaText =  date_format($fecha, 'd/m/Y');
			$fecha = date_format($fecha, 'Y-m-d');
			
		}
		$pagos = $this->M_MedioPago->find(NULL,$soloPendientesDePasar)->result();

		$data['tiposPagos'] = $tiposPagos;
		$data['pagos'] = $pagos;
		$data['fecha'] = $fechaText;
		$data['actionDelForm'] = 'mediosDePago/traerPagos';
		$out = $this->load->view('view_mediosPagoList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
		
	}

	public function traerPendientesAutorizar()
	{

		if ($this->permiso_autorizaPago != NULL) {


			$tiposPagos = $this->M_TipoComprobante->get_paged_list(30, 0)->result();
			$fecha = $this->input->post('txtFecha');

			if ($fecha == NULL){
				$fecha = date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('txtfecha'))));
				$fechaText = $this->input->post('txtfecha');
			}
			else 
			{
			$fecha = date_create_from_format('Y-m-d', $fecha); //date("Y-m-d H:i:s", $fecha);
			$fechaText =  date_format($fecha, 'd/m/Y');
			$fecha = date_format($fecha, 'Y-m-d');
			
		}
		$pagos = $this->M_MedioPago->find(NULL,NULL,2)->result();

		$data['tiposPagos'] = $tiposPagos;
		$data['pagos'] = $pagos;
		$data['fecha'] = $fechaText;
		$data['actionDelForm'] = 'mediosDePago/traerPendientesAutorizar';
		$out = $this->load->view('view_mediosPagoList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}		
}


public function nuevo(){
	$tiposPagos = $this->M_TipoComprobante->get_paged_list(30, 0)->result();

	$data['comprobanteCpr'] =  NULL;
	$data['tiposPagos'] = $tiposPagos;
	$data['fecha'] = NULL;
	$out = $this->load->view('view_mediosPagoDetalle.php', $data, TRUE);
	$data['cuerpo'] = $out;
	parent::cargarTemplate($data);
}

public function modificar($idComprobante=NULL){
	$tiposPagos = $this->M_TipoComprobante->get_paged_list(30, 0)->result();

	if ($idComprobante==NULL)
		$idComprobante = $this->input->post('idMedioPago');

	$comprobanteCpr = $this->M_MedioPago->get_by_id($idComprobante )->result();

	$data['tiposPagos'] 		= $tiposPagos;
	$data['comprobanteCpr'] 		= $comprobanteCpr[0];

		$fecha = date_create_from_format('Y-m-d', $data['comprobanteCpr']->fecha); //date("Y-m-d H:i:s", $fecha);
		$data['comprobanteCpr']->fecha =  date_format($fecha, 'd/m/Y');

		$out = $this->load->view('view_mediosPagoDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function guardar(){
		
		echo $this->input->post('txtImporte');

		$data['fecha'] = 			date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('txtFecha')))); //DateTime::createFromFormat('dd/mm/yyyy', $this->input->post('txtFechaPago'));
		$data['idTipoMedio'] = 	$this->input->post('selTipoComprobante');

		$data['nroComprobante'] = 			$this->input->post('txtNroComprobante');
		$data['nroSerie'] = 			$this->input->post('txtSerie');
		
		$data['importeTotal'] = 		str_replace(',', '', $this->input->post('txtImporte'));
		$data['importeSiva'] = 			str_replace(',', '', $this->input->post('txtImporteSiva'));
		
		$data['nombreProveedor'] = 			$this->input->post('txtProveedor');
		$data['cuitProveedor'] = 			$this->input->post('txtCuit');
		$data['descripcion'] = 			$this->input->post('txtDescripcion');


		$data['fechaCreacion'] = 		date("Y-m-d H:i:s");

		if ($this->input->post('idMedioPago') != null){
			$this->M_MedioPago->update($this->input->post('idMedioPago'),$data);	
		}else {
			$this->M_MedioPago->insert($data);	
		}

		redirect(base_url(). 'index.php/mediosDePago', 'index');
		
	}

	public function eliminar(){
		
		$idMedioPago = $this->input->post('idMedioPago');
		$movimiento = $this->M_Movimiento->get_by_idMedioPago($idMedioPago);
		if ($movimiento->num_rows() > 0){
			foreach ($movimiento->result() as $row)
			{
			//$movimiento = $movimiento->result();
				$this->M_Movimiento->delete($row->idMovimiento);
			}

		}
		
		$this->M_MedioPago->delete($idMedioPago );

		redirect(base_url(). 'index.php/mediosDePago', 'index');

	}

	public function crearMovimiento(){
		
		$comprobanteCpr = $this->M_MedioPago->get_by_id($this->input->post('idMedioPago'))->result();
		$comprobanteCpr = $comprobanteCpr[0];

		$data['idMedioPago'] = 		$comprobanteCpr->idMedioPago;
		$data['fechaPago'] = 			$comprobanteCpr->fecha;
		$data['idTipoMovimiento'] = 	2;
		$data['importeEgreso'] = 		$comprobanteCpr->importeTotal;

		$data['nroOrden'] = 			$comprobanteCpr->nroComprobante;
		$data['descripcion'] = 			$comprobanteCpr->descripcion;
		$data['fechaCreacion'] = 		date("Y-m-d H:i:s");

		$this->M_Movimiento->insert($data);
		
		redirect(base_url(). 'index.php/mediosDePago', 'index');
		
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */