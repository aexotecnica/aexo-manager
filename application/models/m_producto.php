<?php
class M_Producto extends CI_Model {
	// table name
	private $tbl_producto= 'producto';
	private $tbl_despiece= 'despiece';

	function __construct()
	{
        // Call the Model constructor
		parent::__construct();
	}

	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_producto);
	}
	// get proyectos with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by('idProducto','asc');
		return $this->db->get($this->tbl_producto, $limit, $offset);
	}
	// get person by id
	function get_by_id($id){
		$this->db->where('idProducto', $id);
		return $this->db->get($this->tbl_producto);
	}


	function insert($data){
		$this->db->insert($this->tbl_producto, $data);
		return $this->db->insert_id();
	}

	function update($idProducto, $data){
        $this->db->where('idProducto', $idProducto);
        $this->db->update($this->tbl_producto, $data);
	}

	function delete($idProducto){
        $this->db->delete($this->tbl_despiece,  array('idProducto' => $idProducto));
        $this->db->delete($this->tbl_producto,  array('idProducto' => $idProducto));
	}
}