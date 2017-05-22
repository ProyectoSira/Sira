<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes_model extends CI_Model {

	function get_llegadasTarde()
	{
		$this->db->select('*');
		$this->db->from('tbl_llegada_tarde_inst');
		$this->db->join('tbl_estudiante_huella_tbl_dedo',
		'tbl_estudiante_huella_tbl_dedo.HUELLA_EST = tbl_llegada_tarde_inst.HUELLA_EST');
		$this->db->join('tbl_estudiante', 'tbl_estudiante.DOC_EST = tbl_estudiante_huella_tbl_dedo.DOC_EST');
		$this->db->join('tbl_grupo_estudio', 'tbl_grupo_estudio.DOC_EST = tbl_estudiante.DOC_EST');
		$this->db->join('tbl_grupo', 'tbl_grupo.COD_GRUPO = tbl_grupo_estudio.COD_GRUPO');
		$this->db->Where('tbl_llegada_tarde_inst.FECH_INGR', '2017-05-21');
		$query = $this->db->get();
		return $query->result();
	}
}