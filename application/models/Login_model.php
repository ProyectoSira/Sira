<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function get_login($usu)
	{
		$this->db->select('*');
		$this->db->from('tbl_usuario');
		$this->db->join('tbl_rol_usuario', 'tbl_rol_usuario.COD_ROL_USU = tbl_usuario.ROL_USU');
		$this->db->join('tbl_empleado', 'tbl_empleado.DOC_EMP = tbl_usuario.DOC_EMP');
		$this->db->Where('NOM_USU',$usu);
      	$query = $this->db->get();
		return $query->result();
	}

	function get_menu($rol){
		$this->db->select('NOM_OPC_MENU, ULR_MENU, ICONO');
		$this->db->from('tbl_opcion_menu');
		$this->db->join('tbl_asignacion_rol', 'tbl_asignacion_rol.ID_OPC_MENU = tbl_opcion_menu.ID_OPC_MENU');
		$this->db->Where('tbl_asignacion_rol.ROL_USU',$rol);
      	$query = $this->db->get();
		return $query->result();
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

	public function update($where, $data)
	{
		$this->db->update('tbl_usuario', $data, $where);
		return $this->db->affected_rows();
	}

	public function validarUsuario()
	{
		$this->db->select('NOM_USU');
        $this->db->from('tbl_usuario'); 
        $result = $this->db->get();
        if ($result -> num_rows()>0)
        {
            return $result->result();
        }
	}

	public function get_usuario($email)
	{
		$this->db->select('NOM_USU');
		$this->db->from('tbl_usuario');
		$this->db->join('tbl_empleado', 'tbl_empleado.DOC_EMP = tbl_usuario.DOC_EMP');
		$this->db->Where('tbl_empleado.EMAIL_EMP',$email);
      	$query = $this->db->get();
		return $query->result();
	}
}