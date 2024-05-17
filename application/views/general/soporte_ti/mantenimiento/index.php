<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('general/header'); ?>
<div class="app-sidebar__overlay" data-toggle="sidebar">
</div>
<?php $this->load->view('general/nav'); ?>
<main class="app-content">
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title" style="background-color: #C1C1C1;">
                                    <div class="row tile-title line-head" style="background-color: #C1C1C1;">
                                        <div class="col" style="vertical-align: middle;">
                                            <b>Lista de Mantenimiento</b>
                                        </div>
                                        <div class="col" align="right">
                                            <a title="Nuevo Tipo" style="cursor:pointer; cursor: hand;" data-toggle="modal" data-target="#acceso_modal" 
                                                app_crear_per="<?= site_url('General/Modal_Mantenimiento') ?>">
                                                <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                                            </a>

                                            <a href="<?= site_url('General/Excel_Mantenimiento') ?>">
                                                <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-body table-responsive">
                                    <table class="table table-bordered table-striped" id="example" width="100%">
                                        <thead>
                                            <tr style="background-color: #E5E5E5;">
                                                <th><div align="center">Nombres</div></th>
                                                <th><div align="center">Apellido Paterno</div></th>
                                                <th><div align="center">Apellido Materno</div></th>
                                                <th><div align="center">Correo</div></th> 
                                                <th><div align="center">Teléfono</div></th>  
                                                <th><div align="center">Fecha de Nacimiento</div></th>   
                                                <th><div align="center">Estado</div></th>  
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($list_mantenimiento as $list) {  ?>                                           
                                                <tr class="even pointer">
                                                    <td align="center"><?php echo $list['nombres']; ?></td>
                                                    <td align="center"><?php echo $list['apater']; ?></td>
                                                    <td align="center"><?php echo $list['amater']; ?></td>
                                                    <td align="center"><?php echo $list['email']; ?></td>
                                                    <td align="center"><?php echo $list['telefono']; ?></td>
                                                    <td align="center"><?php echo $list['fecha_nacimiento']; ?></td>
                                                    <td align="center"><?php echo $list['nom_status']; ?></td>

                                                    <td align="center">                   
                                                        <img title="Editar Datos del Tipo" data-toggle="modal" 
                                                        data-target="#acceso_modal_mod" 
                                                        app_crear_mod="<?= site_url('General/Modal_Update_Mantenimiento') ?>/<?php echo $list['id_mantenimiento']; ?>" 
                                                        src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" 
                                                        width="22" height="22" />
                                                    </td>
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