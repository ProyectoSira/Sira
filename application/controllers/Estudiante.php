<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estudiante extends CI_Controller {

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
		if(isset($this->session->userdata['logged_in'])){
			if (($this->session->userdata['logged_in']['rol']) != 'Profesor') {
        		$this->load->view('estudiante_view', $data);
        	}else{
        		redirect('error');
        	}
        }else{
            redirect('login');
        }       
	}

	public function ajax_list()
	{
		$list = $this->estudiante->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $estudiante) {
			$tar = $this->estudiante->conTarjeta($estudiante->DOC_EST);
			if ($tar) {
				$validarBotn = true;
			}else{
				$validarBotn = false;
			}
			if (($this->session->userdata['logged_in']['rol']) == 'Coordinador') {
				$no++;
				$row = array();
				$row[] = '<a class="btn btn-sm btn-default" href="javascript:void(0)" title="Ver" onclick="view_person('."'".$estudiante->DOC_EST."'".')"><i class="glyphicon glyphicon-eye-open"></i></a>'." ".$estudiante->DOC_EST;
				$row[] = $estudiante->NOM1_EST." ".$estudiante->NOM2_EST;
				$row[] = $estudiante->APE1_EST." ".$estudiante->APE2_EST;
				$row[] = $estudiante->TEL1_EST;
				$row[] = $estudiante->GRADO_EST;
				$row[] = $estudiante->EMAIL_EST;

				//add html for action
				$row[] = '<a disabled="true" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>
					  <a disabled="true" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></a>';

				if ($validarBotn) {
					$row[] = '<a disabled="true" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-ok"></i></a>';
				}else{
					$row[] = '<a disabled="true" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-remove"></i></a>';
				}
			
				$data[] = $row;
			}else{
				$no++;
				$row = array();
				$row[] = '<a class="btn btn-sm btn-default" href="javascript:void(0)" title="Ver" onclick="view_person('."'".$estudiante->DOC_EST."'".')"><i class="glyphicon glyphicon-eye-open"></i></a>'." ".$estudiante->DOC_EST;
				$row[] = $estudiante->NOM1_EST." ".$estudiante->NOM2_EST;
				$row[] = $estudiante->APE1_EST." ".$estudiante->APE2_EST;
				$row[] = $estudiante->TEL1_EST;
				$row[] = $estudiante->GRADO_EST;
				$row[] = $estudiante->EMAIL_EST;

				//add html for action
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="edit_person('."'".$estudiante->DOC_EST."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
					  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Eliminar" onclick="delete_person('."'".$estudiante->DOC_EST."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
				if ($validarBotn) {
					$row[] = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Cambiar Tarjeta" onclick="AsignarTarjeta2('."'".$estudiante->DOC_EST."'".')"><i class="glyphicon glyphicon-ok"></i></a>';
				}else{
					$row[] = '<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Asignar Tarjeta" onclick="AsignarTarjeta('."'".$estudiante->DOC_EST."'".')"><i class="glyphicon glyphicon-remove"></i></a>';
				}			
				$data[] = $row;
			}
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
		$fecha = date('Y-m-j');
		$nuevafecha = strtotime ( '-18 year' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
		$mail2 = $this->estudiante->val_email($this->input->post('EMAIL_EST'));
		$doc = $this->estudiante->val_doc($this->input->post('DOC_EST'));
		$mail = $this->comprobar_email($this->input->post('EMAIL_EST'));
		if (strlen($this->input->post('DOC_EST')) < 7 or strlen($this->input->post('DOC_EST')) > 11) {
			echo json_encode(array("doc" => TRUE));
		}else if ($doc) {
			echo json_encode(array("valdoc" => TRUE));
		}
		else if ($this->input->post('ID_TIP_DOC_EST') == '1' and $nuevafecha > $this->input->post('FECH_NAC_EST')) {
			echo json_encode(array("fecha" => TRUE));
		}
		else if ($this->input->post('ID_TIP_DOC_EST') != '1' and $nuevafecha < $this->input->post('FECH_NAC_EST')) {
			echo json_encode(array("fecha" => FALSE));
		}
		else if ($mail == 0) {
			echo json_encode(array("mail" => TRUE));
		}
		else if ($mail2) {
			echo json_encode(array("mail" => FALSE));
		}
		else{
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

	public function ajax_Tarjeta()
	{
		$this->validar();
		$val = $this->estudiante->validarTar($this->input->post('id'));
		if($val){
			echo json_encode(array("val" => TRUE));
		}else{
			$data = array(
				'HUELLA_EST' => $this->input->post('id'),
				'DOC_EST' => $this->input->post('idA'),
			);
			$this->estudiante->insertarTarjeta($data);
			echo json_encode(array("status" => TRUE));
		}
	}
	public function ajax_editTarjeta()
	{
		$this->validar();
		$val = $this->estudiante->validarTar($this->input->post('id'));
		if($val){
			echo json_encode(array("val" => TRUE));
		}else{
			$data = array(
				'HUELLA_EST' => $this->input->post('id'),
			);
			$this->estudiante->editarTarjeta(array('DOC_EST' => $this->input->post('idA')), $data);
			echo json_encode(array("status" => TRUE));
		}
	}

	public function ajax_delete($id)
	{
		$data = array(
				'ESTADO_ACU' => 'Inactivo',
			);
		$this->estudiante->update(array('DOC_EST' => $id), $data);
		echo json_encode(array("status" => TRUE));
	}


	private function validar(){
		$data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('id') == '')
        {
            $data['inputerror'][] = 'id';
            $data['error_string'][] = 'El codigo de la tarjeta es obligatorio';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
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
