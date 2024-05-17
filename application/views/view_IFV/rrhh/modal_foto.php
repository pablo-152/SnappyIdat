<form id="formulario_foto" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Agregar Foto</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Foto:</label>
            </div>
            <div class="form-group col-md-5">
                <input type="file" id="foto" name="foto" onchange="validarExt();">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_docente" name="id_docente" value="<?php echo $id_docente; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Foto_Docentes()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div> 
</form>

<script>
    function validarExt(){
        var archivoInput = document.getElementById('foto'); 
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
    }

    function Update_Foto_Docentes(){
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

        var id_docente = $("#id_docente").val();
        var dataString = new FormData(document.getElementById('formulario_foto'));
        var url="<?php echo site_url(); ?>AppIFV/Valida_Update_Foto_Docentes";
        var url2="<?php echo site_url(); ?>AppIFV/Update_Foto_Docentes";

        if (Valida_Update_Foto_Docentes()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="mensaje"){
                        Swal({
                            title: '¿Realmente desea cambiar la foto?',
                            text: "Se mantendrá la foto anterior",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si',
                            cancelButtonText: 'No',
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    url: url2,
                                    data:dataString,
                                    type:"POST",
                                    processData: false,
                                    contentType: false,
                                    success:function (data) {
                                        swal.fire(
                                            'Actualización Exitosa',
                                            'Haga clic en el botón!',
                                            'success'
                                        ).then(function() {
                                            window.location = "<?php echo site_url(); ?>AppIFV/Detalle_Rrhh/"+id_docente;
                                        });
                                    }
                                });
                            }
                        })
                    }else{
                        $.ajax({
                            url: url2,
                            data:dataString,
                            type:"POST",
                            processData: false,
                            contentType: false,
                            success:function (data) {
                                swal.fire(
                                    'Registro Exitoso',
                                    'Haga clic en el botón!',
                                    'success'
                                ).then(function() {
                                    window.location = "<?php echo site_url(); ?>AppIFV/Detalle_Rrhh/"+id_docente;
                                });
                            }
                        });
                    }    
                }
            });
        }
    }

    function Valida_Update_Foto_Docentes() {
        if($('#foto').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Imagen.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>