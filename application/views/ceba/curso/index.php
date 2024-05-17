<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('Admin/header'); ?>
<div class="app-sidebar__overlay" data-toggle="sidebar">
</div>
<?php $this->load->view('Ceba/nav'); ?>
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
                                            <b>Lista de Cursos</b>
                                        </div>
                                        <div class="col" align="right">
                                            
                                            <a title="Nueva Empresa" style="cursor:pointer; cursor: hand;" data-toggle="modal" data-target="#acceso_modal" 
                                            app_crear_per="<?= site_url('Ceba/Modal_Curso_Regis') ?>">
                                                <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                                            </a>
                                            <a href="<?= site_url('Ceba/Excel_Grado') ?>">
                                                <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead class="text-center">
                                            <tr style="background-color: #E5E5E5;">
                                                <th><div>Año</div></th>
                                                <th><div>Grado</div></th>
                                                <th><div>Fecha Inicio</div></th>
                                                <th><div>Fecha Fin</div></th>
                                                <th><div>Observaciones</div></th>
                                                <th><div>Estado</div></th>
                                                <th><div>Acciones</div></th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php foreach($list_curso as $list) {  ?>                                           
                                                <tr class="even pointer">
                                                    <td><?php echo $list['nom_anio']; ?></td>
                                                    <td><?php echo $list['nom_grado']; ?></td>
                                                    <td><?php echo $list['fec_inicio']; ?></td>
                                                    <td><?php echo $list['fec_fin']; ?></td>
                                                    <td><?php echo $list['obs_curso']; ?></td>
                                                    <td><?php echo $list['nom_status']; ?></td>
                                                    <td>
                                                        <a title="Detalle del Curso" href="<?= site_url('Ceba/Detalles_Curso') ?>/<?php echo $list["id_curso"]; ?>">
                                                            <i class="icon fa fa-search"></i>
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
                </div>
            </div>
        </div>
    </div>    
</main>

<!--<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#example1 thead tr').clone(true).appendTo( '#example1 thead' );
        $('#example1 thead tr:eq(1) th').each( function (i) {
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

        var table = $('#example1').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            dom: 'Bfrtip',
            pageLength: 25
        } );

    } );
</script>-->

<?php $this->load->view('Ceba/footer'); ?>