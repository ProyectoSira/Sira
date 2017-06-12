<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acudiente_model extends CI_Model {

	var $table = 'tbl_acudiente';
	var $column_order = array('DOC_ACU','ID_TIP_DOC','NOM1_ACU" "NOM2_ACU','APE1_ACU" "APE2_ACU','FECH_NAC_ACU','EMAIL_ACU','CIU_ACU','DIR_ACU','TEL1_ACU','TEL2_ACU',null); //set column field database for datatable orderable
	var $column_search = array('DOC_ACU','NOM1_ACU','APE1_ACU'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('DOC_ACU' => 'desc'); // default order 

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

	function get_ciudad(){
      $ciudad = $this->db->get('tbl_ciudad');
       if ($ciudad -> num_rows()>0)
       {
       	return $ciudad->result();
       }

	}

	private function _get_datatables_query()
	{
		$this->db->select('*');
		$this->db->from('tbl_acudiente');
        $this->db->join('tbl_tipo_documento','tbl_tipo_documento.ID_TIP_DOC = tbl_acudiente.ID_TIP_DOC');
        $this->db->where('ESTDO_ACU','Activo');

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
		$this->db->where('DOC_ACU',$id);
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
		$this->db->where('DOC_ACU', $id);
		$this->db->delete($this->table);
	}

	public function val_doc($doc){
		$this->db->select('*');
		$this->db->from('tbl_acudiente');
		$this->db->where('DOC_ACU',$doc);
		$query = $this->db->get();
		if ($query->num_rows()>0) {
			return true;
		}else{
			return false;
		}
	}

	public function val_email($mail){
		$this->db->select('*');
		$this->db->from('tbl_acudiente');
		$this->db->where('EMAIL_ACU',$mail);
		$query = $this->db->get();
		if ($query->num_rows()>0) {
			return true;
		}else{
			return false;
		}
	}
}
