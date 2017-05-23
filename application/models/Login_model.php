<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function get_login($usuario)
	{
		$this->db->select('ID_USU, PASS_USU, ROL_USU, NOM_ROL_USU');
		$this->db->from('tbl_usuario');
		$this->db->join('tbl_rol_usuario', 'tbl_rol_usuario.COD_ROL_USU = tbl_usuario.ROL_USU');
		$this->db->Where('NOM_USU', $usuario);
      	$query = $this->db->get();
	    if ($query -> num_rows()>0)
	    {
	       	return $query->result();
	    }
	}

}