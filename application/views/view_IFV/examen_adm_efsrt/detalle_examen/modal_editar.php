<form id="formularioe" method="POST" enctype="multipart/form-data"  class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Actualización de Pregunta </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class=" control-label text-bold">Orden: </label>
                <div class="col">
                    <input class="form-control" required type="text" id="ordene"  name="ordene" value="<?php echo $get_id[0]['orden'] ?>" />
                </div>
            </div>
            
            <div class="form-group col-md-12">
                <label class=" control-label text-bold">Pregunta:</label>
                <div class="col">
                    <textarea name="preguntae" rows="2" class="form-control" id="preguntae" ><?php echo $get_id[0]['pregunta'] ?></textarea>
                </div>
            </div>
                
            <div class="form-group col-md-12">
                <label class=" control-label text-bold">Alternativa&nbsp;1:</label>
                <div class="col">
                    <input name="id_respuesta1" type="hidden" class="form-control" id="id_respuesta1" value="<?php echo $get_id_respuesta[0]['id_respuesta']; ?>">
                    <input class="form-control" required type="text" id="alternativa1e" name="alternativa1e" value="<?php echo $get_id_respuesta[0]['desc_respuesta'] ?>" placeholder= "Ingresar Respuesta"  />
                </div>
            </div>

            <div class="form-group col-md-12">
                <label class=" control-label text-bold">Alternativa&nbsp;2:</label>
                <div class="col">
                    <input name="id_respuesta2" type="hidden" class="form-control" id="id_respuesta2" value="<?php echo $get_id_respuesta[1]['id_respuesta']; ?>">
                    <input class="form-control" required type="text" id="alternativa2e" name="alternativa2e" placeholder= "Ingresar Respuesta" value="<?php echo $get_id_respuesta[1]['desc_respuesta'] ?>" />
                </div>  
            </div>
            <div class="form-group col-md-12">
                <label class=" control-label text-bold">Alternativa&nbsp;3:</label>
                <div class="col">
                    <input name="id_respuesta3" type="hidden" class="form-control" id="id_respuesta3" value="<?php echo $get_id_respuesta[2]['id_respuesta']; ?>">
                    <input class="form-control" required type="text" id="alternativa3e" name="alternativa3e" placeholder= "Ingresar Respuesta" value="<?php echo $get_id_respuesta[2]['desc_respuesta'] ?>" />
                </div>
            </div>
            <!--<div class="form-group col-md-12">
                <label class=" control-label text-bold">Alternativa&nbsp;4:</label>
                <div class="col">
                    <input name="id_respuesta4" type="hidden" class="form-control" id="id_respuesta4" value="<?php echo $get_id_respuesta[3]['id_respuesta']; ?>">
                    <input class="form-control" required type="text" id="alternativa4" name="alternativa4" placeholder= "Ingresar Respuesta" value="<?php echo $get_id_respuesta[3]['desc_respuesta'] ?>" />
                </div>
            </div>-->
            
            <div class="form-group col-md-12">
                <label class=" control-label text-bold">Respuesta&nbsp;Correcta:</label>
                <div class="col">
                    <input name="id_respuesta5" type="hidden" class="form-control" id="id_respuesta5" value="<?php echo $get_id_respuesta[3]['id_respuesta']; ?>">
                    <input class="form-control" required type="text" id="alternativa5e" name="alternativa5e" placeholder= "Ingresar Respuesta" value="<?php echo $get_id_respuesta[3]['desc_respuesta'] ?>" />
                </div>
            </div>

            <div class="form-group col-md-6">
                <label class=" control-label text-bold">Seleccionar nuevo: </label>
                <div class="col">
                    <input name="imge" id="imge" type="file" class="file" onchange="return validarExt()" size="100" required data-allowed-file-extensions='["png"]'  >
                </div>
            </div>

            <div class="form-group col-md-6">
                <label class="col-sm-4 control-label text-bold">Imagen: 
                <?php if ($get_id[0]['img']!="") { ?>
                    <a style="cursor:pointer;" class="delete doc2_delete" type="button" id="delete_file" data-image_id="<?php echo $get_id[0]['id_pregunta']; ?>"  data-title="2">
                        <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                    </a> 
                <?php }?>
                </label>
                <div class="col imagen">
                    <?php if ($get_id[0]['img']!="") { ?>
                        <a href="<?php echo base_url().$get_id[0]['img']; ?> "size="100" target="_blank" ></a>
                    <div id="d_pdf" >
                        <iframe id="pdf" src="<?php echo base_url().$get_id[0]['img']; ?>" > </iframe>
                    </div>
                    <div id="pdf-main-container">
                        <div id="pdf-contents">
                        <canvas id="pdf-canvas"  height=10 0 width=195></canvas>
                            <div id="pdf-meta">
                            <div id="pdf-buttons">
                            </div>
                            </div> 
                        </div>
                    </div>
                    <?php } else { echo "No ha adjuntado ningún archivo"; } ?>
                </div>
            </div>
            
            <input type="hidden" name="img_1" id="img_1" class="form-control" value="<? echo $get_id[0]['img']; ?>">
        </div>
    </div> 
    <div class="modal-footer">
        <input name="id_pregunta" type="hidden" id="id_pregunta" value="<?php echo $get_id[0]['id_pregunta']; ?>">
        <input name="id_carrerae" type="hidden" id="id_carrerae" value="<?php echo $get_id[0]['id_carrera']; ?>">
        <input name="id_examene" type="hidden" id="id_examene" value="<?php echo $get_id[0]['id_examen']; ?>">
        <button type="button" class="btn btn-primary" id="createProductBtn">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
        
    </div>
</form>

<script>
    $("#createProductBtn").on('click', function(e){
        var dataString = new FormData(document.getElementById('formularioe'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Pregunta_Admision_Efsrt";
        var id_area = $('#id_area').val();
        var id_examen = $('#id_examen').val();
        if (valida_preguntae()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="cant"){
                        Swal({
                            title: 'Actualización Denegada',
                            text: "¡La carrera seleccionada llegó al límite de preguntas!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            'Actualización Exitosa!',
                            '',
                            'success'
                        ).then(function() {
                            $("#acceso_modal_mod .close").click();
                            List_Pregunta_Efsrt('<?php echo $get_id[0]['id_carrera']; ?>','<?php echo $get_id[0]['id_examen']; ?>');
                        });
                    }
                }
            });
        }

    });

    function valida_preguntae() {
        if($('#preguntae').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Pregunta.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    $(document).on('click', '#delete_file', function () {
      var image_id = $(this).data('image_id');
      //var file_down = $('#download_file');
      //var file_col = $('#delete_file');
      $.ajax({
          type: 'POST',
          url: '<?php echo site_url(); ?>AppIFV/Delete_Img_Pregunta_Efsrt',
          data: {'id_pregunta': image_id},
          success: function (data) {
            var file_col = $('.doc2_delete');
            var imagen = $('.imagen');
            file_col.remove();              
            imagen.remove();              
          }
      });
  });
</script>