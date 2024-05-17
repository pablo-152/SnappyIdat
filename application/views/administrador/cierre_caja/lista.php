<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $sesion['id_nivel'];
$id_usuario = $sesion['id_usuario'];
?>
<style>
    #example tbody tr td:nth-child(1),#example tbody tr td:nth-child(2),
    #example tbody tr td:nth-child(4),#example tbody tr td:nth-child(7),
    #example tbody tr td:nth-child(10),#example tbody tr td:nth-child(13),
    #example tbody tr td:nth-child(14){ 
        text-align: center;
    }

    #example tbody tr td:nth-child(5),#example tbody tr td:nth-child(6),
    #example tbody tr td:nth-child(8){
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
            <th class="text-center" width="6%" title="Punto de Venta">P. Venta</th> 
            <th class="text-center" width="8%">Vendedor</th>
            <th class="text-center" width="6%">Caja</th>
            <th class="text-center" width="8%">Saldo Automático</th>
            <th class="text-center" width="8%" title="Monto Entregado">Monto Ent.</th>  
            <th class="text-center" width="5%" title="Productos">Prod.</th>
            <th class="text-center" width="8%" title="Diferencia">Dif.</th> 
            <th class="text-center" width="8%">Recibe</th>
            <th class="text-center" width="6%">Fecha</th>
            <th class="text-center" width="8%">Usuario</th>
            <th class="text-center" width="15%">Cofre</th>
            <th class="text-center" width="8%">Estado</th>
            <th class="text-center" width="3%"></th> 
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_cierre_caja as $list){ ?>                                             
            <tr class="even pointer" <?php if($list['fecha_registro']==""){ echo "style='background-color:#FE0100;'"; } ?>>
                <td><input type="checkbox"></td>
                <td><?php echo $list['id_cierre_caja']."_".$list['id_empresa']; ?></td>
                <td><?php echo $list['fecha']; ?></td>
                <td><?php echo $list['cod_sede']; ?></td>
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
                <td>
                    <span class="badge" style="background:<?php echo $list['color_estado']; ?>;font-size:13px;">
                        <?php echo $list['nom_estado']; ?>
                    </span>
                </td>                                  
                <td>
                    <?php if($id_usuario==1 || $id_usuario==85 || $id_nivel==6){ ?>
                        <a title="Más Información" href="<?= site_url('Administrador/Detalle_Cierre_Caja') ?>/<?php echo $list['id_cierre_caja']; ?>/<?php echo $list['id_empresa']; ?>">
                            <img src="<?= base_url() ?>template/img/ver.png"/>
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
            order: [[2,"asc"],[3,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 0,15 ]
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