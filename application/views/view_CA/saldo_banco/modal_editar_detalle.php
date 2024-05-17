<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">

<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Editar Detalle Saldo Banco</h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Mes: </label>
            </div>
            <div class="form-group col-sm-2">
                <label><?php echo substr($get_id[0]['nom_mes'],0,3)."/".substr($get_id[0]['anio'],-2);  ?></label>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Movimientos (PDF): </label>
            </div>
            <div class="form-group col-sm-4">
                <input type="file" id="movimiento_pdf_u" name="movimiento_pdf_u">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Movimientos (XLS): </label>
            </div>
            <div class="form-group col-sm-4">
                <input type="file" id="movimiento_excel_u" name="movimiento_excel_u">
            </div>
        </div> 

        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Saldo (BPI): </label>
            </div>
            <div class="form-group col-sm-3">
                <input type="number" class="form-control" id="saldo_bbva_u" name="saldo_bbva_u" value="<?php echo $get_id[0]['s_bbva']; ?>" placeholder="Saldo (BPI)" <?php if($_SESSION['usuario'][0]['id_nivel']==11){ echo "readonly"; } ?>>
            </div>
        </div>  

        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Saldo (REAL): </label>
            </div>
            <div class="form-group col-sm-3">
                <input type="number" class="form-control" id="saldo_real_u" name="saldo_real_u" value="<?php echo $get_id[0]['s_real']; ?>" placeholder="Saldo (REAL)" <?php if($_SESSION['usuario'][0]['id_nivel']==11){ echo "readonly"; } ?>>
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
                    <div id="i_1" class="form-group col-sm-3">
                        <p><?php echo $get_id[0]['nom_pdf']; ?></p>
                        <a style="cursor:pointer;" class="download" type="button" id="download_pdf" data-image_id="<?php echo $get_id[0]['id_detalle']?>">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                        </a>
                        <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==5 || $_SESSION['usuario'][0]['id_usuario']==7){ ?>
                            <a style="cursor:pointer;" class="delete" type="button" id="delete_pdf" data-image_id="<?php echo  $get_id[0]['id_detalle']?>">
                                <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if(substr($get_id[0]['movimiento_excel'],-3) === "xls" || substr($get_id[0]['movimiento_excel'],-4) === "xlsx"){ ?>
                    <div id="i_2" class="form-group col-sm-3">
                        <p><?php echo $get_id[0]['nom_excel']; ?></p>
                        <a style="cursor:pointer;" class="download" type="button" id="download_excel" data-image_id="<?php echo $get_id[0]['id_detalle']?>">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                        </a>
                        <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==5 || $_SESSION['usuario'][0]['id_usuario']==7){ ?>
                            <a style="cursor:pointer;" class="delete" type="button" id="delete_excel" data-image_id="<?php echo  $get_id[0]['id_detalle']?>">
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
        <input type="hidden" id="id_estado_bancario_u" name="id_estado_bancario_u" value="<?php echo $get_id[0]['id_estado_bancario']; ?>">
        <input type="hidden" id="anio_u" name="anio_u" value="<?php echo $get_id[0]['anio']; ?>">
        <input type="hidden" id="mes_u" name="mes_u" value="<?php echo $get_id[0]['mes']; ?>">
        <input type="hidden" id="antiguo_pdf_u" name="antiguo_pdf_u" value="<?php echo $get_id[0]['movimiento_pdf']; ?>">
        <input type="hidden" id="antiguo_excel_u" name="antiguo_excel_u" value="<?php echo $get_id[0]['movimiento_excel']; ?>">
        <input type="hidden" id="antiguo_nom_pdf_u" name="antiguo_nom_pdf_u" value="<?php echo $get_id[0]['nom_pdf']; ?>">
        <input type="hidden" id="antiguo_nom_excel_u" name="antiguo_nom_excel_u" value="<?php echo $get_id[0]['nom_excel']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Detalle_Saldo_Banco();" data-loading-text="Loading..." autocomplete="off">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
</form>

<script>
    $(document).on('click', '#download_pdf', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>Ca/Descargar_Archivo/" + image_id + "/" + 1);
    });

    $(document).on('click', '#delete_pdf', function () {
        var image_id = $(this).data('image_id');
        var orden = 1;
        var file_col = $('#i_1');
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>Ca/Delete_Archivo',
            data: {'image_id': image_id,'orden':orden},
            success: function (data) {
                file_col.remove();            
            }
        });
    });

    $(document).on('click', '#download_excel', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>Ca/Descargar_Archivo/" + image_id + "/" + 2);
    });

    $(document).on('click', '#delete_excel', function () {
        var image_id = $(this).data('image_id');
        var orden = 2;
        var file_col = $('#i_2');
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>Ca/Delete_Archivo',
            data: {'image_id': image_id,'orden':orden},
            success: function (data) {
                file_col.remove();            
            }
        });
    });

    function Update_Detalle_Saldo_Banco(){
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

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>Ca/Update_Detalle_Saldo_Banco";

        if (Valida_Update_Detalle_Saldo_Banco()) {
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
                        Lista_Detalle_Saldo_Banco();
                        $("#acceso_modal_mod .close").click()
                    });
                }
            });       
        }
    }

    function Valida_Update_Detalle_Saldo_Banco() {
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
</script>
