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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Salida de Capital</b></span></h4>
                </div>

                <div class="heading-elements" style="position: absolute;top: 50%;margin: -25px 0 0 -25px;">
                    <div class="heading-btn-group">
                        <!--<?= site_url('Snappy/Excel_Tipo') ?>-->
                        <a href="#" target="_blank">
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
                <!--<table class="table table-hover table-bordered table-striped" id="example" width="100%">
                    <thead>
                        <tr>
                            <th width="">Nombre de Tipos</th>
                            <th width="">Status</th>
                            <th width="1%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list_tipo as $list) { ?>
                            <tr>
                                <td ><?php echo $list['nom_tipo']; ?></td>
                                <td ><?php echo $list['nom_status']; ?></td>

                                <td  nowrap>
                                    <img title="Editar Datos del Tipo" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Snappy/Modal_Update_Tipo') ?>/<?php echo $list['id_tipo']; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>-->
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#contabilidad").addClass('active');
        $("#hcontabilidad").attr('aria-expanded', 'true');
        $("#sarpays").addClass('active');
        $("#harpays").attr('aria-expanded', 'true');
        $("#salida_capital").addClass('active');
		document.getElementById("rcontabilidad").style.display = "block";
        document.getElementById("rarpays").style.display = "block";
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
        pageLength: 21
    } );

} );
</script>

<?php $this->load->view('Admin/footer'); ?>