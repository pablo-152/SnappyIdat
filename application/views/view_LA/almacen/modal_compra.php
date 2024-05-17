<form id="formulario_compra" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Añadir Compra</b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Código: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_producto_c" name="id_producto_c" onchange="Traer_Datos_Producto_C();">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_producto as $list){ ?>
                        <option value="<?php echo $list['id_producto']; ?>"><?php echo $list['codigo']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div id="div_datos_producto_c" class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="Tipo" disabled>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Sub-Tipo: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="Sub-Tipo" disabled>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo Producto: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="Tipo Producto" disabled>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Talla/Ref.: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="Talla/Ref." disabled>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fecha Compra: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fecha_compra_c" name="fecha_compra_c" onblur="Anio_Defecto_Compra_C();" onkeypress="if(event.keyCode == 13){ Insert_Compra_Almacen(); }">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Año: </label>
            </div>
            <div id="lista_anio_c" class="form-group col-md-4">
                <select class="form-control" id="id_anio_c" name="id_anio_c">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_anio as $list){ ?>
                        <option value="<?php echo $list['id_anio']; ?>"><?php echo $list['nom_anio']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Precio Compra: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros_punto" id="precio_compra_c" name="precio_compra_c" placeholder="Ingresar Precio Compra" onkeypress="if(event.keyCode == 13){ Insert_Compra_Almacen(); }">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Gasto Arpay: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros" id="gasto_arpay_c" name="gasto_arpay_c" placeholder="Ingresar Gasto Arpay" maxlength="5" onkeypress="if(event.keyCode == 13){ Insert_Compra_Almacen(); }">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Cantidad: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros" id="cantidad_c" name="cantidad_c" placeholder="Ingresar Cantidad" onkeypress="if(event.keyCode == 13){ Insert_Compra_Almacen(); }">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_almacen_c" name="id_almacen_c" value="<?php echo $id_almacen; ?>">
        <button type="button" class="btn btn-primary" onclick="Insert_Compra_Almacen();">
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
        this.value = this.value.replace(/[^0-9.,]/g, '');
    });

    function Traer_Datos_Producto_C(){
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

        var id_producto = $("#id_producto_c").val();
        var url="<?php echo site_url(); ?>Laleli/Traer_Datos_Producto_C";

        $.ajax({
            type:"POST",
            url: url,
            data: {'id_producto':id_producto},
            success:function (data) {
                $("#div_datos_producto_c").html(data);
            }
        });   
    }

    function Anio_Defecto_Compra_C(){
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

        var fecha_compra = $("#fecha_compra_c").val();
        var url="<?php echo site_url(); ?>Laleli/Anio_Defecto_Compra_C";

        $.ajax({
            type:"POST",
            url: url,
            data: {'fecha_compra':fecha_compra},
            success:function (data) {
                $("#lista_anio_c").html(data);
            }
        });   
    }

    function Insert_Compra_Almacen(){
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

        var dataString = new FormData(document.getElementById('formulario_compra'));
        var url="<?php echo site_url(); ?>Laleli/Insert_Compra_Almacen";

        if (Valida_Insert_Compra_Almacen()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    $("#acceso_modal .close").click()
                    Lista_Detalle_Almacen();
                }
            });
        }    
    }

    function Valida_Insert_Compra_Almacen() {
        var gasto = $('#gasto_arpay_c').val();
        var cantidad_gasto = gasto.length;

        if($('#id_producto_c').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Producto.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fecha_compra_c').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Compra.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_anio_c').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Año.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#precio_compra_c').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Precio Compra.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#gasto_arpay_c').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Gasto Arpay.',
                'warning'
            ).then(function() { });
            return false;
        }
        if(cantidad_gasto!=5) {
            Swal(
                'Ups!',
                'Gasto Arpay debe tener 5 dígitos.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#cantidad_c').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Cantidad.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
