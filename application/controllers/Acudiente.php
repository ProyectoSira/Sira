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
		$data['ciudad'] = $this->acudiente->get_ciudad();
		if(isset($this->session->userdata['logged_in'])){
			if (($this->session->userdata['logged_in']['rol']) != 'Profesor') {
        		$this->load->view('acudiente_view', $data);
        	}else{
        		redirect('error');
        	}
		}else{
			redirect('login');
		}     

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
			if (($this->session->userdata['logged_in']['rol']) == 'Coordinador') {
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
				$row[] = '<a class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>
					  <a class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></a>';
			
				$data[] = $row;
			}else{
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
		$mail2 = $this->acudiente->val_email($this->input->post('EMAIL_ACU'));
		$doc = $this->acudiente->val_doc($this->input->post('DOC_ACU'));
		$mail = $this->comprobar_email($this->input->post('EMAIL_ACU'));
		if (strlen($this->input->post('DOC_ACU')) < 7 or strlen($this->input->post('DOC_ACU')) > 11) {
			echo json_encode(array("doc" => TRUE));
		}else if ($doc) {
			echo json_encode(array("valdoc" => TRUE));
		}
		else if ($this->input->post('ID_TIP_DOC') == '1') {
			echo json_encode(array("doc" => FALSE));
		}
		else if ($mail == 0) {
			echo json_encode(array("mail" => TRUE));
		}
		else if ($mail2) {
			echo json_encode(array("mail" => FALSE));
		}
		else{
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
		$data = array(
				'ESTDO_ACU' => 'Inactivo',
			);
		$this->acudiente->update(array('DOC_ACU' => $id), $data);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['status'] = TRUE;

		if($this->input->post('DOC_ACU') == '')
		{
			$data['status'] = FALSE;
		}

		if($this->input->post('ID_TIP_DOC') == '')
		{
			$data['status'] = FALSE;
		}

        if($this->input->post('NOM1_ACU') == '')
        {
            $data['status'] = FALSE;
        }

        if($this->input->post('APE1_ACU') == '')
        {
            $data['status'] = FALSE;
        }

		if($this->input->post('FECH_NAC_ACU') == '')
		{
			$data['status'] = FALSE;
		}

		if($this->input->post('EMAIL_ACU') == '')
		{
			$data['status'] = FALSE;
		}

		if($this->input->post('CIU_ACU') == '')
		{
			$data['status'] = FALSE;
		}

		if($this->input->post('DIR_ACU') == '')
		{
			$data['status'] = FALSE;
		}

        if($this->input->post('TEL1_ACU') == '')
        {
            $data['status'] = FALSE;
        }


		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	function comprobar_email($email){
	   $mail_correcto = 0;
	   //compruebo unas cosas primeras
	   if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
	      if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
	         //miro si tiene caracter .
	         if (substr_count($email,".")>= 1){
	            //obtengo la terminacion del dominio
	            $term_dom = substr(strrchr ($email, '.'),1);
	            //compruebo que la terminación del dominio sea correcta
	            if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
	               //compruebo que lo de antes del dominio sea correcto
	               $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
	               $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
	               if ($caracter_ult != "@" && $caracter_ult != "."){
	                  $mail_correcto = 1;
	               }
	            }
	         }
	      }
	   }
	   if ($mail_correcto)
	      return 1;
	   else
	      return 0;
	}

}