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
}