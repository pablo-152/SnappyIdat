<table id="example_pagos_arpay" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th width="20%" class="text-center">Producto</th>  
            <th width="10%" class="text-center">Estado</th>
            <th width="20%" class="text-center">Descripción</th>
            <th width="10%" class="text-center">Fecha VP</th> 
            <th width="10%" class="text-center">Monto</th>
            <th width="10%" class="text-center">Descuento</th>
            <th width="10%" class="text-center">Penalidad</th>
            <th width="10%" class="text-center">SubTotal</th>
        </tr>
    </thead>
    <?php if($estado==1){ ?>
        <tbody>
            <?php foreach ($list_pago_arpay as $list){ ?>
                <tr class="even pointer text-center">
                    <td class="text-left"><?php echo $list['Producto']; ?></td>
                    <td><?php echo $list['Estado']; ?></td>
                    <td class="text-left"><?php echo $list['Descripcion']; ?></td>
                    <td><?php echo $list['Fecha_VP']; ?></td>
                    <td class="text-right"><?php echo "s./".number_format($list['Monto'],2); ?></td>
                    <td class="text-right"><?php echo "s./".number_format($list['Descuento'],2); ?></td>
                    <td class="text-right"><?php echo "s./".number_format($list['Penalidad'],2); ?></td>
                    <td class="text-right"><?php echo "s./".number_format($list['SubTotal'],2); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    <?php }else{ ?>
        <tbody>
            <?php foreach ($list_pago_arpay as $list){
                if($list['Estado']=="Pendiente"){ ?>
                    <tr class="even pointer text-center">
                        <td class="text-left"><?php echo $list['Producto']; ?></td>
                        <td><?php echo $list['Estado']; ?></td>
                        <td class="text-left"><?php echo $list['Descripcion']; ?></td>
                        <td><?php echo $list['Fecha_VP']; ?></td>
                        <td class="text-right"><?php echo "s./".number_format($list['Monto'],2); ?></td>
                        <td class="text-right"><?php echo "s./".number_format($list['Descuento'],2); ?></td>
                        <td class="text-right"><?php echo "s./".number_format($list['Penalidad'],2); ?></td>
                        <td class="text-right"><?php echo "s./".number_format($list['SubTotal'],2); ?></td>
                    </tr>
            <?php } } ?>
        </tbody>
    <?php } ?>
</table>

<script>
  $(document).ready(function() {
      $('#example_pagos_arpay thead tr').clone(true).appendTo('#example_pagos_arpay thead');
      $('#example_pagos_arpay thead tr:eq(1) th').each(function(i) {
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

      var table = $('#example_pagos_arpay').DataTable({
          orderCellsTop: true,
          fixedHeader: true,
          pageLength: 100,
          "aoColumnDefs" : [ 
              {
                  'bSortable' : true,
                  'aTargets' : [ 7 ]
              }
          ]
      });
  } );
</script>