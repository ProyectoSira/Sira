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
    $this->load->view('reportes_view');
  }

  public function descargar(){

    $list = $this->reportes->get_llegadasTarde();
    $no = $_POST['start'];
    $data = array();
    $hoy = date("d/m/y"); 
    foreach ($list as $tabla) {
      $no++;
      $row = array();
      $row[] = $tabla->DOC_EST;
      $row[] = $tabla->NOM1_EST." ".$tabla->NOM2_EST." ".$tabla->APE1_EST." ".$tabla->APE2_EST;
      $row[] = $tabla->GRADO_EST;
      $row[] = $tabla->NUM_GRUPO;
      $data[] = $row;
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
}
?>