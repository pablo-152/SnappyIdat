<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="7%">Estado</th>
            <th class="text-center" width="9%">Grado</th>
            <th class="text-center" width="8%">Pendientes</th>
            <th class="text-center" width="7%" title="Pendientes Matriculados">Pen. Mat.</th>
            <th class="text-center" width="7%" title="Pendientes Retirados">Pen. Ret.</th>
            <th class="text-center" width="8%" title="Total Pendientes">Total Pen.</th>
            <th class="text-center" width="8%">Cancelados</th>
            <th class="text-center" width="7%" title="Cancelados Matriculados">Can. Mat.</th>
            <th class="text-center" width="7%" title="Cancelados Retirados">Can. Ret.</th>
            <th class="text-center" width="8%" title="Total Cancelados">Total Canc.</th>
            <th class="text-center" width="8%" title="Total Devoluciones">Total Dev.</th>
            <th class="text-center" width="8%" title="Total Alumnos">Total Alu.</th>
            <th class="text-center" width="8%">Total</th>
        </tr>
    </thead>
    <?php if($tipo==1){ ?>
        <tbody>      
            <?php foreach($list_informe as $list){
                if($list['CourseStatus']=="Activo"){ ?>                                
                <tr class="even pointer text-center">  
                    <td><?php echo $list['CourseStatus']; ?></td>   
                    <td class="text-left"><?php echo $list['CourseName']; ?></td>   
                    <td><a title="Detalle" role="button" href="<?php echo site_url(); ?>LittleLeaders/Detalle_Informe/<?php echo $list['CourseId']; ?>"><?php echo $list['TotalPending']; ?></td>
                    <td><?php echo $list['TotalPendingMatriculated']; ?></td>
                    <td><?php echo $list['TotalPendingOthers']; ?></td>
                    <td class="text-right"><?php echo "s./ ".number_format($list['TotalAmountPending'],2); ?></td>
                    <td><?php echo $list['TotalPaid']; ?></td>
                    <td><?php echo $list['TotalPaidMatriculated']; ?></td>
                    <td><?php echo $list['TotalPaidOthers']; ?></td>
                    <td class="text-right"><?php echo "s./ ".number_format($list['TotalAmountPaid'],2); ?></td>
                    <td class="text-right"><?php echo "s./ ".number_format($list['TotalRefund'],2); ?></td>
                    <td><?php echo $list['TotalStudents']; ?></td>
                    <td class="text-right"><?php echo "s./ ".number_format($list['TotalAmount'],2); ?></td>
                </tr>
            <?php }} ?>
        </tbody>
    <?php }else{ ?>
        <tbody>      
            <?php foreach($list_informe as $list){ ?>                                
                <tr class="even pointer text-center">  
                    <td><?php echo $list['CourseStatus']; ?></td>   
                    <td class="text-left"><?php echo $list['CourseName']; ?></td>   
                    <td><a title="Detalle" role="button" href="<?php echo site_url(); ?>LittleLeaders/Detalle_Informe/<?php echo $list['CourseId']; ?>"><?php echo $list['TotalPending']; ?></td>
                    <td><?php echo $list['TotalPendingMatriculated']; ?></td>
                    <td><?php echo $list['TotalPendingOthers']; ?></td>
                    <td class="text-right"><?php echo "s./ ".number_format($list['TotalAmountPending'],2); ?></td>
                    <td><?php echo $list['TotalPaid']; ?></td>
                    <td><?php echo $list['TotalPaidMatriculated']; ?></td>
                    <td><?php echo $list['TotalPaidOthers']; ?></td>
                    <td class="text-right"><?php echo "s./ ".number_format($list['TotalAmountPaid'],2); ?></td>
                    <td class="text-right"><?php echo "s./ ".number_format($list['TotalRefund'],2); ?></td>
                    <td><?php echo $list['TotalStudents']; ?></td>
                    <td class="text-right"><?php echo "s./ ".number_format($list['TotalAmount'],2); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    <?php } ?>
</table>

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
            order: [[0,"asc"],[1,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 12 ]
                }
            ]
        } );
    });
</script>