<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recuperacion extends CI_Controller
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
        	$this->load->view('recuperacion_view');
        }
	}

	public function enviarMail()
	{
		$this->_validate();
		$usu = $this->input->post('nomUsu');
		$email = $this->input->post('email');
		$verificar = $this->login->get_validarMail($usu);
		$emm = "";
		foreach ($verificar as $fila) {
				$emm = $fila->EMAIL_EMP;
			}
		$convert = strtolower($emm);
		if ($email == $convert) {
			//configuracion para gmail
			$configGmail = array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_user' => 'incsira@gmail.com',
				'smtp_pass' => '@sira12345',
				'mailtype' => 'html',
				'charset' => 'utf-8',
				'wordwrap' => TRUE,
			);    
	 
			//cargamos la configuración para enviar con gmail
			$this->load->library("email", $configGmail);
	 		$this->email->set_newline("\r\n");
			$this->email->from('incsira@gmail.com');
			$this->email->to($email
				);
			$this->email->subject('Recuperacion de contraseña SIRA');
			$mensaje = '<html>
	                         <head>
	                            <title>Restablece tu contraseña</title>
	                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	                         </head>
	                         <body>
	                           <p>Hemos recibido una petición para restablecer la contraseña de tu cuenta.</p>
	                           <p>Si hiciste esta petición, haz clic en el siguiente enlace, si no hiciste esta petición puedes ignorar este correo.</p>
	                           <p>
	                             <strong>Enlace para restablecer tu contraseña</strong><br>
	                             <a href="http://localhost:8888/Sira/index.php/NuevaClave"> Restablecer contraseña </a>
	                           </p>
	                         </body>
	                        </html>';
			$this->email->message($mensaje);
			if ($this->email->send()) {
				echo json_encode(array("status" => TRUE));
			}
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
 
        if($this->input->post('email') == '')
        {
            $data['inputerror'][] = 'email';
            $data['error_string'][] = 'El Correo electronico es obligatorio';
            $data['status'] = FALSE;
        }
  
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

}