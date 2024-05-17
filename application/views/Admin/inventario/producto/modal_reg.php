

<script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/loaders/pace.min.js"></script>
<script type="text/javascript" src="<?=base_url() ?>template/assets/js/core/libraries/jquery.min.js"></script>

<script type="text/javascript" src="<?=base_url() ?>template/assets/js/pages/uploader_bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url() ?>template/assets/js/plugins/loaders/blockui.min.js"></script>
<form id="formulario_productoi" method="POST" enctype="multipart/form-data"  class="horizontal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Nuevo Producto</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            
            <div class="form-group col-md-1">
                <label>Ref:</label>
            </div>

            <div class="form-group col-md-2">
                <input type="text" readonly class="form-control" id="referencia" name="referencia" value="<?php echo $get_referencia[0]['letra'].$get_referencia[0]['nom_anio'] ?>" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Tipo:</label>
            </div>

            <div class="form-group col-md-3">
                <select required class="form-control" name="id_tipo_inventario" id="id_tipo_inventario" onchange="Busca_Subtipo()">
                <option value="0">Seleccione</option>
                <?php foreach($list_tipo as $list){ ?>
                    <option value="<?php echo $list['id_tipo_inventario']; ?>"><?php echo $list['nom_tipo_inventario'];?></option>
                <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-1">
                <label>Sub-Tipo:</label>
            </div>

            <div class="form-group col-md-3" id="div_subtipo">
                <select required class="form-control" name="id_subtipo_inventario" id="id_subtipo_inventario">
                <option value="0">Seleccione</option>
                
                </select>
            </div>

            <div class="form-group col-md-1 ">
                <input type="text" readonly class="form-control"  id="estado" name="estado" autofocus>
            </div>

        
            <div class="form-group col-md-1">
                <label>Descripción:</label>
            </div>

            <div class="form-group col-md-6 ">
                <input type="text"   class="form-control"  id="producto_descripcion" name="producto_descripcion" autofocus>
            </div>
        

            <div class="form-group col-md-2">
                <label>Fecha&nbsp;Compra:</label>
            </div>

            <div class="form-group col-md-3 ">
                <input type="date"   class="form-control"  id="fec_compra" name="fec_compra" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Proveedor:</label>
            </div>

            <div class="form-group col-md-2 ">
                <input type="text"   class="form-control"  id="proveedor" name="proveedor" autofocus>
            </div>

            <div class="form-group col-md-1 ">
                <label>Garantía:</label>
            </div>

            <div class="form-group col-md-2 ">
                <input type="date"   class="form-control"  id="garantia_h" name="garantia_h" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Precio&nbsp;Unit.:</label>
            </div>

            <div class="form-group col-md-1 ">
                <input type="text" class="form-control"  id="precio_u" name="precio_u" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Cant.:</label>
            </div>

            <div class="form-group col-md-1 ">
                <input type="text" class="form-control"  id="cantidad" name="cantidad" onchange="Cargar_Codigos()" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Total:</label>
            </div>

            <div class="form-group col-md-1 ">
                <input type="text" readonly class="form-control"  id="total" name="total" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Desv/Año:</label>
            </div>

            <div class="form-group col-md-1 ">
                <input type="text"  class="form-control"  id="desvalorizacion" name="desvalorizacion" placeholder="%" autofocus>
            </div>
            <div class="form-group col-md-1 ">
                <input type="text"  class="form-control"  id="anio" maxlength="4" name="anio" placeholder="Año" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Gastos:</label>
            </div>

            <div class="form-group col-md-6 ">
                <input type="text"  class="form-control"  id="gastos" name="gastos" placeholder="Ingresar Gastos" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Valor&nbsp;Actual:</label>
            </div>

            <div class="form-group col-md-1 ">
                <input type="text"  class="form-control"  id="valor_actual" name="valor_actual" placeholder="Valor" autofocus>
            </div>
        
            <div class="form-group col-md-1">
                <label class="text-bold">Imagen: </label>
            </div>

            <div class="form-group col-md-4">
                <input type="file" id="imagen" name="imagen" class="file-input-overwrite" data-allowed-file-extensions='["JPG|jpg|png|PNG|jpeg|JPEG"]'>
            </div>
        </div>
        <div class="col-md-12 row" id="tabla_codigo">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-hover table-bordered table-striped" id="example" width="100%">
                            <thead>
                                <tr >
                                    <th width="10%"><div align="center"></div></th>
                                    <th width="20%"><div align="center">Código</div></th>
                                    <th width="20%"><div align="center">Sede</div></th>
                                    <th width="10%"><div align="center">Estado</div></th>
                                    <th width="10%"><div align="center">LCheck</div></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 row">
        <label class="text-bold"> </label>
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-1">
                <label>Observ.:</label>
            </div>

            <div class="form-group col-md-11 ">
                <textarea name="producto_obs" rows="4" class="form-control" id="producto_obs"></textarea>
            </div>

            <div class="form-group col-md-1">
                <label class="control-label text-bold">Archivos:</label>
            </div>

            <div class="form-group col-md-11 ">
                <input type="file" class="form-control" name="archivos[]" id="archivos" multiple autofocus/>
            </div>
            

        </div>  	           	                	        
    </div> 

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_ProductoI()" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>
<script src="<?= base_url() ?>template/fileinput/js/fileinput.min.js"></script>
<script>
    $('#precio_u').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.]/g, '');
    });
    $('#cantidad').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('#desvalorizacion').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.]/g, '');
    });
    $('#anio').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    $(document).ready(function() {
        var msgDate = '';
        var inputFocus = '';
    });

    $(function(){
        $('#precio_u').on('change', calcularTotal);
        $('#cantidad').on('change', calcularTotal);
    });
    
    function calcularTotal() {
        if($('#precio_u').val().trim() !="" && $('#cantidad').val().trim() !=""){
            var pu=$('#precio_u').val();
            var cantidad=$('#cantidad').val();
            var total=pu*cantidad;
            $('#total').val(total);
        }
        
    }

    $('#archivos').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        maxTotalFileCount: 5,
        showUpload: false,
        overwriteInitial: false,
        initialPreviewAsData: true,
        allowedFileExtensions: ['png','jpeg','jpg','xls','xlsx','pdf'],
    });

    function Busca_Subtipo(){
        var dataString = new FormData(document.getElementById('formulario_productoi'));
        var url="<?php echo site_url(); ?>Snappy/Buscar_Subtipo_Inventario";
        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#div_subtipo').html(data);
                
            }
        });
    }

    function Cargar_Codigos(){
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

        var dataString = new FormData(document.getElementById('formulario_productoi'));
        var url="<?php echo site_url(); ?>Snappy/Cargar_Codigos";
        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#tabla_codigo').html(data);
                
            }
        });
    }

    function Insert_ProductoI(){
        var dataString = new FormData(document.getElementById('formulario_productoi'));
        var url="<?php echo site_url(); ?>Snappy/Insert_Producto_Inventario";
        if (valida_productoi()) {
            bootbox.confirm({
                title: "Registrar Producto",
                message: "¿Desea registrar nuevo producto?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result) {
                        $.ajax({
                            type:"POST",
                            url: url,
                            data:dataString,
                            processData: false,
                            contentType: false,
                            success:function (data) {
                                if(data=="error"){
                                    swal.fire(
                                    'Registro Denegado!',
                                    'Existe un registro con el mismo tipo,subtipo, fecha de compra y garantía',
                                    'error'
                                ).then(function() {
                                    
                                    
                                });
                                }else{
                                    swal.fire(
                                    'Registro Exitoso!',
                                    '',
                                    'success'
                                ).then(function() {
                                    window.location = "<?php echo site_url(); ?>Snappy/Producto";
                                    
                                });
                                }
                                
                            }
                        });
                    }
                } 
            });      
        }else{
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function () {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }
    

    function valida_productoi() {
        if($('#id_tipo_inventario').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar tipo.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#id_subtipo_inventario').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar subtipo.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#fec_compra').val().trim() == '') {
            Swal(
                'Ups!',
                'Debe ingresar fecha de compra.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#precio_u').val().trim() == '') {
            Swal(
                'Ups!',
                'Debe ingresar precio unitario.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#cantidad').val().trim() == '') {
            Swal(
                'Ups!',
                'Debe ingresar cantidad.',
                'warning'
            ).then(function() { });
            return false;
        }

        return true;
    }
</script>
