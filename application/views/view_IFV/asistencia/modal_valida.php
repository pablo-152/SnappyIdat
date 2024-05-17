<form id="formulario_valida" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Esta acción obliga a una clave de administrador:</label>
            </div>
            <div class="form-group col-md-12">
                <input type="password" class="form-control" id="clave_valida" name="clave_valida" placeholder="Clave">
            </div>
        </div>  	           	                	        
    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Abrir_Registro_Manual()">
            Validar
        </button>
    </div>
</form>

<script>
    function Abrir_Registro_Manual(){
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

        var dataString = new FormData(document.getElementById('formulario_valida'));
        var url = "<?php echo site_url(); ?>AppIFV/Abrir_Registro_Manual";

        if(Valida_Abrir_Registro_Manual()){ 
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success: function(data){
                    if(data=="error"){
                        Swal({
                            title: 'Ingreso Denegado',
                            text: "¡Clave Incorrecta!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        $("#modal_contrasena").modal("hide");
                        $("#modal_registro_manual").modal("show");
                    }
                }
            });
        }
    }

    function Valida_Abrir_Registro_Manual() {
        if($('#clave_valida').val().trim() === '') {
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
