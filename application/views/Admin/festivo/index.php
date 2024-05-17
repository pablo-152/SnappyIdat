<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>
<?php $this->load->view('Admin/header'); ?>
<div class="app-sidebar__overlay" data-toggle="sidebar">
</div>
<?php $this->load->view('Admin/nav'); ?>
<main class="app-content">
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <div class="row tile-title line-head" style="background-color: #C1C1C1;">
                                        <div class="col" style="vertical-align: middle;">
                                            <b>Festivos & Fechas Importantes</b>
                                        </div>
                                        <div class="col" align="right">
                                            <!--<button class="btn btn-info" type="button" title="Nuevo Festivo & Fecha Importante" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Snappy/Modal_Festivo') ?>"><i class="fa fa-plus"></i> Nuevo Festivo & Fechas Importante</button>-->
                                            <?php if ($id_nivel==1 || $id_nivel==6 || $id_nivel==4) { ?>
                                            <a title="Nuevo Festivo & Fecha Importante" style="cursor:pointer; cursor: hand;" data-toggle="modal" data-target="#acceso_modal" 
                                            app_crear_per="<?= site_url('Snappy/Modal_Festivo') ?>">
                                                <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                                            </a>
                                            <?php } ?>
                                            <a href="<?= site_url('Snappy/Excel_Festivo') ?>">
                                                <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body table-responsive">
                                    <table class="table table-bordered table-striped" id="example" width="100%">
                                        <thead>
                                            <tr style="background-color: #E5E5E5;">
                                                <th><div align="center">Año</div></th>
                                                <th><div align="center">Fecha</div></th>
                                                <th><div align="center">Día de la Semana</div></th>
                                                <th><div align="center">Descripción</div></th>
                                                <th><div align="center">Tipo</div></th>
                                                <th><div align="center">Observaciones</div></th>
                                                <?php if ($id_nivel==1 || $id_nivel==6 || $id_nivel==4) { ?>
                                                    <th>&nbsp;</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($list_festivo as $list) {  ?>                                           
                                                <tr class="even pointer">

                                                    <td align="center"><?php echo $list['anio']; ?></td>
                                                    <td align="center"><?php if ($list['inicio']!='0000-00-00') echo date('d/m/Y', strtotime($list['inicio'])); ?></td>
                                                    <td align="center"><?php echo $list['nom_dia']; ?></td>
                                                    <td><?php echo $list['descripcion']; ?></td>
                                                    <td align="center"><?php echo $list['nom_tipo_fecha']; ?></td>
                                                    <td align="center"><?php echo $list['observaciones']; ?></td>
                                                    <?php if ($id_nivel==1 || $id_nivel==6 || $id_nivel==4) { ?>

                                                    <td align="center">
                                                        <img title="Editar Datos Festivo" data-toggle="modal" 
                                                        data-target="#acceso_modal_mod" 
                                                        app_crear_mod="<?= site_url('Snappy/Modal_Update_Festivo') ?>/<?php echo $list["id_calendar_festivo"]; ?>" 
                                                        src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" 
                                                        width="22" height="22" />
                                                    </td>
                                                    <?php } ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</main>
<script>
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example thead tr').clone(true).appendTo( '#example thead' );
    $('#example thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        
        $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );

    var table = $('#example').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        dom: 'Bfrtip',
        pageLength: 25
    } );

} );
</script>
<?php $this->load->view('Admin/footer'); ?>