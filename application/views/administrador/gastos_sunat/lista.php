<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $sesion['id_nivel'];
$id_usuario = $sesion['id_usuario'];
?>
<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr>
            <th>Orden</th>
            <th width="4%" class="text-center" title="Empresa">Emp.</th>
            <th width="5%" class="text-center">Mes/Año</th>
            <th width="8%" class="text-center" title="Tipo Pago">T. Pago</th>
            <th width="4%" class="text-center" title="Pedido">Ped.</th>
            <th width="8%" class="text-center">Rubro</th>
            <th width="10%" class="text-center" title="Sub-Rubro">Sub-Ru.</th>
            <th width="18%" class="text-center">Descripción</th>
            <th width="6%" class="text-center" title="Fecha Emisión">F. Emi.</th>
            <th width="6%" class="text-center" title="Fecha Pago">F. Pago</th>
            <th width="6%" class="text-center" title="Fecha Registro Arpay">F. Arp.</th>
            <th width="4%" class="text-center" title="Operación">Ope.</th>
            <th width="6%" class="text-center">Monto</th>
            <th width="9%" class="text-center" title="Tipo Documento">T. Doc.</th>
            <th width="3%" class="text-center" title="Documento">Doc.</th>
            <th width="3%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_gasto as $list){ ?>
            <tr 
                <?php 
                    if($tipo==1){
                        echo "style='background-color:#C2D5FF;'"; 
                    }else{
                        if(($list['CostTypeId']==71 || $list['CostTypeId']==121) || ($list['CostTypeId']==34 && $list['obliga_documento']==0) || 
                        ($list['Ruc_Beneficiario']!="" && $list['Fecha_Pago']!="" && $list['Documento']!="") || 
                        ($list['Ruc_Beneficiario']!="" && $list['Fecha_Pago']!="" && $list['obliga_documento']==0) || 
                        ($list['Documento']!="" && $list['obliga_datos']==0)){ 
                            echo "style='background-color:#E6FFBF;'"; 
                        }else{ 
                            echo "style='background-color:#C2D5FF;'"; 
                        } 
                    }
                ?>>
                <td><?php echo $list['Fecha_Orden']; ?></td>
                <td class="text-center"><?php echo $list['Empresa']; ?></td>
                <td class="text-left"><?php echo $list['Mes_Anio']; ?></td>
                <td><?php echo $list['Tipo_Pago']; ?></td>
                <td class="text-center"><?php echo $list['Pedido']; ?></td>
                <td><?php echo $list['Rubro']; ?></td>
                <td><?php echo $list['Subrubro']; ?></td>
                <td><?php echo substr($list['Descripcion'],0,39); ?></td>
                <td class="text-center"><?php echo $list['Fecha_Emision']; ?></td>
                <td class="text-center"><?php echo $list['Fecha_Pago']; ?></td>
                <td class="text-center"><?php echo $list['Fecha_Arpay']; ?></td>
                <td class="text-center"><?php echo $list['Operacion']; ?></td>
                <td class="text-right"><?php echo "S/ ".$list['Monto']; ?></td>
                <td><?php echo $list['Tipo_Documento']; ?></td>
                <td class="text-center">
                    <?php if($id_usuario==1 || $id_usuario==5 || $id_usuario==7 || $id_nivel==10 || $id_nivel==1 || $id_usuario==56 || $id_nivel==11){ ?>
                        <?php if($list['Documento']!=""){ ?>
                            <a href="<?= site_url('Administrador/Descargar_Documento_Gastos_Sunat') ?>/<?php echo $list['Id']; ?>">
                                <img title="Descargar" src="<?= base_url() ?>template/img/descarga_peq.png">
                            </a>
                        <?php } ?>
                    <?php } ?>
                </td>
                <td class="text-center">
                    <a data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Modal_Update_Gastos_Sunat') ?>/<?php echo $list['Id']; ?>">
                        <img title="Información Adicional" src="<?= base_url() ?>template/img/editar.png">
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
            
            if(title=="" || title=="Doc."){
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
            order: [0,"asc"],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 100,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 14,15 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        } );
    } );
</script>
