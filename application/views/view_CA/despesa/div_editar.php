<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="col-lg-12 row" style="margin-bottom:15px;">
        <div class="form-group col-lg-1">
            <select class="form-control" id="tipo_despesa_u" name="tipo_despesa_u">
                <option value="0" <?php if($get_id[0]['tipo_despesa']==0){ echo "selected"; } ?>>Seleccione</option>
                <option value="4" <?php if($get_id[0]['tipo_despesa']==4){ echo "selected"; } ?>>Black</option>
                <option value="3" <?php if($get_id[0]['tipo_despesa']==3){ echo "selected"; } ?>>Crédito</option> 
                <option value="2" <?php if($get_id[0]['tipo_despesa']==2){ echo "selected"; } ?>>Gasto</option>
                <option value="1" <?php if($get_id[0]['tipo_despesa']==1){ echo "selected"; } ?>>Ingreso</option>
            </select>
        </div>

        <div class="form-group col-lg-1 text-right">
            <label class="control-label text-bold margintop">Tipo Pago:</label>
        </div>
        <div class="form-group col-lg-1">
            <select class="form-control" id="id_tipo_pago_u" name="id_tipo_pago_u">
                <option value="0" <?php if($get_id[0]['id_tipo_pago']==0){ echo "selected"; } ?>>Seleccione</option>
                <option value="1" <?php if($get_id[0]['id_tipo_pago']==1){ echo "selected"; } ?>>Cuenta Bancaria</option>
                <option value="2" <?php if($get_id[0]['id_tipo_pago']==2){ echo "selected"; } ?>>Efectivo/Transferencia</option>
                <option value="3" <?php if($get_id[0]['id_tipo_pago']==3){ echo "selected"; } ?>>Cheque</option>
            </select>
        </div>

        <div class="form-group col-lg-1 text-right">
            <label class="control-label text-bold margintop">Rubro:</label>
        </div>
        <div class="form-group col-lg-1">
            <select class="form-control" name="id_rubro_u" id="id_rubro_u" onchange="Traer_Subrubro_U();">
                <option value="0">Seleccione</option>
                <?php foreach($list_rubro as $list){ ?>
                    <option value="<?php echo $list['id_rubro']; ?>" <?php if($list['id_rubro']==$get_id[0]['id_rubro']){ echo "selected"; } ?>>
                        <?php echo $list['nom_rubro']; ?>
                    </option> 
                <?php } ?>
            </select>
        </div>

        <div class="form-group col-lg-1 text-right">
            <label class="control-label text-bold margintop">Sub-Rubro:</label>
        </div>
        <div id="select_subrubro_u" class="form-group col-lg-1">
            <select class="form-control" name="id_subrubro_u" id="id_subrubro_u">
                <option value="0">Seleccione</option>
                <?php foreach($list_subrubro as $list){ ?>
                    <option value="<?php echo $list['id_subrubro']; ?>" <?php if($list['id_subrubro']==$get_id[0]['id_subrubro']){ echo "selected"; } ?>>
                        <?php echo $list['nom_subrubro']; ?>
                    </option> 
                <?php } ?>
            </select>
        </div>

        <div class="form-group col-lg-1 text-right">
            <label class="control-label text-bold margintop">Descriçao:</label>
        </div>
        <div class="form-group col-lg-4">
            <input type="text" class="form-control" id="descripcion_u" name="descripcion_u" placeholder="Descripción" maxlength="30" value="<?php echo $get_id[0]['descripcion']; ?>" onkeypress="if(event.keyCode == 13){ Update_Despesa(); }">
        </div>
    </div>

    <div class="col-lg-12 row" style="margin-bottom:15px;">
        <div class="form-group col-lg-1 text-right">
            <label class="control-label text-bold margintop">Documento:</label>
        </div>
        <div class="form-group col-lg-2">
            <input type="text" class="form-control" id="documento_u" name="documento_u" placeholder="Documento" value="<?php echo $get_id[0]['documento']; ?>" onkeypress="if(event.keyCode == 13){ Update_Despesa(); }">
        </div>

        <div class="form-group col-lg-1 text-right">
            <label class="control-label text-bold margintop">Data Doc.:</label>
        </div>
        <div class="form-group col-lg-2">
            <input type="date" class="form-control" id="fec_documento_u" name="fec_documento_u" value="<?php echo $get_id[0]['fec_documento']; ?>" onblur="Fecha_Documento();" onkeypress="if(event.keyCode == 13){ Update_Despesa(); }">
        </div>

        <div class="form-group col-lg-1 text-right">
            <label class="control-label text-bold margintop">Mes (Gasto):</label>
        </div>
        <div class="form-group col-lg-2"> 
            <select class="form-control basic" id="mes_gasto_u" name="mes_gasto_u">
                <option value="0">Seleccione</option>
                <?php foreach($list_anio as $list){ 
                    foreach($list_mes as $mes){ ?>
                        <option value="<?php echo $mes['cod_mes']."/".$list['nom_anio']; ?>" <?php if($mes['cod_mes'].$list['nom_anio']==$get_id[0]['mes'].$get_id[0]['anio']){ echo "selected"; } ?>>
                            <?php echo substr($mes['nom_mes'],0,3)."/".substr($list['nom_anio'],-2); ?>
                        </option>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>

        <div class="form-group col-lg-1 text-right">
            <label class="control-label text-bold margintop">Data Pag:</label>
        </div>
        <div class="form-group col-lg-2">
            <input type="date" class="form-control" id="fec_pago_u" name="fec_pago_u" value="<?php echo $get_id[0]['fec_pago']; ?>" onblur="validarFecha('fec_pago_u');" onkeypress="if(event.keyCode == 13){ Update_Despesa(); }">
        </div>
    </div>

    <div class="col-lg-12 row" style="margin-bottom:15px;">
        <div class="form-group col-lg-1 text-right">
            <label class="control-label text-bold margintop">Valor:</label>
        </div>
        <div class="form-group col-lg-1">
            <input type="number" class="form-control" id="valor_u" name="valor_u" placeholder="Valor" value="<?php echo $get_id[0]['valor']; ?>" onkeypress="if(event.keyCode == 13){ Update_Despesa(); }">
        </div>

        <div class="form-group col-lg-2 text-right">
            <label class="control-label text-bold">Sem Contabilizar:</label> 
            <input type="checkbox" class="tamanio" id="sin_contabilizar_u" name="sin_contabilizar_u" value="1" <?php if($get_id[0]['sin_contabilizar']==1){ echo "checked"; } ?> style="margin-left:20px;" onclick="Sin_Contabilizar();">
        </div>

        <div class="form-group col-lg-1 text-right ver_sin_contabilizar">
            <label class="control-label text-bold margintop">Colaborador:</label>
        </div>
        <div class="form-group col-lg-2 ver_sin_contabilizar">
            <select class="form-control" name="id_colaborador" id="id_colaborador">
                <option value="0">Seleccione</option>
                <?php foreach($list_colaborador as $list){ ?>
                    <option value="<?= $list['id_usuario'] ?>" 
                        <?php if($list['id_usuario']==$get_id[0]['id_colaborador']){ echo "selected"; } ?>>
                        <?= $list['usuario_codigo']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group col-lg-2 text-right">
            <label class="control-label text-bold">Enviado Original:</label>
            <input type="checkbox" class="tamanio" id="enviado_original_u" name="enviado_original_u" value="1" <?php if($get_id[0]['enviado_original']==1){ echo "checked"; } ?> style="margin-left:20px;" onclick="Comprobar()">
        </div>

        <div class="form-group col-lg-2 text-right">
            <label class="control-label text-bold">Sem Doc. Físico:</label>
            <input type="checkbox" class="tamanio" id="sin_documento_fisico_u" name="sin_documento_fisico_u" value="1" <?php if($get_id[0]['sin_documento_fisico']==1){ echo "checked"; } ?> style="margin-left:20px;" onclick="Comprobar()">
        </div>
    </div>

    <div class="col-lg-12 row" style="margin-bottom:15px;">
        <div class="form-group col-lg-1 text-right">
            <label class="control-label text-bold">Observaçoes:</label>
        </div>
        <div class="form-group col-lg-11">
            <textarea class="form-control" id="observaciones_u" name="observaciones_u" placeholder="Observaciones" rows="2"><?php echo $get_id[0]['observaciones']; ?></textarea>
        </div>
    </div>

    <div class="col-lg-12 row" style="margin-bottom:15px;">
        <div class="form-group col-lg-2 text-right">
            <label class="control-label text-bold">Documento:</label>
        </div>
        <div class="form-group col-lg-4">
            <button type="button" onclick="Abrir('archivo_u')">Seleccionar archivo</button>
            <input type="file" id="archivo_u" name="archivo_u" onchange="Nombre_Archivo(this,'span_archivo','archivo_u')" style="display: none">
            <span id="span_archivo"><?php if($get_id[0]['archivo']!=""){ echo $get_id[0]['nom_archivo']; }else{ echo "No se eligió archivo"; } ?></span>
        </div>

        <?php if($get_id[0]['archivo']!=""){ ?>
            <div id="i_1" class="col-lg-2">
                <label class="text-bold" style="margin-right: 25px;">Descargar/Eliminar:</label>
                <a style="cursor:pointer;" title="Descargar" class="download" type="button" onclick="Descargar_Archivo('<?php echo $get_id[0]['id_despesa']; ?>',1)">
                    <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                </a>
                <a style="cursor:pointer;" class="delete" type="button" onclick="Delete_Archivo('<?php echo $get_id[0]['id_despesa']; ?>',1);">
                    <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                </a>
            </div>
        <?php } ?>
    </div>

    <div class="col-lg-12 row" style="margin-bottom:15px;">
        <div class="form-group col-lg-2 text-right">
            <label class="control-label text-bold">Pagamento:</label>
        </div>
        <div class="form-group col-lg-4"> 
            <button type="button" onclick="Abrir('pagamento_u')">Seleccionar archivo</button>
            <input type="file" id="pagamento_u" name="pagamento_u" onchange="Nombre_Archivo(this,'span_pagamento','pagamento_u')" style="display: none">
            <span id="span_pagamento"><?php if($get_id[0]['pagamento']!=""){ echo $get_id[0]['nom_pagamento']; }else{ echo "No se eligió archivo"; } ?></span>
        </div>
            
        <?php if($get_id[0]['pagamento']!=""){ ?>
            <div id="i_2" class="col-lg-2">
                <label class="text-bold" style="margin-right: 25px;">Descargar/Eliminar:</label>
                <a style="cursor:pointer;" title="Descargar" class="download" type="button" onclick="Descargar_Archivo('<?php echo $get_id[0]['id_despesa']; ?>',2)">
                    <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                </a>
                <a style="cursor:pointer;" class="delete" type="button" onclick="Delete_Archivo('<?php echo $get_id[0]['id_despesa']; ?>',2);">
                    <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                </a>
            </div>
        <?php } ?>
    </div>

    <div class="col-lg-12 row" style="margin-bottom:15px;">
        <div class="form-group col-lg-2 text-right">
            <label class="control-label text-bold">Doc. & Pagamento:</label>
        </div>
        <div class="form-group col-lg-4"> 
            <button type="button" onclick="Abrir('doc_pagamento_u')">Seleccionar archivo</button>
            <input type="file" id="doc_pagamento_u" name="doc_pagamento_u" onchange="Nombre_Archivo(this,'span_doc_pagamento','doc_pagamento_u')" style="display: none">
            <span id="span_doc_pagamento"><?php if($get_id[0]['doc_pagamento']!=""){ echo $get_id[0]['nom_doc_pagamento']; }else{ echo "No se eligió archivo"; } ?></span>
        </div>
            
        <?php if($get_id[0]['doc_pagamento']!=""){ ?>
            <div id="i_3" class="col-lg-2">
                <label class="text-bold" style="margin-right: 25px;">Descargar/Eliminar:</label>
                <a style="cursor:pointer;" title="Descargar" class="download" type="button" onclick="Descargar_Archivo('<?php echo $get_id[0]['id_despesa']; ?>',3)">
                    <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                </a>
                <a style="cursor:pointer;" class="delete" type="button" onclick="Delete_Archivo('<?php echo $get_id[0]['id_despesa']; ?>',3);">
                    <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                </a>
            </div>
        <?php } ?>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="anio" name="anio" value="<?=$list_anio[0]['nom_anio']?>">
        <input type="hidden" id="id_despesa" name="id_despesa" value="<?php echo $get_id[0]['id_despesa']; ?>">
        <input type="hidden" id="referencia" name="referencia" value="<?php echo $get_id[0]['referencia']; ?>">
        <input type="hidden" id="archivo_actual" name="archivo_actual" value="<?php echo $get_id[0]['archivo']; ?>">
        <input type="hidden" id="pagamento_actual" name="pagamento_actual" value="<?php echo $get_id[0]['pagamento']; ?>">
        <input type="hidden" id="doc_pagamento_actual" name="doc_pagamento_actual" value="<?php echo $get_id[0]['doc_pagamento']; ?>">
        <input type="hidden" id="nom_archivo_actual" name="nom_archivo_actual" value="<?php echo $get_id[0]['nom_archivo']; ?>">
        <input type="hidden" id="nom_pagamento_actual" name="nom_pagamento_actual" value="<?php echo $get_id[0]['nom_pagamento']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Despesa();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
        <a type="button" class="btn btn-default" href="<?= site_url('Ca/Despesa') ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
    </div>
</form>

<script>
    var ss = $(".basic").select2({
        tags: true,
    });
</script>