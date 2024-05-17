<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">

<style>
    .input-group > .input-group-append > .btn, .input-group > .input-group-append > .input-group-text, .input-group > .input-group-prepend:first-child > .btn:not(:first-child), .input-group > .input-group-prepend:first-child > .input-group-text:not(:first-child), .input-group > .input-group-prepend:not(:first-child) > .btn, .input-group > .input-group-prepend:not(:first-child) > .input-group-text {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        /* padding: initial; */
        padding-top: 11px;
    }
    .kv-file-upload{
        display:none!important;
    }
</style>

<style>
    .img-presentation-small-actualizar {
        width: 100%;
        height: 200px;
        object-fit: cover;
        cursor: pointer;
        margin: 5px;
    }

    .img-presentation-small-actualizar_support {
        width: 100%;
        height: 150px;
        object-fit: cover;
        cursor: pointer;
        margin: 5px;
    }
</style>

<style>
    .grande_check{
        width: 20px;
        height: 20px;
    }
</style>

<form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: #715d74;font-size: 21px;"><b >Editar Empresa</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Marca:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="nombre" name="nombre" maxlength="50"  placeholder="Ingresar Marca" value="<?php echo $get_id[0]['empresa']; ?>" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Código Marca:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="cod_empresa" name="cod_empresa" maxlength="2" placeholder="Ingresar Código Marca" value="<?php echo $get_id[0]['cod_empresa']; ?>" autofocus>
            </div>  

            <div class="form-group col-md-2">
                <label class="form-group ">Código Empresa:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="cd_empresa" name="cd_empresa" maxlength="5" placeholder="Ingresar Código Empresa" value="<?php echo $get_id[0]['cd_empresa']; ?>" autofocus>
            </div>  
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Empresa:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nom_empresa" name="nom_empresa" maxlength="50" placeholder="Ingresar Empresa" value="<?php echo $get_id[0]['nom_empresa']; ?>" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="form-group col text-bold">RUC:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="ruc" name="ruc" placeholder="Ingresar RUC" onkeypress="return soloNumeros(event)" maxlength="11" value="<?php echo $get_id[0]['ruc']; ?>" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="form-group col text-bold" for="emailp" >Web:</label>
            </div>
            <div class=" form-group col-md-6">
                <input type="text" class="form-control" id="web" name="web" placeholder="Ingresar Web" value="<?php echo $get_id[0]['web']; ?>" autofocus>
            </div>  

            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Orden Menú:</label>
            </div>
            <div class=" form-group col-md-2">
                <select class="form-control" name="orden_menu" id="orden_menu">
                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['orden_menu']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                    <option value="1" <?php if (!(strcmp(1, $get_id[0]['orden_menu']))) {echo "selected=\"selected\"";} ?>>1</option>
                    <option value="2" <?php if (!(strcmp(2, $get_id[0]['orden_menu']))) {echo "selected=\"selected\"";} ?>>2</option>
                    <option value="3" <?php if (!(strcmp(3, $get_id[0]['orden_menu']))) {echo "selected=\"selected\"";} ?>>3</option>
                    <option value="4" <?php if (!(strcmp(4, $get_id[0]['orden_menu']))) {echo "selected=\"selected\"";} ?>>4</option>
                    <option value="5" <?php if (!(strcmp(5, $get_id[0]['orden_menu']))) {echo "selected=\"selected\"";} ?>>5</option>
                    <option value="6" <?php if (!(strcmp(6, $get_id[0]['orden_menu']))) {echo "selected=\"selected\"";} ?>>6</option>
                    <option value="7" <?php if (!(strcmp(7, $get_id[0]['orden_menu']))) {echo "selected=\"selected\"";} ?>>7</option>
                    <option value="8" <?php if (!(strcmp(8, $get_id[0]['orden_menu']))) {echo "selected=\"selected\"";} ?>>8</option>
                    <option value="9" <?php if (!(strcmp(9, $get_id[0]['orden_menu']))) {echo "selected=\"selected\"";} ?>>9</option>
                    <option value="10" <?php if (!(strcmp(10, $get_id[0]['orden_menu']))) {echo "selected=\"selected\"";} ?>>10</option>
                </select>
            </div>  

            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Cuenta&nbsp;Bancaria:</label>
            </div>
            <div class="form-group col-md-6">
                <input type="text" class="form-control" id="cuenta_bancaria" name="cuenta_bancaria" onkeypress="return soloNumeros(event)" placeholder="Ingresar Cuenta Bancaria" maxlength="18" value="<?php echo $get_id[0]['cuenta_bancaria']; ?>" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Inicio:</label>    
            </div>
            <div class="form-group col-md-2">
                <select class="form-control" id="inicio" name="inicio">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_anio as $list){ 
                        foreach($list_mes as $mes){ ?>
                            <option value="<?php echo $mes['cod_mes']."/".$list['nom_anio']; ?>"
                            <?php if($mes['cod_mes'].$list['nom_anio']==$get_id[0]['mes'].$get_id[0]['anio']){ echo "selected"; } ?>>
                                <?php echo substr($mes['nom_mes'],0,3)."/".substr($list['nom_anio'],-2); ?>
                            </option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div> 

            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Estado: </label>
            </div>
            <div class="form-group col-md-2">
                <select class="form-control" name="estado" id="estado">
                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                    <?php foreach($list_estado as $estado){ ?>
                        <option value="<?php echo $estado['id_status']; ?>"
                            <?php if (!(strcmp($estado['id_status'],
                            $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>>
                            <?php echo $estado['nom_status'];?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="form-group">Color Marca:</label>
            </div>
            <div class="form-group col-md-2">
                <input type="color" value="<?php echo $get_id[0]['color'] ?>" class="form-control" id="color" name="color" maxlength="20" >   
            </div>

            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Informe Redes: </label><span>&nbsp;</span>
            </div>
            <div class="form-group col-md-2">
                <input type="checkbox" class="grande_check" id="rep_redes" name="rep_redes" value="1" <?php if($get_id[0]['rep_redes']!=0){ echo "checked";} ?> class="minimal">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="form-group">Informe SUNAT: </label><span>&nbsp;</span>
            </div>
            <div class="form-group col-md-1">
                <input type="checkbox" class="grande_check" id="rep_sunat" name="rep_sunat" value="1" <?php if($get_id[0]['rep_sunat']!=0){ echo "checked";} ?>>
            </div>

            <div class="form-group col-md-2">
                <label class="form-group">Balance: </label>
            </div>
            <div class="form-group col-md-1">
                <input type="checkbox" class="grande_check" id="balance" name="balance" value="1" <?php if($get_id[0]['balance']!=0){ echo "checked";} ?>>
            </div>

            <div class="form-group col-md-2">
                <label class="form-group">Fecha Inicio: </label>
            </div>
            <div class="form-group col-md-3">
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo $get_id[0]['fecha_inicio']; ?>">
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

        <?php if($get_id[0]['imagen']!=""){ ?>
            <div id="label_imagen" class="col-md-12 row">
                <div class="form-group col-md-4">
                    <label class="control-label text-bold">Imagen Subido: </label>
                </div>
            </div>  
            <div id="contenedor_imagen" class="col-md-12 row">
                <?php if(substr($get_id[0]['imagen'],-3) === "jpg" || substr($get_id[0]['imagen'],-3) === "JPG"){ ?>
                    <div id="i_<?php echo  $get_id[0]['id_empresa']; ?>" class="form-group col-sm-3">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($get_id[0]['imagen'],-27) .'" src="' . base_url() . $get_id[0]['imagen'] . '"></div>'; 
                        ?>
                        <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $get_id[0]['id_empresa']; ?>">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                        </a>
                        <a style="cursor:pointer;" class="delete" type="button" id="delete_file" data-image_id="<?php echo  $get_id[0]['id_empresa']; ?>">
                            <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                        </a>
                    </div>
                <?php }elseif (substr($get_id[0]['imagen'],-3) === "png" || substr($get_id[0]['imagen'],-3) === "PNG"){ ?>
                    <div id="i_<?php echo  $get_id[0]['id_empresa']; ?>" class="form-group col-sm-3">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($get_id[0]['imagen'],-27) .'" src="' . base_url() . $get_id[0]['imagen'] . '"></div>'; 
                        ?> 
                        <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $get_id[0]['id_empresa']; ?>">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                        </a>
                        <a style="cursor:pointer;" class="delete" type="button" id="delete_file" data-image_id="<?php echo  $get_id[0]['id_empresa']; ?>">
                            <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                        </a>
                    </div>
                <?php }elseif (substr($get_id[0]['imagen'],-4) === "jpeg" || substr($get_id[0]['imagen'],-4) === "JPEG"){ ?>
                    <div id="i_<?php echo  $get_id[0]['id_empresa']; ?>" class="form-group col-sm-3">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($get_id[0]['imagen'],-28) .'" src="' . base_url() . $get_id[0]['imagen'] . '"></div>'; 
                        ?>
                        <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $get_id[0]['id_empresa']; ?>">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                        </a>
                        <a style="cursor:pointer;" class="delete" type="button" id="delete_file" data-image_id="<?php echo  $get_id[0]['id_empresa']; ?>">
                            <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                        </a>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>          	                	        
    </div> 
    
    <div class="modal-footer">
        <input type="hidden" id="actual_cb" name="actual_cb" value="<?php echo $get_id[0]['cuenta_bancaria']; ?>">
        <input type="hidden" id="id_empresa" name="id_empresa" value="<?php echo $get_id[0]['id_empresa']; ?>">
        <input type="hidden" id="imagen_actual" name="imagen_actual" value="<?php echo $get_id[0]['imagen']; ?>">
        <button type="button" style="background-color:#715d74;border-color:#715d74" class="btn btn-primary" onclick="Update_Empresa();" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

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
    function pulsar(e) {
        if (e.keyCode === 13 && !e.shiftKey) {
            e.preventDefault();
            //document.querySelector("#submit").click();
            Update_Empresa();
        }
    }
    $(".img_post").click(function () {
        window.open($(this).attr("src"), 'popUpWindow', 
        "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
    });

    $(document).on('click', '#download_file', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>General/Descargar_Imagen_Empresa/" + image_id);
    });

    $(document).on('click', '#delete_file', function () {
        var image_id = $(this).data('image_id');
        var file_col = $('#i_' + image_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>General/Delete_Imagen_Empresa',
            data: {'image_id': image_id},
            success: function (data) {
                file_col.remove();            
            }
        });
    });
</script>

<script>
    var anchors = document.querySelectorAll('.anchor-tooltip');
    anchors.forEach(function(anchor) {
        var toolTipText = anchor.getAttribute('title'),
        toolTip = document.createElement('span');
        toolTip.className = 'title-tooltip';
        toolTip.innerHTML = toolTipText;
        anchor.appendChild(toolTip);
    });
</script>

<script>
    $('#cuenta_bancaria').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>

<script>
    function Update_Empresa(){
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
        var url="<?php echo site_url(); ?>General/Update_Empresa";

        if (valida_empresa()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>General/Empresas";
                    });
                }
            });       
        }
    }

    function valida_empresa() {
        if($('#nombre').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#cod_empresa').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Código.',
                'warning'
            ).then(function() { });
            return false;
        }
        /*if($('#cd_empresa').val().trim() === '') {
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
        }*/
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
