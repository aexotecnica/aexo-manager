<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ComprobanteDeVenta extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('TipoComprobante','',TRUE);
		$this->load->model('ComprobanteVenta','',TRUE);
	}

	public function index()
	{
		$tiposComprobantes = $this->TipoComprobante->get_paged_list(30, 0)->result();

		$data['tiposComprobantes'] = $tiposComprobantes;
		$data['comprobantes'] = NULL;
		$data['fecha'] = NULL;
		$out = $this->load->view('view_comprobanteVtaList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$this->load->view('view_template.php', $data);
	}

	public function traerComprobantes($fecha =NULL)
	{
		
		$tiposComprobantes = $this->TipoComprobante->get_paged_list(30, 0)->result();
		
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
		$comprobantes = $this->ComprobanteVenta->find()->result();

		$data['tiposComprobantes'] = $tiposComprobantes;
		$data['comprobantes'] = $comprobantes;
		$data['fecha'] = $fechaText;
		$out = $this->load->view('view_comprobanteVtaList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$this->load->view('view_template.php', $data);
		
	}


	public function nuevo(){
		$tiposComprobantes = $this->TipoComprobante->get_paged_list(30, 0)->result();

		$data['tiposComprobantes'] = $tiposComprobantes;
		$data['fecha'] = NULL;
		$out = $this->load->view('view_comprobanteVtaDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$this->load->view('view_template.php', $data);
	}

	public function modificar(){
		$tiposComprobantes = $this->TipoComprobante->get_paged_list(30, 0)->result();
		echo "id:" . $this->input->post('idComprobanteVta');
		$comprobanteVta = $this->ComprobanteVenta->get_by_id($this->input->post('idComprobanteVta'))->result();

		$data['tiposComprobantes'] = $tiposComprobantes;
		
		$data['comprobanteVta'] = 				$comprobanteVta[0];
		/*$data['idTipoComprobante'] = 	$comprobanteVta[0]->idTipoComprobante;
		$data['nroComprobante'] = 		$comprobanteVta[0]->nroComprobante;
		$data['nroSerie'] = 			$comprobanteVta[0]->nroSerie;
		
		$data['importeTotal'] = 		$comprobanteVta[0]->importeTotal;
		$data['importeSiva'] = 			$comprobanteVta[0]->importeSiva;
		
		$data['nombreCliente'] = 		$comprobanteVta[0]->nombreCliente;
		$data['cuitCliente'] = 			$comprobanteVta[0]->cuitCliente;
		$data['descripcion'] = 			$comprobanteVta[0]->descripcion;
		*/
		$out = $this->load->view('view_comprobanteVtaDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$this->load->view('view_template.php', $data);
	}

	public function guardar(){
		

		$data['fecha'] = 			date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('txtFecha')))); //DateTime::createFromFormat('dd/mm/yyyy', $this->input->post('txtFechaPago'));
		$data['idTipoComprobante'] = 	$this->input->post('selTipoComprobante');

		$data['nroComprobante'] = 			$this->input->post('txtNroComprobante');
		$data['nroSerie'] = 			$this->input->post('txtSerie');
		
		$data['importeTotal'] = 		$this->input->post('txtImporte');
		$data['importeSiva'] = 			$this->input->post('txtImporteSiva');
		
		$data['nombreCliente'] = 			$this->input->post('txtCliente');
		$data['cuitCliente'] = 			$this->input->post('txtCuit');
		$data['descripcion'] = 			$this->input->post('txtDescripcion');


		$data['fechaCreacion'] = 		date("Y-m-d H:i:s");

		$this->ComprobanteVenta->insert($data);

		redirect(base_url(). 'index.php/comprobanteDeVenta', 'index');
		
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */