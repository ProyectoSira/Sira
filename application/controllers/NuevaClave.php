<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NuevaClave extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Login_model','login');
	}
 
	public function index($usu)
	{
        $data['usuario'] = $usu;
		$this->load->helper('url');
        if(isset($this->session->userdata['logged_in'])){
            redirect('home');
        }else{
            $this->load->view('nuevaClave_view',$data);
        } 
	}

	public function cambiarPass()
	{
		$this->_validate();
		$usu = $this->input->post('nomUsu');
		$pass = $this->input->post('pass1');
		$pass2 = $this->input->post('pass2');
        $val = false;
        $result = $this->login->validarUsuario();
        foreach ($result as $value) {
                if ($value->NOM_USU == $usu) {
                    $val = true;
                }
            }
            if ($val) {
                if ($pass == $pass2) {
                    $data = array(
                        'PASS_USU' => $pass,
                    );
                    $this->login->update(array('NOM_USU' => $usu), $data);
                    echo json_encode(array("status" => TRUE));
                }else{
                    echo json_encode(array("clave" => TRUE));
                }
            }
	}
 
	private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
  
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