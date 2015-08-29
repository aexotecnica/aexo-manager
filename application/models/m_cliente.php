<?php
class M_Cliente extends CI_Model {
	// table name
	private $tbl_cliente= 'cliente';
	

	function __construct()
	{
        // Call the Model constructor
		parent::__construct();
	}

	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_cliente);
	}
	// get proyectos with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by('idCliente','asc');
		return $this->db->get($this->tbl_cliente, $limit, $offset);
	}

	function filter_clientes($keyword){
		$this->db->select('idCliente, nombre, cuit, responsable');
		$this->db->where("nombre like '%" . $keyword ."%'");
		$this->db->order_by('nombre','asc');
		return $this->db->get($this->tbl_cliente);
	}

	function get_by_id($id){
		$this->db->select('idCliente, nombre, idTipoCliente, idCategoriaIVA, telefono_1, cuit, domicilio, calle, numero, 
							idProvincia, localidad, partido, codigoPostal, 
							responsable, email, paginaWeb, volumenFact, 
							dias_horarios, latitud, longitud, comentarios');
		$this->db->where("idCliente",$id);
		$this->db->order_by('nombre','asc');
		return $this->db->get($this->tbl_cliente);
	}


	function insert($data){
		$this->db->insert($this->tbl_cliente, $data);
		return $this->db->insert_id();
	}

	function update($idCliente, $data){
        $this->db->where('idCliente', $idCliente);
        $this->db->update($this->tbl_cliente, $data);
	}

	function delete($idCliente){
        $this->db->delete($this->tbl_cliente,  array('idCliente' => $idCliente));
	}

	// get Clientes with paging
	function getMapaCompleto(){
		return $this->db->query(sprintf("SELECT nombre,idTipoCliente,domicilio AS address , latitud as calle_lat , longitud as calle_lng 
										FROM cliente i 
										INNER JOIN provincia p ON i.idProvincia=p.idprovincia "));
		
	}


	function getMapa($lat,$lng,$radio){
		return $this->db->query(sprintf("SELECT nombre,idTipoCliente,domicilio AS address , latitud as calle_lat , longitud as  calle_lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( latitud ) ) * cos( radians( longitud ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( `latitud` ) ) ) ) AS distance FROM cliente i INNER JOIN provincia p ON i.idProvincia=p.idprovincia HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",  $lat,  $lng,  $lat,  $radio));
		
	}

}