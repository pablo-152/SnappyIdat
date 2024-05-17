<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>Editar Festivo & Fecha Importante</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="text-bold">Año: </label>
                <div class="col">
                    <input type="number" class="form-control" value="<?php echo $get_id[0]['anio']; ?>" id="anio_u" name="anio_u" placeholder="Ingresar Año">
                </div>
            </div>
            
            <div class="form-group col-md-4">
                <label class="text-bold">Fecha: </label>
                <div class="col">
                    <input class="form-control" type="date" id="inicio_u" name="inicio_u" value="<?php echo $get_id[0]['fecha']; ?>" />
                </div>
            </div>
            
            <div class="form-group col-md-4">
                <label class="text-bold">Descripción: </label>
                <div class="col">
                    <input type="text" class="form-control" id="descripcion_u" value="<?php echo $get_id[0]['descripcion']; ?>" name="descripcion_u" placeholder="Ingresar Descripción">
                </div>
            </div>
            
            <div class="form-group col-md-4">
                <label class="text-bold">Tipo: </label>
                <div class="col">
                    <select class="form-control" name="id_tipo_fecha_u" id="id_tipo_fecha_u">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_tipo_festivo as $list){ ?>
                            <option value="<?php echo $list['id_tipo_fecha']; ?>" <?php if($list['id_tipo_fecha']==$get_id[0]['id_tipo_fecha']){ echo "selected"; } ?>>
                                <?php echo $list['nom_tipo_fecha'];?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="text-bold">F/V: </label>
                <div class="col">
                    <select class="form-control" name="fijo_variable_u" id="fijo_variable_u">
                        <option value="0" <?php if($get_id[0]['fijo_variable']==0){ echo "selected"; } ?>>Seleccione</option>
                        <option value="1" <?php if($get_id[0]['fijo_variable']==1){ echo "selected"; } ?>>Fijo</option>
                        <option value="2" <?php if($get_id[0]['fijo_variable']==2){ echo "selected"; } ?>>Variable</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group col-md-4">
                <label class="text-bold">Estado: </label> 
                <div class="col">
                    <select class="form-control" name="id_status_u" id="id_status_u">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_estado as $list){ ?>
                            <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                                <?php echo $list['nom_status'];?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-2">
                <label class="text-bold">Hay&nbsp;Clases: </label><span>&nbsp;</span>
                <div>
                    <select name="clases_u" id="clases_u" class="form-control">
                        <option value="0">Seleccione</option>
                        <option value="SI" <?php if($get_id[0]['clases']=="SI"){echo "selected";}?>>SI</option>
                        <option value="NO" <?php if($get_id[0]['clases']=="NO"){echo "selected";}?>>NO</option>
                    </select>
                </div>
                
            </div>

            <div class="form-group col-md-2">
                <label class="text-bold">Laborable: </label>
                <div>
                    <select name="laborable_u" id="laborable_u" class="form-control">
                        <option value="0">Seleccione</option>
                        <option value="SI" <?php if($get_id[0]['laborable']=="SI"){echo "selected";}?>>SI</option>
                        <option value="NO" <?php if($get_id[0]['laborable']=="NO"){echo "selected";}?>>NO</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group col-md-12">
                <label class="text-bold">Observaciones: </label>
                <div class="col">
                    <textarea name="observaciones_u" rows="4" class="form-control" id="observaciones_u" placeholder="Observaciones"><?php echo $get_id[0]['observaciones']; ?></textarea>
                </div>
            </div>
            
        </div>  	           	                	        
    </div> 
    <div class="modal-footer">
        <input name="id_calendar_festivo" type="hidden" id="id_calendar_festivo" value="<?php echo $get_id[0]['id_calendar_festivo']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Festivo();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
        
    </div>
</form>

<script>
    function Update_Festivo(){
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

        var dataString = $("#formulario_update").serialize();
        var url="<?php echo site_url(); ?>Snappy/Update_Festivo";

        if (Valida_Update_Festivo()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    Lista_Festivo(1);
                    $("#acceso_modal_mod .close").click()
                }
            });
        }
    }    

    function Valida_Update_Festivo() {
        if($('#anio_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Año.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#inicio_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha de Inicio.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#descripcion_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Descripción.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_tipo_fecha_u').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo de Festivo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_status_u').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Estado.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
