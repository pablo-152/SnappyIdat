<form id="from_fondo" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title" id="exampleModalLabel"><b>Fondo de Intranet (Nuevo)</b></h5>
    </div>

    <div class="modal-body" >
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="text-bold">Empresa: </label>
                <div class="col">
                    <select class="form-control" name="id_empresa" id="id_empresa">
                        <option value="0">Seleccione</option>
                        <?php foreach ($list_empresa as $empresa) {?>
                        <option value="<?php echo $empresa->id_empresa; ?>"><?php echo $empresa->nom_empresa; ?></option>
                        <?php }?>
                        <option value="100">General</option>
                    </select>
                </div> 
            </div>
            

            <div class="form-group col-md-6">
                <label class="text-bold">Nombre: </label>
                <div class="col">
                    <input type="text" class="form-control" id="nom_fintranet" name="nom_fintranet" placeholder="Nombre del Fondo de Intranet" >
                </div> 
            </div>
              

            <div class="form-group col-md-6">
                <label class="text-bold">Imagen: </label>
                <div class="col">
                    <div class="col">
                        <input type="file" id="productImage" name="productImage" data-allowed-file-extensions='["png|jpg|pdf"]' size="100" required>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Fondo();"> <i class="glyphicon glyphicon-ok-sign"></i> Guardar </button>
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Cancelar</button>
    </div>
</form>

<!--<script src="<?= base_url() ?>template/fileinput/js/fileinput.min.js"></script>-->

<script>
    function Insert_Fondo(){
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

        var dataString = new FormData(document.getElementById('from_fondo'));
        var url="<?php echo site_url(); ?>General/Insert_fondo";
        if (img()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function () {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>General/Fondo_snappy";
                        
                    });
                }
            });  
        } 
    }

    function img() {
        if($('#id_empresa').val()== '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#nom_fintranet').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#productImage').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe adjuntar Imagen.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
