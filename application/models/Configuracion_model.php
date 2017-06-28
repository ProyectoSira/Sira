<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracion_model extends CI_Model {

	var $table = 'tbl_usuario';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function updateNOM($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function updatePass($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function val_pass($usu, $pass)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('NOM_USU',$usu);
		$this->db->where('PASS_USU',$pass);
		$query = $this->db->get();
		if ($query->num_rows()>0) {
			return true;
		}else{
			return false;
		}
	}

}