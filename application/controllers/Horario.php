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
        $data['lunes1'] = $this->horario->get_lunes1();
        $data['lunes2'] = $this->horario->get_lunes2();
        $data['lunes3'] = $this->horario->get_lunes3();
        $data['lunes4'] = $this->horario->get_lunes4();
        $data['lunes5'] = $this->horario->get_lunes5();
        $data['lunes6'] = $this->horario->get_lunes6();
        $data['martes1'] = $this->horario->get_martes1();
        $data['martes2'] = $this->horario->get_martes2();
        $data['martes3'] = $this->horario->get_martes3();
        $data['martes4'] = $this->horario->get_martes4();
        $data['martes5'] = $this->horario->get_martes5();
        $data['martes6'] = $this->horario->get_martes6();
        $data['miercoles1'] = $this->horario->get_miercoles1();
        $data['miercoles2'] = $this->horario->get_miercoles2();
        $data['miercoles3'] = $this->horario->get_miercoles3();
        $data['miercoles4'] = $this->horario->get_miercoles4();
        $data['miercoles5'] = $this->horario->get_miercoles5();
        $data['miercoles6'] = $this->horario->get_miercoles6();
        $data['jueves1'] = $this->horario->get_jueves1();
        $data['jueves2'] = $this->horario->get_jueves2();
        $data['jueves3'] = $this->horario->get_jueves3();
        $data['jueves4'] = $this->horario->get_jueves4();
        $data['jueves5'] = $this->horario->get_jueves5();
        $data['jueves6'] = $this->horario->get_jueves6();
        $data['viernes1'] = $this->horario->get_viernes1();
        $data['viernes2'] = $this->horario->get_viernes2();
        $data['viernes3'] = $this->horario->get_viernes3();
        $data['viernes4'] = $this->horario->get_viernes4();
        $data['viernes5'] = $this->horario->get_viernes5();
        $data['viernes6'] = $this->horario->get_viernes6();


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
            $hora = $this->input->post('ID_DIA');
            $dia_sem =  $this->input->post('DIA_SEM');
            $cal = $this->input->post('COD_CAL');
            $grup = $this->input->post('COD_GRUPO');
			
		
		foreach ($hora as $hora) {
			$this->horario->save($doc_emp, $asign, $aula, $hora, $dia_sem, $cal, $grup);
		}
		echo json_encode(array("status" => TRUE));
	}


	

} 