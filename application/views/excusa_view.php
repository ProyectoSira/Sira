<?php $this->load->view('header_nav'); ?>
<div id="page-wrapper">

<div class="container-fluid">
 
        <h1 style="font-size:20pt">Registro de Excusas</h1>
        <button id="btnCambiar" class="btn btn-success"><samp class="glyphicon glyphicon-refresh"></samp> Llegadas tarde a clase</button>
        <br>
        <br>
        <h3 id="h3Cambiar">Estudiantes con llegadas tarde a la Institución</h3>
        <div id="result"></div>
        <br />
        <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>N°</th>
                    <th style="width: 20%;">Documento</th>
                    <th style="width: 55%;">Estudiante</th>
                    <th style="width: 20%;">Fecha de Inasistencia</th>
                    <th style="width: 20px;">Acción</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th>N°</th>
                <th>Documento</th>
                <th>Estudiante</th>
                <th>Fecha de Inasistencia</th>
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

var documento; //for save method string
var ruta;
var falta;
var table;
$(document).ready(function() {
    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('excusa/ajax_list')?>",
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
    $('.datepicker').datepicker({
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

$('#btnCambiar').click(function(){
    $('#btnCambiar').text("Llegadas tarde a la Institución");
    $('#h3Cambiar').text("Estudiantes con llegadas tarde a Clase");
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

function adjuntar(id, fecha){
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Adjuntar Excusa'); // Set Title to Bootstrap modal title
    documento = id;
    falta = fecha;
}

function nombre(hola) {
    hola = hola.split('\\');
    ruta = hola[hola.length-1];
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save() {
    $('#btnSave').text('Guardando...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    $.ajax({
        url : "<?php echo site_url('excusa/ajax_add')?>",
        type: "POST",
        data: {doc:documento, ruta:ruta, fech:falta},
        dataType: "JSON",
        success: function(data)
        {
            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
                $("#result").addClass("alert alert-success");
                $('#result').text('Registro Exitoso'); 
                setTimeout("cerrarAlerta()",2000);
                documento = "";
                ruta = "";
                falta = "";
                document.getElementById("URL").value = "";
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
            alert('Error al registrar la excusa');
            $('#btnSave').text('Guardar'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
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
                    <div id="alert"></div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Url Excusa <span style="color: red;">*</span></label>
                            <div class="col-md-9">
                                <input name="URL" type="file" id="URL" onchange="nombre(this.value)">
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