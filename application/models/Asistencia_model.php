<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asistencia_model extends CI_Model {
    var $table = 'tbl_asistencia_clase';
	var $column_order = array('ID_ASIS_CLAS','DOC_EST','COD_GRUPO','FECH_INGR_CLAS','HORA_INGRESO', 'PUNTUALIDAD', null); //set column field database for datatable orderable
	var $column_search = array('ID_ASIS_CLAS','DOC_EST','COD_GRUPO'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('ID_ASIS_CLAS' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{

		$this->db->select('*');
		$this->db->from('tbl_asistencia_clase');
		$this->db->join('tbl_estudiante', 'tbl_estudiante.DOC_EST = tbl_asistencia_clase.DOC_EST');
        $this->db->join('tbl_grupo', 'tbl_grupo.COD_GRUPO = tbl_asistencia_clase.COD_GRUPO');

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
	function get_estudiante(){
      $estudiante = $this->db->get('tbl_estudiante');
       if ($estudiante -> num_rows()>0)
       {
       	return $estudiante->result();
       }

	}
	function get_grupo(){
       $this->db->select('*');
      $this->db->from('tbl_grupo');
      $this->db->join('tbl_grado', 'tbl_grado.COD_GRADO = tbl_grupo.COD_GRADO');
     // $this->db->order_by('NUM_GRUPO','asc');
      $this->db->order_by('NOM_GRADO', 'asc' and 'NUM_GRUPO','asc');
     $grupo =  $this->db->get();
     if($grupo -> num_rows()>0)
     {

      return $grupo->result();
     }
	}
	function get_jornada(){

	      $this->db->select('*');
		  $this->db->from('tbl_jornada');
		  $this->db->join('tbl_tip_jornada', 'tbl_tip_jornada.ID_TIP_JORN = tbl_jornada.ID_TIP_JORN ');
		  
          $jornada = $this->db->get();
          if ($jornada ->num_rows()>0) {
            return $jornada->result();
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

	 function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	 function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('ID_ASIS_CLAS',$id);
		$query = $this->db->get();

		return $query->row();
	}

	 function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	 function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	 function delete_by_id($id)
	{
		$this->db->where('ID_ASIS_CLAS', $id);
		$this->db->delete($this->table);
	}


}