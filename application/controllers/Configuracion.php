<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuracion_model','configuracion');
	}

	public function index()
	{
		$this->load->helper('url');
		if(isset($this->session->userdata['logged_in'])){
        		$this->load->view('configuracion_view');
		}else{
			redirect('login');
		}        

	}

	public function ajax_list()
	{
		$this->db->select('*');
		$this->db->from('tbl_empleado');
		$this->db->join('tbl_tipo_empleado', 'tbl_tipo_empleado.ID_TIP_EMP = tbl_empleado.ID_TIP_EMP');
		$this->db->join('tbl_tipo_documento', 'tbl_tipo_documento.ID_TIP_DOC = tbl_empleado.ID_TIP_DOC');
		$this->db->join('tbl_ciudad', 'tbl_ciudad.COD_CIUDAD = tbl_empleado.CIU_EMP');
		$this->db->where('DOC_EMP', ($this->session->userdata['logged_in']['documento']));
        $data = $this->db->get()->row_array();
		echo json_encode($data);
	}

	public function ajax_editNom()
	{
		$this->_validate();
		if ($this->input->post('DOC_EMP') == ($this->session->userdata['logged_in']['documento'])) {
			$data = array(
				'NOM_USU' => $this->input->post('NOM_USU'),
                );
			$this->configuracion->updateNOM(array('DOC_EMP' => $this->input->post('DOC_EMP')), $data);
			echo json_encode(array("status" => TRUE));
		}else{
			echo json_encode(array("error" => TRUE));
		}
	}

	public function ajax_editPass()
	{
		$this->_validate2();
		$pass1 = $this->input->post('PASS_USU');
		$pass2 = $this->input->post('PASS_USU2');
		if ($this->input->post('NOM_USU2') == ($this->session->userdata['logged_in']['nombre'])) {
			if ($pass1 == $pass2) {
			$data = array(
				'PASS_USU' => $pass1,
                );
			$this->configuracion->updatePass(array('NOM_USU' => $this->input->post('NOM_USU2')), $data);
			echo json_encode(array("status" => TRUE));
			}else{
				echo json_encode(array("error" => TRUE));
			}
		}else{
			echo json_encode(array("error" => FALSE));
		}
	}

	private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('DOC_EMP') == '')
        {
            $data['inputerror'][] = 'DOC_EMP';
            $data['error_string'][] = 'El documento es obligatorio';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('NOM_USU') == '')
        {
            $data['inputerror'][] = 'NOM_USU';
            $data['error_string'][] = 'El nombre de usuario es obligatorio';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    private function _validate2()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('NOM_USU2') == '')
        {
            $data['inputerror'][] = 'NOM_USU2';
            $data['error_string'][] = 'El nombre de usuario es obligatorio';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('PASS_USU') == '')
        {
            $data['inputerror'][] = 'PASS_USU';
            $data['error_string'][] = 'La contrtaseña es obligatoria';
            $data['status'] = FALSE;
        }

        if($this->input->post('PASS_USU2') == '')
        {
            $data['inputerror'][] = 'PASS_USU2';
            $data['error_string'][] = 'La confirmacion de contraseña es obligatoria';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
 
}

