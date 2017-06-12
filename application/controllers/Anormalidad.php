<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anormalidad extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('anormalidad_model','anormalidad');
	}

	public function index()
	{
		$this->load->helper('url');
		$data['tipoAnorm'] = $this->anormalidad->get_tipoAnorm();
		$data['programacion'] = $this->anormalidad->get_programacion();
        if(isset($this->session->userdata['logged_in'])){
        	if (($this->session->userdata['logged_in']['rol']) != 'Profesor') {
        		$this->load->view('anormalidad_view',$data);
        	}else{
        		redirect('error');
        	}
        }else{
            redirect('login');
        }

	}

	public function ajax_list()
	{
		$list = $this->anormalidad->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $anormalidad) {
			$no++;
			$row = array();
			$row[] = $anormalidad->NOM_ANORM;
			if ($anormalidad->HORA_INICIO == '0') {
				$row[] = '6:30 am';
			}else if ($anormalidad->HORA_INICIO == '1') {
				$row[] = '7:25 am';
			}else if ($anormalidad->HORA_INICIO == '2') {
				$row[] = '8:20 am';
			}else if ($anormalidad->HORA_INICIO == '3') {
				$row[] = '9:50 am';
			}else if ($anormalidad->HORA_INICIO == '4') {
				$row[] = '10:45 am';
			}else if ($anormalidad->HORA_INICIO == '5') {
				$row[] = '11:40 am';
			}else if ($anormalidad->HORA_INICIO == '6') {
				$row[] = '12:00 pm';
			}else if ($anormalidad->HORA_INICIO == '7') {
				$row[] = '12:55 pm';
			}else if ($anormalidad->HORA_INICIO == '8') {
				$row[] = '1:50 pm';
			}else if ($anormalidad->HORA_INICIO == '9') {
				$row[] = '3:15 pm';
			}else if ($anormalidad->HORA_INICIO == '10') {
				$row[] = '4:10 pm';
			}else if ($anormalidad->HORA_INICIO == '11') {
				$row[] = '5:05 pm';
			}
			if ($anormalidad->HORA_FIN == '0') {
				$row[] = '6:30 am';
			}else if ($anormalidad->HORA_FIN == '1') {
				$row[] = '7:25 am';
			}else if ($anormalidad->HORA_FIN == '2') {
				$row[] = '8:20 am';
			}else if ($anormalidad->HORA_FIN == '3') {
				$row[] = '9:50 am';
			}else if ($anormalidad->HORA_FIN == '4') {
				$row[] = '10:45 am';
			}else if ($anormalidad->HORA_FIN == '5') {
				$row[] = '11:40 am';
			}else if ($anormalidad->HORA_FIN == '6') {
				$row[] = '12:00 pm';
			}else if ($anormalidad->HORA_FIN == '7') {
				$row[] = '12:55 pm';
			}else if ($anormalidad->HORA_FIN == '8') {
				$row[] = '1:50 pm';
			}else if ($anormalidad->HORA_FIN == '9') {
				$row[] = '3:15 pm';
			}else if ($anormalidad->HORA_FIN == '10') {
				$row[] = '4:10 pm';
			}else if ($anormalidad->HORA_FIN == '11') {
				$row[] = '5:05 pm';
			}else if ($anormalidad->HORA_FIN == '12') {
				$row[] = '6:00 pm';
			}
			$row[] = $anormalidad->DESCRIPCION;
			if ($anormalidad->ESTADO == '0') {
				$row[] = 'ACTIVA';
			}else{
				$row[] = 'INACTIVA';
			}
			$row[] = $anormalidad->DIA_SEM;


			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$anormalidad->COD_ANORM."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$anormalidad->COD_ANORM."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->anormalidad->count_all(),
						"recordsFiltered" => $this->anormalidad->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->anormalidad->get_by_id($id);
		echo json_encode($data);
	}



	public function ajax_add()
	{
		$this->_validate();
		if ($this->input->post('HORA_INICIO') >= $this->input->post('HORA_FIN')) {
        	echo json_encode(array("error" => TRUE));        	
        }else{
        	$data = array(
				'COD_TIP_ANORM' => $this->input->post('COD_TIP_ANORM'),
                'HORA_INICIO' => $this->input->post('HORA_INICIO'),
                'HORA_FIN' => $this->input->post('HORA_FIN'),
                'DESCRIPCION' => $this->input->post('DESCRIPCION'),
                'COD_PROGRA' => $this->input->post('COD_PROGRA'),
			);
		$insert = $this->anormalidad->save($data);
		echo json_encode(array("status" => TRUE));
        }
	}



	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'COD_TIP_ANORM' => $this->input->post('COD_TIP_ANORM'),
                'HORA_INICIO' => $this->input->post('HORA_INICIO'),
                'HORA_FIN' => $this->input->post('HORA_FIN'),
                'DESCRIPCION' => $this->input->post('DESCRIPCION'),
                'ESTADO' => $this->input->post('ESTADO'),
                'COD_PROGRA' => $this->input->post('COD_PROGRA'),
			);
		$this->anormalidad->update(array('COD_ANORM' => $this->input->post('COD_ANORM')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->anormalidad->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;


        if($this->input->post('COD_TIP_ANORM') == '')
        {
            $data['inputerror'][] = 'COD_TIP_ANORM';
            $data['status'] = FALSE;
        }

        if($this->input->post('HORA_INICIO') == '')
        {
            $data['inputerror'][] = 'HORA_INICIO';
            $data['status'] = FALSE;
        }

        if($this->input->post('HORA_FIN') == '')
        {
            $data['inputerror'][] = 'HORA_FIN';
            $data['status'] = FALSE;
        }

		if($this->input->post('DESCRIPCION') == '')
		{
			$data['inputerror'][] = 'DESCRIPCION';
			$data['status'] = FALSE;
		}

		if($this->input->post('COD_PROGRA') == '')
		{
			$data['inputerror'][] = 'COD_PROGRA';
			$data['status'] = FALSE;
		}
		
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}