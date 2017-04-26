<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asignacion_model extends CI_Model {

	var $table = 'tbl_estudiante';
	var $column_order = array('DOC_EST','ID_TIP_DOC_EST','COD_DANE_INST','TBL_ACUDIENTE_DOC_ACU','NOM1_EST', 'NOM2_EST','APE1_EST', 
	'APE2_EST','FECH_NAC_EST','CIU_EST','DIR_EST','TEL1_EST','TEL2_EST','EMAIL_EST',null);
	var $column_search = array('DOC_EST','NOM1_EST','APE1_EST'); 
	var $order = array('DOC_EST' => 'desc'); // default order 
	var $gradoEst = 'Primero';
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	function get_grado(){
      $Grado = $this->db->get('tbl_grado');
       if ($Grado -> num_rows()>0)
       {
       	return $Grado->result();
       }

	}	

	

	
	function get_grupo(){
       
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
		$this->db->from('tbl_estudiante');
        $this->db->join('tbl_tipo_documento','tbl_tipo_documento.ID_TIP_DOC = tbl_estudiante.ID_TIP_DOC_EST');
        $this->db->join('tbl_acudiente','tbl_acudiente.DOC_ACU = tbl_estudiante.TBL_ACUDIENTE_DOC_ACU');
        $this->db->join('tbl_institucion','tbl_institucion.COD_DANE_INST = tbl_estudiante.COD_DANE_INST');
        $this->db->where('GRADO_EST', $this->gradoEst);

        
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

	
}
