<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Actualización de Área <b><?php echo $get_id[0]['descripcion_area']; ?></b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Descripción: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="descripcion_area_u" name="descripcion_area_u" value="<?php echo $get_id[0]['descripcion_area']; ?>" placeholder="Ingresar Descripción" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_status_u" id="id_status_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                            <?php echo $list['nom_status']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>  	           	                	        
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_area" name="id_area" value="<?php echo $get_id[0]['id_area']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Area();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Update_Area(){
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
        var url="<?php echo site_url(); ?>Ceba2/Update_Area";

        if (Valida_Update_Area()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Actualización Denegada',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            'Actualización Exitosa!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>Ceba2/Area";
                        });
                    }
                }
            });
        }    
    }

    function Valida_Update_Area() {
        if($('#descripcion_area_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Descripción.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_status_u').val().trim() == '0') {
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