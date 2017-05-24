<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recuperacion extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
 
	public function index()
	{
		$this->load->helper('url');
		$this->load->view('recuperacion_view');
	}

	public function enviarMail()
	{
		//cargamos la libreria email de ci
		$this->load->library("email");
 
		//configuracion para gmail
		$configGmail = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_port' => 465,
			'smtp_user' => 'juanfer.072013.jm@gmail.com',
			'smtp_pass' => '25873468',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		);    
 
		//cargamos la configuración para enviar con gmail
		$this->email->initialize($configGmail);
 
		$this->email->from('juanfer.072013.jm@gmail.com');
		$this->email->to("para quien es");
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
                             <a href="http://localhost:8888/Sira"> Restablecer contraseña </a>
                           </p>
                         </body>
                        </html>';
		$this->email->message($mensaje);
		$this->email->send();
		//con esto podemos ver el resultado
		var_dump($this->email->print_debugger());
	}
 
}