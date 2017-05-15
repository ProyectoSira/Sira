	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Programacion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('programacion_model','programacion');
	}

	public function index()
	{
		$this->load->helper('url');
		$data['asignatura'] = $this->programacion->get_asignatura();
		$data['empleado'] = $this->programacion->get_empleado();
		$data['aula'] = $this->programacion->get_aula();
		$data['calendario'] = $this->programacion->get_calendario();
		$data['grupo'] = $this->programacion->get_grupo();
		$this->load->view('programacion_view', $data);
        

	}

	public function ajax_list()
	{
		$list = $this->programacion->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $programacion) {
			$no++;
			$row = array();
			$row[] = $programacion->COD_PROGRA;
			$row[] = $programacion->DOC_EMP;
			$row[] = $programacion->COD_ASIG;
			$row[] = $programacion->COD_AULA;
			$row[] = $programacion->HORA_INI;
			$row[] = $programacion->HORA_FIN;
			$row[] = $programacion->DIA_SEM;
			$row[] = $programacion->COD_CAL;
			$row[] = $programacion->COD_GRUPO;


			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$programacion->COD_PROGRA."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$programacion->COD_PROGRA."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->programacion->count_all(),
						"recordsFiltered" => $this->programacion->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->programacion->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_view($id)
	{
		$data = $this->programacion->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'COD_PROGRA' => $this->input->post('COD_PROGRA'),
				'DOC_EMP' => $this->input->post('DOC_EMP'),
                'COD_ASIG' => $this->input->post('COD_ASIG'),
                'COD_AULA' => $this->input->post('COD_AULA'),
                'HORA_INI' => $this->input->post('HORA_INI'),
                'HORA_FIN' => $this->input->post('HORA_FIN'),
                'DIA_SEM' => $this->input->post('DIA_SEM'),
                'COD_CAL' => $this->input->post('COD_CAL'),
                'COD_GRUPO' => $this->input->post('COD_GRUPO'),
			);
		$insert = $this->programacion->save($data);
		echo json_encode(array("status" => TRUE));
	}



	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'DOC_EMP' => $this->input->post('DOC_EMP'),
                'COD_ASIG' => $this->input->post('COD_ASIG'),
                'COD_AULA' => $this->input->post('COD_AULA'),
                'HORA_INI' => $this->input->post('HORA_INI'),
                'HORA_FIN' => $this->input->post('HORA_FIN'),
                'DIA_SEM' => $this->input->post('DIA_SEM'),
                'COD_CAL' => $this->input->post('COD_CAL'),
                'COD_GRUPO' => $this->input->post('COD_GRUPO'),
			);
		$this->programacion->update(array('COD_PROGRA' => $this->input->post('COD_PROGRA')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->programacion->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('COD_PROGRA') == '')
		{
			$data['inputerror'][] = 'COD_PROGRA';
			$data['status'] = FALSE;
		}

		if($this->input->post('DOC_EMP') == '')
		{
			$data['inputerror'][] = 'DOC_EMP';
			$data['status'] = FALSE;
		}

        if($this->input->post('COD_ASIG') == '')
        {
            $data['inputerror'][] = 'COD_ASIG';
            $data['status'] = FALSE;
        }

        if($this->input->post('COD_AULA') == '')
        {
            $data['inputerror'][] = 'COD_AULA';
            $data['status'] = FALSE;
        }

        if($this->input->post('HORA_INI') == '')
        {
            $data['inputerror'][] = 'HORA_INI';
            $data['status'] = FALSE;
        }

        if($this->input->post('HORA_FIN') == '')
        {
            $data['inputerror'][] = 'HORA_FIN';
            $data['status'] = FALSE;
        }

		if($this->input->post('DIA_SEM') == '')
		{
			$data['inputerror'][] = 'DIA_SEM';
			$data['status'] = FALSE;
		}

		if($this->input->post('COD_CAL') == '')
		{
			$data['inputerror'][] = 'COD_CAL';
			$data['status'] = FALSE;
		}

		if($this->input->post('COD_GRUPO') == '')
		{
			$data['inputerror'][] = 'COD_GUPO';
			$data['status'] = FALSE;
		}
		
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}