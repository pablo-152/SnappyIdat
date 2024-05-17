<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="6%">Curso</th>
            <th class="text-center" width="6%">Año</th>
            <th class="text-center" width="18%">Nombre</th>
            <th class="text-center" width="8%">Referencia</th>
            <th class="text-center" width="18%">Artículo</th>
            <th class="text-center" width="12%">Público</th>
            <th class="text-center" width="9%" title="Inicio Pagamento">Inicio Pag.</th>
            <th class="text-center" width="9%" title="Fin Pagamento">Fin Pag.</th>
            <th class="text-center" width="6%">Estado</th>
            <th class="text-center" width="8%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_producto as $list){ 
            $array = explode(",",$list['id_articulo']);
            $i = 0;
            $nom_articulo = "";
            while($i<count($array)){
                $busqueda = in_array($array[$i], array_column($list_articulo, 'id_articulo')); 
                if($busqueda!=false){
                    $posicion = array_search($array[$i], array_column($list_articulo, 'id_articulo'));
                    $nom_articulo = $nom_articulo.$list_articulo[$posicion]['nombre'].", ";
                }
                $i++;
            }
            $nom_articulo = substr($nom_articulo,0,-2);
            ?>                                           
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['nom_grado']; ?></td>   
                <td><?php echo $list['anio']; ?></td>   
                <td class="text-left"><?php echo $list['nombre']; ?></td>   
                <td><?php echo $list['referencia']; ?></td>   
                <td class="text-left"><?php echo $nom_articulo; ?></td>   
                <td><?php echo $list['nom_publico']; ?></td>   
                <td><?php echo $list['inicio']; ?></td>   
                <td><?php echo $list['fin']; ?></td>              
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;font-size:13px;"><?php echo $list['nom_status']; ?></span></td>                                       
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('CursosCortos/Modal_Update_Producto') ?>/<?php echo $list['id_producto']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>

                    <a title="Más Información" href="<?= site_url('CursosCortos/Detalle_Producto') ?>/<?php echo $list['id_producto']; ?>">
                        <img src="<?= base_url() ?>template/img/ver.png">
                    </a>

                    <a title="Eliminar" onclick="Delete_Producto('<?php echo $list['id_producto']; ?>')" role="button"> 
                        <img src="<?= base_url() ?>template/img/eliminar.png">
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

        var table=$('#example').DataTable( {
            order: [[8,"asc"],[0,"asc"],[1,"desc"],[2,"asc"]],
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