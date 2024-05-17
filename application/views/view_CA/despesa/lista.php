<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center">Orden</th>
            <th class="text-center">Fec Pago</th>
            <th class="text-center" width="4%" title="Referencia">Ref.</th>
            <th class="text-center" width="4%">Tipo</th>
            <th class="text-center" width="5%">Mes/Año</th>
            <th class="text-center" width="8%">Tipo Pago</th> 
            <th class="text-center" width="7%">Rubro</th>
            <th class="text-center" width="9%">Sub-Rubro</th>
            <th class="text-center" width="9%">Descripción</th>
            <th class="text-center" width="6%">Doc.</th>
            <th class="text-center" width="5%" title="Fecha Documento">Fecha Dc.</th>
            <th class="text-center" width="5%" title="Fecha Pago">Fecha Pg.</th>
            <th class="text-center" width="7%" title="Operación">Valor</th>
            <th class="text-center" width="7%">Saldo</th>
            <th class="text-center" width="3%" title="Documento">Do.</th>
            <th class="text-center" width="3%" title="Pagamento">Pa.</th>
            <th class="text-center" width="3%" title="Sin Contabilizar">S/C</th>
            <th class="text-center" width="3%" title="Enviado Original">En.</th>
            <th class="text-center" width="3%" title="Sin Documento Físico">SD.</th>
            <th class="text-center" width="5%">Estado</th>
            <th class="text-center" width="4%"></th>
        </tr>
    </thead>
    <tbody>
        <?php $saldo=0; foreach($list_despesa as $list){ if($list['estado']==2 && $list['tipo_despesa']!=4){ $saldo=$saldo+$list['valor']; } ?>                                            
            <tr class="even pointer text-center" <?php if($list['tipo_despesa']==4){ echo "style='background-color:#FBE5D6;'"; } ?>>
                <td><?php echo $list['orden']; ?></td>   
                <td><?php echo $list['fec_pago']; ?></td>   
                <td><?php echo $list['referencia']; ?></td>   
                <td><?php echo $list['nom_tipo']; ?></td>   
                <td><?php echo $list['mes_anio']; ?></td>   
                <td class="text-left"><?php echo $list['nom_tipo_pago']; ?></td>   
                <td class="text-left"><?php echo $list['nom_rubro']; ?></td>   
                <td class="text-left"><?php echo $list['nom_subrubro']; ?></td>  
                <td class="text-left"><?php echo $list['descripcion']; ?></td>   
                <td class="text-left"><?php echo $list['documento']; ?></td>   
                <td><?php echo $list['fecha_documento']; ?></td>   
                <td><?php echo $list['fecha_pago']; ?></td>    
                <td class="text-right" style="color:<?php echo $list['color_valor']; ?>;"><?php echo $list['valor_salida']; ?></td>
                <td class="text-right"><?php if($list['tipo_despesa']!=4){ echo "€ ".number_format($saldo,2); } ?></td>    
                <td><?php echo $list['v_archivo']; ?></td>   
                <td><?php echo $list['v_pagamento']; ?></td>   
                <td><?php echo $list['sin_contabilizar']; ?></td>   
                <td><?php echo $list['enviado_original']; ?></td> 
                <td><?php echo $list['v_sin_documento_fisico']; ?></td>  
                <td><span class="badge" style="background:<?php echo $list['color_estado']; ?>"><?php echo $list['nom_estado']; ?></span></td>                                                  
                <td>
                    <a href="<?= site_url('Ca/Modal_Update_Despesa') ?>/<?php echo $list['id_despesa']; ?>">
                        <img title="Editar Datos" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;">
                    </a>
                    <?php if($_SESSION['usuario'][0]['id_nivel']!=13){ ?>
                        <a href="#" class="" title="Eliminar" onclick="Delete_Despesa('<?php echo $list['id_despesa']; ?>')"  role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"></a>
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
            order: [[0,"asc"],[1,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 20 ]
                },
                {
                    'targets' : [ 0,1 ],
                    'visible' : false
                } 
            ]
        } );

        //Última Página
        //Recordar https://datatables.net/reference/api/page()
        table.page('last').draw('page');
    } );
</script>