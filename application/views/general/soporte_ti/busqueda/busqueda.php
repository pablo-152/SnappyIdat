<table width="100%" class="table table-hover table-bordered table-striped" id="example">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="4%" title="Código">Cod</th>
          <th class="text-center" width="4%" title="Prioridad">Pri</th>
          <th class="text-center" width="4%">Tipo</th>
          <th class="text-center" width="4%" title="Empresa">Emp</th>
          <th class="text-center" width="10%">Proyecto</th>
          <th class="text-center" width="13%">Sub-Proyecto</th>
          <th class="text-center" width="26%">Descripción</th>
          <th class="text-center" width="6%">Fecha</th>
          <th class="text-center" width="6%" title="Solicitado">Soli</th>
          <th class="text-center" width="6%" >Ult.&nbsp;Acción</th>          
          <!--<th class="text-center" width="6%" >Usuario</th>-->
          <th class="text-center" width="6%">Desarrollador</th>
          <th class="text-center" width="5%">Horas</th>
          <th class="text-center" width="6%">Estado</th>
          <th class="text-center" width="3%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_busqueda as $list) {  ?>                                           
            <tr class="even pointer">
                  <td class="text-center"><?php echo $list['cod_ticket']; ?></td>
                  <td class="text-center"><?php echo $list['v_prioridad']; ?></td>
                  <td class="text-center"><?php echo $list['nom_tipo_ticket']; ?></td>
                  <td class="text-center"><?php echo $list['cod_empresa']; ?></td>
                  <td class="text-left"><?php echo $list['proyecto']; ?></td>
                  <td class="text-left"><?php echo $list['subproyecto']; ?></td>
                  <td ><?php echo substr($list['ticket_desc'], 0, 50); ?></td>
                  <td class="text-center"><?php echo $list['fecha_registro']; ?></td>                  
                  <td ><?php echo $list['cod_soli']; ?></td>   
                  <td ><?php echo $list['fecha_registro_th']; ?></td>                                 
                  <td ><?php echo $list['cod_terminado_por']; ?></td>
                  <!--<td ><?php echo $list['cod_terminado_por']; ?></td>-->
                  <!--<td ><?php echo $list['tiempo']; ?></td>-->
                  <td class="text-center">
                    <?php 
                      if ($list['horas'] != 0 || $list['minutos'] != 0) {
                        if ($list['minutos'] == "0") {
                          $minuto = "00";
                        }else{
                          $minuto = $list['minutos'];
                        }
                        echo $list['horas'] . ":" . $minuto;
                      } 
                    ?>
                  </td>
                  <td><span class="badge" style="background:<?php echo $list['col_status']; ?>;"><?php echo $list['nom_status']; ?></span></td>
                  <td class="text-center">
                    <a title="Más Información" href="<?= site_url('General/Historial_Ticket') ?>/<?php echo $list['id_ticket']; ?>/2">
                      <img title="Más Información" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
                    </a>
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
            ordering: true,
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
        });
    });
</script>