<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $sesion['id_nivel'];
$id_usuario = $sesion['id_usuario'];
?>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">

<form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Editar Detalle Estado Bancario</h5>
    </div>

    <div class="modal-body" style="max-height:530px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Mes: </label>
            </div>
            <div class="form-group col-sm-2">
                <label><?php echo substr($get_id[0]['nom_mes'],0,3)."/".substr($get_id[0]['anio'],-2);  ?></label>
            </div>
        </div>

        <?php if($id_nivel!=11){ ?>
            <div class="col-md-12 row">
                <div class="form-group col-md-4">
                    <label class="col-sm-12 control-label text-bold">Movimientos (PDF): </label>
                </div>
                <div class="form-group col-sm-4">
                    <input type="file" id="movimiento_pdf" name="movimiento_pdf" onchange="return validar_Archivo_Pdf('movimiento_pdf')">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-4">
                    <label class="col-sm-12 control-label text-bold">Movimientos (XLS): </label>
                </div>
                <div class="form-group col-sm-4">
                    <input type="file" id="movimiento_excel" name="movimiento_excel" onchange="return validar_Archivo_Xls('movimiento_excel')">
                </div>
            </div> 

            <div class="col-md-12 row">
                <div class="form-group col-md-4">
                    <label class="col-sm-12 control-label text-bold">Resumen Anual (XLS): </label>
                </div>
                <div class="form-group col-sm-4">
                    <input type="file" id="resumen_anual" name="resumen_anual" onchange="return validar_Archivo_Xls('resumen_anual')">
                </div>
            </div> 
        <?php } ?>

        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Saldo (BBVA): </label>
            </div>
            <div class="form-group col-sm-3">
                <input type="number" class="form-control" id="saldo_bbva" name="saldo_bbva" value="<?php if($get_id[0]['saldo_bbva']!=0){ echo $get_id[0]['saldo_bbva']; }else{ echo ""; } ?>" placeholder="Saldo (BBVA)" <?php if($id_nivel==11){ echo "readonly"; } ?> onkeypress="if(event.keyCode == 13){ Update_Estado_Bancario(); }">
            </div>
        </div>  

        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Saldo (REAL): </label>
            </div>
            <div class="form-group col-sm-3">
                <input type="number" class="form-control" id="saldo_real" name="saldo_real" value="<?php if($get_id[0]['saldo_real']!=0){ echo $get_id[0]['saldo_real']; }else{ echo ""; } ?>" placeholder="Saldo (REAL)" <?php if($id_nivel==11){ echo "readonly"; } ?> onkeypress="if(event.keyCode == 13){ Update_Estado_Bancario(); }">
            </div>
        </div>  

        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Revisado 100%: </label>
            </div>
            <div class="form-group col-sm-3">
                <input type="checkbox" id="revisado" name="revisado" value="1" <?php if($get_id[0]['revisado']==1){ echo "checked"; } ?> style="height:20px;width:20px;">
            </div>
        </div>  

        <?php if($get_id[0]['movimiento_pdf']!="" || $get_id[0]['movimiento_excel']!=""){ ?>
            <div class="col-md-12 row">
                <div class="form-group col-md-4">
                    <label class="col-sm-12 control-label text-bold">Archivos: </label>
                </div>
            </div>  
            <div class="col-md-12 row">
                <?php if (substr($get_id[0]['movimiento_pdf'],-3) === "pdf" || substr($get_id[0]['movimiento_pdf'],-3) === "PDF"){ ?>
                    <div id="i_1" class="form-group col-sm-4">
                        <p><?php echo $get_id[0]['nom_pdf']; ?></p>
                        <a style="cursor:pointer;" class="download" type="button" id="download_pdf" data-image_id="<?php echo $get_id[0]['id_detalle']?>">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                        </a>
                        <?php if($id_usuario==1 || $id_usuario==5 || $id_usuario==7){ ?>
                            <a style="cursor:pointer;" class="delete" type="button" id="delete_pdf" data-image_id="<?php echo  $get_id[0]['id_detalle']?>">
                                <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if(substr($get_id[0]['movimiento_excel'],-3) === "xls" || substr($get_id[0]['movimiento_excel'],-4) === "xlsx"){ ?>
                    <div id="i_2" class="form-group col-sm-4">
                        <p><?php echo $get_id[0]['nom_excel']; ?></p>
                        <a style="cursor:pointer;" class="download" type="button" id="download_excel" data-image_id="<?php echo $get_id[0]['id_detalle']?>">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                        </a>
                        <?php if($id_usuario==1 || $id_usuario==5 || $id_usuario==7){ ?>
                            <a style="cursor:pointer;" class="delete" type="button" id="delete_excel" data-image_id="<?php echo  $get_id[0]['id_detalle']?>">
                                <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>  
                <?php if(substr($get_id[0]['resumen_anual'],-3) === "xls" || substr($get_id[0]['resumen_anual'],-4) === "xlsx"){ ?>
                    <div id="i_3" class="form-group col-sm-4">
                        <p><?php echo $get_id[0]['nom_resumen_anual']; ?></p>
                        <a style="cursor:pointer;" class="download" type="button" id="download_anual" data-image_id="<?php echo $get_id[0]['id_detalle']?>">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                        </a>
                        <?php if($id_usuario==1 || $id_usuario==5 || $id_usuario==7){ ?>
                            <a style="cursor:pointer;" class="delete" type="button" id="delete_anual" data-image_id="<?php echo  $get_id[0]['id_detalle']?>">
                                <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>  
            </div>
        <?php } ?>
    </div> 
    
    <div class="modal-footer">
        <input type="hidden" id="id_detalle" name="id_detalle" value="<?php echo $get_id[0]['id_detalle']; ?>">
        <input type="hidden" id="id_estado_bancario" name="id_estado_bancario" value="<?php echo $get_id[0]['id_estado_bancario']; ?>">
        <input type="hidden" id="anio" name="anio" value="<?php echo $get_id[0]['anio']; ?>">
        <input type="hidden" id="mes" name="mes" value="<?php echo $get_id[0]['mes']; ?>">
        <input type="hidden" id="antiguo_pdf" name="antiguo_pdf" value="<?php echo $get_id[0]['movimiento_pdf']; ?>">
        <input type="hidden" id="antiguo_excel" name="antiguo_excel" value="<?php echo $get_id[0]['movimiento_excel']; ?>">
        <input type="hidden" id="antiguo_nom_pdf" name="antiguo_nom_pdf" value="<?php echo $get_id[0]['nom_pdf']; ?>">
        <input type="hidden" id="antiguo_nom_excel" name="antiguo_nom_excel" value="<?php echo $get_id[0]['nom_excel']; ?>">
        <input type="hidden" id="antiguo_resumen_anual" name="antiguo_resumen_anual" value="<?php echo $get_id[0]['resumen_anual']; ?>">
        <input type="hidden" id="antiguo_nom_resumen_anual" name="antiguo_nom_resumen_anual" value="<?php echo $get_id[0]['nom_resumen_anual']; ?>">
        <?php if($id_nivel!=11){ ?>
            <button type="button" class="btn btn-primary" onclick="Update_Estado_Bancario();" data-loading-text="Loading..." autocomplete="off">Guardar</button>
        <?php } ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
</form>

<script>
    $("#saldo_bbva").keyup(function () {
        var value = $(this).val();
        $("#saldo_real").val($('#saldo_bbva').val());
    });
    function Update_Estado_Bancario(){
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

        var id = $('#id_estado_bancario').val();
        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?php echo site_url(); ?>Administrador/Update_Detalle_Estado_Bancario";

        if (Valida_Detalle_Estado_Bancario()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    Lista_Detalle_Estado_Bancario(1);
                    $("#acceso_modal_mod .close").click();
                    /*swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>Administrador/Detalle_Estado_Bancario/"+id;
                    });*/
                }
            });       
        }
    }

    function Valida_Detalle_Estado_Bancario() {
        /*if($('#saldo').val() === '' || $('#saldo').val() === '0') {
            Swal(
                'Ups!',
                'Debe ingresar Saldo.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        return true;
    }

    $(document).on('click', '#download_pdf', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>Administrador/Descargar_Archivo/" + image_id + "/" + 1);
    });

    $(document).on('click', '#delete_pdf', function () {
        var image_id = $(this).data('image_id');
        var orden = 1;
        var file_col = $('#i_1');
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>Administrador/Delete_Archivo',
            data: {'image_id': image_id,'orden':orden},
            success: function (data) {
                file_col.remove();            
            }
        });
    });

    $(document).on('click', '#download_excel', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>Administrador/Descargar_Archivo/" + image_id + "/" + 2);
    });

    $(document).on('click', '#delete_excel', function () {
        var image_id = $(this).data('image_id');
        var orden = 2;
        var file_col = $('#i_2');
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>Administrador/Delete_Archivo',
            data: {'image_id': image_id,'orden':orden},
            success: function (data) {
                file_col.remove();            
            }
        });
    });

    $(document).on('click', '#download_anual', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>Administrador/Descargar_Archivo/" + image_id + "/" + 3);
    });

    $(document).on('click', '#delete_anual', function () {
        var image_id = $(this).data('image_id');
        var orden = 3;
        var file_col = $('#i_3');
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>Administrador/Delete_Archivo',
            data: {'image_id': image_id,'orden':orden},
            success: function (data) {
                file_col.remove();            
            }
        });
    });

    function validar_Archivo_Pdf(v){
        var archivoInput = document.getElementById(v);
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.pdf)$/i;
        if(!extPermitidas.exec(archivoRuta)){
                swal.fire(
                    '!Archivo no permitido!',
                    'El archivo debe ser PDF',
                    'error'
                )
            archivoInput.value = '';
            return false;
        }
    }
    function validar_Archivo_Xls(v){
        var archivoInput = document.getElementById(v);
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.xlsx)$/i;
        if(!extPermitidas.exec(archivoRuta)){
                swal.fire(
                    '!Archivo no permitido!',
                    'El archivo debe ser XLSX',
                    'error'
                )
            archivoInput.value = '';
            return false;
        }
    }
</script>