<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $sesion['id_nivel'];
$id_usuario = $sesion['id_usuario'];
?>
<input type="hidden" id="usuario_actual" value="<?php echo $id_usuario; ?>">

<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead class="text-center">
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="8%">Referencia </th>
            <th class="text-center" width="8%">Fecha </th>
            <th class="text-center" width="8%">De</th>
            <!--<th class="text-center" width="8%">Empresa&nbsp;para</th>-->
            <th class="text-center" width="5%">Sede&nbsp;para</th>
            <th class="text-center" width="5%">Usuario&nbsp;para</th>
            <th class="text-center" width="8%">Rubro</th>
            <th class="text-center" width="36%">Descripción</th>
            <th class="text-center" width="8%">Doc</th>
            <th class="text-center" width="10%">Estado</th>
            <td class="text-center" width="4%"></td> 
        </tr>
    </thead>
    <tbody >
        <?php foreach($list_cargo as $list){ ?>    
            <tr class="even pointer text-center">
                <td><?php echo $list['cod_cargo']; ?></td>
                <td><?php echo $list['fecha']; ?></td>
                <td class="text-left"><?php echo $list['usuario_de']; ?></td>
                <td class="text-left"><?php echo $list['sede_1']; ?></td>
                <td class="text-left"><?php echo $list['usuario_1']; ?></td>
                <td class="text-left"><?php echo $list['nom_rubro']; ?></td>
                <td class="text-left"><?php echo $list['desc_cargo']; ?></td>
                <td><?php if($list['doc']==null){ 
                    echo 'No';
                    }else{
                    echo 'Si';
                    };?></td>
                <td>
                    <span class="badge" style="background:<?php echo $list['color_estado']; ?>;"><?php echo $list['nom_estado']; ?></span> 
                </td>
                <td>
                    <a title="Más Información" href="<?= site_url('Snappy/Vista_Upd_Cargo') ?>/<?php echo $list['id_cargo']; ?>">
                        <img title="Más Información" src="<?= base_url() ?>template/img/ver.png">
                    </a> 

                    <?php if($id_usuario==1 || $id_nivel==6 || $id_usuario==7){ ?>
                        <a title="Eliminar" onclick="Delete_Cargo('<?php echo $list['id_cargo']; ?>')">
                            <img title="Eliminar" src="<?= base_url() ?>template/img/eliminar.png"> 
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

        var usuario = $("#usuario_actual").val();

        if(usuario==60){
            var table = $('#example').DataTable( {
                order: [0,"desc"],
                orderCellsTop: true,
                fixedHeader: true,
                pageLength: 25,
                "aoColumnDefs" : [ {
                    'targets' : [ 9 ],
                    'visible' : false
                } ]
            } );
        }else{
            var table = $('#example').DataTable( {
                order: [7,"desc"],
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
        }
    } );
</script>