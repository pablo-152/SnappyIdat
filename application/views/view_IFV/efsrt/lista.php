<table class="table table-hover table-bordered table-striped" id="example" width="100%"> 
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="4%">Grupo</th> 
            <th class="text-center" width="4%" title="Especialidad">Esp.</th> 
            <th class="text-center" width="4%" title="Módulo">Mod.</th> 
            <th class="text-center" width="6%">Turno</th> 
            <th class="text-center" width="6%">Sección</th>
            <th class="text-center" width="6%">Inicio</th> 
            <th class="text-center" width="6%">Termino</th>
            <th class="text-center" width="4%" title="Matriculados">Mat.</th>
            <th class="text-center" width="6%" title="Inducción">IND</th>
            <th class="text-center">Col. 2</th>
            <th class="text-center">Col. 3</th>
            <th class="text-center">Col. 4</th>
            <th class="text-center">Col. 5</th>
            <th class="text-center">Col. 6</th>
            <th class="text-center">Col. 7</th>
            <th class="text-center">Col. 8</th>
            <th class="text-center">Col. 9</th>
            <th class="text-center" width="3%"></th> 
        </tr>
    </thead>

    <tbody>
        <?php foreach ($list_efsrt as $list){ ?>  
            <tr class="even pointer text-center">  
                <td><?php echo $list['grupo']; ?></td>
                <td class="text-center"><?php echo $list['abreviatura'] ?></td>
                <td><?php echo $list['modulo']; ?></td>
                <td><?php echo $list['nom_turno']; ?></td>
                <td><?php echo $list['seccion']; ?></td>
                <td><?php echo $list['inicio_efsrt']; ?></td>
                <td><?php echo $list['termino_efsrt']; ?></td>
                <td><?php echo $list['matriculados']; ?></td>
                <td>
                    <span class="badge" style="background:<?php echo $list['color_induccion']; ?>;color:white;font-size:14px;"><?php echo $list['induccion']; ?></span>
                </td>
                <td><?php echo ""; ?></td>
                <td><?php echo ""; ?></td>
                <td><?php echo ""; ?></td>
                <td><?php echo ""; ?></td>
                <td><?php echo ""; ?></td>
                <td><?php echo ""; ?></td>
                <td><?php echo ""; ?></td>
                <td><?php echo ""; ?></td>
                <td>
                    <?php if($list['inicio_efsrt']!="Fal. Ciclo" && $list['termino_efsrt']!="Fal. Ciclo"){ ?>
                        <a title="Más Información" href="<?= site_url('AppIFV/Detalle_Efsrt') ?>/<?php echo str_replace('/','_',$list['grupo']); ?>/<?php echo $list['id_especialidad']; ?>/<?php echo $list['id_modulo']; ?>/<?php echo $list['id_turno']; ?>">
                            <img src="<?= base_url() ?>template/img/ver.png">
                        </a> 
                    <?php } ?> 
                </td>
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
                    'bSortable' : false,
                    'aTargets' : [ 17 ]
                }
            ]
        });
    });
</script>