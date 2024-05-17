<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<style type="text/css">
    td,
    th {
        padding: 1px;
        padding-top: 5px;
        padding-right: 8px;
        padding-bottom: 1px;
        padding-left: 8px;
        line-height: 1;
        vertical-align: top;
    }

    .table-total {
        border-spacing: 0;
        border-collapse: collapse;
    }

    .active1 {
        color: #fff;
        background-color: #1b55e2;
        height: 32px;
        width: 150px;
        padding: 5px;
        cursor: default;
    }

    .active2 {
        color: white;
        background-color: #009245;
        height: 32px;
        width: 150px;
        padding: 5px;
        cursor: default;
    }

    .active3 {
        color: white;
        background-color: #C10010;
        height: 32px;
        width: 150px;
        padding: 5px;
        cursor: default;
    }

    .active4 {
        color: #000000;
        background-color: #BDD7EE;
        height: 32px;
        width: 150px;
        padding: 5px;
        cursor: default;
    }

    .active5 {
        color: #000000;
        background-color: #C6E0B4;
        height: 32px;
        width: 150px;
        padding: 5px;
        cursor: default;
    }

    .active6 {
        color: #000000;
        background-color: #e7515a;
        height: 32px;
        width: 150px;
        padding: 5px;
        cursor: default;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Reglamento Interno (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a type="button" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Reglamento') ?>/<?php /*echo $id_ticket*/ ?>"> <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo Ticket" />
                        </a>

                        <a href="<?= site_url('AppIFV/Excel_Reglamento_Interno') ?>" style="margin-left: 5px;">
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
                            <th class="text-center" width="35%">Referencia</th>
                            <th class="text-center" width="10%">Activo de</th>
                            <th class="text-center" width="10%">Hasta</th>
                            <th class="text-center" width="20%">Creado por</th>
                            <th class="text-center" width="10%">Fecha</th>
                            <th class="text-center" width="10%">Estado</th>
                            <th class="text-center" width="5%"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($list_reglamento as $list) {  ?>
                            <tr class="even pointer">
                                <td><?php echo $list['refe_comuimg']; ?></td>
                                <td class="text-center"><?php echo $list['inicio_comuimg'] ?></td>
                                <td class="text-center"><?php echo $list['fin_comuimg']; ?></td>
                                <td><?php echo $list['creado_por']; ?></td>
                                <td class="text-center"><?php echo substr($list['fec_reg'], 0, 10); ?></td>
                                <td class="text-center"><?php echo $list['nom_status']; ?></td>
                                <td class="text-center">
                                    <img title="Editar Reglamento" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Editar_Reglamento') ?>/<?php echo $list["id_comuimg"]; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
                                    <?php if ($sesion['id_nivel'] == 1) { ?>
                                        <a href="#" class="" title="Eliminar" onclick="Delete_ComuImg('<?php echo $list['id_comuimg']; ?>')" role="button"> <img title="Eliminar" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" /></a>
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
        $("#pdf_reglamento").addClass('active');
		document.getElementById("rcomunicaciones").style.display = "block";
    });
</script>

<script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>

<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');

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
            ordering: false,
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25
        });

    });
</script>

<script src="<?= base_url() ?>template/fileinput/js/fileinput.min.js"></script>

<script>
    $("#btn_producto").on('click', function(e) {
        if (Valida_producto()) {
            swal.fire(
                'Carga Exitosa!',
                'Haga clic en el botón!',
                'success'
            ).then(function() {
                $('#formulario_pdf').submit();
            });


        } else {
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    });

    function Valida_producto() {
        //alert($('#tiempo').val());
        if ($('#archivo_pdf').val().trim() == '') {
            msgDate = 'Debe seleccionar un PDF';
            inputFocus = '#archivo_pdf';
            return false;
        }
        return true;
    }
</script>

<script>
    $(document).ready(function() {
        var msgDate = '';
        var inputFocus = '';
    });

    var base_url = "<?php echo site_url(); ?>";

    function Delete_ComuImg(id) {
        var id = id;
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
                    data: {
                        'id_comuimg': id
                    },
                    success: function() {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>AppIFV/PDF_Reglamento";

                        });
                    }
                });
            }
        })
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>