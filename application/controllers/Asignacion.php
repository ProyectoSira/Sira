<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asignacion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Asignacion_model','asignacion');
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->helper('form');
		$grados = $this->asignacion->get_list_Grado();
		$data['grupo'] = $this->asignacion->get_grupo();
		$opt = array('NADA' => '--SELECCIONE--');
		$opt2 = array();
		foreach ($grados as $grados) {
			$opt[$grados] = $grados;
		}
		$data['form_grado'] = form_dropdown('', $opt, '','id="GRADO_EST" class="selectpicker form-control" data-live-search="true"');
		if(isset($this->session->userdata['logged_in'])){
			if (($this->session->userdata['logged_in']['rol']) != 'Profesor') {
        		$this->load->view('asignacion_view', $data );
        	}else{
        		redirect('error');
        	}
		}else{
			redirect('login');
		} 
	}


	public function ajax_list()
	{
		$list = $this->asignacion->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $asignacion) {
			$no++;
			$row = array();
			$row[] = $asignacion->	DOC_EST;
			$row[] = $asignacion->NOM1_EST." ".$asignacion->NOM2_EST." ".$asignacion->APE1_EST." ".$asignacion->APE2_EST;
			$row[] = $asignacion->GRADO_EST;
			//add html for action
			$row[] = '<input type="checkbox" class="data-check" value="'.$asignacion->DOC_EST.'">';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->asignacion->count_all(),
						"recordsFiltered" => $this->asignacion->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}


	public function ajax_registrar()
	{
		$list_id = $this->input->post('id');
		$grupo = $this->input->post('grupo');
		foreach ($list_id as $id) {
			$this->asignacion->save($id, $grupo);
		}
		echo json_encode(array("status" => TRUE));
	}

}