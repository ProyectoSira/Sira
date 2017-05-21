<?php $this->load->view('header_nav'); ?>
<div id="page-wrapper">

<div class="container-fluid">
 
    <h1 style="font-size:20pt">Reportes</h1>
    <h4>Seleccione el tipo de reporte que desea generar</h4>

    <div class="row">
            <div class="col-md-3">
            <form action="<?php echo base_url('index.php/reportes/descargar');?>" method="POST">
                <div class="form-group">
                <select name="selectTipo" class="selectpicker form-control">
                    <option>--SELECCIONE--</option>
                    <option>LLEGADAS TARDE</option>
                </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <button type="submit" class="btn btn-info form-control" id="btnBuscar"><i class="glyphicon glyphicon-search"></i> Consultar
                    </button>
                </div> 
            </div> 
            </form>              
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

$('#btnBuscar').click(function () {
    location.href = 'http://localhost:8888/Sira/index.php/reportes/descargar';
};

</script>

</section>
  
<script src="<?php echo base_url('assets/js/jquery.nicescroll.js')?>"></script>
<script src="<?php echo base_url('assets/js/scripts.js')?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
</body>
</html>