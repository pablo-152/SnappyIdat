<link href="<?php echo base_url(); ?>template/inputfiles/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="<?php echo base_url(); ?>template/inputfiles/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>template/inputfiles/js/plugins/piexif.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/plugins/sortable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/fileinput.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/locales/fr.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/locales/es.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/themes/fas/theme.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/themes/explorer-fas/theme.js" type="text/javascript"></script>


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

<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Editar Base de Datos</h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-3">
                <label class="control-label text-bold">Empresa: </label>
                <select class="form-control" id="id_empresa_u" name="id_empresa_u" onchange="Sede_U();">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_empresa as $list){ ?>
                        <option value="<?php echo $list['id_empresa']; ?>" <?php if($list['id_empresa']==$get_id[0]['id_empresa']){ echo "selected"; } ?>>
                            <?php echo $list['cod_empresa']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            
            <div id="div_sede_u" class="form-group col-md-3">
                <label class="control-label text-bold">Sede:</label>
                <select class="form-control" id="id_sede_u" name="id_sede_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_sede as $list){
                        if($list['id_empresa']==$get_id[0]['id_empresa']){ ?>
                            <option value="<?php echo $list['id_sede']; ?>" <?php if (!(strcmp($list['id_sede'], $get_id[0]['id_sede']))){ echo "selected=\"selected\"";} ?>><?php echo $list['cod_sede']; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Base de Datos: </label>
                <input type="text" class="form-control" id="nom_base_datos_u" name="nom_base_datos_u" placeholder="Base de Datos" value="<?php echo $get_id[0]['nom_base_datos']; ?>" onkeypress="if(event.keyCode == 13){ Update_Base_Datos(); }">
            </div>

            <div class="form-group col-md-3">
                <label class="control-label text-bold">Estado: </label>
                <select class="form-control" id="estado_u" name="estado_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_status as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if (!(strcmp($list['id_status'], $get_id[0]['estado']))){ echo "selected=\"selected\"";} ?>><?php echo $list['nom_status']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Archivo: </label>
                <a href="<?= site_url('Administrador/Plantilla_Base_Datos') ?>" title="Estructura de Excel">
                    <img src="<?= base_url() ?>template/img/excel_tabla.png" alt="Exportar Excel"/>
                </a>
                <input type="file" id="archivo_u" name="archivo_u" data-allowed-file-extensions='["xls|xlsx"]' size="100" required>
            </div>

            <?php if(count($list_numero)>0){ ?>
                <?php 
                    $numeros="";
                    foreach($list_numero as $list){
                        $numeros=$numeros.$list['numero'].",";
                    } 
                ?>
                <div class="form-group col-md-12">
                    <label class="control-label text-bold">Números: </label>
                    <textarea class="form-control" rows="5" readonly><?php echo substr($numeros,0,-1) ?></textarea>
                </div>
            <?php } ?>

            <?php if($get_id[0]['archivo']!=""){ ?>
                <div id="label_subido" class="col-md-12 row">
                    <div class="form-group col-md-4">
                        <label class="control-label text-bold">Archivo Subido: </label>
                    </div>
                </div>  
                <div class="col-md-12 row">
                    <?php if(substr($get_id[0]['archivo'],-3) === "xls" || substr($get_id[0]['archivo'],-4) === "xlsx"){ ?>
                        <div id="i_2" class="form-group col-md-3">
                            <?php 
                                if(substr($get_id[0]['archivo'],-3) === "xls"){
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($get_id[0]['archivo'],-27) .'" src="' . base_url() ."/template/inputfiles/excel_example.png". '"></div>';
                                }else{
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($get_id[0]['archivo'],-28) .'" src="' . base_url() ."/template/inputfiles/excel_example.png". '"></div>'; 
                                }
                            ?>
                            <a style="cursor:pointer;" class="download" type="button" id="download_excel" data-image_id="<?php echo $get_id[0]['id_base_datos']?>">
                                <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                            </a>
                            <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==5 || $_SESSION['usuario'][0]['id_usuario']==7){ ?>
                                <a style="cursor:pointer;" class="delete" type="button" id="delete_excel" data-image_id="<?php echo  $get_id[0]['id_base_datos']?>">
                                    <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                                </a>
                            <?php } ?>
                        </div>
                    <?php } ?>  
                </div>
            <?php } ?>
        </div>
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_base_datos" name="id_base_datos" value="<?php echo $get_id[0]['id_base_datos']; ?>">
        <input type="hidden" id="archivo_actual" name="archivo_actual" value="<?php echo $get_id[0]['archivo']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Base_Datos();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button> 
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $(document).on('click', '#download_excel', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>Administrador/Descargar_Archivo_Bd/"+image_id);
    });

    $(document).on('click', '#delete_excel', function () {
        var image_id = $(this).data('image_id');
        var file_col = $('#i_2');
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>Administrador/Delete_Archivo_Bd',
            data: {'image_id':image_id},
            success: function (data) {
                file_col.remove(); 
                $('#label_subido').hide();        
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
    function Sede_U(){
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
        
        var url = "<?php echo site_url(); ?>Administrador/Buscar_Sede_U";
        var id_empresa = $("#id_empresa_u").val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_empresa':id_empresa},
            success: function(data){
                $('#div_sede_u').html(data);
            }
        });
    }

    function Update_Base_Datos(){
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

        var tipo = $("#tipo_excel").val();
        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>Administrador/Update_Base_Datos";
        var url2="<?php echo site_url(); ?>Administrador/Update_Base_Datos_Con_Error";

        if (Valida_Base_Datos()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data!=""){
                        if(data=="cargado"){
                            Swal({
                                title: 'Registro Denegado',
                                text: "¡Hay un archivo cargado!",
                                type: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK',
                            });
                        }else if(data=="falta"){
                            Swal({
                                title: 'Registro Denegado',
                                text: "¡Debe seleccionar Archivo!",
                                type: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK',
                            });
                        }else{
                            swal.fire(
                                'Errores Encontrados!',
                                data.split("*")[0],
                                'error'
                            ).then(function() {
                                if(data.split("*")[1]=="INCORRECTO"){
                                    Lista_Base_Datos(tipo);
                                     $("#acceso_modal_mod .close").click()
                                }else{
                                    Swal({
                                        title: '¿Desea registrar de todos modos?',
                                        text: "El archivo contiene errores y no se cargara esa(s) fila(s)",
                                        type: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Si',
                                        cancelButtonText: 'No',
                                    }).then((result) => {
                                        if (result.value) {
                                            $.ajax({
                                                type:"POST",
                                                url:url2,
                                                data: dataString,
                                                processData: false,
                                                contentType: false,
                                                success:function () {
                                                    swal.fire(
                                                        'Actualización Exitosa!',
                                                        'Haga clic en el botón!',
                                                        'success'
                                                    ).then(function() {
                                                        Lista_Base_Datos(tipo);
                                                         $("#acceso_modal_mod .close").click()
                                                    });
                                                }
                                            });
                                        }
                                    })
                                }
                            });
                        }
                    }else{
                        swal.fire(
                            'Actualización Exitosa!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Base_Datos(tipo);
                             $("#acceso_modal_mod .close").click()
                        });
                    }
                }
            });
        }
    }

    function Valida_Base_Datos() {
        if($('#id_empresa_u').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_sede_u').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Sede.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nom_base_datos_u').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Base de Datos.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_u').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Estado.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_u').val() === '2') {
            if($('#archivo_actual').val() === '') {
                if($('#archivo_u').val() === '') {
                    Swal(
                        'Ups!',
                        'Debe seleccionar Archivo.',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
        }
        return true;
    }
</script>