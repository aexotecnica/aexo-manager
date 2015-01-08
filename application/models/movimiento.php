<?php
class Movimiento extends CI_Model {
	// table name
	private $tbl_movimiento= 'movimiento';

    function __construct()
    {
        // Call the Model constructor
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

	function insert($data){
        $this->db->insert($this->tbl_movimiento, $data);
		return $this->db->insert_id();
	}

	function get_saldoCalendario($mes, $anio){
		$sql = "CALL sp_flujoCaja(?,?)";
		$params = array($mes,$anio);
		return $this->db->query($sql, $params)->result();
	}

}