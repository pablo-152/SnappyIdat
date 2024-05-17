<form id="formulario_update_fut"  method="POST" enctype="multipart/form-data" class="formulario">
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h5 class="modal-title"><b>Actualizar Historial del Fut</b></h5>
  </div>

  <div class="modal-body" style="max-height:600px; overflow:auto;">
    <div class="col-md-12 row">
      <!--
      <div class="form-group col-md-4">
        <label class="text-bold">Fecha</label>
        <div class="col">
          <input type="date" class="form-control" id="fecha_accion_i" name="fecha_accion_i" value="<?php echo date('Y-m-d'); ?>" onkeypress="if(event.keyCode == 13){ Insert_Historial(); }">
        </div>
      </div>
      -->

      <div class="form-group col-md-4">
        <label class="control-label text-bold">Estado:</label>
        <div class="col">
          
          <select class="form-control" id="id_estado_e" name="id_estado_e">
            <option value="0" >Seleccione</option>
            <?php foreach($list_estados as $list){ ?>
              <option value="<?php echo $list['id_status_general']; ?>" <?php if($get_id[0]['estado_envio_det']==$list['id_status_general']){ echo "selected"; } ?>>
                  <?php echo $list['nom_status'];?>
            <?php } ?>
          </select>
        </div> 
      </div>     
      
      
      <!--
    
        <div class="form-group col-md-8">
          <label class="text-bold">Comentario</label>
          <div class="col">
              <input type="text" class="form-control" id="comentario1_i" name="comentario1_i" value="<?php echo $get_id[0]['observ_envio_det']; ?>" placeholder="Comentario" maxlength="35" readonly>
          </div>
        </div>
    

            -->
      <div class="form-group col-md-12">
        <label class="text-bold">Observaciones:</label>
        <div class="col">
          <textarea class="form-control" id="observacion_e" name="observacion_e" rows="5" placeholder="Observaciones"><?php echo $get_id[0]['observ_envio_det']; ?></textarea>
        </div>
      </div>


      <div class="form-group col-md-3">
        <label class="control-label text-bold">Archivo: </label>
        <div class="col">
            <button type="button" onclick="Abrir('img_comuimge')">Seleccionar archivo</button>
            <input type="file" id="img_comuimge" name="img_comuimge" onchange="Nombre_Archivo(this,'span_documento')" style="display: none">
            <span id="span_documento"><?php if($get_id[0]['pdf_envio_det']!=""){ echo str_replace("imgfut_snappy/","",$get_id[0]['pdf_envio_det']); }else{ echo "No se eligió archivo"; } ?></span>
        </div>
      </div>
      <!--
      <div class="form-group col-md-4">
        <label class="control-label text-bold">Tipo:</label>
        <div class="col">
          <select class="form-control" id="id_tipo_i" name="id_tipo_i">
            <option value="0" >Seleccione</option>
            <?php foreach($list_informe as $list){ ?>
                <option value="<?php echo $list['id_informe']; ?>" <?php if($get_id[0]['id_informe']==$list['id_informe']){ echo "selected"; } ?>>
                  <?php echo $list['nom_informe'];?>
                </option>
            <?php } ?>
          </select>
        </div> 
      </div>    

      <div class="form-group col-md-4">
        <label class="text-bold">Acción:</label>
        <div class="col">
          <?php if($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
            <select name="id_accion_i" id="id_accion_i" class="form-control" onchange="Status()">
              <option value="0">Seleccione</option>
              <?php foreach($list_accion as $list){ ?>
                  <option value="<?php echo $list['id_accion']; ?>"><?php echo $list['nom_accion'];?></option>
              <?php } ?>
            </select>
          <?php }else{ ?>
            <select name="id_accion_i" id="id_accion_i" class="form-control" onchange="Status()">
              <option value="0">Seleccione</option>
              <?php foreach($list_accion as $list){ if($list['id_accion']!=11){ ?>
                  <option value="<?php echo $list['id_accion']; ?>"><?php echo $list['nom_accion'];?></option>
              <?php }} ?>
            </select>
          <?php } ?>
        </div> -->
      </div>

                          
  </div>

  <div class="modal-footer">
    <input type="hidden" id="id_envio" name="id_envio" value="<?php echo $get_id[0]['id_envio']; ?>">
    <input type="hidden" id="id_envio_det" name="id_envio_det" value="<?php echo $get_id[0]['id_envio_det']; ?>">
    <button type="button" onclick="Update_Detalle_Fut();" class="btn btn-primary"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button>
  </div>
</form>

<script>
  /*function Status(){
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

    var url = "<?php echo site_url(); ?>Administrador/Cambia_Status";
    var id_accion = $('#id_accion_i').val();
    var mailing = $('#mailing').val();

    $.ajax({
      url: url,
      type: 'POST',
      data: {'id_accion':id_accion,'mailing':mailing},
      success: function(data){
        $('#mstatus_i').html(data);
      }
    });
  }*/
  function Abrir(id) {
        var file = document.getElementById(id);
        file.dispatchEvent(new MouseEvent('click', {
            view: window,
            bubbles: true,
            cancelable: true
        }));
  }

    function Nombre_Archivo(element,glosa) {
        var glosa = document.getElementById(glosa);

        if(element=="") {
            glosa.innerText = "No se eligió archivo";
        } else {
            if(element.files[0].name.substr(-3)=='pdf' || element.files[0].name.substr(-3)=='PDF'){
              var archivoInput = document.getElementById('img_comuimge');
              var archivoRuta = archivoInput.value;
              var extPermitidas = /(.pdf)$/i;
              if (!extPermitidas.exec(archivoRuta)) {
                  swal({
                      title: 'Solo se aceptan documentos PDF',
                      text: 'Asegurese de haber seleccionado un archivo .pdf',
                      animation: true,
                      customClass: 'animated tada',
                      padding: '2em'
                  });
                  //alert('Asegurese de haber seleccionado un archivo .pdf');
                  archivoInput.value = '';
                  return false;
              } 

              const fileInput = document.getElementById('img_comuimge');
              const file = fileInput.files[0];

              const fileSize = file.size;
              const fileSizeMB = (fileSize / (1024 * 1024)).toFixed(2);

              if(fileSizeMB > 3){
                  swal({
                      title: 'Documentos PDF muy pesado',
                      text: 'Su documento en PDF superó el máximo de 3 MB.',
                      animation: true,
                      customClass: 'animated tada',
                      padding: '2em'
                  });
                  fileInput.value ='';
                  return false;
              }
              glosa.innerText = element.files[0].name;
            }else{
                Swal({
                    title: 'Registro Denegado',
                    text: "Asegurese de ingresar foto con extensiones .pdf",
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
                archivoInput.value = '';
                return false;
            }
        }
    }


  function Update_Detalle_Fut(){
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

    var id_envio = $("#id_envio").val();
    var dataString = new FormData(document.getElementById('formulario_update_fut'));
    //var dataString = $("#formulario_update_fut").serialize();
    var url="<?php echo site_url(); ?>AppIFV/Update_Detalle_Fut";

    if (Valida_Update_Detalle_Fut()) {
      $.ajax({
          type:"POST",
          url:url,
          data:dataString,
          processData: false,
          contentType: false,
          success:function (data) {
            if(data=="error"){
              Swal({
                  title: 'Registro Denegado',
                  text: "¡Existe un registro con el mismo estado!",
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
                  window.location = "<?php echo site_url(); ?>AppIFV/Historial_Fut_Recibido/"+id_envio;
              });
            }
          }
      });
    }
  }

  function Valida_Update_Detalle_Fut() {
    if($('#id_estado_e').val()=="0"){
      Swal(
          'Ups!',
          'Debe seleccionar un estado.',
          'warning'
      ).then(function() { });
      return false;
    }
    
    return true;
  }
</script>

   




