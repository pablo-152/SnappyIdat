<table class="table table-hover table-bordered table-striped" id="tardanza_rrhh" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="6%">Empresa</th>
            <th class="text-center" width="6%">Sede</th>
            <th class="text-center" width="12%">Tipo Contrato</th>
            <th class="text-center" width="8%">Código</th>
            <th class="text-center" width="18%">Tipo</th>
            <th class="text-center" width="18%">Sub-Tipo</th>
            <th class="text-center" width="10%">Tipo</th>
            <th class="text-center" width="10%">Monto</th>
            <th class="text-center" width="8%">Estado</th>
            <th class="text-center" width="4%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list as $item) {  ?>                                           
            <tr class="even pointer text-center">      
                <td><?php echo $item['cod_empresa']; ?></td>   
                <td><?php echo $item['cod_sede']; ?></td>   
                <td class="text-left"><?php echo $item['nom_tipo_contrato']; ?></td>
                <td><?php echo $item['codigo']; ?></td>   
                <td class="text-left"><?php echo $item['tipo']; ?></td>   
                <td class="text-left"><?php echo $item['subtipo']; ?></td>      
                <td><?php echo $item['tipo_tardanza_texto']; ?></td>   
                <td class="text-right"><?php echo $item['monto']; ?></td>  
                <td><span class="badge" style="background-color:<?php echo $item['color']; ?>;"><?php echo $item['nom_status']; ?></span></td>                                                 
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('General/Modal_Update_Tardanza_RRHH') ?>/<?= $item['id']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#tardanza_rrhh thead tr').clone(true).appendTo( '#tardanza_rrhh thead' );
        $('#tardanza_rrhh thead tr:eq(1) th').each( function (i) {
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

        var table=$('#tardanza_rrhh').DataTable( {
            order: [[0,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 9 ]
                }
            ]
        } );
    } );
</script>