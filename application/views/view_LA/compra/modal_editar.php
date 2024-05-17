<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario"> 
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Compra</b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Código: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="Código" value="<?php echo $get_id[0]['codigo']; ?>" disabled>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="Tipo" value="<?php echo $get_id[0]['nom_tipo']; ?>" disabled>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Sub-Tipo: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="Sub-Tipo" value="<?php echo $get_id[0]['nom_subtipo']; ?>" disabled>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo Producto: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="Tipo Producto" value="<?php echo $get_id[0]['descripcion']; ?>" disabled>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Talla/Ref.: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="Talla/Ref." value="<?php echo $get_id[0]['talla']; ?>" disabled>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fecha Compra: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fecha_compra_u" name="fecha_compra_u" value="<?php echo $get_id[0]['fecha_compra']; ?>" onblur="Anio_Defecto_Compra_U();" onkeypress="if(event.keyCode == 13){ Update_Compra(); }">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Año: </label>
            </div>
            <div id="select_anio_u" class="form-group col-md-4">
                <select class="form-control" id="id_anio_u" name="id_anio_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_anio as $list){ ?>
                        <option value="<?php echo $list['id_anio']; ?>" <?php if($list['id_anio']==$get_id[0]['id_anio']){ echo "selected"; } ?>>
                            <?php echo $list['nom_anio']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Precio Compra: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros_punto" id="precio_compra_u" name="precio_compra_u" placeholder="Ingresar Precio Compra" value="<?php echo $get_id[0]['precio_compra']; ?>" onkeypress="if(event.keyCode == 13){ Update_Compra(); }">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Gasto Arpay: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros" id="gasto_arpay_u" name="gasto_arpay_u" placeholder="Ingresar Gasto Arpay" maxlength="5" value="<?php echo $get_id[0]['gasto_arpay']; ?>" onkeypress="if(event.keyCode == 13){ Update_Compra(); }">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Cantidad: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="Cantidad" value="<?php echo $get_id[0]['cantidad']; ?>" disabled>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_compra" name="id_compra" value="<?php echo $get_id[0]['id_compra']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Compra();">
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

    function Anio_Defecto_Compra_U(){
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

        var fecha_compra = $("#fecha_compra_u").val();
        var url="<?php echo site_url(); ?>Laleli/Anio_Defecto_Compra_U";

        $.ajax({
            type:"POST",
            url: url,
            data: {'fecha_compra':fecha_compra},
            success:function (data) {
                $("#select_anio_u").html(data);
            }
        });   
    }

    function Update_Compra(){
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
        var url="<?php echo site_url(); ?>Laleli/Update_Compra";

        if (Valida_Update_Compra()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    $("#acceso_modal_mod .close").click()
                    Lista_Compra();
                }
            });
        }    
    }

    function Valida_Update_Compra() {
        var gasto = $('#gasto_arpay_u').val();
        var cantidad_gasto = gasto.length;

        if($('#fecha_compra_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Compra.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_anio_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Año.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#precio_compra_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Precio Compra.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#gasto_arpay_u').val().trim() === '') {
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
        return true;
    }
</script>
