<form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="col-md-12 row" style="margin-top:15px;margin-bottom:15px;">
        <div class="form-group col-md-2">
            <label class="control-label text-bold">Tipo:</label>
            <select class="form-control" id="tipo" name="tipo">
                <option value="0" <?php if($get_id[0]['tipo']==0){ echo "selected"; } ?>>Seleccione</option>
                <option value="1" <?php if($get_id[0]['tipo']==1){ echo "selected"; } ?>>Actas</option>
                <option value="2" <?php if($get_id[0]['tipo']==2){ echo "selected"; } ?>>Nominas</option>
                <option value="3" <?php if($get_id[0]['tipo']==3){ echo "selected"; } ?>>Titulación</option>
            </select>
        </div>

        <div class="form-group col-md-2">
            <label class="control-label text-bold">Ref:</label>
            <select class="form-control" id="ref_mes" name="ref_mes">
                <?php foreach($list_mes as $list){ ?>
                    <option value="<?php echo $list['cod_mes']; ?>" <?php if($list['cod_mes']==$get_id[0]['ref_mes']){ echo "selected"; } ?>><?php echo $list['nom_mes']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group col-md-2">
            <label style="color:transparent;">Ref</label>
            <select class="form-control" id="ref_anio" name="ref_anio">
                <?php foreach($list_anio as $list){ ?>
                    <option value="<?php echo $list['nom_anio']; ?>" <?php if($list['nom_anio']==$get_id[0]['ref_anio']){ echo "selected"; } ?>><?php echo $list['nom_anio']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group col-md-2">
            <label style="color:transparent;">Ref</label>
            <select class="form-control" id="ref_lugar" name="ref_lugar">
                <option value="1" <?php if($get_id[0]['ref_lugar']==1){ echo "selected"; } ?>>Chincha</option>
                <option value="2" <?php if($get_id[0]['ref_lugar']==2){ echo "selected"; } ?>>Lima</option>
            </select>
        </div>
    </div>

    <div class="col-md-12 row">
        <div class="form-group col-md-4">
            <label class="control-label text-bold">Especialidad:</label>
            <select class="form-control" id="id_especialidad" name="id_especialidad">
                <option value="0">Seleccione</option>
                <?php foreach($list_especialidad as $list){ ?>
                <option value="<?php echo $list['id_especialidad']; ?>" <?php if($get_id[0]['id_especialidad']==$list['id_especialidad']){ echo "selected"; } ?>><?php echo $list['nom_especialidad']; ?></option>
                <?php } ?>
            </select>
        </div>
      </div>

    <div class="col-md-12 row">
        <div class="form-group col-md-2">
            <label class="control-label text-bold">Grupo:</label>
            <input type="text" class="form-control" id="grupo" name="grupo" placeholder="Grupo" value="<?php echo $get_id[0]['grupo']; ?>">
        </div>
        
        <div class="form-group col-md-2">
            <label class="control-label text-bold">Fecha Envio:</label>
            <input type="date" class="form-control" id="fecha_envio" name="fecha_envio" value="<?php echo $get_id[0]['fecha_envio']; ?>">
        </div>

        <div class="form-group col-md-2">
            <label class="control-label text-bold">Nr. Alumnos:</label>
            <input type="text" class="form-control" id="n_alumnos" name="n_alumnos" placeholder="Nr. Alumnos" value="<?php echo $get_id[0]['n_alumnos']; ?>">
        </div>
    </div>

    <div class="col-md-12 row">
        <div class="form-group col-md-8">
            <label class="control-label text-bold">Producto:</label>
            <input type="text" class="form-control" id="producto" name="producto" placeholder="Producto" value="<?php echo $get_id[0]['producto']; ?>">
        </div>
    </div>

    <div class="col-md-12 row">
        <div class="form-group col-md-8">
            <label class="control-label text-bold">Observaciones:</label>
            <textarea rows="5" class="form-control" id="observaciones" name="observaciones" placeholder="Observaciones" <?php if($get_id[0]['segundo_estado']!=3){ echo "disabled"; } ?>><?php echo $get_id[0]['observaciones']; ?></textarea>
            <span style="color: #C8C8C8;">Utilizar siempre la configuración: DD/MM/AAAA - Observaciones (Usuario)</span>
        </div>
    </div>

    <div class="col-md-6 row">
        <div class="form-group col-md-6">
            <label class="control-label text-bold">Tablas Alumnos Arpay:</label>
            <?php if($get_id[0]['tabla_alumno_arpay']!=""){ ?>
            <a href="<?= site_url('AppIFV/Descargar_Documento_Registro') ?>/<?php echo $get_id[0]['id_registro']; ?>/1">
                <img title="Descargar" src="<?= base_url() ?>template/img/icono-subir.png" style="cursor:pointer; cursor: hand;" width="30" height="20">
            </a>
            <?php } ?>
            <input type="file" id="tabla_alumno_arpay" name="tabla_alumno_arpay" data-allowed-file-extensions='["xls|xlsx|pdf|jpg|png|jpeg"]' size="100" required>
        </div>

        <div class="form-group col-md-6">
            <label class="control-label text-bold">Registro (apuntes):</label>
            <?php if($get_id[0]['registro_apuntes']!=""){ ?>
            <a href="<?= site_url('AppIFV/Descargar_Documento_Registro') ?>/<?php echo $get_id[0]['id_registro']; ?>/2">
                <img title="Descargar" src="<?= base_url() ?>template/img/icono-subir.png" style="cursor:pointer; cursor: hand;" width="30" height="20">
            </a>
            <?php } ?>
            <input type="file" id="registro_apuntes" name="registro_apuntes" data-allowed-file-extensions='["xls|xlsx|pdf|jpg|png|jpeg"]' size="100" required>
        </div>

        <div class="form-group col-md-6">
            <label class="control-label text-bold">Documento Enviado:</label>
            <?php if($get_id[0]['documento_enviado']!=""){ ?>
            <a href="<?= site_url('AppIFV/Descargar_Documento_Registro') ?>/<?php echo $get_id[0]['id_registro']; ?>/3">
                <img title="Descargar" src="<?= base_url() ?>template/img/icono-subir.png" style="cursor:pointer; cursor: hand;" width="30" height="20">
            </a>
            <?php } ?>
            <input type="file" id="documento_enviado" name="documento_enviado" data-allowed-file-extensions='["xls|xlsx|pdf|jpg|png|jpeg"]' size="100" required><!--onchange="Cambiar_Estado();" -->
        </div>

        <div class="form-group col-md-6">
            <label class="control-label text-bold">Documento Recibido:</label>
            <?php if($get_id[0]['documento_recibido']!=""){ ?>
            <a href="<?= site_url('AppIFV/Descargar_Documento_Registro') ?>/<?php echo $get_id[0]['id_registro']; ?>/4">
                <img title="Descargar" src="<?= base_url() ?>template/img/icono-subir.png" style="cursor:pointer; cursor: hand;" width="30" height="20">
            </a>
            <?php } ?>
            <input type="file" id="documento_recibido" name="documento_recibido" data-allowed-file-extensions='["xls|xlsx|pdf|jpg|png|jpeg"]' size="100" required><!--onchange="Cambiar_Estado();" -->
        </div>
    </div>

    <div id="div_boton" class="col-md-2 div_padre">
        <?php if($get_id[0]['segundo_estado']==3){ ?>
            <?php if($get_id[0]['primer_estado']==0){ ?>
                <button type="button" class="btn boton_principal_pendiente" <?php if($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6){ ?> onclick="Primer_Estado(1);" <?php } ?>>Pendiente</button>
            <?php }else{ ?>
                <button type="button" class="btn boton_principal_revisado" <?php if($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6){ ?> onclick="Primer_Estado(0);" <?php } ?>>Revisado </button>
                <span class="span_volador1"><?php echo $get_id[0]['f_rev']; ?></span>
                <span class="span_volador2"><?php echo $get_id[0]['u_rev']; ?></span>
            <?php } ?>
        <?php } ?>
    </div>

    <div class="col-md-12 row">
        <div id="div_estado" class="form-group col-md-2">
            <label class="control-label text-bold">Estado:</label>
            <!--<input type="text" class="form-control" disabled value="<?php echo $get_id[0]['seg_estado']; ?>">-->
            <select class="form-control" id="segundo_estado" name="segundo_estado" onchange="Permitir_Obs();">
            <option value="1" <?php if($get_id[0]['segundo_estado']==1){ echo "selected"; } ?>>Registrado</option>
            <option value="2" <?php if($get_id[0]['segundo_estado']==2){ echo "selected"; } ?>>Enviado</option>
            <option value="3" <?php if($get_id[0]['segundo_estado']==3){ echo "selected"; } ?>>Confirmado</option>
            </select>
        </div>
    </div>

    <div class="col-md-8 modal-footer">
        <input type="hidden" id="id_registro" name="id_registro" value="<?php echo $get_id[0]['id_registro']; ?>">
        <input type="hidden" id="primer_estado" name="primer_estado" value="<?php echo $get_id[0]['primer_estado']; ?>">
        <input type="hidden" id="segundo_estado" name="segundo_estado" value="<?php echo $get_id[0]['segundo_estado']; ?>">
        <input type="hidden" name="tabla_alumno_arpay_actual" value="<?php echo $get_id[0]['tabla_alumno_arpay']; ?>">
        <input type="hidden" name="registro_apuntes_actual" value="<?php echo $get_id[0]['registro_apuntes']; ?>">
        <input type="hidden" name="documento_enviado_actual" value="<?php echo $get_id[0]['documento_enviado']; ?>">
        <input type="hidden" name="documento_recibido_actual" value="<?php echo $get_id[0]['documento_recibido']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Registro()"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
        <a type="button" class="btn btn-default" href="<?= site_url('AppIFV/Registro') ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
        </div>
</form>