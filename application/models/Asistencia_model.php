<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asistencia_model extends CI_Model {
    var $table = 'tbl_grupo_estudio';
	var $column_order = array('ID_EST_GRUP','DOC_EST','COD_GRUPO', null); //set column field database for datatable orderable
	var $column_search = array('NOM1_EST', 'NOM2_EST', 'APE1_EST', 'APE2_EST'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('APE1_EST' => 'asc', 'APE2_EST' =>'asc', 'NOM1_EST' =>'asc', 'NOM2' =>'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function _get_datatables_query()
	{
		if ($this->input->post('COD_GRUPO')) {
			$this->db->Where('COD_GRUPO', $this->input->post('COD_GRUPO'));
		}

		$this->db->select('*');
		$this->db->from('tbl_grupo_estudio');
        $this->db->join('tbl_estudiante','tbl_estudiante.DOC_EST = tbl_grupo_estudio.DOC_EST');


        
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


	public function save($grupo, $fecha)
	{
		$array = array('ID_GRUP_EST' => $grupo,
		 'FECH_INGR_CLAS' => $fecha,
 		);
		$this->db->set($array);
		$this->db->insert('tbl_asistencia_clase'); 
		return $this->db->insert_id();
	}

	public function get_grupo(){
       	$this->db->distinct();
	    $this->db->select('tbl_grupo.COD_GRUPO, NOM_GRADO, NUM_GRUPO');
	    $this->db->from('tbl_grupo');
	    $this->db->join('tbl_grado', 'tbl_grado.COD_GRADO = tbl_grupo.COD_GRADO');
	    $this->db->join('tbl_programacion', 'tbl_programacion.COD_GRUPO = tbl_grupo.COD_GRUPO');
	    $this->db->order_by('NOM_GRADO', 'asc' and 'NUM_GRUPO','asc');
	    $this->db->where('tbl_programacion.DOC_EMP',($this->session->userdata['logged_in']['documento']));
	    $grupo =  $this->db->get();
	    if($grupo -> num_rows()>0)
	    {
	    	return $grupo->result();
	    }
	}

	public function get_grupoEst($id){
		$this->db->select('ID_EST_GRUP');
	    $this->db->from('tbl_grupo_estudio');
	    $this->db->where('DOC_EST',$id);
	    $query = $this->db->get();
	    if($query -> num_rows()>0)
	    {
	    	return $query->result();
	    }
	}

}