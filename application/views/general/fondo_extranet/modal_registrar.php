<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title" id="exampleModalLabel"><b>Fondo Extranet (Nuevo)</b></h5>
    </div>

    <div class="modal-body" >
        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="text-bold">Título: </label>
                <div class="col">
                    <input type="text" class="form-control" id="titulo_i" name="titulo_i" placeholder="Título">
                </div> 
            </div>

            <div class="form-group col-md-12">
                <label class="text-bold">Imagen: </label>
                <div class="col">
                    <div class="col">
                        <input type="file" id="imagen_i" name="imagen_i" onchange="return Validar_Insert_Ext();">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Fondo_Extranet();"> <i class="glyphicon glyphicon-ok-sign"></i> Guardar </button>
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Fondo_Extranet(){
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

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>General/Insert_Fondo_Extranet";

        if (Valida_Insert_Fondo_Extranet()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function () {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Fondo_Extranet();
                        $("#modal_form_vertical .close").click()
                    });
                }
            });  
        } 
    }

    function Valida_Insert_Fondo_Extranet() {
        if($('#titulo_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Título.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#imagen_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Imagen.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Validar_Insert_Ext(){
        var archivoInput = document.getElementById('imagen_i');
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.jpg)$/i;
  
        if(!extPermitidas.exec(archivoRuta)){
            Swal({
                title: 'Registro Denegado',
                text: "Asegurese de seleccionar Archivo jpg",
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
