<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Estados Bancarios (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a href="<?= site_url('Administrador/Excel_Estado_Bancario') ?>">
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
                <table class="table table-hover table-bordered table-striped" id="example">
                    <thead>
                        <tr>
                            <th class="text-center" width="50%">Empresa</th >
                            <th class="text-center" width="20%">Cuenta Bancaria</th >
                            <th class="text-center" width="8%">Inicio</th >
                            <th class="text-center" width="8%">Status</th >
                            <th class="text-center" width="8%">Estado</th >
                            <th class="text-center" width="6%"></th >
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list_estado_bancario as $list) { ?>
                            <tr>
                                <td><?php echo $list['nom_empresa']; ?></td>
                                <td class="text-center"><?php echo $list['cuenta_bancaria']; ?></td>
                                <td class="text-center"><?php echo $list['inicio']; ?> </td>
                                <td class="text-center">
                                    <?php if ($list['movimiento_pdf']!="" && $list['movimiento_excel']!="" && $list['saldo_bbva']!=0) { ?>
                                        <span class="badge" style="background:#92D050;color: white;">Cargado</span>
                                    <?php }else{ ?>
                                        <span class="badge" style="background:#C00000;color: white;">Pendiente</span>
                                    <?php } ?>    
                                </td>
                                <td class="text-center"><?php echo $list['nom_status']; ?></td>
                                <td class="text-center">
                                    <a type="button" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Modal_Update_Estado_Bancario') ?>/<?php echo $list['id_estado_bancario']; ?>">  
                                        <img title="Editar" src="<?= base_url() ?>template/img/editar.png"  style="cursor:pointer; cursor: hand;" width="22" height="22" />
                                    </a>
                                    <a title="Más Información" href="<?= site_url('Administrador/Detalle_Estado_Bancario') ?>/<?php echo $list['id_estado_bancario']; ?>">
                                        <img title="Más Información" src="<?= base_url() ?>template/img/ver.png"  style="cursor:pointer; cursor: hand;" width="22" height="22" />
                                    </a>  
                                    <?php if($sesion['id_usuario']==1 || $sesion['id_usuario']==5){ ?>
                                        <a href="#" class="" title="Eliminar" onclick="Delete_Estado_Bancario('<?php echo $list['id_estado_bancario']; ?>')" role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;" width="22" height="22"/></a>
                                    <?php } ?>
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
        $("#contabilidad").addClass('active');
        $("#hcontabilidad").attr('aria-expanded','true');
        $("#ebancario").addClass('active');
		document.getElementById("rcontabilidad").style.display = "block";
    });
</script>

<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();

            if(title!=''){
                $(this).html('<input type="text" placeholder="Buscar '+title+'"/>');
            }else{
                $(this).html('');
            }
    
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
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 5 ]
                }
            ]
        } );
    } );
</script>

<?php $this->load->view('Admin/footer'); ?>

<script>
    function Delete_Estado_Bancario(id){
        var id = id;
        var url="<?php echo site_url(); ?>Administrador/Delete_Estado_Bancario";
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
                    data: {'id_estado_bancario':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>Administrador/Estado_Bancario";
                        });
                    }
                });
            }
        })
    }
</script>

		
