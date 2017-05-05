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
		$opt = array('' => 'Todos los Grados');
		foreach ($grados as $grados) {
			$opt[$grados] = $grados;
		}
		$data['form_grado'] = form_dropdown('', $opt, '','id="GRADO_EST" class="selectpicker form-control" data-live-search="true"');

		$this->load->view('asignacion_view', $data );

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
			$row[] = '<input class="data-check" value="'.$asignacion->DOC_EST.'" type="checkbox">';
		
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
		$list_id = $this->input->post('DOC_EST');
		foreach ($list_id as $id) {
			$data = array(
				'DOC_EST' => $this->input->post($id), 
				'COD_GRUPO' => $this->input->post('COD_GRUPO'),
				);
			$insert = $this->asignacion->insertar($data);
		}
		return json_encode(array("status" => TRUE));
	}

}