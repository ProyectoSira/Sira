<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asistencia extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Asistencia_model','asistencia');
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->helper('form');
		$data['grupo'] = $this->asistencia->get_grupo();
		if(isset($this->session->userdata['logged_in'])){
			if (($this->session->userdata['logged_in']['rol']) != 'Secretaria') {
        		$this->load->view('asistencia_view', $data );
        	}else{
        		redirect('error');
        	}
		}else{
			redirect('login');
		} 
	}


	public function ajax_list()
	{
		$list = $this->asistencia->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $asistencia) {
			$var = $asistencia->COD_GRUPO;
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $asistencia->APE1_EST." ".$asistencia->APE2_EST." ".$asistencia->NOM1_EST." ".$asistencia->NOM2_EST;
			$row[] = '<input type="checkbox" class="data-check">';
			$row[] = '<input type="checkbox" class="data-check2">';
			$row[] = '<input type="text" class="form-control" id="text-hora">';
			$row[] = '<input type="text" class="form-control" id="text-obser">';
			$row[] = '<input type="checkbox" class="data-check3">';
			$row[] = '<input type="checkbox" class="data-check3">';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->asistencia->count_all(),
						"recordsFiltered" => $this->asistencia->count_filtered(),
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
			$this->asistencia->save($id, $grupo);
		}
		echo json_encode(array("status" => TRUE));
	}

}