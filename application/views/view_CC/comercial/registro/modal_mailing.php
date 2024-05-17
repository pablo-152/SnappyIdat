<form id="formulario_mailing"  method="POST" enctype="multipart/form-data" class="formulario">
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h5 class="modal-title"><b>Mailing (Nuevo)</b></h5>
  </div>

  <div class="modal-body" style="max-height:600px; overflow:auto;">
    <div class="col-md-12 row">
      <div class="form-group col-md-4">
        <label class="text-bold">Fecha Envío</label>
        <div class="col">
          <input type="date" class="form-control" id="fecha_envio_m" name="fecha_envio_m" value="<?php echo date('Y-m-d'); ?>" onkeypress="if(event.keyCode == 13){ Insert_Registro_Mail_Mailing(); }">
        </div>
      </div>

      <div class="form-group col-md-4">
          <label class="control-label text-bold">Archivo: </label>
          <a href="<?= site_url('CursosCortos/Plantilla_Mailing') ?>" title="Estructura de Excel">
              <img src="<?= base_url() ?>template/img/excel_tabla.png" alt="Exportar Excel"/>
          </a>
          <input type="file" id="archivo_m" name="archivo_m" data-allowed-file-extensions='["xls|xlsx"]' size="100" required>
      </div>
      
      <div class="form-group col-md-12">
        <label class="text-bold">Observaciones:</label>
        <div class="col">
          <textarea class="form-control" id="observacion_m" name="observacion_m" rows="5" placeholder="Observaciones"></textarea>
        </div>
      </div>                       
  </div>

  <div class="modal-footer">
    <button type="button" onclick="Insert_Registro_Mail_Mailing();" class="btn btn-primary">Enviado</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
  </div>
</form>

<script>
  function Insert_Registro_Mail_Mailing(){
    $(document)
    .ajaxStart(function () {
        $.blockUI({
            message: '<svg> ... </svg>',
            fadeIn: 800,
            overlayCSS: {
                backgroundColor: '#1b2024',
                opacity: 0.8,
                zIndex: 1200,
                cursor: 'wait'
            },
            css: {
                border: 0,
                color: '#fff',
                zIndex: 1201,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });
    })
    .ajaxStop(function () {
        $.blockUI({
            message: '<svg> ... </svg>',
            fadeIn: 800,
            timeout: 100,
            overlayCSS: {
                backgroundColor: '#1b2024',
                opacity: 0.8,
                zIndex: 1200,
                cursor: 'wait'
            },
            css: {
                border: 0,
                color: '#fff',
                zIndex: 1201,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });
    });

    var dataString = new FormData(document.getElementById('formulario_mailing'));
    var url="<?php echo site_url(); ?>CursosCortos/Insert_Registro_Mail_Mailing";

    if (Valida_Insert_Registro_Mail_Mailing()) {
      $.ajax({
          url: url,
          data:dataString,
          type:"POST",
          processData: false,
          contentType: false,
          success:function (data) {
            if(data=="error"){
              Swal({
                  title: 'Registro Denegado',
                  text: "¡No hay datos en el Excel!",
                  type: 'error',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'OK',
              });
            }else{
              swal.fire(
                  'Registro Exitoso!',
                  'Haga clic en el botón!',
                  'success'
              ).then(function() {
                  window.location = "<?php echo site_url(); ?>CursosCortos/Registro";
              });
            }
          }
      });
    }
  }

  function Valida_Insert_Registro_Mail_Mailing() {
    if($('#fecha_envio_m').val().trim() === ""){
      Swal(
          'Ups!',
          'Debe ingresar Fecha Envío.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#archivo_m').val().trim() === ""){
      Swal(
          'Ups!',
          'Debe seleccionar Archivo.',
          'warning'
      ).then(function() { });
      return false;
    }
    return true;
  }
</script>

   




