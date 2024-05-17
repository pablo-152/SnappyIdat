<form  method="post" id="formularioxls" enctype="multipart/form-data" action="<?= site_url('Administrador/Excel_Mailing')?>" class="formulario">
  <input type="hidden" name="parametro" id="parametro" value="<?php echo $parametro; ?> ">
</form>

<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
  <table id="example" class="table table-hover table-striped table-bordered" width="100%">
    <thead>
      <tr style="background-color: #E5E5E5;">
        <th class="text-center" width="3%"><input type="checkbox" id="total" name="total" onclick="seleccionart();" value="1"></th>
        <th class="text-center" width="4%" title="Referencia">Ref</th>
        <th class="text-center" width="5%">Tipo</th>
        <th class="text-center" width="5%" title="Fecha Contacto">Fec&nbsp;Cont</th>
        <th class="text-center" width="27%" title="Nombres y Apellidos">Nom&nbsp;y&nbsp;Ape</th>
        <th class="text-center" width="8%">Acción</th>
        <th class="text-center" width="3%" title="Empresa">Emp</th>
        <th class="text-center" width="35%">Mensaje</th>
        <th class="text-center" width="10%">Status</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($list_registro as $list) {  ?>
        <tr class="even pointer">
          <td class="text-center"><input required type="checkbox" id="id_registro[]" name="id_registro[]" value="<?php echo $list['id_registro']; ?>"></td>
          <td class="text-center"><?php echo $list['cod_registro']; ?></td>
          <td class="text-center"><?php echo $list['nom_informe']; ?></td>
          <td class="text-center"><?php echo $list['fec_inicial']; ?></td>
          <td><?php echo substr($list['nombres_apellidos'],0,30); ?></td>
          <td><?php echo $list['nom_accion']; ?></td>
          <td class="text-center"><?php echo $list['cod_empresa']; ?></td>
          <td><?php echo substr($list['mensaje'],0,75); ?></td>
          <td><?php echo $list['nom_status']; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <div id="registro_mailing" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5 style="color: #000000;">Mailing (Nuevo)</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>

        <div class="modal-body" style="overflow:auto;">
            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label>Fecha Envío: </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="date" class="form-control" id="fecha_envio" name="fecha_envio" value="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="form-group col-md-12">
                    <label>Observaciones: </label>
                    <textarea class="form-control" id="observaciones" name="observaciones" rows="5"></textarea>  
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" id="btn_insert_mailing" class="btn btn-success">Guardar</button>&nbsp;&nbsp;
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
  $("#btn_asignar").on('click', function(e){
    var contador=0;
    var contadorf=0;

    $("input[type=checkbox]").each(function(){
      if($(this).is(":checked"))
      contador++;
    }); 

    if(contador>0 && document.getElementById('total').checked){
      contadorf=contador-1;
    }else{
      contadorf=contador;
    }
    
    if(contadorf>0){
      $('#registro_mailing').modal('show');    
    }else{
      Swal(
          'Ups!',
          'Debe seleccionar al menos 1 registro.',
          'warning'
      ).then(function() { });
      return false;
    }
  });

  function seleccionart(){
    if (document.getElementById('total').checked){
      var inp=document.getElementsByTagName('input');
      for(var i=0, l=inp.length;i<l;i++){
        if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='id_registro')
        inp[i].checked=1;
      }
    }else{
      var inp=document.getElementsByTagName('input');
      for(var i=0, l=inp.length;i<l;i++){
        if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='id_registro')
          inp[i].checked=0;
      }
    }
  }

  $("#btn_insert_mailing").on('click', function(e){
    var contador=0;
    var contadorf=0;

    $("input[type=checkbox]").each(function(){
      if($(this).is(":checked"))
      contador++;
    }); 

    if(contador>0 && document.getElementById('total').checked){
      contadorf=contador-1;
    }else{
      contadorf=contador;
    }
    
    var url = "<?php echo site_url(); ?>Administrador/Insert_Mailing";

    var dataString2 = new FormData(document.getElementById('formulario'));
    var url2="<?php echo site_url(); ?>Administrador/Insert_Mailing";

    if (Valida_Mailing()) {
      bootbox.confirm({
          title: "Asignar Mailing",
          message: "¿Desea asignar "+contadorf+" registro(s)?",
          buttons: {
              cancel: {
                  label: 'Cancelar'
              },
              confirm: {
                  label: 'Confirmar'
              }
          },
          callback: function (result) {
            if (result) {
              $.ajax({
                  type:"POST",
                  url: url2,
                  data:dataString2,
                  processData: false,
                  contentType: false,
                  success:function () {
                      swal.fire(
                          'Asignación Exitosa!',
                          '',
                          'success'
                      ).then(function() {
                          window.location = "<?php echo site_url(); ?>Administrador/Mailing";
                          
                      });
                  }
              });
            }
          } 
      });             
    }
  });

  function Valida_Mailing() {
    if($('#fecha_envio').val().trim() === '') {
      Swal(
          'Ups!',
          'Debe ingresar Fecha Envío.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#observaciones').val().trim() === '') {
      Swal(
          'Ups!',
          'Debe ingresar Observaciones.',
          'warning'
      ).then(function() { });
      return false;
    }
    return true;
  }
</script>

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
          ordering: false,
          orderCellsTop: true,
          fixedHeader: true,
          pageLength: 50
        });
  } );
</script>
  
