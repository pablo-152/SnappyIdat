<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h5 class="modal-title"><b>Colegio Proveniencia (Nuevo)</b></h5>
	</div>

	<div class="modal-body" style="max-height:520px; overflow:auto;">
		<div class="col-md-12 row">
			<div class="form-group col-md-4">
                <label class="control-label text-bold">Departamento:</label>
                <select id="departamento" name="departamento" class="form-control" onchange="Provincia();">
                    <option value="0" >Seleccione</option>
                    <?php foreach($list_departamento as $list){ ?>
                        <option value="<?php echo $list['id_departamento']; ?>"><?php echo $list['nombre_departamento'];?></option>
                    <?php } ?>
                </select>
            </div>

            <div id="mprovincia" class="form-group col-md-4">
                <label class="control-label text-bold">Provincia:</label>
                <select id="provincia" name="provincia" class="form-control" onchange="Distrito();">
                    <option value="0" >Seleccione</option>
                </select>
            </div>

            <div id="mdistrito" class="form-group col-md-4">
                <label class="control-label text-bold">Distrito:</label>
                <select id="distrito" name="distrito" class="form-control">
                    <option value="0" >Seleccione</option>
                </select>
            </div>

        	<div class="form-group col-md-4">
			<label class="control-label text-bold">Tipo de Gestión:</label>
        		<select class="form-control" name="tipo_gestion" id="tipo_gestion">
					<option value="1" >Privada</option>
    				<option value="2" >Pública</option>
    				<option value="3" >Pública (Gestión Privada)</option>
        		</select>
        	</div> 

			<div class="form-group col-md-12">
			<label class="control-label text-bold">Institucion:</label>
				<input name="institucion" id="institucion" class="form-control" placeholder="Ingresar nombre de la institución">
			</div>

        	<div class="form-group col-md-4">
			<label class="control-label text-bold">Estado:</label>
        		<select class="form-control" name="id_estado" id="id_estado">
					<?php foreach($list_estado as $item) {?>
   					    <option value="<?php echo $item['id_status']; ?>" <?php if ($item['id_status'] == 2) echo 'selected'; ?>>
   					        <?php echo $item['nom_status']; ?>
   					    </option> 
   					<?php } ?>
        		</select>
        	</div> 
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-primary" onclick="Registrar_Colegio_Prov()">
			<i class="glyphicon glyphicon-ok-sign"></i> Guardar
		</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">
			<i class="glyphicon glyphicon-remove-sign"></i> Cancelar
		</button>
	</div>
</form>

<script>	
	$(document).ready(function() {
        activateEnterKeyForFunction(Registrar_Colegio_Prov);
    }); 
	function Registrar_Colegio_Prov() {
		Cargando();

		var dataString = new FormData(document.getElementById('formulario_insert'));
		var url = "<?php echo site_url(); ?>AppIFV/Registrar_Colegio_Prov";

		if (Valida_Colegio_Prov()) {
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
						Listar_Colegio_Prov();
					}
				}
			});
		}
	}

	function Valida_Colegio_Prov() {
        if($('#departamento').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un departamento.',
                'warning'
            ).then(function() { });
            return false;
        }
		if($('#provincia').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un provincia.',
                'warning'
            ).then(function() { });
            return false;
        }
		if($('#distrito').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un distrito.',
                'warning'
            ).then(function() { });
            return false;
        }
		if ($('#institucion').val().trim() === '') {
			Swal(
				'Ups!',
				'Debe ingresar una institución.',
				'warning'
			).then(function() {});
			return false;
		}
		return true;
	}
</script>