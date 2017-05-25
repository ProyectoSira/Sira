<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Llegadatarde_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function save($huella, $grupo, $fecha, $hora, $estado)
	{
		$array = array(
			'HUELLA_EST' => $huella, 
			'COD_GRUPO' => $grupo, 
			'FECH_INGR' => $fecha, 
			'HORA_INGR' => $hora,
		    'EST_JUSTIFICADO' => $estado
		);
		$this->db->set($array);
		$this->db->insert('tbl_llegada_tarde_inst'); 
		return $this->db->insert_id();
	}
}