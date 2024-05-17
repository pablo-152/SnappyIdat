<table class="table table-hover table-bordered table-striped" id="example_horario" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th>Orden</th> 
            <th class="text-center" width="10%">Semana</th> 
            <th class="text-center" width="10%">Fecha</th> 
            <th class="text-center" width="10%">Fecha</th> 
            <th class="text-center" width="12%">Horario</th>  
            <th class="text-center" width="12%">Día</th> 
            <th class="text-center" width="11%">De</th>
            <th class="text-center" width="11%">A</th>
            <th class="text-center" width="11%">Estado</th> 
            <th class="text-center" width="10%">Hora</th>
            <th class="text-center" width="3%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_horario as $list){ ?>                                            
            <tr class="even pointer text-center">
                <td><?php echo $list['orden']; ?></td>
                <td><?php echo $list['semana']; ?></td>         
                <td class="text-right"><?php echo $list['fecha_corta']; ?></td>  
                <td><?php echo $list['fecha']; ?></td>         
                <td><?php echo $list['nom_turno']; ?></td>  
                <td class="text-left"><?php echo $list['dia']; ?></td>         
                <td><?php echo $list['desde']; ?></td>   
                <td><?php echo $list['hasta']; ?></td>         
                <td class="text-left"><?php echo $list['nom_estado']; ?></td>  
                <td><?php echo $list['horas']; ?></td>         
                <td>
                    <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || 
                    $_SESSION['usuario'][0]['id_usuario']==85 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                        <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_Horario_Grupo_C') ?>/<?php echo $list['id_horario']; ?>">
                            <img src="<?= base_url() ?>template/img/editar.png">
                        </a>
                    <?php } ?>
                </td>                             
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example_horario thead tr').clone(true).appendTo( '#example_horario thead' );
        $('#example_horario thead tr:eq(1) th').each( function (i) { 
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

        var table=$('#example_horario').DataTable( {
            order: [[0,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 10 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        } );
    } );
</script>