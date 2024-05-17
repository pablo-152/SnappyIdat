<table id="example" class="table table-hover table-bordered table-striped" width="100%">     
    <thead>
        <tr style="font-weight: bold;">
            <td class="text-center" rowspan="2">Semana</td>
            <td class="text-center melon" colspan="4">Bugs</td>
            <td class="text-center violeta" colspan="4">Improve</td>
            <td class="text-center azulino" colspan="4">News</td>
            <td class="text-center celeste" colspan="4">TOTALES</td>
            <td class="text-center" colspan="7" >Estado</td>
        </tr>
        <tr style="font-weight: bold;"> 
            <th class="text-center melon help" title="Solicitados">SOL</td>
            <th class="text-center melon help" title="Terminados">TER</td>
            <th class="text-center melon help" title="Revisados">RVS</td>
            <th class="text-center melon">Horas</td>
            <th class="text-center violeta help" title="Solicitados">SOL</td>
            <th class="text-center violeta help" title="Terminados">TER</td>
            <th class="text-center violeta help" title="Revisados">RVS</td>
            <th class="text-center violeta">Horas</td>
            <th class="text-center azulino help" title="Solicitados">SOL</td>
            <th class="text-center azulino help" title="Terminados">TER</td>
            <th class="text-center azulino help" title="Revisados">RVS</td>
            <th class="text-center azulino">Horas</td>
            <th class="text-center celeste help" title="Solicitados">SOL</th>
            <th class="text-center celeste help" title="Terminados">TER</th>
            <th class="text-center celeste help" title="Revisados">RVS</th>
            <th class="text-center celeste">Horas</th>
            <th class="text-center">Estado</th>
            <th class="text-center help" title="Solicitados">Soli</th>
            <th class="text-center help" title="Asignados">Asig</th>
            <th class="text-center help" title="En Trámite">Trám</th>
            <th class="text-center">Pend.&nbsp;Resp.</th>
            <th class="text-center"></th>
            <th class="text-center"></th>
        </tr>
    </thead>

    <?php foreach ($list_informe as $list) { ?>
        <tr class="text-center">
        <td align="left" nowrap><?php echo "<b>".$list['semana']."</b> (".$list['primer']." - ".$list['ultimo'].")"; ?></td>
        <td><?php echo $list['bug_solici']; ?></td>
        <td><?php echo $list['bug_termi']; ?></td>
        <td><?php echo $list['bug_revi']; ?></td>
        <td class="text-right">
            <?php
                $h = 0;
                $m = 0;
                $h = $list['hr_bug_ter_rev'];
                $minutes = $list['min_bug_ter_rev'];
                $zero    = new DateTime('@0');
                $offset  = new DateTime('@' . $minutes * 60);
                $diff    = $zero->diff($offset);
                $hora = $diff->format('%h');
                $minuto = $diff->format('%i');
                echo str_pad(($h+$hora),2,"0",STR_PAD_LEFT).":".str_pad($minuto,2,"0",STR_PAD_LEFT);
                /*echo ($h + $hora) . ":" . $minuto;
                if ($h != 0) {
                echo " hr";
                } else {
                echo " min";
                }*/
            ?>
        </td>
        <td><?php echo $list['improve_solici']; ?></td>
        <td><?php echo $list['improve_termi']; ?></td>
        <td><?php echo $list['improve_revi']; ?></td>
        <td class="text-right">
            <?php
                $h = 0;
                $m = 0;
                $h = $list['hr_improve_ter_rev'];
                $minutes = $list['min_improve_ter_rev'];
                $zero    = new DateTime('@0');
                $offset  = new DateTime('@' . $minutes * 60);
                $diff    = $zero->diff($offset);
                $hora = $diff->format('%h');
                $minuto = $diff->format('%i');
                echo str_pad(($h+$hora),2,"0",STR_PAD_LEFT).":".str_pad($minuto,2,"0",STR_PAD_LEFT);
                /*echo ($h + $hora) . ":" . $minuto;
                if ($h != 0) {
                echo " hr";
                } else {
                echo " min";
                }*/
            ?>
        </td>
        <td><?php echo $list['new_solici']; ?></td>
        <td><?php echo $list['new_termi']; ?></td>
        <td><?php echo $list['new_revi']; ?></td>
        <td class="text-right">
            <?php
                $h = 0;
                $m = 0;
                $h = $list['hr_new_ter_rev'];
                $minutes = $list['min_new_ter_rev'];
                $zero    = new DateTime('@0');
                $offset  = new DateTime('@' . $minutes * 60);
                $diff    = $zero->diff($offset);
                $hora = $diff->format('%h');
                $minuto = $diff->format('%i');
                echo str_pad(($h+$hora),2,"0",STR_PAD_LEFT).":".str_pad($minuto,2,"0",STR_PAD_LEFT);
                /*echo ($h + $hora) . ":" . $minuto;
                if ($h != 0) {
                echo " hr";
                } else {
                echo " min";
                }*/
            ?>
        </td>
        <td><?php echo $list['total_solicitado']; ?></td>
        <td><?php echo $list['total_terminado']; ?></td>
        <td><?php echo $list['total_revisado']; ?></td>
        <td class="text-right">
            <?php
                $h = 0;
                $m = 0;
                $h = $list['hr_total_ter'];
                $minutes = $list['min_total_ter'];
                $zero    = new DateTime('@0');
                $offset  = new DateTime('@' . $minutes * 60);
                $diff    = $zero->diff($offset);
                $hora = $diff->format('%h');
                $minuto = $diff->format('%i');
                echo str_pad(($h+$hora),2,"0",STR_PAD_LEFT).":".str_pad($minuto,2,"0",STR_PAD_LEFT);
                /*echo ($h + $hora) . ":" . $minuto;
                if ($h != 0) {
                echo " hr";
                } else {
                echo " min";
                }*/
            ?>
        </td>
        <td><span class='badge' <?php if($list['estado_semana']=="Pendiente"){ echo "style='background:#0070C0;color:white;'"; }else{echo "style='background:#C00000;color:white;'"; }?>><?php echo $list['estado_semana'] ?></span></td>
        <td><?php echo $list['t_estado_soli']; ?></td>
        <td><?php echo $list['t_estado_asig']; ?></td>
        <td><?php echo $list['t_estado_trami']; ?></td>
        <td><?php echo $list['t_estado_pendresp']; ?></td>
        <td><input required type="checkbox" id="id_informe[]" name="id_informe[]" value="<?php echo $list['semana'] . "-" . $list['anio']; ?>"></td>
        <td>
            <a href="<?= site_url('General/Excel_Informe_Periodo') ?>/<?php echo $list['semana'] ?>/<?php echo $list['anio'] ?>" title="Exportar Excel">
                <img height="20px" src="<?= base_url() ?>template/img/excel_tabla.png" alt="Exportar Excel" />
            </a>
        </td>
        </tr>
    <?php } ?>
</table>

<script>
    $(document).ready(function() {
        /*$('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();

            if(title==""){
                $(this).html('');
            }else{
                $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
            }
    
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );*/

        var table = $('#example').DataTable( {
            ordering: false,
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50
        } );
    } );
</script>