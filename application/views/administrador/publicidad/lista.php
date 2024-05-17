<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="5%" title="Empresa">Emp</th>
            <th class="text-center" width="5%" title="Código">Cod</th> 
            <th class="text-center" width="8%">Tipo</th>
            <th class="text-center" width="10%">Sub-Tipo</th>
            <th class="text-center" width="12%">Descripción</th>
            <th class="text-center" width="6%">Agenda</th>
            <th class="text-center" width="10%">Campaña</th>
            <th class="text-center" width="8%">Tipo</th>
            <th class="text-center" width="6%">Del día</th>
            <th class="text-center" width="6%">Hasta</th>
            <th class="text-center" width="6%">Días</th>
            <th class="text-center" width="5%">Alcance</th>
            <th class="text-center" width="5%">Interacciones</th>
            <th class="text-center" width="5%">Monto</th>
            <th class="text-center" width="3%"></th>
        </tr>
    </thead> 

    <tbody >
        <?php foreach($list_publicidad as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['cod_empresa']; ?></td>
                <td><?php echo $list['cod_proyecto']; ?></td>
                <td class="text-left"><?php echo $list['nom_tipo']; ?></td>
                <td class="text-left"><?php echo $list['nom_subtipo']; ?></td>
                <td class="text-left"><?php echo $list['descripcion']; ?></td>
                <td><?php echo $list['agenda']; ?></td>
                <td class="text-left"><?php echo $list['campania']; ?></td>                
                <td class="text-left"><?php echo $list['tipo']; ?></td>     
                <td><?php echo $list['del_dia']; ?></td>     
                <td><?php echo $list['hasta']; ?></td>                
                <td><?php echo $list['dias']; ?></td>
                <td><?php echo $list['alcance']; ?></td>
                <td><?php echo $list['interacciones']; ?></td>     
                <td class="text-right"><?php echo $list['monto']; ?></td>
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('Administrador/Modal_Update_Publicidad') ?>/<?php echo $list['id_proyecto']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
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
            order: [[1,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 14 ]
                }
            ]
        } );
    });
</script>