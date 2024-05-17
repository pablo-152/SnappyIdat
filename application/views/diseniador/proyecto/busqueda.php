<input type="hidden" name="id_status" id="id_status" value="<?php echo $status; ?>">

<table id="example" class="table table-striped table-bordered" width="100%">
  <thead>
    <tr style="background-color: #E5E5E5;">
      <th class="text-center" width="3%">Pri</th>
      <th class="text-center" width="5%">Cod</th>
      <th class="text-center" width="6%">Status</th>
      <th class="text-center" width="4%">Emp</th>
      <th class="text-center" width="5%">Sede</th>
      <th class="text-center" width="7%">Tipo</th>
      <th class="text-center" width="10%">SubTipo</th>
      <th class="text-center" width="23%">Descripción</th>
      <th class="text-center" width="6%">Snappy's</th>
      <th class="text-center" width="6%">Agenda</th>
      <th class="text-center" width="5%">Usu</th>
      <th class="text-center" width="6%">Fecha</th>
      <th class="text-center" width="5%">Usu</th>
      <th class="text-center" width="6%">Fecha</th>
      <th class="text-center" width="3%"></th>
    </tr>
  </thead>

  <tbody>
    <?php foreach($diseniador_busq as $row_p) {  ?>
      <tr class="even pointer text-center">
        <td <?php if($row_p['proy_obs']!=''){ echo "style='background-color: #37A0CF;'"; } ?>>
          <?php echo $row_p['prioridad']; ?>
        </td>
        <td <?php if($row_p['proy_obs']!=''){ echo "style='background-color: #37A0CF;'"; } ?>>
          <?php echo $row_p['cod_proyecto']; ?>
        </td>
        <td class="text-left" style="background-color:<?php echo $row_p['color']; ?>">
          <?php echo $row_p['nom_statusp']; ?>
        </td>
        <td class="text-left" <?php if($row_p['proy_obs']!=''){ echo "style='background-color: #37A0CF;'"; } ?>>
          <?php echo $row_p['cod_empresa']; ?>
        </td>
        <td class="text-left" <?php if($row_p['proy_obs']!=''){ echo "style='background-color: #37A0CF;'"; } ?>>
          <?php echo $row_p['cod_sede']; ?>
        </td>
        <td class="text-left" <?php if($row_p['proy_obs']!=''){ echo "style='background-color: #37A0CF;'";} ?>>
          <?php echo $row_p['nom_tipo']; ?>
        </td>
        <td class="text-left" <?php if($row_p['proy_obs']!=''){ echo "style='background-color: #37A0CF;'";} ?>>
          <?php echo $row_p['nom_subtipo']; ?>
        </td>
        <td class="text-left" <?php if($row_p['proy_obs']!=''){ echo "style='background-color: #37A0CF;'";} ?>>
          <?php echo $row_p['descripcion']; ?>
        </td>
        <td <?php if($row_p['proy_obs']!=''){ echo "style='background-color: #37A0CF;'";} ?>>
          <?php echo $row_p['s_artes']+$row_p['s_redes']; ?>
        </td>
        <td <?php if($row_p['proy_obs']!=''){ echo "style='background-color: #37A0CF;'";} ?>>
          <?php echo $row_p['fecha_agenda']; ?>
        </td>
        <td class="text-left" <?php if($row_p['proy_obs']!=''){ echo "style='background-color: #37A0CF;'";} ?>>
          <?php echo $row_p['ucodigo_solicitado']; ?>
        </td>
        <td <?php if($row_p['proy_obs']!=''){ echo "style='background-color: #37A0CF;'";} ?>>
          <?php echo $row_p['fecha_solicitante']; ?>
        </td>
        <td class="text-left" <?php if($row_p['proy_obs']!=''){ echo "style='background-color: #37A0CF;'";} ?>>
          <?php echo $row_p['ucodigo_asignado']; ?>
        </td>
        <td <?php if($row_p['proy_obs']!=''){ echo "style='background-color: #37A0CF;'";} ?>>
          <?php echo $row_p['fecha_termino']; ?>
        </td>
        <td <?php if($row_p['proy_obs']!=''){ echo "style='background-color: #37A0CF;'";} ?>>
          <a title="Editar" href="<?= site_url('Diseniador/Editar_proyecto') ?>/<?php echo $row_p['id_proyecto']; ?>" style="cursor:pointer; cursor: hand;">
            <img src="<?= base_url() ?>template/img/editar.png">
          </a>

          <?php if($row_p['imagen']!=''){ ?>
            <a title="Ver Imagen" data-toggle="modal" data-target="#dataUpdate" 
            data-imagen="<?php echo $row_p['imagen']?>" style="cursor:pointer; cursor: hand;">
              <img src="<?= base_url() ?>template/img/ver.png">
            </a>
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

        if(title==""){
            $(this).html('');
        }else{
            $(this).html('<input type="text" placeholder="Buscar '+title+'" />');
        }

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

    var table = $('#example').DataTable( {
        order: [[0,"asc"],[1,"asc"]],
        orderCellsTop: true,
        fixedHeader: true,
        pageLength: 50,
        "aoColumnDefs" : [ 
            {
                'bSortable' : false,
                'aTargets' : [ 14 ]
            }
        ]
    } );
} );
</script>