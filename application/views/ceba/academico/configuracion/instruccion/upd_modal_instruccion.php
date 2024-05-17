<form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Actualización de Instrucción</b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Grado: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_grado" id="id_grado" onchange="Modulo()">
                    <option value="0">Seleccione</option>
                        <?php foreach($list_grado as $list){ 
                        if($get_id[0]['id_grado'] == $list['id_grado']){ ?>
                        <option selected value="<?php echo $list['id_grado'] ; ?>">
                        <?php echo $list['descripcion_grado'];?></option>
                        <?php }else
                        {?>
                    <option value="<?php echo $list['id_grado']; ?>"><?php echo $list['descripcion_grado'];?></option>
                    <?php }} ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Módulo: </label>
            </div>
            <div class="form-group col-md-4" id="munidad">
                <select class="form-control" name="id_unidad" id="id_unidad" onchange="Tema()">
                <option  value="0"  selected>Seleccionar</option>
                <?php 
                if ($get_id[0]['id_unidad'] != "0" && isset($get_id[0]['id_unidad'])){
                    foreach($list_unidad as $list){
                        if($get_id[0]['id_unidad'] == $list['id_unidad']){ ?> 
                        <option selected value="<?php echo $list['id_unidad']; ?>"><?php echo $list['nom_unidad'];?></option>
                        <?php }else{?>
                        <option value="<?php echo $list['id_unidad']; ?>"><?php echo $list['nom_unidad'];?></option>
                        <?php } 
                    } 
                } ?>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Tema: </label>
            </div>
            <div class="form-group col-md-4" id="mtema">
                <select class="form-control" name="id_tema" id="id_tema">
                <option  value="0"  selected>Seleccionar</option>
                <?php 
                if ($get_id[0]['id_tema'] != "0" && isset($get_id[0]['id_tema'])){
                    foreach($list_tema as $list){
                        if($get_id[0]['id_tema'] == $list['id_tema']){ ?> 
                        <option selected value="<?php echo $list['id_tema']; ?>"><?php echo $list['referencia'];?></option>
                        <?php }else{?>
                        <option value="<?php echo $list['id_tema']; ?>"><?php echo $list['referencia'];?></option>
                        <?php } 
                    } 
                } ?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label class="form-group col text-bold">Registrado&nbsp;por: </label>
            </div>
            <div class="form-group col-md-3">
                <?php echo $get_id[0]['usuario_codigo']; ?>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Imagen: </label>
                <input name="imagen_instru" id="imagen_instru" type="file" data-allowed-file-extensions='["png"]'  size="100" required >
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Imagen Subida: </label>
            </div>
            <div class="form-group col-md-4">
            <?php if ($get_id[0]['imagen']!="") { ?>
                <a href="<?php echo base_url().$get_id[0]['imagen']; ?> "size="100" target="_blank" ></a>
                <div id="d_pdf" >
                    <iframe id="pdf" src="<?php echo base_url().$get_id[0]['imagen']; ?>" width="250"> </iframe>
                </div>
                <div id="pdf-main-container">
                    <div id="pdf-contents">
                    <canvas id="pdf-canvas" height="50" width="195"></canvas>
                        <div id="pdf-meta">
                        <div id="pdf-buttons">
                        </div>
                        </div> 
                    </div>
                </div>
                <?php } else { echo "No ha adjuntado ningún archivo"; } ?>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Regla: </label>
            </div>
            <div class="form-group col-md-10">
                <textarea class="form-control" required id="regla"  maxlength="200" name="regla" placeholder= "Ingresar Regla" rows="4" cols="50"><?php echo $get_id[0]['regla'] ?></textarea>
            </div>

            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Estado: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_status" id="id_status">
                    <option value="0">Seleccione</option>
                        <?php foreach($list_estado as $list){ 
                        if($get_id[0]['estado'] == $list['id_status_general']){ ?>
                        <option selected value="<?php echo $list['id_status_general'] ; ?>">
                        <?php echo $list['nom_status'];?></option>
                        <?php }else
                        {?>
                    <option value="<?php echo $list['id_status_general']; ?>"><?php echo $list['nom_status'];?></option>
                    <?php }} ?>
                </select>
            </div>
        </div>  	           	                	        
    </div>

    <div class="modal-footer">
        <input name="id_instruccion" type="hidden" class="form-control" id="id_instruccion" value="<?php echo $get_id[0]['id_instruccion']; ?>">
        <button class="btn btn-primary mt-3" type="button" onclick="Update_Instruccion();">
            <i class="glyphicon glyphicon-ok-sign"></i>Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Modulo(){
        var url = "<?php echo site_url(); ?>Ceba/Grado_Unidad";
        $.ajax({
            url: url,
            type: 'POST',
            data: $("#formulario").serialize(),
            success: function(data)             
            {
                $('#munidad').html(data);
            }
        });
        Tema();
    }

    function Tema(){
        var url = "<?php echo site_url(); ?>Ceba/Unidad_Tema";
        $.ajax({
            url: url,
            type: 'POST',
            data: $("#formulario").serialize(),
            success: function(data)             
            {
                $('#mtema').html(data);
            }
        });
    }

    function Update_Instruccion(){
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
        var url="<?php echo site_url(); ?>Ceba/Update_Instruccion";

        if (Valida_Actu_Instruccion()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>Ceba/Instruccion";
                    });
                }
            }); 
        }    
    }

    function Valida_Actu_Instruccion() {
        if($('#id_grado').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Grado.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#id_unidad').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Módulo.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#id_tema').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tema.',
                'warning'
            ).then(function() { });
            return false;
        }

        return true;
    }
</script>