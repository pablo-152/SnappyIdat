
<form method="post" id="formulario_doc_insert" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cargar Documento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Adjuntar: </label>
            </div>

            <div class="form-group col-md-4">
                <input type="file" id="archivo_i" name="archivo_i" onchange="Validar_Extension_I();">
            </div>
        </div>
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_documento" name="id_documento" value="<?php echo $id_documento; ?>">
        <input type="hidden" id="id_alumno" name="id_alumno" value="<?php echo $id_alumno; ?>">
        <input type="hidden" id="cod_documento_i" value="<?php echo $get_documento[0]['cod_documento']; ?>">
        <button type="button" class="btn btn-primary" onclick="Insert_Documento();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button> 
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form> 

<script type="text/javascript">
    function Validar_Extension_I(){
        var cod_documento = document.getElementById('cod_documento_i');
        var cod_documento = cod_documento.value;

        if(cod_documento=='D00'){
            var archivoInput = document.getElementById('archivo_i'); 
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.jpeg|.png|.jpg)$/i;
            
            if(!extPermitidas.exec(archivoRuta)){
                Swal({
                    title: 'Registro Denegado',
                    text: "Asegurese de ingresar foto con extensiones .jpeg, .png y .jpg.",
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
                archivoInput.value = '';
                return false;
            }else{   
                let img = new Image()
                img.src = window.URL.createObjectURL(event.target.files[0])
                img.onload = () => {
                    if(img.width === 225 && img.height === 225){
                        return true;
                    }else{
                        Swal({
                            title: 'Registro Denegado',
                            text: "Asegurese de ingresar foto con dimensión de 225x225.",
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
        }else{
            var archivoInput = document.getElementById('archivo_i');
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.jpeg|.png|.jpg|.pdf)$/i;
    
            if(!extPermitidas.exec(archivoRuta)){
                Swal({
                    title: 'Registro Denegado',
                    text: "Asegurese de ingresar archivos con extensiones .jpeg, .png, .jpg y .pdf.",
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
    }

    function Insert_Documento(){
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
            })
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
        
        var dataString = new FormData(document.getElementById('formulario_doc_insert'));
        var url="<?php echo site_url(); ?>LittleLeaders/Insert_Documento_Alumno";

        if (Valida_Insert_Documento()) {
            $.ajax({
                type:"POST",
                url:url,
                data: dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    Swal(
                        'Carga Exitosa!',
                        'El archivo ha sido cargado exitosamente.',
                        'success'
                    ).then(function() {
                        Lista_Documentos();
                        $("#acceso_modal .close").click()
                    });
                }
            });        
        }  
    }

    function Valida_Insert_Documento() {
        if($('#archivo_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Archivo.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>