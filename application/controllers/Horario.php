<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Horario extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Horario_model','horario');
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->helper('form');
		$data['asignatura'] = $this->horario->get_asignatura();
		$data['empleado'] = $this->horario->get_empleado();
		$data['aula'] = $this->horario->get_aula();
		$data['calendario'] = $this->horario->get_calendario();
		$data['grupo'] = $this->horario->get_grupo();			
        $data['grupo'] = $this->horario->get_grupo();
        $data['lunes1'] = $this->horario->get_horario();
        $data['lunes2'] = $this->horario->get_horario();
        $data['lunes3'] = $this->horario->get_horario();
        $data['lunes4'] = $this->horario->get_horario();
        $data['lunes5'] = $this->horario->get_horario();
        $data['lunes6'] = $this->horario->get_horario();
        $data['martes1'] = $this->horario->get_horario();
        $data['martes2'] = $this->horario->get_horario();
        $data['martes3'] = $this->horario->get_horario();
        $data['martes4'] = $this->horario->get_horario();
        $data['martes5'] = $this->horario->get_horario();
        $data['martes6'] = $this->horario->get_horario();
        $data['miercoles1'] = $this->horario->get_horario();
        $data['miercoles2'] = $this->horario->get_horario();
        $data['miercoles3'] = $this->horario->get_horario();
        $data['miercoles4'] = $this->horario->get_horario();
        $data['miercoles5'] = $this->horario->get_horario();
        $data['miercoles6'] = $this->horario->get_horario();
        $data['jueves1'] = $this->horario->get_horario();
        $data['jueves2'] = $this->horario->get_horario();
        $data['jueves3'] = $this->horario->get_horario();
        $data['jueves4'] = $this->horario->get_horario();
        $data['jueves5'] = $this->horario->get_horario();
        $data['jueves6'] = $this->horario->get_horario();
        $data['viernes1'] = $this->horario->get_horario();
        $data['viernes2'] = $this->horario->get_horario();
        $data['viernes3'] = $this->horario->get_horario();
        $data['viernes4'] = $this->horario->get_horario();
        $data['viernes5'] = $this->horario->get_horario();
        $data['viernes6'] = $this->horario->get_horario();


        
       


		$opt = array('NADA' => '--SELECCIONE--');
		$opt2 = array();
		
		if(isset($this->session->userdata['logged_in'])){
			if (($this->session->userdata['logged_in']['rol']) != 'Secretaria') {
        		$this->load->view('horario_view', $data );
        	}else{
        		redirect('error');
        	}
		}else{
			redirect('login');
		} 
        	
	}

	public function ajax_add()
	{
		
	
		    $doc_emp = $this->input->post('DOC_EMP');
            $asign = $this->input->post('COD_ASIG');
            $aula =  $this->input->post('COD_AULA');
            $horas = $this->input->post('HORA_SEM');
            $dia_sem =  $this->input->post('ID_SEM');
            $cal = $this->input->post('COD_CAL');
            $grup = $this->input->post('COD_GRUPO');
			
		
		foreach ($horas as $value) {
			$this->horario->save($doc_emp, $asign, $aula, $value, $dia_sem, $cal, $grup);
		}
		echo json_encode(array("status" => TRUE));
	}


	

} 