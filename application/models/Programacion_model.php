<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Programacion_model extends CI_Model {

	var $table = 'tbl_programacion';
	var $column_order = array('COD_PROGRA','DOC_EMP','COD_ASIG','COD_AULA','HORA_INI', 'HORA_FIN','DIA_SEM','COD_CAL','COD_GRUPO',null); //set column field database for datatable orderable
	var $column_search = array('COD_PROGRA','DOC_EMP','DIA_SEM'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('COD_PROGRA' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function get_asignatura(){
      $asignatura = $this->db->get('tbl_asignatura');
       if ($asignatura -> num_rows()>0)
       {
       	return $asignatura->result();
       }

	}


	function get_empleado(){
		$this->db->select('*');
		$this->db->from('tbl_empleado');
		$this->db->join('tbl_tipo_empleado','tbl_tipo_empleado.ID_TIP_EMP = tbl_empleado.ID_TIP_EMP');
		$this->db->where('tbl_empleado.ID_TIP_EMP',3);
        $empleado = $this->db->get();
        if ($empleado -> num_rows()>0)
        {
       	return $empleado->result();
        }

	}

	function get_aula(){
      $aula = $this->db->get('tbl_aula');
       if ($aula -> num_rows()>0)
       {
       	return $aula->result();
       }

	}

	function get_calendario(){
      $calendario = $this->db->get('tbl_calendario');
       if ($calendario -> num_rows()>0)
       {
       	return $calendario->result();
       }

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

	private function _get_datatables_query()
	{
		$this->db->select('*');
		$this->db->from('tbl_programacion');
        $this->db->join('tbl_empleado','tbl_empleado.DOC_EMP = tbl_programacion.DOC_EMP');


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

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('COD_PROGRA',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('COD_PROGRA', $id);
		$this->db->delete($this->table);
	}


}