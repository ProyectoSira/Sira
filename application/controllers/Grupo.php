<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grupo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('grupo_model','grupo');
	}

	public function index()
	{
		$this->load->helper('url');
		$data['empleado'] = $this->grupo->get_empleado();
		$data['grado'] = $this->grupo->get_grado();
		$data['jornada'] = $this->grupo->get_jornada();
        if(isset($this->session->userdata['logged_in'])){
        	if (($this->session->userdata['logged_in']['rol']) != 'Profesor') {
        		$this->load->view('grupo_view',$data);
        	}else{
        		redirect('error');
        	}
		}else{
			redirect('login');
		} 
	}

public function ajax_list()
	{
		$list = $this->grupo->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $grupo) {
			$no++;
			$row = array();
			$row[] = $grupo->NUM_GRUPO;
			$row[] = $grupo->NOM_GRADO;
			$row[] = $grupo->NOM1_EMP." ". $grupo->NOM2_EMP." ". $grupo->APE1_EMP ." ". $grupo->APE2_EMP;
			$row[] = $grupo->TBL_JORNADA_COD_JOR;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$grupo->COD_GRUPO."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$grupo->COD_GRUPO."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->grupo->count_all(),
						"recordsFiltered" => $this->grupo->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->grupo->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'NUM_GRUPO' => $this->input->post('NUM_GRUPO'),
				'COD_GRADO' => $this->input->post('COD_GRADO'),
				'DOC_EMP' => $this->input->post('DOC_EMP'),
                'TBL_JORNADA_COD_JOR' => $this->input->post('TBL_JORNADA_COD_JOR'),
			);
		$insert = $this->grupo->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'NUM_GRUPO' => $this->input->post('NUM_GRUPO'),
				'COD_GRADO' => $this->input->post('COD_GRADO'),
				'DOC_EMP' => $this->input->post('DOC_EMP'),
                'TBL_JORNADA_COD_JOR' => $this->input->post('TBL_JORNADA_COD_JOR'),
                );
		$this->grupo->update(array('COD_GRUPO' => $this->input->post('COD_GRUPO')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->grupo->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('NUM_GRUPO') == '')
		{
			$data['inputerror'][] = 'NUM_GRUPO';
			$data['status'] = FALSE;
		}
		if($this->input->post('COD_GRADO') == '')
		{
			$data['inputerror'][] = 'COD_GRADO';
			$data['status'] = FALSE;
		}
		if($this->input->post('DOC_EMP') == '')
		{
			$data['inputerror'][] = 'DOC_EMP';
			$data['status'] = FALSE;
		}

        if($this->input->post('TBL_JORNADA_COD_JOR') == '')
        {
            $data['inputerror'][] = 'TBL_JORNADA_COD_JOR';
            $data['status'] = FALSE;
        }

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}


