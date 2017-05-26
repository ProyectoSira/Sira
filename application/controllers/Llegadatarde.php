<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Llegadatarde extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Llegadatarde_model','llegadatarde');
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->helper('form');
		if(isset($this->session->userdata['logged_in'])){
			if (($this->session->userdata['logged_in']['rol']) == 'Coordinador') {
        		$this->load->view('llegadatarde_view');
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
		$this->db->from('tbl_estudiante_huella_tbl_dedo');
		$this->db->where('HUELLA_EST', $id);
        $this->db->join('tbl_estudiante','tbl_estudiante.DOC_EST = tbl_estudiante_huella_tbl_dedo.DOC_EST');
        $this->db->join('tbl_tipo_documento','tbl_tipo_documento.ID_TIP_DOC = tbl_estudiante.ID_TIP_DOC_EST');
        $this->db->join('tbl_acudiente','tbl_acudiente.DOC_ACU = tbl_estudiante.DOC_ACU');
        $this->db->join('tbl_grupo_estudio','tbl_grupo_estudio.DOC_EST = tbl_estudiante.DOC_EST');
        $this->db->join('tbl_grupo','tbl_grupo.COD_GRUPO = tbl_grupo_estudio.COD_GRUPO');
        $data = $this->db->get()->row_array();
		echo json_encode($data);
	}


	public function ajax_registrar()
	{
		$huella = $this->input->post('huella');
		$grupo = $this->input->post('codGrupo');
        $fecha = $this->input->post('fecha');
        $hora = $this->input->post('hora');
        $estado = $this->input->post('justificacion');
		$insert = $this->llegadatarde->save($huella, $grupo, $fecha, $hora, $estado);
		echo json_encode(array("status" => TRUE));
	}

}