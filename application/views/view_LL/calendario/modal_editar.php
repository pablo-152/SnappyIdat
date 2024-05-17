<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>Editar Calendario</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="text-bold">Fecha: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fecha_u" name="fecha_u" value="<?php echo $get_id[0]['fecha']; ?>">
            </div>
            
            <div class="form-group col-md-2">
                <label class="text-bold">Descripción: </label>  
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="descripcion_u" name="descripcion_u" placeholder="Ingresar Descripción" value="<?php echo $get_id[0]['descripcion']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="text-bold">Días Feriado: </label> 
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros" id="dias_u" name="dias_u" placeholder="Ingresar Días Feriado" value="<?php echo $get_id[0]['dias']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="text-bold">Estado: </label> 
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado_u" id="estado_u"> 
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                            <?php echo $list['nom_status']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
            
        <div class="form-group col-md-12 row">
            <div class="form-group col-md-2">
                <label class="text-bold">Motivo: </label>
            </div>
            <div class="form-group col-md-10">
                <textarea class="form-control" id="motivo_u" name="motivo_u" placeholder="Ingresar Motivo" rows="5"><?php echo $get_id[0]['motivo']; ?></textarea>
            </div>
        </div>  	           	                	        
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_calendario" name="id_calendario" value="<?php echo $get_id[0]['id_calendario']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Calendario();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Update_Calendario(){
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

        var tipo_excel = $("#tipo_excel").val();
        var dataString = $("#formulario_update").serialize();
        var url="<?php echo site_url(); ?>LittleLeaders/Update_Calendario";

        if (Valida_Update_Calendario()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    Lista_Calendario(tipo_excel);
                    $("#acceso_modal_mod .close").click()
                }
            });
        }
    }

    function Valida_Update_Calendario() {
        if($('#fecha_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha.',
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
        if($('#dias_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Días Feriado.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#dias_u').val().trim() <= 0) {
            Swal(
                'Ups!',
                'Debe ingresar Días Feriado mayor a 0.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_u').val().trim() === '0') {
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
