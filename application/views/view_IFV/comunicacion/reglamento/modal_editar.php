<form method="post" id="formulario_update_pdf" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Editar Reglamento Interno</h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Referencia&nbsp;: </label>
            </div>
            <div class="form-group col-md-6">
                <input maxlength="25" type="text" class="form-control" id="referenciae" name="referenciae" value="<?php echo $get_id[0]['refe_comuimg'] ?>" placeholder="Ingresar Referencia" autofocus>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Activo de&nbsp;: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="inicioe" name="inicioe" value="<?php echo $get_id[0]['inicio_comuimg'] ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Hasta&nbsp;: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fine" name="fine" value="<?php echo $get_id[0]['fin_comuimg'] ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Archivo:</label>
                <input id="archivoe" name="archivoe" type="file" size="100" required data-allowed-file-extensions='["pdf|PDF"]'>
                <span style="color:#867A82;">PDF/Maximo 2Mb ó 2048kl</span>
            </div>


            <div class="form-group col-md-6">
                <label class="control-label text-bold">Archivo:</label>
                <?php if ($get_id[0]['img_comuimg'] != "") { ?>
                    <div id="i_<?php echo  $get_id[0]['id_comuimg'] ?>" >
                        <?php 
                        /*echo'<div id="lista_escogida"><embed loading="lazy" src="'. base_url() . $get_id[0]['img_comuimg'] . '" width="100%" height="150px" /></div>';*/
                        ?>
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
                <select class="form-control" name="estadoe" id="estadoe">
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
        <button id="btn_producto" name="btn_producto" type="button" class="btn btn-primary" data-loading-text="Loading..." autocomplete="off" onclick="update_Comu_Img();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function update_Comu_Img() {
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
        var url = "<?php echo site_url(); ?>AppIFV/Update_Reglamento";
        if (valida_insert_comuimg()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Su PDF Reglamento Interno se ha actualizado correctamente',
                        '',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>AppIFV/PDF_Reglamento";
                    });
                }
            });

        }
    }

    function valida_insert_comuimg() {
        if ($('#referenciae').val() === '') {
            Swal(
                'Ups!',
                'Debe Ingresar una Referencia.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#inicioe').val() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Fecha Inicio.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#fine').val() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Fecha Fin.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#estadoe').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un Estado.',
                'warning'
            ).then(function() {});
            return false;
        }
        return true;
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