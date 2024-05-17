<style>
    .color_fondo{
        background-color: #DEEBF7 !important;
        border: 1px solid #DEEBF7; 
    }
</style>

<input type="hidden" id="id_almacen" name="id_almacen" value="<?php echo $id_almacen; ?>"> 
<input type="hidden" id="almacen_actual" name="almacen_actual" value="<?php echo $almacen_actual; ?>">

<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="20%">Código</th>
            <th class="text-center" width="20%">Tipo</th>
            <th class="text-center" width="20%">Descripción</th> 
            <th class="text-center" width="20%">Talla/Ref.</th>
            <th class="text-center" width="10%">Stock</th>
            <th class="text-center" width="10%">Transferido</th> 
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_producto as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['codigo']; ?></td>
                <td class="text-left"><?php echo $list['nom_tipo']; ?></td>
                <td class="text-left"><?php echo $list['descripcion']; ?></td>
                <td><?php echo $list['talla']; ?></td>
                <td><?php echo $list['stock']; ?></td> 
                <td>
                    <input type="hidden" id="productos" name="productos[]" value="<?php echo $list['codigo']; ?>">
                    <input type="text" class="form-control solo_numeros color_fondo" 
                    id="transferido_<?php echo $list['codigo']; ?>" name="transferido_<?php echo $list['codigo']; ?>" value="0" 
                    onkeyup="Cambiar_Color('<?php echo $list['codigo']; ?>','<?php echo $list['stock']; ?>');"> 
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
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 10000,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 5 ]
                }
            ]
        } );
    });

    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Cambiar_Color(codigo,stock){ 
        var v_transferido = $("#transferido_"+codigo).val();
        var transferido = document.getElementById('transferido_'+codigo);
        if(v_transferido>Number(stock)){
            $("#transferido_"+codigo).val(1);
        }
        if(v_transferido>0){
            transferido.style.cssText  = 'background-color:#E2F0D9 !important; border:1px solid #E2F0D9;';
        }else{
            transferido.style.cssText  = 'background-color:#DEEBF7 !important; border:1px solid #DEEBF7;';
        }
    }
</script>