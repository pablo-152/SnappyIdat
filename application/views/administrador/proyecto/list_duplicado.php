<table id="example" class="table table-striped table-bordered" width="100%">
    <thead>
        <tr>
            <th>Orden</th>
            <th class="text-center" width="15%">Inicio</th>
            <th class="text-center" width="15%">Snappy Redes</th>
            <th class="text-center" width="30%">Tipo</th>
            <th class="text-center" width="30%">Sub-Tipo</th>
            <th class="text-center" width="10%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_duplicado as $list) {  ?>
            <tr class="even pointer text-center">
                <td><?php echo $list['inicio']; ?></td>
                <td><?php echo $list['fecha_inicio']; ?></td>
                <td><?php echo $list['snappy_redes']; ?></td>
                <td><?php echo $list['nom_tipo']; ?></td>
                <td><?php echo $list['nom_subtipo']; ?></td>
                <td>
                    <a title="Eliminar" onclick="Delete_Duplicado('<?php echo $list['id_calendar_agenda']; ?>','<?php echo $list['id_calendar_redes']; ?>')">
                        <img src="<?= base_url() ?>template/img/eliminar.png">
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

          if(title==""){
            $(this).html('');
          }else{
            $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
          }

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
          order: [[0,"asc"]],
          orderCellsTop: true,
          fixedHeader: true, 
          pageLength: 10,
          "aoColumnDefs" : [ 
              {
                  'bSortable' : false,
                  'aTargets' : [ 5 ]
              },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
          ]
      });
    } );
</script>