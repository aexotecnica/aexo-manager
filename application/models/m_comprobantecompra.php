<?php
class M_ComprobanteCompra extends CI_Model {
	// table name
	private $tbl_comprobante= 'comprobantecompra';

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
		$this->db->order_by('idComprobanteCpr','asc');
		return $this->db->get($this->tbl_comprobante, $limit, $offset);
	}
	// get person by id
	function get_by_id($id){
		$this->db->where('idComprobanteCpr', $id);
		return $this->db->get($this->tbl_comprobante);
	}

	function find($idTipoComprobante = NULL){
		$this->db->select($this->tbl_comprobante.'.*, tipocomprobante.descripcion, movimiento.idComprobanteCpr as idComprobanteCprMovimiento');
		$this->db->from($this->tbl_comprobante);
		$this->db->join('tipocomprobante', 'tipocomprobante.idTipoComprobante = '.$this->tbl_comprobante.'.idTipoComprobante');
		$this->db->join('movimiento', 'movimiento.idComprobanteCpr = '. $this->tbl_comprobante.'.idComprobanteCpr and movimiento.idTipoMovimiento=2', 'left');
		
		if ($idTipoComprobante != NULL)
			$this->db->where($this->tbl_comprobante.'.idTipoComprobante', $idTipoComprobante);
		
		$this->db->order_by($this->tbl_comprobante.'.fecha','DESC');
		return $this->db->get();
	}

	function insert($data){
		$this->db->insert($this->tbl_comprobante, $data);
		return $this->db->insert_id();
	}

}