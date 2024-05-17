
    <form id="formulario" method="POST" enctype="multipart/form-data"  class="formulario">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualización de Pregunta </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body" style="max-height:450px; overflow:auto;">
            <div class="col-md-12 row">
                <!--<div class="form-group col-md-6">
                    <label class=" control-label text-bold">Carrera: </label>
                    <div class="col">
                        <?php echo $get_id[0]['nombre_carrera'] ?>
                    </div>
                </div>

                

                <div class="form-group col-md-6">
                    <label class=" control-label text-bold">Área: </label>
                    <div class="col">
                        <?php echo $get_id[0]['nombre_area'] ?>
                    </div>
                </div>-->

                
                
                <div class="form-group col-md-6">
                    <label class=" control-label text-bold">Orden: </label>
                    <div class="col">
                        <input class="form-control" required type="text" id="orden"  name="orden" value="<?php echo $get_id[0]['orden'] ?>" />
                    </div>
                </div>
                

                <div class="form-group col-md-12">
                    <label class=" control-label text-bold">Pregunta:</label>
                    <div class="col">
                        <textarea name="pregunta" rows="5" class="form-control" id="pregunta" ><?php echo $get_id[0]['pregunta'] ?></textarea>
                    </div>
                </div>
                    
                <div class="form-group col-md-12">
                    <label class=" control-label text-bold">Alternativa&nbsp;1:</label>
                    <div class="col">
                        <input name="id_respuesta1" type="hidden" class="form-control" id="id_respuesta1" value="<?php echo $get_id_respuesta[0]['id_respuesta']; ?>">
                        <input class="form-control" required type="text" id="alternativa1" name="alternativa1" value="<?php echo $get_id_respuesta[0]['desc_respuesta'] ?>" placeholder= "Ingresar Respuesta"  />
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label class=" control-label text-bold">Alternativa&nbsp;2:</label>
                    <div class="col">
                        <input name="id_respuesta2" type="hidden" class="form-control" id="id_respuesta2" value="<?php echo $get_id_respuesta[1]['id_respuesta']; ?>">
                        <input class="form-control" required type="text" id="alternativa2" name="alternativa2" placeholder= "Ingresar Respuesta" value="<?php echo $get_id_respuesta[1]['desc_respuesta'] ?>" />
                    </div>  
                </div>
                <div class="form-group col-md-12">
                    <label class=" control-label text-bold">Alternativa&nbsp;3:</label>
                    <div class="col">
                        <input name="id_respuesta3" type="hidden" class="form-control" id="id_respuesta3" value="<?php echo $get_id_respuesta[2]['id_respuesta']; ?>">
                        <input class="form-control" required type="text" id="alternativa3" name="alternativa3" placeholder= "Ingresar Respuesta" value="<?php echo $get_id_respuesta[2]['desc_respuesta'] ?>" />
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class=" control-label text-bold">Alternativa&nbsp;4:</label>
                    <div class="col">
                        <input name="id_respuesta4" type="hidden" class="form-control" id="id_respuesta4" value="<?php echo $get_id_respuesta[3]['id_respuesta']; ?>">
                        <input class="form-control" required type="text" id="alternativa4" name="alternativa4" placeholder= "Ingresar Respuesta" value="<?php echo $get_id_respuesta[3]['desc_respuesta'] ?>" />
                    </div>
                </div>
                
                <div class="form-group col-md-12">
                    <label class=" control-label text-bold">Respuesta&nbsp;Correcta:</label>
                    <div class="col">
                        <input name="id_respuesta5" type="hidden" class="form-control" id="id_respuesta5" value="<?php echo $get_id_respuesta[4]['id_respuesta']; ?>">
                        <input class="form-control" required type="text" id="alternativa5" name="alternativa5" placeholder= "Ingresar Respuesta" value="<?php echo $get_id_respuesta[4]['desc_respuesta'] ?>" />
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label class=" control-label text-bold">Seleccionar nuevo: </label>
                    <div class="col">
                        <input name="img" id="img" type="file" class="file" onchange="return validarExt()" size="100" required data-allowed-file-extensions='["png"]'  >
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label class="col-sm-4 control-label text-bold">Imagen: </label>
                    <div class="col">
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
            <input name="id_pregunta" type="hidden" class="form-control" id="id_pregunta" value="<?php echo $get_id[0]['id_pregunta']; ?>">
            <input name="id_area" type="hidden" class="form-control" id="id_area" value="<?php echo $id_area; ?>">
            <input name="id_examen" type="hidden" class="form-control" id="id_examen" value="<?php echo $id_examen; ?>">
            <button type="button" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..." autocomplete="off">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
            </button>
            
        </div>
    </form>

<script src="<?= base_url() ?>template/fileinput/js/fileinput.min.js"></script>

<script>
    $("#createProductBtn").on('click', function(e){
        var dataString2 = new FormData(document.getElementById('formulario'));
        var url2="<?php echo site_url(); ?>AppIFV/Update_Pregunta_Admision";
        var id_area = $('#id_area').val();
        var id_examen = $('#id_examen').val();
        if (valida_pregunta()) {
            bootbox.confirm({
                title: "Actualizar Pregunta",
                message: "¿Desea ctualizar datos de pregunta?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                        if (result==false) 
                        {

                        }else
                        {
                            $.ajax({
                                        type:"POST",
                                        url: url2,
                                        data:dataString2,
                                        processData: false,
                                        contentType: false,
                                        success:function () {
                                            swal.fire(
                                                'Actualización Exitosa!',
                                                '',
                                                'success'
                                            ).then(function() {
                                                window.location = "<?php echo site_url(); ?>AppIFV/Preguntas/"+id_area+"/"+id_examen;
                                                
                                            });
                                        }
                                    });
                        }
                } 
            });        }

    });

    function valida_pregunta() {
        /*if($('#nombres').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombres.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        return true;
    }
</script>