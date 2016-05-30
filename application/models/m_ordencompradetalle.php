<?php
class M_OrdenCompraDetalle extends CI_Model {
	// table name
	private $tbl_ordencompradetalle= 'ordencompradetalle';
	private $tbl_despiece= 'despiece';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_ordencompradetalle);
	}
	// get proyectos with paging
	function get_paged_list($id, $limit = 10, $offset = 0){
		$this->db->select('idOrdenCompra, parte.idParte idParte, codigo, cantidad, parte.descripcion parte_descripcion');
		$this->db->join('parte', 'parte.idParte = '. $this->tbl_ordencompradetalle.'.idParte');
		$this->db->order_by('idOrdenCompra','asc');
		$this->db->where('idOrdenCompra', $id);

		return $this->db->get($this->tbl_ordencompradetalle, $limit, $offset);
		 //echo $this->db->last_query();
	}
	// get person by id
	function get_by_id($id){
		$this->db->where('idOrdenCompra', $id);
		return $this->db->get($this->tbl_ordencompradetalle);
	}

	function insert($data){
        $this->db->insert($this->tbl_ordencompradetalle, $data);
        $ultimoId = $this->db->insert_id();

		return $ultimoId;
	}

	function update($idOrdenCompra, $data){
        $this->db->where('idOrdenCompra', $idOrdenCompra);
        $this->db->update($this->tbl_ordencompradetalle, $data);
	}

	function delete($idOrdenCompra){
		$this->db->delete($this->tbl_ordencompradetalle,  array('idOrdenCompra' => $idOrdenCompra));
		return $this->db->insert_id();
	}

}