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
                <select id="tipo" name="selectTipo" class="selectpicker form-control">
                    <option value="0">--SELECCIONE--</option>
                    <option value="1">LLEGADAS TARDE</option>
                    <option value="2">SANCIONES</option>
                </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <button class="btn btn-info form-control" id="btnBuscar"><i class="glyphicon glyphicon-search"></i> Generar
                    </button>
                </div> 
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
        location.href = 'http://localhost:8888/Sira/index.php/reportes/tarde';
    }else{
        location.href = 'http://localhost:8888/Sira/index.php/reportes/sanciones';
    }
});

</script>

</section>
  
<script src="<?php echo base_url('assets/js/jquery.nicescroll.js')?>"></script>
<script src="<?php echo base_url('assets/js/scripts.js')?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
</body>
</html>