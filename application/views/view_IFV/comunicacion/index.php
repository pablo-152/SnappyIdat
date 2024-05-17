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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Resultados IFV (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a type="button" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Insertar_Admision') ?>"> 
                            <img src="<?= base_url() ?>template/img/nuevo.png">
                        </a>

                        <a href="<?= site_url('AppIFV/Excel_Resultados_IFV') ?>" style="margin-left: 5px;">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-hover table-bordered table-striped" id="example" width="100%">
                    <thead>
                        <tr style="background-color: #E5E5E5;">
                            <th>Orden</th>
                            <th class="text-center" width="10%">Tipo</th>
                            <th class="text-center" width="29%">Referencia</th>
                            <th class="text-center" width="8%">Activo de</th>
                            <th class="text-center" width="8%">Hasta</th>
                            <th class="text-center" width="20%">Creado por</th>
                            <th class="text-center" width="10%">Fecha</th>
                            <th class="text-center" width="10%">Estado</th>
                            <th class="text-center" width="5%"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($list_comu_img as $list) {  ?>
                            <tr class="even pointer">
                                <td><?php echo $list['inicio_comuimg'] ?></td>
                                <td class="text-center"><?php echo $list['tipo']; ?></td>
                                <td><?php echo $list['refe_comuimg']; ?></td>
                                <td class="text-center"><?php echo $list['inicio'] ?></td>
                                <td class="text-center"><?php echo $list['fin']; ?></td>
                                <td><?php echo $list['creado_por']; ?></td>
                                <td class="text-center"><?php echo substr($list['fec_reg'], 0, 10); ?></td>
                                <td class="text-center"><?php echo $list['nom_status']; ?></td>
                                <td class="text-center">
                                    <img title="Editar Datos Postulante" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Editar_Admision') ?>/<?php echo $list["id_comuimg"]; ?>" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;"/>
                                    <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_nivel']==6) { ?>
                                        <a href="#" class="" title="Eliminar" onclick="Delete_ComuImg('<?php echo $list['id_comuimg']; ?>')" role="button"> <img title="Eliminar" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"/></a>
                                    <?php } ?>
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
        $("#comunicaciones").addClass('active');
        $("#hcomunicaciones").attr('aria-expanded', 'true');
        $("#resultados").addClass('active');
		document.getElementById("rcomunicaciones").style.display = "block";

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
            order: [[0,"desc"],[7,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 8 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        });
    });

    function Delete_ComuImg(id) {
        $(document)
        .ajaxStart(function() {
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
        .ajaxStop(function() {
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

        var url = "<?php echo site_url(); ?>AppIFV/Delete_ComuImg";

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
                    type: "POST",
                    url: url,
                    data: {'id_comuimg': id},
                    success: function() {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>AppIFV/PDF_Admision";
                        });
                    }
                });
            }
        })
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>