<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h5 class="modal-title"><b>Editar Documento</b></h5>
	</div>

	<div class="modal-body" style="max-height:520px; overflow:auto;">
		<div class="col-md-12 row">
			<div class="form-group col-md-2">
				<label class="control-label text-bold">Codigo:</label>
			</div>
			<div id="div_modulo_i" class="form-group col-md-4">
				<input type="text" name="codigo_e" id="codigo_e" class="form-control" value="<?php echo $get_id[0]['codigo'] ?>">
			</div>

			<div class="form-group col-md-2">
				<label class="control-label text-bold">Nombre:</label>
			</div>
			<div class="form-group col-md-4">
				<input type="text" name="nombre_e" id="nombre_e" class="form-control" value="<?php echo $get_id[0]['nombre'] ?>">
			</div>
			<div class="form-group col-md-2">
				<label class="control-label text-bold">Asunto:</label>
			</div>
			<div class="form-group col-md-4">
				<input type="text" name="asunto_e" id="asunto_e" class="form-control" value="<?php echo $get_id[0]['asunto'] ?>">
			</div>

			<div class="form-group col-md-2">
				<label class="control-label text-bold">Tipo:</label>
			</div>
			<div class="form-group col-md-4">
                <select class="form-control" id="tipo_e" name="tipo_e" > <!--onchange="updateInputIdProductValue()"-->
                    <option value="0">Seleccione</option>
                    <?php foreach($list as $item){?> 
                        <!-- <option value="<?php echo $item['id_status_general'] ?>"><?php echo $item['nom_status'] ?></option>	-->
						<option value="<?php echo $item['id_status_general'] ?>" <?php if($get_id[0]['tipo']==$item['id_status_general']){echo "selected";}?> ><?php echo $item['nom_status'] ?></option>	

                    <?php }?>
                </select>
            </div>
			
			<div class="form-group col-md-2">
				<label class="control-label text-bold">Texto:</label>
			</div>
			<div class="form-group col-md-10">
				<textarea name="texto_e" id="texto_e" class="form-control" placeholder="Ingresar el Texto"><?php echo $get_id[0]['texto'] ?></textarea>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<input type="hidden" id="id_documento" name="id_documento" value="<?php echo $get_id[0]['id_documento']; ?>">
		<button type="button" class="btn btn-primary" onclick="Actualizar_Documento_Configuracion()">
			<i class="glyphicon glyphicon-ok-sign"></i> Guardar
		</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">
			<i class="glyphicon glyphicon-remove-sign"></i> Cerrar
		</button>
	</div>
</form>

<script>
	function Actualizar_Documento_Configuracion() {
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
		var url = "<?php echo site_url(); ?>AppIFV/Actualizar_Documento_Configuracion";

		if (Valida_Documento_Configuracion()) {
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
							'Registro Exitoso',
							'¡El registro se ha actualizado correctamente!',
							'success'
						).then(function() {
							Listar_Documento_Configuracion();
						});
					}
				}
			});
		}
	}

	function Valida_Documento_Configuracion() {
		if ($('#codigo_e').val().trim() === '') {
			Swal(
				'Ups!',
				'Debe ingresar un codigo.',
				'warning'
			).then(function() {});
			return false;
		}
		if ($('#nombre_e').val().trim() === '') {
			Swal(
				'Ups!',
				'Debe ingresar un nombre.',
				'warning'
			).then(function() {});
			return false;
		}
		return true;
	}
</script>
