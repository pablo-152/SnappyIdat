<?php 
    $id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>

<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
  <div class="modal-header">
      <h3 class="tile-title" style="color: #715d74;font-size: 21px;"><b>Edición de Historial</b></h3>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-3">
                <label class="control-label text-bold">Status:</label>
                <select class="form-control" name="id_status_ticket_u" id="id_status_ticket_u" onchange="Status_U()">
                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_status_ticket']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                    <?php foreach($list_status as $list){ ?>
                        <option value="<?php echo $list['id_status_general']; ?>" <?php if (!(strcmp($list['id_status_general'], $get_id[0]['id_status_ticket']))) {echo "selected=\"selected\"";} ?>><?php echo $list['nom_status'];?></option>
                    <?php } ?>
                </select>
            </div>

            <div id="div_horas_u" class="form-group col-md-2" <?php if($get_id[0]['id_status_ticket']==20 || $get_id[0]['id_status_ticket']==2 || $get_id[0]['id_status_ticket']==23){ ?> style="display: block;" <?php }else{ ?> style="display: none;" <?php } ?>>
                <label class="text-bold">Horas:</label>
                <input class="form-control" type="number" id="horas_u" name="horas_u" placeholder="Horas" value="<?php echo $get_id[0]['horas']; ?>">
            </div>

            <div id="div_minutos_u" class="form-group col-md-2" <?php if($get_id[0]['id_status_ticket']==20 || $get_id[0]['id_status_ticket']==2 || $get_id[0]['id_status_ticket']==23){ ?> style="display: block;" <?php }else{ ?> style="display: none;" <?php } ?>>
                <label class="text-bold">Minutos:</label>
                <input class="form-control" type="number" id="minutos_u" name="minutos_u" placeholder="Minutos" value="<?php echo $get_id[0]['minutos']; ?>">
            </div>

            <div id="div_colaborador_u" class="form-group col-md-3" <?php if($get_id[0]['id_status_ticket']==20){ ?> style="display: block;" <?php }else{ ?> style="display: none;" <?php } ?>>
                <label class="text-bold">Colaborador:</label>
                <select class="form-control" name="id_mantenimiento_u" id="id_mantenimiento_u">
                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_mantenimiento']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                    <?php foreach($list_mantenimiento as $list){ ?>
                    <option value="<?php echo $list['id_usuario']; ?>" <?php if (!(strcmp($list['id_usuario'], $get_id[0]['id_mantenimiento']))) {echo "selected=\"selected\"";} ?>><?php echo $list['usuario_codigo']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="text-bold">Fecha:</label>
                <div><?php echo $get_id[0]['fecha_registro']; ?></div>
            </div>
            <div class="form-group col-md-2" style="display:<?php if($get_id[0]['id_status_ticket']==34){ echo "block";}else{echo "none";}?>">
                <label class="text-bold">Mes:</label>
                <div><?php echo $get_id[0]['nom_mes'].substr($get_id[0]['anio'], 2,2); ?></div>
            </div>

            <div class="form-group col-md-12">
                <label class="text-bold">Observaciones:</label>
                <textarea name="ticket_obs_u" rows="5" class="form-control" id="ticket_obs_u"><?php echo $get_id[0]['ticket_obs']; ?></textarea>
            </div>

            <div class="form-group col-md-12">
                <label class="control-label text-bold">Archivos:</label>
                <input type="file" name="files_u[]" id="files_u" multiple/>
            </div>
        </div>

        <div class="col-md-12 row">
            <?php foreach($list_archivo as $list) {  ?>
                <div id="i_<?php echo $list['id_historial_archivo']; ?>" class="form-group col-md-12" style="margin-bottom: 0px !important;">
                    <label class="control-label text-bold"><?php echo $list['nom_archivo']; ?></label>
                    <a title="Descargar" type="button" onclick="Descargar_Archivo('<?php echo $list['id_historial_archivo']; ?>')" style="cursor:pointer;">
                        <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                    </a>
                    <a title="Eliminar" type="button" onclick="Delete_Archivo('<?php echo $list['id_historial_archivo']; ?>');" style="cursor:pointer;">
                        <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                    </a>
                </div>
                <?php /*if(substr($list['archivo'],-3) === "jpg" || substr($list['archivo'],-3) === "JPG"){ ?>
                    <div id="i_<?php echo  $list['id_historial_archivo']?>" class="form-group col-sm-3">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivo'],-27) .'" src="' . base_url() . $list['archivo'] . '"></div>'; 
                        ?>
                        <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_historial_archivo']?>">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                        </a>
                        <a style="cursor:pointer;" class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_historial_archivo']?>">
                            <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                        </a>
                    </div>
                <?php }elseif (substr($list['archivo'],-3) === "png" || substr($list['archivo'],-3) === "PNG"){ ?>
                    <div id="i_<?php echo  $list['id_historial_archivo']?>" class="form-group col-sm-3">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivo'],-27) .'" src="' . base_url() . $list['archivo'] . '"></div>'; 
                        ?> 
                        <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_historial_archivo']?>">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                        </a>
                        <a style="cursor:pointer;" class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_historial_archivo']?>">
                            <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                        </a>
                    </div>
                <?php }elseif (substr($list['archivo'],-4) === "jpeg" || substr($list['archivo'],-4) === "JPEG"){ ?>
                    <div id="i_<?php echo  $list['id_historial_archivo']?>" class="form-group col-sm-3">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivo'],-28) .'" src="' . base_url() . $list['archivo'] . '"></div>'; 
                        ?>
                        <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_historial_archivo']?>">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                        </a>
                        <a style="cursor:pointer;" class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_historial_archivo']?>">
                            <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                        </a>
                    </div>
                <?php }elseif (substr($list['archivo'],-3) === "pdf"){ ?>
                    <div id="i_<?php echo  $list['id_historial_archivo']?>" class="form-group col-sm-3">
                        <?php 
                        echo'<div id="lista_escogida"><embed loading="lazy" src="'. base_url() . $list['archivo'] . '" width="100%" height="150px" /></div>';
                        ?>
                        <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_historial_archivo']?>">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                        </a>
                        <a style="cursor:pointer;" class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_historial_archivo']?>">
                            <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                        </a>
                    </div>
                <?php }elseif (substr($list['archivo'],-4) === "xlsx"){ ?>
                    <div id="i_<?php echo  $list['id_historial_archivo']?>" class="form-group col-sm-3">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivo'],-28) .'" src="' . base_url() ."/template/inputfiles/excel_example.png". '"></div>'; 
                        ?>
                        <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_historial_archivo']?>">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                        </a>
                        <a style="cursor:pointer;" class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_historial_archivo']?>">
                            <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                        </a>
                    </div>
                <?php }elseif (substr($list['archivo'],-3) === "xls"){ ?>
                    <div id="i_<?php echo  $list['id_historial_archivo']?>" class="form-group col-sm-3">
                        <?php 
                        echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivo'],-27) .'" src="' . base_url() ."/template/inputfiles/excel_example.png". '"></div>'; 
                        ?>
                        <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_historial_archivo']?>">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                        </a>
                        <a style="cursor:pointer;" class="delete" type="button" id="delete_file" data-image_id="<?php echo  $list['id_historial_archivo']?>">
                            <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                        </a>
                    </div>
                <?php }else{ echo ""; }*/ ?>  
            <?php } ?>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_historial" name="id_historial" value="<?php echo $get_id[0]['id_historial']; ?>">
        <input type="hidden" id="id_ticket" name="id_ticket" value="<?php echo $get_id[0]['id_ticket']; ?>">
        <input type="hidden" id="cod_ticket" name="cod_ticket" value="<?php echo $get_id[0]['cod_ticket']; ?>">
        <?php if($id_nivel!=9){ ?>
            <button type="button" class="btn btn-success" onclick="Update_Historial()">Guardar</button>&nbsp;&nbsp;
        <?php } ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
  </div>
</form>

<script>
    function Descargar_Archivo(id){
        window.location.replace("<?php echo site_url(); ?>General/Descargar_Archivo/"+id);
    } 

    function Delete_Archivo(id){
        Cargando();

        var file_col = $('#i_'+id);

        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>General/Delete_Archivo',
            data: {'image_id': id},
            success: function (data) {
                file_col.remove();            
            }
        });
    }
    
    function Status_U(){
        var id_status_ticket=$('#id_status_ticket_u').val();
        var div_colaborador = document.getElementById("div_colaborador_u");
        var div_horas = document.getElementById("div_horas_u");
        var div_minutos = document.getElementById("div_minutos_u"); 

        if(id_status_ticket==20){
          div_colaborador.style.display = "block";
          div_horas.style.display = "block";
          div_minutos.style.display = "block";
        }else if(id_status_ticket==2 || id_status_ticket==23){
          div_horas.style.display = "block";
          div_minutos.style.display = "block";
        }else{
          div_colaborador.style.display = "none"; 
          div_horas.style.display = "none";
          div_minutos.style.display = "none";
        }
    }

    function Update_Historial(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>General/Update_Historial_Ticket";

        if (Valida_Update_Historial()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    $("#acceso_modal_eli .close").click();
                    Lista_Historial_Ticket();
                }
            });
        }
    }

    function Valida_Update_Historial() {
        if($('#id_status_ticket_u').val() == '0'){
            Swal(
                'Ups!',
                'Debe seleccionar Estado.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_status_ticket_u').val()==2){
            if($('#horas_u').val().trim() == '' && $('#minutos_u').val().trim() == ''){
                Swal(
                    'Ups!',
                    'Debe ingresar Tiempo.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#horas_u').val()<2){
                Swal(
                    'Ups!',
                    'Debe ingresar Tiempo mayor o igual a 2h.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if($('#id_status_ticket_u').val()==23){
            if($('#horas_u').val().trim() == '' && $('#minutos_u').val().trim() == ''){
                Swal(
                    'Ups!',
                    'Debe ingresar Tiempo.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        return true;
    }
</script>