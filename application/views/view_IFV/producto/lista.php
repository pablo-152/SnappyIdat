<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="10%">Año</th>    
            <th class="text-center" width="18%">Tipo</th>
            <th class="text-center" width="25%">Producto</th>
            <th class="text-center" width="18%">Especialidad</th>
            <th class="text-center" width="8%">Informe</th>
            <th class="text-center" width="8%">Cancelados</th>
            <th class="text-center" width="8%">Estado</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_producto as $list){ 
            $id_producto = "";
            $nom_tipo = "";
            $nom_especialidad = "";
            $v_informe = "";
            $v_cancelado = "";
            $busqueda = in_array($list['Id'], array_column($snappy, 'Id'));
            if($busqueda != false){
                $posicion = array_search($list['Id'], array_column($snappy, 'Id'));
                $id_producto = $snappy[$posicion]['id_producto'];
                $nom_tipo = $snappy[$posicion]['nom_tipo_producto'];
                $v_informe = $snappy[$posicion]['v_informe'];
                $v_cancelado = $snappy[$posicion]['v_cancelado'];

                $array = explode(",", $snappy[$posicion]['id_especialidad']);
                $i = 0;
                $nom_especialidad = "";
                while($i<count($array)){
                    $busqueda_e = in_array($array[$i], array_column($list_especialidad, 'id_especialidad')); 
                    if($busqueda_e!=false){
                        $posicion_e = array_search($array[$i], array_column($list_especialidad, 'id_especialidad'));
                        $nom_especialidad = $nom_especialidad.$list_especialidad[$posicion_e]['abreviatura'].",";
                    }
                    $i++;
                }
                $nom_especialidad = substr($nom_especialidad,0,-1);
            } ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['anio']; ?></td>   
                <td class="text-left"><?php echo $nom_tipo; ?></td>   
                <td class="text-left"><?php echo $list['nom_producto']; ?></td>
                <td class="text-left"><?php echo $nom_especialidad; ?></td>  
                <td><?php echo $v_informe; ?></td>                                                   
                <td><?php echo $v_cancelado; ?></td>   
                <td><?php echo $list['estado']; ?></td>            
                <td>
                    <?php if($id_producto==""){ ?>
                        <img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" 
                        app_crear_mod="<?= site_url('AppIFV/Modal_Producto') ?>/<?php echo $list['Id']; ?>" 
                        src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;">
                    <?php }else{ ?>
                        <img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" 
                        app_crear_mod="<?= site_url('AppIFV/Modal_Update_Producto') ?>/<?php echo $id_producto; ?>" 
                        src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;">
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
            pageLength: 100,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 7 ]
                }
            ]
        } );
    } );
</script>