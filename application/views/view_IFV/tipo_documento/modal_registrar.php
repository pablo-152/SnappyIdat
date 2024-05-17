<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h5 class="modal-title"><b>Tipo Documento (Nuevo)</b></h5>
	</div>

	<div class="modal-body" style="max-height:520px; overflow:auto;">
		<div class="col-md-12 row">

			<div class="form-group col-md-2">
				<label class="control-label text-bold">Tipo:</label>
			</div>
			<div class="form-group col-md-4">
				<input name="tipo" id="tipo" class="form-control" placeholder="Tipo">
			</div>

			<div class="form-group col-md-2">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="estado" name="estado" > <!--onchange="updateInputIdProductValue()"-->
                    <option value="0">Seleccione</option>
                    <?php foreach($list as $item){?> 
                        <option value="<?php echo $item['id_status'] ?>"><?php echo $item['nom_status'] ?></option>	
                    <?php }?>
                </select>
            </div>

			<input type="hidden" name="id_producto" id="id_producto" value="">
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-primary" onclick="Registrar_Tipo_Documento()">
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
	
	function Registrar_Tipo_Documento() {
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
		var url = "<?php echo site_url(); ?>AppIFV/Registrar_Tipo_Documento";

		if (Valida_Tipo_Documento()) {
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
							Listar_Tipo_Documento();
						});

					}
				}
			});
		}
	}

	function Valida_Tipo_Documento() {
		if ($('#tipo').val().trim() === '') {
			Swal(
				'Ups!',
				'Debe ingresar Tipo.',
				'warning'
			).then(function() {});
			return false;
		}
        if($('#estado').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un Estado.',
                'warning'
            ).then(function() { });
            return false;
        }
		
		return true;
	}
</script>
