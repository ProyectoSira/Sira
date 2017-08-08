<?php $this->load->view('header_nav'); ?>
<div id="page-wrapper">

    <div class="container-fluid">
    </div>
    <h1 style="font-size:20pt">Programacion</h1>
    <br>
    <div id="result"></div>
        <div class="row">
            <div class="col-md-1">
                <div class="form-group" style="text-align: center; font-size: 23px;">
                    <label>Grupo</label> 
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select name="COD_GRUPO" class="selectpicker form-control tablaDatos" data-live-search = "true" id="COD_GRUPO">
                        <option value="NADA">--SELECCIONE--</option>
                            <?php 
                                foreach ($grupo as $fila) {
                                ?>
                                <option value="<?= $fila->COD_GRUPO ?>"><?= $fila->NOM_GRADO, " ",$fila->NUM_GRUPO?></option>
                                <?php 
                                 }
                            ?>
                        </select>  
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <button class="btn btn-info form-control" id="btnBuscar"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                </div> 
            </div>   
                           
        </div>
        
        
</div>
            <!-- /.container-fluid -->



<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
<script src="<?php echo base_url('assets/select/js/bootstrap-select.min.js')?>"></script>

<script type="text/javascript">


$(document).ready(function(){
     
    //oculto mediante id

    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });

    //set input/textarea/select event when change value, remove class error and remove text help block 
    



$('#btnBuscar').click(function () {
     $('#show_form').show();
     $('#tbl_horario').show().addClass("col-md-12");
     $('#form_prog').hide();
     $('#hide_form').hide();
     $('#tbl_horario').removeClass("col-md-6").addClass('col-md-12');

     


});
$('#show_form').click(function () {
     
     $('#tbl_horario').removeClass("col-md-12").addClass('col-md-6');
     $('#form_prog').show().addClass('col-md-6');
     $('#show_form').hide();
     $('#hide_form').show();
     

});
$('#hide_form').click(function() {
   $('#tbl_horario').removeClass("col-md-6").addClass('col-md-12');
   $('#form_prog').hide();
   $('#hide_form').hide();
   $('#show_form').show();
});

$('#DIA_SEM').change(function(){
    var valorCambiado =$(this).val();
    if((valorCambiado != '0')){
    
       $('#tbl_sem').show();
     }else{
        $('#tbl_sem').hide();
     }
     
});



});

function registrar() {
    var grup = $('#COD_GRUPO').val();
    var emp = $('#DOC_EMP').val();
    var asig = $('#COD_ASIG').val();
    var aula = $('#COD_AULA').val();
    var dia = $('#DIA_SEM').val();
    var cal = $('#COD_CAL').val();
    var horas = [];
    $(".data-check:checked").each(function() { 
            horas.push(this.value);
    });
    if (horas.length > 0) {
        if (confirm('¿Deseas agregar la Programacion al Grupo?')) {
            $.ajax({
                url: "<?php echo site_url('horario/ajax_add')?>",
                type: "POST",
                data: {COD_GRUPO:grup, DOC_EMP:emp, COD_ASIG:asig, COD_AULA:aula, ID_SEM:dia, HORA_SEM:horas, COD_CAL:cal}, 
                dataType: "JSON",
                success: function(data){
                    if (data.status) {
                        
                        $("#result").addClass("alert alert-success");
                        $('#result').text('Registro Exitoso'); 
                        setTimeout("cerrarAlerta()",5000);
                        location.reload();
                    }else{
                        alert('Error');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert('Error al insetar la Programacion');
                }
            });
        }
    }
    else{
        alert('No ha seleccionado el día');
    }
} 


</script>
<div class=""  id="tbl_horario" style="display: none;">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Horario de Clase </h3>
                <center>
                    <button type="button" class="btn btn-default" aria-label="Left Align" id="show_form" style="float: right;">
                      <div class="glyphicon glyphicon-plus" aria-hidden="true"></div>
                    
                     
                    </button>
                    <button type="button" class="btn btn-default" aria-label="Left Align" id="hide_form" style="float: right;">
                      <div class="glyphicon glyphicon-minus"  ></div>
                    </button>
                </center>
                
              </div>
              <div class="panel-body">
                
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th >Horas</th>
                      <th >Lunes</th>
                      <th >Martes</th>
                      <th >Miércoles</th>
                      <th >Jueves</th>
                      <th >Viernes</th>
                      
                    </tr>
                  </thead >
                  <tbody> 
                    <tr>
                      <th scope="row">1</th>
                      <td>  
                      <?php 
                              if ($lunes1=='') {
                                echo "VACIO";
                              } else {
                                foreach ($lunes1  as $row)

                                  {
                                      if ($row->ID_SEM == 1 and $row->HORA_SEM==1) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                        break;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }
                                     
                                  }
                              }
                      ?> 
                      </td>
                      <td >
                       <?php 
                              if ($martes1=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($martes1  as $row)

                                  {

                                      if ($row->ID_SEM == 2 and $row->HORA_SEM==1) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{

                                        echo "VACIO";
                                        break;
                                      }

                                  }
                              }
                      ?> 
                      </td>
                      <td >
                        <?php 
                              if ($miercoles1=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($miercoles1  as $row)

                                  {

                                       if ($row->ID_SEM == 3 and $row->HORA_SEM==1) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?> 
                      </td>
                      <td >
                        <?php 
                              if ($jueves1=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($jueves1  as $row)

                                  {

                                       if ($row->ID_SEM == 4 and $row->HORA_SEM==1) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?>
                      </td>
                      
                      <td >
                        <?php 
                              if ($viernes1=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($viernes1  as $row)

                                  {

                                       if ($row->ID_SEM == 5 and $row->HORA_SEM==1) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?>
                      </td>
                     
                    </tr>
                    <tr>
                      <th scope="row">2</th>
                      <td >
                        <?php 
                              if ($lunes2=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($lunes2  as $row)

                                  {

                                       if ($row->ID_SEM == 1 and $row->HORA_SEM==2) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?>
                      </td>
                      <td >
                        <?php 
                              if ($martes2=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($martes2  as $row)

                                  {

                                       if ($row->ID_SEM == 2 and $row->HORA_SEM==2) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?>
                      </td>
                      <td >
                        <?php 
                              if ($miercoles2=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($miercoles2  as $row)

                                  {

                                      if ($row->ID_SEM == 3 and $row->HORA_SEM==2) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?> 
                      </td>
                      <td >
                      <?php 
                              if ($jueves2=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($jueves2  as $row)

                                  {

                                       if ($row->ID_SEM == 4 and $row->HORA_SEM==2) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?></td>
                      <td >
                        <?php 
                              if ($viernes2=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($viernes2  as $row)

                                  {

                                       if ($row->ID_SEM == 5 and $row->HORA_SEM==2) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?>
                      </td>
                     
                    </tr>
                    <tr>
                      <th scope="row">3</th>
                      <td >
                        <?php 
                              if ($lunes3=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($lunes3  as $row)

                                  {

                                       if ($row->ID_SEM == 1 and $row->HORA_SEM==3) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?>
                      </td>
                      <td >
                        <?php 
                              if ($martes3=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($martes3  as $row)

                                  {

                                      if ($row->ID_SEM == 2 and $row->HORA_SEM==3) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?> 
                      </td>
                      <td >
                        <?php 
                              if ($miercoles3=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($miercoles3  as $row)

                                  {

                                       if ($row->ID_SEM == 3 and $row->HORA_SEM== 3) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }

                                  }
                              }
                      ?>
                      </td>
                      <td >
                        <?php 
                              if ($jueves3=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($jueves3  as $row)

                                  {

                                       if ($row->ID_SEM == 4 and $row->HORA_SEM==3) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?>
                      </td>
                      <td >
                        <?php 
                              if ($viernes3=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($viernes3  as $row)

                                  {

                                       if ($row->ID_SEM == 5 and $row->HORA_SEM==3) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?>
                      </td>
                    
                    </tr>
                    <tr>
                      <th scope="row">4</th>
                      <td >
                        <?php 
                              if ($lunes4=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($lunes4  as $row)

                                  {

                                       if ($row->ID_SEM == 1 and $row->HORA_SEM==4) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }

                                  }
                              }
                              
                                
                      ?>
                      </td>
                      
                      <td >
                      <?php 
                              if ($martes4=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($martes4  as $row)

                                  {

                                       if ($row->ID_SEM == 2 and $row->HORA_SEM==4) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?>
                        
                      </td>
                      <td >
                      <?php 
                              if ($miercoles4=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($miercoles4  as $row)

                                  {

                                       if ($row->ID_SEM == 3 and $row->HORA_SEM==4) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?> 
                      </td>
                      <td >
                        <?php 
                              if ($jueves4=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($jueves4  as $row)

                                  {

                                       if ($row->ID_SEM == 4 and $row->HORA_SEM==4) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }

                                  }
                              }
                      ?>
                      </td>
                      <td >
                        <?php 
                              if ($viernes4=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($viernes4  as $row)

                                  {

                                      if ($row->ID_SEM == 5 and $row->HORA_SEM== 4) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?>
                      </td>
                    
                    </tr>
                    <tr>
                      <th scope="row">5</th>
                      <td >
                        <?php 
                              if ($lunes5=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($lunes5  as $row)

                                  {

                                      if ($row->ID_SEM == 1 and $row->HORA_SEM==5) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }

                                  }
                              }
                      ?>
                      </td>
                      <td >
                        <?php 
                              if ($martes5=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($martes5  as $row)

                                  {

                                       if ($row->ID_SEM == 2 and $row->HORA_SEM==5) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?>
                      </td>
                      <td >
                        <?php 
                              if ($miercoles5=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($miercoles5  as $row)

                                  {

                                       if ($row->ID_SEM == 3 and $row->HORA_SEM==5) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?> 
                      </td>

                      <td >
                      <?php 
                              if ($jueves5=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($jueves5  as $row)

                                  {

                                       if ($row->ID_SEM == 4 and $row->HORA_SEM==5) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }

                                  }
                              }
                      ?></td>
                      <td >
                        <?php 
                              if ($viernes5=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($viernes5  as $row)

                                  {

                                       if ($row->ID_SEM == 5 and $row->HORA_SEM==5) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?>
                      </td>
                    
                    </tr>
                    <tr>
                      <th scope="row">6</th>
                      <td >
                        <?php 
                              if ($lunes6=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($lunes6  as $row)

                                  {

                                       if ($row->ID_SEM == 1 and $row->HORA_SEM==6) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }                      
                        ?>
                      </td>
                      <td ><?php 
                              if ($martes6=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($martes6  as $row)

                                  {

                                       if ($row->ID_SEM == 2 and $row->HORA_SEM==6) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }                      
                        ?></td>
                      <td >
                        <?php 
                              if ($miercoles6=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($miercoles6  as $row)

                                  {

                                       if ($row->ID_SEM == 3 and $row->HORA_SEM==6) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?> 
                      </td>
                      <td >
                      <?php 
                              if ($jueves6=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($jueves6  as $row)

                                  {

                                      if ($row->ID_SEM == 4 and $row->HORA_SEM==6) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?></td>
                      <td >
                        <?php 
                              if ($viernes6=='') {
                                 echo "VACIO";
                              } else {
                                foreach ($viernes6  as $row)

                                  {

                                       if ($row->ID_SEM == 5 and $row->HORA_SEM==6) {
                                        echo $row->NOM1_EMP." ".$row->NOM2_EMP." ".$row->APE1_EMP;
                                        echo "<br>";
                                        echo $row->NOM_ASIG;
                                        echo "<br>";
                                        echo "Aula ".$row->NUM_AULA;
                                      }else{
                                        echo "VACIO";
                                        break;
                                      }


                                  }
                              }
                      ?>
                      </td>
                    
                    </tr>

                    
                  </tbody>
                </table>
                </div>
        


            </div>
 </div>
<div class="" id="form_prog" style="display: none;"> 
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Agregar Grupos y Asignatura al Horario</h3>
              </div>
              <div class="panel-body">
                
                        <input type="hidden" value="" name="COD_PROGRA"/>
                        <div class="form-group">
                            <label class="control-label col-md-3">Empleado <span style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select name="DOC_EMP" id="DOC_EMP" class="selectpicker form-control" data-live-search="true">
                                    <option value="">--SELECCIONAR--</option>
                                    <?php 
                                      foreach ($empleado as $filas) 
                                      {
                                   ?>
                                   <option value="<?= $filas->DOC_EMP ?>" data-subtext="<?=$filas->NOM1_EMP," ",$filas->NOM2_EMP," ",$filas->APE1_EMP ?>">
                                   <?= $filas->DOC_EMP ?></option>
                                   <?php 
                                        }
                                    ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Asignatura <span style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select name="COD_ASIG" id="COD_ASIG" class="selectpicker form-control" data-live-search="true">
                                    <option value="">--SELECCIONAR--</option>
                                    <?php 
                                      foreach ($asignatura as $filas) 
                                      {
                                   ?>
                                   <option value="<?= $filas->COD_ASIG ?>">
                                   <?= $filas->NOM_ASIG ?></option>
                                   <?php 
                                        }
                                    ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Aula <span style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select name="COD_AULA"  id="COD_AULA" class="selectpicker form-control">
                                    <option value="">--SELECCIONAR--</option>
                                    <?php 
                                      foreach ($aula as $filas) 
                                      {
                                   ?>
                                   <option value="<?= $filas->COD_AULA ?>" >
                                   <?= $filas->NUM_AULA ?></option>
                                   <?php 
                                        }
                                    ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Dia <span style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select name="DIA_SEM" id="DIA_SEM" id="DIA_SEM" class="selectpicker form-control">
                                    <option >--SELECCIONE--</option>
                                    <option value="1">LUNES</option>
                                    <option value="2">MARTES</option>
                                    <option value="3">MIERCOLES</option>
                                    <option value="4">JUEVES</option>
                                    <option value="5">VIERNES</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group" id="tbl_sem" style="display: none;">
                            <label class="control-label col-md-3"> <span style="color: red;">*</span></label>
                            <div class="col-md-3">
                                <table class="table table-bordered">
                                      <thead>
                                        <tr>
                                          <th  width="25">Horas</th>
                                          
                                        </tr>
                                      </thead >
                                      <tbody>
                                        <tr>
                                          <th scope="row">1</th>
                                          <td ><input type="checkbox" class="data-check" value="1"></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">2</th>
                                          <td ><input type="checkbox" class="data-check" value="2"></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">3</th>
                                          <td ><input type="checkbox" class="data-check" value="3"></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">4</th>
                                          <td ><input type="checkbox" class="data-check" value="4"></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">5</th>
                                          <td ><input type="checkbox" class="data-check" value="5"></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">6</th>
                                          <td ><input type="checkbox" class="data-check" value="6"></td>
                                          
                                        
                                        </tr>

                                        
                                      </tbody>
                                </table>
                                
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Calendario <span style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select name="COD_CAL" id="COD_CAL" class="selectpicker form-control">
                                    <option value="">--SELECCIONAR--</option>
                                    <?php 
                                      foreach ($calendario as $filas) 
                                      {
                                   ?>
                                   <option value="<?= $filas->COD_CAL ?>" data-subtext="<?=$filas->COD_CAL ?>">
                                   <?= $filas->AÑO_CAL ?></option>
                                   <?php 
                                        }
                                    ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                 <button id="btnRegistrar" class="btn btn-success form-control" onclick="registrar()">
                                 <i class="glyphicon glyphicon-plus"></i> Registrar
                                 </button>
                                 <br><br>
                             </div>
                        </div>
                 

              </div> 

        
        
</section>

  
<script src="<?php echo base_url('assets/js/jquery.nicescroll.js')?>"></script>
<script src="<?php echo base_url('assets/js/scripts.js')?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
</body>
</html>

