<style>
    .cursor_tabla{
        cursor: help;
    } 
</style>

<table id="example" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th width="13%" class="text-center cursor_tabla" title="Apellido Paterno">Ap. Paterno</th>
            <th width="13%" class="text-center cursor_tabla" title="Apellido Materno">Ap. Materno</th>
            <th width="16%" class="text-center">Nombre(s)</th>
            <th width="6%" class="text-center">Código</th>
            <th width="15%" class="text-center">Grado <?php echo date('Y')-1; ?></th>
            <th width="15%" class="text-center">Grado <?php echo date('Y'); ?></th>
            <th width="8%" class="text-center">Matricula</th>
            <th width="8%" class="text-center">Alumno</th>
            <th width="6%" class="text-center">Año</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_alumno as $list) { ?>
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>
                <td class="text-left"><?php echo $list['Nombre']; ?></td>
                <td><?php echo $list['Codigo']; ?></td>
                <td class="text-left"><?php echo $list['Grado']; ?></td>
                <td class="text-left">
                    <?php if($list['CourseGradeId']==0){echo "2 Primaria";}
                        elseif($list['CourseGradeId']==1){echo "3 Primaria";}
                        elseif($list['CourseGradeId']==2){echo "4 Primaria";}
                        elseif($list['CourseGradeId']==3){echo "5 Primaria";}
                        elseif($list['CourseGradeId']==4){echo "6 Primaria";}
                        elseif($list['CourseGradeId']==5){echo "1 Secundaria";}
                        elseif($list['CourseGradeId']==6){echo "2 Secundaria";}
                        elseif($list['CourseGradeId']==7){echo "3 Secundaria";}
                        elseif($list['CourseGradeId']==8){echo "4 Secundaria";}
                        elseif($list['CourseGradeId']==9){echo "5 Secundaria";}
                        elseif($list['CourseGradeId']==11){echo "3 Años";}
                        elseif($list['CourseGradeId']==12){echo "4 Años";}
                        elseif($list['CourseGradeId']==13){echo "5 Años";}
                        elseif($list['CourseGradeId']==14){echo "1 Primaria";}
                    ?>
                </td>
                <td class="text-left"><?php echo $list['Matricula']; ?></td>
                <td class="text-left"><?php echo $list['Alumno']; ?></td> 
                <td><?php echo $list['Anio']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            if(title==""){
                $(this).html('');
            }else{
                $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
            }
        
            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#example').DataTable({
            order: [[0,"asc"],[1,"asc"],[2,"asc"],[3,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 8 ]
                }
            ]
        });
    });
</script>