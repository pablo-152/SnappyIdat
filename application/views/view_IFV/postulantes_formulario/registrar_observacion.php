<?php $sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
$id_usuario = $sesion['id_usuario'];
?>
<div class="col-md-12 row">
    <div class="form-group col-md-2">
        <label class="control-label text-bold">Tipo:</label>
        <select class="form-control" id="id_tipo_o" name="id_tipo_o">
            <option  value="0">Seleccione</option>
            <?php foreach($list_tipo_obs as $list){ ?>
                <option value="<?php echo $list['id_tipo']; ?>"><?php echo $list['nom_tipo']; ?></option>
            <?php } ?>
        </select> 
    </div>

    <?php if($id_nivel==1 || $id_nivel==6){ ?>
        <div class="form-group col-md-2">
            <label class="control-label text-bold">Fecha:</label>
            <input class="form-control" type="date" id="fecha_o" name="fecha_o" value="<?php echo date('Y-m-d'); ?>"> 
        </div>

        <div class="form-group col-md-2">
            <label class="control-label text-bold">Usuario:</label>
            <select class="form-control" id="usuario_o" name="usuario_o">
                <option value="0">Seleccione</option>
                <?php foreach($list_usuario as $list){ ?> 
                    <option value="<?php echo $list['id_usuario'] ?>">
                        <?php echo $list['usuario_codigo']; ?>
                    </option>    
                <?php } ?>
            </select>
        </div>
        
    <?php }else{ ?>
        <div class="form-group col-md-2">
            <label class="control-label text-bold">Fecha:</label>
            <input class="form-control" type="date" readonly="yes" id="fecha_o" name="fecha_o" value="<?php echo date('Y-m-d'); ?>"> 
        </div>

        <div class="form-group col-md-2">
            <label class="control-label text-bold">Usuario:</label>
            <p><?php echo $_SESSION['usuario'][0]['usuario_codigo'] ?></p>
            <input type="hidden" id="usuario_o" name="usuario_o" value="<?php echo $_SESSION['usuario'][0]['id_usuario']; ?>">
        </div>
    <?php } ?>
    

    <div class="form-group col-md-4">
        <label class="control-label text-bold">Comentario:</label>
        <div class="">
            <input class="form-control" type="text" id="observacion_o" name="observacion_o" maxlength="150" placeholder="Comentario">
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Archivo:</label>
        <button type="button" onclick="Abrir('observacion_archivo')">Seleccionar archivo</button>
        <input type="file" id="observacion_archivo" name="observacion_archivo" onchange="Nombre_Archivo2(this,'span_observacion_archivo')" style="display: none">
        <span id="span_observacion_archivo"></span>
    </div>

    <!--
    <div class="form-group col-md-4">
        <div class="">
            <input class="form-control" type="text" id="comentariog_o" name="comentariog_o" maxlength="45" value=" ">
        </div>
    </div>-->
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" onclick="limpiarFormularioObservacion()">
        <i class="glyphicon glyphicon-remove-sign"></i>Limpiar
    </button>
    <button id="boton_obs" type="button" class="btn btn-primary" onclick="Insert_Observacion_Postulante()">
        <i class="glyphicon glyphicon-ok-sign"></i>Guardar
    </button>
</div>

<script>
    function Abrir(id) {
        var file = document.getElementById(id);
        file.dispatchEvent(new MouseEvent('click', {
            view: window,
            bubbles: true,
            cancelable: true
        }));
    }

    function Nombre_Archivo2(element,glosa) { 
        var glosa = document.getElementById(glosa);

        if(element=="") {
            glosa.innerText = "No se eligió archivo";
        }
        else {
            if(element.files[0].name.substr(-3)=='pdf' || element.files[0].name.substr(-3)=='png' ||
            element.files[0].name.substr(-3)=='PDF' || element.files[0].name.substr(-3)=='PNG' ||
            element.files[0].name.substr(-3)=='jpg' || element.files[0].name.substr(-4)=='jpeg' ||
            element.files[0].name.substr(-3)=='JPG' || element.files[0].name.substr(-4)=='JPEG' ||
            element.files[0].name.substr(-3)=='mp4'){
                glosa.innerText = element.files[0].name;
            }else{
                Swal({
                    title: 'Registro Denegado',
                    text: "Asegurese de ingresar archivo con extensión .pdf, .jpg, .png ó .mp4.",
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
                archivoInput.value = '';
                return false;
            }
        }
    }
</script>