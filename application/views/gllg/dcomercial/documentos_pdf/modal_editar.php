<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">

<form method="post" id="formulario_update" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Documentos PDF (Editar)</h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;"> 
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Ref: </label> 
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="referencia_u" name="referencia_u" placeholder="Ingresar Referencia" value="<?php echo $get_id[0]['referencia']; ?>" onkeypress="if(event.keyCode == 13){ Update_Documentos_PDF(); }">
            </div>
        </div>
        
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre&nbsp;: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="nombre_documento_pdf_u" name="nombre_documento_pdf_u" value="<?php echo $get_id[0]['nombre_documento_pdf'] ?>" placeholder="Ingresar Nombre" onkeypress="if(event.keyCode == 13){ Update_Documentos_PDF(); }">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Link&nbsp;: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="link_documento_pdf_u" name="link_documento_pdf_u" value="<?php echo $get_id[0]['link_documento_pdf'] ?>" placeholder="Ingresar Link" onkeypress="if(event.keyCode == 13){ Update_Documentos_PDF(); }">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Empresa:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_empresa_u" name="id_empresa_u" onchange="Buscar_Sede_Update()">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_empresas as $list){ ?>
                        <option value="<?php echo $list['id_empresa']; ?>" <?php if($list['id_empresa']==$get_id[0]['id_empresa']){ echo "selected"; } ?>>
                            <?php echo $list['cod_empresa']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Sede:</label>
            </div>
            <div id="select_sede_u" class="form-group col-md-4">
                <select class="form-control" name="id_sede_u" id="id_sede_u">
                    <option value="0" selected>Seleccione</option>
                    <?php foreach($list_sede1 as $list){ ?>
                        <option value="<?php echo $list['id_sede']; ?>" <?php if($list['id_sede']==$get_id[0]['id_sede']){ echo "selected"; } ?>>
                            <?php echo $list['cod_sede']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Archivo:</label>
            </div>
            <div class="form-group col-md-6">
                <input type="file" id="documento_pdf_u" name="documento_pdf_u" onchange="Validar_Extension_Update();">
            </div>

            <?php if($get_id[0]['documento']!=""){ ?>
                <div id="i_<?php echo $get_id[0]['id_documento_pdf']; ?>" class="form-group col-md-4">
                    <label class="control-label text-bold">Descargar/Eliminar:</label>
                    <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $get_id[0]['id_documento_pdf'] ?>">
                        <img src="<?= base_url() ?>template/img/descarga_peq.png">
                    </a>
                    <a style="cursor:pointer;" class="delete" type="button" id="delete_file" data-image_id="<?php echo $get_id[0]['id_documento_pdf'] ?>">
                        <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                    </a>
                </div>
            <?php } ?>
        </div> 

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado_u" id="estado_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_status as $list){ ?>    
                        <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                            <?php echo $list['nom_status']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" class="form-control" id="id_documento_pdf" name="id_documento_pdf" value="<?php echo $get_id[0]['id_documento_pdf'] ?>">
        <input type="hidden" class="form-control" id="documento_actual" name="documento_actual" value="<?php echo $get_id[0]['documento'] ?>">
        <button id="btn_producto" name="btn_producto" type="button" class="btn btn-primary" data-loading-text="Loading..." autocomplete="off" onclick="Update_Documentos_PDF();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Buscar_Sede_Update(){
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

        var id_empresa = $('#id_empresa_u').val();
        var url="<?php echo site_url(); ?>Administrador/Buscar_Sede_Update_Documentos_PDF";

        $.ajax({
            type: "POST",
            url: url,
            data: {'id_empresa':id_empresa},
            success:function (data) {
                $('#select_sede_u').html(data);
            }
        });
    }

    function Update_Documentos_PDF() {
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
        
        var dataString = new FormData(document.getElementById('formulario_update'));
        var url = "<?php echo site_url(); ?>Administrador/Update_Documentos_PDF";

        if (Valida_Update_Documentos_PDF()) {
            $.ajax({
                url: url,
                data: dataString, 
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    if(data=="error"){
                        Swal({
                            title: 'Actualización Denegada',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Documentos_PDF();
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });

        }
    }

    function Valida_Update_Documentos_PDF() {
        if ($('#referencia_u').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Referencia.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#nombre_documento_pdf_u').val() === '') {
            Swal(
                'Ups!',
                'Debe Ingresar Nombre.',
                'warning'
            ).then(function() {});
            return false;
        }
        return true;
    }

    function Validar_Extension_Update(){
        var archivoInput = document.getElementById('documento_pdf_u');
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.pdf|.PDF)$/i;
  
        if(!extPermitidas.exec(archivoRuta)){
            Swal({
                title: 'Registro Denegado',
                text: "Asegurese de ingresar Archivos PDF.",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
            archivoInput.value = '';
            return false;
        }else{
            return true;            
        }
    }

    $(document).on('click', '#download_file', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>Administrador/Descargar_Archivo_Documento_PDF/" + image_id);
    });

    $(document).on('click', '#delete_file', function () {
        var image_id = $(this).data('image_id');
        var file_col = $('#i_' + image_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>Administrador/Delete_Archivo_Documento_PDF',
            data: {'image_id': image_id},
            success: function (data) {
                file_col.remove();            
            }
        });
    });
</script>