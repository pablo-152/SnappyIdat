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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Detalle Alumnos Pensiones Canceladas / Por Cancelar (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a type="button" href="<?= site_url('LeadershipSchool/Detalle_Informe/') ?><?php echo $CourseId;?>" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>

                        <a href="<?= site_url('LeadershipSchool/Excel_Detalle_Alumno') ?>/<?php echo $CourseId; ?>/<?php echo $PaymentDueDate; ?>">
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
                        <tr style="background-color: #E5E5E5;">
                            <th class="text-center" width="5%">Estado</th>
                            <th class="text-center" width="5%">Recibo</th>
                            <th class="text-center" width="5%" title="Fecha VP">F. VP</th> 
                            <th class="text-center" width="5%" title="Fecha Pago">F. Pa.</th>
                            <th class="text-center" width="6%">Grado</th>
                            <th class="text-center" width="8%">Descripción</th>
                            <th class="text-center" width="4%" title="Código">Cod.</th>
                            <th class="text-center" width="6%">DNI</th>
                            <th class="text-center" width="6%" title="Apellido Paterno">Ap. Pat.</th>
                            <th class="text-center" width="6%" title="Apellido Materno">Ap. Mat.</th>
                            <th class="text-center" width="8%">Nombre(s)</th>
                            <th class="text-center" width="5%" title="Matrícula">Mat.</th>
                            <th class="text-center" width="5%">Monto</th>
                            <th class="text-center" width="5%" title="Descuento">Desc.</th>
                            <th class="text-center" width="5%" title="Penalidad">Pena.</th>
                            <th class="text-center" width="5%" title="Subtotal">SubT.</th>
                            <th class="text-center" width="6%">Curso</th>
                            <th class="text-center" width="5%">Estado</th>
                        </tr>
                    </thead>
                    <tbody>      
                        <?php foreach($list_alumno as $list){ ?>                                
                            <tr class="even pointer text-center">  
                                <td><?php echo $list['PaymentStatus']; ?></td>   
                                <td><?php echo $list['ReceiptNumber']; ?></td>   
                                <td><?php echo $list['PaymentDueDate']; ?></td>   
                                <td><?php echo $list['PaymentDate']; ?></td>   
                                <td class="text-left"><?php echo $list['CourseGrade']; ?></td>   
                                <td class="text-left"><?php echo $list['Description']; ?></td>   
                                <td><?php echo $list['InternalStudentId']; ?></td>   
                                <td><?php echo $list['IdentityCardNumber']; ?></td>   
                                <td class="text-left"><?php echo $list['FatherSurname']; ?></td>   
                                <td class="text-left"><?php echo $list['MotherSurname']; ?></td>   
                                <td class="text-left"><?php echo $list['FirstName']; ?></td>   
                                <td><?php echo $list['MatriculationStatus']; ?></td>   
                                <td class="text-right"><?php echo "s./ ".number_format($list['Cost'],2); ?></td>   
                                <td class="text-right"><?php echo "s./ ".number_format($list['TotalDiscount'],2); ?></td>   
                                <td class="text-right"><?php echo "s./ ".number_format($list['PenaltyAmountToBePaid'],2); ?></td>   
                                <td class="text-right"><?php echo "s./ ".number_format($list['SubTotal'],2); ?></td>   
                                <td class="text-left"><?php echo $list['CourseName']; ?></td>   
                                <td><?php echo $list['CourseStatus']; ?></td>                                                      
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
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50
        } );
    });
</script>
<?php $this->load->view('view_LS/footer'); ?>