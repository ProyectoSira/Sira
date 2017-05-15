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
        </div>
        <br>
            <div>
                    <table id="table" class="table table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="width:20px;">N°</th>
                                <th>Estudiantes</th>
                                <th style="width:20px;">Asistió</th>
                                <th style="width:20px;">Tarde</th>
                                <th style="width:50px;">Hora</th>
                                <th style="width:50px;">Observacion</th>
                                <th style="width:20px;">Justificado</th>
                                <th style="width:20px;">Excusa</th>
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



function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax
}


function registrar() {
    var grup = $('#COD_GRUPO').val();
    var list_id = [];
    $(".data-check:checked").each(function() { 
            list_id.push(this.value);
    });
    if (list_id.length > 0) {
        if (confirm('Desea registrar '+list_id.length+' alumnos a este grupo?')) {
            $.ajax({
                url: "<?php echo site_url('asignacion/ajax_registrar')?>",
                type: "POST",
                data: {id:list_id, grupo:grup}, 
                dataType: "JSON",
                success: function(data){
                    if (data.status) {
                        reload_table();
                        $("#result").addClass("alert alert-success");
                        $('#result').text('Registro Exitoso'); 
                        setTimeout("cerrarAlerta()",2000);
                    }else{
                        alert('Error');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert('Error al insetar los alumnos');
                }
            });
        }
    }
    else{
        alert('No ha seleccionado ningun alumno');
    }
}

</script>

</section>

  
<script src="<?php echo base_url('assets/js/jquery.nicescroll.js')?>"></script>
<script src="<?php echo base_url('assets/js/scripts.js')?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
</body>
</html>