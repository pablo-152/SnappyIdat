<table class="table table-hover table-bordered table-striped" id="example">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="2%">Pri</th>
            <th class="text-center" width="5%">Cód</th>
            <th class="text-center" width="6%">Status</th>
            <th class="text-center" width="4%">Emp</th>
            <th class="text-center" width="5%">Sede</th>
            <th class="text-center" width="8%">Tipo</th>
            <th class="text-center" width="15%">SubTipo</th>
            <th class="text-center" width="22%">Descripción</th>
            <th class="text-center" width="8%">Snappy's</th>
            <th class="text-center" width="7%">Agenda</th>
            <th class="text-center" width="8%">Usu</th>
            <th class="text-center" width="8%">Fecha</th>
            <th class="text-center" width="7%">Usu</th>
            <th class="text-center" width="8%">Fecha</th>
            <td class="text-center" width="4%"></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_proyecto as $row_p) {  ?>                                           
            <tr <?php if($row_p['background']!='') { echo "style='background-color: ".$row_p['background'].";'";} ?> >
                <td class="text-center"><?php echo $row_p['prioridad']; ?></td>
                <td class="text-center"><?php if($row_p['duplicado']==1){echo utf8_encode($row_p['cod_proyecto'])."*";}else{echo utf8_encode($row_p['cod_proyecto']);} ?></td>
                <td class="text-center" style="background-color:<?php echo $row_p['color']; ?>"><?php echo $row_p['nom_statusp']; ?></td>
                <td class="text-center"><?php echo $row_p['cod_empresa']; ?> </td>
                <td class="text-center">  <?php echo $row_p['cod_sede'];  ?> </td>
                <td class="text-center" nowrap><?php echo $row_p['nom_tipo']; ?></td>
                <td nowrap><?php echo $row_p['nom_subtipo']; ?></td>
                <td style="max-width: 10px; overflow: hidden;" nowrap ><?php echo $row_p['descripcion']; ?></td>
                <td class="text-center"><?php echo $row_p['s_artes']+$row_p['s_redes']; ?></td>
                <td class="text-center"><?php if($row_p['duplicado']==1){ echo $row_p['fec_agenda_duplicado']; }else{ if ($row_p['fec_agenda']!='00/00/0000') echo $row_p['fec_agenda']; }  ?></td>
                <td class="text-center"><?php echo $row_p['ucodigo_solicitado']; ?></td>
                <td class="text-center"><?php if ($row_p['fec_solicitante']!='00/00/0000') echo $row_p['fec_solicitante']; ?></td>
                <td class="text-center"><?php echo $row_p['ucodigo_asignado']; ?></td>
                <td class="text-center"><?php if ($row_p['fec_termino']!='00/00/0000 00:00:00') echo $row_p['fec_termino'];?></td>
                <td class="text-center" >
                    <?php  if($row_p['duplicado']!=1){ ?>
                        <a type="button" title="Editar Proyecto" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Modal_Update_Busqueda2') ?>/<?php echo $row_p['id_proyecto']; ?>"> 
                            <img src="<?= base_url() ?>images/editar.png" style="cursor:pointer; cursor: hand;"/>
                        </a>
                        
                        <?php if ($row_p['imagen']!='') { ?>
                            <img src="<?= base_url() ?>template/img/ver.png" data-toggle="modal" data-target="#dataUpdate" data-imagen="<?php echo $row_p['imagen']?>" title="Ver Imagen" style="cursor:pointer; cursor: hand;"/>
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
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 21,
        });
    });
</script>