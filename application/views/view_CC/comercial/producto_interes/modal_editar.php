<form class="formulario" id="formulario" method="POST" enctype="multipart/form-data">
    <div class="modal-header">
        <h3 class="tile-title">Edición de Datos de <b><?php echo $get_id[0]['nom_producto_interes']; ?></b></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class=" text-bold">Empresa: </label>
                <div class="col">
                    <select class="form-control" name="empresa" id="empresa" onchange="Sede();">
                        <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_empresa']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                        <?php foreach($list_empresa as $list){ ?>
                            <option value="<?php echo $list['id_empresa']; ?>" <?php if (!(strcmp($list['id_empresa'], $get_id[0]['id_empresa']))) {echo "selected=\"selected\"";} ?>><?php echo $list['cod_empresa'];?></option>
                        <?php } ?>
                    </select>                
                </div>
            </div>
            
            <div class="form-group col-md-4">
                <label class=" text-bold">Sede: </label>
                <div id="div_sede" class="col">
                    <select class="form-control" name="sede" id="sede">
                        <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_sede']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                        <?php foreach($list_sede as $list){ 
                            if($list['id_empresa']==$get_id[0]['id_empresa']){ ?>
                                <option value="<?php echo $list['id_sede']; ?>" <?php if (!(strcmp($list['id_sede'], $get_id[0]['id_sede']))) {echo "selected=\"selected\"";} ?>><?php echo $list['cod_sede'];?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>                
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class=" text-bold">Interese: </label>
                <div class="col">
                    <input type="text" id="nom_producto_interes" name="nom_producto_interes" class="form-control" value="<?php echo $get_id[0]['nom_producto_interes']; ?>" onkeypress="if(event.keyCode == 13){ Update_Producto_Interes(); }">
                </div>
            </div>

            <div class="form-group col-md-2">
                <label class=" text-bold">Orden: </label>
                <div class="col">
                    <input type="text" id="orden_producto_interes" name="orden_producto_interes" class="form-control" placeholder="Orden" value="<?php echo $get_id[0]['orden_producto_interes']; ?>" onkeypress="if(event.keyCode == 13){ Update_Producto_Interes(); }">
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class=" text-bold">Fecha Inicio: </label>
                <div class="col">
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="<?php echo $get_id[0]['fecha_inicio']; ?>" onkeypress="if(event.keyCode == 13){ Update_Producto_Interes(); }">
                </div>
            </div>
            
            <div class="form-group col-md-4">
                <label class=" text-bold">Fecha Fin: </label>
                <div class="col">
                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" value="<?php echo $get_id[0]['fecha_fin']; ?>" onkeypress="if(event.keyCode == 13){ Update_Producto_Interes(); }">
                </div>
            </div>
            
            <div class="form-group col-md-4">
                <label class=" text-bold">Status: </label>
                <div class="col">
                    <select class="form-control" name="id_status" id="id_status">
                        <option value="0" <?php if (!(strcmp(0, $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                        <?php foreach($list_status as $list){ ?>
                            <option value="<?php echo $list['id_status']; ?>" <?php if (!(strcmp($list['id_status'], $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>><?php echo $list['nom_status'];?></option>
                        <?php } ?>
                    </select>               
                </div>
            </div>
            
            <div class="form-group col-md-2">
                <label class=" text-bold">Totales: </label>
                <div class="col">
                    <input type="checkbox" id="total" name="total" <?php if($get_id[0]['total']==1){ echo "checked"; } ?> value="1" class="minimal" onkeypress="if(event.keyCode == 13){ Update_Producto_Interes(); }"> 
                    <span style="font-weight:normal"><?php echo " "; ?></span>
                </div>
            </div>

            <div class="form-group col-md-2">
                <label class=" text-bold">Formulario: </label>
                <div class="col">
                    <input type="checkbox" id="formulario" name="formulario" <?php if($get_id[0]['formulario']==1){ echo "checked"; } ?> value="1" class="minimal" onkeypress="if(event.keyCode == 13){ Update_Producto_Interes(); }"> 
                    <span style="font-weight:normal"><?php echo " "; ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_producto_interes" name="id_producto_interes" class="form-control" value="<?php echo $get_id[0]['id_producto_interes']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Producto_Interes();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button>
    </div>
</form>

<script>
    $('#orden_producto_interes').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Sede(){
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
        
        var url = "<?php echo site_url(); ?>CursosCortos/Buscar_Sede_Producto_Interes";
        var id_empresa = $("#empresa").val();
        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_empresa':id_empresa},
            success: function(data){
                $('#div_sede').html(data);
            }
        });
    }

    function Update_Producto_Interes(){
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
        
        var dataString = $("#formulario").serialize();
        var url="<?php echo site_url(); ?>CursosCortos/Update_Producto_Interes";

        if (Valida_Producto_Interes()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    if(data=="total"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "Solo se permiten 11 totales por empresa. Borre otro si desea este en Totales.",
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
                            window.location = "<?php echo site_url(); ?>CursosCortos/Producto_Interes";
                        });
                    }
                }
            });

            
        }
    }

    function Valida_Producto_Interes() {
        if($('#empresa').val()=="0") { 
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#sede').val()=="0") { 
            Swal(
                'Ups!',
                'Debe seleccionar Sede',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nom_producto_interes').val()=="") { 
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fecha_inicio').val()=="") { 
            Swal(
                'Ups!',
                'Debe ingresar Fecha Inicio',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fecha_fin').val()=="") { 
            Swal(
                'Ups!',
                'Debe ingresar Fecha Fin',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_status').val()=="") { 
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