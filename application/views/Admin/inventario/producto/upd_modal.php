<script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/loaders/pace.min.js"></script>
<script type="text/javascript" src="<?=base_url() ?>template/assets/js/core/libraries/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url() ?>template/assets/js/pages/uploader_bootstrap.js"></script>

<link href="<?php echo base_url(); ?>template/inputfiles/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="<?php echo base_url(); ?>template/inputfiles/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>template/inputfiles/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/plugins/piexif.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/plugins/sortable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/fileinput.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/locales/fr.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/locales/es.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/themes/fas/theme.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/themes/explorer-fas/theme.js" type="text/javascript"></script>


<form id="formulario_prodie" method="POST" enctype="multipart/form-data" action="<?= site_url('Snappy/Update_Tipo')?>"  class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Actualizar Producto: </b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-1">
                <label>Ref:</label>
            </div>

            <div class="form-group col-md-2">
                <input type="text" readonly class="form-control" id="referencia" name="referencia" value="<?php echo $get_id[0]['referencia'] ?>" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Tipo:</label>
            </div>

            <div class="form-group col-md-3">
                <select required class="form-control" name="id_tipo_inventario" id="id_tipo_inventario" onchange="Busca_Subtipo()">
                <option value="0">Seleccione</option>
                <?php foreach($list_tipo as $list){ 
                    if($get_id[0]['id_tipo_inventario']==$list['id_tipo_inventario']){?>
                    <option selected value="<?php echo $list['id_tipo_inventario']; ?>"><?php echo $list['nom_tipo_inventario'];?></option>
                    <?php }else{?> 
                        <option value="<?php echo $list['id_tipo_inventario']; ?>"><?php echo $list['nom_tipo_inventario'];?></option>
                    <?php } } ?>
                </select>
            </div>

            <div class="form-group col-md-1">
                <label>Sub-Tipo:</label>
            </div>

            <div class="form-group col-md-3" id="div_subtipo">
                <select required class="form-control" name="id_subtipo_inventario" id="id_subtipo_inventario">
                <option value="0">Seleccione</option>
                <?php foreach($list_subtipo as $list){ 
                if($get_id[0]['id_subtipo_inventario']==$list['id_subtipo_inventario']){?>
                <option selected value="<?php echo $list['id_subtipo_inventario']; ?>"><?php echo $list['nom_subtipo_inventario'];?></option>
                <?php }else{?> 
                    <option value="<?php echo $list['id_subtipo_inventario']; ?>"><?php echo $list['nom_subtipo_inventario'];?></option>
                <?php } } ?>
                </select>
            </div>

            <div class="form-group col-md-1 ">
                <input type="text" readonly class="form-control"  id="estado" name="estado" autofocus>
            </div>

        
            <div class="form-group col-md-1">
                <label>Descripción:</label>
            </div>

            <div class="form-group col-md-6 ">
                <input type="text"   class="form-control" value="<?php echo $get_id[0]['producto_descripcion'] ?>"  id="producto_descripcion" name="producto_descripcion" autofocus>
            </div>
        

            <div class="form-group col-md-2">
                <label>Fecha&nbsp;Compra:</label>
            </div>

            <div class="form-group col-md-3 ">
                <input type="date" class="form-control" value="<?php echo $get_id[0]['fec_compra'] ?>" id="fec_compra" name="fec_compra" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Proveedor:</label>
            </div>

            <div class="form-group col-md-2 ">
                <input type="text"   class="form-control" value="<?php echo $get_id[0]['proveedor'] ?>" id="proveedor" name="proveedor" autofocus>
            </div>

            <div class="form-group col-md-1 ">
                <label>Garantía:</label>
            </div>

            <div class="form-group col-md-2 ">
                <input type="date" value="<?php echo $get_id[0]['garantia_h'] ?>"  class="form-control"  id="garantia_h" name="garantia_h" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Precio&nbsp;Unit.:</label>
            </div>

            <div class="form-group col-md-1 ">
                <input type="text" value="<?php echo $get_id[0]['precio_u'] ?>" class="form-control"  id="precio_u" name="precio_u" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Cant.:</label>
            </div>

            <div class="form-group col-md-1 ">
                <input type="text" class="form-control" value="<?php echo $get_id[0]['cantidad'] ?>" id="cantidad" name="cantidad" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Total:</label>
            </div>

            <div class="form-group col-md-1 ">
                <input type="text" readonly class="form-control" value="<?php echo $get_id[0]['total'] ?>" id="total" name="total" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Desv/Año:</label>
            </div>

            <div class="form-group col-md-1 ">
                <input type="text"  class="form-control" value="<?php echo $get_id[0]['desvalorizacion'] ?>" id="desvalorizacion" name="desvalorizacion" placeholder="%" autofocus>
            </div>
            <div class="form-group col-md-1 ">
                <input type="text"  class="form-control" value="<?php echo $get_id[0]['anio'] ?>" id="anio" maxlength="4" name="anio" placeholder="Año" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Gastos:</label>
            </div>

            <div class="form-group col-md-6 ">
                <input type="text"  class="form-control" value="<?php echo $get_id[0]['gastos'] ?>" id="gastos" name="gastos" placeholder="Ingresar Gastos" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Valor&nbsp;Actual:</label>
            </div>

            <div class="form-group col-md-1 ">
                <input type="text"  class="form-control" value="<?php echo $get_id[0]['valor_actual'] ?>" id="valor_actual" name="valor_actual" placeholder="Valor" autofocus>
            </div>

            <?php if($get_id[0]['imagen']!=""){?> 
                <div class="form-group col-md-1">
                    <label>Imágen:</label>
                </div>
            <?php } ?>
            

            <?php if(substr($get_id[0]['imagen'],-3) === "jpg" || substr($get_id[0]['imagen'],-3) === "JPG"){ ?>
                <div id="i_<?php echo  $get_id[0]['id_inventario_producto']?>" class="form-group col-sm-3">
                    <?php 
                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($get_id[0]['imagen'],-27) .'" src="' . base_url() . $get_id[0]['imagen'] . '"></div>'; 
                    ?>
                    <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $get_id[0]['id_inventario_producto']?>">
                        <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                    </a>
                    <a style="cursor:pointer;" class="delete" type="button" id="delete_file" data-image_id="<?php echo  $get_id[0]['id_inventario_producto']?>">
                        <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                    </a>
                </div>
            <?php }elseif (substr($get_id[0]['imagen'],-3) === "png" || substr($get_id[0]['imagen'],-3) === "PNG"){ ?>
                <div id="i_<?php echo  $get_id[0]['id_inventario_producto']?>" class="form-group col-sm-3">
                    <?php 
                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($get_id[0]['imagen'],-27) .'" src="' . base_url() . $get_id[0]['imagen'] . '"></div>'; 
                    ?> 
                    <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $get_id[0]['id_inventario_producto']?>">
                        <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                    </a>
                    <a style="cursor:pointer;" class="delete" type="button" id="delete_file" data-image_id="<?php echo  $get_id[0]['id_inventario_producto']?>">
                        <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                    </a>
                </div>
            <?php }elseif (substr($get_id[0]['imagen'],-4) === "jpeg" || substr($get_id[0]['imagen'],-4) === "JPEG"){ ?>
                <div id="i_<?php echo  $get_id[0]['id_inventario_producto']?>" class="form-group col-sm-3">
                    <?php 
                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($get_id[0]['imagen'],-28) .'" src="' . base_url() . $get_id[0]['imagen'] . '"></div>'; 
                    ?>
                    <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $get_id[0]['id_inventario_producto']?>">
                        <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                    </a>
                    <a style="cursor:pointer;" class="delete" type="button" id="delete_file" data-image_id="<?php echo  $get_id[0]['id_inventario_producto']?>">
                        <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                    </a>
                </div>
            <?php }else{ echo ""; } ?> 

            <div class="form-group col-md-1">
                <label class="text-bold"><?php if($get_id[0]['imagen']!=""){ echo "Reemplazar:"; }else{ echo "Imágen:"; } ?> </label>
            </div>

            <div class="form-group col-md-4">
                <input type="file" id="imagene" name="imagene" class="file-input-overwrite" data-allowed-file-extensions='["JPG|jpg|png|PNG|jpeg|JPEG"]'>
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-1">
                <label>Observ.:</label>
            </div>

            <div class="form-group col-md-11 ">
                <textarea name="producto_obs" rows="4" class="form-control" id="producto_obs"><?php echo $get_id[0]['producto_obs'] ?></textarea>
            </div>

            <?php if(count($list_historial)>0){ ?>
                <div class="form-group col-md-12">
                    <label class="col-sm-12 control-label text-bold">Archivos:</label>
                </div>
            <?php } ?>

        <?php foreach($list_historial as $list) {  ?>
            <?php if(substr($list['archivo'],-3) === "jpg" || substr($list['archivo'],-3) === "JPG"){ ?>
                <div id="i_<?php echo  $list['id_historial_producto']?>" class="form-group col-sm-3">
                    <?php 
                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post_historial img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivo'],-27) .'" src="' . base_url() . $list['archivo'] . '"></div>'; 
                    ?>
                    <a style="cursor:pointer;" class="download" type="button" id="download_file_historial" data-image_id="<?php echo $get_id[0]['id_historial_producto']?>">
                        <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                    </a>
                    <a style="cursor:pointer;" class="delete" type="button" id="delete_file_historial" data-image_id="<?php echo  $list['id_historial_producto']?>">
                        <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                    </a>
                </div>
            <?php }elseif (substr($list['archivo'],-3) === "png" || substr($list['archivo'],-3) === "PNG"){ ?>
                <div id="i_<?php echo  $list['id_historial_producto']?>" class="form-group col-sm-3">
                    <?php 
                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post_historial img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivo'],-27) .'" src="' . base_url() . $list['archivo'] . '"></div>'; 
                    ?> 
                    <a style="cursor:pointer;" class="download" type="button" id="download_file_historial" data-image_id="<?php echo $get_id[0]['id_historial_producto']?>">
                        <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                    </a>
                    <a style="cursor:pointer;" class="delete" type="button" id="delete_file_historial" data-image_id="<?php echo  $list['id_historial_producto']?>">
                        <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                    </a>
                </div>
            <?php }elseif (substr($list['archivo'],-4) === "jpeg" || substr($list['archivo'],-4) === "JPEG"){ ?>
                <div id="i_<?php echo  $list['id_historial_producto']?>" class="form-group col-sm-3">
                    <?php 
                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post_historial img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivo'],-28) .'" src="' . base_url() . $list['archivo'] . '"></div>'; 
                    ?>
                    <a style="cursor:pointer;" class="download" type="button" id="download_file_historial" data-image_id="<?php echo $get_id[0]['id_historial_producto']?>">
                        <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                    </a>
                    <a style="cursor:pointer;" class="delete" type="button" id="delete_file_historial" data-image_id="<?php echo  $list['id_historial_producto']?>">
                        <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                    </a>
                </div>
            <?php }elseif (substr($list['archivo'],-3) === "pdf"){ ?>
                <div id="i_<?php echo  $list['id_historial_producto']?>" class="form-group col-sm-3">
                    <?php 
                    echo'<div id="lista_escogida"><embed loading="lazy" src="'. base_url() . $list['archivo'] . '" width="100%" height="150px" /></div>';
                    ?>
                    <a style="cursor:pointer;" class="download" type="button" id="download_file_historial" data-image_id="<?php echo $get_id[0]['id_historial_producto']?>">
                        <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                    </a>
                    <a style="cursor:pointer;" class="delete" type="button" id="delete_file_historial" data-image_id="<?php echo  $list['id_historial_producto']?>">
                        <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                    </a>
                </div>
            <?php }elseif (substr($list['archivo'],-4) === "xlsx"){ ?>
                <div id="i_<?php echo  $list['id_historial_producto']?>" class="form-group col-sm-3">
                    <?php 
                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post_historial img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivo'],-28) .'" src="' . base_url() ."/template/inputfiles/excel_example.png". '"></div>'; 
                    ?>
                    <a style="cursor:pointer;" class="download" type="button" id="download_file_historial" data-image_id="<?php echo $get_id[0]['id_historial_producto']?>">
                        <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                    </a>
                    <a style="cursor:pointer;" class="delete" type="button" id="delete_file_historial" data-image_id="<?php echo  $list['id_historial_producto']?>">
                        <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                    </a>
                </div>
            <?php }elseif (substr($list['archivo'],-3) === "xls"){ ?>
                <div id="i_<?php echo  $list['id_historial_producto']?>" class="form-group col-sm-3">
                    <?php 
                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post_historial img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivo'],-27) .'" src="' . base_url() ."/template/inputfiles/excel_example.png". '"></div>'; 
                    ?>
                    <a style="cursor:pointer;" class="download" type="button" id="download_file_historial" data-image_id="<?php echo $get_id[0]['id_historial_producto']?>">
                        <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                    </a>
                    <a style="cursor:pointer;" class="delete" type="button" id="delete_file_historial" data-image_id="<?php echo  $list['id_historial_producto']?>">
                        <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                    </a>
                </div>
            <?php }else{ echo ""; } ?>  
        <?php } ?>

            <div class="form-group col-md-1">
                <label class="control-label text-bold">Archivos:</label>
            </div>

            <div class="form-group col-md-11 ">
                <input type="file" class="form-control" name="archivose[]" id="archivose" multiple autofocus/>
            </div>

        
        </div>  	           	                	        
    </div>

    <div class="modal-footer">
        <input name="id_inventario_producto" type="hidden" class="form-control" id="id_inventario_producto" value="<?php echo $get_id[0]['id_inventario_producto']; ?>">
        <input type="hidden" readonly class="form-control" id="cod_producto" name="cod_producto" value="<?php echo $get_id[0]['cod_producto'] ?>" autofocus>
        <button type="button" class="btn btn-primary" onclick="Actualizar_ProductoI()" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
        
    </div>
</form>
<script src="<?= base_url() ?>template/fileinput/js/fileinput.min.js"></script>
<script>
    $(".img_post").click(function () {
        window.open($(this).attr("src"), 'popUpWindow', 
        "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
    });

    $(document).on('click', '#download_file', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>Snappy/Descargar_Imagen_ProductoI/" + image_id);
    });

    $(document).on('click', '#delete_file', function () {
        var image_id = $(this).data('image_id');
        var file_col = $('#i_' + image_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>Snappy/Delete_Imagen_ProductoI',
            data: {'image_id': image_id},
            success: function (data) {
                file_col.remove();            
            }
        });
    });

    $(".img_post_historial").click(function () {
        window.open($(this).attr("src"), 'popUpWindow', 
        "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
    });

    $(document).on('click', '#download_file_historial', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>Snappy/Descargar_Imagen_ProductoI_Historial/" + image_id);
    });

    $(document).on('click', '#delete_file_historial', function () {
        var image_id = $(this).data('image_id');
        var file_col = $('#i_' + image_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>Snappy/Delete_Imagen_ProductoI_Historial',
            data: {'image_id': image_id},
            success: function (data) {
                file_col.remove();            
            }
        });
    });
</script>
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

    $('#archivose').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        maxTotalFileCount: 5,
        showUpload: false,
        overwriteInitial: false,
        initialPreviewAsData: true,
        allowedFileExtensions: ['png','jpeg','jpg','xls','xlsx','pdf'],
    });

    function Actualizar_ProductoI(){
        var dataString = new FormData(document.getElementById('formulario_prodie'));
        var url="<?php echo site_url(); ?>Snappy/Update_Producto";

        if (valida_prodi()) {
            bootbox.confirm({
                title: "Editar Datos de Producto",
                message: "¿Desea actualizar datos del Producto?",
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
                                    'Actualización Denegada!',
                                    'Existe un registro con mismos datos',
                                    'error'
                                ).then(function() {
                                    
                                    
                                });
                                }else{
                                    swal.fire(
                                    'Actualización Exitosa!',
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

    

    function valida_prodi() {
        /*if($('#letra').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar letra.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#num_inicio').val().trim() == '') {
            Swal(
                'Ups!',
                'Debe ingresar número de inicio.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#num_fin').val().trim() == '' || $('#num_fin').val().trim() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar número de fin.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#num_fin').val().trim() < $('#num_inicio').val()) {
            Swal(
                'Ups!',
                'Número fin no debe ser menor que número de inicio.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        return true;
    }
</script>
