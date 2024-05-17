<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h5 class="modal-title"><b>Colegio Proveniencia (Editar)</b></h5>
	</div>

	<div class="modal-body" style="max-height:520px; overflow:auto;">
		<div class="col-md-12 row">
			<div class="form-group col-md-4">
			    <label class="control-label text-bold">Departamento:</label>
			    <select class="form-control" name="departamento_e" id="departamento_e" onchange="Provincia('editar')">
			        <option value="0">Seleccione</option>
			        <?php foreach ($list_departamento as $list) : ?>
			            <?php $isSelected = ($colegio_prov[0]['departamento'] == $list['id_departamento']) ? 'selected' : ''; ?>
			            <option value="<?php echo $list['id_departamento']; ?>" <?php echo $isSelected; ?>>
			                <?php echo $list['nombre_departamento']; ?>
			            </option>
			        <?php endforeach; ?>
			    </select>
			</div>


			<div id="mprovincia_e" class="form-group col-md-4">
			    <label class="control-label text-bold">Provincia:</label>
			    <select class="form-control" name="provincia_e" id="provincia_e" onchange="Distrito('editar')">
			        <option value="0">Seleccione</option>
			        <?php foreach ($list_provincia as $list) : ?>
			            <?php $selected = ($colegio_prov[0]['provincia'] == $list['id_provincia']) ? 'selected' : ''; ?>
			            <option value="<?php echo $list['id_provincia']; ?>" <?php echo $selected; ?>>
			                <?php echo $list['nombre_provincia']; ?>
			            </option>
			        <?php endforeach; ?>
			    </select>
			</div>


			<div id="mdistrito_e" class="form-group col-md-4">
			    <label class="control-label text-bold">Distrito:</label>
			    <select class="form-control" name="distrito_e" id="distrito_e">
			        <option value="0">Seleccione</option>
			        <?php foreach ($list_distrito as $list) : ?>
			            <?php $isSelected = ($colegio_prov[0]['distrito'] == $list['id_distrito']) ? 'selected' : ''; ?>
			            <option value="<?php echo $list['id_distrito']; ?>" <?php echo $isSelected; ?>>
			                <?php echo $list['nombre_distrito']; ?>
			            </option>
			        <?php endforeach; ?>
			    </select>
			</div>

        	<div class="form-group col-md-4">
			<label class="control-label text-bold">Tipo de Gestión:</label>
        		<select class="form-control" name="tipo_gestion_e" id="tipo_gestion_e">
					<option value="1" <?php if($colegio_prov[0]['tipo_gestion'] == 1) echo 'selected'; ?>>Privada</option>
					<option value="2" <?php if($colegio_prov[0]['tipo_gestion'] == 2) echo 'selected'; ?>>Pública</option>
					<option value="3" <?php if($colegio_prov[0]['tipo_gestion'] == 3) echo 'selected'; ?>>Pública (Gestión Privada)</option>
        		</select>
        	</div> 

			<div class="form-group col-md-12">
				<label class="control-label text-bold">Institucion:</label>
				<input value="<?=$colegio_prov[0]['institucion']?>" name="institucion_e" id="institucion_e" class="form-control" placeholder="Ingresar nombre de la institución">
			</div>

        	<div class="form-group col-md-4">
				<label class="control-label text-bold">Estado:</label>
        		<select class="form-control" name="id_estado_e" id="id_estado_e">
        		        <?php foreach($list_estado as $item){ ?>
        		        <option value="<?php echo $item['id_status']; ?>" <?php if($item['id_status']==$colegio_prov[0]['estado']){ echo "selected"; } ?>>
        		            <?php echo $item['nom_status']; ?>
        		        </option>
        		        <?php } ?>
        		</select>
        	</div>
		</div>
	</div>

	<div class="modal-footer">
		<input type="hidden" name="id_colegio_prov_e" id="id_colegio_prov_e" value="<?=$colegio_prov[0]['id']?>">
		<button type="button" class="btn btn-primary" onclick="Actualizar_Colegio_Prov()">
			<i class="glyphicon glyphicon-ok-sign"></i> Guardar
		</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">
			<i class="glyphicon glyphicon-remove-sign"></i> Cancelar
		</button>
	</div>
</form>

<script>
	$(document).ready(function() {
        activateEnterKeyForFunction(Actualizar_Colegio_Prov);
    });  
	function Actualizar_Colegio_Prov() {
		Cargando();

		var dataString = new FormData(document.getElementById('formulario_update'));
		var url = "<?php echo site_url(); ?>AppIFV/Actualizar_Colegio_Prov";

		if (Valida_Actualizar_Colegio_Prov()) {
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
						Listar_Colegio_Prov();
					}
				}
			});
		}
	}
	
	function Valida_Actualizar_Colegio_Prov() {
        if($('#departamento_e').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un departamento.',
                'warning'
            ).then(function() { });
            return false;
        }
		if($('#provincia_e').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un provincia.',
                'warning'
            ).then(function() { });
            return false;
        }
		if($('#distrito_e').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un distrito.',
                'warning'
            ).then(function() { });
            return false;
        }
		if ($('#institucion_e').val().trim() === '') {
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
