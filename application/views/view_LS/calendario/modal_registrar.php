<form  id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario"> 
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>Calendario (Nuevo)</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="text-bold">Fecha: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fecha_i" name="fecha_i" value="<?php echo date('Y-m-d'); ?>">
            </div>
            
            <div class="form-group col-md-2">
                <label class="text-bold">Descripción: </label> 
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="descripcion_i" name="descripcion_i" placeholder="Ingresar Descripción">
            </div>

            <div class="form-group col-md-2">
                <label class="text-bold">Días Feriado: </label> 
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros" id="dias_i" name="dias_i" placeholder="Ingresar Días Feriado">
            </div>
        </div>
            
        <div class="form-group col-md-12 row">
            <div class="form-group col-md-2">
                <label class="text-bold">Motivo: </label>
            </div>
            <div class="form-group col-md-10">
                <textarea class="form-control" id="motivo_i" name="motivo_i" placeholder="Ingresar Motivo" rows="5"></textarea>
            </div>
        </div>  	           	                	        
    </div> 

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Calendario();"> 
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

    function Insert_Calendario(){
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
        var dataString = $("#formulario_insert").serialize();
        var url="<?php echo site_url(); ?>LeadershipSchool/Insert_Calendario";

        if (Valida_Insert_Calendario()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    Lista_Calendario(tipo_excel);
                    $("#acceso_modal .close").click()
                }
            });
        }
    }

    function Valida_Insert_Calendario() {
        if($('#fecha_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#descripcion_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Descripción.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#dias_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Días Feriado.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#dias_i').val().trim() <= 0) {
            Swal(
                'Ups!',
                'Debe ingresar Días Feriado mayor a 0.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
