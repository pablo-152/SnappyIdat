<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>

<form method="post" id="formularioxls" enctype="multipart/form-data" action="<?= site_url('General/Excel_Ticket') ?>" class="formulario">
  <input type="hidden" name="id_status" id="id_status" value="<?php echo $status; ?>"> 
</form>

<form id="formulario_cancelados" method="POST" enctype="multipart/form-data" class="needs-validation">
  <?php if($status==5){ ?>
    <table id="example" class="table table-hover table-bordered table-striped">
      <thead>
        <tr style="background-color: #E5E5E5; ">
          <th class="text-center">Orden</th>
          <th class="text-center" width="4%" title="Código">Cod</th>
          <th class="text-center" width="4%" title="Prioridad">Pri</th>
          <th class="text-center" width="4%">Tipo</th>
          <th class="text-center" width="4%" title="Empresa">Emp</th>
          <th class="text-center" width="10%">Proyecto</th>
          <th class="text-center" width="13%">Sub-Proyecto</th>
          <th class="text-center" width="26%">Descripción</th>
          <th class="text-center" width="5%">Fecha</th>
          <th class="text-center" width="6%" title="Solicitado">Soli</th>
          <th class="text-center" width="6%" >Ult.&nbsp;Acción</th>          
          <th class="text-center" width="6%" >Usuario</th>
          <th class="text-center" width="10%">Terminado Por</th>
          <th class="text-center" width="5%">Horas</th>
          <th class="text-center" width="6%">Estado</th>
          <th  width="3%" class="no-content"></th>
        </tr>
      </thead>
      <tbody>
        <?php if ($id_nivel == 9) { ?>
          <?php foreach ($list_busqueda as $list) {
              if ($list['id_status_ticket'] != 99){ if($sesion['id_usuario'] == $list['id_mantenimiento']){ ?>
                <tr class="even pointer">
                  <td class="text-center"><?php echo $list['prioridad']; ?></td>
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
                  <td ><?php echo $list['colaborador_codigo']; ?></td>
                  <td ><?php echo $list['cod_terminado_por']; ?></td>
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
                    <a title="Más Información" href="<?= site_url('General/Historial_Ticket') ?>/<?php echo $list['id_ticket']; ?>/1">
                      <img title="Más Información" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
                    </a>
                  </td>
                </tr>
              <?php } } ?>
            <?php } ?>
        <?php }else{ ?>
          <?php foreach ($list_busqueda as $list) {
            if ($list['id_status_ticket'] != 99) { ?>
              <tr class="even pointer">
                <td class="text-center"><?php echo $list['prioridad']; ?></td>
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
                <td ><?php echo $list['colaborador_codigo']; ?></td>                
                <td ><?php echo $list['cod_terminado_por']; ?></td>
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
                  <a title="Más Información" href="<?= site_url('General/Historial_Ticket') ?>/<?php echo $list['id_ticket']; ?>/1">
                    <img title="Más Información" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
                  </a>
                </td>
              </tr>
            <?php } ?>
          <?php } ?>
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
                  $(this).html('<input type="text" placeholder="Buscar '+title+'" />');
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
                order: [0,"asc"],
                orderCellsTop: true,
                fixedHeader: true,
                pageLength: 50,
                "aoColumnDefs" : [ 
                    {
                        'bSortable' : false,
                        'aTargets' : [ 15 ]
                    },
                    {
                        'targets' : [ 0 ],
                        'visible' : false
                    } 
                ]
            } );

            var estado = $('#id_status').val();

            if (estado == 7) {
              $('#cancelados').show();
            } else {
              $('#cancelados').hide();
            }

            if (estado == 8) {
              $('#cancelar').show();
            } else {
              $('#cancelar').hide();
            }
        } );
    </script>

  <?php }else{ ?>
    <table id="example" class="table table-hover table-bordered table-striped">
      <thead>
        <tr style="background-color: #E5E5E5;">
          <th class="text-center">Orden</th>
          <?php if ($status == 7 || $status == 8) { ?>
            <th class="text-center" width="3%"><input type="checkbox" id="total" name="total" onclick="seleccionart();" value="1"></th>
          <?php } ?>
          <?php if ($status == 7) { ?>
            <th class="text-center" style="font-size:14px" width="4%" title="Código">Mes</th>
          <?php }?>
          <th class="text-center" style="font-size:14px" width="4%" title="Código">Cod</th>
          <th class="text-center" style="font-size:14px" width="4%" title="Prioridad">Pri</th>
          <th class="text-center" style="font-size:14px" width="4%">Tipo</th>
          <th class="text-center"style="font-size:14px" width="4%" title="Empresa">Emp</th>
          <th class="text-center" style="font-size:14px" width="10%">Proyecto</th>
          <th class="text-center" style="font-size:14px" width="13%">Sub-Proyecto</th>
          <th class="text-center" style="font-size:14px" width="28%">Descripción</th>
          <th class="text-center" style="font-size:14px" width="5%">Fecha</th>
          <th class="text-center" style="font-size:14px" width="6%" title="Solicitado">Soli</th>
          <th class="text-center" width="6%" >Ult.&nbsp;Acción</th>
          <th class="text-center" width="6%" >Usuario</th>          
          <th class="text-center" style="font-size:14px" width="5%">Horas</th>
          <th class="text-center" style="font-size:14px" width="8%">Estado</th>
          <th  width="3%" class="no-content"></th>
        </tr>
      </thead>
      <tbody>
        <?php if ($id_nivel == 9) { ?>
          <?php foreach ($list_busqueda as $list) {
            if ($list['id_status_ticket'] != 99) {
              if ($sesion['id_usuario'] == $list['id_mantenimiento']) { ?>
                <tr class="even pointer">
                  <td class="text-center" ><?php echo $list['prioridad']; ?></td>
                  <?php if ($status == 7 || $status == 8) { ?>
                    <td class="text-center"><input required type="checkbox" id="id_ticket[]" name="id_ticket[]" value="<?php echo $list['id_ticket']; ?>"></td>
                  <?php } ?>
                  <?php if ($status == 7) { ?>
                    <td class="text-center" ><?php echo $list['nom_mes_revisado']; ?></td>  
                  <?php }?>
                  <td class="text-center" ><?php echo $list['cod_ticket']; ?></td>
                  <td class="text-center" ><?php echo $list['v_prioridad']; ?></td>
                  <td class="text-center"><?php echo $list['nom_tipo_ticket']; ?></td>
                  <td class="text-center" ><?php echo $list['cod_empresa']; ?></td>
                  <td class="text-left"><?php echo $list['proyecto']; ?></td>
                  <td class="text-left"><?php echo $list['subproyecto']; ?></td>
                  <td class="text-left"><?php echo substr($list['ticket_desc'], 0, 50); ?></td>
                  <td class="text-center"><?php echo $list['fecha_registro']; ?></td>
                  <td ><?php echo $list['cod_soli']; ?></td>
                  <td ><?php echo $list['fecha_registro_th']; ?></td>
                  <td ><?php echo $list['colaborador_codigo']; ?></td>
                  
                  <td class="text-center">
                    <?php 
                      if ($list['horas'] != 0 || $list['minutos'] != 0) {
                        if ($list['minutos'] == "0") {
                          $minuto = "00";
                        } else {
                          $minuto = $list['minutos'];
                        }
                        echo $list['horas'] . ":" . $minuto;
                      } 
                    ?>
                  </td>
                  <td><span class="badge" style="background:<?php echo $list['col_status']; ?>;"><?php echo $list['nom_status']; ?></span></td>

                  <td class="text-center" nowrap>
                    <a title="Más Información" href="<?= site_url('General/Historial_Ticket') ?>/<?php echo $list['id_ticket']; ?>/1">
                      <img title="Más Información" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
                    </a>
                  </td>
                </tr>
            <?php } } ?>
          <?php } ?>
        <?php }else{ ?>
          <?php foreach ($list_busqueda as $list) {
            if ($list['id_status_ticket'] != 99) { ?>
              <tr class="even pointer">
                <td class="text-center"><?php echo $list['prioridad']; ?></td>
                <?php if ($status == 7 || $status == 8 ) { ?>
                  <td class="text-center"><input required type="checkbox" id="id_ticket[]" name="id_ticket[]" value="<?php echo $list['id_ticket']; ?>"></td>
                <?php } ?>

                <?php if ($status == 7 ) { ?>
                  <td class="text-center"><?php echo $list['nom_mes_revisado']; ?></td>
                <?php } ?>
                <td class="text-center"><?php echo $list['cod_ticket']; ?></td>
                <td class="text-center"><?php echo $list['v_prioridad']; ?></td>
                <td class="text-center"><?php echo $list['nom_tipo_ticket']; ?></td>
                <td class="text-center"><?php echo $list['cod_empresa']; ?></td>
                <td class="text-left"><?php echo $list['proyecto']; ?></td>
                <td class="text-left"><?php echo $list['subproyecto']; ?></td>
                <td class="text-left"><?php echo substr($list['ticket_desc'], 0, 50); ?></td>
                <td class="text-center"><?php echo $list['fecha_registro']; ?></td>
                <td ><?php echo $list['cod_soli']; ?></td>
                <td ><?php echo $list['fecha_registro_th']; ?></td>
                <td ><?php echo $list['colaborador_codigo']; ?></td>
                                
                <td class="text-center">
                  <?php 
                    if ($list['horas'] != 0 || $list['minutos'] != 0) {
                      if ($list['minutos'] == "0") {
                        $minuto = "00";
                      } else {
                        $minuto = $list['minutos'];
                      }
                      echo $list['horas'] . ":" . $minuto;
                    } 
                  ?>
                </td>
                <td><span class="badge" style="background:<?php echo $list['col_status']; ?>;"><?php echo $list['nom_status']; ?></span></td>

                <td class="text-center" nowrap>
                  <a title="Más Información" href="<?= site_url('General/Historial_Ticket') ?>/<?php echo $list['id_ticket']; ?>/1">
                    <img title="Más Información" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
                  </a>
                </td>
              </tr>
            <?php } ?>
          <?php } ?>
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
                $(this).html('<input type="text" placeholder="Buscar '+title+'" />');
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
          var estado_a =$('#id_status').val();
          if (estado_a == 7) {
            var table = $('#example').DataTable( {
                order: [0,"asc"],
                orderCellsTop: true,
                fixedHeader: true,
                pageLength: 50,
                "aoColumnDefs" : [ 
                    {
                        'bSortable' : false,
                        'aTargets' : [ 1,16 ]
                    },
                    {
                        'targets' : [ 0 ],
                        'visible' : false
                    } 
                ]
            } );
          }
          else if (estado_a == 8) {
            var table = $('#example').DataTable( {
                order: [0,"asc"],
                orderCellsTop: true,
                fixedHeader: true,
                pageLength: 50,
                "aoColumnDefs" : [ 
                    {
                        'bSortable' : false,
                        'aTargets' : [ 1,15 ]
                    },
                    {
                        'targets' : [ 0 ],
                        'visible' : false
                    } 
                ]
            } );
          }
          else{
            var table = $('#example').DataTable( {
                order: [0,"asc"],
                orderCellsTop: true,
                fixedHeader: true,
                pageLength: 50,
                "aoColumnDefs" : [ 
                    {
                        'bSortable' : false,
                        'aTargets' : [ 14 ]
                    },
                    {
                        'targets' : [ 0 ],
                        'visible' : false
                    } 
                ]
            } );
          }
          var estado = $('#id_status').val();

          if (estado == 7) {
            $('#cancelados').show();
          } else {
            $('#cancelados').hide();
          }

          if (estado == 8) {
            $('#cancelar').show();
          } else {
            $('#cancelar').hide();
          }
      } );
    </script>
  <?php } ?>
</form>

<script>
function seleccionart() {
    if (document.getElementById('total').checked) {
        var inp = document.getElementsByTagName('input');
        for (var i = 0, l = inp.length; i < l; i++) {
          if (inp[i].type == 'checkbox' && inp[i].name.split('[]')[0] == 'id_ticket')
            inp[i].checked = 1;
        }
    } else {
        var inp = document.getElementsByTagName('input');
        for (var i = 0, l = inp.length; i < l; i++) {
          if (inp[i].type == 'checkbox' && inp[i].name.split('[]')[0] == 'id_ticket')
            inp[i].checked = 0;
        }
    }
}

function Completados() {
    var contador = 0;
    var contadorf = 0;

    $("input[type=checkbox]").each(function() {
        if ($(this).is(":checked"))
        contador++;
    });

    if (contador > 0 && document.getElementById('total').checked) {
        contadorf = contador - 1;
    } else {
        contadorf = contador;
    }

    if (contadorf > 0) {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_cancelados'));
        var url = "<?php echo site_url(); ?>General/Insert_Completados";

        $.ajax({
          url: url,
          data: dataString,
          type: "POST",
          processData: false,
          contentType: false,
          success: function(data) {
            swal.fire(
              'Actualización Exitosa!',
              'Haga clic en el botón!',
              'success'
            ).then(function() {
              Buscar(this,7);
            });
          }
        });
    } else {
        Swal(
            'Ups!',
            'Debe seleccionar al menos 1 registro.',
            'warning'
        ).then(function() { });
        return false;
    }
}

function Cancelados() {
    var contador = 0;
    var contadorf = 0;

    $("input[type=checkbox]").each(function() {
        if ($(this).is(":checked"))
        contador++;
    });

    if (contador > 0 && document.getElementById('total').checked) {
        contadorf = contador - 1;
    } else {
        contadorf = contador;
    }

    if (contadorf > 0) {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_cancelados'));
        var url = "<?php echo site_url(); ?>General/Insert_Cancelados";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                swal.fire(
                    'Actualización Exitosa!',
                    'Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Buscar(this,8);
                });
            }
        });
    } else {
        Swal(
            'Ups!',
            'Debe seleccionar al menos 1 registro.',
            'warning'
        ).then(function() { });
        return false;
    }
}
</script>

