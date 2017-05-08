<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendario extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('calendario_model','calendario');
	}

	public function index()
	{
		$this->load->helper('url');
		$data['periodo'] = $this->calendario->get_periodo();
		$this->load->view('calendario_view', $data);
	}

public function ajax_list()
	{
		$list = $this->calendario->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $calendario) {
			$no++;
			$row = array();
			$row[] = $calendario->COD_CAL;
			$row[] = $calendario->AÑO_CAL;
			$row[] = $calendario->NOM_PER;


			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$calendario->COD_CAL."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$calendario->COD_CAL."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->calendario->count_all(),
						"recordsFiltered" => $this->calendario->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->calendario->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'COD_CAL' => $this->input->post('COD_CAL'),
				'AÑO_CAL' => $this->input->post('AÑO_CAL'),
                'COD_PER' => $this->input->post('COD_PER'),
			);
		$insert = $this->calendario->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'AÑO_CAL' => $this->input->post('AÑO_CAL'),
                'COD_PER' => $this->input->post('COD_PER'),
                );
		$this->calendario->update(array('COD_CAL' => $this->input->post('COD_CAL')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->calendario->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('COD_CAL') == '')
		{
			$data['inputerror'][] = 'COD_CAL';
			$data['status'] = FALSE;
		}

		if($this->input->post('AÑO_CAL') == '')
		{
			$data['inputerror'][] = 'AÑO_CAL';
			$data['status'] = FALSE;
		}

        if($this->input->post('COD_PER') == '')
        {
            $data['inputerror'][] = 'COD_PER';
            $data['status'] = FALSE;
        }

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}