<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h5 class="modal-title"><b>Documento (Nuevo)</b></h5>
	</div>

	<div class="modal-body" style="max-height:520px; overflow:auto;">
		<div class="col-md-12 row">
			<div class="form-group col-md-2">
				<label class="control-label text-bold">Codigo:</label>
			</div>
			<div id="div_modulo_i" class="form-group col-md-4">
				<input type="text" name="codigo" id="codigo" class="form-control">
			</div>

			<div class="form-group col-md-2">
				<label class="control-label text-bold">Nombre:</label>
			</div>
			<div class="form-group col-md-4">
				<input type="text" name="nombre" id="nombre" class="form-control">
			</div>

			<div class="form-group col-md-2">
				<label class="control-label text-bold">Asunto:</label>
			</div>
			<div class="form-group col-md-4">
				<input type="text" name="asunto" id="asunto" class="form-control">
			</div>

			<div class="form-group col-md-2">
				<label class="control-label text-bold">Tipo:</label>
			</div>
			<div class="form-group col-md-4">
                <select class="form-control" id="tipo" name="tipo" > <!--onchange="updateInputIdProductValue()"-->
                    <option value="0">Seleccione</option>
                    <?php foreach($list as $item){?> 
                        <option value="<?php echo $item['id_status_general'] ?>"><?php echo $item['nom_status'] ?></option>	
                    <?php }?>
                </select>
            </div>
			
			<div class="form-group col-md-2">
				<label class="control-label text-bold">Texto:</label>
			</div>
			<div class="form-group col-md-10">
				<textarea name="texto" id="texto" class="form-control" placeholder="Ingresar el Texto"></textarea>
			</div>

		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-primary" onclick="Registrar_Documento_Configuracion()">
			<i class="glyphicon glyphicon-ok-sign"></i> Guardar
		</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">
			<i class="glyphicon glyphicon-remove-sign"></i> Cancelar
		</button>
	</div>
</form>

<script>
	function Registrar_Documento_Configuracion() {
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
		var url = "<?php echo site_url(); ?>AppIFV/Registrar_Documento_Configuracion";

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
							title: 'Registro Denegado',
							text: "¡Existe un registro con los mismos datos!",
							type: 'error',
							showCancelButton: false,
							confirmButtonColor: '#3085d6',
							confirmButtonText: 'OK',
						});
					} else {
						$('#acceso_modal .close').click();
						Swal(
							'Registro Exitoso',
							'¡El registro se ha realizado correctamente!',
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
		if ($('#codigo').val().trim() === '') {
			Swal(
				'Ups!',
				'Debe ingresar un codigo.',
				'warning'
			).then(function() {});
			return false;
		}
		if ($('#nombre').val().trim() === '') {
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
