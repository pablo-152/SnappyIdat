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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Centro Custo (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo Usuario" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#modal_form_vertical" modal_form_vertical="<?= site_url('Administrador/Modal_Centro_Custo') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                        </a>
                        <a href="<?= site_url('Administrador/Excel_Centro_Custo') ?>">
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
                        <tr>
                            <th class="text-center" width="80%">Nombre</th>
                            <th class="text-center" width="16%">Status</th>
                            <th class="text-center" width="4%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list_tipo as $list) { ?>
                            <tr>
                                <td><?php echo $list['nom_ccr']; ?></td>
                                <td class="text-center"><?php echo $list['nom_status']; ?></td>

                                <td class="text-center">
                                    <img title="Editar Datos del Tipo" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Modal_Update_Centro_Custo') ?>/<?php echo $list['id_ccr']; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
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
        $("#contabilidade").addClass('active');
        $("#hcontabilidade").attr('aria-expanded', 'true');
        $("#configcontabilidade").addClass('active');
        $("#hconfigcontabilidade").attr('aria-expanded', 'true');
        $("#centro_custoe").addClass('active');
		document.getElementById("rcontabilidade").style.display = "block";
        document.getElementById("rconfigcontabilidade").style.display = "block";
    });
</script>

<script>
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example thead tr').clone(true).appendTo( '#example thead' );
    $('#example thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        
        if(title==""){
            $(this).html( '' );
        }else{
            $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
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
        pageLength: 21
    } );

} );
</script>

<?php $this->load->view('Admin/footer'); ?>