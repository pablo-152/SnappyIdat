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
                                            <b>Cargo</b>
                                        </div>

                                        <div class="col" align="right">
                                            <a title="Nuevo Curso" style="cursor:pointer; cursor: hand;" href="<?= site_url('Administrador/Agregar_Cargo') ?>">
                                                <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                                            </a>

                                            <a href="<?= site_url('Administrador/Excel_Base_Datos') ?>">
                                                <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div id="lista_base_datos" class="table-responsive">
                                    <table id="example" class="table table-bordered table-striped">
                                        <thead class="text-center">
                                            <tr style="background-color: #E5E5E5;">
                                                <th width="6%">Empresa</th>
                                                <th width="6%">Sede</th>
                                                <th width="37%">Base de Datos</th>
                                                <th width="37%">Números</th>
                                                <th width="8%">Estado</th>
                                                <th width="6%">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php foreach($list_base_datos as $list){ ?>    
                                                <?php
                                                    $bd_numeros="";
                                                    foreach($list_base_datos_num as $num){
                                                        if($num['id_base_datos']==$list['id_base_datos']){
                                                            $bd_numeros=$bd_numeros.$num['numero'].",";
                                                        }
                                                    }
                                                ?>                                       
                                                <tr class="even pointer">
                                                    <td><?php echo $list['cod_empresa']; ?></td>
                                                    <td><?php echo $list['cod_sede']; ?></td>
                                                    <td align="left"><?php echo $list['nom_base_datos']; ?></td>
                                                    <td align="left"><?php echo substr($bd_numeros,0,-1); ?></td>
                                                    <td><?php echo $list['nom_status']; ?></td>
                                                    <td>
                                                        <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Modal_Update_Base_Datos') ?>/<?php echo $list['id_base_datos']; ?>">
                                                            <img title="Editar" src="<?= base_url() ?>template/img/editar.png"  style="cursor:pointer; cursor: hand;" width="22" height="22" />
                                                        </a>  

                                                        <?php //if($sesion['id_usuario']==1 || $sesion['id_usuario']==5){ ?>
                                                            <!--<a href="#" class="" title="Eliminar" onclick="Delete_Base_Datos('<?php echo $list['id_base_datos']; ?>')" role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;" width="22" height="22"/></a>-->
                                                        <?php //} ?>
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
            pageLength: 21
        } );

    } );
</script>

<?php $this->load->view('Admin/footer'); ?>

<script>
    function Delete_Base_Datos(id){
        var id = id;
        var url="<?php echo site_url(); ?>Administrador/Delete_Base_Datos";
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
                    data: {'id_base_datos':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>Administrador/Base_Datos";
                        });
                    }
                });
            }
        })
    }
</script>