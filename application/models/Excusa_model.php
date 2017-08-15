<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excusa_model extends CI_Model {

	var $table = 'tbl_asistencia_clase';
	var $column_order = array('DOC_EST','NOM1_EST', 'NOM2_EST','APE1_EST','APE2_EST',null);
	var $column_order2 = array('DOC_EST','NOM1_EST', 'NOM2_EST','APE1_EST','APE2_EST',null);  //set column field database for datatable orderable
	var $column_search = array('tbl_estudiante.DOC_EST','NOM1_EST','APE1_EST'); 
	var $column_search2 = array('tbl_estudiante.DOC_EST','NOM1_EST','APE1_EST'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('FECH_INGR' => 'desc');
	var $order2 = array('FECH_INGR_CLAS' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$fecha = date('Y-m-j');
    	$nuevafecha = strtotime ( '-3 day' , strtotime ( $fecha ) ) ;
    	$nuevafecha = date ( 'Y-m-j' , $nuevafecha );

    		$this->db->distinct();
			$this->db->select('tbl_estudiante.DOC_EST, NOM1_EST, NOM2_EST, APE1_EST, APE2_EST, FECH_INGR');
			$this->db->from('tbl_estudiante');
	     $this->db->join('tbl_estudiante_huella_tbl_dedo','tbl_estudiante_huella_tbl_dedo.DOC_EST = tbl_estudiante.DOC_EST');
	        $this->db->join('tbl_llegada_tarde_inst','tbl_llegada_tarde_inst.HUELLA_EST = tbl_estudiante_huella_tbl_dedo.HUELLA_EST');
	        $this->db->where("FECH_INGR >", $nuevafecha);
	        $this->db->where("EST_JUSTIFICADO", '0');

        //$this->db->where("`tbl_estudiante.DOC_EST` NOT IN (SELECT `DOC_EST` FROM `tbl_excusa` WHERE `FECH_FALTA` > $nuevafecha)");
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

	private function _get_datatables_query2()
	{
		$fecha = date('Y-m-j');
    	$nuevafecha = strtotime ( '-3 day' , strtotime ( $fecha ) ) ;
    	$nuevafecha = date ( 'Y-m-j' , $nuevafecha );

		$this->db->select('tbl_estudiante.DOC_EST, NOM1_EST, NOM2_EST, APE1_EST, APE2_EST, FECH_INGR_CLAS');
		$this->db->from('tbl_asistencia_clase');
	   $this->db->join('tbl_grupo_estudio','tbl_grupo_estudio.ID_EST_GRUP = tbl_asistencia_clase.ID_GRUP_EST');
	    $this->db->join('tbl_estudiante','tbl_estudiante.DOC_EST = tbl_grupo_estudio.DOC_EST');
	    $this->db->where("FECH_INGR_CLAS >", $nuevafecha);
	    $this->db->where("ESTADO_ASIS_CLAS", '1');

        //$this->db->where("`tbl_estudiante.DOC_EST` NOT IN (SELECT `DOC_EST` FROM `tbl_excusa` WHERE `FECH_FALTA` > $nuevafecha)");
		$i = 0;
	
		foreach ($this->column_search2 as $item) // loop column 
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

				if(count($this->column_search2) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order2[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order2))
		{
			$order = $this->order2;
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

	function get_datatables2()
	{
		$this->_get_datatables_query2();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered2()
	{
		$this->_get_datatables_query2();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

		public function count_all2()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function save($data)
	{
		$this->db->insert('tbl_excusa', $data);
		return $this->db->insert_id();
	}

}