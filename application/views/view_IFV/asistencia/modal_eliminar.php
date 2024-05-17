<form id="formulario_delete" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Esta acción obliga a una clave de administrador:</label>
            </div>
            <div class="form-group col-md-12">
                <input type="password" class="form-control" id="clave_admin" name="clave_admin" placeholder="Clave">
            </div>
        </div>  	           	                	        
    </div> 
    
    <div class="modal-footer">
        <input type="hidden" id="id_registro_ingreso" name="id_registro_ingreso" value="<?php echo $get_id[0]['id_registro_ingreso']; ?>">
        <button type="button" class="btn btn-primary" onclick="Delete_Registro_Ingreso()">
            Validar
        </button>
    </div>
</form>

<script>
    function Delete_Registro_Ingreso(){
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

        var dataString = new FormData(document.getElementById('formulario_delete'));
        var url = "<?php echo site_url(); ?>AppIFV/Delete_Registro_Ingreso";

        if(Valida_Delete_Registro_Ingreso()){
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success: function(data){
                    if(data=="error"){
                        Swal({
                            title: 'Eliminación Denegada',
                            text: "¡Clave Incorrecta!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        $("#modal_contrasena").modal("hide");
                        Lista_Registro_Ingreso();
                        Botones_Bajos();
                    }
                }
            });
        }
        
        $('#codigo_alumno').val('');
        $('#codigo_alumno').focus();
    }

    function Valida_Delete_Registro_Ingreso() {
        if($('#clave_admin').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Clave.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
