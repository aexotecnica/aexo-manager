<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class movimiento extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_TipoMovimiento','',TRUE);
		$this->load->model('M_Evento','',TRUE);
		$this->load->model('M_Movimiento','',TRUE);

	}

	public function index()
	{
		$tiposMovimiento = $this->M_TipoMovimiento->get_paged_list(30, 0)->result();
		$data['movimiento'] = NULL;
		$data['tiposMovimiento'] = $tiposMovimiento;
		$out = $this->load->view('view_movimientoDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function listarMovimientos()
	{
		$tiposMovimiento = $this->M_TipoMovimiento->get_paged_list(30, 0)->result();
		
		$data['fechaPago'] = NULL;
		$data['movimientos'] = NULL;
		$data['tiposMovimiento'] = $tiposMovimiento;
		$out = $this->load->view('view_movimientoList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function traerMovimientos($fechaPago =NULL)
	{
		$tiposMovimiento = $this->M_TipoMovimiento->get_paged_list(30, 0)->result();
		
		if ($fechaPago == NULL){
			$fechaPago = date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('txtFechaPago'))));
			$fechaText = $this->input->post('txtFechaPago');
		}
		else 
		{
			$fechaPago = date_create_from_format('Y-m-d', $fechaPago); //date("Y-m-d H:i:s", $fechaPago);
			$fechaText =  date_format($fechaPago, 'd/m/Y');
			$fechaPago = date_format($fechaPago, 'Y-m-d');
			
		}
		$movimientos = $this->M_Movimiento->get_porFecha($fechaPago)->result();

		$data['tiposMovimiento'] = $tiposMovimiento;
		$data['movimientos'] = $movimientos;
		$data['fechaPago'] = $fechaText;
		$out = $this->load->view('view_movimientoList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function modificar(){
		$tiposMovimiento = $this->M_TipoMovimiento->get_paged_list(30, 0)->result();
		$idMovimiento= $this->input->post('idMovimiento');
		
		$movimiento = $this->M_Movimiento->get_by_id($idMovimiento )->result();

		$data['movimiento'] 		= $movimiento[0];


		$fecha = date_create_from_format('Y-m-d', $data['movimiento']->fechaPago); //date("Y-m-d H:i:s", $fecha);
		
		$data['movimiento']->fechaPago =  date_format($fecha, 'd/m/Y');
		$data['tiposMovimiento'] = $tiposMovimiento;
		
		$out = $this->load->view('view_movimientoDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		parent::cargarTemplate($data);
	}

	public function guardar(){
		echo $this->input->post('txtFechaPago');

		$data['fechaPago'] = 			date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('txtFechaPago')))); //DateTime::createFromFormat('dd/mm/yyyy', $this->input->post('txtFechaPago'));
		$data['idTipoMovimiento'] = 	$this->input->post('selTipoMovimiento');
		
		if ($data['idTipoMovimiento']  == 1)
			$data['importeIngreso'] = 	str_replace(',', '', $this->input->post('txtImporte'));
		else
			$data['importeEgreso'] = 	str_replace(',', '', $this->input->post('txtImporte'));

		$data['nroOrden'] = 			$this->input->post('txtNroOrden');
		$data['descripcion'] = 			$this->input->post('txtDescripcion');
		$data['fechaCreacion'] = 		date("Y-m-d H:i:s");

		if ($this->input->post('idMovimiento') != null){
			$this->M_Movimiento->update($this->input->post('idMovimiento'),$data);	
		}else {
			$this->M_Movimiento->insert($data);	
		}
		
		redirect(base_url(). 'index.php/flujoCaja', 'index');

	}

	public function eliminar(){
		
		$idMovimiento = $this->input->post('idMovimiento');
		
		$this->M_Movimiento->delete($idMovimiento );

		redirect(base_url(). 'index.php/flujoCaja', 'index');

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */