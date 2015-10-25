<?php
class M_Producto extends CI_Model {
	// table name
	private $tbl_producto= 'producto';
	private $tbl_productoPrecio= 'productoprecio';
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
	function get_paged_list($limit = 500, $offset = 0){
		$this->db->order_by('idProducto','asc');
		return $this->db->get($this->tbl_producto, $limit, $offset);
	}

	function get_productoPrecios($id){
		$this->db->where('idProducto', $id);
		return $this->db->get("productoprecio");
	}
	
	// get person by id
	function get_by_id($id){
		$this->db->where('idProducto', $id);
		return $this->db->get($this->tbl_producto);
	}

	function get_by_codigo($codigo){
		$this->db->where('codigo', $codigo);
		return $this->db->get($this->tbl_producto);
	}

	function insert($data){
		$this->db->insert($this->tbl_producto, $data);
		return $this->db->insert_id();
	}


	function insertCostos($data){
		$this->db->insert("productoprecio", $data);
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

	function deleteCostos($idProducto){
        $this->db->delete("productoprecio",  array('idProducto' => $idProducto));
	}

	function getProductosConPrec(){
		$this->db->select($this->tbl_producto.'.idProducto, codigo, descripcion, precio, fechaInicio');
		$this->db->from($this->tbl_producto);
		$this->db->join('productoprecio', 'productoprecio.idProducto = '.$this->tbl_producto.'.idProducto and fechaFin is NULL','left');
		//$this->db->join('productoprecio', 'productoprecio.idProducto = '.$this->tbl_producto.'.idProducto and fechaInicio <= Now() and fechaFin is NULL','left');

		$this->db->order_by($this->tbl_producto . '.idProducto','asc');
		
		return $this->db->get();
	}

	function updatePrecio($idProducto, $data){
        $this->db->where('idProducto', $idProducto);
        $this->db->where('fechaFin is null');
        $this->db->update($this->tbl_productoPrecio, $data);
	}
}