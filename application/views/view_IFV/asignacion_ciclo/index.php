<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('view_IFV/header'); ?>
<div class="app-sidebar__overlay" data-toggle="sidebar">
</div>
<?php $this->load->view('view_IFV/nav'); ?>
<main class="app-content">
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <div class="row tile-title line-head"  style="background-color: #C1C1C1;">
                                        <div class="col" style="vertical-align: middle;">
                                            <b>Lista de Asignación de Ciclos</b>
                                        </div>
                                        <div class="col" align="right">
                                            <a title="Nuevo Centro" style="cursor:pointer; cursor: hand;" data-toggle="modal" data-target="#acceso_modal" 
                                            app_crear_per="<?= site_url('AppIFV/Modal_Asignacion_Ciclo') ?>">
                                                <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                                            </a>
                                            <a href="">
                                                <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="example" class="table table-striped table-bordered" >
                                        <thead>
                                            <tr style="background-color: #E5E5E5;">
                                                <th><div align="center">Carrera</div></th>
                                                <th><div align="center">Ciclo</div></th>
                                                <th><div align="center">Estado</div></th>
                                                <th><div align="center">&nbsp;&nbsp;</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($list_asignacion_ciclo as $list) {  ?>                                           
                                                <tr class="even pointer">                                                  
                                                    <td align="center"><?php echo $list['codigo']; ?></td>
                                                    <td align="center"><?php echo $list['ciclo']; ?></td>
                                                    <td align="center"><?php echo $list['nom_status']; ?></td>

                                                    <td align="center">
                                                        <img title="Editar Datos Ciclo" data-toggle="modal"  data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_Asignacion_Ciclo') ?>/<?php echo $list["id_asignacion_ciclo"]; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" width="22" height="22"/>
                                                        <a href="#" class="" title="Eliminar" onclick="Delete_Asignacion_Ciclo('<?php echo $list['id_asignacion_ciclo']; ?>')" role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;" width="22" height="22"/></a>
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

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>