<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asignacion_model extends CI_Model {

	var $table = 'tbl_estudiante';
	var $table1 = 'tbl_grupo_estudio';
	var $column_order = array('DOC_EST','ID_TIP_DOC_EST','COD_DANE_INST','DOC_ACU','NOM1_EST', 'NOM2_EST','APE1_EST', 
	'APE2_EST','GRADO_EST','FECH_NAC_EST','CIU_EST','DIR_EST','TEL1_EST','TEL2_EST','EMAIL_EST',null);
	var $column_search = array('DOC_EST','NOM1_EST','NOM2_EST','APE1_EST','APE2_EST'); 
	var $order = array('DOC_EST' => 'desc'); // default order 
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	

	public function _get_datatables_query()
	{
		if ($this->input->post('GRADO_EST')) {
			$this->db->Where('GRADO_EST', $this->input->post('GRADO_EST'));
		}

		$this->db->select('*')->from('tbl_estudiante');
		$this->db->where('`DOC_EST` NOT IN (SELECT `DOC_EST` FROM `tbl_grupo_estudio`)', NULL, FALSE);

        
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}


	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}


	public function save($id, $grupo)
	{
		$array = array('DOC_EST' => $id, 'COD_GRUPO' => $grupo);
		$this->db->set($array);
		$this->db->insert('tbl_grupo_estudio'); 
		return $this->db->insert_id();
	}

	public function get_list_Grado(){
		$this->db->select('*');
		$this->db->from('tbl_grado');
		$this->db->order_by('COD_GRADO');
		$query = $this->db->get();
		$result = $query->result();

		$grados = array();
		foreach ($result as $row) {
			$grados[] = $row->NOM_GRADO;
		}
		return $grados;
	}

	public function get_grupo(){
       
	    $this->db->select('*');
	    $this->db->from('tbl_grupo');
	    $this->db->join('tbl_grado', 'tbl_grado.COD_GRADO = tbl_grupo.COD_GRADO');
	    $this->db->order_by('NOM_GRADO', 'asc' and 'NUM_GRUPO','asc');
	    $grupo =  $this->db->get();
	    if($grupo -> num_rows()>0)
	    {
	    	return $grupo->result();
	    }
	}

	public function grupo_est($grupo)
	{
		$this->db->select('*');
		$this->db->from('tbl_grupo_estudio');
		$this->db->join('tbl_estudiante','tbl_estudiante.DOC_EST = tbl_grupo_estudio.DOC_EST');
		$this->db->where('COD_GRUPO',$grupo);
		$grupo =  $this->db->get();
	    if($grupo -> num_rows()>0)
	    {
	    	return $grupo->result();
	    }
	}

}

