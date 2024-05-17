<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $sesion['id_nivel'];
$id_usuario = $sesion['id_usuario'];
?>
<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr>
            <th class="text-center">Año</th>
            <th class="text-center">Mes</th>
            <th class="text-center" width="6%">Mes</th>
            <th class="text-center" width="15%">Movimientos (PDF)</th>
            <th class="text-center" width="15%">Movimientos (XLS)</th>
            <th class="text-center" width="15%">Resumen Anual (XLS)</th>
            <th class="text-center" width="11%">Saldo (BBVA)</th>
            <th class="text-center" width="11%">Saldo (REAL)</th>
            <th class="text-center" width="11%">Saldo Auto</th>
            <th class="text-center" width="11%">Diferencia</th>
            <th class="text-center" width="8%">Revisado</th>
            <th class="text-center" width="8%">Usuario</th>
            <th class="text-center" width="6%">Fecha</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_detalle as $list) { ?>
            <tr class="text-center">
                <td><?php echo $list['anio']; ?></td>
                <td><?php echo $list['mes']; ?></td>
                <td><?php echo $list['mes_anio']; ?></td>
                <td><span class="badge" style="background:<?php echo $list['c_pdf']; ?>;color: white;"><?php echo $list['v_pdf']; ?></span></td>
                <td><span class="badge" style="background:<?php echo $list['c_excel']; ?>;color: white;"><?php echo $list['v_excel']; ?></span></td>
                <td><span class="badge" style="background:<?php echo $list['c_anual']; ?>;color: white;"><?php echo $list['v_anual']; ?></span></td>
                <td class="text-right"><?php if($list['saldo_bbva']!=0){ echo "S/".number_format($list['saldo_bbva'],2); }else{ echo ""; }  ?></td>
                <td class="text-right"><?php if($list['saldo_real']!=0){ echo "S/".number_format($list['saldo_real'],2); }else{ echo ""; }  ?></td>
                <td class="text-right" style="background-color:#e2f0d9"><?php $saldos = substr($meses, 0, -1);
                    $saldos = explode(",", $saldos);
                    $automatico=0;
                    if(count($saldos)>0){
                        foreach($saldos as $s){
                            $array=explode("_",$s);
                            if($array[0]==$list['mes_anio']){
                                $automatico=$array[1];
                                echo "S/".number_format($array[1],2);
                            }
                        }
                    }
                 ?></td>
                <td class="text-right" style="background-color:#fff3df"><?php if($automatico>0 && $list['saldo_real']!=0){echo "S/".number_format($automatico-$list['saldo_real'],2);}?></td>
                <td><?php echo $list['revisado']; ?></td>
                <td class="text-left"><?php echo $list['user_rev']; ?></td>
                <td><?php echo $list['fec_rev']; ?></td>
                <td>
                <?php if( $id_nivel==11){ ?>
                    <a type="button" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Modal_Update_Detalle_Estado_Bancario') ?>/<?php echo $list['id_detalle']; ?>">  <img title="Más Información" src="<?= base_url() ?>template/img/ver.png"  style="cursor:pointer; cursor: hand;" width="22" height="22" />
                    </a>
                <?php }else{ ?>
                    <a type="button" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Modal_Update_Detalle_Estado_Bancario') ?>/<?php echo $list['id_detalle']; ?>">  <img src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" width="22" height="22"/>
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
              $(this).html('<input type="text" placeholder="Buscar '+title+'"/>');
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
            order: [[0,"desc"],[1,"desc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 11 ]
                },
                {
                    'targets' : [ 0,1 ],
                    'visible' : false
                } 
            ]
        } );
    } );
</script>