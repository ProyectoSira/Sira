<?php $this->load->view('header_nav'); ?>
<div id="page-wrapper">

<div class="container-fluid">
 
        <h1 style="font-size:20pt">Registro de Programacion</h1>

        <h3>Datos de la Programacion</h3>
        <div id="result"></div>
        <br />
        <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Nuevo</button>
        <br />
        <br />
        <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Id Programacion</th>
                    <th>Empleado</th>
                    <th>Asignatura</th>
                    <th>Aula</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Dia</th>
                    <th>Calendario</th>
                    <th>Grupo</th>
                    <th style="width:55px;">Accion</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
                <tr>
                    <th>Id Programacion</th>
                    <th>Empleado</th>
                    <th>Asignatura</th>
                    <th>Aula</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Dia</th>
                    <th>Calendario</th>
                    <th>Grupo</th>
                    <th>Accion</th>
                </tr>
            </tfoot>
        </table>
        </div>

    </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
<script src="<?php echo base_url('assets/select/js/bootstrap-select.min.js')?>"></script>


<script type="text/javascript">

var save_method; //for save method string
var table;

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('programacion/ajax_list')?>",
            "type": "POST"
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

    //datepicker
    $('#datepicker').datepicker({
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

function cerrarAlerta(){
    $("#result").removeClass("alert alert-success");
    $("#result").removeClass("alert alert-info");
    $("#result").removeClass("alert alert-warning");
    $('#result').text('');
}

function add_person()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Nueva Programacion'); // Set Title to Bootstrap modal title
    $('select[name="DIA_SEM"]').val();
    $('select[name="DIA_SEM"]').change();
    $('select[name="COD_CAL"]').val();
    $('select[name="COD_CAL"]').change();
    $('select[name="DOC_EMP"]').val();
    $('select[name="DOC_EMP"]').change();
    $('select[name="COD_GRUPO"]').val();
    $('select[name="COD_GRUPO"]').change();
    $('select[name="COD_ASIG"]').val();
    $('select[name="COD_ASIG"]').change();
    $('select[name="COD_AULA"]').val();
    $('select[name="COD_AULA"]').change();
}

function edit_person(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('programacion/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="COD_PROGRA"]').val(data.COD_PROGRA);
            $('select[name="DOC_EMP"]').val(data.DOC_EMP);
            $('select[name="DOC_EMP"]').change();
            $('select[name="COD_ASIG"]').val(data.COD_ASIG);
            $('select[name="COD_ASIG"]').change();
            $('select[name="COD_AULA"]').val(data.COD_AULA);
            $('select[name="COD_AULA"]').change();
            $('[name="HORA_INI"]').val(data.HORA_INI);
            $('[name="HORA_FIN"]').val(data.HORA_FIN);
            $('select[name="DIA_SEM"]').val(data.DIA_SEM);
            $('select[name="DIA_SEM"]').change();
            $('select[name="COD_CAL"]').val(data.COD_CAL);
            $('select[name="COD_CAL"]').change();
            $('select[name="COD_GRUPO"]').val(data.COD_GRUPO);
            $('select[name="COD_GRUPO"]').change();
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Editar Programacion');

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}



function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').text('Guardando...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url('programacion/ajax_add')?>";
    } else {
        url = "<?php echo site_url('programacion/ajax_update')?>";
    }
 
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
 
            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
                i = 0;
                if (save_method == 'add') {
                    $("#result").addClass("alert alert-success");
                    $('#result').text('Registro Exitoso'); 
                }else{
                    $("#result").addClass("alert alert-info");
                    $('#result').text('Registro Modificado Exitosamente'); 
                }
                setTimeout("cerrarAlerta()",2000);       
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                }
            }
            $('#btnSave').text('Guardar'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error al insertar / Actualizar Datos');
            $('#btnSave').text('Guardar'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
        }
    });
}   

function delete_person(id)
{
    if(confirm('Desea eliminar este registro?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('programacion/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
                $("#result").addClass("alert alert-warning");
                $('#result').text('Registro Eliminado Exitosamente'); 
                setTimeout("cerrarAlerta()",2000);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error Al Eliminar');
            }
        });

    }
}

function justNumbers(e){
    var keynum = window.event ? window.event.keyCode : e.which;
    if ((keynum == 8) || (keynum == 46))
    return true;
    return /\d/.test(String.fromCharCode(keynum));
}
function validar(e) { 
    tecla = (document.all) ? e.keyCode : e.which; 
    if (tecla==8) return true; 
        patron =/[A-Za-z\s]/; 
        te = String.fromCharCode(tecla); 
        return patron.test(te); 

} 

</script>

<!-- Bootstrap modal -->
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
                        <input type="hidden" value="" name="COD_PROGRA"/>
                        <div class="form-group">
                            <label class="control-label col-md-3">Empleado <span style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select name="DOC_EMP" class="selectpicker form-control" data-live-search="true">
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
                                <select name="COD_ASIG" class="selectpicker form-control" data-live-search="true">
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
                                <select name="COD_AULA" class="selectpicker form-control">
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
                            <label class="control-label col-md-3">Hora Inicio <span style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <input name="HORA_INI" placeholder="HORA INICIO" class="form-control" type="text" id="HORA_INI">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Hora Fin <span style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <input name="HORA_FIN" placeholder="HORA FIN" class="form-control" type="text" id="HORA_FIN">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Dia <span style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select name="DIA_SEM" class="selectpicker form-control">
                                    <option value="">--SELECCIONE--</option>
                                    <option value="LUNES">LUNES</option>
                                    <option value="MARTES">MARTES</option>
                                    <option value="MIERCOLES">MIERCOLES</option>
                                    <option value="JUEVES">JUEVES</option>
                                    <option value="VIERNES">VIERNES</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Calendario <span style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select name="COD_CAL" class="selectpicker form-control">
                                    <option value="">--SELECCIONAR--</option>
                                    <?php 
                                      foreach ($calendario as $filas) 
                                      {
                                   ?>
                                   <option value="<?= $filas->COD_CAL ?>" data-subtext="<?=$filas->AÑO_CAL ?>">
                                   <?= $filas->COD_CAL ?></option>
                                   <?php 
                                        }
                                    ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Grupo <span style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select name="COD_GRUPO" class="selectpicker form-control">
                                    <option value="">--SELECCIONAR--</option>
                                    <?php 
                                foreach ($grupo as $fila) {
                                ?>
                                <option value="<?= $fila->COD_GRUPO ?>"><?= $fila->NOM_GRADO, " ",$fila->NUM_GRUPO?></option>
                                <?php 
                                 }
                                ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>  
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
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