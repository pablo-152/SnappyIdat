<form id="formulario_insert" method="POST" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="tile-title"><b>Producto de Interese (Nuevo)</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="text-bold">Empresa: </label>
                <div class="col">
                    <select class="form-control" id="id_empresa_i" name="id_empresa_i" onchange="Traer_Sede_I();">
                        <option value="0" >Seleccione</option>
                        <?php foreach($list_empresa as $list){ ?>
                            <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa']; ?></option>
                        <?php } ?>
                    </select>                
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="text-bold">Sede: </label>
                <div class="col">
                    <select class="form-control" id="id_sede_i" name="id_sede_i">
                        <option value="0" >Seleccione</option>
                    </select>                
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="text-bold">Interese: </label>
                <div class="col">
                    <input type="text" class="form-control" id="nom_producto_interes_i" name="nom_producto_interes_i" placeholder="Interese" onkeypress="if(event.keyCode == 13){ Insert_Producto_Interes(); }">
                </div>
            </div>

            <div class="form-group col-md-2">
                <label class="text-bold">Orden: </label>
                <div class="col">
                    <input type="text" class="form-control" id="orden_producto_interes_i" name="orden_producto_interes_i" placeholder="Orden" onkeypress="if(event.keyCode == 13){ Insert_Producto_Interes(); }">
                </div>
            </div>
            
            <div class="form-group col-md-4">
                <label class="text-bold">Fecha Inicio: </label>
                <div class="col">
                    <input type="date" class="form-control" id="fecha_inicio_i" name="fecha_inicio_i" onkeypress="if(event.keyCode == 13){ Insert_Producto_Interes(); }">
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="text-bold">Fecha Fin: </label>
                <div class="col">
                    <input type="date" class="form-control" id="fecha_fin_i" name="fecha_fin_i" onkeypress="if(event.keyCode == 13){ Insert_Producto_Interes(); }">
                </div>
            </div>
            
            <div class="form-group col-md-2">
                <label class="text-bold">Totales: </label>
                <div class="col">
                    <input type="checkbox" id="total_i" name="total_i" value="1" class="minimal" onkeypress="if(event.keyCode == 13){ Insert_Producto_Interes(); }"> 
                </div>
            </div>

            <div class="form-group col-md-3">
                <label class="text-bold">Formulario: </label>
                <div class="col">
                    <input type="checkbox" id="formulario_i" name="formulario_i" value="1" class="minimal" onkeypress="if(event.keyCode == 13){ Insert_Producto_Interes(); }"> 
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Producto_Interes();">
            <i class="glyphicon glyphicon-ok-sign"></i>Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i>Cancelar
        </button>
    </div>
</form>

<script>
    $('#orden_producto_interes_i').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Traer_Sede_I(){
        Cargando();
        
        var url = "<?php echo site_url(); ?>General/Traer_Sede_Producto_Interes";
        var id_empresa = $("#id_empresa_i").val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_empresa':id_empresa},
            success: function(data){
                $('#id_sede_i').html(data);
            }
        });
    }

    function Insert_Producto_Interes(){
        Cargando();
        
        var dataString = $("#formulario_insert").serialize();
        var url="<?php echo site_url(); ?>General/Insert_Producto_Interes";

        if (Valida_Insert_Producto_Interes()) {
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
                        Lista_Producto_Interes();
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }
    }

    function Valida_Insert_Producto_Interes() {
        if($('#id_empresa_i').val()=="0") { 
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_sede_i').val()=="0") { 
            Swal(
                'Ups!',
                'Debe seleccionar Sede',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nom_producto_interes_i').val()=="") { 
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fecha_inicio_i').val()=="") { 
            Swal(
                'Ups!',
                'Debe ingresar Fecha Inicio',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fecha_fin_i').val()=="") { 
            Swal(
                'Ups!',
                'Debe ingresar Fecha Fin',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>