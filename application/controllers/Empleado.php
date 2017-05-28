<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleado extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Empleado_model','empleado');
	}

	public function index()
	{
		$this->load->helper('url');
		$data['tipoDocumento'] = $this->empleado->get_tipodocumento();
		$data['tipoEmpleado'] = $this->empleado->get_tipoEmpleado();
		$data['ciudad'] = $this->empleado->get_ciudad();
		if(isset($this->session->userdata['logged_in'])){
			if (($this->session->userdata['logged_in']['rol']) != 'Profesor') {
        		$this->load->view('empleado_view', $data);
        	}else{
        		redirect('error');
        	}
		}else{
			redirect('login');
		}      
	}

public function ajax_list()
	{
		$list = $this->empleado->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $empleado) {
			if (($this->session->userdata['logged_in']['rol']) == 'Coordinador') {
				$no++;
				$row = array();
				$row[] = '<a class="btn btn-sm btn-default" href="javascript:void(0)" title="Hapus" onclick="view_person('."'".$empleado->DOC_EMP."'".')"><i class="glyphicon glyphicon-eye-open"></i></a>'." ".$empleado->DOC_EMP;
				$row[] = $empleado->SIGLA_DOC;
				$row[] = $empleado->NOM_CARGO_EMP;
				$row[] = $empleado->NOM1_EMP." ".$empleado->NOM2_EMP;
				$row[] = $empleado->APE1_EMP." ".$empleado->APE2_EMP;
				$row[] = $empleado->EMAIL_EMP;
				$row[] = $empleado->TEL1_EMP;
				$row[] = $empleado->TEL2_EMP;



				//add html for action
				$row[] = '<a class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>
					  <a class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></a>';
			
				$data[] = $row;
			}else{
				$no++;
				$row = array();
				$row[] = '<a class="btn btn-sm btn-default" href="javascript:void(0)" title="Hapus" onclick="view_person('."'".$empleado->DOC_EMP."'".')"><i class="glyphicon glyphicon-eye-open"></i></a>'." ".$empleado->DOC_EMP;
				$row[] = $empleado->SIGLA_DOC;
				$row[] = $empleado->NOM_CARGO_EMP;
				$row[] = $empleado->NOM1_EMP." ".$empleado->NOM2_EMP;
				$row[] = $empleado->APE1_EMP." ".$empleado->APE2_EMP;
				$row[] = $empleado->EMAIL_EMP;
				$row[] = $empleado->TEL1_EMP;
				$row[] = $empleado->TEL2_EMP;



				//add html for action
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$empleado->DOC_EMP."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
					  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$empleado->DOC_EMP."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			
				$data[] = $row;
			}
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->empleado->count_all(),
						"recordsFiltered" => $this->empleado->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->empleado->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_view($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_empleado');
		$this->db->where('DOC_EMP', $id);
        $this->db->join('tbl_tipo_documento','tbl_tipo_documento.ID_TIP_DOC = tbl_empleado.ID_TIP_DOC');
        $this->db->join('tbl_tipo_empleado','tbl_tipo_empleado.ID_TIP_EMP = tbl_empleado.ID_TIP_EMP');
        $data = $this->db->get()->row_array();
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'DOC_EMP' => $this->input->post('DOC_EMP'),
				'ID_TIP_DOC' => $this->input->post('ID_TIP_DOC'),
                'ID_TIP_EMP' => $this->input->post('ID_TIP_EMP'),
                'NOM1_EMP' => $this->input->post('NOM1_EMP'),
                'NOM2_EMP' => $this->input->post('NOM2_EMP'),
                'APE1_EMP' => $this->input->post('APE1_EMP'),
                'APE2_EMP' => $this->input->post('APE2_EMP'),
                'CIU_EMP' => $this->input->post('CIU_EMP'),
                'FECH_NAC_EMP' => $this->input->post('FECH_NAC_EMP'),
                'DIR_EMP' => $this->input->post('DIR_EMP'),
                'EMAIL_EMP' => $this->input->post('EMAIL_EMP'),
                'TEL1_EMP' => $this->input->post('TEL1_EMP'),
                'TEL2_EMP' => $this->input->post('TEL2_EMP'),
			);
		$insert = $this->empleado->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'DOC_EMP' => $this->input->post('DOC_EMP'),
				'ID_TIP_DOC' => $this->input->post('ID_TIP_DOC'),
                'ID_TIP_EMP' => $this->input->post('ID_TIP_EMP'),
                'NOM1_EMP' => $this->input->post('NOM1_EMP'),
                'NOM2_EMP' => $this->input->post('NOM2_EMP'),
                'APE1_EMP' => $this->input->post('APE1_EMP'),
                'APE2_EMP' => $this->input->post('APE2_EMP'),
                'CIU_EMP' => $this->input->post('CIU_EMP'),
                'FECH_NAC_EMP' => $this->input->post('FECH_NAC_EMP'),
                'DIR_EMP' => $this->input->post('DIR_EMP'),
                'EMAIL_EMP' => $this->input->post('EMAIL_EMP'),
                'TEL1_EMP' => $this->input->post('TEL1_EMP'),
                'TEL2_EMP' => $this->input->post('TEL2_EMP'),
                );
		$this->empleado->update(array('DOC_EMP' => $this->input->post('DOC_EMP')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->empleado->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('DOC_EMP') == '')
		{
			$data['inputerror'][] = 'DOC_EMP';
			$data['status'] = FALSE;
		}

		if($this->input->post('ID_TIP_DOC') == '')
		{
			$data['inputerror'][] = 'ID_TIP_DOC';
			$data['status'] = FALSE;
		}

        if($this->input->post('ID_TIP_EMP') == '')
        {
            $data['inputerror'][] = 'ID_TIP_EMP';
            $data['status'] = FALSE;
        }


          if($this->input->post('NOM1_EMP') == '')
        {
            $data['inputerror'][] = 'NOM1_EMP';
            $data['status'] = FALSE;
        }

          if($this->input->post('APE1_EMP') == '')
        {
            $data['inputerror'][] = 'APE1_EMP';
            $data['status'] = FALSE;
        }

          if($this->input->post('CIU_EMP') == '')
        {
            $data['inputerror'][] = 'CIU_EMP';
            $data['status'] = FALSE;
        }

          if($this->input->post('FECH_NAC_EMP') == '')
        {
            $data['inputerror'][] = 'FECH_NAC_EMP';
            $data['status'] = FALSE;
        }

          if($this->input->post('EMAIL_EMP') == '')
        {
            $data['inputerror'][] = 'EMAIL_EMP';
            $data['status'] = FALSE;
        }

          if($this->input->post('TEL1_EMP') == '')
        {
            $data['inputerror'][] = 'TEL1_EMP';
            $data['status'] = FALSE;
        }



		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}