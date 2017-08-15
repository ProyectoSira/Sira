<?php $this->load->view('header_nav'); ?>
<div id="page-wrapper">

<div class="container-fluid">
 
    <h1 style="font-size:20pt">Reportes</h1>
    <h4>Seleccione el tipo de reporte que desea generar</h4>
    <br>
    <div id="result"></div>

        <div class="row">
            <div class="col-md-3">

                <div class="form-group">
                <select id="tipo" name="selectTipo" class="selectpicker form-control" data-live-search="true">
                    <option value="0">--SELECCIONE--</option>
                    <option value="1">LLEGADAS TARDE A LA INSTITUCIÓN</option>
                    <option value="2">SANCIONES</option>
                    <option value="3">INASISTENCIA A CLASE</option>
                </select>
                </div>
            </div>
        </div>
        <div id="checks">
            <div class="row">
                <div class="col-md-2">
                    <label>Reporte del dia</label>
                    <input type="checkbox" id="dia">
                </div>
                <div class="col-md-2">
                    <label>Rango de fecha</label>
                    <input type="checkbox" id="rango">
                </div>
            </div>
        </div>
        <br>
        <div id="divRango">
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label">Fecha de inicio <span style="color: red;">*</span></label>
                    <div class="col-md-3">
                        <input name="inicio" placeholder="YYYY-MM-DD" class="form-control inicio" id="datepicker" type="text" data-date-end-date="0d" readonly="false">                                
                    </div>                            
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label">Fecha de fin <span style="color: red;">*</span></label>
                    <div class="col-md-3">
                        <input name="fin" placeholder="YYYY-MM-DD" class="form-control fin" id="datepicker2" type="text" data-date-end-date="0d" readonly="false">                                
                    </div>                            
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <button class="btn btn-info form-control" id="btnBuscar"><i class="glyphicon glyphicon-search"></i> Generar
                    </button>
                </div> 
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

$(document).ready(function() {
    $('#divRango').hide();
    $('#datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true,
            todayHighlight: true,  
    });

    $('#datepicker2').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true,
            todayHighlight: true,  
    });
});

function cerrarAlerta(){
    $("#result").removeClass("alert alert-danger");
    $('#result').text('');
}

$('#btnBuscar').click(function () {
    var tipo = $('#tipo').val();
    if (tipo == 0){
        $("#result").addClass("alert alert-danger");
        $('#result').text('Por favor seleccione el tipo de reporte'); 
        setTimeout("cerrarAlerta()",3000); 
    }else if (tipo == 1) {
        if($("#dia").prop("checked")){
            location.href = 'http://localhost:8888/Sira/index.php/reportes/tarde';
            $("#dia").prop("checked", "");
        }
        else if ($("#rango").prop("checked")) {
            var inicio = $('.inicio').val();
            var fin = $('.fin').val();
            if(inicio == '' || fin == ''){
                $("#result").addClass("alert alert-danger");
                $('#result').text('La fecha de inicio y de fin son obligatorias'); 
                setTimeout("cerrarAlerta()",3000);
            }else{
                if (inicio >= fin) {
                    $("#result").addClass("alert alert-danger");
                    $('#result').text('La fecha de inicio no puede ser posterior o igual la fecha de fin'); 
                    setTimeout("cerrarAlerta()",3000);
                }else{
                    location.href = 'http://localhost:8888/Sira/index.php/reportes/tardeRango/'+inicio+'/'+fin;
                    $("#dia").prop("checked", "");
                    $("#rango").prop("checked", "");
                    $('#divRango').hide();
                    $('.inicio').val('');
                    $('.fin').val('');
                }
            }
        }
        else{
            $("#result").addClass("alert alert-danger");
            $('#result').text('Seleccione el reporte del día o por rango de fecha'); 
            setTimeout("cerrarAlerta()",3000); 
        }
    }else if(tipo == 2){
        if($("#dia").prop("checked")){
            location.href = 'http://localhost:8888/Sira/index.php/reportes/sanciones';
            $("#dia").prop("checked", "");
        }
        else if ($("#rango").prop("checked")) {
            var inicio = $('.inicio').val();
            var fin = $('.fin').val();
            if(inicio == '' || fin == ''){
                $("#result").addClass("alert alert-danger");
                $('#result').text('La fecha de inicio y de fin son obligatorias'); 
                setTimeout("cerrarAlerta()",3000);
            }else{
                if (inicio >= fin) {
                    $("#result").addClass("alert alert-danger");
                    $('#result').text('La fecha de inicio no puede ser posterior o igual la fecha de fin'); 
                    setTimeout("cerrarAlerta()",3000);
                }else{
                    location.href = 'http://localhost:8888/Sira/index.php/reportes/sancionesRango/'+inicio+'/'+fin;
                    $("#dia").prop("checked", "");
                    $("#rango").prop("checked", "");
                    $('#divRango').hide();
                    $('.inicio').val('');
                    $('.fin').val('');
                }
            } 
        }
        else{
            $("#result").addClass("alert alert-danger");
            $('#result').text('Seleccione el reporte del día o por rango de fecha'); 
            setTimeout("cerrarAlerta()",3000); 
        }
    }else{
        if($("#dia").prop("checked")){
            location.href = 'http://localhost:8888/Sira/index.php/reportes/clases';
            $("#dia").prop("checked", "");
        }
        else if ($("#rango").prop("checked")) {
            var inicio = $('.inicio').val();
            var fin = $('.fin').val();
            if(inicio == '' || fin == ''){
                $("#result").addClass("alert alert-danger");
                $('#result').text('La fecha de inicio y de fin son obligatorias'); 
                setTimeout("cerrarAlerta()",3000);
            }else{
                if (inicio >= fin) {
                    $("#result").addClass("alert alert-danger");
                    $('#result').text('La fecha de inicio no puede ser posterior o igual la fecha de fin'); 
                    setTimeout("cerrarAlerta()",3000);
                }else{
                    location.href = 'http://localhost:8888/Sira/index.php/reportes/clasesRango/'+inicio+'/'+fin;
                    $("#dia").prop("checked", "");
                    $("#rango").prop("checked", "");
                    $('#divRango').hide();
                    $('.inicio').val('');
                    $('.fin').val('');
                }
            } 
        }
        else{
            $("#result").addClass("alert alert-danger");
            $('#result').text('Seleccione el reporte del día o por rango de fecha'); 
            setTimeout("cerrarAlerta()",3000); 
        }
    }
});

$('#rango').click(function () {
    if($("#rango").prop("checked")){
        $("#dia").prop("checked", "");
        $('#divRango').show();
    }else{
        $('#divRango').hide();
    }
});

$('#dia').click(function () {
    $("#rango").prop("checked", "");
    $('#divRango').hide();
    $('.inicio').val('');
    $('.fin').val('');
});



</script>


</section>
  
<script src="<?php echo base_url('assets/js/jquery.nicescroll.js')?>"></script>
<script src="<?php echo base_url('assets/js/scripts.js')?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
</body>
</html>