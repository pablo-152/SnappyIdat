
<form  method="post" id="formularioxls" enctype="multipart/form-data" action="<?= site_url('Snappy/Excel_Iventario_xSede')?>" class="formulario">
    <input type="hidden" name="id_sede" id="id_sede" value="<?php echo $id_sede ?>"> 
</form>
<table class="table table-hover table-bordered table-striped" id="example2" width="100%">
    <thead>
        <tr >
            
            <th width="4%"><div align="center" title="Referencia" style="cursor:help">Ref.</div></th>
            <th width="11%"><div align="center" title="Código" style="cursor:help">Cod.</div></th>
            <th width="15%"><div align="center">Tipo</div></th>
            <th width="15%"><div align="center">Sub-Tipo</div></th>
            <th width="12%"><div align="center">Empresa</div></th>
            <th width="9%"><div align="center">Sede</div></th>
            <th width="9%"><div align="center">Local</div></th>
            <th width="8%"><div align="center" title="Validación" style="cursor:help">Vali.</div></th>
            <th width="13%"><div align="center" title="Usuario que realizó Validación" style="cursor:help">Usuario Vali.</div></th>
            <th width="11%"><div align="center" title="Fecha de Validación" style="cursor:help">Fec.&nbsp;Vali.</div></th>
            <th width="11%"><div align="center" title="Último Check" style="cursor:help">Últ.&nbsp;check</div></th>
            <!--<th width="10%"><div align="center">Stock</div></th>-->
            <th width="11%"><div align="center">Estado</div></th>
            <!--<td width="6%"></td>-->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_inventario_sede as $list) { ?>
            <tr>
                
                <td align="center"><?php echo $list['numero']; ?></td>
                <td align="center"><?php echo $list['letra']."/".$list['codigo_barra']; ?></td>
                <td ><?php echo $list['nom_tipo_inventario']; ?></td>
                <td ><?php echo $list['nom_subtipo_inventario']; ?></td>
                <td align="center"><?php echo $list['cod_empresa']; ?></td>
                <td><?php echo $list['cod_sede']; ?></td>
                <td ><?php echo $list['nom_local']; ?></td>
                <td align="center"><?php echo $list['validacion_msg']; ?></td>
                <td><?php echo $list['usuario_codigo']; ?></td>
                <td align="center"><?php if($list['validacion']!=0){echo $list['fecha_validacion'];}  ?></td>
                <td align="center"><?php if($list['fecha_validacion']!="00/00/0000 00:00:00"){echo $list['lcheck']; } ?></td>
                <!--<td ><?php echo ""; ?></td>-->
                <td align="center"><?php echo $list['nom_status']; ?></td>

                <!--<td align="center" nowrap>
                    <img title="Editar Datos" data-toggle="modal"  data-target="#modal_form_vertical" modal_form_vertical="<?= site_url('Snappy/Modal_Update_Inventario') ?>/<?php echo $list["id_inventario"]; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" width="20" height="20" />
                    <img title="Eliminar" onclick="Delete_Codigo('<?php echo $list['id_inventario']; ?>')" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;" width="20" height="20" />
                </td>-->
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#example2 thead tr').clone(true).appendTo( '#example2 thead' );
        $('#example2 thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            
            $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
    
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        var table = $('#example2').DataTable( {
            ordering: false,
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ {
            'bSortable' : false,
            'aTargets' : [ 0 ]
            } ]
           
        } );

    } );
</script>