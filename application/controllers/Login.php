<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model','login');
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->view('login_view');
	}

	public function iniciar_sesion()
	{
		$this->_validate();
		$pass = $this->input->post('pasWord');
		$usu = $this->input->post('nomUsu');
		$result = $this->login->get_login($usu);
		if ($result != false) {
			foreach ($result as $login) {
				if ($pass == $login->PASS_USU) {
					$sess_array = array();
				    $sess_array = array(
				        'username' => $login->NOM_USU,
				        'rol' => $login->NOM_ROL_USU,
				    );
				    $this->session->set_userdata('logged_in', $sess_array);
				    echo json_encode(array("status" => TRUE));
				}
			}
		}
	}

	function logout()
	{
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('login');
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
 
        if($this->input->post('pasWord') == '')
        {
            $data['inputerror'][] = 'pasWord';
            $data['error_string'][] = 'La contraseña es obligatoria';
            $data['status'] = FALSE;
        }
  
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

}