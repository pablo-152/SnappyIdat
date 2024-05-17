<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title" id="exampleModalLabel"><b>Editar Fondo Extranet</b></h5>
    </div>

    <div class="modal-body" >
        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="text-bold">Título: </label>
                <div class="col">
                    <input type="text" class="form-control" id="titulo_u" name="titulo_u" placeholder="Título" value="<?php echo $get_id[0]['titulo']; ?>">
                </div> 
            </div>

            <div class="form-group col-md-12">
                <label class="text-bold">Imagen: </label>
                <div class="col">
                    <div class="col">
                        <input type="file" id="imagen_u" name="imagen_u" onchange="return Validar_Update_Ext();">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_fondo" name="id_fondo" value="<?php echo $get_id[0]['id_fondo']; ?>">
        <input type="hidden" id="estado" name="estado" value="<?php echo $get_id[0]['estado']; ?>">
        <input type="hidden" id="imagen_actual" name="imagen_actual" value="<?php echo $get_id[0]['imagen']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Fondo_Extranet();"> <i class="glyphicon glyphicon-ok-sign"></i> Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Fondo_Extranet(){
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

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>General/Update_Fondo_Extranet";

        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function () {
                swal.fire(
                    'Actualización Exitosa!',
                    'Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_Fondo_Extranet();
                    $("#acceso_modal_mod .close").click()
                });
            }
        });
    }

    function Validar_Update_Ext(){
        var archivoInput = document.getElementById('imagen_u');
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
