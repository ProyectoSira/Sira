<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estudiante_model extends CI_Model {

	var $table = 'tbl_estudiante';
	var $column_order = array('DOC_EST','ID_TIP_DOC_EST','DOC_ACU','NOM1_EST', 'NOM2_EST','APE1_EST', 
	'APE2_EST','FECH_NAC_EST','CIU_EST','DIR_EST','TEL1_EST','TEL2_EST','EMAIL_EST','GRADO_EST',null); //set column field database for datatable orderable
	var $column_search = array('DOC_EST','NOM1_EST','APE1_EST','GRADO_EST'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('DOC_EST' => 'desc'); // default order 

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

	function get_grado(){
      $Grado = $this->db->get('tbl_grado');
       if ($Grado -> num_rows()>0)
       {
       	return $Grado->result();
       }

	}	

	function conTarjeta($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_estudiante_huella_tbl_dedo');
        $this->db->where('DOC_EST',$id);
        $Est = $this->db->get();
        if ($Est -> num_rows()>0)
        {
       		return true;
        }else{
        	return false;
        }
	}

	function get_acudiente(){
      	$this->db->select('*');
		$this->db->from('tbl_acudiente');
        $this->db->where('ESTDO_ACU','Activo');
      	$acudiente = $this->db->get();
       if ($acudiente -> num_rows()>0)
       {
       	return $acudiente->result();
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
		$this->db->from('tbl_estudiante');
        $this->db->join('tbl_tipo_documento','tbl_tipo_documento.ID_TIP_DOC = tbl_estudiante.ID_TIP_DOC_EST');
        $this->db->join('tbl_acudiente','tbl_acudiente.DOC_ACU = tbl_estudiante.DOC_ACU');
        $this->db->where('ESTADO_ACU', 'Activo');

        
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
		$this->db->where('DOC_EST',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function insertarTarjeta($data)
	{
		$this->db->insert('tbl_estudiante_huella_tbl_dedo', $data);
		return $this->db->insert_id();
	}

	public function validarTar($id){
		$this->db->select('*');
		$this->db->from('tbl_estudiante_huella_tbl_dedo');
        $this->db->where('HUELLA_EST',$id);
      	$val = $this->db->get();
        if ($val -> num_rows()>0)
        {
       	 	return true;
        }else{
        	return false;
        }
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function activar($id)
	{
		$data = array(
            'ESTADO_ACU' => 'Activo',
        );
		$this->db->where('DOC_EST', $id);
		$this->db->update('tbl_estudiante', $data);
		return $this->db->affected_rows();
	}

	public function editarTarjeta($where, $data)
	{
		$this->db->update('tbl_estudiante_huella_tbl_dedo', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('DOC_EST', $id);
		$this->db->delete($this->table);
	}

	public function val_doc($doc){
		$this->db->select('*');
		$this->db->from('tbl_estudiante');
		$this->db->where('DOC_EST',$doc);
		$query = $this->db->get();
		if ($query->num_rows()>0) {
			return true;
		}else{
			return false;
		}
	}

	public function val_email($mail){
		$this->db->select('*');
		$this->db->from('tbl_estudiante');
		$this->db->where('EMAIL_EST',$mail);
		$query = $this->db->get();
		if ($query->num_rows()>0) {
			return true;
		}else{
			return false;
		}
	}

	public function inactivos()
	{
		$this->db->select('*');
		$this->db->from('tbl_estudiante');
		$this->db->where('ESTADO_ACU','Inactivo');
		$query = $this->db->get();
		if ($query->num_rows()>0) {
			return $query->result();
		}else{
			return false;
		}
	}

}
