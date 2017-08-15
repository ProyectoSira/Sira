<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes_model extends CI_Model {

	function get_llegadasTarde($dia)
	{
		$this->db->select('*');
		$this->db->from('tbl_llegada_tarde_inst');
		$this->db->join('tbl_estudiante_huella_tbl_dedo',
		'tbl_estudiante_huella_tbl_dedo.HUELLA_EST = tbl_llegada_tarde_inst.HUELLA_EST');
		$this->db->join('tbl_estudiante', 'tbl_estudiante.DOC_EST = tbl_estudiante_huella_tbl_dedo.DOC_EST');
		$this->db->join('tbl_grupo_estudio', 'tbl_grupo_estudio.DOC_EST = tbl_estudiante.DOC_EST');
		$this->db->join('tbl_grupo', 'tbl_grupo.COD_GRUPO = tbl_grupo_estudio.COD_GRUPO');
		$this->db->Where('tbl_llegada_tarde_inst.FECH_INGR',$dia);
		$query = $this->db->get();
		return $query->result();
	}

	function get_llegadasTardeRango($inicio, $fin)
	{
		$this->db->select('*');
		$this->db->from('tbl_llegada_tarde_inst');
		$this->db->join('tbl_estudiante_huella_tbl_dedo',
		'tbl_estudiante_huella_tbl_dedo.HUELLA_EST = tbl_llegada_tarde_inst.HUELLA_EST');
		$this->db->join('tbl_estudiante', 'tbl_estudiante.DOC_EST = tbl_estudiante_huella_tbl_dedo.DOC_EST');
		$this->db->join('tbl_grupo_estudio', 'tbl_grupo_estudio.DOC_EST = tbl_estudiante.DOC_EST');
		$this->db->join('tbl_grupo', 'tbl_grupo.COD_GRUPO = tbl_grupo_estudio.COD_GRUPO');
		$this->db->Where("tbl_llegada_tarde_inst.FECH_INGR BETWEEN '$inicio' AND '$fin'");
		$query = $this->db->get();
		return $query->result();
	}

	function get_sanciones($dia)
	{
		$this->db->select('*');
		$this->db->from('tbl_sancion');
		$this->db->join('tbl_tipo_sancion','tbl_tipo_sancion.COD_TIP_SANC = tbl_sancion.COD_TIP_SANC');
		$this->db->join('tbl_estudiante', 'tbl_estudiante.DOC_EST = tbl_sancion.DOC_EST');
		//$this->db->join('tbl_grupo_estudio', 'tbl_grupo_estudio.DOC_EST = tbl_estudiante.DOC_EST');
		//$this->db->join('tbl_grupo', 'tbl_grupo.COD_GRUPO = tbl_grupo_estudio.COD_GRUPO');
		$this->db->Where('FECH_SANC',$dia);
		$query = $this->db->get();
		return $query->result();
	}

	function get_sancionesRango($inicio, $fin)
	{
		$this->db->select('*');
		$this->db->from('tbl_sancion');
		$this->db->join('tbl_tipo_sancion','tbl_tipo_sancion.COD_TIP_SANC = tbl_sancion.COD_TIP_SANC');
		$this->db->join('tbl_estudiante', 'tbl_estudiante.DOC_EST = tbl_sancion.DOC_EST');
		//$this->db->join('tbl_grupo_estudio', 'tbl_grupo_estudio.DOC_EST = tbl_estudiante.DOC_EST');
		//$this->db->join('tbl_grupo', 'tbl_grupo.COD_GRUPO = tbl_grupo_estudio.COD_GRUPO');
		$this->db->Where("FECH_SANC BETWEEN '$inicio' AND '$fin'");
		$query = $this->db->get();
		return $query->result();
	}

	function get_clases($dia)
	{
		$this->db->select('*');
		$this->db->from('tbl_asistencia_clase');
		$this->db->join('tbl_grupo_estudio','tbl_grupo_estudio.ID_EST_GRUP = tbl_asistencia_clase.ID_GRUP_EST');
		$this->db->join('tbl_estudiante', 'tbl_estudiante.DOC_EST = tbl_grupo_estudio.DOC_EST');
		//$this->db->join('tbl_grupo_estudio', 'tbl_grupo_estudio.DOC_EST = tbl_estudiante.DOC_EST');
		//$this->db->join('tbl_grupo', 'tbl_grupo.COD_GRUPO = tbl_grupo_estudio.COD_GRUPO');
		$this->db->Where('FECH_INGR_CLAS',$dia);
		$query = $this->db->get();
		return $query->result();
	}

	function get_clasesRango($inicio, $fin)
	{
		$this->db->select('*');
		$this->db->from('tbl_asistencia_clase');
		$this->db->join('tbl_grupo_estudio','tbl_grupo_estudio.ID_EST_GRUP = tbl_asistencia_clase.ID_GRUP_EST');
		$this->db->join('tbl_estudiante', 'tbl_estudiante.DOC_EST = tbl_grupo_estudio.DOC_EST');
		//$this->db->join('tbl_grupo_estudio', 'tbl_grupo_estudio.DOC_EST = tbl_estudiante.DOC_EST');
		//$this->db->join('tbl_grupo', 'tbl_grupo.COD_GRUPO = tbl_grupo_estudio.COD_GRUPO');
		$this->db->Where("FECH_INGR_CLAS BETWEEN '$inicio' AND '$fin'");
		$query = $this->db->get();
		return $query->result();
	}
}