<?php $this->load->view('header_nav'); ?>
        <div class="row" style="margin-top: -10%; margin-bottom: 8%;">
            <div class="col-md-4 col-md-offset-4">
                <div class="form-group">
                <input name="codigo" class="form-control" type="text" id="codigo" onFocus="foco()" onBlur="accion()" autofocus>
                </div>
            </div>              
        </div>
<div id="page-wrapper">
    <div class="container-fluid">
    <center>
        <h1 style="font-size:20pt">Registro de Asistencia</h1>
    </center>
    <br>
    <div id="result"></div>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="form-group">
                    <center>
                        <button class="btn btn-primary btn-lg" id="btn1">Registrar llegada tarde al estudiante</button>
                    </center>
                </div>
            </div>              
        </div>
        <br>
        <p class="text-muted" id="texto" style="font-size: 20px; text-align: center;"></p>
    </div>
</div>



<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
<script src="<?php echo base_url('assets/select/js/bootstrap-select.min.js')?>"></script>

<script type="text/javascript">

var huella;
var codGrupo;

$(document).ready(function (){
    $('#codigo').focus();
});

$('#btn1').click(function (){
    $('#codigo').focus();
});

function foco(){
    $('#btn1').removeClass('btn-primary');
    $('#btn1').addClass('btn-warning');
    $('#btn1').attr('disabled','true');
    $('#texto').text("Por favor ponga la terjeta del estudiante en el lector");
}

function accion(){
    var cod = $('#codigo').val();
    if(cod.length < 9){
        $('#codigo').val("");
        $('#btn1').removeClass('btn-warning');
        $('#btn1').addClass('btn-primary');
        $('#btn1').removeAttr("disabled")
        $('#texto').text("");
    }else{
        $.ajax({
            url : "<?php echo site_url('llegadatarde/ajax_view/')?>/" + cod,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="ID_TIP_DOC_EST_L"]').text(data.NOM_TIP_DOC);
                $('[name="DOC_EST_L"]').text(data.DOC_EST);
                $('[name="NOM1_EST_L"]').text(data.NOM1_EST+" "+data.NOM2_EST);
                $('[name="APE1_EST_L"]').text(data.APE1_EST+" "+data.APE2_EST);
                $('[name="GRADO_L"]').text(data.GRADO_EST);
                $('[name="GRUPO_L"]').text(data.NUM_GRUPO);
                $('[name="DOC_ACU_L"]').text(data.DOC_ACU);
                $('[name="NOM1_ACU_L"]').text(data.NOM1_ACU+" "+data.NOM2_ACU);
                $('[name="APE1_ACU_L"]').text(data.APE1_ACU+" "+data.APE2_ACU);
                $('[name="TEL_ACU_L"]').text(data.TEL1_ACU);
                huella = cod;
                codGrupo = data.COD_GRUPO;
                $('.modal-title').text("Información del estudiante");
                $('#modal_form').modal("show");
                $('#codigo').val("");
                $('#btn1').removeClass('btn-warning');
                $('#btn1').addClass('btn-primary');
                $('#btn1').removeAttr("disabled")
                $('#texto').text("");
                cod = "";
                setTimeout("registrar()",2000);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error');
            }
        });
    }
}

    function startTime(){
        today=new Date();
        h=today.getHours();
        m=today.getMinutes();
        s=today.getSeconds();
        m=checkTime(m);
        s=checkTime(s);
        document.getElementById('04').innerHTML=h+":"+m+":"+s;
        t=setTimeout('startTime()',500);
    }
    
    function checkTime(i){
        if (i<10) {i="0" + i;}return i;
    }
    
    window.onload=function(){
        startTime();
        cargarNum(); 
        cargarMsg();
    }

$( "#codigo" ).change(function() {
    $("#codigo").blur();
});

function cerrarAlerta(){
    $("#result").removeClass("alert alert-success");
    $("#result").removeClass("alert alert-danger");
    $('#result').text('');
}


function registrar() {
    var fecha = document.getElementById('03').innerHTML;
    var hora = document.getElementById('04').innerHTML;
    $.ajax({
        url: "<?php echo site_url('llegadatarde/ajax_registrar')?>",
        type: "POST",
        data: {huella:huella, codGrupo:codGrupo, fecha:fecha, hora:hora}, 
        dataType: "JSON",
        success: function(data){
            if (data.status) {
                $('#modal_form').modal('hide');
                $("#result").addClass("alert alert-success");
                $('#result').text('Registro Exitoso'); 
            }else if(data.val){
                $('#modal_form').modal('hide');
                $("#result").addClass("alert alert-danger");
                $('#result').text('El estudiante ya tiene una llegada tarde registrada el dia de hoy'); 
            }
            else{
                $('#modal_form').modal('hide');
                $("#result").addClass("alert alert-danger");
                $('#result').text('Error Al registrar'); 
            }
            $('#codigo').focus();
            setTimeout("cerrarAlerta()",2000);
            huella = "";
            codGrupo = "";
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('Error al Registrar');
        }
    });
}

</script>

<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
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
                            <div class="col-md-6">
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Tipo de Documento:</strong></label>
                                <label name="ID_TIP_DOC_EST_L"></label>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Documento:</strong></label>
                                <label name="DOC_EST_L"></label>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Nombres:</strong></label>
                                <label name="NOM1_EST_L"></label>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Apellidos:</strong></label>
                                <label name="APE1_EST_L"></label>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Grado:</strong></label>
                                <label name="GRADO_L"></label>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Grupo:</strong></label>
                                <label name="GRUPO_L"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Documento Acudiente:</strong></label>
                                <label name="DOC_ACU_L"></label>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Nombre Acudiente:</strong></label>
                                <label name="NOM1_ACU_L"></label>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Apellido Acudiente:</strong></label>
                                <label name="APE1_ACU_L"></label>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Contacto:</strong></label>
                                <label name="TEL_ACU_L"></label>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Fecha Ingreso:</strong></label>
                                <label name="FECHA_L" id="03"><?php echo date('Y-m-d'); ?></label>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 16px;"><strong>Hora:</strong></label>
                                <label name="HORA_L" id="04"></label>
                            </div>
                        </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="registrar()" class="btn btn-primary">Guardar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</section>

  
<script src="<?php echo base_url('assets/js/jquery.nicescroll.js')?>"></script>
<script src="<?php echo base_url('assets/js/scripts.js')?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
</body>
</html>