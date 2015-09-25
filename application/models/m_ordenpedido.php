<?php
class M_OrdenPedido extends CI_Model {
	// table name
	private $tbl_ordenPedido= 'ordenpedido';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_ordenPedido);
	}
	// get proyectos with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->select('idOrdenPedido,idEstadoPedido,nroPedido, cliente.idCliente idCliente, fechaPedido, fechaEntrega, nombre cliente_nombre');
		//$this->db->from($this->tbl_ordenPedido);
		$this->db->join('cliente', 'cliente.idCliente = '. $this->tbl_ordenPedido.'.idCliente');
		$this->db->order_by('idOrdenPedido','asc');
		return $this->db->get($this->tbl_ordenPedido, $limit, $offset);
	}
	// get person by id
	function get_by_id($id){
		$this->db->select('idOrdenPedido,idEstadoPedido,nroPedido, cliente.idCliente idCliente, fechaPedido, fechaEntrega, precioTotal, costoTotal, nombre cliente_nombre');
		$this->db->join('cliente', 'cliente.idCliente = '. $this->tbl_ordenPedido.'.idCliente');
		$this->db->where('idOrdenPedido', $id);
		return $this->db->get($this->tbl_ordenPedido);
	}

	function insert($data){
        $this->db->insert($this->tbl_ordenPedido, $data);
        $ultimoId = $this->db->insert_id();

		return $ultimoId;
	}

	function guardar($data){
		$sql = "CALL sp_OrdenPedidoAgregar(?,?,?,?,?,?,?);";
		$params = array($data["idCliente"], 
						$data["fechaPedido"], 
						$data["fechaEntrega"], 
						$data["idEstadoPedido"],
						($data["nroPedido"]=='') ? null : $data["nroPedido"],
						$data["precioTotal"],
						$data["costoTotal"]);
		$query = $this->db->query($sql, $params);

		$res = $query->result();

		$query->next_result();
		$query->free_result();
		//echo $this->db->last_query();
		return $res[0];
	}

	function update($idOrdenPedido, $data){
        $this->db->where('idOrdenPedido', $idOrdenPedido);
        $this->db->update($this->tbl_ordenPedido, $data);
	}

	function delete($idOrdenPedido){
        $this->db->delete($this->tbl_ordenPedido,  array('idOrdenPedido' => $idOrdenPedido));
		return $this->db->insert_id();
	}

	function obtenerOrdenesYDetalles($ids){
		$sql = "CALL sp_OrdenPedidoDetalleEnConjunto(?);";
		$params = array($ids);
		$query = $this->db->query($sql, $params);

		$res = $query->result();

		$query->next_result();
		$query->free_result();
		//echo $this->db->last_query();
		return $res;
	}

}