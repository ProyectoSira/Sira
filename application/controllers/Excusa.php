<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excusa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('excusa_model','excusa');
	}

	public function index()
	{
		$this->load->helper('url');
		if(isset($this->session->userdata['logged_in'])){
			if (($this->session->userdata['logged_in']['rol']) != 'Secretaria') {
        		$this->load->view('excusa_view');
        	}else{
        		redirect('error');
        	}
		}else{
			redirect('login');
		}        

	}

public function ajax_list()
	{
		$list = $this->excusa->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $excusa) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $excusa->DOC_EST;
			$row[] = $excusa->NOM1_EST." ".$excusa->NOM2_EST." ". $excusa->APE1_EST." ". $excusa->APE2_EST;
			$row[] = $excusa->FECH_INGR;
				//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit"
			onclick="adjuntar('."'".$excusa->DOC_EST."'".','."'".$excusa->FECH_INGR."'".')"><i class="glyphicon glyphicon-paperclip"></i> Adjuntar</a>';
			
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->excusa->count_all(),
						"recordsFiltered" => $this->excusa->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function ajax_add()
	{
		if ($this->input->post('ruta') == "") {
			echo json_encode(array("status" => FALSE));
		}else{
			$data = array(
				'DOC_EST' => $this->input->post('doc'),
            	'URL_EXC' => $this->input->post('ruta'),
            	'FECH_FALTA' => $this->input->post('fech'),
			);
			$insert = $this->excusa->save($data);
			echo json_encode(array("status" => TRUE));
		}
	}

}