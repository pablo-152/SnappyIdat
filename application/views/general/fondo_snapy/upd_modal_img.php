<form id="formulario_fondoe" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <?php if(isset($get_id)){ ?>
            <input  type="hidden" name="id_fintranet" id="id_fintranet" value="<?php echo $get_id[0]['id_fintranet'] ?>">
        <?php } ?>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title" id="exampleModalLabel"><b>Editar Imagen de Intranet</b></h5>
    </div>

    <div class="modal-body" >
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="text-bold">Empresa: </label>
                <div class="col">
                    <select class="form-control" name="id_empresa" id="id_empresa">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_empresa as $empresa){ 
                            if($get_id[0]['id_empresa'] == $empresa['id_empresa']){ ?>
                                <option selected value="<?php echo $empresa['id_empresa'] ; ?>"><?php echo $empresa['nom_empresa'];?></option>  
                            <?php }else{ ?>
                                <option value="<?php echo $empresa['id_empresa']; ?>"><?php echo $empresa['nom_empresa'];?></option>
                            <?php } ?>
                        <?php } ?>

                        <?php if($get_id[0]['id_empresa']==100){ ?>
                            <option selected value="100">General</option>
                        <?php }else{ ?>
                            <option value="100">General</option>
                        <?php } ?>
                    </select>
                </div> 
            </div>

            <div class="form-group col-md-6">
                <label class="text-bold">Nombre: </label>
                <div class="col">
                    <input type="text" class="form-control" id="nom_fintranet" name="nom_fintranet" value="<?php echo $get_id[0]['nom_fintranet'] ?>">
                </div> 
            </div>

            <div class="form-group col-md-6">
                <label class="text-bold">Imagen: </label>
                <div class="col" id="d_pdf" >
                    <iframe id="pdf" src="<?php echo base_url().$get_id[0]['foto']; ?>" height="250"></iframe>
                </div>
            </div> 
            
            <div class="form-group col-md-6">
                <label class="text-bold">Selecciona imagen:</label>
                <div class="col" id="archivo_essalud_container" align="left">
                    <input name="actuimagen" id="actuimagen" type="file" data-allowed-file-extensions='["png|jpg|pdf"]' size="100" required>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary"> <i class="glyphicon glyphicon-ok-sign"></i> Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Cancelar</button>
    </div>
</form>

<!--<script src="<?= base_url() ?>template/fileinput/js/fileinput.min.js"></script>-->

<script>
    function Update_Fondo(){
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

        var dataString = new FormData(document.getElementById('formulario_fondoe'));
        var url="<?php echo site_url(); ?>General/update_foto";

        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function () {
                swal.fire(
                    'Actualización Exitosa!',
                    '',
                    'success'
                ).then(function() {
                    window.location = "<?php echo site_url(); ?>General/Fondo_snappy";
                    
                });
            }
        });
    }
</script>
