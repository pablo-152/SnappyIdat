<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_CC/header'); ?>
<?php $this->load->view('view_CC/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Mailing </b></span></h4>
                </div>

                <div class="heading-elements">

                    <div class="heading-btn-group">  
                        <a title="Nuevo" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('CursosCortos/Modal_Mail') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png">  
                        </a>

                        <a onclick="Excel_Contrato();" style="margin-left: 5px;">
                            <img src="<?= base_url() ?>template/img/excel.png">
                        </a>
                    </div>
                 
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
            <!-- <div class="heading-btn-group">
                <a onclick="Lista_Matricula_Pendiente(1);" id="pendientes" style="background-color:#C00000;" class="form-group btn clase_boton"><span>Pendientes</span><i class="icon-arrow-down52"></i></a>
                <a onclick="Lista_Matricula_Pendiente(3);" id="todos" style="background-color:#0070c0;" class="form-group btn clase_boton"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
                <input type="hidden" id="tipo" name="tipo" value="1">
            </div> -->

            <div class="row">
                <div class="col-lg-12" id="lista_alumno"> 

                                <table id="mail_tbl" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>CODIGO</th>
                                            <th>Asunto</th>
                                            <th>ALUMNO</th>
                                            <th>CURSO</th>
                                            <th>SECCIÓN</th>
                                            <th>ESTADO</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                </div>
            </div>

    </div>
</div>




<div class="modal" tabindex="-1" role="dialog" id="veralumos">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Lista de alumnos que les llego el correo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="texto_alumno">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script>

    
$(document).ready(function() {
        $("#configuracion").addClass('active');
        $("#hconfiguracion").attr('aria-expanded', 'true');
        $("#c_mailing").addClass('active');
		document.getElementById("rconfiguracion").style.display = "block";

    });


    var url_lista = "<?php echo site_url(); ?>CursosCortos/Mailing_list";
    function listar() {
        $('#mail_tbl').dataTable({
            "aProcessing": true, //Activamos el procesamiento del datatables
            "aServerSide": true, //Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip', //Definimos los elementos del control de tabla
            "searching": true,
            lengthChange: false,
            colReorder: true,
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "ajax": {
                url: url_lista,
                type: "post",
                dataType: "json",
                error: function(e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "responsive": true,
            "bInfo": true,
            "iDisplayLength": 10,
            "order": [
                [0, "desc"]
            ],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar MENU registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando un total de TOTAL registros",
                "sInfoEmpty": "Mostrando un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de MAX registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        }).DataTable();
    }



    function Delete_Email(id){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url="<?php echo site_url(); ?>CursosCortos/Delete_Email";
        
        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type:"POST",
                    url:url,
                    data: {'id_correo_empre':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>CursosCortos/Mailing";
                        });
                    }
                });
            }
        })
    }

    $(document).ready(function() {
        listar();
    });




    function Ver_alumno(id){
        $('#veralumos').modal('show');

        $( "#texto_alumno" ).html('');

        var url="<?php echo site_url(); ?>CursosCortos/Ver_Alumnos_mail";

                $.ajax({
                    type:"POST",
                    url:url,
                    data: {'id_correo_empre':id},
                    success:function (data) {

                        datas=$.parseJSON(data);
                        console.log("🚀 ~ file: index.php:254 ~ Ver_alumno ~ datas", datas)


                        $.each(datas, function (ind, elem) { 

                        $( "#texto_alumno" ).append( '<p>'+elem+'</p></br>' );

                        }); 


                    }
                });
    }

 
</script>

<?php $this->load->view('view_CC/footer'); ?>