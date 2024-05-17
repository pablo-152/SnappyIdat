<style>
  #example tbody tr td:nth-child(1),#example tbody tr td:nth-child(2),#example tbody tr td:nth-child(3),#example tbody tr td:nth-child(5),
  #example tbody tr td:nth-child(7),#example tbody tr td:nth-child(10),#example tbody tr td:nth-child(11),#example tbody tr td:nth-child(13),
  #example tbody tr td:nth-child(15),#example tbody tr td:nth-child(16){
      text-align: center;
  }

  <?php $i_o=1; foreach($row_p as $list){ 
      if($list['proy_obs']==''){ ?>
        #example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(1),#example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(2),
        #example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(3),#example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(5),
        #example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(6),#example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(7),
        #example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(8),#example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(9),
        #example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(10),#example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(11),
        #example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(12),#example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(13),
        #example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(14),#example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(15),
        #example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(16){
            background-color: #FFF;
        }
      <?php }else{ ?>
        #example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(1),#example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(2),
        #example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(3),#example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(5),
        #example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(6),#example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(7),
        #example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(8),#example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(9),
        #example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(10),#example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(11),
        #example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(12),#example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(13),
        #example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(14),#example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(15),
        #example tbody tr:nth-child(<?php echo $i_o; ?>) td:nth-child(16){
            background-color: #ABD5FF;
        }
    <?php } $i_o++; }  ?>
  
  <?php $i_c=1; foreach($row_p as $list) { ?>
      #example tbody tr:nth-child(<?php echo $i_c; ?>) td:nth-child(4){
          background-color: <?php echo $list['color']; ?>;
      }
  <?php $i_c++; } ?>
</style>

<input type="hidden" id="cadena" name="cadena" value="">
<input type="hidden" id="cantidad" name="cantidad" value="0">
<input type="hidden" id="prueba" name="prueba">

<input type="hidden" name="id_status" id="id_status" value="<?php echo $status; ?>">

<table class="table table-hover table-bordered table-striped" id="example" >
    <thead>
        <tr>
          <th class="text-center" width="3%"><input type="checkbox" style="width: 20px" id="total" name="total" value="1"></th>
          <th class="text-center">Id</th>
          <th class="text-center" width="3%" title="Prioridad">Pri</th>
          <th class="text-center" width="5%" title="Código">Cod</th>
          <th class="text-center" width="6%">Status</th>
          <th class="text-center" width="4%" title="Empresa">Emp</th>
          <th class="text-center" width="5%">Sede</th>
          <th class="text-center" width="7%">Tipo</th>
          <th class="text-center" width="10%">SubTipo</th>
          <th class="text-center" width="21%">Descripción</th>
          <th class="text-center" width="6%">Snappy's</th>
          <th class="text-center" width="6%">Agenda</th>
          <th class="text-center" width="5%">Usuario</th>
          <th class="text-center" width="5%">Fecha</th>
          <th class="text-center" width="5%">Usuario</th>
          <th class="text-center" width="6%">Fecha</th>
          <th class="text-center" width="3%"></th>
        </tr>
    </thead>
    <tbody>
      <?php foreach($row_p as $list) {  ?>
        <tr class="even pointer">
          <td><input type="checkbox" id="array_proyecto[]" name="array_proyecto[]" value="<?php echo $list['id_proyecto']; ?>"></td>
          <td><?php echo $list['id_proyecto']; ?></td>
          <td><?php echo $list['prioridad']; ?></td>
          <td><?php echo utf8_encode($list['cod_proyecto']); ?></td>
          <td><?php echo $list['nom_statusp']; ?></td>
          <td><?php echo $list['cod_empresa']; ?></td>
          <td><?php echo $list['cod_sede']; ?></td>
          <td><?php echo $list['nom_tipo']; ?></td>
          <td><?php echo $list['nom_subtipo']; ?></td>
          <td><?php echo $list['descripcion']; ?></td>
          <td><?php echo $list['s_artes']+$list['s_redes']; ?></td>
          <td><?php if ($list['fecha_agenda']!='00/00/0000'){ echo $list['fecha_agenda']; } ?></td>
          <td><?php echo $list['ucodigo_solicitado']; ?></td>
          <td><?php if ($list['fecha_solicitante']!='00/00/0000'){ echo $list['fecha_solicitante']; } ?></td>
          <td><?php echo $list['ucodigo_asignado']; ?></td>
          <td><?php if ($list['fecha_termino']!='00/00/0000'){ echo $list['fecha_termino']; } ?></td>
          <td>
              <a title="Detalle Proyecto" href="<?= site_url('Administrador/Detalle_Proyecto') ?>/<?php echo $list['id_proyecto']; ?>">
                <img src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;"/>
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
          order: [[2,"asc"],[3,"asc"]],
          orderCellsTop: true,
          fixedHeader: true, 
          pageLength: 50,
          "aoColumnDefs" : [ 
              {
                  'bSortable' : false,
                  'aTargets' : [ 0,16 ]
              },
                {
                    'targets' : [ 1 ],
                    'visible' : false
                } 
          ]
      });

      // Seleccionar todo en la tabla
      let $dt = $('#example');
      let $total = $('#total');
      let $cadena = $('#cadena');
      let $cantidad = $('#cantidad');
      let $span_cantidad = $('#span_cantidad');

      // Cuando hacen click en el checkbox del thead
      $dt.on('change', 'thead input', function (evt) {
          var tipo=$('#prueba').val();
          if(tipo==""){
              let checked = this.checked;
              let total = 0;
              let data = [];
              let cadena='';
              
              table.data().each(function (info) {
              var txt = info[0];
                  if (checked) {
                      total += 1;
                      txt = txt.substr(0, txt.length - 1) + ' checked>';
                      cadena += info[1]+",";
                  } else {
                      txt = txt.replace(' checked', '');
                  }
                  info[0] = txt;
                  data.push(info);
              });
              
              table.clear().rows.add(data).draw();
              $cantidad.val(total);
              $cadena.val(cadena);
              $span_cantidad.html(total);
          }else{
              if (document.getElementById('total').checked){
                  var inp=document.getElementsByTagName('input');
                  for(var i=0, l=inp.length;i<l;i++){
                      if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='array_proyecto')
                          inp[i].checked=1;
                  }
              }else{
                  let checked = this.checked;
                  let total = 0;
                  let data = [];
                  let cadena='';
                  
                  table.data().each(function (info) {
                  var txt = info[0];
                      if (checked) {
                          total += 1;
                          txt = txt.substr(0, txt.length - 1) + ' checked>';
                          cadena += info[1]+",";
                      } else {
                          txt = txt.replace(' checked', '');
                      }
                      info[0] = txt;
                      data.push(info);
                  });
                  
                  table.clear().rows.add(data).draw();
                  $cantidad.val(total);
                  $cadena.val(cadena);
                  $span_cantidad.html(total);
              } 
          }
      });

      // Cuando hacen click en los checkbox del tbody
      $dt.on('change', 'tbody input', function() {
          let q= $('#cadena').val();
          let cantidad= $('#cantidad').val();
          let info = table.row($(this).closest('tr')).data();
          let total = parseFloat($total.val());
          let cadena = $cadena.val();
          let price = parseFloat(info[1]);
          let cadena2 = info[1]+",";
          //total += this.checked ? price : price * -1;
          
          if(this.checked==false){
              q = q.replace(cadena2, "");
              cantidad = parseFloat(cantidad)-1;
          }else{
              q += this.checked ? cadena2 : cadena2+",";
              cantidad = parseFloat(cantidad)+1;
          }
          $cadena.val(q);
          $cantidad.val(cantidad);
          $span_cantidad.html(cantidad);
          //cadena += this.checked ? cadena2 : info[1]+", ";
      });
    } );
</script>

<script>
  $(".img_post").click(function () {
    window.open($(this).attr("data-imagen"), 'popUpWindow',"height=" + $(this).attr("data-imagen").naturalHeight + ",width=" + $(this).attr("data-imagen").naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
  });
</script>

