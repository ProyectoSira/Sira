<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Periodo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('periodo_model','periodo');
	}

	public function index()
	{
		$this->load->helper('url');
		if(isset($this->session->userdata['logged_in'])){
			if (($this->session->userdata['logged_in']['rol']) != 'Profesor') {
        		$this->load->view('periodo_view');
        	}else{
        		redirect('error');
        	}
        }else{
            redirect('login');
        }        
	}

	public function ajax_list()
	{
		$list = $this->periodo->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $periodo) {
			if (($this->session->userdata['logged_in']['rol']) == 'Coordinador') {
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $periodo->NUM_PER;
				$row[] = $periodo->NOM_PER;
				$row[] = $periodo->FECH_INI_PER;
				$row[] = $periodo->FECH_FIN_PER;


				//add html for action
				$row[] = '<a disabled="true" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>
					  <a disabled="true" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></a>';
			
				$data[] = $row;
			}else{
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $periodo->NUM_PER;
				$row[] = $periodo->NOM_PER;
				$row[] = $periodo->FECH_INI_PER;
				$row[] = $periodo->FECH_FIN_PER;


				//add html for action
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$periodo->COD_PER."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
					  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$periodo->COD_PER."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			
				$data[] = $row;
			}
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->periodo->count_all(),
						"recordsFiltered" => $this->periodo->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->periodo->get_by_id($id);
		$data->FECH_INI_PER = ($data->FECH_INI_PER == '0000-00-00') ? '' : $data->FECH_INI_PER;
		$data->FECH_FIN_PER = ($data->FECH_FIN_PER == '0000-00-00') ? '' : $data->FECH_FIN_PER; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	public function ajax_view($id)
	{
		$data = $this->periodo->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$val = $this->periodo->val_periodo($this->input->post('NOM_PER'));
		if ($this->input->post('FECH_INI_PER') >= $this->input->post('FECH_FIN_PER')) {
			echo json_encode(array("error" => TRUE));
		}
		else if ($val) {
			echo json_encode(array("error" => FALSE));
		}
		else
		{
			$data = array(
				'NUM_PER' => $this->input->post('NUM_PER'),
                'NOM_PER' => $this->input->post('NOM_PER'),
                'FECH_INI_PER' => $this->input->post('FECH_INI_PER'),
                'FECH_FIN_PER' => $this->input->post('FECH_FIN_PER'),
			);
			$insert = $this->periodo->save($data);
			echo json_encode(array("status" => TRUE));
		}
	}



	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'NUM_PER' => $this->input->post('NUM_PER'),
                'NOM_PER' => $this->input->post('NOM_PER'),
                'FECH_INI_PER' => $this->input->post('FECH_INI_PER'),
                'FECH_FIN_PER' => $this->input->post('FECH_FIN_PER'),
			);
		$this->periodo->update(array('COD_PER' => $this->input->post('COD_PER')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->periodo->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('NUM_PER') == '')
		{
			$data['inputerror'][] = 'NUM_PER';
			$data['status'] = FALSE;
		}

        if($this->input->post('NOM_PER') == '')
        {
            $data['inputerror'][] = 'NOM_PER';
            $data['status'] = FALSE;
        }

        if($this->input->post('FECH_INI_PER') == '')
        {
            $data['inputerror'][] = 'FECH_INI_PER';
            $data['status'] = FALSE;
        }

        if($this->input->post('FECH_FIN_PER') == '')
        {
            $data['inputerror'][] = 'FECH_FIN_PER';
            $data['status'] = FALSE;
        }
		
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}