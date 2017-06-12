<?php $this->load->view('header_nav'); ?>
<div id="page-wrapper">
    <div class="container-fluid">
    <div class="page-header">
    <h1>Asignación de Usuarios</h1>
    </div>
    <h3>Registrar nuevo usuario</h3>
    <br>
    <div id="result"></div>
    <br>
    <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Empleado</label>
                        <select id="DOC_EMP" name="DOC_EMP" class="selectpicker form-control emp" data-live-search="true">
                            <option value="">--SELECCIONAR--</option>
                            <?php 
                                foreach ($empleado as $filas) 
                                {
                            ?>
                                <option value="<?= $filas->DOC_EMP ?>" data-subtext="<?=$filas->DOC_EMP ?>">
                                <?= $filas->NOM1_EMP," ",$filas->NOM2_EMP," ",$filas->APE1_EMP," ",$filas->APE2_EMP?></option>
                            <?php 
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Rol del Usuario</label>
                        <input disabled="true" type="text" id="ROL_USU" name="ROL_USU" class="form-control" placeholder="ROL DEL USUARIO">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre de Usuario</label>
                        <input disabled="true" type="text" id="NOM_USU" name="NOM_USU" class="form-control" placeholder="NOMBRE DE USUARIO">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input disabled="true" type="password" id="PASS_USU" name="PASS_USU" class="form-control" placeholder="CONTRASEÑA">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <button class="btn btn-success form-control" id="btnGuardar"><span class="glyphicon glyphicon-ok"></span> Guardar</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <button class="btn btn-danger form-control" id="btnCancelar"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
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

    function cerrarAlerta(){
        $("#result").removeClass("alert alert-success");
        $("#result").removeClass("alert alert-danger");
        $('#result').text('');
    }

    
    $( "#DOC_EMP" ).change(function() {
        var empleado = $('#DOC_EMP').val();
        $.ajax({
                url: "<?php echo site_url('usuario/ajax_cargar')?>",
                type: "POST",
                data: {DOC_EMP:empleado},
                dataType: "JSON",
                success: function(data){
                    $('#ROL_USU').val(data.NOM_CARGO_EMP.toLowerCase());
                    $('#NOM_USU').val(data.EMAIL_EMP.toLowerCase());
                    $('#PASS_USU').val(data.DOC_EMP);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert('Error');
                }
        });
    });
    
    $('#btnGuardar').click(function () {
        var empleado = $('#DOC_EMP').val();
        var rol = $('#ROL_USU').val();
        var nombre = $('#NOM_USU').val();
        var clave = $('#PASS_USU').val();
        if (rol == 'coordinador') {
            rol = 1;
        }else if (rol == 'profesor') {
            rol = 2;
        }else{
            rol = 3;
        }
        $.ajax({
                url: "<?php echo site_url('usuario/ajax_registrar')?>",
                type: "POST",
                data: {NOM_USU:nombre, PASS_USU:clave, DOC_EMP:empleado, ROL_USU:rol},
                dataType: "JSON",
                success: function(data){
                    if (data.status) {
                        $('.emp').find('[value='+empleado+']').remove();
                        $('.emp').selectpicker('refresh');
                        $('#ROL_USU').val('');
                        $('#NOM_USU').val('');
                        $('#PASS_USU').val('');
                        $("#result").addClass("alert alert-success");
                        $('#result').text('Registro Exitoso'); 
                        setTimeout("cerrarAlerta()",3000);
                    }else if (data.error) {
                        $("#result").addClass("alert alert-danger");
                        $('#result').text('El empleado ya tiene un usuario asignado'); 
                        setTimeout("cerrarAlerta()",3000);
                    }else{
                        for (var i = 0; i < data.inputerror.length; i++) 
                        {
                            $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class

                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert('Error al registrar el usuario');
                }
        });
    });

    $('#btnCancelar').click(function () {
        var empleado = $('#DOC_EMP').val();
        $('#ROL_USU').val('');
        $('#NOM_USU').val('');
        $('#PASS_USU').val('');
        $('.emp').find('[value='+empleado+']').remove();
        $('.emp').selectpicker('refresh');

    });

</script>

</section>

  
<script src="<?php echo base_url('assets/js/jquery.nicescroll.js')?>"></script>
<script src="<?php echo base_url('assets/js/scripts.js')?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
</body>
</html>