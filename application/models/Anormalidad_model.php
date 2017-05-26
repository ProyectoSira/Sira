<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anormalidad_model extends CI_Model {

	var $table = 'tbl_anorm';
	var $column_order = array('COD_TIP_ANORM','HORA_INICIO','HORA_FIN','DESCRIPCION','ESTADO', 'COD_PROGRA',null); //set column field database for datatable orderable
	var $column_search = array('ESTADO','DIA_SEM'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('COD_ANORM' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function get_tipoAnorm(){
       $grado = $this->db->get('tbl_tipo_anormalidad');
      if ($grado ->num_rows()>0) 
      {
      	return $grado->result();
      }
	}

	function get_programacion(){
       $grado = $this->db->get('tbl_programacion');
      if ($grado ->num_rows()>0) 
      {
      	return $grado->result();
      }

	}


	private function _get_datatables_query()
	{
		$this->db->select('*');
		$this->db->from('tbl_anorm');
        $this->db->join('tbl_tipo_anormalidad','tbl_tipo_anormalidad.COD_TIP_ANORM = tbl_anorm.COD_TIP_ANORM');
        $this->db->join('tbl_programacion','tbl_programacion.COD_PROGRA = tbl_anorm.COD_PROGRA');


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
		$this->db->where('COD_ANORM',$id);
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
		$this->db->where('COD_ANORM', $id);
		$this->db->delete($this->table);
	}


}