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
		if(isset($this->session->userdata['logged_in'])){
		redirect('home');
		}else{
			$this->load->view('login_view');
		} 
	}

	public function iniciar_sesion()
	{
		$this->_validate();
		$usu = $this->input->post('nomUsu');
		$pass = $this->input->post('pasWord');
		$entrar = $this->login->get_login($usu);
		$passw = "";
		$nomRol = "";
		$idRol = "";
		$doc = "";
		$nombre = "";
		if ($entrar != false) {
			foreach ($entrar as $fila) {
				$passw = $fila->PASS_USU;
				$nomRol = $fila->NOM_ROL_USU;
				$idRol = $fila->ROL_USU;
				$usu = $fila->NOM1_EMP;
				$nombre = $fila->NOM_USU;
				$doc = $fila->DOC_EMP;
			}
			if ($pass == $passw) {
				$pintar = $this->login->get_menu($idRol);
				$menu = "";
				foreach ($pintar as $value) {
					$menu .= "<li><a href='".$value->ULR_MENU."'>
                        <i class='".$value->ICONO."'></i> <span> ".$value->NOM_OPC_MENU."</span></a>
                        </li>";
				}
				$sess_array = array();
				$sess_array = array(
				    'username' => $usu,
				    'nombre' => $nombre,
				    'rol' => $nomRol,
				    'menu' => $menu,
				    'documento' => $doc,
				    'msgNoty' => '',
				    'numNoty' => '',
				);
				$this->session->set_userdata('logged_in', $sess_array);
				echo json_encode(array("status" => TRUE));
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