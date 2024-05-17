
<input type="hidden" id="parametro" name="parametro" value="<?php echo $parametro ?>">
<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr >
            <th width="1%"><div align="center" ><input type="checkbox" style="width: 20px" id="total" name="total"  value="1"></div></div></th>
            <th width="3%"><div align="center" title="Código de barra" style="cursor:help">Código</div></th>
            <!--<th width="4%"><div align="center" title="Número" style="cursor:help">Ref.</div></th>-->
            <th width="15%"><div align="center">Tipo</div></th>
            <th width="15%"><div align="center">Sub-Tipo</div></th>
            <th width="12%"><div align="center">Empresa</div></th>
            <th width="9%"><div align="center">Sede</div></th>
            <th width="9%"><div align="center">Local</div></th>
            <th width="8%"><div align="center" title="Validación" style="cursor:help">Vali.</div></th>
            <th width="13%"><div align="center" title="Usuario que realizó Validación" style="cursor:help">Usuario&nbsp;Vali.</div></th>
            <th width="11%"><div align="center" title="Fecha de Validación" style="cursor:help">Fecha&nbsp;Vali.</div></th>
            <th width="11%"><div align="center">Último&nbsp;check</div></th>
            <!--<th width="10%"><div align="center">Stock</div></th>-->
            <th width="11%"><div align="center">Estado</div></th>
            <td width="6%"></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_inventario as $list) { ?>
            <tr>
                <td ><input required type="checkbox" id="id_inventario[]" name="id_inventario[]" value="<?php echo $list['id_inventario']; ?>"></td>
                
                <td ><?php echo $list['codigo_barra']; ?></td>
                <!--<td ><?php echo $list['numero']; ?></td>-->
                <td ><?php echo $list['nom_tipo_inventario']; ?></td>
                <td ><?php echo $list['nom_subtipo_inventario']; ?></td>
                <td ><?php echo $list['cod_empresa']; ?></td>
                <td ><?php echo $list['cod_sede']; ?></td>
                <td ><?php echo $list['nom_local']; ?></td>
                <td ><?php echo $list['validacion_msg']; ?></td>
                <td ><?php echo $list['usuario_codigo']; ?></td>
                <td ><?php if($list['validacion']!=0){echo $list['fecha_validacion'];}  ?></td>
                <td ><?php if($list['fecha_validacion']!="00/00/0000 00:00:00"){echo $list['lcheck']; } ?></td>
                <!--<td ><?php echo ""; ?></td>-->
                <td ><?php echo $list['nom_status']; ?></td>

                <td align="center" nowrap>
                    <img title="Editar Datos" data-toggle="modal"  data-target="#modal_full" modal_full="<?= site_url('Snappy/Modal_Update_Inventario') ?>/<?php echo $list["id_inventario"]; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;"/>
                    <?php 
                    if($list['archivo_validacion']!=""){?> 
                    <a style="cursor:pointer;" class="" data-toggle="modal" data-target="#documento" data-imagen="<?php echo $list['archivo_validacion']; ?>" title="Documento"> <img title="Imágen 1" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;"/></a>
                    <?php }
                    ?>
                    
                    <!--<img title="Eliminar" onclick="Delete_Codigo('<?php echo $list['id_inventario']; ?>')" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"/>-->
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<input type="text" id="cadena" name="cadena" class="form-control"  value="" />
<input type="hidden" id="cantidad" name="cantidad" class="form-control"  value="0" />

<script>
    $(document).ready(function() {
        $("#inventario").addClass('active');
        $("#hinventario").attr('aria-expanded','true');
        $("#inventariog").addClass('active');
        document.getElementById("rinventario").style.display = "block";

        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            
            if(title==""){
              $(this).html('');
            }else{
              $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
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

        let $dt = $('#example');

        var table=$('#example').DataTable( {
            ordering:false,
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
        } );


        
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
            //total += this.checked ? price : price * -1;
            
            if(this.checked==false){
                q = q.replace(cadena2, "");
                cantidad = parseFloat(cantidad)-1;
            }else{
                q += this.checked ? cadena2 : cadena2+",";
                cantidad = parseFloat(cantidad)+1;
            }
            $cadena.val(q);
            $cantidad.val(cantidad);
            //cadena += this.checked ? cadena2 : info[1]+", ";
            
        });
    });
</script>