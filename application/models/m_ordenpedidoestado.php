<?php
class M_OrdenPedidoEstado extends CI_Model {
	// table name
	private $tbl_ordenPedidoEstado= 'ordenpedido_estado';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_ordenPedidoEstado);
	}
	// get proyectos with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by('idEstadoOrdenPedido','asc');
		return $this->db->get($this->tbl_ordenPedidoEstado, $limit, $offset);
	}
	// get person by id
	function get_by_id($id){
		$this->db->where('idEstadoOrdenPedido', $id);
		return $this->db->get($this->tbl_ordenPedidoEstado);
	}

}