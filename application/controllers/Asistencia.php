<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asistencia extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('asistencia_model','asistencia');
	}

	public function index()
	{
		$this->load->helper('url');
		$data['estudiante'] = $this->asistencia->get_estudiante();
		$data['grupo'] = $this->asistencia->get_grupo();
		$this->load->view('asistencia_view',$data);
        

	}

public function ajax_list()
	{
		$list = $this->asistencia->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $asistencia) {
			$no++;
			$row = array();
			$row[] = $asistencia->ID_ASIS_CLAS;
			$row[] = $asistencia->NOM1_EST." ".$asistencia->NOM2_EST." ".$asistencia->APE1_EST;
			$row[] = $asistencia->NUM_GRUPO;
			$row[] = $asistencia->FECH_INGR_CLAS;
			$row[] = $asistencia->HORA_INGRESO;
			$row[] = $asistencia->PUNTUALIDAD;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$asistencia->ID_ASIS_CLAS."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$asistencia->ID_ASIS_CLAS."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
		
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

	public function ajax_edit($id)
	{
		$data = $this->asistencia->get_by_id($id);
		$data->FECH_INGR_CLAS = ($data->FECH_INGR_CLAS == '0000-00-00') ? '' : $data->FECH_INGR_CLAS; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'ID_ASIS_CLAS' => $this->input->post('ID_ASIS_CLAS'),
				'DOC_EST' => $this->input->post('DOC_EST'),
				'COD_GRUPO' => $this->input->post('COD_GRUPO'),
				'FECH_INGR_CLAS' => $this->input->post('FECH_INGR_CLAS'),
                'HORA_INGRESO' => $this->input->post('HORA_INGRESO'),
                'PUNTUALIDAD' => $this->input->post('PUNTUALIDAD'),
			);
		$insert = $this->asistencia->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'DOC_EST' => $this->input->post('DOC_EST'),
				'COD_GRUPO' => $this->input->post('COD_GRUPO'),
				'FECH_INGR_CLAS' => $this->input->post('FECH_INGR_CLAS'),
                'HORA_INGRESO' => $this->input->post('HORA_INGRESO'),
                'PUNTUALIDAD' => $this->input->post('PUNTUALIDAD'),
                );
		$this->asistencia->update(array('ID_ASIS_CLAS' => $this->input->post('ID_ASIS_CLAS')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->asistencia->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('ID_ASIS_CLAS') == '')
		{
			$data['inputerror'][] = 'ID_ASIS_CLAS';
			$data['status'] = FALSE;
		}

		if($this->input->post('DOC_EST') == '')
		{
			$data['inputerror'][] = 'DOC_EST';
			$data['status'] = FALSE;
		}
		if($this->input->post('COD_GRUPO') == '')
		{
			$data['inputerror'][] = 'COD_GRUPO';
			$data['status'] = FALSE;
		}
		if($this->input->post('FECH_INGR_CLAS') == '')
		{
			$data['inputerror'][] = 'FECH_INGR_CLAS';
			$data['status'] = FALSE;
		}

        if($this->input->post('HORA_INGRESO') == '')
        {
            $data['inputerror'][] = 'HORA_INGRESO';
            $data['status'] = FALSE;
        }

        if($this->input->post('PUNTUALIDAD') == '')
        {
            $data['inputerror'][] = 'PUNTUALIDAD';
            $data['status'] = FALSE;
        }

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}