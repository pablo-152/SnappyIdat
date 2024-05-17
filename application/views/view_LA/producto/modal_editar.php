<style>
    .tamanio{
        height: 20px;
        width: 20px;
    }
</style>

<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Editar Producto</h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;"> 
        <!--<div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo Producto: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_tipo_producto_u" name="id_tipo_producto_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_tipo_producto as $list){ ?>
                        <option value="<?php echo $list['id_tipo_producto']; ?>" <?php if($list['id_tipo_producto']==$get_id[0]['id_tipo_producto']){ echo "selected"; } ?>>
                            <?php echo $list['tipo_producto']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Talla: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_talla_u" name="id_talla_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_talla as $list){ ?>
                        <option value="<?php echo $list['id_talla']; ?>" <?php if($list['id_talla']==$get_id[0]['id_talla']){ echo "selected"; } ?>>
                            <?php echo $list['cod_talla']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>-->

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo Producto: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" value="<?php echo $get_id[0]['cod_tipo_producto']; ?>" disabled>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Talla: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" value="<?php echo $get_id[0]['cod_talla']; ?>" disabled>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Disponible Encomendar: </label>
            </div>
            <div class="form-group col-md-1">
                <input type="checkbox" class="tamanio" id="disponible_encomendar_u" name="disponible_encomendar_u" value="1" <?php if($get_id[0]['disponible_encomendar']==1){ echo "checked"; } ?>>
            </div>

            <div class="form-group col-md-3">
                <label class="control-label text-bold">Aviso (con stock Total): </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros" id="aviso_u" name="aviso_u" placeholder="Ingresar Aviso" value="<?php echo $get_id[0]['aviso']; ?>" onkeypress="if(event.keyCode == 13){ Update_Producto(); }">
            </div>   
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Activo de: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="desde_u" name="desde_u" value="<?php echo $get_id[0]['desde']; ?>" onkeypress="if(event.keyCode == 13){ Update_Producto(); }">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">A: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="hasta_u" name="hasta_u" value="<?php echo $get_id[0]['hasta']; ?>" onkeypress="if(event.keyCode == 13){ Update_Producto(); }">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Precio Venta: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros_punto" id="precio_venta_u" name="precio_venta_u" placeholder="Precio Venta" value="<?php echo $get_id[0]['precio_venta']; ?>" onkeypress="if(event.keyCode == 13){ Update_Producto(); }">
            </div>

            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Estado:</label>                 
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado_u" id="estado_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                            <?php echo $list['nom_status'];?>
                        </option>
                    <?php } ?>
                </select>
            </div>          	                	        
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_producto" name="id_producto" value="<?php echo $get_id[0]['id_producto']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Producto();">
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

    $('.solo_numeros_punto').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.,-]/g, '');
    });

    function Update_Producto(){
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
        var url="<?php echo site_url(); ?>Laleli/Update_Producto";

        if (Valida_Update_Producto()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
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
                        Lista_Producto(1); 
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }    
    }

    function Valida_Update_Producto() {
        var anio_desde = $('#desde_u').val().split('-');
        var anio_hasta = $('#hasta_u').val().split('-');

        /*if($('#id_tipo_producto_u').val().trim() === '0') { 
            Swal(
                'Ups!',
                'Debe seleccionar Tipo Producto.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_talla_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Talla.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        if($('#desde_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Inicio.',
                'warning'
            ).then(function() { });
            return false;
        }
        if(anio_desde[0]<2000){
            Swal(
                'Ups!',
                'Debe ingresar Fecha Inicio válida.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#hasta_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Fin.',
                'warning'
            ).then(function() { });
            return false;
        }
        if(anio_hasta[0]<2000){
            Swal(
                'Ups!',
                'Debe ingresar Fecha Fin válida.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#precio_venta_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Precio de Venta.',
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