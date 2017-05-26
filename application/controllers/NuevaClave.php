<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NuevaClave extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Login_model','login');
	}
 
	public function index()
	{
		$this->load->helper('url');
        if(isset($this->session->userdata['logged_in'])){
            redirect('home');
        }else{
            $this->load->view('nuevaClave_view');
        } 
	}

	public function cambiarPass()
	{
		$this->_validate();
		$usu = $this->input->post('nomUsu');
		$pass = $this->input->post('pass1');
		$pass2 = $this->input->post('pass2');
		if ($pass == $pass2) {
			$data = array(
				'PASS_USU' => $pass,
			);
			$this->login->update(array('NOM_USU' => $usu), $data);
			echo json_encode(array("status" => TRUE));
		}
	}
 
	private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('nomUsu') == '')
        {
            $data['inputerror'][] = 'nomUsu';
            $data['error_string'][] = 'El nombre de usuario es obligatorio';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('pass1') == '')
        {
            $data['inputerror'][] = 'pass1';
            $data['error_string'][] = 'La nueva contraseña es obligatoria';
            $data['status'] = FALSE;
        }

        if($this->input->post('pass2') == '')
        {
            $data['inputerror'][] = 'pass2';
            $data['error_string'][] = 'Debes confirmar la contraseña';
            $data['status'] = FALSE;
        }
  
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

}