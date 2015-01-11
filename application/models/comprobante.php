<?php
class Movimiento extends CI_Model {
	// table name
	private $tbl_comprobante= 'comprobante';

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
		$this->db->order_by('idComprobante','asc');
		return $this->db->get($this->tbl_comprobante, $limit, $offset);
	}
	// get person by id
	function get_by_id($id){
		$this->db->where('idComprobante', $id);
		return $this->db->get($this->tbl_comprobante);
	}

	// get person by id
	function get_porFecha($fecha, $tipoComprobante=NULL){
		$this->db->where('fechaPago', $fecha);
		if  ($tipoComprobante != NULL)
			$this->db->where('idTipoComprobante', $tipoComprobante);
		return $this->db->get($this->tbl_comprobante);
	}

	function insert($data){
        $this->db->insert($this->tbl_comprobante, $data);
		return $this->db->insert_id();
	}

}