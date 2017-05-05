<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleado_model extends CI_Model {

	var $table = 'tbl_empleado';
	var $column_order = array('DOC_EMP','ID_TIP_DOC','ID_TIP_EMP','NOM1_EMP" "NOM2_EMP','APE1_EMP" "APE2_EMP','CIU_EMP','FECH_NAC_EMP','DIR_EMP','EMAIL_EMP','TEL1_EMP','TEL2_EMP',null); //set column field database for datatable orderable
	var $column_search = array('DOC_EMP','NOM1_EMP','NOM2_EMP'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('DOC_EMP' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function get_tipoDocumento(){
      $tipoDocumento = $this->db->get('tbl_tipo_documento');
       if ($tipoDocumento -> num_rows()>0)
       {
       	return $tipoDocumento->result();
       }

	}

	function get_tipoEmpleado(){
		
      $tipoEmpleado = $this->db->get('tbl_tipo_empleado');
       if ($tipoEmpleado -> num_rows()>0)
       {
       	return $tipoEmpleado->result();
       }

	}


	private function _get_datatables_query()
	{
		
		$this->db->select('*');
		$this->db->from('tbl_empleado');
        $this->db->join('tbl_tipo_documento','tbl_tipo_documento.ID_TIP_DOC = tbl_empleado.ID_TIP_DOC');
        $this->db->join('tbl_tipo_empleado','tbl_tipo_empleado.ID_TIP_EMP = tbl_empleado.ID_TIP_EMP');


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
		$this->db->where('DOC_EMP',$id);
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
		$this->db->where('DOC_EMP', $id);
		$this->db->delete($this->table);
	}


}
