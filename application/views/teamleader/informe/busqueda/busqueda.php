<table class="table table-bordered table-striped" style="font-size:12px" id="example">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th width="5%">Pri</th>
            <th width="5%">Cód</th>
            <th width="5%">Status</th>
            <th width="5%">Emp</th>
            <th width="5%">Sede</th>
            <th width="8%">Tipo</th>
            <th width="8%">SubTipo</th>
            <th width="18%">Descripción</th>
            <th width="8%">Snappy's</th>
            <th width="6%">Agenda</th>
            <th width="5%">Usu</th>
            <th width="6%">Fecha</th>
            <th width="5%">Usu</th>
            <th width="6%">Fecha</th>
            <th width="7%">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_proyecto as $row_p) {  ?>                                           
            <tr <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?> >
                <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['prioridad']; ?></td>
                <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo utf8_encode($row_p['cod_proyecto']); ?></td>
                <td style="background-color:<?php echo $row_p['color']; ?>"><?php echo $row_p['nom_statusp']; ?></td>
                <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>>
                    <?php 
                        $empresa="";
                        foreach($list_empresa as $list){
                        if($list['id_proyecto']==$row_p['id_proyecto']){
                            $empresa=$empresa.$list['cod_empresa'].",";
                        }
                        }
                        echo substr($empresa,0,-1);
                    ?>
                </td>
                <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>>
                    <?php 
                        $sede="";
                        foreach($list_sede as $list){
                        if($list['id_proyecto']==$row_p['id_proyecto']){
                            $sede=$sede.$list['cod_sede'].",";
                        }
                        }
                        echo substr($sede,0,-1);
                    ?>
                </td>
                <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['nom_tipo']; ?></td>
                <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['nom_subtipo']; ?></td>
                <td style="max-width: 10px; overflow: hidden;" nowrap <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['descripcion']; ?></td>
                <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['s_artes']+$row_p['s_redes']; ?></td>
                <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php if ($row_p['fec_agenda']!='00/00/0000') echo $row_p['fec_agenda']; ?></td>
                <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['ucodigo_solicitado']; ?></td>
                <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php if ($row_p['fec_solicitante']!='00/00/0000') echo $row_p['fec_solicitante']; ?></td>
                <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['ucodigo_asignado']; ?></td>
                <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php if ($row_p['fec_termino']!='00/00/0000 00:00:00') echo $row_p['fec_termino'];?></td>
                <td nowrap align="center"
                <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>>
                
                <?php  if($row_p['duplicado']!=1){ ?>
                    <a type="button" title="Editar Proyecto" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Teamleader/Editar_proyect') ?>/<?php echo $row_p['id_proyecto']; ?>/<?php echo "1"; ?>"> 
                        <img width="20px" height="20px" src="<?= base_url() ?>images/editar.png" style="cursor:pointer; cursor: hand;"/>
                    </a>
                    
                    <?php if ($row_p['imagen']!='') { ?>
                        <img src="<?= base_url() ?>template/img/ver.png" width="21px" height="21px" data-toggle="modal" data-target="#dataUpdate" data-imagen="<?php echo $row_p['imagen']?>" title="Ver Imagen" style="cursor:pointer; cursor: hand;"/>
                    <?php } ?>
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

        var table = $('#example').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            dom: 'Bfrtip',
            pageLength: 100
        } );

    } );
</script>