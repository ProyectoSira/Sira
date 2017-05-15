<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
	
	function get_user($email, $pwd)
	{
		$this->db->where('NOM_USU', $email);
		$this->db->where('PASS_USU', md5($pwd));
        $query = $this->db->get('tbl_usuario');
		return $query->result();
	}
	
	// get user
	function get_user_by_id($id)
	{
		$this->db->where('ID_USU', $id);
        $query = $this->db->get('tbl_usuario');
		return $query->result();
	}
	
	// insert
	function insert_user($data)
    {
		return $this->db->insert('tbl_usuario', $data);
	}
}?>