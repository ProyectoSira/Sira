<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuario_model','usuario');
	}

	public function index()
	{
		$this->load->helper('url'); 
		$data['empleado'] = $this->usuario->get_empleado();
		if(isset($this->session->userdata['logged_in'])){
			if (($this->session->userdata['logged_in']['rol']) == 'Coordinador') {
        		$this->load->view('usuario_view',$data);
        	}else{
        		redirect('error');
        	}
		}else{
			redirect('login');
		}        

	}

	public function ajax_registrar()
	{
		$this->_validate();
		$doc = $this->input->post('DOC_EMP');
		$emp = $this->usuario->get_validar($doc);
		if ($emp == false) {
			$data = array(
				'NOM_USU' => $this->input->post('NOM_USU'),
				'PASS_USU' => $this->input->post('PASS_USU'),
                'DOC_EMP' => $doc,
                'ROL_USU' => $this->input->post('ROL_USU'),

			);
			$this->usuario->save($data);
			echo json_encode(array("status" => TRUE));
		}else if ($emp) {
			echo json_encode(array("error" => TRUE));
		}	
	}

	public function ajax_cargar()
	{
        $doc = $this->input->post('DOC_EMP');
		$this->db->select('DOC_EMP,NOM_CARGO_EMP,EMAIL_EMP');
		$this->db->from('tbl_empleado');
		$this->db->join('tbl_tipo_empleado', 'tbl_tipo_empleado.ID_TIP_EMP = tbl_empleado.ID_TIP_EMP');
		$this->db->join('tbl_tipo_documento', 'tbl_tipo_documento.ID_TIP_DOC = tbl_empleado.ID_TIP_DOC');
		$this->db->join('tbl_ciudad', 'tbl_ciudad.COD_CIUDAD = tbl_empleado.CIU_EMP');
		$this->db->where('DOC_EMP', $doc);
        $data = $this->db->get()->row_array();
		echo json_encode($data);
	}

	private function _validate()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('NOM_USU') == '')
        {
            $data['inputerror'][] = 'NOM_USU';
            $data['status'] = FALSE;
        }

        if($this->input->post('PASS_USU') == '')
        {
            $data['inputerror'][] = 'PASS_USU';
            $data['status'] = FALSE;
        }

		if($this->input->post('DOC_EMP') == '')
		{
			$data['inputerror'][] = 'DOC_EMP';
			$data['status'] = FALSE;
		}

		if($this->input->post('ROL_USU') == '')
		{
			$data['inputerror'][] = 'ROL_USU';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}