<?php
class M_Usuario extends CI_Model {
	// table name
	private $tbl_usuario= 'usuario';
	private $tbl_accion= 'accion';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	// get number of Clientes in database
	function count_all(){
		return $this->db->count_all($this->tbl_usuario);
	}
	
	// get person by id
	function login($usuario,$password){
		$this->db->where('username', $usuario);
		$this->db->where('pass', $password);

		return $this->db->get($this->tbl_usuario)->result();
	}

	function get_acciones($idRol){
		$this->db->select($this->tbl_accion.'.idAccion, descripcion, label');
		$this->db->from($this->tbl_accion);
		$this->db->join('rol_accion', 'rol_accion.idAccion = '.$this->tbl_accion.'.idAccion');
		$this->db->where('rol_accion.idRol', $idRol);

		return $this->db->get();

		//var_dump($this->db->get()->result());die();

		//echo $this->db->last_query();die();
	}

}