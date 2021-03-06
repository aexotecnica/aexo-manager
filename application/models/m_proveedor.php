<?php
class M_Proveedor extends CI_Model {
	// table name
	private $tbl_proveedor= 'proveedor';
	

	function __construct()
	{
        // Call the Model constructor
		parent::__construct();
	}

	// get number of proyectos in database
	function count_all(){
		return $this->db->count_all($this->tbl_proveedor);
	}
	// get proyectos with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by('idProveedor','asc');
		return $this->db->get($this->tbl_proveedor, $limit, $offset);
	}

	function filter_proveedors($keyword){
		$this->db->select('idProveedor, nombre, cuit, responsable');
		$this->db->where("nombre like '%" . $keyword ."%'");
		$this->db->order_by('nombre','asc');
		return $this->db->get($this->tbl_proveedor);
	}

	function get_by_id($id){
		$this->db->select('idProveedor, nombre, idTipoProveedor, idCategoriaIVA, cuit, domicilio,  
							idProvincia, localidad, partido, codPostal, 
							responsable, email, paginaWeb, latitud, longitud, comentarios');
		$this->db->where("idProveedor",$id);
		$this->db->order_by('nombre','asc');
		return $this->db->get($this->tbl_proveedor);
	}


	function insert($data){
		$this->db->insert($this->tbl_proveedor, $data);
		return $this->db->insert_id();
	}

	function update($idProveedor, $data){
        $this->db->where('idProveedor', $idProveedor);
        $this->db->update($this->tbl_proveedor, $data);
	}

	function delete($idProveedor){
		$this->db->delete($this->tbl_proveedor,  array('idProveedor' => $idProveedor));
	}

	// get proveedors with paging
	function getMapaCompleto(){
		return $this->db->query(sprintf("SELECT nombre,idTipoProveedor,domicilio AS address , latitud as calle_lat , longitud as calle_lng 
										FROM proveedor i 
										INNER JOIN provincia p ON i.idProvincia=p.idprovincia "));
		
	}


	function getMapa($lat,$lng,$radio){
		return $this->db->query(sprintf("SELECT nombre,idTipoProveedor,domicilio AS address , latitud as calle_lat , longitud as  calle_lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( latitud ) ) * cos( radians( longitud ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( `latitud` ) ) ) ) AS distance FROM proveedor i INNER JOIN provincia p ON i.idProvincia=p.idprovincia HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",  $lat,  $lng,  $lat,  $radio));
		
	}

}