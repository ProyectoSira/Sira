<?php $this->load->view('header_nav'); ?>
<div id="page-wrapper">
    <div class="container-fluid">
    <div class="page-header">
    <h1>Configuracion de Usuario <span class="glyphicon glyphicon-cog"></span></h1>
    </div>
    <div id="result"></div>
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading"><h2>Informacion Personal <span class="glyphicon glyphicon-th-list"></span></h2></div>
                    <div class="panel-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Tipo de Documento:</strong></label>
                                <label id="tipoDoc"></label>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Documento:</strong></label>
                                <label id="Doc"></label>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Nombres:</strong></label>
                                <label id="Nom"></label>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Apellidos:</strong></label>
                                <label id="Ape"></label>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Cargo en la Institucion:</strong></label>
                                <label id="Cargo"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Direccion:</strong></label>
                                <label id="Dir"></label>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Fecha de Nacimiento:</strong></label>
                                <label id="fecNac"></label>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Ciudad:</strong></label>
                                <label id="Ciu"></label>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Correo Electronico:</strong></label>
                                <label id="Email"></label>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Telefono:</strong></label>
                                <label id="Tel"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading"><h2>Información de Usuario <span class="glyphicon glyphicon-user"></span></h2></div>
                    <div class="panel-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Nombre de Usuario:</strong></label>
                                <label><?php echo ($this->session->userdata['logged_in']['nombre'])?></label>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary form-control" id="btnEditNom"><span class="glyphicon glyphicon-pencil"></span> Editar nombre de usuario</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Rol del Usuario:</strong></label>
                                <label><?php echo ($this->session->userdata['logged_in']['rol'])?></label>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary form-control" id="btnEditPass"><span class="glyphicon glyphicon-pencil"></span> Cambiar contraseña</button>
                            </div>
                        </div>
                    </div>
                </div>
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

$(document).ready(function() {

    $.ajax({
        url : "<?php echo site_url('configuracion/ajax_list')?>",
        type: "POST",
        dataType: "JSON",
        success: function(data)
        {            
            $('#tipoDoc').text(data.NOM_TIP_DOC);
            $('#Doc').text(data.DOC_EMP);
            $('#Nom').text(data.NOM1_EMP+" "+data.NOM2_EMP);
            $('#Ape').text(data.APE1_EMP+" "+data.APE2_EMP);
            $('#Cargo').text(data.NOM_CARGO_EMP);
            $('#Dir').text(data.DIR_EMP);
            $('#fecNac').text(data.FECH_NAC_EMP);
            $('#Ciu').text(data.NOM_CIUDAD);
            $('#Email').text(data.EMAIL_EMP);
            $('#Tel').text(data.TEL1_EMP);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error');
        }
    });
  
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
 
});


    function cerrarAlerta(){
        $("#result").removeClass("alert alert-success");
        $('#result').text('');
    }

    function cerrarAlerta2(){
        $("#result2").removeClass("alert alert-danger");
        $('#result2').text('');
    }

    function cerrarAlerta3(){
        $("#result3").removeClass("alert alert-danger");
        $('#result3').text('');
    }

    $('#btnEditNom').click(function () {
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Editar Nombre de Usuario');
    });

    $('#btnEditPass').click(function () {
        $('#form2')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form2').modal('show'); // show bootstrap modal
        $('.modal-title2').text('Cambiar Contraseña');
    });
    
    function save() {
        $.ajax({
                url: "<?php echo site_url('Configuracion/ajax_editNom')?>",
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data){
                    if (data.status) {
                        $('#modal_form').modal('hide');
                        $("#result").addClass("alert alert-success");
                        $('#result').text('Nombre de usuario modificado exitosamente'); 
                        setTimeout("cerrarAlerta()",1000);
                    }else if (data.error) {
                        $("#result2").addClass("alert alert-danger");
                        $('#result2').text('El documento es incorrecto'); 
                        setTimeout("cerrarAlerta2()",3000);
                    }else
                    {
                        for (var i = 0; i < data.inputerror.length; i++) 
                        {
                            $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert('Error al cambiar el usuario');
                }
        });
    }

    function save2() {
        $.ajax({
                url: "<?php echo site_url('Configuracion/ajax_editPass')?>",
                type: "POST",
                data: $('#form2').serialize(),
                dataType: "JSON",
                success: function(data){
                    if (data.status) {
                        $('#modal_form2').modal('hide');
                        $("#result").addClass("alert alert-success");
                        $('#result').text('La contraseña se ha modificado exitosamente'); 
                        setTimeout("cerrarAlerta()",3000);
                    }else if (data.error) {
                        $("#result3").addClass("alert alert-danger");
                        $('#result3').text('Las contraseñas no coinciden'); 
                        setTimeout("cerrarAlerta3()",3000);
                    }else if (!(data.error)) {
                        $("#result3").addClass("alert alert-danger");
                        $('#result3').text('El nombre de usuario es incorrecto'); 
                        setTimeout("cerrarAlerta3()",3000);
                    }else
                    {
                        for (var i = 0; i < data.inputerror.length; i++) 
                        {
                            $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert('Error al cambiar la contraseña');
                }
        });
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
                    <div id="result2"></div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Documento <span style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <input name="DOC_EMP" placeholder="DOCUMENTO" class="form-control" type="text" id="DOC_EMP" onkeypress="return justNumbers(event);">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nuevo Usuario <span style="color: red;">*</span></label>
                            <div class="col-md-9">
                            <input name="NOM_USU" placeholder="NOMBRE DE USUARIO" class="form-control" type="text" onkeypress="return validar(event)">
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

<div class="modal fade" id="modal_form2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title2"></h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form2" class="form-horizontal">
                    <div class="form-body">
                    <div id="result3"></div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Nombre de Usuario <span style="color: red;">*</span></label>
                            <div class="col-md-8">
                                <input name="NOM_USU2" placeholder="NOMBRE DE USUARIO" class="form-control" type="text" id="DOC_EMP" >
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Contraseña <span style="color: red;">*</span></label>
                            <div class="col-md-8">
                            <input name="PASS_USU" placeholder="CONTRASEÑA" class="form-control" type="password" >
                            <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Confirmar Contraseña <span style="color: red;">*</span></label>
                            <div class="col-md-8">
                            <input name="PASS_USU2" placeholder="CONFIRMAR CONTRASEÑA" class="form-control" type="password" >
                            <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save2()" class="btn btn-primary">Guardar</button>
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