<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class estudiante extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Estudiante_model','estudiante');
	}

	public function index()
	{
		$this->load->helper('url');
		$data['tipoDocumento'] = $this->estudiante->get_tipodocumento();
		$data['acudiente'] = $this->estudiante->get_acudiente();
		$data['Grado'] = $this->estudiante->get_grado();
		$data['ciudad'] = $this->estudiante->get_ciudad();
		$this->load->view('person_view', $data);
        

	}

	public function ajax_list()
	{
		$list = $this->estudiante->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $estudiante) {
			$no++;
			$row = array();
			$row[] = '<a class="btn btn-sm btn-default" href="javascript:void(0)" title="Hapus" onclick="view_person('."'".$estudiante->DOC_EST."'".')"><i class="glyphicon glyphicon-eye-open"></i></a>'." ".$estudiante->	DOC_EST;
			$row[] = $estudiante->SIGLA_DOC;
			$row[] = $estudiante->NOM1_EST." ".$estudiante->NOM2_EST;
			$row[] = $estudiante->APE1_EST." ".$estudiante->APE2_EST;
			$row[] = $estudiante->TEL1_EST;
			$row[] = $estudiante->GRADO_EST;
			$row[] = $estudiante->EMAIL_EST;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$estudiante->DOC_EST."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$estudiante->DOC_EST."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->estudiante->count_all(),
						"recordsFiltered" => $this->estudiante->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->estudiante->get_by_id($id);
		$data->FECH_NAC_EST = ($data->FECH_NAC_EST == '0000-00-00') ? '' : $data->FECH_NAC_EST; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	public function ajax_view($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_estudiante');
		$this->db->where('DOC_EST', $id);
        $this->db->join('tbl_tipo_documento','tbl_tipo_documento.ID_TIP_DOC = tbl_estudiante.ID_TIP_DOC_EST');
        $this->db->join('tbl_acudiente','tbl_acudiente.DOC_ACU = tbl_estudiante.DOC_ACU');
        $data = $this->db->get()->row_array();
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'DOC_EST' => $this->input->post('DOC_EST'),
				'ID_TIP_DOC_EST' => $this->input->post('ID_TIP_DOC_EST'),
                'DOC_ACU' => $this->input->post('TBL_ACUDIENTE_DOC_ACU'),
                'NOM1_EST' => $this->input->post('NOM1_EST'),
                'NOM2_EST' => $this->input->post('NOM2_EST'),
                'APE1_EST' => $this->input->post('APE1_EST'),
                'APE2_EST' => $this->input->post('APE2_EST'),
                'FECH_NAC_EST' => $this->input->post('FECH_NAC_EST'),
                'CIU_EST' => $this->input->post('CIU_EST'),
                'DIR_EST' => $this->input->post('DIR_EST'),
                'TEL1_EST' => $this->input->post('TEL1_EST'),
                'TEL2_EST' => $this->input->post('TEL2_EST'),
                'EMAIL_EST' => $this->input->post('EMAIL_EST'),
                'GRADO_EST' => $this->input->post('GRADO_EST'),
			);
		$insert = $this->estudiante->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'ID_TIP_DOC_EST' => $this->input->post('ID_TIP_DOC_EST'),
				'DOC_ACU' => $this->input->post('TBL_ACUDIENTE_DOC_ACU'),
				'NOM1_EST' => $this->input->post('NOM1_EST'),
				'NOM2_EST' => $this->input->post('NOM2_EST'),
				'APE1_EST' => $this->input->post('APE1_EST'),
				'APE2_EST' => $this->input->post('APE2_EST'),
				'FECH_NAC_EST' => $this->input->post('FECH_NAC_EST'),
				'CIU_EST' => $this->input->post('CIU_EST'),
				'DIR_EST' => $this->input->post('DIR_EST'),
				'TEL1_EST' => $this->input->post('TEL1_EST'),
				'TEL2_EST' => $this->input->post('TEL2_EST'),
				'EMAIL_EST' => $this->input->post('EMAIL_EST'),
				'GRADO_EST' => $this->input->post('GRADO_EST'),
			);
		$this->estudiante->update(array('DOC_EST' => $this->input->post('DOC_EST')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$data = array(
				'ESTADO_ACU' => 'Inactivo',
			);
		$this->estudiante->update(array('DOC_EST' => $id), $data);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('DOC_EST') == '')
		{
			$data['inputerror'][] = 'DOC_EST';
			$data['status'] = FALSE;
		}

		if($this->input->post('ID_TIP_DOC_EST') == '')
		{
			$data['inputerror'][] = 'ID_TIP_DOC_EST';
			$data['status'] = FALSE;
		}

        if($this->input->post('TBL_ACUDIENTE_DOC_ACU') == '')
        {
            $data['inputerror'][] = 'TBL_ACUDIENTE_DOC_ACU';
            $data['status'] = FALSE;
        }

        if($this->input->post('NOM1_EST') == '')
        {
            $data['inputerror'][] = 'NOM1_EST';
            $data['status'] = FALSE;
        }

        if($this->input->post('APE1_EST') == '')
        {
            $data['inputerror'][] = 'APE1_EST';
            $data['status'] = FALSE;
        }

        if($this->input->post('GRADO_EST') == '')
        {
            $data['inputerror'][] = 'GRADO_EST';
            $data['status'] = FALSE;
        }

		if($this->input->post('FECH_NAC_EST') == '')
		{
			$data['inputerror'][] = 'FECH_NAC_EST';
			$data['status'] = FALSE;
		}

		if($this->input->post('CIU_EST') == '')
		{
			$data['inputerror'][] = 'CIU_EST';
			$data['status'] = FALSE;
		}

		if($this->input->post('DIR_EST') == '')
		{
			$data['inputerror'][] = 'DIR_EST';
			$data['status'] = FALSE;
		}

        if($this->input->post('TEL1_EST') == '')
        {
            $data['inputerror'][] = 'TEL1_EST';
            $data['status'] = FALSE;
        }

        if($this->input->post('EMAIL_EST') == '')
        {
            $data['inputerror'][] = 'EMAIL_EST';
            $data['status'] = FALSE;
        }

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}
