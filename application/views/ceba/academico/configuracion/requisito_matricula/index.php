<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('ceba/header'); ?>
<div class="app-sidebar__overlay" data-toggle="sidebar">
</div>
<?php $this->load->view('ceba/nav'); ?>

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
                                            <b>Lista de Requisito de Matrícula</b>
                                        </div>
                                        <div class="col" align="right">
                                            <a title="Nuevo grado" style="cursor:pointer; cursor: hand;" data-toggle="modal" data-target="#acceso_modal"  app_crear_per="<?= site_url('Ceba/Modal_Requisito_Matricula') ?>">
                                                <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo area" />
                                            </a>
                                            <a href="<?= site_url('Ceba/Excel_Requisito_Matricula') ?>">
                                                <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                                            </a>
                                        </div>
                                    </div>

                                <div class="box-body table-responsive">
                                    <table id="example" class="table table-striped table-bordered text-center">
                                        <thead class="text-center">
                                            <tr style="background-color: #E5E5E5;">
                                                <th>Código</th>
                                                <th>Nombre</th>
                                                <th>Estado</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
    
                                        <tbody class="text-center">
                                            <?php foreach($list_requisito as $list) {  ?>                                           
                                                <tr class="even pointer">
                                                    <td><?php echo $list['codigo']; ?></td>
                                                    <td><?php echo $list['nombre']; ?></td>  
                                                    <td><?php echo $list['nom_status']; ?></td>                                                       
                                                    <td>
                                                        <img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod"  app_crear_mod="<?= site_url('Ceba/Modal_Update_Requisito_Matricula') ?>/<?php echo $list["id_requisito_m"]; ?>"  src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />

                                                        <img title="Eliminar" onclick="Delete_Requisito_Matricula('<?php echo $list['id_requisito_m']; ?>')" id="id_area" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
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
<?php $this->load->view('ceba/footer'); ?>