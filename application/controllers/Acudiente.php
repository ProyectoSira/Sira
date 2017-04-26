<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acudiente extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('acudiente_model','acudiente');
	}

	public function index()
	{
		$this->load->helper('url');
		$data['tipoDocumento'] = $this->acudiente->get_tipodocumento();
		$this->load->view('acudiente_view', $data);
        

	}

	public function ajax_view($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_acudiente');
		$this->db->where('DOC_ACU', $id);
        $this->db->join('tbl_tipo_documento','tbl_tipo_documento.ID_TIP_DOC = tbl_acudiente.ID_TIP_DOC');
        $data = $this->db->get()->row_array();
		echo json_encode($data);
	}

	public function ajax_list()
	{
		$list = $this->acudiente->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $acudiente) {
			$no++;
			$row = array();
			$row[] = '<a class="btn btn-sm btn-default" href="javascript:void(0)" title="Hapus" onclick="view_person('."'".$acudiente->DOC_ACU."'".')"><i class="glyphicon glyphicon-eye-open"></i></a>'." ".$acudiente->DOC_ACU;
			$row[] = $acudiente->SIGLA_DOC;
			$row[] = $acudiente->NOM1_ACU." ".$acudiente->NOM2_ACU;
			$row[] = $acudiente->APE1_ACU." ".$acudiente->APE2_ACU;
			$row[] = $acudiente->TEL1_ACU;
			$row[] = $acudiente->TEL2_ACU;
			$row[] = $acudiente->EMAIL_ACU;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$acudiente->DOC_ACU."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$acudiente->DOC_ACU."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->acudiente->count_all(),
						"recordsFiltered" => $this->acudiente->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->acudiente->get_by_id($id);
		$data->FECH_NAC_ACU = ($data->FECH_NAC_ACU == '0000-00-00') ? '' : $data->FECH_NAC_ACU; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'DOC_ACU' => $this->input->post('DOC_ACU'),
				'ID_TIP_DOC' => $this->input->post('ID_TIP_DOC'),
                'NOM1_ACU' => $this->input->post('NOM1_ACU'),
                'NOM2_ACU' => $this->input->post('NOM2_ACU'),
                'APE1_ACU' => $this->input->post('APE1_ACU'),
                'APE2_ACU' => $this->input->post('APE2_ACU'),
                'FECH_NAC_ACU' => $this->input->post('FECH_NAC_ACU'),
				'EMAIL_ACU' => $this->input->post('EMAIL_ACU'),
                'CIU_ACU' => $this->input->post('CIU_ACU'),
                'DIR_ACU' => $this->input->post('DIR_ACU'),
                'TEL1_ACU' => $this->input->post('TEL1_ACU'),
                'TEL2_ACU' => $this->input->post('TEL2_ACU'),
			);
		$insert = $this->acudiente->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'ID_TIP_DOC' => $this->input->post('ID_TIP_DOC'),
				'NOM1_ACU' => $this->input->post('NOM1_ACU'),
				'NOM2_ACU' => $this->input->post('NOM2_ACU'),
				'APE1_ACU' => $this->input->post('APE1_ACU'),
				'APE2_ACU' => $this->input->post('APE2_ACU'),
				'FECH_NAC_ACU' => $this->input->post('FECH_NAC_ACU'),
				'EMAIL_ACU' => $this->input->post('EMAIL_ACU'),
				'CIU_ACU' => $this->input->post('CIU_ACU'),
				'DIR_ACU' => $this->input->post('DIR_ACU'),
				'TEL1_ACU' => $this->input->post('TEL1_ACU'),
				'TEL2_ACU' => $this->input->post('TEL2_ACU'),
			);
		$this->acudiente->update(array('DOC_ACU' => $this->input->post('DOC_ACU')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->acudiente->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('DOC_ACU') == '')
		{
			$data['inputerror'][] = 'DOC_ACU';
			$data['status'] = FALSE;
		}

		if($this->input->post('ID_TIP_DOC') == '')
		{
			$data['inputerror'][] = 'ID_TIP_DOC';
			$data['status'] = FALSE;
		}

        if($this->input->post('NOM1_ACU') == '')
        {
            $data['inputerror'][] = 'NOM1_ACU';
            $data['status'] = FALSE;
        }

        if($this->input->post('APE1_ACU') == '')
        {
            $data['inputerror'][] = 'APE1_ACU';
            $data['status'] = FALSE;
        }

		if($this->input->post('FECH_NAC_ACU') == '')
		{
			$data['inputerror'][] = 'FECH_NAC_ACU';
			$data['status'] = FALSE;
		}

		if($this->input->post('EMAIL_ACU') == '')
		{
			$data['inputerror'][] = 'EMAIL_ACU';
			$data['status'] = FALSE;
		}

		if($this->input->post('CIU_ACU') == '')
		{
			$data['inputerror'][] = 'CIU_ACU';
			$data['status'] = FALSE;
		}

		if($this->input->post('DIR_ACU') == '')
		{
			$data['inputerror'][] = 'DIR_ACU';
			$data['status'] = FALSE;
		}

        if($this->input->post('TEL1_ACU') == '')
        {
            $data['inputerror'][] = 'TEL1_ACU';
            $data['status'] = FALSE;
        }


		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}