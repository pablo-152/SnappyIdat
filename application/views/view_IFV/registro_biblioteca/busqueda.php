<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="4%" title="Código">Cod</th>
            <th class="text-center" width="15%">Especialidad</th>
            <th class="text-center" width="4%" title="Módulo">Mod</th>
            <th class="text-center" width="4%" title="Ciclo">Cic</th>
            <th class="text-center" width="16%">Unidad Didáctica</th>
            <th class="text-center" width="12%">Título</th>
            <th class="text-center" width="12%">Sub-Título</th>
            <th class="text-center" width="10%">Editorial</th>
            <th class="text-center" width="10%">Tipo</th>
            <th class="text-center" width="5%">Estado</th>
            <th class="text-center" width="4%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($get_busqueda as $list){
            $busqueda = in_array($list['id_unidad_didactica'],array_column($list_unidad_didactica,'id_unidad_didactica'));
            if($busqueda!=false){
                $posicion = array_search($list['id_unidad_didactica'],array_column($list_unidad_didactica,'id_unidad_didactica'));
                $nom_unidad_didactica = $list_unidad_didactica[$posicion]['nom_unidad_didactica'];
            }else{
                $nom_unidad_didactica = "";
            }?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['cod_biblioteca']; ?></td>   
                <td class="text-left"><?php echo $list['nom_especialidad']; ?></td>   
                <td><?php echo $list['nom_modulo']; ?></td>                                                     
                <td><?php echo $list['nom_ciclo']; ?></td>   
                <td class="text-left"><?php echo $nom_unidad_didactica; ?></td>   
                <td class="text-left"><?php echo $list['titulo']; ?></td>   
                <td class="text-left"><?php echo $list['subtitulo']; ?></td>   
                <td class="text-left"><?php echo $list['editorial']; ?></td>   
                <td class="text-left"><?php echo $list['tipo']; ?></td> 
                <td><?php echo $list['nom_estado']; ?></td>   
                <td>
                    <a href="<?= site_url('AppIFV/Descripcion_Libro') ?>/<?php echo $list['id_biblioteca']; ?>">
                        <img title="Descripción" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;">
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
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 21,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 10 ]
                }
            ]
        } );
    } );
</script>