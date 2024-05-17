<style>
    #example tbody tr td:nth-child(1),#example tbody tr td:nth-child(3),
    #example tbody tr td:nth-child(6),#example tbody tr td:nth-child(9),
    #example tbody tr td:nth-child(12),#example tbody tr td:nth-child(13){ 
        text-align: center;
    }

    #example tbody tr td:nth-child(4),#example tbody tr td:nth-child(5),
    #example tbody tr td:nth-child(7){ 
        text-align: right;
    }
</style>

<input type="hidden" id="cadena" name="cadena" value="">
<input type="hidden" id="cantidad" name="cantidad" value="0">

<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;"> 
            <th class="text-center" width="3%"><input type="checkbox" id="total" name="total" value="1"></th>
            <th class="text-center">Id</th>
            <th class="text-center">Fecha</th>
            <th class="text-center" width="8%">Vendedor</th>
            <th class="text-center" width="6%">Caja</th>
            <th class="text-center" width="8%">Saldo Automático</th>
            <th class="text-center" width="8%" title="Monto Entregado">Monto Ent.</th>  
            <th class="text-center" width="5%" title="Productos">Prod.</th>
            <th class="text-center" width="8%" title="Diferencia">Dif.</th> 
            <th class="text-center" width="8%">Recibe</th>
            <th class="text-center" width="6%">Fecha</th>
            <th class="text-center" width="8%">Usuario</th>
            <th class="text-center" width="20%">Cofre</th>
            <th class="text-center" width="6%">Estado</th>
            <th class="text-center" width="6%"></th> 
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_cierre_caja as $list){ ?>                                              
            <tr class="even pointer" <?php if($list['cerrada']==0 && $list['estado']==2){ echo "style='background-color:#E2F0D9;'"; } ?>>
                <td><input type="checkbox"></td>
                <td><?php echo $list['id_cierre_caja']; ?></td>
                <td><?php echo $list['fecha']; ?></td>
                <td><?php echo $list['cod_vendedor']; ?></td> 
                <td><?php echo $list['caja']; ?></td>
                <td <?php if($list['saldo_automatico']<0){ echo "style='color:red;'"; } ?>><?php echo "s/. ".$list['saldo_automatico']; ?></td> 
                <td <?php if($list['monto_entregado']<0){ echo "style='color:red;'"; } ?>><?php echo "s/. ".$list['monto_entregado']; ?></td>
                <td><?php echo $list['productos']; ?></td>
                <td <?php if($list['diferencia']!=0){ echo "style='background-color:#C00000;color:#FFF'"; } ?>><?php echo "s/. ".$list['diferencia']; ?></td> 
                <td><?php echo $list['cod_entrega']; ?></td>
                <td><?php echo $list['fecha_registro']; ?></td>
                <td><?php echo $list['cod_registro']; ?></td>
                <td><?php echo $list['cofre']; ?></td>       
                <td><span class="badge" style="background:<?php echo $list['color_estado']; ?>;font-size:13px;"><?php echo $list['nom_estado']; ?></span></td>  
                <td>
                    <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_nivel']==6 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_usuario']==10){ ?>
                        <a title="Más Información" href="<?= site_url('AppIFV/Detalle_Cierre_Caja') ?>/<?php echo $list['id_cierre_caja']; ?>">
                            <img src="<?= base_url() ?>template/img/ver.png"/>
                        </a>
                    <?php } ?>

                    <a title="Documento" href="<?= site_url('AppIFV/Pdf_Cierre_Caja') ?>/<?php echo $list['id_cierre_caja']; ?>" target="_blank">
                        <img src="<?= base_url() ?>template/img/icono_impresora.png">
                    </a>

                    <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                        <a title="Eliminar" onclick="Delete_Cierre_Caja('<?php echo $list['id_cierre_caja']; ?>')">
                            <img src="<?= base_url() ?>template/img/eliminar.png">
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

        var table = $('#example').DataTable( { 
            order: [[2,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 0,14 ]
                },
                {
                    'targets' : [ 1,2 ],
                    'visible' : false
                } 
            ]
        } );

        // Seleccionar todo en la tabla
        let $dt = $('#example');
        let $total = $('#total');
        let $cadena = $('#cadena');
        let $cantidad = $('#cantidad');

        // Cuando hacen click en el checkbox del thead
        $dt.on('change', 'thead input', function (evt) {
            let checked = this.checked;
            let total = 0;
            let data = [];
            let cadena='';
            
            table.data().each(function (info) {
            var txt = info[0];
                if (checked) {
                    total += 1;
                    txt = txt.substr(0, txt.length - 1) + ' checked>';
                    cadena += info[1]+",";
                } else {
                    txt = txt.replace(' checked', '');
                }
                info[0] = txt;
                data.push(info);
            });
            
            table.clear().rows.add(data).draw();
            $cantidad.val(total); 
            $cadena.val(cadena);
        });

        // Cuando hacen click en los checkbox del tbody
        $dt.on('change', 'tbody input', function() {
            let q= $('#cadena').val();
            let cantidad= $('#cantidad').val();
            let info = table.row($(this).closest('tr')).data();
            let total = parseFloat($total.val());
            let cadena = $cadena.val();
            let price = parseFloat(info[1]);
            let cadena2 = info[1]+",";
            
            if(this.checked==false){
                q = q.replace(cadena2, "");
                cantidad = parseFloat(cantidad)-1;
            }else{
                q += this.checked ? cadena2 : cadena2+",";
                cantidad = parseFloat(cantidad)+1;
            }
            $cadena.val(q);
            $cantidad.val(cantidad);
        });
    });
</script>