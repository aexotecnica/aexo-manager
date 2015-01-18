<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ComprobanteDeVenta extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_TipoComprobante','',TRUE);
		$this->load->model('M_ComprobanteVenta','',TRUE);
		$this->load->model('M_Movimiento','',TRUE);
	}

	public function index()
	{
		$tiposComprobantes = $this->M_TipoComprobante->get_paged_list(30, 0)->result();

		$data['tiposComprobantes'] = $tiposComprobantes;
		$data['comprobantes'] = NULL;
		$data['fecha'] = NULL;
		$out = $this->load->view('view_comprobanteVtaList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function traerComprobantes($fecha =NULL)
	{
		
		

		$tiposComprobantes = $this->M_TipoComprobante->get_paged_list(30, 0)->result();
		
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
		$comprobantes = $this->M_ComprobanteVenta->find()->result();

		$data['tiposComprobantes'] = $tiposComprobantes;
		$data['comprobantes'] = $comprobantes;
		$data['fecha'] = $fechaText;
		$out = $this->load->view('view_comprobanteVtaList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		//$this->load->view('view_template.php', $data);
		parent::cargarTemplate($data);
		
	}


	public function nuevo(){
		$tiposComprobantes = $this->M_TipoComprobante->get_paged_list(30, 0)->result();

		$data['comprobanteVta'] =  NULL;
		$data['tiposComprobantes'] = $tiposComprobantes;
		$data['fecha'] = NULL;
		$out = $this->load->view('view_comprobanteVtaDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;

		parent::cargarTemplate($data);
	}

	public function modificar($idComprobante=NULL){
		$tiposComprobantes = $this->M_TipoComprobante->get_paged_list(30, 0)->result();

		if ($idComprobante==NULL)
			$idComprobante = $this->input->post('idComprobanteVta');
		
		$comprobanteVta = $this->M_ComprobanteVenta->get_by_id($idComprobante )->result();

		$data['tiposComprobantes'] 		= $tiposComprobantes;
		$data['comprobanteVta'] 		= $comprobanteVta[0];

		$fecha = date_create_from_format('Y-m-d', $data['comprobanteVta']->fecha); //date("Y-m-d H:i:s", $fecha);
		$data['comprobanteVta']->fecha =  date_format($fecha, 'd/m/Y');

		$out = $this->load->view('view_comprobanteVtaDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function eliminar(){
		
		$idComprobanteVta = $this->input->post('idComprobanteVta');
		$movimiento = $this->M_Movimiento->get_by_idComprobanteVta($idComprobanteVta);
		if ($movimiento->num_rows() > 0){
		   foreach ($movimiento->result() as $row)
		   {
			//$movimiento = $movimiento->result();
			$this->M_Movimiento->delete($row->idMovimiento);
		   }

		}
		
		$this->M_ComprobanteVenta->delete($idComprobanteVta );

		redirect(base_url(). 'index.php/comprobanteDeVenta', 'index');

	}

	public function guardar(){
		

		$data['fecha'] = 			date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('txtFecha')))); //DateTime::createFromFormat('dd/mm/yyyy', $this->input->post('txtFechaPago'));
		$data['idTipoComprobante'] = 	$this->input->post('selTipoComprobante');

		$data['nroComprobante'] = 			$this->input->post('txtNroComprobante');
		$data['nroSerie'] = 			$this->input->post('txtSerie');
		
		$data['importeTotal'] = 		str_replace(',', '', $this->input->post('txtImporte'));
		$data['importeSiva'] = 			str_replace(',', '', $this->input->post('txtImporteSiva'));
		
		$data['nombreCliente'] = 			$this->input->post('txtCliente');
		$data['cuitCliente'] = 			$this->input->post('txtCuit');
		$data['descripcion'] = 			$this->input->post('txtDescripcion');


		$data['fechaCreacion'] = 		date("Y-m-d H:i:s");

		if ($this->input->post('idComprobanteVta') != null){
			$this->M_ComprobanteVenta->update($this->input->post('idComprobanteVta'),$data);	
		}else {
			$this->M_ComprobanteVenta->insert($data);	
		}

		redirect(base_url(). 'index.php/comprobanteDeVenta', 'index');
		
	}

	public function crearMovimiento(){
		
		$comprobanteVta = $this->M_ComprobanteVenta->get_by_id($this->input->post('idComprobanteVta'))->result();
		$comprobanteVta = $comprobanteVta[0];

		$data['idComprobanteVta'] = 		$comprobanteVta->idComprobanteVta;
		$data['fechaPago'] = 			$comprobanteVta->fecha;
		$data['idTipoMovimiento'] = 	1;
		$data['importeIngreso'] = 		$comprobanteVta->importeTotal;

		$data['nroOrden'] = 			$comprobanteVta->nroComprobante;
		$data['descripcion'] = 			$comprobanteVta->descripcion;
		$data['fechaCreacion'] = 		date("Y-m-d H:i:s");

		$this->M_Movimiento->insert($data);
		
		redirect(base_url(). 'index.php/comprobanteDeVenta', 'index');
		
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */