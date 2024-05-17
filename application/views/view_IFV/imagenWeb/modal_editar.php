<form method="post" id="formulario_actu_web" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Editar Registro</h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Referencia&nbsp;: </label>
            </div>
            <div class="form-group col-md-6">
                <input maxlength="25" type="text" class="form-control" id="refe_comuimg" name="refe_comuimg" value="<?php echo $get_id[0]['refe_comuimg'] ?>" placeholder="Ingresar Referencia" autofocus>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Activo de&nbsp;: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="inicio_comuimg" name="inicio_comuimg" value="<?php echo $get_id[0]['inicio_comuimg'] ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Hasta&nbsp;: </label>
            </div>
            <div class="form-group col-sm-4">
                <input type="date" class="form-control" id="fin_comuimg" name="fin_comuimg" value="<?php echo $get_id[0]['fin_comuimg'] ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Archivo:</label>
                <input id="img_comuimg" name="img_comuimg" type="file" onchange="return validarExt()" size="100" required data-allowed-file-extensions='["jpg"]'>
                <span style="color:#867A82;">jpg/1920 x 1291</span>
            </div>

            <div class="form-group col-md-5">
                <?php if ($get_id[0]['img_comuimg'] != "") { ?>
                    <a href="<?php echo base_url() . $get_id[0]['img_comuimg']; ?> " size="100" target="_blank"></a>
                    <div id="d_pdf">
                        <iframe id="img2" name="img2" height="255" width="350" src="<?php echo base_url() . $get_id[0]['img_comuimg']; ?>"> </iframe>
                    </div>
                    <div id="pdf-main-container">
                        <div id="pdf-contents">
                            <canvas id="pdf-canvas" height="50" width="195"></canvas>
                            <div id="pdf-meta">
                                <div id="pdf-buttons">
                                </div>
                            </div>
                        </div>
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
            <div class="form-group col-sm-4">
                <select class="form-control" name="estado" id="estado">
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
        <input type="hidden" class="form-control" id="id_comuimg" name="id_comuimg" value="<?php echo $get_id[0]['id_comuimg'] ?>">
        <button id="btn_producto" name="btn_producto" type="button" class="btn btn-primary" data-loading-text="Loading..." autocomplete="off" onclick="Update_Web_Img()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Update_Web_Img() {
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
        var dataString = new FormData(document.getElementById('formulario_actu_web'));
        var url = "<?php echo site_url(); ?>AppIFV/Update_WebImg";
        if (valida_insert_webimg()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Su Imagen de Portada IFV se ha actualizado correctamente',
                        'ok',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>AppIFV/Imagen_Web";


                    });
                }
            });

        }
    }

    function valida_insert_webimg() {
        if ($('#refe_comuimg').val() === '') {
            Swal(
                'Ups!',
                'Debe Ingresar una Referencia.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#inicio_comuimg').val() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Fecha Inicio.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#fin_comuimg').val() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Fecha Fin.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#estado').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un Estado.',
                'warning'
            ).then(function() {});
            return false;
        }
        return true;
    }
</script>

<script type="text/javascript">
    function validarExt() {
        var archivoInput = document.getElementById('img_comuimg');
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.jpg)$/i;
        if (!extPermitidas.exec(archivoRuta)) {
            alert('Asegurese de haber seleccionado un archivo .jpg');
            archivoInput.value = '';
            return false;
        } else {
            if (archivoRuta.substr(-3) === "jpg") {
                let img = new Image()
                img.src = window.URL.createObjectURL(event.target.files[0])
                img.onload = () => {
                    if (img.width === 1920 && img.height == 1291) {
                        //alert(`Agradable, la imagen tiene el tamaño correcto. Se puede subir.`)
                        $("div.uno div.file-input div.input-group.file-caption-main div.file-caption.form-control.kv-fileinput-caption.icon-visible input.file-caption-name").css("visibility", "visible");
                        $("div.uno div.file-input div.input-group.file-caption-main div.file-caption.form-control.kv-fileinput-caption.icon-visible input.file-caption-name").css("opacity", "1");
                        $("div.uno div.file-input div.file-preview div.file-drop-zone div.file-preview-thumbnails div.file-preview-frame.krajee-default.kv-preview-thumb").css("visibility", "visible");

                        // upload logic here
                    } else {
                        alert(`Lo sentimos, esta imagen de ${img.width} x ${img.height} de tamaño no se parece a lo que se pide. Se requiere que el tamaño sea 1920 x 1291.`);
                        // $("img.file-preview-image.kv-preview-data").attr("src", "");
                        // $("img.file-preview-image.kv-preview-data").attr("alt", "");
                        // $("img.file-preview-image.kv-preview-data").attr("title", "");
                        // $("img.file-preview-image.kv-preview-data").css("visibility", "hidden");
                        // $("img.file-preview-image.kv-preview-data").css("opacity", "0");
                        // $('div.file-caption-info').empty();
                        // $('div.file-size-info').empty();
                        //$('div.uno div.file-input div.input-group.file-caption-main div.file-caption.form-control.kv-fileinput-caption.icon-visible input.file-caption-name').attr("title", "");
                        // $("div.uno div.file-input div.input-group.file-caption-main div.file-caption.form-control.kv-fileinput-caption.icon-visible input.file-caption-name").val("");
                        $("div.uno div.file-input div.file-preview div.file-drop-zone div.file-preview-thumbnails div.file-preview-frame.krajee-default.kv-preview-thumb").css("visibility", "hidden");
                        $("div.uno div.file-input div.input-group.file-caption-main div.file-caption.form-control.kv-fileinput-caption.icon-visible input.file-caption-name").css("visibility", "hidden");
                        $("div.uno div.file-input div.input-group.file-caption-main div.file-caption.form-control.kv-fileinput-caption.icon-visible input.file-caption-name").css("opacity", "0");
                        $("div.uno input#img_comuimg").val("");
                    }
                }
            } else {

            }
        }
    }
</script>