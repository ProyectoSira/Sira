<?php $this->load->view('header_nav'); ?>
<div id="page-wrapper">
    <div class="container-fluid">
    <h1 style="font-size:20pt">Registro de Asistencia</h1>
    <br>
    <div id="result"></div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group" style="text-align: center; font-size: 23px;">
                    <label>Touch Id</label> 
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                <input name="Huella" placeholder="HUELLA ESTUDIANTE" class="form-control" type="text" id="Huella">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <button class="btn btn-info form-control" id="btnBuscar"><i class="glyphicon glyphicon-search"></i> Consultar
                    </button>
                </div> 
            </div>               
        </div>
        <br>
    </div>
</div>


<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
<script src="<?php echo base_url('assets/select/js/bootstrap-select.min.js')?>"></script>

<script type="text/javascript">

$('#btnBuscar').click(function () {
    var touch = $('#Huella').val();
    $("#05").removeAttr("checked");
    $.ajax({
        url : "<?php echo site_url('llegadatarde/ajax_view/')?>/" + touch,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="DOC_EST_L"]').text(data.DOC_EST);
            $('[name="ID_TIP_DOC_EST_L"]').text(data.NOM_TIP_DOC);
            $('[name="NOM1_EST_L"]').text(data.NOM1_EST+" "+data.NOM2_EST);
            $('[name="APE1_EST_L"]').text(data.APE1_EST+" "+data.APE2_EST);
            $('[name="GRADO_L"]').text(data.GRADO_EST);
            $('[name="DOC_ACU_L"]').text(data.DOC_ACU);
            $('[name="NOM1_ACU_L"]').text(data.NOM1_ACU+" "+data.NOM2_ACU);
            $('[name="APE1_ACU_L"]').text(data.APE1_ACU+" "+data.APE2_ACU);
            $('[name="TEL_ACU_L"]').text(data.TEL1_ACU);
            $('[name="GRUPO_L"]').text(data.NUM_GRUPO);
            $('[name="HUELLA_L"]').text(data.HUELLA_EST);
            $('[name="COD_GRUPO_L"]').text(data.COD_GRUPO);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Informacion del Estudiante'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error al consultar');
        }
    });
});

function cerrarAlerta(){
    $("#result").removeClass("alert alert-success");
    $("#result").removeClass("alert alert-danger");
    $('#result').text('');
}


function registrar() {
    var huella = document.getElementById('01').innerHTML;
    var codGrupo = document.getElementById('02').innerHTML;
    var fecha = document.getElementById('03').innerHTML;
    var hora = document.getElementById('04').innerHTML;
    var justif;
    if( $('#05').prop('checked') ) {
        justif = 1;
    }else{
        justif = 0;
    }
            $.ajax({
                url: "<?php echo site_url('llegadatarde/ajax_registrar')?>",
                type: "POST",
                data: {huella:huella, codGrupo:codGrupo, fecha:fecha, hora:hora, justificacion:justif}, 
                dataType: "JSON",
                success: function(data){
                    if (data.status) {
                        $('#modal_form').modal('hide');
                        $("#result").addClass("alert alert-success");
                        $('#result').text('Registro Exitoso'); 
                        setTimeout("cerrarAlerta()",2000);
                    }else{
                        $("#result").addClass("alert alert-danger");
                        $('#result').text('Error Al registrar'); 
                        setTimeout("cerrarAlerta()",2000);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert('Error al insetar la llegada tarde');
                }
            });
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="text-align: left; font-weight: bold;" class="control-label col-md-4">Documento:</label>
                                    <label style="text-align: left;" class="control-label col-md-1 text-muted" name="DOC_EST_L"></label>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left; font-weight: bold;" class="control-label col-md-4">Tipo Documento:</label>
                                    <label style="text-align: left;" class="control-label col-md-8 text-muted" name="ID_TIP_DOC_EST_L"></label>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left; font-weight: bold;" class="control-label col-md-4">Nombre:</label>
                                    <label style="text-align: left;" class="control-label col-md-8 text-muted" name="NOM1_EST_L"></label>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left; font-weight: bold;" class="control-label col-md-4">Apellido:</label>
                                    <label style="text-align: left;" class="control-label col-md-8 text-muted" name="APE1_EST_L"></label>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left; font-weight: bold;" class="control-label col-md-4">Grado:</label>
                                    <label style="text-align: left;" class="control-label col-md-8 text-muted" name="GRADO_L"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="text-align: left; font-weight: bold;" class="control-label col-md-4">Documento Acudiente:</label>
                                        <label style="text-align: left;" class="control-label col-md-8 text-muted" name="DOC_ACU_L"></label>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left; font-weight: bold;" class="control-label col-md-4">Nombre Acudiente:</label>
                                    <label style="text-align: left;" class="control-label col-md-8 text-muted" name="NOM1_ACU_L"></label>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left; font-weight: bold;" class="control-label col-md-4">Apellido Acudiente:</label>
                                    <label style="text-align: left;" class="control-label col-md-8 text-muted" name="APE1_ACU_L"></label>
                                </div>
                                 <div class="form-group">
                                    <label style="text-align: left; font-weight: bold;" class="control-label col-md-4">Contacto:</label>
                                    <label style="text-align: left;" class="control-label col-md-8 text-muted" name="TEL_ACU_L"></label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="text-align: left; font-weight: bold;" class="control-label col-md-4">Grupo:</label>
                                    <label style="text-align: left;" class="control-label col-md-1 text-muted" name="GRUPO_L"></label>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left; font-weight: bold;" class="control-label col-md-4">Fecha Ingreso:</label>
                                    <label id="03" style="text-align: left;" class="control-label col-md-8 text-muted" name="FECHA_L"><?php echo date('Y/m/d'); ?></label>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left; font-weight: bold;" class="control-label col-md-4">Huella:</label>
                                        <label style="text-align: left;" class="control-label col-md-8 text-muted" name="HUELLA_L" id="01"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="text-align: left; font-weight: bold;" class="control-label col-md-4">Hora:</label>
                                        <label style="text-align: left;" class="control-label col-md-8 text-muted" name="HORA_L" id="04"><?php echo date('G:i:s'); ?></label>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left; font-weight: bold;" class="control-label col-md-4">Justificacion:</label>
                                    <input id="05" type="checkbox" class="col-md-3" name="JUST">
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left; font-weight: bold;" class="control-label col-md-4">Codigo Grupo:</label>
                                        <label style="text-align: left;" class="control-label col-md-8 text-muted" name="COD_GRUPO_L" id="02"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="registrar()" class="btn btn-primary">Guardar</button>
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