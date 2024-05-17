<style>
    .grande_check{
        width: 20px;
        height: 20px;
    }
</style>

<form id="formulario" method="POST" enctype="multipart/form-data"  class="horizontal" >
    <div class="modal-header" >
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Empresa (Nueva)</b></h5>
    </div>

    <div class="modal-body">
        <div class="col-md-12 row">
            <div class="form-group col-md-2 ">
                <label class="form-group ">Marca:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="nombre" name="nombre" maxlength="50" placeholder="Ingresar Marca" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="form-group ">Código Marca:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="cod_empresa" name="cod_empresa" maxlength="2" placeholder="Ingresar Código Marca" autofocus>
            </div>  

            <div class="form-group col-md-2">
                <label class="form-group ">Código&nbsp;Empresa:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="cd_empresa" name="cd_empresa" maxlength="5" placeholder="Ingresar Código Empresa" autofocus>
            </div>  
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="form-group ">Empresa:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nom_empresa" name="nom_empresa" maxlength="50" placeholder="Ingresar Empresa" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="form-group">RUC:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="ruc" name="ruc" maxlength="11" onkeypress="return soloNumeros(event)" placeholder="Ingresar RUC" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="form-group" for="emailp">Web:</label>
            </div>
            <div class="form-group col-md-6">
                <input type="text" class="form-control" id="web" name="web" placeholder="Ingresar Web" autofocus>
            </div>  

            <div class="form-group col-md-2">
                <label class="form-group">Orden Menú:</label>
            </div>
            <div class="form-group col-md-2">
                <select class="form-control" name="orden_menu" id="orden_menu">
                    <option value="0">Seleccione</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
            </div>  

            <div class="form-group col-md-2">
                <label class="form-group">Cuenta&nbsp;Bancaria:</label>
            </div>
            <div class="form-group col-md-6">
                <input type="text" class="form-control" id="cuenta_bancaria" name="cuenta_bancaria" onkeypress="return soloNumeros(event)" placeholder="Ingresar Cuenta Bancaria" maxlength="18" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="form-group">Inicio C. Bancaria:</label> 
            </div>
            <div class="form-group col-md-2">
                <select class="form-control" id="inicio" name="inicio">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_anio as $list){ 
                        foreach($list_mes as $mes){ ?>
                            <option value="<?php echo $mes['cod_mes']."/".$list['nom_anio']; ?>">
                                <?php echo substr($mes['nom_mes'],0,3)."/".substr($list['nom_anio'],-2); ?>
                            </option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div> 
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="form-group">Estado: </label>
            </div>
            <div class="form-group col-md-2">
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
            
            <div class="form-group col-md-2">
                <label class="form-group">Color Marca:</label>
            </div>
            <div class="form-group col-md-2">
                <input type="color" value="#ff0000" class="form-control" id="color" name="color" maxlength="20" >   
            </div>

            <div class="form-group col-md-2">
                <label class="form-group">Informe Redes: </label><span>&nbsp;</span>
            </div>
            <div class="form-group col-md-2">
                <input type="checkbox" class="grande_check" id="rep_redes" name="rep_redes" value="1">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="form-group">Informe SUNAT: </label><span>&nbsp;</span>
            </div>
            <div class="form-group col-md-1">
                <input type="checkbox" class="grande_check" id="rep_sunat" name="rep_sunat" value="1">
            </div>

            <div class="form-group col-md-2">
                <label class="form-group">Balance: </label>
            </div>
            <div class="form-group col-md-1">
                <input type="checkbox" class="grande_check" id="balance" name="balance" value="1">
            </div>

            <div class="form-group col-md-2">
                <label class="form-group">Fecha Inicio: </label>
            </div>
            <div class="form-group col-md-3">
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="1">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Imagen: </label>
            </div>
            <div class="form-group col-md-5">
                <input type="file" id="imagen" name="imagen">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" style="background-color:#715d74;border-color:#715d74" class="btn btn-primary" onclick="Insert_Empresa();" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    /*$('#imagen').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        maxTotalFileCount: 1,
        showUpload: false,
        overwriteInitial: false,
        initialPreviewAsData: true,
        allowedFileExtensions: ['png','jpeg','jpg'],
    });*/
</script>

<script>
    function soloNumeros(e) {
        var key = e.keyCode || e.which,
        tecla = String.fromCharCode(key).toLowerCase(),
        //letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
        letras = "0123456789",
        especiales = [8, 37, 39, 46],
        tecla_especial = false;

        for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
        }

        if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
        }
    }
</script>

<script>
    function pulsar(e) {
        if (e.keyCode === 13 && !e.shiftKey) {
            e.preventDefault();
            //document.querySelector("#submit").click();
            Insert_Empresa();
        }
    }
    function Insert_Empresa(){
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

        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?php echo site_url(); ?>General/Insert_Empresa";

        if(valida_empresa()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        /*Swal({
                            title: 'Registro Denegado',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });*/
                        swal.fire(
                            'Registro Denegado!',
                            '¡El registro ya existe!',
                            'error'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>General/Empresas";
                        });
                    }else{
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>General/Empresas";
                        });
                    }
                }
            });     
        }
    }

    function valida_empresa() {
        if($('#nombre').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Marca.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#cod_empresa').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Código Marca.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#cd_empresa').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Código Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#ruc').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar RUC.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#ruc').val().length!=11){
            Swal(
                'Ups!',
                'Debe ingresar RUC válido.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#orden_menu').val()=== '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Orden Menú.',
                'warning'
            ).then(function() { });
            return false;
        }
        /*if($('#cuenta_bancaria').val()=== '') {
            Swal(
                'Ups!',
                'Debe ingresar Cuenta Bancaria.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#inicio').val()=== '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Inicio.',
                'warning'
            ).then(function() { });
            return false;
        }*/
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
