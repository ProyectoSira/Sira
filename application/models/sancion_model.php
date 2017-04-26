<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sancion_model extends CI_Model {

	var $table = 'tbl_sancion';
	var $column_order = array('COD_SANC','COD_TIP_SANC','DOC_EST','DOC_EMP','RAZON_SANC', 'FECH_SANC','ESTADO',null); //set column field database for datatable orderable
	var $column_search = array('COD_SANC','DOC_EST','FECH_SANC'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('COD_SANC' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function get_tipoSancion(){
      $tipoSancion = $this->db->get('tbl_tipo_sancion');
       if ($tipoSancion -> num_rows()>0)
       {
       	return $tipoSancion->result();
       }

	}

	function get_estudiante(){
      $estudiante = $this->db->get('tbl_estudiante');
       if ($estudiante -> num_rows()>0)
       {
       	return $estudiante->result();
       }

	}

	function get_empleado(){
      $empleado = $this->db->get('tbl_empleado');
       if ($empleado -> num_rows()>0)
       {
       	return $empleado->result();
       }

	}


	private function _get_datatables_query()
	{
		$this->db->select('*');
		$this->db->from('tbl_sancion');
        $this->db->join('tbl_tipo_sancion','tbl_tipo_sancion.COD_TIP_SANC = tbl_sancion.COD_TIP_SANC');
        $this->db->join('tbl_estudiante','tbl_estudiante.DOC_EST = tbl_sancion.DOC_EST');
        $this->db->join('tbl_empleado','tbl_empleado.DOC_EMP = tbl_sancion.DOC_EMP');


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
		$this->db->where('COD_SANC',$id);
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
		$this->db->where('COD_SANC', $id);
		$this->db->delete($this->table);
	}


}