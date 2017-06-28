<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {

   public function __construct()
  {
    parent::__construct();
    $this->load->model('reportes_model','reportes');
  }

  public function index()
  {
    $this->load->helper('url');
    if(isset($this->session->userdata['logged_in'])){
      if (($this->session->userdata['logged_in']['rol']) != 'Secretaria') {
            $this->load->view('reportes_view');
          }else{
            redirect('error');
          }
        }else{
            redirect('login');
        }
  }

  public function tarde(){
    $hoy = date("Y-m-j");
    $list = $this->reportes->get_llegadasTarde($hoy);
    $no = $_POST['start'];
    $data = array();
    $cuerpo = ""; 
    foreach ($list as $tabla) {
      $no++;
      $cuerpo .= "<tr><td style='text-align:center;'>".$no."</td>
      <td style='text-align:center;'>".$tabla->DOC_EST."</td>
      <td style='text-align:center;'>".$tabla->NOM1_EST." ".$tabla->NOM2_EST." ".$tabla->APE1_EST." ".$tabla->APE2_EST."</td>
      <td style='text-align:center;'>".$tabla->GRADO_EST."</td>
      <td style='text-align:center;'>".$tabla->NUM_GRUPO."</td></tr>";
    }

    $html = "<style>@page {
          margin-top: 0.5cm;
          margin-bottom: 0.5cm;
          margin-left: 0.5cm;
          margin-right: 0.5cm;
      }
      </style>".
        "<body>
          <h1>Institucion Educativa Pedro Octavio Amado</h1>
            <h3>Reporte de llegadas tarde.</h3>
            <h5>Medellín, Antioquia ".$hoy."</h5>
              <table class='table table-striped' cellspacing='0' width='100%'>
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>Documento</th>
                    <th>Nombres y Apellidos</th>
                    <th>Grado</th>
                    <th>Grupo</th>
                  </tr>
                </thead>
                <tbody>
                ".$cuerpo."
                </tbody>
            </table>
        </body>";

    $pdfFilePath = "LlegadasTarde_".$hoy.".pdf";
    //load mPDF library
    $this->load->library('M_pdf');
    $mpdf = new mPDF('c', 'A4-L'); 
    $mpdf->WriteHTML($html);
    $mpdf->Output($pdfFilePath, "D");
   }

   public function tardeRango($inicio, $fin){
    $hoy = date("Y-m-j");
    $list = $this->reportes->get_llegadasTardeRango($inicio, $fin);
    $no = $_POST['start'];
    $data = array();
    $cuerpo = ""; 
    foreach ($list as $tabla) {
      $no++;
      $cuerpo .= "<tr><td style='text-align:center;'>".$no."</td>
      <td style='text-align:center;'>".$tabla->DOC_EST."</td>
      <td style='text-align:center;'>".$tabla->NOM1_EST." ".$tabla->NOM2_EST." ".$tabla->APE1_EST." ".$tabla->APE2_EST."</td>
      <td style='text-align:center;'>".$tabla->GRADO_EST."</td>
      <td style='text-align:center;'>".$tabla->NUM_GRUPO."</td></tr>";
    }

    $html = "<style>@page {
          margin-top: 0.5cm;
          margin-bottom: 0.5cm;
          margin-left: 0.5cm;
          margin-right: 0.5cm;
      }
      </style>".
        "<body>
          <h1>Institucion Educativa Pedro Octavio Amado</h1>
            <h3>Reporte de llegadas tarde.</h3>
            <h5>Medellín, Antioquia ".$inicio." / ".$fin."</h5>
              <table class='table table-striped' cellspacing='0' width='100%'>
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>Documento</th>
                    <th>Nombres y Apellidos</th>
                    <th>Grado</th>
                    <th>Grupo</th>
                  </tr>
                </thead>
                <tbody>
                ".$cuerpo."
                </tbody>
            </table>
        </body>";

    $pdfFilePath = "LlegadasTarde_".$hoy."_Rango.pdf";
    //load mPDF library
    $this->load->library('M_pdf');
    $mpdf = new mPDF('c', 'A4-L'); 
    $mpdf->WriteHTML($html);
    $mpdf->Output($pdfFilePath, "D");
   }

   public function sanciones(){
    $hoy = date("Y-m-d");
    $list = $this->reportes->get_sanciones($hoy);
    $no = $_POST['start'];
    $data = array();
    $cuerpo = ""; 
    foreach ($list as $tabla) {
      $no++;
      $cuerpo .= "<tr><td style='text-align:center;'>".$no."</td>
      <td style='text-align:center;'>".$tabla->DOC_EST."</td>
      <td style='text-align:center;'>".$tabla->NOM1_EST." ".$tabla->NOM2_EST." ".$tabla->APE1_EST." ".$tabla->APE2_EST."</td>
      <td style='text-align:center;'>".$tabla->GRADO_EST."</td>
      <td style='text-align:center;'>".$tabla->NOM_SANC."</td></tr>";
    }

    $html = "<style>@page {
          margin-top: 0.5cm;
          margin-bottom: 0.5cm;
          margin-left: 0.5cm;
          margin-right: 0.5cm;
      }
      </style>".
        "<body>
          <h1>Institución Educativa Pedro Octavio Amado</h1>
            <h3>Reporte de Sanciones.</h3>
            <h5>Medellín, Antioquia ".$hoy."</h5>
              <table class='table table-striped' cellspacing='0' width='100%'>
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>Documento</th>
                    <th>Nombres y Apellidos</th>
                    <th>Grado</th>
                    <th>Sanción</th>
                  </tr>
                </thead>
                <tbody>
                ".$cuerpo."
                </tbody>
            </table>
        </body>";

    $pdfFilePath = "Sanciones_".$hoy.".pdf";
    //load mPDF library
    $this->load->library('M_pdf');
    $mpdf = new mPDF('c', 'A4-L'); 
    $mpdf->WriteHTML($html);
    $mpdf->Output($pdfFilePath, "D");
   }

   public function sancionesRango($inicio, $fin){
    $hoy = date("Y-m-d");
    $list = $this->reportes->get_sancionesRango($inicio, $fin);
    $no = $_POST['start'];
    $data = array();
    $cuerpo = ""; 
    foreach ($list as $tabla) {
      $no++;
      $cuerpo .= "<tr><td style='text-align:center;'>".$no."</td>
      <td style='text-align:center;'>".$tabla->DOC_EST."</td>
      <td style='text-align:center;'>".$tabla->NOM1_EST." ".$tabla->NOM2_EST." ".$tabla->APE1_EST." ".$tabla->APE2_EST."</td>
      <td style='text-align:center;'>".$tabla->GRADO_EST."</td>
      <td style='text-align:center;'>".$tabla->NOM_SANC."</td></tr>";
    }

    $html = "<style>@page {
          margin-top: 0.5cm;
          margin-bottom: 0.5cm;
          margin-left: 0.5cm;
          margin-right: 0.5cm;
      }
      </style>".
        "<body>
          <h1>Institución Educativa Pedro Octavio Amado</h1>
            <h3>Reporte de Sanciones.</h3>
            <h5>Medellín, Antioquia ".$inicio." / ".$fin."</h5>
              <table class='table table-striped' cellspacing='0' width='100%'>
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>Documento</th>
                    <th>Nombres y Apellidos</th>
                    <th>Grado</th>
                    <th>Sanción</th>
                  </tr>
                </thead>
                <tbody>
                ".$cuerpo."
                </tbody>
            </table>
        </body>";

    $pdfFilePath = "Sanciones_".$hoy.".pdf";
    //load mPDF library
    $this->load->library('M_pdf');
    $mpdf = new mPDF('c', 'A4-L'); 
    $mpdf->WriteHTML($html);
    $mpdf->Output($pdfFilePath, "D");
   }

}
?>