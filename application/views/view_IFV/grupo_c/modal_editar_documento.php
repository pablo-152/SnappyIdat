
<form id="formulario_doc_update" method="post" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cargar Documento</h5>  
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Adjuntar: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="file" id="archivo_u" name="archivo_u" onchange="Validar_Extension_U();"> 
            </div>
        </div>
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_documento" name="id_documento" value="<?php echo $get_id[0]['id_documento']; ?>">
        <input type="hidden" id="archivo_actual" name="archivo_actual" value="<?php echo $get_id[0]['archivo']; ?>">
        <input type="hidden" id="tipo_u" name="tipo_u" value="<?php echo $get_id[0]['tipo']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Documento();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button> 
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Validar_Extension_U(){
        var tipo = document.getElementById('tipo_u');
        var tipo = tipo.value;

        if(tipo==1 || tipo==2){
            var archivoInput = document.getElementById('archivo_u'); 
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.png)$/i;
            
            if(!extPermitidas.exec(archivoRuta)){
                Swal({
                    title: 'Registro Denegado',
                    text: "Asegurese de ingresar archivo con extensión .png.",
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
                    if(tipo==1){
                        if(img.width === 1410 && img.height === 410){
                            return true;
                        }else{
                            Swal({
                                title: 'Registro Denegado',
                                text: "Asegurese de ingresar foto con dimensión de 1410x410.",
                                type: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK',
                            });
                            archivoInput.value = '';
                            return false;
                        }  
                    }else{
                        if(img.width === 387 && img.height === 575){
                            return true;
                        }else{
                            Swal({
                                title: 'Registro Denegado',
                                text: "Asegurese de ingresar foto con dimensión de 387x575.",
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
        }else{
            var archivoInput = document.getElementById('archivo_u'); 
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.pdf)$/i;
            
            if(!extPermitidas.exec(archivoRuta)){
                Swal({
                    title: 'Registro Denegado',
                    text: "Asegurese de ingresar archivo con extensión .pdf.",
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

    function Update_Documento(){
        Cargando();
        
        var dataString = new FormData(document.getElementById('formulario_doc_update'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Documento_Grupo_C";

        if (Valida_Update_Documento()) {
            $.ajax({
                type:"POST",
                url:url,
                data: dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    Lista_Documento();
                    $("#acceso_modal_mod .close").click()
                }
            });        
        }  
    }

    function Valida_Update_Documento() {
        if($('#archivo_u').val().trim() === '') {
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