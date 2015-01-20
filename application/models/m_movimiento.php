<?php
class M_Movimiento extends CI_Model {
	// table name
	private $tbl_movimiento= 'movimiento';

    function __construct()
    {
        // Call the Model constructor
        $this->load->model('M_MovimientoSaldoMes','',TRUE);
        parent::__construct();
    }
    
	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_movimiento);
	}
	// get proyectos with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by('idmovimiento','asc');
		return $this->db->get($this->tbl_movimiento, $limit, $offset);
	}
	// get person by id
	function get_by_id($id){
		$this->db->where('idmovimiento', $id);
		return $this->db->get($this->tbl_movimiento);
	}

	// get person by id
	function get_by_idComprobanteCpr($id){
		$this->db->where('idComprobanteCpr', $id);
		return $this->db->get($this->tbl_movimiento);
	}

	function get_by_idComprobanteVta($id){
		$this->db->where('idComprobanteVta', $id);
		return $this->db->get($this->tbl_movimiento);
	}

	// get person by id
	function get_porFecha($fecha, $tipoMovimiento=NULL){
		$this->db->where('fechaPago', $fecha);
		if  ($tipoMovimiento != NULL)
			$this->db->where('idTipoMovimiento', $tipoMovimiento);
		return $this->db->get($this->tbl_movimiento);
	}

	function insert($data){
        $this->db->insert($this->tbl_movimiento, $data);
        $ultimoId = $this->db->insert_id();
        
        $this->actualizarSaldo($data);

		return $ultimoId;
	}

	function update($idMovimiento, $data){
        $this->db->where('idMovimiento', $idMovimiento);
        $this->db->update($this->tbl_movimiento, $data);

        $this->actualizarSaldo($data);
	}

	function delete($idmovimiento){
        $this->db->delete($this->tbl_movimiento,  array('idMovimiento' => $idmovimiento));
		return $this->db->insert_id();
	}


	function get_saldoCalendario($mes, $anio){
		$sql = "CALL sp_flujoCaja(?,?)";
		$params = array($mes,$anio);
		$query = $this->db->query($sql, $params);
		return $query->result();
	}

	function get_saldoMes($mes, $anio){
		$sql = "select coalesce(sum(importeIngreso),0) - coalesce(sum(importeEgreso),0) as saldo from movimiento where year(fechaPago) = ? and month(fechaPago) = ?";
		//$sql = "call sp_getSaldoMes(?,?)";
		$params = array($anio,$mes);
		$query = $this->db->query($sql, $params);
		$resultado = $query->result();
		
		return $resultado[0]->saldo;
	}

	function actualizarSaldo($data){
        $dataSaldo['anio'] = date('Y',strtotime($data['fechaPago']));
        $dataSaldo['mes'] = (int) date('m',strtotime($data['fechaPago']));
        $dataSaldo['saldo'] = $this->get_saldoMes($dataSaldo['mes'], $dataSaldo['anio']);
        $dataSaldo['fechaCarga'] =strtotime($data['fechaPago']);

		$this->db->insert_on_duplicate_update('movimientosaldomes', array_keys($dataSaldo),array_values($dataSaldo));
	}

}