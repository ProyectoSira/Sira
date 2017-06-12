<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificaciones extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->helper('url');
	}

		public function msgNotificaciones()
	{
		$this->db->select('NOM1_EST, NOM2_EST, APE1_EST, APE2_EST');
		$this->db->from('tbl_sancion');
		$this->db->join('tbl_estudiante','tbl_estudiante.DOC_EST = tbl_sancion.DOC_EST');
		$this->db->group_by('tbl_sancion.DOC_EST');
		$this->db->having('COUNT(*) >= 3');
		$query = $this->db->get();
		if ($query -> num_rows()>0)
        {
            $data = $query->row_array();
        }else
        {
        	$data = false;
        }
        echo json_encode($data);
	}

	public function numNotificaciones()
	{
		$this->db->select('DOC_EST');
		$this->db->from('tbl_sancion');
		$this->db->group_by('DOC_EST');
		$this->db->having('COUNT(*) >= 3');
		$query = $this->db->get();
		if ($query -> num_rows()>0)
        {
            $data = $query->num_rows();
        }else
        {
        	$data = false;
        }
        echo json_encode($data);
	}

}