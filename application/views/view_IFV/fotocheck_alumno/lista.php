<style>
    .grande{
        width: 18px; 
        height: 18px; 
    } 

    #example tbody tr td:nth-child(1),#example tbody tr td:nth-child(5),#example tbody tr td:nth-child(6),#example tbody tr td:nth-child(7),
    #example tbody tr td:nth-child(8),#example tbody tr td:nth-child(10),#example tbody tr td:nth-child(12),#example tbody tr td:nth-child(13),
    #example tbody tr td:nth-child(14){ 
        text-align: center;
    }
</style>

<input type="hidden" id="cadena" name="cadena" value="">
<input type="hidden" id="cantidad" name="cantidad" value="0">

<table id="example" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="3%"><input type="checkbox" class="grande" id="total" name="total" value="1"></th>
            <th>Id</th>
            <th width="8%" class="text-center" title="Apellido Paterno">Ap. Paterno</th>
            <th width="8%" class="text-center" title="Apellido Materno">Ap. Materno</th>
            <th width="11%" class="text-center">Nombre(s)</th>
            <th width="4%" class="text-center" title="Código">Cod</th>
            <th width="4%" class="text-center">Esp.</th> 
            <th width="4%" class="text-center">Grupo</th>
            <th width="6%" class="text-center" title="Fecha Pago">Fecha P.</th>
            <th width="5%" class="text-center">Monto</th>
            <th width="6%" class="text-center">Foto</th> 
            <th width="7%" class="text-center">Usuario</th>
            <th width="6%" class="text-center">Envio</th>
            <th width="7%" class="text-center">Usuario</th>
            <th width="7%" class="text-center">Cargo</th>
            <th width="6%" class="text-center">Estado</th>
            <th width="8%"></th>
            <th>Orden</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_fotocheck as $list){ ?>
            <tr class="even pointer text-center">
                <td><input type="checkbox" class="grande" id="array_fotocheck[]" name="array_fotocheck[]" value="<?php echo $list['id_fotocheck']; ?>"></td>
                <td><?php echo $list['id_fotocheck']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>
                <td class="text-left"><?php echo $list['Nombre']; ?></td>
                <td><?php echo $list['Codigo']; ?></td>
                <td><?php echo $list['abreviatura']; ?></td>
                <td><?php echo $list['Grupo']; ?></td>
                <td><?php echo $list['Pago_Fotocheck']; ?></td>
                <td class="text-right"><?php echo "s/. ".$list['Monto_Pago_Fotocheck']; ?></td>
                <td><?php echo $list['fecha_recepcion']; ?></td>
                <td class="text-left"><?php echo $list['usuario_foto']; ?></td>
                <td><?php echo $list['fecha_envio']; ?></td>
                <td class="text-left"><?php echo $list['usuario_codigo']; ?></td> 
                <td><?php echo $list['cargo_envio']; ?></td>
                <td><span class="badge" style="background-color:<?php echo $list['color_esta_fotocheck']; ?>;"><?php echo $list['esta_fotocheck']; ?></span></td>             
                <td>
                    <?php if($list['id_fotocheck']!=''){  
                        if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==5 || $_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==9 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_usuario']==33){ ?> 
                            <a type="button" style="margin-right:5px;" data-toggle="modal" data-target="#modal_form_vertical" modal_form_vertical="<?= site_url('AppIFV/Modal_Detalle') ?>/<?php echo $list['id_fotocheck']; ?>">
                                <img title="Más Información" src="<?= base_url() ?>template/img/GL-BOTON-VER-COLOR-5.png">
                            </a>
                        <?php } 

                        if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==5 || $_SESSION['usuario'][0]['id_usuario']==30 || 
                        $_SESSION['usuario'][0]['id_usuario']==35 || $_SESSION['usuario'][0]['id_usuario']==69 || $_SESSION['usuario'][0]['id_usuario']==71 || 
                        $_SESSION['usuario'][0]['id_usuario']==82 ||$_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_usuario']==33){ ?>
                        <a type="button" href="<?= site_url('AppIFV/Carne_Estudiante') ?>/<?php echo $list['id_fotocheck']; ?>" target="_blank" style="margin-right:5px;" >
                            <img title="Fotocheck" src="<?= base_url() ?>template/img/GL-ICONO-FOTOCHECK.png">
                        </a>
                    <?php } }

                    if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==5 || $_SESSION['usuario'][0]['id_usuario']==70 || 
                    $_SESSION['usuario'][0]['id_usuario']==82 || $_SESSION['usuario'][0]['id_nivel']==3 || $_SESSION['usuario'][0]['id_nivel']==12 || $_SESSION['usuario'][0]['id_usuario']==7  || $_SESSION['usuario'][0]['id_usuario']==33){ ?>
                        <a type="button" style="margin-right:5px;" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Foto') ?>/<?php echo $list['id_fotocheck']; ?>">
                            <img title="Cargar Foto" src="<?= base_url() ?>template/img/GL-BOTON-CAMARA-GRIS.png">
                        </a>
                    <?php }

                    if($list['estado_fotocheck']==1 && $list['impresion']==0){ ?>
                        <a title="Fotocheck Impreso" onclick="Impresion_Fotocheck('<?php echo $list['id_fotocheck']; ?>')" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/btn_impreso.png">
                        </a>
                    <?php } ?>

                    <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==5){ 
                        if($list['id_fotocheck']!=''){ ?>
                            <a type="button" style="margin-right:5px;" data-toggle="modal" data-target="#LargeLabelModal" LargeLabelModal="<?= site_url('AppIFV/Modal_Anular') ?>/<?php echo $list['id_fotocheck']; ?>"> 
                                <img title="Anular" src="<?= base_url() ?>template/img/eliminar.png">                    
                            </a>
                    <?php } }?>
                </td>
                <td><?php echo $list['Fecha_Pago_Fotocheck']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            if(title==""){
                $(this).html('');
            }else{
                $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
            }
        
            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        }); 

        var table = $('#example').DataTable({
            order: [17,"asc"],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 0,16 ]
                },
                {
                    'targets' : [ 1,17 ],
                    'visible' : false
                } 
            ]
        });

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