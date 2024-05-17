<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_LS/header'); ?>
<?php $this->load->view('view_LS/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Detalle Pensiones Canceladas / Por Cancelar (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a type="button" href="<?= site_url('LeadershipSchool/Informe') ?>" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>

                        <a href="<?= site_url('LeadershipSchool/Excel_Detalle_Informe') ?>/<?php echo $CourseId; ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div id="lista_detalle" class="col-lg-12">
                <table class="table table-hover table-bordered table-striped" id="example" width="100%">
                    <thead>
                        <tr style="background-color: #E5E5E5;">
                            <th class="text-center">Fecha Orden</th>
                            <th class="text-center" width="75%">Descripción</th>
                            <th class="text-center" width="10%">Pendientes</th>
                            <th class="text-center" width="10%">Total Pendientes</th>
                            <th class="text-center" width="5%"></th>
                        </tr>
                    </thead>
                    <tbody>      
                        <?php $i=1; foreach($list_detalle as $list){ ?>                                
                            <tr class="even pointer text-center">  
                                <td class="text-left"><?php echo $list['PaymentDueDate']; ?></td>    
                                <td class="text-left"><?php echo $list['ItemDescription']; ?></td>   
                                <td><?php echo $list['TotalPending']; ?></td>   
                                <td class="text-right"><?php echo "s./ ".number_format($list['TotalAmountPending'],2); ?></td>                                                             
                                <td>
                                    <a title="Detalle" role="button" href="<?php echo site_url(); ?>LeadershipSchool/Detalle_Alumno/<?php echo $list['CourseId']; ?>/<?php echo substr($list['PaymentDueDate'],0,4).substr($list['PaymentDueDate'],5,2).substr($list['PaymentDueDate'],8,2); ?>">
                                        <img title="Detalle" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer;">
                                    </a>
                                </td>
                            </tr>
                        <?php $i++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
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

        var table=$('#example').DataTable( {
            order: [0,"asc"],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 4 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        } );
    });
</script>

<?php $this->load->view('view_LS/footer'); ?>