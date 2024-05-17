<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h5 class="modal-title"><b>Texto Fut (Nuevo)</b></h5>
	</div>

	<div class="modal-body" style="max-height:520px; overflow:auto;">
		<div class="col-md-12 row">
			<div class="form-group col-md-2">
                <label class="control-label text-bold">Producto:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="producto" name="producto" onchange="updateInputIdProductValue()">
                    <option value="0">Seleccione</option>
                    <?php foreach($list as $item){?> 
                        <option value="<?php echo $item['id_producto'] ?>"><?php echo $item['nom_sistema'] ?></option>	
                    <?php }?>
                </select>
            </div>

			<input type="hidden" name="id_producto" id="id_producto" value="">

			<div class="form-group col-md-2">
				<label class="control-label text-bold">Asunto:</label>
			</div>
			<div class="form-group col-md-4">
				<input name="asunto" id="asunto" class="form-control" placeholder="Asunto">
			</div>

			<div class="form-group col-md-2">
				<label class="control-label text-bold">Texto:</label>
			</div>
			<div class="form-group col-md-10">
				<textarea name="texto" id="texto" class="form-control" placeholder="Texto"></textarea>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-primary" onclick="Registrar_Texto_Fut()">
			<i class="glyphicon glyphicon-ok-sign"></i> Guardar
		</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">
			<i class="glyphicon glyphicon-remove-sign"></i> Cancelar
		</button>
	</div>
</form>

<script>
	function updateInputIdProductValue() {
		var id_producto = $('#producto').val();
		$('#id_producto').val(id_producto);
	}
	
	function Registrar_Texto_Fut() {
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
		var url = "<?php echo site_url(); ?>AppIFV/Registrar_Texto_Fut";

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
							title: 'Registro Denegado',
							text: "¡Existe un registro para ese Producto!",
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
							Listar_Texto_Fut();
						});

					}
				}
			});
		}
	}

	function Valida_Texto_Fut() {
        if($('#producto').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un Producto.',
                'warning'
            ).then(function() { });
            return false;
        }
		if ($('#asunto').val().trim() === '') {
			Swal(
				'Ups!',
				'Debe ingresar Asunto.',
				'warning'
			).then(function() {});
			return false;
		}
		if ($('#texto').val().trim() === '') {
			Swal(
				'Ups!',
				'Debe ingresar Texto.',
				'warning'
			).then(function() {});
			return false;
		}
		return true;
	}
</script>
