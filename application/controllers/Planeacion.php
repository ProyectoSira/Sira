<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Planeacion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('planeacion_model','planeacion');
	}

	public function index()
	{
		$this->load->helper('url');
		$data['programacion'] = $this->planeacion->get_programacion();
        if(isset($this->session->userdata['logged_in'])){
        	if (($this->session->userdata['logged_in']['rol']) == 'Profesor') {
        		$this->load->view('planeacion_view', $data);
        	}else{
        		redirect('error');
        	}
        }else{
            redirect('login');
        }
	}

	public function ajax_list()
	{
		$list = $this->planeacion->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $planeacion) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $planeacion->URL_ARCHIVO;
			$row[] = $planeacion->COD_PROGRA;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$planeacion->COD_PLANEACION."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$planeacion->COD_PLANEACION."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->planeacion->count_all(),
						"recordsFiltered" => $this->planeacion->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->planeacion->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
                'URL_ARCHIVO' => $this->input->post('url'),
                'COD_PROGRA' => $this->input->post('cod'),
			);
		$insert = $this->planeacion->save($data);
		echo json_encode(array("status" => TRUE));
	}



	public function ajax_update()
	{
		$data = array(
				'URL_ARCHIVO' => $this->input->post('url'),
                'COD_PROGRA' => $this->input->post('cod'),
			);
		$this->planeacion->update(array('COD_PLANEACION' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->planeacion->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


}