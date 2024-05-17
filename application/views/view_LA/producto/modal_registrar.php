<style>
    .tamanio{
        height: 20px;
        width: 20px;
    }
</style>

<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Producto (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;"> 
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo Producto: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_tipo_producto_i" name="id_tipo_producto_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_tipo_producto as $list){ ?>
                        <option value="<?php echo $list['id_tipo_producto']; ?>"><?php echo $list['tipo_producto']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Talla: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_talla_i" name="id_talla_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_talla as $list){ ?>
                        <option value="<?php echo $list['id_talla']; ?>"><?php echo $list['cod_talla']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Disponible Encomendar: </label>
            </div>
            <div class="form-group col-md-1">
                <input type="checkbox" class="tamanio" id="disponible_encomendar_i" name="disponible_encomendar_i" value="1">
            </div>

            <div class="form-group col-md-3">
                <label class="control-label text-bold">Aviso (con stock Total): </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros" id="aviso_i" name="aviso_i" placeholder="Ingresar Aviso" onkeypress="if(event.keyCode == 13){ Insert_Producto(); }">
            </div>   
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Activo de: </label>
            </div>
            <div class="form-group col-md-4"> 
                <input type="date" class="form-control" id="desde_i" name="desde_i" value="<?php echo date('Y-01-01'); ?>" onkeypress="if(event.keyCode == 13){ Insert_Producto(); }">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">A: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="hasta_i" name="hasta_i" value="<?php echo date('Y-12-31'); ?>" onkeypress="if(event.keyCode == 13){ Insert_Producto(); }">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Precio Venta: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros_punto" id="precio_venta_i" name="precio_venta_i" placeholder="Precio Venta" onkeypress="if(event.keyCode == 13){ Insert_Producto(); }">
            </div>

            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Estado:</label>                 
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado_i" id="estado_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==2){ echo "selected"; } ?>>
                            <?php echo $list['nom_status'];?>
                        </option>
                    <?php } ?>
                </select>
            </div>          	                	        
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Producto();">
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

    function Insert_Producto(){
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

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>Laleli/Insert_Producto";

        if (Valida_Insert_Producto()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Producto(1); 
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }    
    }

    function Valida_Insert_Producto() {
        var anio_desde = $('#desde_i').val().split('-');
        var anio_hasta = $('#hasta_i').val().split('-');

        if($('#id_tipo_producto_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo Producto.',
                'warning'
            ).then(function() { });
            return false; 
        }
        if($('#id_talla_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Talla.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#desde_i').val().trim() === '') {
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
        if($('#hasta_i').val().trim() === '') {
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
        if($('#precio_venta_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Precio de Venta.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_i').val().trim() === '0') {
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
