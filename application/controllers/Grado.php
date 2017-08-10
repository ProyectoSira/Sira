<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grado extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('grado_model','grado');
	}

	public function index()
	{
		$this->load->helper('url');
        if(isset($this->session->userdata['logged_in'])){
        	if (($this->session->userdata['logged_in']['rol']) != 'Profesor') {
        		$this->load->view('grado_view');
        	}else{
        		redirect('error');
        	}
		}else{
			redirect('login');
		} 
	}

public function ajax_list()
	{
		$list = $this->grado->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $grado) {
			if (($this->session->userdata['logged_in']['rol']) == 'Coordinador') {
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $grado->NOM_GRADO;


				//add html for action
				$row[] = '<a disabled="true" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>
					  <a disabled="true" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></a>';
			
				$data[] = $row;
			}else{
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $grado->NOM_GRADO;


				//add html for action
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$grado->COD_GRADO."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
					  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$grado->COD_GRADO."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			
				$data[] = $row;
			}
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->grado->count_all(),
						"recordsFiltered" => $this->grado->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->grado->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$val = $this->grado->val_grado($this->input->post('NOM_GRADO'));
		if ($val) {
			echo json_encode(array("error" => TRUE));
		}else{
			$data = array(
				'NOM_GRADO' => $this->input->post('NOM_GRADO'),
			);
		$insert = $this->grado->save($data);
		echo json_encode(array("status" => TRUE));
		}
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'NOM_GRADO' => $this->input->post('NOM_GRADO'),
                );
		$this->grado->update(array('COD_GRADO' => $this->input->post('COD_GRADO')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->grado->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('NOM_GRADO') == '')
		{
			$data['inputerror'][] = 'NOM_GRADO';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}