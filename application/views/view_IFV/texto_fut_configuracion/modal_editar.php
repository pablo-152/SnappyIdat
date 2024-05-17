<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h5 class="modal-title"><b>Editar Registro</b></h5>
	</div>

	<div class="modal-body" style="max-height:520px; overflow:auto;">
		<div class="col-md-12 row">
			<div class="form-group col-md-2">
                <label class="control-label text-bold">Producto:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="producto_e" name="producto_e" onchange="updateInputIdProductValue()">
                    <option value="0">Seleccione</option>
                    <?php foreach($productos as $item){?> 
                        <option value="<?php echo $item['id_producto'] ?>" <?php if($get_id[0]['id_producto']==$item['id_producto']){echo "selected";}?> ><?php echo $item['nom_sistema'] ?></option>	
                    <?php }?>
                </select>
            </div>

			<input type="hidden" id="id_texto_e" name="id_texto_e" value="<?php echo $get_id[0]['id_texto']; ?>">
			
			<input type="hidden" name="id_producto_e" id="id_producto_e" value="<?php echo $get_id[0]['id_producto']; ?>">

			<div class="form-group col-md-2">
				<label class="control-label text-bold">Asunto:</label>
			</div>
			<div class="form-group col-md-4">
				<input name="asunto_e" id="asunto_e" class="form-control" value="<?php echo $get_id[0]['asunto']; ?>" placeholder="Asunto">
			</div>

			<div class="form-group col-md-2">
				<label class="control-label text-bold">Texto:</label>
			</div>
			<div class="form-group col-md-10">
				<textarea name="texto_e" id="texto_e" class="form-control" placeholder="Texto"><?php echo $get_id[0]['texto']?></textarea>
			</div>
		</div>
	</div>

	<div class="modal-footer">		
		<button type="button" class="btn btn-primary" onclick="Actualizar_Texto_Fut()">
			<i class="glyphicon glyphicon-ok-sign"></i> Guardar
		</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">
			<i class="glyphicon glyphicon-remove-sign"></i> Cerrar
		</button>
	</div>
</form>

<script>
	function updateInputIdProductValue() {
		var id_producto = $('#producto_e').val();
		$('#id_producto_e').val(id_producto);
	}

	function Actualizar_Texto_Fut() {
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
		var url = "<?php echo site_url(); ?>AppIFV/Actualizar_Texto_Fut";

		if (Valida_Texto_Fut()) {
			$.ajax({
				url: url,
				data: dataString,
				type: "POST",
				processData: false,
				contentType: false,
				success: function(data) {
					if (data == "error") {
						Swal({
							title: 'Actualización Denegada',
							text: "¡Existe un registro con los mismos datos!",
							type: 'error',
							showCancelButton: false,
							confirmButtonColor: '#3085d6',
							confirmButtonText: 'OK',
						});
					} else {
						$('#acceso_modal_mod .close').click();
						Swal(
							'Actualización Exitosa',
							'¡El registro se ha actualizado correctamente!',
							'success'
						).then(function() {
							Listar_Texto_Fut();
						});
					}
				}
			});
		}
	}
	
	function Valida_Texto_Fut() {
        if($('#producto_e').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un producto.',
                'warning'
            ).then(function() { });
            return false;
        }
		if ($('#asunto_e').val().trim() === '') {
			Swal(
				'Ups!',
				'Debe ingresar texto.',
				'warning'
			).then(function() {});
			return false;
		}
		if ($('#texto_e').val().trim() === '') {
			Swal(
				'Ups!',
				'Debe ingresar texto.',
				'warning'
			).then(function() {});
			return false;
		}
		return true;
	}
</script>
