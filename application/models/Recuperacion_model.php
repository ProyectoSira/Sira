<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recuperacion_model extends CI_Model {


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function get_validarMail($usu)
	{
		$this->db->select('EMAIL_EMP');
		$this->db->from('tbl_empleado');
		$this->db->join('tbl_usuario', 'tbl_usuario.DOC_EMP = tbl_empleado.DOC_EMP');
		$this->db->Where('NOM_USU',$usu);
      	$query = $this->db->get();
		return $query->result();
	}


}