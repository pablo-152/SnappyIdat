<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span id="titulo" class="text-semibold"><b>Invitados (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nueva Módulo" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" 
                        app_crear_per="<?= site_url('AppIFV/Modal_Invitado') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                        </a>

                        <a onclick="Excel_Invitado();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row"> 
            <div class="col-lg-12">
                <table id="example" class="table table-hover table-bordered table-striped" width="100%">
                    <thead>
                        <tr style="background-color: #E5E5E5;">
                            <th width="10%" class="text-center">Fecha</th>
                            <th width="35%" class="text-center">Persona</th>
                            <th width="10%" class="text-center">DNI</th>
                            <th width="30%" class="text-center">Institución/Empresa</th>
                            <th width="10%" class="text-center">Invitado</th>
                            <th width="20%" class="text-center">Usuario</th>
                            <th width="5%" class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list_invitado as $list){ ?>
                            <tr class="even pointer text-center">
                                <td><?php echo $list['fecha']; ?></td>
                                <td class="text-left"><?php echo $list['persona']; ?></td>
                                <td><?php echo $list['dni']; ?></td>
                                <td class="text-left"><?php echo $list['inst_empresa']; ?></td>
                                <td><?php echo $list['invitado']; ?></td>
                                <td><?php echo $list['user_cod']; ?></td>
                                <td>
                                    <img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal" 
                                    app_crear_per="<?= site_url('AppIFV/Modal_Update_Invitado') ?>/<?php echo $list['id_invitado']; ?>"
                                    src="<?= base_url() ?>template/img/editar.png">
                                    <a href="#" class="" title="Eliminar" onclick="Delete_Invitado('<?php echo $list['id_invitado']; ?>')"> 
                                        <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png">
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#asistencias").addClass('active');
        $("#hasistencias").attr('aria-expanded', 'true');
        $("#invitados_asistencias").addClass('active');
		document.getElementById("rasistencias").style.display = "block";

        $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            if(title==""){
                $(this).html('');
            }else{
                $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
            }
        
            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        }); 

        var table = $('#example').DataTable({
            order: [[0,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 5 ]
                }
            ]
        });
    });

    function Delete_Invitado(id){
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

        var url="<?php echo site_url(); ?>AppIFV/Delete_Invitado";
        
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
                    data: {'id_invitado':id},
                    success:function () {
                        window.location = "<?php echo site_url(); ?>AppIFV/Invitado";
                    }
                });
            }
        })
    }

    function Excel_Invitado(){
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Invitado";
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>