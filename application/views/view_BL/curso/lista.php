<table id="example" class="table table-hover table-bordered">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th width="5%">Año</th>
            <th width="11%">Nombre</th>
            <th width="5%">Grado</th>
            <th width="8%" title="Inicio de Curso">Fecha Inicio</th>
            <th width="8%" title="Fin de Curso">Fecha Fin</th>
            <th width="3%" title="Total">Total</th>
            <th width="3%" title="Activos">Activos</th>
            <th width="3%" title="Con Sección">Con Sección</th>
            <th width="3%" title="Sin Sección">Sin Sección</th>
            <th width="3%" title="Retirado">Retirados</th>
            <th width="3%" title="Promovidos">Promovidos</th>
            <th width="3%" title="Reprovados">Reprovados</th>
            <th width="3%" title="Otros">Otros</th>
            <th width="3%" title="Cantidad de Matriculados">Matriculados</th>
            <th width="5%">Estado</th>
            <td width="3%"></td>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_curso as $list) {  ?>                                            
            <tr class="text-center">
                <td><?php echo $list['nom_anio']; ?></td>
                <td class="text-left"><?php echo $list['nom_curso']; ?></td>
                <td class="text-left"><?php echo $list['nom_grado']; ?></td>
                <td><?php echo $list['inicio_curso']; ?></td>
                <td><?php echo $list['fin_curso']; ?></td>
                <td><?php echo ""; ?></td>
                <td><?php echo ""; ?></td>
                <td><?php echo ""; ?></td>
                <td><?php echo ""; ?></td>
                <td><?php echo ""; ?></td>
                <td><?php echo ""; ?></td>
                <td><?php echo ""; ?></td>
                <td><?php echo ""; ?></td>
                <td><?php echo ""; ?></td>
                <td>
                    <span class="badge" style="background:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span>
                </td>
                <td>
                    <a title="Detalle del Curso" href="<?= site_url('BabyLeaders/Detalle_Curso') ?>/<?php echo $list["id_curso"]; ?>">
                        <img title="Más Información" src="<?= base_url() ?>template/img/ver.png" 
                        style="cursor:pointer; cursor: hand;">
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
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

        var table = $('#example').DataTable( {
            order: [[14,"asc"],[0,"desc"],[1,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 15 ]
                }
            ]
        } );
    });
</script>