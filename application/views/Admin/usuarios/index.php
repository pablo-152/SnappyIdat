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
                                    <div class="row tile-title line-head" style="background-color: #C1C1C1;">
                                        <div class="col" style="vertical-align: middle;">
                                            <b>Lista de Usuario</b>
                                        </div>
                                        <div class="col" align="right">
                                            <!--<button class="btn btn-info" type="button" title="Nuevo Usuario" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Snappy/Modal_Usuario') ?>"><i class="fa fa-plus"></i> Nuevo Usuario</button>-->
                                            <a title="Nuevo Usuario" style="cursor:pointer; cursor: hand;" data-toggle="modal" data-target="#acceso_modal" 
                                            app_crear_per="<?= site_url('Snappy/Modal_Usuario') ?>">
                                                <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                                            </a>
                                            <a href="<?= site_url('Snappy/Excel_Usuario') ?>" target="_blank">
                                                <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-body table-responsive">
                                    <table class="table table-bordered table-striped" id="example" width="100%">
                                        <thead>
                                            <tr style="background-color: #E5E5E5;">
                                                <th><div align="center">Usuario</div></th>
                                                <th><div align="center">Código</div></th>
                                                <th><div align="center">Apellido(s)Mat</div></th>
                                                <th><div align="center">Apellido(s)Pat</div></th>
                                                <th><div align="center">Nombre(s)</div></th>
                                                <th><div align="center">Perfil</div></th>
                                                <th><div align="center">Código GL</div></th>
                                                <th><div align="center">Ini. Funciones</div></th>
                                                <th><div align="center">Ter. Funciones</div></th>
                                                <th><div align="center">Último Ingreso</div></th>
                                                <th width="2%"><div align="center">Status</div></th> 
                                                <th>&nbsp;&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($list_usuario as $list) {  ?>                                           
                                            <tr class="even pointer">
                                            
                                                <td align="center"><?php echo $list['usuario_codigo']; ?></td>
                                                <td align="center"><?php echo $list['codigo']; ?></td>
                                                <td align="center"><?php echo $list['usuario_apater']; ?></td>
                                                <td align="center"><?php echo $list['usuario_amater']; ?></td>
                                                <td align="center"><?php echo $list['usuario_nombres']; ?></td>
                                                <td align="center"><?php echo $list['nom_nivel']; ?></td>
                                                <td align="center"><?php echo $list['codigo_gllg']; ?></td>
                                                <td align="center"><?php if ($list['ini_funciones']!='0000-00-00') echo date('d/m/Y', strtotime($list['ini_funciones'])); ?></td>
                                                <td align="center"><?php if ($list['fin_funciones']!='0000-00-00') echo date('d/m/Y', strtotime($list['fin_funciones'])); ?></td>

                                            <!--<td align="center"><?php if ($list['fec_ingreso']!='0000-00-00') echo date('d/m/Y', strtotime($list['fec_ingreso'])); ?></td>-->

                                                
                                            <td align="center"><?php echo  $list['fec_ingreso']; ?></td>


                                                <td align="center"><?php echo $list['nom_status']; ?></td>

                                                <td align="center">                   
                                                    <img title="Editar Datos del Usuario" data-toggle="modal" 
                                                    data-target="#acceso_modal_mod" 
                                                    app_crear_mod="<?= site_url('Snappy/Modal_Update_Usuario') ?>/<?php echo $list["id_usuario"]; ?>" 
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
/*$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example thead tr:eq(1) .filterhead ').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" class="column_search" />' );
    } );
 
    // DataTable
    var table = $('#example').DataTable({
      orderCellsTop: true,
      pageLength: 25,
      dom: 'Bfrtip',
      buttons: [
           {
               extend: 'colvis'
           }
      ]    
    });
 
// Apply the search
    $( '#example thead '  ).on( 'keyup', ".column_search",function () {
   
        table
            .column( $(this).parent().index() )
            .search( this.value )
            .draw();
    } );

} );*/
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