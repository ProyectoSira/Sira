<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asignatura extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('asignatura_model','asignatura');
	}

	public function index()
	{
		$this->load->helper('url');
		$data['area'] = $this->asignatura->get_area();
		if(isset($this->session->userdata['logged_in'])){
			if (($this->session->userdata['logged_in']['rol']) != 'Profesor') {
        		$this->load->view('asignatura_view',$data);
        	}else{
        		redirect('error');
        	}
		}else{
			redirect('login');
		}       

	}

public function ajax_list()
	{
		$list = $this->asignatura->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $asignatura) {
			if (($this->session->userdata['logged_in']['rol']) == 'Coordinador') {
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $asignatura->NOM_ASIG;
				$row[] = $asignatura->NOM_AREA;


				//add html for action
				$row[] = '<a class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>
					  <a class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></a>';
			
				$data[] = $row;
			}else{
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $asignatura->NOM_ASIG;
				$row[] = $asignatura->NOM_AREA;


				//add html for action
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$asignatura->COD_ASIG."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
					  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$asignatura->COD_ASIG."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			
				$data[] = $row;
			}
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->asignatura->count_all(),
						"recordsFiltered" => $this->asignatura->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->asignatura->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$val = $this->asignatura->val_asig($this->input->post('NOM_ASIG'));
		if ($val) {
			echo json_encode(array("error" => TRUE));
		}else{
			$data = array(
				'NOM_ASIG' => $this->input->post('NOM_ASIG'),
                'COD_AREA' => $this->input->post('COD_AREA'),
			);
		$insert = $this->asignatura->save($data);
		echo json_encode(array("status" => TRUE));
		}
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'NOM_ASIG' => $this->input->post('NOM_ASIG'),
                'COD_AREA' => $this->input->post('COD_AREA'),
                );
		$this->asignatura->update(array('COD_ASIG' => $this->input->post('COD_ASIG')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->asignatura->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;


		if($this->input->post('NOM_ASIG') == '')
		{
			$data['inputerror'][] = 'NOM_ASIG';
			$data['status'] = FALSE;
		}

        if($this->input->post('COD_AREA') == '')
        {
            $data['inputerror'][] = 'COD_AREA';
            $data['status'] = FALSE;
        }

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}