<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('ceba2/header'); ?>
<?php $this->load->view('ceba2/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Cliente (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a href="<?= site_url('Ceba2/Excel_Cliente') ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel"/>
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
                        <tr style="background-color: #E5E5E5;">
                            <th class="text-center" width="6%">Tipo</th>
                            <th class="text-center" width="27%">Apellido Paterno</th>
                            <th class="text-center" width="27%">Apellido Materno</th>
                            <th class="text-center" width="27%">Nombre(s)</th>
                            <th class="text-center" width="6%">Sede</th>
                            <th class="text-center" width="7%">Documento</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($list_cliente as $list) {  ?>                                           
                            <tr class="even pointer text-center">
                                <td><?php echo "Alumno"; ?></td>
                                <td class="text-left"><?php echo $list['alum_apater']; ?></td>
                                <td class="text-left"><?php echo $list['alum_amater']; ?></td>
                                <td class="text-left"><?php echo $list['alum_nom']; ?></td>
                                <td><?php echo "EP1"; ?></td>   
                                <td><?php echo $list['dni_alumno']; ?></td>                                                       
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
        $("#clientes").addClass('active');
        $("#hclientes").attr('aria-expanded', 'true');
        $("#listas_clientes").addClass('active');
		document.getElementById("rclientes").style.display = "block";

        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            
            if(title==""){
              $(this).html('');
            }else{
              $(this).html('<input type="text" placeholder="Buscar '+title+'" />');
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
            order: [[0,"asc"],[1,"asc"],[2,"asc"],[3,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50
        } );
    });
</script>

<?php $this->load->view('ceba2/validaciones'); ?>
<?php $this->load->view('ceba2/footer'); ?>