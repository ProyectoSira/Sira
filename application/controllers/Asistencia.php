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
		$data['estudiante'] = $this->asistencia->get_estudiante();
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
			$row[] = $asistencia->DOC_EST;
			$row[] = $asistencia->APE1_EST." ".$asistencia->APE2_EST." ".$asistencia->NOM1_EST." ".$asistencia->NOM2_EST;
			$row[] = '<input type="checkbox" class="data-check" value="'.$asistencia->DOC_EST.'">';
		
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
		$documento = $this->input->post('doc');
		$estado = array($this->input->post('estado'));
		$justificacion = $this->input->post('just');
		$fecha = date('Y-m-d');
		$id = '';
		foreach ($documento as $value) {
			$grupo = $this->asistencia->get_grupoEst($value);
			foreach ($grupo as $value2) {
				$id = $value2->ID_EST_GRUP;
			}
			$this->asistencia->save($id, $fecha);
		}
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_consultar()
	{
		$documento = $this->input->post('doc');
		$val = $this->asistencia->validar($documento);
		$arr = array();
		if ($val == false) {
			echo json_encode(array("status" => TRUE));
		}else{
			$data = $this->asistencia->excusas($documento);
			foreach ($data as $value) {
				$row = array(
					'doc' => $value->DOC_EST,
					'nom1' => $value->NOM1_EST,
					'nom2' => $value->NOM2_EST,
					'ape1' => $value->APE1_EST,
					'ape2' => $value->APE2_EST,
					'fecha' => $value->FECH_FALTA,
					'url' => $value->URL_EXC);
				$arr[] = $row;
			}
			echo json_encode($arr);
		}
	}

}