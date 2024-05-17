<form method="post" id="formulario_insert" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Documentos PDF (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Ref: </label> 
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="referencia_i" name="referencia_i" placeholder="Ingresar Referencia" onkeypress="if(event.keyCode == 13){ Insert_Documentos_PDF(); }">
            </div>
        </div>
        
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre&nbsp;: </label> 
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="nombre_documento_pdf_i" name="nombre_documento_pdf_i" placeholder="Ingresar Nombre" onkeypress="if(event.keyCode == 13){ Insert_Documentos_PDF(); }">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Link&nbsp;: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="link_documento_pdf_i" name="link_documento_pdf_i" placeholder="Ingresar Link" onkeypress="if(event.keyCode == 13){ Insert_Documentos_PDF(); }">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Empresa:</label>
            </div>
            <div class="form-group col-md-4">
                <select  name="id_empresa_i" id="id_empresa_i" class="form-control" onchange="Buscar_Sede_Insert()">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_empresas as $list){ ?>
                    <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa'];?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Sede:</label>
            </div>
            <div id="select_sede_i" class="form-group col-md-4">
                <select class="form-control" name="id_sede_i" id="id_sede_i">
                    <option value="0" selected>Seleccione</option>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Archivo:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="file" id="documento_pdf_i" name="documento_pdf_i" onchange="Validar_Extension_Insert();">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button id="btn_producto" name="btn_producto" type="button" onclick="Insert_Documentos_PDF();" class="btn btn-primary" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Buscar_Sede_Insert(){
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

        var id_empresa = $('#id_empresa_i').val();
        var url="<?php echo site_url(); ?>Administrador/Buscar_Sede_Insert_Documentos_PDF";

        $.ajax({
            type: "POST",
            url: url,
            data: {'id_empresa':id_empresa},
            success:function (data) {
                $('#select_sede_i').html(data);
            }
        });
    }

    function Insert_Documentos_PDF() {
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

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "<?php echo site_url(); ?>Administrador/Insert_Documentos_PDF";

        if (Valida_Insert_Documentos_PDF()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    if(data=="error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Documentos_PDF();
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }
    }

    function Valida_Insert_Documentos_PDF() {
        if ($('#referencia_i').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Referencia.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#nombre_documento_pdf_i').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#link_documento_pdf_i').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Link.', 
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#documento_pdf_i').val() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Archivo.',
                'warning'
            ).then(function() {});
            return false;
        }
        return true;
    }

    function Validar_Extension_Insert(){
        var archivoInput = document.getElementById('documento_pdf_i');
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
</script>
