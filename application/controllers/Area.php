<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('area_model','area');
	}

	public function index()
	{
		$this->load->helper('url');
		$data['empleado'] = $this->area->get_empleado();
		if(isset($this->session->userdata['logged_in'])){
			if (($this->session->userdata['logged_in']['rol']) != 'Profesor') {
        		$this->load->view('area_view', $data);
        	}else{
        		redirect('error');
        	}
		}else{
			redirect('login');
		}        

	}

public function ajax_list()
	{
		$list = $this->area->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $area) {
			$no++;
			$row = array();
			$row[] = $area->COD_AREA;
			$row[] = $area->NOM_AREA;
			$row[] = $area->NOM1_EMP." ".$area->NOM2_EMP." ". $area->APE1_EMP." ". $area->APE2_EMP;


			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$area->COD_AREA."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$area->COD_AREA."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->area->count_all(),
						"recordsFiltered" => $this->area->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->area->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'COD_AREA' => $this->input->post('COD_AREA'),
				'NOM_AREA' => $this->input->post('NOM_AREA'),
                'DOC_EMP' => $this->input->post('DOC_EMP'),
			);
		$insert = $this->area->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'NOM_AREA' => $this->input->post('NOM_AREA'),
                'DOC_EMP' => $this->input->post('DOC_EMP'),
                );
		$this->area->update(array('COD_AREA' => $this->input->post('COD_AREA')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->area->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('COD_AREA') == '')
		{
			$data['inputerror'][] = 'COD_AREA';
			$data['status'] = FALSE;
		}

		if($this->input->post('NOM_AREA') == '')
		{
			$data['inputerror'][] = 'NOM_AREA';
			$data['status'] = FALSE;
		}

        if($this->input->post('DOC_EMP') == '')
        {
            $data['inputerror'][] = 'DOC_EMP';
            $data['status'] = FALSE;
        }

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}