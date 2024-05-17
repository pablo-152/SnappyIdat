<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Recibidos (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a href="#"><!--<?= site_url('AppIFV/Excel_Historico_Extranet') ?>-->
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
                <table class="table table-hover table-striped table-bordered" id="example" width="100%">
                    <thead>
                        <tr style="background-color: #E5E5E5;">
                            <th class="text-center" width="33%">DNI</th>
                            <th class="text-center" width="34%">Código</th>
                            <th class="text-center" width="33%">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($list_historico_extranet as $list){ ?>                                           
                            <!--<tr class="even pointer text-center">
                                <td class="text-left"><?php echo $list['orden_tabla']; ?></td>
                                <td><?php echo $list['dUltimo_Acceso']; ?></td>
                                <td><?php echo $list['hUltimo_Acceso']; ?></td>
                                <td><?php echo $list['dLogout']; ?></td>
                                <td><?php echo $list['hLogout']; ?></td>
                                <td><?php echo $list['tipo_acceso']; ?></td>
                                <td class="text-left"><?php echo $list['Usuario']; ?></td>
                                <td><?php echo $codigo; ?></td>
                                <td class="text-left"><?php echo $list['FatherSurname']; ?></td>
                                <td class="text-left"><?php echo $list['MotherSurname']; ?></td>
                                <td class="text-left"><?php echo $list['FirstName']; ?></td>
                                <td class="text-left"><?php echo $especialidad; ?></td>
                                <td><?php echo $grupo; ?></td>
                            </tr>-->
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#calendarizaciones").addClass('active');
        $("#hcalendarizaciones").attr('aria-expanded', 'true');
        $("#docucalen").addClass('active');
        $("#hdocucalen").attr('aria-expanded', 'true');
        $("#recibidos").addClass('active');
		document.getElementById("rcalendarizaciones").style.display = "block";
        document.getElementById("rdocucalen").style.display = "block";
    });
</script>

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

        var table=$('#example').DataTable( {
            order: [0,"desc"],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 21
        } );
    } );
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>