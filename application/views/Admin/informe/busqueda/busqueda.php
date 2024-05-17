<table width="100%" class="table table-hover table-bordered table-striped" id="example">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th width="3%" class="text-center" title="Prioridad">Pri</th>
            <th width="3%" class="text-center" title="Código">Cod</th>
            <th width="3%" class="text-center">M/D</th>
            <th width="6%" class="text-center">Status</th>
            <th width="3%" class="text-center" title="Empresa">Emp</th>
            <th width="3%" class="text-center">Sede</th>
            <th width="6%" class="text-center">Tipo</th>
            <th width="10%" class="text-center">SubTipo</th>
            <th width="29%" class="text-center">Descripción</th>
            <th width="5%" class="text-center">Snappy's</th>
            <th width="5%" class="text-center">Agenda</th>
            <th width="5%" class="text-center">Usuario</th>
            <th width="5%" class="text-center">Fecha</th>
            <th width="5%" class="text-center">Usuario</th>
            <th width="5%" class="text-center">Fecha</th>
            <td width="4%" class="text-center"></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_proyecto as $row_p) {  ?>                                           
            <tr <?php if($row_p['background']!='') { echo "style='background-color: ".$row_p['background'].";'";} ?> >
                <td class="text-center"><?php echo $row_p['prioridad']; ?></td>
                <td class="text-center"><?php echo utf8_encode($row_p['cod_proyecto']); ?></td>
                <td class="text-center"><?php if($row_p['duplicado']==1){echo "D";}else{echo "M";} ?></td>
                <td style="background-color:<?php echo $row_p['color']; ?>"><?php echo $row_p['nom_statusp']; ?></td>
                <td class="text-center"><?php echo $row_p['cod_empresa']; ?> </td>
                <td><?php echo $row_p['cod_sede'];  ?> </td>
                <td class="text-center"><?php echo $row_p['nom_tipo']; ?></td>
                <td><?php echo $row_p['nom_subtipo']; ?></td>
                <td><?php $array=explode(" ",$row_p['descripcion']); $i=0; $cadena=""; while($i<count($array)){ if(strlen($cadena.$array[$i])>63){ break; } $cadena=$cadena.$array[$i]." "; $i++; }  echo substr($cadena,0,-1); ?></td>
                <td class="text-center"><?php echo $row_p['s_artes']+$row_p['s_redes']; ?></td>
                <td class="text-center"><?php if ($row_p['fec_agenda']!='00/00/0000') echo $row_p['fec_agenda'];  ?></td>
                <td><?php echo $row_p['ucodigo_solicitado']; ?></td>
                <td class="text-center"><?php if ($row_p['fec_solicitante']!='00/00/0000') echo $row_p['fec_solicitante']; ?></td>
                <td><?php echo $row_p['ucodigo_asignado']; ?></td>
                <td class="text-center"><?php if ($row_p['fec_termino']!='00/00/0000') echo $row_p['fec_termino'];?></td>
                <td class="text-center">
                    <?php if($row_p['duplicado']!=1){ ?>
                        <?php if($_SESSION['usuario'][0]['id_usuario']!=69 && $_SESSION['usuario'][0]['id_usuario']!=72){ ?>
                            <a type="button" title="Editar" href="<?= site_url('Snappy/Editar_proyect') ?>/<?php echo $row_p['id_proyecto']; ?>"> 
                                <img src="<?= base_url() ?>images/editar.png" style="cursor:pointer; cursor: hand;"/>
                            </a>
                        <?php } ?>

                        <?php if ($row_p['imagen']!='') { ?>
                            <!--<img src="<?= base_url() ?>template/img/ver.png" data-toggle="modal" data-target="#dataUpdate" data-imagen="<?php echo $row_p['imagen']?>" title="Ver Imagen" style="cursor:pointer; cursor: hand;"/>-->
                            <a title="Ver Imagen" href="<?php echo $row_p['imagen']; ?>" target="_blank">
                                <img src="<?= base_url() ?>template/img/ver.png">
                            </a>
                        <?php } ?>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');

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
            ordering: false,
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 100,
        });
    });
</script>