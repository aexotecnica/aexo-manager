<?php
class M_EstadoFactura extends CI_Model {
	// table name
	private $tbl_estadoFactura= 'estadofactura';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_estadoFactura);
	}
	// get proyectos with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by('idEstadoFactura','asc');
		return $this->db->get($this->tbl_estadoFactura, $limit, $offset);
	}
	// get person by id
	function get_by_id($id){
		$this->db->where('idEstadoFactura', $id);
		return $this->db->get($this->tbl_estadoFactura);
	}

}