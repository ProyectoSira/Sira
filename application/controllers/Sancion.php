<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sancion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('sancion_model','sancion');
	}

	public function index()
	{
		$this->load->helper('url');
		$data['tipoSancion'] = $this->sancion->get_tipoSancion();
		$data['empleado'] = $this->sancion->get_empleado();
		$data['estudiante'] = $this->sancion->get_estudiante();
        if(isset($this->session->userdata['logged_in'])){
        	if (($this->session->userdata['logged_in']['rol']) != 'Secretaria') {
        		$this->load->view('sancion_view', $data);
        	}else{
        		redirect('error');
        	}
        }else{
            redirect('login');
        }
	}

	public function ajax_list()
	{
		$list = $this->sancion->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $sancion) {
			$no++;
			$row = array();
			$row[] = $sancion->COD_SANC;
			$row[] = $sancion->NOM_SANC;
			$row[] = $sancion->NOM1_EST." ".$sancion->NOM2_EST." ". $sancion->APE1_EST." ". $sancion->APE2_EST;
			$row[] = $sancion->NOM1_EMP." ".$sancion->NOM2_EMP." ". $sancion->APE1_EMP." ". $sancion->APE2_EMP;
			$row[] = $sancion->RAZON_SANC;
			$row[] = $sancion->FECH_SANC;
			$row[] = $sancion->ESTADO;


			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$sancion->COD_SANC."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$sancion->COD_SANC."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->sancion->count_all(),
						"recordsFiltered" => $this->sancion->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->sancion->get_by_id($id);
		$data->FECH_SANC = ($data->FECH_SANC == '0000-00-00') ? '' : $data->FECH_SANC; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	public function ajax_view($id)
	{
		$data = $this->sancion->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'COD_SANC' => $this->input->post('COD_SANC'),
				'COD_TIP_SANC' => $this->input->post('COD_TIP_SANC'),
                'DOC_EST' => $this->input->post('DOC_EST'),
                'DOC_EMP' => $this->input->post('DOC_EMP'),
                'RAZON_SANC' => $this->input->post('RAZON_SANC'),
                'FECH_SANC' => $this->input->post('FECH_SANC'),
                'ESTADO' => $this->input->post('ESTADO'),
			);
		$insert = $this->sancion->save($data);
		echo json_encode(array("status" => TRUE));
	}



	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'COD_TIP_SANC' => $this->input->post('COD_TIP_SANC'),
                'DOC_EST' => $this->input->post('DOC_EST'),
                'DOC_EMP' => $this->input->post('DOC_EMP'),
                'RAZON_SANC' => $this->input->post('RAZON_SANC'),
                'FECH_SANC' => $this->input->post('FECH_SANC'),
                'ESTADO' => $this->input->post('ESTADO'),
			);
		$this->sancion->update(array('COD_SANC' => $this->input->post('COD_SANC')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->sancion->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('COD_SANC') == '')
		{
			$data['inputerror'][] = 'COD_SANC';
			$data['status'] = FALSE;
		}

		if($this->input->post('COD_TIP_SANC') == '')
		{
			$data['inputerror'][] = 'COD_TIP_SANC';
			$data['status'] = FALSE;
		}

        if($this->input->post('DOC_EST') == '')
        {
            $data['inputerror'][] = 'DOC_EST';
            $data['status'] = FALSE;
        }

        if($this->input->post('DOC_EMP') == '')
        {
            $data['inputerror'][] = 'DOC_EMP';
            $data['status'] = FALSE;
        }

        if($this->input->post('RAZON_SANC') == '')
        {
            $data['inputerror'][] = 'RAZON_SANC';
            $data['status'] = FALSE;
        }

        if($this->input->post('FECH_SANC') == '')
        {
            $data['inputerror'][] = 'FECH_SANC';
            $data['status'] = FALSE;
        }

		if($this->input->post('ESTADO') == '')
		{
			$data['inputerror'][] = 'ESTADO';
			$data['status'] = FALSE;
		}

		
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}