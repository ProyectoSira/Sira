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
                <input name="Huella" placeholder="HUELLA ESTUDIANTE" class="form-control" type="text" id="Huella" autofocus>
                </div>
            </div>              
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading"><h2>Informacion Del Estudiante <span class="glyphicon glyphicon-th-list"></span></h2></div>
                    <div class="panel-body">
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
                        <div class="col-md-12">
                            <button type="button" id="btnSave" onclick="registrar()" class="form-control btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Registrar</button>
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

var huella;
var codGrupo;

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

$( "#Huella" ).change(function() {
    var touch = $('#Huella').val();
    $.ajax({
        url : "<?php echo site_url('llegadatarde/ajax_view/')?>/" + touch,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="DOC_EST_L"]').text(data.DOC_EST);
            huella = data.DOC_EST;
            $('[name="ID_TIP_DOC_EST_L"]').text(data.NOM_TIP_DOC);
            $('[name="NOM1_EST_L"]').text(data.NOM1_EST+" "+data.NOM2_EST);
            $('[name="APE1_EST_L"]').text(data.APE1_EST+" "+data.APE2_EST);
            $('[name="GRADO_L"]').text(data.GRADO_EST);
            $('[name="DOC_ACU_L"]').text(data.DOC_ACU);
            $('[name="NOM1_ACU_L"]').text(data.NOM1_ACU+" "+data.NOM2_ACU);
            $('[name="APE1_ACU_L"]').text(data.APE1_ACU+" "+data.APE2_ACU);
            $('[name="TEL_ACU_L"]').text(data.TEL1_ACU);
            $('[name="GRUPO_L"]').text(data.NUM_GRUPO);
            codGrupo = data.COD_GRUPO;
            $('#Huella').val('');
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
    location.reload();
}


function registrar() {
    var fecha = document.getElementById('03').innerHTML;
    var hora = document.getElementById('04').innerHTML;
    var justif;
    $.ajax({
        url: "<?php echo site_url('llegadatarde/ajax_registrar')?>",
        type: "POST",
        data: {huella:huella, codGrupo:codGrupo, fecha:fecha, hora:hora}, 
        dataType: "JSON",
        success: function(data){
            if (data.status) {
                $("#result").addClass("alert alert-success");
                $('#result').text('Registro Exitoso'); 
                setTimeout("cerrarAlerta()",1000);
                huella = "";
                codGrupo = "";
            }else{
                $("#result").addClass("alert alert-danger");
                $('#result').text('Error Al registrar'); 
                setTimeout("cerrarAlerta()",2000);
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('Error al Registrar');
        }
    });
}

</script>

<!-- Bootstrap modal -->
</section>

  
<script src="<?php echo base_url('assets/js/jquery.nicescroll.js')?>"></script>
<script src="<?php echo base_url('assets/js/scripts.js')?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
</body>
</html>