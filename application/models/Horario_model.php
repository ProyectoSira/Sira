<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Horario_model extends CI_Model {

	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_horario(){
		
		//$this->db->Where('COD_GRUPO', $this->input->post('COD_GRUPO'));
		
	    $this->db->select('*');
	    $this->db->from('tbl_programacion');
	    $this->db->join('tbl_empleado','tbl_empleado.DOC_EMP = tbl_programacion.DOC_EMP');
	    $this->db->join('tbl_asignatura','tbl_asignatura.COD_ASIG = tbl_programacion.COD_ASIG');
	    $this->db->join('tbl_aula','tbl_aula.COD_AULA = tbl_programacion.COD_AULA');
	    $horario =  $this->db->get();
	    if($horario -> num_rows()>0)
	    {
	    	return $horario->result();
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

	public function save($doc_emp, $asign, $aula, $horas, $dia_sem, $cal, $grup)
	{
		$array = array(
					   'DOC_EMP' => $doc_emp,
					   'COD_GRUPO' => $grup,
					   'COD_ASIG' => $asign,
					   'COD_AULA' => $aula,
					   'HORA_SEM' => $horas,
					   'ID_SEM' => $dia_sem,
					   'COD_CAL' => $cal,					   
					   );
		$this->db->set($array);
		$this->db->insert('tbl_programacion'); 
		return $this->db->insert_id();
	}


}

