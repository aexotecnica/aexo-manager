<?php
class M_MedioPago extends CI_Model {
	// table name
	private $tbl_comprobante= 'mediopago';

	function __construct()
	{
        // Call the Model constructor
		parent::__construct();
	}

	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_comprobante);
	}
	// get proyectos with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by('idMedioPago','asc');
		return $this->db->get($this->tbl_comprobante, $limit, $offset);
	}
	// get person by id
	function get_by_id($id){
		$this->db->where('idMedioPago', $id);
		return $this->db->get($this->tbl_comprobante);
	}

	function find($idTipoMedio = NULL, $soloPendientes =NULL){
		$this->db->select($this->tbl_comprobante.'.*, tipomedio.descripcion, movimiento.idMedioPago as idMedioPagoMovimiento');
		$this->db->from($this->tbl_comprobante);
		$this->db->join('tipomedio', 'tipomedio.idTipoMedio = '.$this->tbl_comprobante.'.idTipoMedio');
		$this->db->join('movimiento', 'movimiento.idMedioPago = '. $this->tbl_comprobante.'.idMedioPago and movimiento.idTipoMovimiento=2', 'left');
		
		if ($idTipoMedio != NULL)
			$this->db->where($this->tbl_comprobante.'.idTipoMedio', $idTipoMedio);

		if ($soloPendientes != NULL)
			$this->db->where('movimiento.idComprobanteVta', NULL);
		
		$this->db->order_by($this->tbl_comprobante.'.fecha','DESC');
		return $this->db->get();
	}

	function get_saldoCompra(){
		$this->db->select('sum('.$this->tbl_comprobante.'.importeTotal) as saldoCompra');
		$this->db->from($this->tbl_comprobante);
		$this->db->join('movimiento', 'movimiento.idMedioPago = '.$this->tbl_comprobante.'.idMedioPago','left');
		$this->db->where('movimiento.idMedioPago', NULL);
		
		return $this->db->get()->result();
	}

	function insert($data){
		$this->db->insert($this->tbl_comprobante, $data);
		return $this->db->insert_id();
	}

	function update($idMedioPago, $data){
        $this->db->where('idMedioPago', $idMedioPago);
        $this->db->update($this->tbl_comprobante, $data);
	}

	function delete($idMedioPago){
        $this->db->delete($this->tbl_comprobante,  array('idMedioPago' => $idMedioPago));
	}
}