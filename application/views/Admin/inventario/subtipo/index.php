<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Subtipos (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo Usuario" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#modal_form_vertical" modal_form_vertical="<?= site_url('Snappy/Modal_Subtipo_Inventario') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                        </a>
                        <a href="<?= site_url('Snappy/Excel_Subtipo_Inventario') ?>" target="_blank">
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
                    <thead>
                        <tr >
                            <th width="10%"><div align="center">Tipo</div></th>
                            <th width="20%"><div align="center">Subtipo</div></th>
                            <th width="20%"><div align="center">Intervalo de Revisión (meses)</div></th>
                            <th width="10%"><div align="center">Estado</div></th>
                            <td width="3%"></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list_subtipo as $list) { ?>
                            <tr>
                                <td ><?php echo $list['nom_tipo_inventario']; ?></td>
                                <td ><?php echo $list['nom_subtipo_inventario']; ?></td>
                                <td align="center"><?php echo $list['intervalo_rev']; ?></td>
                                <td align="center"><?php echo $list['nom_status']; ?></td>

                                <td align="center" nowrap>
                                <img title="Editar Datos" data-toggle="modal"  data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Snappy/Modal_Update_Subtipo_Inventario') ?>/<?php echo $list["id_subtipo_inventario"]; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;"/>
                                    <img title="Eliminar" onclick="Delete_Subtipoi('<?php echo $list['id_subtipo_inventario']; ?>')" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"/>
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
        $("#inventario").addClass('active');
        $("#hinventario").attr('aria-expanded', 'true');
        $("#sconfig_inventario").addClass('active');
        $("#hconfig_inventario").attr('aria-expanded', 'true');
        $("#subtipoi").addClass('active');
        document.getElementById("rconfig_inventario").style.display = "block";
        document.getElementById("rinventario").style.display = "block";
    });
</script>

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
        pageLength: 25
    } );

} );

function Delete_Subtipoi(id){
    var id = id;
    //alert(id);
    var url="<?php echo site_url(); ?>Snappy/Delete_Subtipo_Inventario";
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
                data: {'id_subtipo_inventario':id},
                success:function () {
                    Swal(
                        'Eliminado!',
                        'El registro ha sido eliminado satisfactoriamente.',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>Snappy/SubTipo_Inventario";
                    });
                }
            });
        }
    })
}
</script>

<?php $this->load->view('Admin/footer'); ?>