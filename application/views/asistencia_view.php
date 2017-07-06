<?php $this->load->view('header_nav'); ?>
<div id="page-wrapper">
    <div class="container-fluid">
    <h1 style="font-size:20pt">Registro de Asistencia</h1>
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
            <div class="col-md-2">
                <div class="form-group">
                    <button class="btn btn-success form-control" id="btnRegistrar"><i class="glyphicon glyphicon-plus"></i> Registrar
                    </button>
                </div> 
            </div> 
            <div class="col-md-4" style="margin-top: -6%;">
                <div class="panel panel-primary">
                    <div class="panel-heading"><h2>Consultar Excusa</h2></div>
                    <div class="panel-body">
                    <div id="result2"></div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Estudiante <span style="color: red;">*</span></label>
                            <div class="col-md-8">
                                <select name="DOC_EST" id="DOC_EST" class="selectpicker form-control" data-live-search="true">
                                    <option value="">--SELECCIONAR--</option>
                                    <?php 
                                      foreach ($estudiante as $filas) 
                                      {
                                   ?>
                                   <option value="<?= $filas->DOC_EST ?>" data-subtext="<?= $filas->DOC_EST ?>">
                                   <?=$filas->NOM1_EST," ",$filas->NOM2_EST," ",$filas->APE1_EST ?></option>
                                   <?php 
                                        }
                                    ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <button class="btn btn-primary form-control" id="btnConsultar"><i class="glyphicon glyphicon-search"></i> Consultar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>           
        </div>
        <br>
            <div>
                    <table id="table" class="table table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th style="width: 20%;">Documento</th>
                                <th style="width: 60%;">Estudiante</th>
                                <th>No Asistió</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</div>


<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
<script src="<?php echo base_url('assets/select/js/bootstrap-select.min.js')?>"></script>

<script type="text/javascript">

var save_method;
$(document).ready(function(){
     table = $('#table').DataTable({ 

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('asistencia/ajax_list')?>",
                "type": "POST",
                "data": function (data) {
                    data.COD_GRUPO = $('#COD_GRUPO').val();
                }
            },

            //Set column definition initialisation properties.
            "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            },
            ],

            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ Registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",                
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }

        });

 //for save method string
    //datepicker


    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });

    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });

});



$('#btnBuscar').click(function () {
    table.ajax.reload(null,false);
});

function cerrarAlerta(){
    $("#result").removeClass("alert alert-success");
    $("#result").removeClass("alert alert-info");
    $('#result').text('');
}

function cerrarAlerta2(){
    $("#result2").removeClass("alert alert-info");
    $("#result2").removeClass("alert alert-danger");
    $('#result2').text('');
}


function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax
}


$('#btnRegistrar').click(function () {
    var textGrupo = $('#COD_GRUPO').val();
    var documento = [];

    $(".data-check:checked").each(function() { 
        documento.push(this.value);
    });

    if (confirm('Ha dicho que del grupo '+textGrupo+' solo han asistido '+documento.length+' estudiantes.\n Desea continuar?')) {
        $.ajax({
            url: "<?php echo site_url('asistencia/ajax_registrar')?>",
            type: "POST",
            data: {doc:documento}, 
            dataType: "JSON",
            success: function(data){
                if (data.status) {
                    reload_table();
                    $("#result").addClass("alert alert-success");
                    $('#result').text('Registro Exitoso'); 
                    setTimeout("cerrarAlerta()",2000);
                    $('#COD_GRUPO').find('[value='+textGrupo+']').remove();
                    $('#COD_GRUPO').selectpicker('refresh');
                    table.ajax.reload(null,false);
                }else{
                    alert('Error');
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('Error al registrar la asistencia');
            }
        });
    }
});

$('#btnConsultar').click(function () {
   var doc = $('#DOC_EST').val(); 
   $.ajax({
        url: "<?php echo site_url('asistencia/ajax_consultar')?>",
        type: "POST",
        data: {doc:doc}, 
        dataType: "JSON",
        success: function(data){
            $("#body").empty();
            if ($('#DOC_EST').val() == "") {
                $("#result2").addClass("alert alert-danger");
                $('#result2').text('Por favor seleccione un estudiante');
                setTimeout("cerrarAlerta2()",3000);
            }
            else if (data.status) {
                $("#result2").addClass("alert alert-info");
                $('#result2').text('El estudiante no tiene excusas');
                setTimeout("cerrarAlerta2()",3000);
            }else{
                var html;
                $('#nom').text(data[0].nom1+" "+data[0].nom2+" "+data[0].ape1+" "+data[0].ape2);
                $('#doc').text(data[0].doc);
                for (var i = 0; i < data.length; i++) {
                    html += '<tr>';
                    html += '<td style="width:70%;">'+data[i].fecha+'</td>';
                    html += '<td><a onclick="imagen('+"'"+data[i].url+"'"+')" class="btn btn-default"><i class="glyphicon glyphicon-eye-open"> Ver Imagen</a></td>';
                    html += '</tr>';
                }
                $('#body').append(html); 
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Excusas del estudiante'); // Set title to Bootstrap modal title
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('Error');
        }
    });
});

function imagen(url) {
    var ruta = '<?php echo base_url('assets/img/')?>/'+url;
    //alert(ruta);
    $('#img').attr('src', ruta);
    $('#modal_form2').modal('show'); // show bootstrap modal when complete loaded
    $('.modal-title2').text('Vista previa de la excusa'); // Set title to Bootstrap modal title
}

</script>

<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title"></h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <div class="form-body">
                    <div id="alert"></div>
                        <div class="form-group">
                            <p>El estudiante <span id="nom"></span> con documento de identidad N°<span id="doc"></span>,
                             presenta las siguientes excusas.</p>
                        </div>
                       <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Fecha de la falta</th>
                                    <th>Excusa</th>
                                </tr>
                            </thead>
                            <tbody id="body">
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal_form2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title2"></h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <div class="form-body">
                    <div id="alert"></div>
                        <center>
                           <img width="450" id="img">
                        </center>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</section>

  
<script src="<?php echo base_url('assets/js/jquery.nicescroll.js')?>"></script>
<script src="<?php echo base_url('assets/js/scripts.js')?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
</body>
</html>