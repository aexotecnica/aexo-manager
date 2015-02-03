<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MediosDeCobro extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_TipoComprobante','',TRUE);
		$this->load->model('M_MedioCobro','',TRUE);
		$this->load->model('M_Movimiento','',TRUE);
	}

	public function index()
	{
		$tiposcobros = $this->M_TipoComprobante->get_paged_list(30, 0)->result();

		$data['tiposcobros'] = $tiposcobros;
		$data['cobros'] = NULL;
		$data['fecha'] = NULL;
		$out = $this->load->view('view_mediosCobroList.php', $data, TRUE);
		$data['cuerpo'] = $out;

		parent::cargarTemplate($data);
	}

	public function traerCobros($soloPendientes = NULL)
	{

		$tiposcobros = $this->M_TipoComprobante->get_paged_list(30, 0)->result();
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
		$cobros = $this->M_MedioCobro->find(NULL,$soloPendientes)->result();

		$data['tiposcobros'] = $tiposcobros;
		$data['cobros'] = $cobros;
		$data['fecha'] = $fechaText;
		$out = $this->load->view('view_mediosCobroList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		//$this->load->view('view_template.php', $data);
		parent::cargarTemplate($data);
		
	}


	public function nuevo(){
		$tiposcobros = $this->M_TipoComprobante->get_paged_list(30, 0)->result();

		$data['medioCobro'] =  NULL;
		$data['tiposcobros'] = $tiposcobros;
		$data['fecha'] = NULL;
		$out = $this->load->view('view_mediosCobroDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;

		parent::cargarTemplate($data);
	}

	public function modificar($idComprobante=NULL){
		$tiposcobros = $this->M_TipoComprobante->get_paged_list(30, 0)->result();

		if ($idComprobante==NULL)
			$idComprobante = $this->input->post('idMedioCobro');
		
		$medioCobro = $this->M_MedioCobro->get_by_id($idComprobante )->result();

		$data['tiposcobros'] 		= $tiposcobros;
		$data['medioCobro'] 		= $medioCobro[0];

		$fecha = date_create_from_format('Y-m-d', $data['medioCobro']->fecha); //date("Y-m-d H:i:s", $fecha);
		$data['medioCobro']->fecha =  date_format($fecha, 'd/m/Y');

		$out = $this->load->view('view_mediosCobroDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function eliminar(){
		
		$idMedioCobro = $this->input->post('idMedioCobro');
		$movimiento = $this->M_Movimiento->get_by_idMedioCobro($idMedioCobro);
		if ($movimiento->num_rows() > 0){
		   foreach ($movimiento->result() as $row)
		   {
			//$movimiento = $movimiento->result();
			$this->M_Movimiento->delete($row->idMovimiento);
		   }

		}
		
		$this->M_MedioCobro->delete($idMedioCobro );

		redirect(base_url(). 'index.php/mediosDeCobro', 'index');

	}

	public function guardar(){
		

		$data['fecha'] = 				date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('txtFecha')))); //DateTime::createFromFormat('dd/mm/yyyy', $this->input->post('txtFechaPago'));
		$data['idTipoMedio'] = 			$this->input->post('selTipoComprobante');

		$data['nroComprobante'] = 		$this->input->post('txtNroComprobante');
		$data['nroSerie'] = 			$this->input->post('txtSerie');
		
		$data['importeTotal'] = 		str_replace(',', '', $this->input->post('txtImporte'));
		$data['importeSiva'] = 			str_replace(',', '', $this->input->post('txtImporteSiva'));
		
		$data['nombreCliente'] = 			$this->input->post('txtCliente');
		$data['cuitCliente'] = 			$this->input->post('txtCuit');
		$data['descripcion'] = 			$this->input->post('txtDescripcion');


		$data['fechaCreacion'] = 		date("Y-m-d H:i:s");

		if ($this->input->post('idMedioCobro') != null){
			$this->M_MedioCobro->update($this->input->post('idMedioCobro'),$data);	
		}else {
			$this->M_MedioCobro->insert($data);	
		}

		redirect(base_url(). 'index.php/mediosDeCobro', 'index');
		
	}

	public function crearMovimiento(){
		
		$medioCobro = $this->M_MedioCobro->get_by_id($this->input->post('idMedioCobro'))->result();
		$medioCobro = $medioCobro[0];

		$data['idMedioCobro'] = 		$medioCobro->idMedioCobro;
		$data['fechaPago'] = 			$medioCobro->fecha;
		$data['idTipoMovimiento'] = 	1;
		$data['importeIngreso'] = 		$medioCobro->importeTotal;

		$data['nroOrden'] = 			$medioCobro->nroComprobante;
		$data['descripcion'] = 			$medioCobro->descripcion;
		$data['fechaCreacion'] = 		date("Y-m-d H:i:s");

		$this->M_Movimiento->insert($data);
		
		redirect(base_url(). 'index.php/mediosDeCobro', 'index');
		
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */