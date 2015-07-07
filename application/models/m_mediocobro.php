<?php
class M_MedioCobro extends CI_Model {
	// table name
	private $tbl_comprobante= 'mediocobro';

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
		$this->db->order_by('idMedioCobro','asc');
		return $this->db->get($this->tbl_comprobante, $limit, $offset);
	}
	// get person by id
	function get_by_id($id){
		$this->db->where('idMedioCobro', $id);
		return $this->db->get($this->tbl_comprobante);
	}

	function find($idTipoMedio = NULL, $soloPendientes =NULL){
		$this->db->select($this->tbl_comprobante.'.*, tipomedio.descripcion, movimiento.idMedioCobro as idMedioCobroMovimiento');
		$this->db->from($this->tbl_comprobante);
		$this->db->join('tipomedio', 'tipomedio.idTipoMedio = '.$this->tbl_comprobante.'.idTipoMedio');
		$this->db->join('movimiento', 'movimiento.idMedioCobro = '. $this->tbl_comprobante.'.idMedioCobro and movimiento.idTipoMovimiento=1', 'left');
		$this->db->where('movimiento.activo', 1);
		
		if ($idTipoMedio != NULL)
			$this->db->where($this->tbl_comprobante.'idTipoMedio', $idTipoMedio);
		
		if ($soloPendientes != NULL)
			$this->db->where('movimiento.idMedioCobro', NULL);

		$this->db->order_by($this->tbl_comprobante.'.fecha','DESC');
		
		return $this->db->get();
	}

	function get_saldoVenta(){
		$this->db->select('sum('.$this->tbl_comprobante.'.importeTotal) as saldoVenta');
		$this->db->from($this->tbl_comprobante);
		$this->db->join('movimiento', 'movimiento.idMedioCobro = '.$this->tbl_comprobante.'.idMedioCobro','left');
		$this->db->where('movimiento.idMedioCobro', NULL);
		$this->db->where('movimiento.activo', 1);
		
		return $this->db->get()->result();
	}

	function insert($data){
		$this->db->insert($this->tbl_comprobante, $data);
		return $this->db->insert_id();
	}
	function update($idMedioCobro, $data){
        $this->db->where('idMedioCobro', $idMedioCobro);
        $this->db->update($this->tbl_comprobante, $data);
	}

	function delete($idMedioCobro){
        $this->db->delete($this->tbl_comprobante,  array('idMedioCobro' => $idMedioCobro));
	}
}