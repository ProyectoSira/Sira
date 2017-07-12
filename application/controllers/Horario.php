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
        $data['horario'] = $this->horario->get_horario();
       


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