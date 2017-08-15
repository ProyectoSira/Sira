<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Llegadatarde_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function save($data)
	{
		$this->db->insert('tbl_llegada_tarde_inst', $data); 
		return $this->db->insert_id();
	}

	public function validar($id, $fecha){
		$this->db->select('*');
		$this->db->from('tbl_llegada_tarde_inst');
		$this->db->where('HUELLA_EST',$id);
		$this->db->where('FECH_INGR',$fecha);
		$query = $this->db->get();
		if ($query->num_rows()>0) {
			return true;
		}else{
			return false;
		}
	}

}