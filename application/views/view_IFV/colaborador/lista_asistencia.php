<table id="example_asistencia" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
        <th>Orden</th>
        <th class="text-center" width="10%">Fecha</th>
        <th class="text-center" width="10%">Hora</th>
        <th class="text-center" width="10%">Obs</th>
        <th class="text-center" width="15%">Tipo</th>
        <th class="text-center" width="15%">Estado</th>
        <th class="text-center" width="15%">Autorización</th>
        <th class="text-center" width="15%">Registro</th>
        <th class="text-center" width="5%"></th> 
        </tr>
    </thead>
    
    <tbody>
    <?php foreach($list_asistencia as $list) {  ?>
            <tr class="even pointer text-center">
            <td><?php echo $list['orden']; ?></td> 
            <td><?php echo $list['fecha_ingreso']; ?></td> 
            <td><?php echo $list['hora_ingreso']; ?></td>  
            <td><?php echo $list['obs']; ?></td>  
            <td><?php echo $list['tipo_desc']; ?></td> 
            <td><?php echo $list['nom_estado_reporte']; ?></td>
            <td><?php echo $list['usuario_codigo']; ?></td> 
            <td><?php echo $list['estado_ing']; ?></td>
            <td>
                <?php if($list['obs']=="Si"){ ?>
                    <a title="Historial"  data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('AppIFV/Modal_Historial_Registro_Ingreso') ?>/<?php echo $list['codigo']; ?>">
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
        $('#example_asistencia thead tr').clone(true).appendTo( '#example_asistencia thead' );
        $('#example_asistencia thead tr:eq(1) th').each( function (i) {
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

        var table = $('#example_asistencia').DataTable( {
            order: [[0,"desc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 8 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        } );
    });
</script>