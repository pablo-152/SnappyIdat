<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">

<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Datos Detalle Saldo Banco</h5>
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
                <label class="col-sm-12 control-label text-bold">Saldo (BPI): </label>
            </div>
            <div class="form-group col-sm-3">
                <input type="number" class="form-control" disabled value="<?php echo $get_id[0]['s_bbva']; ?>" placeholder="Saldo (BPI)" <?php if($_SESSION['usuario'][0]['id_nivel']==11){ echo "readonly"; } ?>>
            </div>
        </div>  

        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Saldo (REAL): </label>
            </div>
            <div class="form-group col-sm-3">
                <input type="number" class="form-control" disabled value="<?php echo $get_id[0]['s_real']; ?>" placeholder="Saldo (REAL)" <?php if($_SESSION['usuario'][0]['id_nivel']==11){ echo "readonly"; } ?>>
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
                        <?php if($_SESSION['usuario'][0]['id_nivel']!=13){ ?>
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
                        <?php if($_SESSION['usuario'][0]['id_nivel']!=13){ ?>
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
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
</form>

<script>
    $(document).on('click', '#download_pdf', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>Ca/Descargar_Archivo/" + image_id + "/" + 1);
    });

    $(document).on('click', '#download_excel', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>Ca/Descargar_Archivo/" + image_id + "/" + 2);
    });
</script>
