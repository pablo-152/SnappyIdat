<?php 
//$sesion =  $_SESSION['usuario'][0];
//defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php /*$this->load->view('Admin/header');*/ ?>
<?php /*$this->load->view('Admin/nav');*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>.:: SNAPPY ::.</title>
    <script src="<?= base_url() ?>template/docs/js/jquery-3.2.1.min.js"></script>
    <link href="<?= base_url() ?>template/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?= base_url('template/assets/assets2/libs/sweetalert2/dist/sweetalert2.min.css') ?>">
    <script src="<?=base_url('template/assets/assets2/libs/sweetalert2/dist/sweetalert2.min.js')?>"></script>
    <body class="sidebar-xs">
</div>

<!--<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Cargos</b></span></h4>
                </div>

                <div class="heading-elements" style="position: absolute;top: 50%;margin: -25px 0 0 -25px;">
                    <div class="heading-btn-group">
                        <a title="Nuevo Usuario" style="cursor:pointer;margin-right:5px;" href="<?= site_url('Snappy/Agregar_Cargo') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                        </a>
                        <a href="<?= site_url('Snappy/Excel_Base_Datos') ?>" target="_blank">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
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
                    <thead class="text-center">
                        <tr style="background-color: #E5E5E5;">
                            <th width="6%">Referencia</th>
                            <th width="6%">De</th>
                            <th width="6%">Empresa para</th>
                            <th width="37%">Sede para</th>
                            <th width="37%">Usuario para</th>
                            <th width="8%">Estado</th>
                            <th width="6%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php foreach($list_cargo as $list){ ?>    
                            <tr class="even pointer">
                                
                                <td><?php echo $list['cod_cargo']; ?></td>
                                <td><?php echo $list['usuario_de']; ?></td>
                                <td><?php echo $list['empresa_1']; ?></td>
                                <td><?php echo $list['sede_1']; ?></td>
                                <td><?php echo $list['usuario_1']; ?></td>
                                <td><?php echo $list['nom_estado']; ?></td>
                                <td>-->
                                    <!--<a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Modal_Update_Base_Datos') ?>/<?php echo $list['id_cargo']; ?>">
                                        <img title="Editar" src="<?= base_url() ?>template/img/editar.png"  style="cursor:pointer; cursor: hand;" width="22" height="22" />
                                    </a> -->
                                    <!--<a title="Más Información" href="<?= site_url('Snappy/Vista_Upd_Cargo') ?>/<?php echo $list['id_cargo']; ?>">
                                        <img title="Más Información" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
                                    </a>-->

                                    <?php //if($sesion['id_usuario']==1 || $sesion['id_usuario']==5){ ?>
                                        <!--<a href="#" class="" title="Eliminar" onclick="Delete_Base_Datos('<?php echo $list['id_cargo']; ?>')" role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;" width="22" height="22"/></a>-->
                                    <?php //} ?>
                                <!--</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>-->

<script>
    /*$(document).ready(function() {
        $("#cargo").addClass('active');
        $("#hcargo").attr('aria-expanded', 'true');
        $("#slista").addClass('active');*/
        /*$("#hlista").attr('aria-expanded', 'true');
        $("#nuevocargo").addClass('active');
        document.getElementById("rlista").style.display = "block";*/
        /*document.getElementById("rcargo").style.display = "block";
    });*/
</script>
<style>
    .swal2-show{
        height: 280px !important;
    }

    .swal2-actions{
        display: none !important;
    }
</style>
<script>
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    /*$('#example thead tr').clone(true).appendTo( '#example thead' );
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
        pageLength: 25
    } );*/
    var mensaje='<?php echo $mensaje; ?>';
    var titulo='<?php echo $titulo; ?>';
    var tipo='<?php echo $tipo; ?>';

    Swal(
            ''+titulo,
            ''+mensaje,
            ''+tipo
        ).then(function() { });
    /*if(mensaje == 'exitoap') {
        
    }else if(mensaje == 'yaaprobado'){
        Swal(
            'El Cargo ya está aprobado!',
            '',
            'warning'
        ).then(function() { });
        return false;
    }
    else if(mensaje == 'exitodes'){
        Swal(
            'Cargo Desaprobado!',
            '',
            'success'
        ).then(function() { });
        return false;
    }else if(mensaje == 'yadesaprobado'){
        Swal(
            'El Cargo ya está desaprobado!',
            '',
            'warning'
        ).then(function() { });
        return false;
    }*/

} );

/*function Delete_Local(id){
    var id = id;
    //alert(id);
    var url="<?php echo site_url(); ?>Snappy/Delete_Local";
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
                data: {'id_inventario_local':id},
                success:function () {
                    Swal(
                        'Eliminado!',
                        'El registro ha sido eliminado satisfactoriamente.',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>Snappy/Local";
                    });
                }
            });
        }
    })
}*/
</script>

<?php /*$this->load->view('Admin/footer');*/ ?>
