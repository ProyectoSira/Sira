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
	    $data['grado'] = $this->asignacion->get_grado();
	    $data['grupo'] = $this->asignacion->get_grupo();
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

			//add html for action
			$row[] = '<input id="checkAsignar" type="checkbox">';
		
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



}