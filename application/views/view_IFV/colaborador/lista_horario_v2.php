<table id="example_horariov2" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center">De</th>
            <th class="text-center">A</th>
            <th class="text-center">Dias<br>Laborables</th>
            <th class="text-center">Ingreso<br>Mañana</th>
            <th class="text-center">Salida<br>Mañana</th>
            <th class="text-center">Ingreso<br>Almuerzo</th>
            <th class="text-center">Salida<br>Almuerzo</th>
            <th class="text-center">Ingreso<br>Tarde</th>
            <th class="text-center">Salida<br>Tarde</th>
            <th class="text-center">Ingreso<br>Cena</th>
            <th class="text-center">Salida<br>Cena</th> 
            <th class="text-center">Ingreso<br>Noche</th>
            <th class="text-center">Salida<br>Noche</th> 
            <th class="text-center">Estado</th> 
            <th class="text-center no-content" width="5%"></th>
        </tr>
    </thead>
    
    <tbody>
    <?php foreach($list_horario as $list) {  ?>
            <tr class="even pointer text-center">
                <td><?php echo date('d/m/Y',strtotime($list['de'])); ?></td> 
                <td><?php echo date('d/m/Y',strtotime($list['a'])); ?></td> 
                <td><?php echo $list['dias'] ?></td>  
                <td><?php echo $list['ingreso_m']; ?></td>  
                <td><?php echo $list['salida_m']; ?></td> 
                <td><?php echo $list['ingreso_alm']; ?></td>
                <td><?php echo $list['salida_alm']; ?></td> 
                <td><?php echo $list['ingreso_t']; ?></td>
                <td><?php echo $list['salida_t']; ?></td>
                <td><?php echo $list['ingreso_c']; ?></td>
                <td><?php echo $list['salida_c']; ?></td>
                <td><?php echo $list['ingreso_n']; ?></td>
                <td><?php echo $list['salida_n']; ?></td>
                <td><?php echo $list['desc_estado_registro']; ?></td>
                <td nowrap>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_form_vertical" 
                        modal_form_vertical="<?= site_url('AppIFV/Modal_Update_Horario_Colaborador') ?>/<?php echo $list['id_horario']; ?>" title="Editar">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>
                    <a title="Eliminar" onclick="Delete_Horario_Colabordor_V2('<?php echo $list['id_horario']; ?>')"> 
                        <img src="<?= base_url() ?>template/img/eliminar.png">
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    /*$(document).ready(function() {
        var table = $('#example_horariov2').DataTable( {
            order: [[0,"desc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 8 ]
                }
            ]
        });

        // Clona la segunda fila del thead
        $('#example_horariov2 thead tr:eq(1)').clone(true).appendTo('#example_horariov2 thead');

        // Itera a través de los th de la segunda fila
        $('#example_horariov2 thead tr:eq(1) th').each(function (i) {
            var title = $(this).text();

            if (title == "") {
                $(this).html('');
            } else {
                $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
            }

            $('input', this).on('keyup change', function () {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });
    });*/



    $(document).ready(function() {
        $('#example_horariov2 thead tr').clone(true).appendTo( '#example_horariov2 thead' );
        $('#example_horariov2 thead tr:eq(1) th').each( function (i) {
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

        var table = $('#example_horariov2').DataTable( {
            order: [[0,"desc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 8 ]
                }
            ]
        } );
    });
</script>