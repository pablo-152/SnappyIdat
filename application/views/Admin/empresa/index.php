<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
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
                                    <div class="row tile-title line-head"  style="background-color: #C1C1C1;">
                                        <div class="col" style="vertical-align: middle;">
                                            <b>Lista de Empresas</b>
                                        </div>
                                        <div class="col" align="right">
                                            <!--<button   class="btn btn-info" type="button" title="Nueva Empresa" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Ceba/Modal_Grado_Regis') ?>"><i class="fa fa-plus"></i> Nuevo Grado</button> -->
                                            <a title="Nueva Empresa" style="cursor:pointer; cursor: hand;" data-toggle="modal" data-target="#acceso_modal" 
                                            app_crear_per="<?= site_url('Snappy/Modal_Empresa') ?>">
                                                <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                                            </a>
                                            <a href="<?= site_url('Snappy/Excel_Empresa') ?>">
                                                <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="example" class="table table-striped table-bordered" >
                                        <thead>
                                            <tr style="background-color: #E5E5E5;">
                                                <th width="16%"><div align="center" >Empresa</div></th>
                                                <th width="12%"><div align="center">Código</div></th>
                                                <th width="12%"><div align="center">Orden</div></th>
                                                <th width="25%"><div align="center">Observaciones</div></th>
                                                <th width="16%"><div align="center">Rep. Redes</div></th>
                                                <th width="16%"><div align="center">Status</div></th>
                                                <th width="4%"><div align="center">&nbsp;&nbsp;</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($list_empresa as $list) {  ?>                                           
                                                <tr class="even pointer">
                                                    <td  align="center"><?php echo $list['nom_empresa']; ?></td>
                                                    <td  align="center"><?php echo $list['cod_empresa']; ?></td>
                                                    <td  align="center"><?php echo $list['orden_empresa']; ?></td>
                                                    <td  align="center"><?php echo $list['observaciones_empresa']; ?></td>
                                                    <td  align="center"><?php if ($list['rep_redes']==1) {echo "Si";} else {echo "No";}?></td>
                                                    <td  align="center"><?php echo $list['nom_status']; ?></td>
                                                    <td align="center">
                                                        <img title="Editar Datos Empresa" data-toggle="modal" 
                                                        data-target="#acceso_modal_mod" 
                                                        app_crear_mod="<?= site_url('Snappy/Modal_Update_Empresa') ?>/<?php echo $list["id_empresa"]; ?>" 
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