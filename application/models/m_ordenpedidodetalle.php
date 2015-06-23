<?php
class M_OrdenPedidoDetalle extends CI_Model {
	// table name
	private $tbl_ordenPedidoDetalle= 'ordenpedidodetalle';
	private $tbl_despiece= 'despiece';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_ordenPedidoDetalle);
	}
	// get proyectos with paging
	function get_paged_list($id, $limit = 10, $offset = 0){
		$this->db->select('idOrdenPedido, producto.idProducto idProducto, codigo, cantidad, costo, precio, costoUnitario, margen, producto.descripcion producto_descripcion');
		$this->db->join('producto', 'producto.idProducto = '. $this->tbl_ordenPedidoDetalle.'.idProducto');
		$this->db->order_by('idOrdenPedido','asc');
		$this->db->where('idOrdenPedido', $id);
		return $this->db->get($this->tbl_ordenPedidoDetalle, $limit, $offset);
		 //echo $this->db->last_query();
	}
	// get person by id
	function get_by_id($id){
		$this->db->where('idOrdenPedido', $id);
		return $this->db->get($this->tbl_ordenPedidoDetalle);
	}

	function insert($data){
        $this->db->insert($this->tbl_ordenPedidoDetalle, $data);
        $ultimoId = $this->db->insert_id();

		return $ultimoId;
	}

	function update($idOrdenPedido, $data){
        $this->db->where('idOrdenPedido', $idOrdenPedido);
        $this->db->update($this->tbl_ordenPedidoDetalle, $data);
	}

	function delete($idOrdenPedido){
		$this->db->delete($this->tbl_ordenPedidoDetalle,  array('idOrdenPedido' => $idOrdenPedido));
		return $this->db->insert_id();
	}

	// falta joinear conntra la tabla producto para que me traiga el costo del producto. 
	function get_by_idProducto($idProducto, $cantidad){
		$this->db->select($this->tbl_despiece .'.idProducto, idParte, ' . $this->tbl_despiece . '.cantidad * ' . $cantidad . ' cantidad');
		$this->db->from($this->tbl_despiece);
		//$this->db->join($this->tbl_ordenPedidoDetalle, $this->tbl_despiece  .'.idProducto = '. $this->tbl_ordenPedidoDetalle . '.idProducto','left');
		//$this->db->join('productoprecio', $this->tbl_despiece  .'.idProducto = productoprecio.idProducto','left');
	    //$this->db->where("((fechaInicio < curdate() and fechaFin > curdate()) or (fechaFin is null))");
		$this->db->where($this->tbl_despiece . '.idProducto', $idProducto);
		//$this->db->where('nivel', 1);
		return $this->db->get();
	}

}