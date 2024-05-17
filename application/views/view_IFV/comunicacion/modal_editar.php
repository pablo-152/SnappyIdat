<form method="post" id="formulario_update_pdf" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Editar Registro</h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Tipo: </label>
                <div class="col">
                    <select class="form-control" name="flag_referencia_u" id="flag_referencia_u" onchange="Flag_Referencia_U()">
                        <option value="">Seleccione</option>
                        <option value="0" <?php if($get_id[0]['flag_referencia']==0){echo "selected";} ?>>Resultados IFV</option>
                        <option value="1" <?php if($get_id[0]['flag_referencia']==1){echo "selected";} ?>>Triptico</option>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-6" id="div_triptico_u" style="display:<?php if($get_id[0]['flag_referencia']==1){echo "block";}else{echo "none";}?>">
                <label class="control-label text-bold">Carrera: </label>
                <div class="col">
                    <select class="form-control" name="id_carrera_u" id="id_carrera_u" >
                        <option value="0">Seleccione</option>
                        <?php foreach($list_carrera as $list){?> 
                            <option value="<?php echo $list['id_carrera'] ?>" <?php if($get_id[0]['cod_referencia']==$list['id_carrera']){echo "selected";}?>><?php echo $list['nombre'] ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-6" id="div_otro_u" style="display:<?php if($get_id[0]['flag_referencia']==0){echo "block";}else{echo "none";}?>">
                <label class="control-label text-bold">Referencia: </label>
                <div class="col">
                    <input maxlength="25" type="text" class="form-control" id="refe_comuimg_u" name="refe_comuimg_u" value="<?php echo $get_id[0]['refe_comuimg'] ?>" placeholder="Ingresar Referencia">
                </div>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Activo de&nbsp;: </label>
                <div class="col">
                    <input type="date" class="form-control" id="inicio_comuimg_u" name="inicio_comuimg_u" value="<?php echo $get_id[0]['inicio_comuimg'] ?>">
                </div>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Hasta&nbsp;: </label>
                <div class="col">
                    <input type="date" class="form-control" id="fin_comuimg_u" name="fin_comuimg_u" value="<?php echo $get_id[0]['fin_comuimg'] ?>">
                </div>
            </div>
            
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Archivo:</label>
                <input id="img_comuimg_u" name="img_comuimg_u" type="file" size="100" required data-allowed-file-extensions='["pdf|PDF"]'>
                <span style="color:#867A82;">IMG/PDF/Maximo 2Mb ó 2048kl</span>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Archivo:</label>
                <?php if ($get_id[0]['img_comuimg'] != "") { ?>
                    <div id="i_<?php echo  $get_id[0]['id_comuimg'] ?>" >
                        <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $get_id[0]['id_comuimg'] ?>">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png" style="cursor:pointer; cursor: hand;"/>
                        </a>
                        <a style="cursor:pointer;" class="delete" type="button" id="delete_file" data-image_id="<?php echo  $get_id[0]['id_comuimg'] ?>">
                            <img src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"/>
                        </a>
                    </div>
                <?php } else {
                    echo "No ha adjuntado ningún archivo";
                } ?>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado&nbsp;: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado_u" id="estado_u">
                    <option value="0">Seleccionar</option>
                    <?php foreach ($list_statusva as $list) {
                        if ($get_id[0]['estado'] == $list['id_statusav']) { ?>
                            <option selected value="<?php echo $list['id_statusav']; ?>"><?php echo $list['nom_status']; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $list['id_statusav']; ?>"><?php echo $list['nom_status']; ?></option>
                    <?php }
                    } ?>
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_comuimg" name="id_comuimg" value="<?php echo $get_id[0]['id_comuimg']; ?>">
        <input type="hidden" id="archivo_actual" name="archivo_actual" value="<?php echo $get_id[0]['img_comuimg']; ?>">
        <button id="btn_producto" name="btn_producto" type="button" class="btn btn-primary" onclick="Update_Comu_Img();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Update_Comu_Img() {
        $(document)
        .ajaxStart(function() {
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
        .ajaxStop(function() {
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

        var dataString = new FormData(document.getElementById('formulario_update_pdf'));
        var url = "<?php echo site_url(); ?>AppIFV/Update_ComuImg";
        
        if (Valida_Update_Comu_Img()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    if(data=="error"){
                        swal.fire(
                            'Actualización Denegada',
                            'Existe un registro que coincide con las fechas de publicación ingresada, por favor verificar!',
                            'error'
                        ).then(function() {
                            
                        });
                    }else{
                        swal.fire(
                            'Actualización Exitosa',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>AppIFV/PDF_Admision";
                        });  
                    }
                }
            });
        }
    }

    function Valida_Update_Comu_Img() {
        if ($('#flag_referencia_u').val() === '') {
            Swal(
                'Ups!',
                'Debe Seleccionar Tipo.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#flag_referencia_u').val() === '1') {
            if ($('#id_carrera_u').val() === '0') {
                Swal(
                    'Ups!',
                    'Debe Seleccionar Carrera.',
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        if ($('#flag_referencia_u').val() === '0') {
            if ($('#refe_comuimg_u').val().trim() === '') {
                Swal(
                    'Ups!',
                    'Debe Ingresar Referencia.',
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        if ($('#inicio_comuimg_u').val() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Fecha Inicio.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#fin_comuimg_u').val() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Fecha Fin.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#estado_u').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un Estado.',
                'warning'
            ).then(function() {});
            return false;
        }
        return true;
    }

    function Flag_Referencia_U(){
        var div1 = document.getElementById("div_triptico_u");
        var div2 = document.getElementById("div_otro_u");
        $('#id_carrera_u').val('0');
        $('#refe_comuimg_u').val('');
        if($('#flag_referencia_u').val()!=""){
            if($('#flag_referencia_u').val()=="1"){
                div1.style.display = "block";
                div2.style.display = "none";
                
            }
            if($('#flag_referencia_u').val()=="0"){
                div1.style.display = "none";
                div2.style.display = "block";
            }
        }else{
            div1.style.display = "none";
            div2.style.display = "none";
        }
    }

    $(".img_post").click(function () {
        window.open($(this).attr("src"), 'popUpWindow', 
        "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
    });

    $(document).on('click', '#download_file', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_Archivo/" + image_id);
    });

    $(document).on('click', '#delete_file', function () {
        var image_id = $(this).data('image_id');
        var file_col = $('#i_' + image_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>AppIFV/Delete_Archivo',
            data: {'image_id': image_id},
            success: function (data) {
                file_col.remove();            
            }
        });
    });
</script>