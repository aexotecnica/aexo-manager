<?php
class M_facturaVtaDetalle extends CI_Model {
	// table name
	private $tbl_facturaVtaDetalle= 'facturavtadetalle';
	private $tbl_despiece= 'despiece';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_facturaVtaDetalle);
	}
	// get proyectos with paging
	function get_paged_list($id, $limit = 10, $offset = 0){
		$this->db->select('idFactura, producto.idProducto idProducto, codigo, cantidad, costo, precio, costoUnitario, margen, producto.descripcion producto_descripcion');
		$this->db->join('producto', 'producto.idProducto = '. $this->tbl_facturaVtaDetalle.'.idProducto');
		$this->db->order_by('idFactura','asc');
		$this->db->where('idFactura', $id);
		return $this->db->get($this->tbl_facturaVtaDetalle, $limit, $offset);
		 //echo $this->db->last_query();
	}
	// get person by id
	function get_by_id($id){
		$this->db->where('idFactura', $id);
		return $this->db->get($this->tbl_facturaVtaDetalle);
	}

	function insert($data){
        $this->db->insert($this->tbl_facturaVtaDetalle, $data);
        $ultimoId = $this->db->insert_id();

		return $ultimoId;
	}

	function update($idFactura, $data){
        $this->db->where('idFactura', $idFactura);
        $this->db->update($this->tbl_facturaVtaDetalle, $data);
	}

	function delete($idFactura){
		$this->db->delete($this->tbl_facturaVtaDetalle,  array('idFactura' => $idFactura));
		return $this->db->insert_id();
	}

	// falta joinear conntra la tabla producto para que me traiga el costo del producto. 
	function get_by_idProducto($idProducto, $cantidad){
		$this->db->select($this->tbl_despiece .'.idProducto, idParte, ' . $this->tbl_despiece . '.cantidad * ' . $cantidad . ' cantidad');
		$this->db->from($this->tbl_despiece);
		//$this->db->join($this->tbl_facturaVtaDetalle, $this->tbl_despiece  .'.idProducto = '. $this->tbl_facturaVtaDetalle . '.idProducto','left');
		//$this->db->join('productoprecio', $this->tbl_despiece  .'.idProducto = productoprecio.idProducto','left');
	    //$this->db->where("((fechaInicio < curdate() and fechaFin > curdate()) or (fechaFin is null))");
		$this->db->where($this->tbl_despiece . '.idProducto', $idProducto);
		//$this->db->where('nivel', 1);
		return $this->db->get();
	}

}