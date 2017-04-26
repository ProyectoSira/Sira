<?php $this->load->view('header_nav'); ?>
<div id="page-wrapper">
    <div class="container-fluid">
    <h1 style="font-size:20pt">Registro de asignacion</h1>
    <h3>Datos de asignacion</h3>
    <br>
        <div class="row">
            <div class="col-md-3">
                 <form action="#">
                     <div class="form-group">
                        <label>Grado</label>  
                        <select name="COD_GRADO" class="selectpicker form-control" data-live-search = "true" id="grado">
                            <?php 
                            foreach ($grado as $fila) {
                            ?>
                            <option value="<?= $fila->NOM_GRADO ?>"><?= $fila->NOM_GRADO?></option>
                            <?php 
                            }
                            ?>
                        </select>                      
                     </div>
                     <div class="form-group">
                     <button class="btn btn-info form-control"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                     </div>
                     <br>
                     <div class="form-group">
                        <label>Grupo</label>  
                        <select name="COD_GRADO" class="selectpicker form-control" data-live-search = "true" id="grado">
                            <?php 
                                foreach ($grupo as $fila) {
                                ?>
                                <option value="<?= $fila->COD_GRUPO ?>"><?= $fila->NOM_GRADO, " ",$fila->NUM_GRUPO?></option>
                                <?php 
                                 }
                            ?>
                        </select>                      
                     </div>
                     <div class="form-group">
                     <button class="btn btn-success form-control"><i class="glyphicon glyphicon-plus"></i> Registrar</button>
                     </div>
                 </form>
            </div>
            <div class="col-md-9">
                <div id="result"></div>
                    <table id="table" class="table table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Documento</th>
                                <th>Nombres y Apellidos</th>
                                <th style="width:20px;">Asignar</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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

var save_method;
var table;
$(document).ready(function() {
     table = $('#table').DataTable({ 

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('asignacion/ajax_list')?>",
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

 //for save method string
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





function cerrarAlerta(){
    $("#result").removeClass("alert alert-success");
    $("#result").removeClass("alert alert-info");
    $('#result').text('');
}

function add_person()
{

    
    save_method = 'add'; 
   
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Nueva Asignacion'); // Set Title to Bootstrap modal title
    //var doc_est = document.getElementById('DOC_EST');
    //doc_est.disabled = false;
    document.getElementById('ID_EST_GRUP').readOnly = false;
     $('select[name="DOC_EST"]').val();
    $('select[name="DOC_EST"]').change();
    $('select[name="COD_GRUPO"]').val();
     $('select[name="COD_GRUPO"]').change();

}

function edit_person(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    var doc_est = document.getElementById('DOC_EST');
    doc_est.disabled = true;
      
    document.getElementById('ID_EST_GRUP').readOnly = true;

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('Asignacion/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="ID_EST_GRUP"]').val(data.ID_EST_GRUP);
            $('select[name="DOC_EST"]').val(data.DOC_EST);
            $('select[name="DOC_EST"]').change();
            $('[name="COD_GRUPO"]').val(data.COD_GRUPO);
            $('select[name="COD_GRUPO"]').change();
            $('[name="FECH_INGR_GRUP"]').val(data.FECH_INGR_GRUP);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Editar Asignacion'); // Set title to Bootstrap modal title

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


function save()
{
    $('#btnSave').text('Guardando...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url('asignacion/ajax_add')?>";
    } else {
        url = "<?php echo site_url('asignacion/ajax_update')?>";
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
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                }
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
            url : "<?php echo site_url('asignacion/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error Al Eliminar');
            }
        });

    }
}

</script>

</section>
  
<script src="<?php echo base_url('assets/js/jquery.nicescroll.js')?>"></script>
<script src="<?php echo base_url('assets/js/scripts.js')?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
</body>
</html>