<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class movimiento extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_TipoMovimiento','',TRUE);
		$this->load->model('M_Evento','',TRUE);
		$this->load->model('M_Repeticion','',TRUE);
		$this->load->model('M_Movimiento','',TRUE);

	}

	public function index()
	{
		$tiposMovimiento 			= $this->M_TipoMovimiento->get_paged_list(30, 0)->result();
		$data['movimiento'] 		= NULL;
		$data['tiposMovimiento'] 	= $tiposMovimiento;
		$out = $this->load->view('view_movimientoDetalle.php', $data, TRUE);
		$data['cuerpo'] 			= $out;
		$data['permiso'] = "[PERMISOGENERAL]";

		parent::cargarTemplate($data);
	}

	public function listarMovimientos()
	{
		$tiposMovimiento = $this->M_TipoMovimiento->get_paged_list(30, 0)->result();
		
		$data['fechaDesde'] 		= NULL;
		$data['fechaHasta'] 		= NULL;
		$data['movimientos'] 		= NULL;
		$data['tiposMovimiento'] 	= $tiposMovimiento;
		$out = $this->load->view('view_movimientoList.php', $data, TRUE);
		$data['cuerpo'] 			= $out;
		$data['permiso'] = "[PERMISOGENERAL]";

		parent::cargarTemplate($data);

	}

	public function traerMovimientos($fechaDesde =NULL, $fechaHasta =NULL)
	{
		$tiposMovimiento = $this->M_TipoMovimiento->get_paged_list(30, 0)->result();
		
		if ($fechaDesde == NULL){
			$fechaDesde 	= date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('txtFechaDesde'))));
			$fechaDesdeText = $this->input->post('txtFechaDesde');
		}
		else 
		{
			$fechaDesde 	= date_create_from_format('Y-m-d', $fechaDesde); //date("Y-m-d H:i:s", $fechaDesde);
			$fechaDesdeText =  date_format($fechaDesde, 'd/m/Y');
			$fechaDesde 	= date_format($fechaDesde, 'Y-m-d');
			
		}

		if ($fechaHasta == NULL){
			$fechaHasta 	= date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('txtFechaHasta'))));
			$fechaHastaText = $this->input->post('txtFechaHasta');
		}
		else 
		{
			$fechaHasta 	= date_create_from_format('Y-m-d', $fechaHasta); //date("Y-m-d H:i:s", $fechaDesde);
			$fechaHastaText =  date_format($fechaHasta, 'd/m/Y');
			$fechaHasta 	= date_format($fechaHasta, 'Y-m-d');
			
		}

		$movimientos = $this->M_Movimiento->get_porFecha($fechaDesde, $fechaHasta)->result();

		$data['tiposMovimiento'] 	= $tiposMovimiento;
		$data['movimientos'] 		= $movimientos;
		$data['fechaDesde'] 		= $fechaDesdeText;
		$data['fechaHasta'] 		= $fechaHastaText;
		$out = $this->load->view('view_movimientoList.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";

		parent::cargarTemplate($data);
	}

	public function modificar(){
		$tiposMovimiento = $this->M_TipoMovimiento->get_paged_list(30, 0)->result();
		$idMovimiento= $this->input->post('idMovimiento');
		
		$movimiento = $this->M_Movimiento->get_by_id($idMovimiento )->result();

		$data['movimiento'] 		= $movimiento[0];

		$fecha = date_create_from_format('Y-m-d', $data['movimiento']->fechaPago); //date("Y-m-d H:i:s", $fecha);
		
		$data['movimiento']->fechaPago 	=  date_format($fecha, 'd/m/Y');
		$data['tiposMovimiento'] 		= $tiposMovimiento;
		
		$out = $this->load->view('view_movimientoDetalle.php', $data, TRUE);
		$data['cuerpo'] = $out;
		$data['permiso'] = "[PERMISOGENERAL]";
		
		parent::cargarTemplate($data);
	}

	public function guardar(){
		echo $this->input->post('txtFechaPago');

		$data['fechaPago'] 				= date("Y-m-d H:i:s", strtotime(str_replace('/', '-',$this->input->post('txtFechaPago')))); //DateTime::createFromFormat('dd/mm/yyyy', $this->input->post('txtFechaPago'));
		$data['idTipoMovimiento'] 		= $this->input->post('selTipoMovimiento');
		
		if ($data['idTipoMovimiento']  == 1){
			$data['importeIngreso'] 	= str_replace(',', '', $this->input->post('txtImporte'));
			$data['importeEgreso']		= null;
		}else{
			$data['importeEgreso'] 		= str_replace(',', '', $this->input->post('txtImporte'));
			$data['importeIngreso']		= null;
		}

		$data['nroOrden'] 				= $this->input->post('txtNroOrden');
		$data['descripcion'] 			= $this->input->post('txtDescripcion');
		$data['fechaCreacion'] 			= date("Y-m-d H:i:s");

		$data['esConciliado'] = ($this->input->post('chkConciliado') == '1') ? 1 : 0;

		if ($this->input->post('idMovimiento') != null){
			$this->M_Movimiento->update($this->input->post('idMovimiento'),$data);	
		}else {
			if ($this->input->post('chkRepeticion')){
				$dataRepeticion["cantRepeticion"] = $this->input->post('txtCantRepeticion');
				$idRepeticion = $this->M_Repeticion->insert($dataRepeticion);
				$data["idRepeticion"] = $idRepeticion;

				for($i=0; $i< $dataRepeticion["cantRepeticion"]; $i++){
					$data["nroRepeticion"] = $dataRepeticion["cantRepeticion"] - $i;
					$this->M_Movimiento->insert($data);	
					$data['fechaPago'] = date('Y-m-d',strtotime('+1 months', strtotime($data['fechaPago'])));
				}
				

			} else {
				$this->M_Movimiento->insert($data);		
			}

			
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