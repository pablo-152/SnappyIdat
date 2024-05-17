<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="50%">Empresa</th >
            <th class="text-center" width="20%">Cuenta Bancaria</th >
            <th class="text-center" width="8%">Inicio</th >
            <th class="text-center" width="8%">Status</th >
            <th class="text-center" width="8%">Estado</th >
            <th class="text-center" width="6%"></th >
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_saldo_banco as $list) {  ?>                                           
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['nom_empresa']; ?></td>
                <td><?php echo $list['cuenta_bancaria']; ?></td>
                <td><?php echo $list['inicio']; ?></td>
                <td>
                    <?php if ($list['estado']!="Pendiente") { ?>
                        <span class="badge" style="background:#92D050;color: white;">Actualizado</span>
                    <?php }else{ ?>
                        <span class="badge" style="background:#C00000;color: white;">Pendiente</span>
                    <?php } ?>    
                </td>
                <td><?php echo $list['nom_status']; ?></td>
                <td>
                    <?php if($_SESSION['usuario'][0]['id_nivel']!=13){ ?>
                        <a type="button" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Ca/Modal_Update_Saldo_Banco') ?>/<?php echo $list['id_estado_bancario']; ?>">  
                            <img title="Editar" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer;">
                        </a>
                    <?php } ?>
                    <a title="Más Información" href="<?= site_url('Ca/Detalle_Saldo_Banco') ?>/<?php echo $list['id_estado_bancario']; ?>">
                        <img title="Más Información" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer;">
                    </a>  
                    <?php if($_SESSION['usuario'][0]['id_nivel']!=13){ ?>
                        <a href="#" class="" title="Eliminar" onclick="Delete_Saldo_Banco('<?php echo $list['id_estado_bancario']; ?>')" role="button"> 
                            <img title="Eliminar" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer;">
                        </a>
                    <?php } ?>
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

        var table=$('#example').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 21,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 5 ]
                }
            ]
        } );
    } );
</script>