<form id="formulario_update" method="POST" enctype="multipart/form-data">
    <div class="modal-header">
        <h3 class="tile-title">Editar Producto Interese</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="text-bold">Empresa: </label>
                <div class="col">
                    <select class="form-control" id="id_empresa_u" name="id_empresa_u" onchange="Traer_Sede_U();">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_empresa as $list){ ?>
                            <option value="<?php echo $list['id_empresa']; ?>" <?php if($list['id_empresa']==$get_id[0]['id_empresa']){ echo "selected"; } ?>>
                                <?php echo $list['cod_empresa']; ?>
                            </option>
                        <?php } ?>
                    </select>                
                </div>
            </div>
            
            <div class="form-group col-md-4">
                <label class="text-bold">Sede: </label>
                <div class="col">
                    <select class="form-control" id="id_sede_u" name="id_sede_u">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_sede as $list){ ?>
                            <option value="<?php echo $list['id_sede']; ?>" <?php if($list['id_sede']==$get_id[0]['id_sede']){ echo "selected"; } ?>>
                                <?php echo $list['cod_sede']; ?>
                            </option>
                        <?php } ?>
                    </select>                
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="text-bold">Interese: </label>
                <div class="col">
                    <input type="text" class="form-control" id="nom_producto_interes_u" name="nom_producto_interes_u" value="<?php echo $get_id[0]['nom_producto_interes']; ?>" onkeypress="if(event.keyCode == 13){ Update_Producto_Interes(); }">
                </div>
            </div>

            <div class="form-group col-md-2">
                <label class="text-bold">Orden: </label>
                <div class="col">
                    <input type="text" class="form-control" id="orden_producto_interes_u" name="orden_producto_interes_u" placeholder="Orden" value="<?php echo $get_id[0]['orden_producto_interes']; ?>" onkeypress="if(event.keyCode == 13){ Update_Producto_Interes(); }">
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="text-bold">Fecha Inicio: </label>
                <div class="col">
                    <input type="date" class="form-control" id="fecha_inicio_u" name="fecha_inicio_u" value="<?php echo $get_id[0]['fecha_inicio']; ?>" onkeypress="if(event.keyCode == 13){ Update_Producto_Interes(); }">
                </div>
            </div>
            
            <div class="form-group col-md-4">
                <label class="text-bold">Fecha Fin: </label>
                <div class="col">
                    <input type="date" class="form-control" id="fecha_fin_u" name="fecha_fin_u" value="<?php echo $get_id[0]['fecha_fin']; ?>" onkeypress="if(event.keyCode == 13){ Update_Producto_Interes(); }">
                </div>
            </div>
            
            <div class="form-group col-md-4">
                <label class="text-bold">Estado: </label>
                <div class="col">
                    <select class="form-control" id="estado_u" name="estado_u">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_estado as $list){ ?>
                            <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                                <?php echo $list['nom_status']; ?>
                            </option>
                        <?php } ?>
                    </select>               
                </div>
            </div>
            
            <div class="form-group col-md-2">
                <label class="text-bold">Totales: </label>
                <div class="col">
                    <input type="checkbox" id="total_u" name="total_u" <?php if($get_id[0]['total']==1){ echo "checked"; } ?> value="1"> 
                </div>
            </div>

            <div class="form-group col-md-2">
                <label class="text-bold">Formulario: </label>
                <div class="col">
                    <input type="checkbox" id="formulario_u" name="formulario_u" <?php if($get_id[0]['formulario']==1){ echo "checked"; } ?> value="1"> 
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_producto_interes" name="id_producto_interes" value="<?php echo $get_id[0]['id_producto_interes']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Producto_Interes();">
            <i class="glyphicon glyphicon-ok-sign"></i>Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i>Cancelar
        </button>
    </div>
</form>

<script>
    $('#orden_producto_interes_u').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Traer_Sede_U(){
        Cargando();
        
        var url = "<?php echo site_url(); ?>General/Traer_Sede_Producto_Interes";
        var id_empresa = $("#id_empresa_u").val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_empresa':id_empresa},
            success: function(data){
                $('#id_sede_u').html(data);
            }
        });
    }

    function Update_Producto_Interes(){
        Cargando();
        
        var dataString = $("#formulario_update").serialize();
        var url="<?php echo site_url(); ?>General/Update_Producto_Interes";

        if (Valida_Update_Producto_Interes()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    if(data=="total"){
                        Swal({
                            title: 'Actualización Denegada',
                            text: "Solo se permiten 11 totales por empresa. Borre otro si desea este en Totales.",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Producto_Interes();
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }
    }

    function Valida_Update_Producto_Interes() {
        if($('#id_empresa_u').val()=="0") { 
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_sede_u').val()=="0") { 
            Swal(
                'Ups!',
                'Debe seleccionar Sede',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nom_producto_interes_u').val()=="") { 
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fecha_inicio_u').val()=="") { 
            Swal(
                'Ups!',
                'Debe ingresar Fecha Inicio',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fecha_fin_u').val()=="") { 
            Swal(
                'Ups!',
                'Debe ingresar Fecha Fin',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_u').val()=="") { 
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