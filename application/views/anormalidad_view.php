<?php $this->load->view('header_nav'); ?>
<div id="page-wrapper">

<div class="container-fluid">
 
        <h1 style="font-size:20pt">Registro de Anormalidades</h1>

        <h3>Datos de la Anormalidad</h3>
        <div id="result"></div>
        <br />
        <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Nuevo</button>
        <br />
        <br />
        <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Tipo Anormalidad</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Día</th>
                    <th style="width:55px;">Acción</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
                <tr>
                    <th>Tipo Anormalidad</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Día</th>
                    <th>Acción</th>
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
            "url": "<?php echo site_url('anormalidad/ajax_list')?>",
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

function cerrarAlerta2(){
    $("#alert").removeClass("alert alert-danger");
    $('#alert').text('');
}

function add_person()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Nueva Anormalidad'); // Set Title to Bootstrap modal title
    $('select[name="COD_TIP_ANORM"]').val();
    $('select[name="COD_TIP_ANORM"]').change();
    $('select[name="COD_PROGRA"]').val();
    $('select[name="COD_PROGRA"]').change();
    $('select[name="HORA_INICIO"]').val();
    $('select[name="HORA_INICIO"]').change();
    $('select[name="HORA_FIN"]').val();
    $('select[name="HORA_FIN"]').change();
}

function edit_person(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('anormalidad/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="COD_ANORM"]').val(data.COD_ANORM);
            $('select[name="COD_TIP_ANORM"]').val(data.COD_TIP_ANORM);
            $('select[name="COD_TIP_ANORM"]').change();
            $('select[name="HORA_INICIO"]').val(data.HORA_INICIO);
            $('select[name="HORA_INICIO"]').change();
            $('select[name="HORA_FIN"]').val(data.HORA_FIN);
            $('select[name="HORA_FIN"]').change();
            $('[name="DESCRIPCION"]').val(data.DESCRIPCION);
            $('[name="ESTADO"]').val(data.ESTADO);
            $('select[name="COD_PROGRA"]').val(data.COD_PROGRA);
            $('select[name="COD_PROGRA"]').change();
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Editar Anormalidad');

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
        url = "<?php echo site_url('anormalidad/ajax_add')?>";
    } else {
        url = "<?php echo site_url('anormalidad/ajax_update')?>";
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
            else if (data.error) {
                $("#alert").addClass("alert alert-danger");
                $('#alert').text('La fecha de fin no puede ser menor o igual a la hora de inicio');
                setTimeout("cerrarAlerta2()",3000);
            }
            else
            {
                $("#alert").addClass("alert alert-danger");
                $('#alert').text('No dejes campos obligatorios en blanco');
                setTimeout("cerrarAlerta2()",3000);
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
            url : "<?php echo site_url('anormalidad/ajax_delete')?>/"+id,
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
                    <div id="alert"></div>
                        <input type="hidden" value="" name="COD_ANORM"/>
                        <div class="form-group">
                            <label class="control-label col-md-3">Anormalidad <span style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select name="COD_TIP_ANORM" class="selectpicker form-control" data-live-search="true">
                                    <option value="">--SELECCIONAR--</option>
                                    <?php 
                                      foreach ($tipoAnorm as $fila) 
                                      {
                                   ?>
                                   <option value="<?= $fila->COD_TIP_ANORM ?>"><?= $fila->NOM_ANORM ?></option>
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
                                        <select name="HORA_INICIO" class="selectpicker form-control" data-live-search="true">
                                            <option value="">--SELECCIONAR--</option>
                                            <option value="0">6:30 am</option>
                                            <option value="1">7:25 am</option>
                                            <option value="2">8:20 am</option>
                                            <option value="3">9:50 am</option>
                                            <option value="4">10:45 am</option>
                                            <option value="5">11:40 am</option>
                                            <option value="6">12:00 pm</option>
                                            <option value="7">12:55 pm</option>
                                            <option value="8">1:50 pm</option>
                                            <option value="9">3:15 pm</option>
                                            <option value="10">4:10 pm</option>
                                            <option value="11">5:05 pm</option>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                        <div class="form-group">
                                    <label class="control-label col-md-3">Hora Fin <span style="color: red;">*</span></label>
                                    <div class="col-md-9">
                                        <select name="HORA_FIN" class="selectpicker form-control" data-live-search="true">
                                            <option value="">--SELECCIONAR--</option>
                                            <option value="0">6:30 am</option>
                                            <option value="1">7:25 am</option>
                                            <option value="2">8:20 am</option>
                                            <option value="3">9:50 am</option>
                                            <option value="4">10:45 am</option>
                                            <option value="5">11:40 am</option>
                                            <option value="6">12:00 pm</option>
                                            <option value="7">12:55 pm</option>
                                            <option value="8">1:50 pm</option>
                                            <option value="9">3:15 pm</option>
                                            <option value="10">4:10 pm</option>
                                            <option value="11">5:05 pm</option>
                                            <option value="12">6:00 pm</option>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Descripción <span style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <textarea name="DESCRIPCION" placeholder="DESCRIPCION" class="form-control"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" onkeypress="return validar(event)"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Día <span style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <select name="COD_PROGRA" class="selectpicker form-control">
                                    <option value="">--SELECCIONAR--</option>
                                    <option value="LUNES">LUNES</option>
                                    <option value="MARTES">MARTES</option>
                                    <option value="MIERCOLES">MIERCOLES</option>
                                    <option value="JUEVES">JUEVES</option>
                                    <option value="VIERNES">VIERNES</option>
                                </select>
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