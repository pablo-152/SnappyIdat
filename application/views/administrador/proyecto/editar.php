<form id="from_proy" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="col-md-12 row" style="margin-top:15px;margin-bottom:15px;">
        <div class="form-group col-md-2">
            <label class="control-label text-bold label_tabla">Solicitado por:</label>
            <select class="form-control" name="id_solicitante" id="id_solicitante">
            <option value="0">Seleccione</option>
                <?php foreach ($solicitado as $list) { ?>
                <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group col-md-2">
            <label class="control-label text-bold label_tabla">Fecha:</label>
            <div class="col">
            <?php echo date('d-m-Y'); ?>
            </div>
        </div>

        <div id="mempresa" class="form-group col-md-3">
            <label id="etiqueta_empresa" class="text-bold">Empresas:&nbsp;&nbsp;&nbsp;</label>
            <div class="col">
            <?php foreach ($list_empresas as $list) { ?>
                <label class="col">
                <input type="checkbox" id="id_empresa" name="id_empresa[]" value="<?php echo $list['id_empresa']; ?>" class="check_empresa" onchange="Empresa(this)">
                <span style="font-weight:normal"><?php echo $list['cod_empresa']; ?></span>&nbsp;&nbsp;
                </label>
            <?php } ?>
            </div>
        </div>

        <div id="div_sedes" class="form-group col-md-5">
        </div>
    </div>

    <div class="col-md-12 row" style="margin-top:15px;margin-bottom:15px;">
        <div class="form-group col-md-2">
            <label class="control-label text-bold label_tabla">Tipo:</label>
            <select name="id_tipo" id="id_tipo" class="form-control" onchange="Tipo();">
            <option value="0">Seleccione</option>
            <?php foreach($list_tipo as $list){ ?>
                <option value="<?php echo $list['id_tipo']; ?>"><?php echo $list['nom_tipo']; ?></option>
            <?php } ?>
            </select>
        </div>
        
        <div class="form-group col-md-2" id="cmb_subtipo">
            <label class="control-label text-bold label_tabla">Sub-Tipo:</label>
            <select name="id_subtipo" id="id_subtipo" class="form-control"  onchange="Cambio_Week();">
            <option value="0">Seleccione</option>
            </select>
        </div>

        <div class="form-group col-md-2" id="msaters">
            <label class="control-label text-bold label_tabla">Week Snappy Artes:</label>
            <input name="s_artes" type="number" class="form-control" id="s_artes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Artes">
        </div>

        <div class="form-group col-md-2" id="msredes">
            <label class="control-label text-bold label_tabla">Week Snappy Redes:</label>
            <input name="s_artes" type="number" class="form-control" id="s_artes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Redes">
        </div>
        

        <div class="form-group col-md-2">
            <label class="control-label text-bold label_tabla">Prioridad:</label>
            <select class="form-control" name="prioridad" id="prioridad">
            <option value="0">Seleccione</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            </select>
        </div>
    </div>

    <div class="col-md-12 row" style="margin-top:15px;margin-bottom:15px;">
        <div class="form-group col-md-4">
            <label class="control-label text-bold label_tabla">Descripción:</label>
            <input name="descripcion" type="text" maxlength="50" class="form-control" id="descripcion" placeholder="Descripción">
        </div>

        <div class="form-group col-md-2">
            <label class="control-label text-bold label_tabla">Agenda / Redes:</label>
            <input class="form-control date" id="fec_agenda" name="fec_agenda" type="date" value="<?php echo date('Y-m-d'); ?>" />
        </div>

        <div class="form-group col-md-6">
            <label class="control-label text-bold">Observaciones:</label>
            <textarea name="proy_obs" rows="5" class="form-control" id="proy_obs" placeholder="Observaciones"></textarea>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Proyecto()"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
        <?php if ($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
            <!-- Administrador-->
            <a type="button" class="btn btn-default" href="<?= site_url('Administrador/proyectos') ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
        <?php }elseif ($_SESSION['usuario'][0]['id_nivel']==2 || $_SESSION['usuario'][0]['id_nivel']==4){ ?>
            <!-- TEAMLEADER-->
            <a type="button" class="btn btn-default" href="<?= site_url('Teamleader/proyectos') ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
        <?php } ?>
    </div>
</form>