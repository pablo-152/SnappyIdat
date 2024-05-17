<form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>Sede (Nueva)</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4 ">
                <label class="text-bold">Empresa: </label>
                <div class="col">
                    <select class="form-control" name="id_empresa" id="id_empresa">
                    <option value="0">Seleccione</option>
                        <?php foreach ($list_empresa as $empresa) {?>
                        <option value="<?php echo $empresa->id_empresa; ?>"><?php echo $empresa->cod_empresa; ?></option>
                    <?php }?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="text-bold">Código: </label>

                <div class="col">
                    <select class="form-control" name="cod_sede" id="cod_sede">
                    <option value="">Seleccione</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="text-bold">Base&nbsp;de&nbsp;Datos:</label>

                <div class="col">
                    <select class="form-control" id="b_datos" name="b_datos">
                        <option value="0">No</option>
                        <option value="1">Si</option>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="text-bold">Local:</label>

                <div class="col">
                    <select class="form-control" id="id_local" name="id_local">
                        <option value="0">Ninguno</option>
                        <option value="1">Jesús María</option>
                        <option value="2">Chincha</option>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="text-bold">Aparece Menú: </label>
                <select class="form-control" id="aparece_menu" name="aparece_menu">
                    <option value="0">No</option>
                    <option value="1">Si</option>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="text-bold">Orden Menú: </label>
                <input type="text" class="form-control" id="orden_menu" name="orden_menu" placeholder="Orden Menú">
            </div>

            <div class="form-group col-md-12">
                <label class="text-bold">Observaciones: </label>
                <div class="col ">
                    <textarea name="observaciones_sede" rows="4" class="form-control" id="observaciones_sede"></textarea>
                </div>
            </div>


            <div class="form-group col-md-4">
                <label class="text-bold">Status: </label>
                <div class="col">
                    <select class="form-control" name="estado" id="estado">
                    <option value="0" >Seleccione</option>
                        <?php foreach($list_estado as $estado){
                        if($estado["id_status"] == 2){ ?>
                            <option selected value="<?php echo $estado['id_status']; ?>"><?php echo $estado['nom_status'];?></option>
                            <?php }else{?>
                        <option value="<?php echo $estado['id_status']; ?>"><?php echo $estado['nom_status'];?></option>
                        <?php } } ?>
                    </select>
                </div>
            </div>
        </div>  	           	                	        
    </div> 
    
    <div class="modal-footer">
        <button type="button" style="background-color:#715d74;border-color:#715d74" class="btn btn-primary" onclick="Insert_Sede();" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $('#orden_menu').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function pulsar(e) {
        if (e.keyCode === 13 && !e.shiftKey) {
            e.preventDefault();
            Insert_Sede();
        }
    }

    function Insert_Sede(){
        Cargando();

        var dataString = $("#formulario").serialize();
        var url="<?php echo site_url(); ?>General/Insert_sede";

        if (valida_sede()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    if(data=="error") {
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else if(data=="limiteemp") {
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡Solo se pueden asignar sedes para 6 empresas, por favor verificar!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else if(data=="xempresa") {
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡Solo se pueden asignar 3 sedes por empresa para Base de Datos!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else if(data=="bd") {
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡Solo se pueden asignar 18 sedes en total para Base de Datos!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>General/Sedes";
                        });
                    }
                }
            });         
        }
    }

    function valida_sede() {
        if($('#id_empresa').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#cod_sede').val() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Código.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado').val() === '0') {
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


