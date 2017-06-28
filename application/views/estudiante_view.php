<?php $this->load->view('header_nav'); ?>
<div id="page-wrapper">

<div class="container-fluid">
 
        <h1 style="font-size:20pt">Registro de Alumnos</h1>

        <h3>Datos Personales</h3>
        <div id="result"></div>
        <br />
        <button class="btn btn-success" id="btnNuevo" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Nuevo</button>
        <a href="<?php echo base_url('index.php/acudiente');?>" class="btn btn-default"><i class="glyphicon glyphicon-search"></i> Acudientes</a>
        <br />
        <br />
        <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th style="width:150px;">Documento</th>
                    <th>Tipo Doc.</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Teléfono 1</th>
                    <th>Grado</th>
                    <th>Correo</th>
                    <th style="width:55px;">Acción</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th>Documento</th>
                <th>Tipo Doc.</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Teléfono 1</th>
                <th>Grado</th>
                <th>Correo</th>
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
var rol = "<?php echo ($this->session->userdata['logged_in']['rol'])?>"

$(document).ready(function() {
    if (rol == 'Coordinador') {
        $('#btnNuevo').attr('disabled',true);
    }

    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('estudiante/ajax_list')?>",
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
    $('.modal-title').text('Nuevo Alumno'); // Set Title to Bootstrap modal title
    document.getElementById('DOC_EST').readOnly = false;
    $('select[name="ID_TIP_DOC_EST"]').val();
    $('select[name="ID_TIP_DOC_EST"]').change();
    $('select[name="TBL_ACUDIENTE_DOC_ACU"]').val();
    $('select[name="TBL_ACUDIENTE_DOC_ACU"]').change();
    $('select[name="GRADO_EST"]').val();
    $('select[name="GRADO_EST"]').change();
    $('select[name="CIU_EST"]').val();
    $('select[name="CIU_EST"]').change();
}


function edit_person(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    document.getElementById('DOC_EST').readOnly = true;
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('estudiante/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="DOC_EST"]').val(data.DOC_EST);
            $('select[name="ID_TIP_DOC_EST"]').val(data.ID_TIP_DOC_EST);
            $('select[name="ID_TIP_DOC_EST"]').change();
            $('select[name="TBL_ACUDIENTE_DOC_ACU"]').val(data.DOC_ACU);
            $('select[name="TBL_ACUDIENTE_DOC_ACU"]').change();
            $('[name="NOM1_EST"]').val(data.NOM1_EST);
            $('[name="NOM2_EST"]').val(data.NOM2_EST);
            $('[name="APE1_EST"]').val(data.APE1_EST);
            $('[name="APE2_EST"]').val(data.APE2_EST);
            $('select[name="GRADO_EST"]').val(data.GRADO_EST);
            $('select[name="GRADO_EST"]').change();
            $('[name="FECH_NAC_EST"]').datepicker('update',data.FECH_NAC_EST);
            $('select[name="CIU_EST"]').val(data.CIU_EST);
            $('select[name="CIU_EST"]').change();
            $('[name="DIR_EST"]').val(data.DIR_EST);
            $('[name="TEL1_EST"]').val(data.TEL1_EST);
            $('[name="TEL2_EST"]').val(data.TEL2_EST);
            $('[name="EMAIL_EST"]').val(data.EMAIL_EST);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Editar Alumno');

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function view_person(id)
{
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('estudiante/ajax_view/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="DOC_EST_L"]').text(data.DOC_EST);
            $('[name="ID_TIP_DOC_EST_L"]').text(data.NOM_TIP_DOC);
            $('[name="TBL_ACUDIENTE_DOC_ACU_L"]').text(data.NOM1_ACU+" "+data.NOM2_ACU+" "+data.APE1_ACU+" "+data.APE2_ACU);
            $('[name="NOM1_EST_L"]').text(data.NOM1_EST+" "+data.NOM2_EST);
            $('[name="APE1_EST_L"]').text(data.APE1_EST+" "+data.APE2_EST);
            $('[name="GRADO_EST_L"]').text(data.GRADO_EST);
            $('[name="FECH_NAC_EST_L"]').text(data.FECH_NAC_EST);
            $('[name="CIU_EST_L"]').text(data.CIU_EST);
            $('[name="DIR_EST_L"]').text(data.DIR_EST);
            $('[name="TEL1_EST_L"]').text(data.TEL1_EST);
            $('[name="TEL2_EST_L"]').text(data.TEL2_EST);
            $('[name="EMAIL_EST_L"]').text(data.EMAIL_EST);
            $('#modal_form1').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title1').text('Informacion Personal'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
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
        url = "<?php echo site_url('estudiante/ajax_add')?>";
    } else {
        url = "<?php echo site_url('estudiante/ajax_update')?>";
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
               
                if (save_method == 'add') {
                    $("#result").addClass("alert alert-success");
                    $('#result').text('Registro Exitoso'); 
                }else{
                    $("#result").addClass("alert alert-info");
                    $('#result').text('Registro Modificado Exitosamente'); 
                }
                setTimeout("cerrarAlerta()",2000);
            }
            else if (data.doc) {
                $("#alert").addClass("alert alert-danger");
                $('#alert').text('El documento no es válido'); 
                setTimeout("cerrarAlerta2()",4000);
            }
            else if (data.valdoc) {
                $("#alert").addClass("alert alert-danger");
                $('#alert').text('El documento ya se encuentra registrado'); 
                setTimeout("cerrarAlerta2()",4000);
            }
            else if (data.fecha || data.fecha == false) {
                $("#alert").addClass("alert alert-danger");
                $('#alert').text('El tipo de documento no corresponde a la fecha de nacimiento'); 
                setTimeout("cerrarAlerta2()",4000);
            }
            else if (data.mail) {
                $("#alert").addClass("alert alert-danger");
                $('#alert').text('El correo electrónico no es válido'); 
                setTimeout("cerrarAlerta2()",4000);
            }
            else if (data.mail == false) {
                $("#alert").addClass("alert alert-danger");
                $('#alert').text('El correo electrónico ya se encuentra registrado'); 
                setTimeout("cerrarAlerta2()",4000);
            }
            else
            {
                $("#alert").addClass("alert alert-danger");
                $('#alert').text('No dejes campos obligatorios en blanco'); 
                setTimeout("cerrarAlerta2()",4000);
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
            url : "<?php echo site_url('estudiante/ajax_delete')?>/"+id,
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


</script>

<!-- Bootstrap modal estudiante-->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title"></h3>
            </div>
            <div class="modal-body form">
                <div class="row">
                <form action="#" id="form">
                <div class="form-body">
                    <div id="alert"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Documento <span style="color: red;">*</span></label>
                            <input name="DOC_EST" placeholder="DOCUMENTO" class="form-control" type="text" id="DOC_EST" onkeypress="return justNumbers(event);">
                            <span class="help-block"></span>

                        </div>
                        <div class="form-group">
                            <label>Tipo Documento <span style="color: red;">*</span></label>
                                <select name="ID_TIP_DOC_EST" class="selectpicker form-control">
                                <option value="">--SELECCIONAR--</option>
                                    <?php 
                                      foreach ($tipoDocumento as $filas) 
                                      {
                                   ?>
                                   <option value="<?= $filas->ID_TIP_DOC ?>" data-subtext="<?=$filas->NOM_TIP_DOC ?>"><?= $filas->SIGLA_DOC ?></option>
                                   <?php 
                                        }
                                    ?>
                                </select>
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label>Documento Acudiente <span style="color: red;">*</span></label>
                                <select name="TBL_ACUDIENTE_DOC_ACU" id="DOC_ACU" class="selectpicker form-control" data-live-search="true">
                                    <option value="">--SELECCIONAR--</option>
                                    <?php 
                                      foreach ($acudiente as $filas) 
                                      {
                                   ?>
                                   <option value="<?= $filas->DOC_ACU ?>" data-subtext="<?=$filas->NOM1_ACU," ",$filas->APE1_ACU ?>"><?= $filas->DOC_ACU ?></option>
                                   <?php 
                                        }
                                    ?>
                                </select>
                                <span class="help-block"></span>
                        </div>
                        
                        <div class="form-group">
                            <label>Nombre 1 <span style="color: red;">*</span></label>
                                <input name="NOM1_EST" placeholder="NOMBRE 1" class="form-control" type="text" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" onkeypress="return validar(event)">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label>Nombre 2</label>
                                <input name="NOM2_EST" placeholder="NOMBRE 2" class="form-control" type="text" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" onkeypress="return validar(event)">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label>Apellido 1 <span style="color: red;">*</span></label>
                                <input name="APE1_EST" placeholder="APELLIDO 1" class="form-control" type="text" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" onkeypress="return validar(event)">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label>Apellido 2</label>
                                <input name="APE2_EST" placeholder="APELLIDO 2" class="form-control" type="text" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" onkeypress="return validar(event)">
                                <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fecha Nacimiento <span style="color: red;">*</span></label>
                                <input name="FECH_NAC_EST" placeholder="YYYY-MM-DD" class="form-control" data-date-end-date="-4y" 
                                id="datepicker" type="text">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label>Grado <span style="color: red;">*</span></label>
                                <select name="GRADO_EST" class="selectpicker form-control" data-live-search="true">
                                <option value="">--SELECCIONAR--</option>
                                    <?php 
                                      foreach ($Grado as $filas) 
                                      {
                                   ?>
                                   <option value="<?= $filas->NOM_GRADO ?>" ><?= $filas->NOM_GRADO ?></option>
                                   <?php 
                                        }
                                    ?>
                                </select>
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label>Ciudad <span style="color: red;">*</span></label>
                                <select name="CIU_EST" class="selectpicker form-control" data-live-search="true">
                                    <option value="">--SELECCIONAR--</option>
                                    <?php 
                                      foreach ($ciudad as $filas) 
                                      {
                                   ?>
                                   <option value="<?= $filas->COD_CIUDAD ?>"><?= $filas->NOM_CIUDAD ?></option>
                                   <?php 
                                        }
                                    ?>
                                </select>
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label>Dirección <span style="color: red;">*</span></label>
                                <input name="DIR_EST" placeholder="DIRECCION" class="form-control" type="text" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label>Teléfono 1 <span style="color: red;">*</span></label>
                                <input name="TEL1_EST" placeholder="TELEFONO 1" class="form-control" type="text" onkeypress="return justNumbers(event);">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label>Teléfono 2</label>
                                <input name="TEL2_EST" placeholder="TELEFONO 2" class="form-control" type="text" onkeypress="return justNumbers(event);">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label>Correo <span style="color: red;">*</span></label>
                                <input name="EMAIL_EST" placeholder="CORREO" class="form-control" type="text" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                <span class="help-block"></span>
                        </div>
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


<!-- 
acudiente
 -->

<div class="modal fade" id="modal_form1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title1"></h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-6">Documento:</label>
                                <label class="control-label col-md-1 text-muted" name="DOC_EST_L"></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Tipo Documento:</label>
                            <label style="text-align: left;" class="control-label col-md-6 text-muted" name="ID_TIP_DOC_EST_L"></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Acudiente:</label>
                            <label style="text-align: left;" class="control-label col-md-6 text-muted" name="TBL_ACUDIENTE_DOC_ACU_L"></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Nombres:</label>
                            <label style="text-align: left;" class="control-label col-md-6 text-muted" name="NOM1_EST_L"></label>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-6">Apellidos:</label>
                            <label style="text-align: left;" class="control-label col-md-6 text-muted" name="APE1_EST_L"></label>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-6">Grado:</label>
                            <label style="text-align: left;" class="control-label col-md-6 text-muted" name="GRADO_EST_L"></label>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-6">Fecha Nacimiento:</label>
                            <label class="control-label col-md-1 text-muted" name="FECH_NAC_EST_L"></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Ciudad:</label>
                            <label class="control-label col-md-1 text-muted" name="CIU_EST_L"></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Direccion:</label>
                            <label style="text-align: left;" class="control-label col-md-6 text-muted" name="DIR_EST_L"></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Telefono 1:</label>
                            <label class="control-label col-md-1 text-muted" name="TEL1_EST_L"></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Telefono 2:</label>
                            <label class="control-label col-md-1 text-muted" name="TEL2_EST_L"></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Correo:</label>
                            <label class="control-label col-md-1 text-muted" name="EMAIL_EST_L"></label>
                        </div>
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