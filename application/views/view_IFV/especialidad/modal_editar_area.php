<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Editar Área:</h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Código: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="codigo_u" name="codigo_u" maxlength="6" placeholder="Ingresar Código" value="<?php echo $get_id[0]['codigo']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nombre_u" name="nombre_u" maxlength="50" placeholder="Ingresar Nombre" value="<?php echo $get_id[0]['nombre']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Orden: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="orden_u" name="orden_u" maxlength="1" placeholder="Ingresar Orden" onkeypress="return soloNumeros(event)" value="<?php echo $get_id[0]['orden']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado: </label>
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
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_area" name="id_area" value="<?php echo $get_id[0]['id_area']; ?>">
        <input type="hidden" id="id_especialidad" name="id_especialidad" value="<?php echo $get_id[0]['id_especialidad']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Area();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
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

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Area";

        if (Valida_Update_Area()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
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
                        Lista_Area();
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }
    }

    function Valida_Update_Area() {
        if($('#codigo_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Código.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nombre_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#orden_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Orden.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#orden_u').val()<1) {
            Swal(
                'Ups!',
                'Orden debe ser mayor a 0.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#orden_u').val()>4) {
            Swal(
                'Ups!',
                'Orden debe ser menor o igual a 4.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe ingresar Estado.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>