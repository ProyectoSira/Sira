<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
	
    function get_empleado(){
		$this->db->select('*');
		$this->db->from('tbl_empleado');
        $this->db->where('ESTADO_EMP','Activo');
        $empleado = $this->db->get();
        if ($empleado->num_rows()>0)
        {
       	return $empleado->result();
        }

	}

    function get_validar($emp){
        $this->db->select('DOC_EMP');
        $this->db->from('tbl_usuario');
        $this->db->where('DOC_EMP',$emp);
        $val = $this->db->get();
        if ($val->num_rows()>0)
        {
            return true;
        }else{
            return false;
        }

    }


    public function save($data)
	{
		$this->db->insert('tbl_usuario', $data);
		return $this->db->insert_id();
	}

    public function delete_by_id($id)
    {
        $this->db->where('DOC_EMP', $id);
        $this->db->delete('tbl_usuario');
    }

    public function existe($doc){
        $this->db->select('*');
        $this->db->from('tbl_usuario');
        $this->db->where('DOC_EMP',$doc);
        $query = $this->db->get();
        if ($query->num_rows()>0) {
            return true;
        }else{
            return false;
        }
    }

}?>