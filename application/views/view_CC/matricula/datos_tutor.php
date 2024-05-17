<div class="col-md-12" style="margin-bottom:10px;">
    <label class="control-label text-bold">TUTOR (Principal)</label>
</div>

<div class="col-md-12 row">
    <div class="form-group col-md-2">
        <label class="control-label text-bold">Tipo de Doc.:</label>
        <div class="col">
            <select class="form-control" id="id_tipo_documento_prin" name="id_tipo_documento_prin">
                <option value="0" <?php if($get_id[0]['id_tipo_documento_prin']==0){ echo "selected"; } ?>>Seleccione</option>
                <option value="1" <?php if($get_id[0]['id_tipo_documento_prin']==1){ echo "selected"; } ?>>DNI</option>
            </select>
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Nr. Doc.:</label>
        <div class="col">
            <input type="text" class="form-control solo_numeros" id="n_doc_prin" name="n_doc_prin" maxlength="8" placeholder="Ingresar Nr. Doc." value="<?php echo $get_id[0]['n_doc_prin']; ?>">
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Fecha Nac.:</label>
        <div class="col">
            <input type="date" class="form-control" id="fec_nac_prin" name="fec_nac_prin" value="<?php echo $get_id[0]['fec_nac_prin']; ?>">
        </div>
    </div>

    <div class="form-group col-md-1">
        <label class="control-label text-bold">Parentesco:</label>
        <div class="col">
            <select class="form-control" id="parentesco_prin" name="parentesco_prin">
                <option value="0">Seleccione</option>
                <?php foreach($list_parentesco as $list){ ?>
                    <option value="<?php echo $list['id_parentesco']; ?>" <?php if($list['id_parentesco']==$get_id[0]['parentesco_prin']){ echo "selected"; } ?>>
                        <?php echo $list['nom_parentesco']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>

<div class="col-md-12 row">
    <div class="form-group col-md-3">
        <label class="control-label text-bold">Apellido(s) Pat.:</label>
        <div class="col">
            <input type="text" class="form-control" id="apater_prin" name="apater_prin" placeholder="Ingresar Apellido(s) Pat." value="<?php echo $get_id[0]['apater_prin']; ?>">
        </div>
    </div>

    <div class="form-group col-md-3">
        <label class="control-label text-bold">Apellido(s) Mat.:</label>
        <div class="col">
            <input type="text" class="form-control" id="amater_prin" name="amater_prin" placeholder="Ingresar Apellido(s) Mat." value="<?php echo $get_id[0]['amater_prin']; ?>">
        </div>
    </div>

    <div class="form-group col-md-3">
        <label class="text-bold">Nombre(s):</label>
        <div class="col">
            <input type="text" class="form-control" id="nombres_prin" name="nombres_prin" placeholder="Ingresar Nombre(s)" value="<?php echo $get_id[0]['nombres_prin']; ?>">
        </div>
    </div>
</div>

<div class="col-md-12 row">
    <div class="form-group col-md-1">
        <label class="control-label text-bold">Vive Alumno(a):</label>
        <div class="col">
            <input type="checkbox" class="tamanio" id="vive_alumno_prin" name="vive_alumno_prin" value="1" onclick="Vive_Alumno_Prin();" <?php if($get_id[0]['vive_alumno_prin']==1){ echo "checked"; } ?>>
        </div>
    </div>

    <div class="form-group col-md-3">
        <label class="control-label text-bold">Dirección:</label>
        <div class="col">
            <input type="text" class="form-control" id="direccion_prin" name="direccion_prin" placeholder="Ingresar Dirección" value="<?php echo $get_id[0]['direccion_prin']; ?>">
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Departamento:</label>
        <div class="col">
            <select class="form-control" id="id_departamento_prin" name="id_departamento_prin" onchange="Provincia_Prin();">
                <option value="0">Seleccione</option>
                <?php foreach($list_departamento as $list){ ?>
                    <option value="<?php echo $list['id_departamento']; ?>" <?php if($list['id_departamento']==$get_id[0]['id_departamento_prin']){ echo "selected"; } ?>>
                        <?php echo $list['nombre_departamento']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="text-bold">Provincia:</label>
        <div id="mprinprovincia" class="col">
            <select class="form-control" id="id_provincia_prin" name="id_provincia_prin" onchange="Distrito_Prin();">
                <option value="0">Seleccione</option>
                <?php foreach($list_provincia_prin as $list){ ?>
                    <option value="<?php echo $list['id_provincia']; ?>" <?php if($list['id_provincia']==$get_id[0]['id_provincia_prin']){ echo "selected"; } ?>>
                        <?php echo $list['nombre_provincia']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="text-bold">Distrito:</label>
        <div id="mprindistrito" class="col">
            <select class="form-control" id="id_distrito_prin" name="id_distrito_prin">
                <option value="0">Seleccione</option>
                <?php foreach($list_distrito_prin as $list){ ?>
                    <option value="<?php echo $list['id_distrito']; ?>" <?php if($list['id_distrito']==$get_id[0]['id_distrito_prin']){ echo "selected"; } ?>>
                        <?php echo $list['nombre_distrito']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>

<div class="col-md-12 row">
    <div class="form-group col-md-2">
        <label class="control-label text-bold">Celular:</label>
        <div class="col">
            <input type="text" class="form-control solo_numeros" id="celular_prin" name="celular_prin" maxlength="9" placeholder="Ingresar Celular" value="<?php echo $get_id[0]['celular_prin']; ?>">
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Teléfono Casa:</label>
        <div class="col">
            <input type="text" class="form-control solo_numeros" id="telf_casa_prin" name="telf_casa_prin" maxlength="9" placeholder="Ingresar Teléfono Casa" value="<?php echo $get_id[0]['telf_casa_prin']; ?>">
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Correo Personal:</label>
        <div class="col">
            <input type="text" class="form-control" id="correo_personal_prin" name="correo_personal_prin" placeholder="Ingresar Correo Personal" value="<?php echo $get_id[0]['correo_personal_prin']; ?>">
        </div>
    </div>
</div>

<div class="col-md-12 row">
    <div class="form-group col-md-2">
        <label class="control-label text-bold">Ocupación:</label>
        <div class="col">
            <input type="text" class="form-control" id="ocupacion_prin" name="ocupacion_prin" placeholder="Ingresar Ocupación" value="<?php echo $get_id[0]['ocupacion_prin']; ?>">
        </div>
    </div>

    <div class="form-group col-md-3">
        <label class="control-label text-bold">Centro de Empleo:</label>
        <div class="col">
            <input type="text" class="form-control" id="centro_empleo_prin" name="centro_empleo_prin" placeholder="Ingresar Centro de Empleo" value="<?php echo $get_id[0]['centro_empleo_prin']; ?>">
        </div>
    </div>
</div>

<div class="col-md-12" style="margin-top:10px;margin-bottom:10px;">
    <label class="control-label text-bold">TUTOR (Secundario)</label>
</div>

<div class="col-md-12 row">
    <div class="form-group col-md-2">
        <label class="control-label text-bold">Tipo de Doc.:</label>
        <div class="col">
            <select class="form-control" id="id_tipo_documento_secu" name="id_tipo_documento_secu">
                <option value="0" <?php if($get_id[0]['id_tipo_documento_secu']==0){ echo "selected"; } ?>>Seleccione</option>
                <option value="1" <?php if($get_id[0]['id_tipo_documento_secu']==1){ echo "selected"; } ?>>DNI</option>
            </select>
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Nr. Doc.:</label>
        <div class="col">
            <input type="text" class="form-control solo_numeros" id="n_doc_secu" name="n_doc_secu" maxlength="8" placeholder="Ingresar Nr. Doc." value="<?php echo $get_id[0]['n_doc_secu']; ?>">
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Fecha Nac.:</label>
        <div class="col">
            <input type="date" class="form-control" id="fec_nac_secu" name="fec_nac_secu" value="<?php echo $get_id[0]['fec_nac_secu']; ?>">
        </div>
    </div>

    <div class="form-group col-md-1">
        <label class="control-label text-bold">Parentesco:</label>
        <div class="col">
            <select class="form-control" id="parentesco_secu" name="parentesco_secu">
                <option value="0">Seleccione</option>
                <?php foreach($list_parentesco as $list){ ?>
                    <option value="<?php echo $list['id_parentesco']; ?>" <?php if($list['id_parentesco']==$get_id[0]['parentesco_secu']){ echo "selected"; } ?>>
                        <?php echo $list['nom_parentesco']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>

<div class="col-md-12 row">
    <div class="form-group col-md-3">
        <label class="control-label text-bold">Apellido(s) Pat.:</label>
        <div class="col">
            <input type="text" class="form-control" id="apater_secu" name="apater_secu" placeholder="Ingresar Apellido(s) Pat." value="<?php echo $get_id[0]['apater_secu']; ?>">
        </div>
    </div>

    <div class="form-group col-md-3">
        <label class="control-label text-bold">Apellido(s) Mat.:</label>
        <div class="col">
            <input type="text" class="form-control" id="amater_secu" name="amater_secu" placeholder="Ingresar Apellido(s) Mat." value="<?php echo $get_id[0]['amater_secu']; ?>">
        </div>
    </div>

    <div class="form-group col-md-3">
        <label class="text-bold">Nombre(s):</label>
        <div class="col">
            <input type="text" class="form-control" id="nombres_secu" name="nombres_secu" placeholder="Ingresar Nombre(s)" value="<?php echo $get_id[0]['nombres_secu']; ?>">
        </div>
    </div>
</div>

<div class="col-md-12 row">
    <div class="form-group col-md-1">
        <label class="control-label text-bold">Vive Alumno(a):</label>
        <div class="col">
            <input type="checkbox" class="tamanio" id="vive_alumno_secu" name="vive_alumno_secu" value="1" onclick="Vive_Alumno_Secu();" <?php if($get_id[0]['vive_alumno_secu']==1){ echo "checked"; } ?>>
        </div>
    </div>

    <div class="form-group col-md-3">
        <label class="control-label text-bold">Dirección:</label>
        <div class="col">
            <input type="text" class="form-control" id="direccion_secu" name="direccion_secu" placeholder="Ingresar Dirección" value="<?php echo $get_id[0]['direccion_secu']; ?>">
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Departamento:</label>
        <div class="col">
            <select class="form-control" id="id_departamento_secu" name="id_departamento_secu" onchange="Provincia_Secu();">
                <option value="0">Seleccione</option>
                <?php foreach($list_departamento as $list){ ?>
                    <option value="<?php echo $list['id_departamento']; ?>" <?php if($list['id_departamento']==$get_id[0]['id_departamento_secu']){ echo "selected"; } ?>>
                        <?php echo $list['nombre_departamento']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="text-bold">Provincia:</label>
        <div id="msecuprovincia" class="col">
            <select class="form-control" id="id_provincia_secu" name="id_provincia_secu" onchange="Distrito_Secu();">
                <option value="0">Seleccione</option>
                <?php foreach($list_provincia_secu as $list){ ?>
                    <option value="<?php echo $list['id_provincia']; ?>" <?php if($list['id_provincia']==$get_id[0]['id_provincia_secu']){ echo "selected"; } ?>>
                        <?php echo $list['nombre_provincia']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="text-bold">Distrito:</label>
        <div id="msecudistrito" class="col">
            <select class="form-control" id="id_distrito_secu" name="id_distrito_secu">
                <option value="0">Seleccione</option>
                <?php foreach($list_distrito_secu as $list){ ?>
                    <option value="<?php echo $list['id_distrito']; ?>" <?php if($list['id_distrito']==$get_id[0]['id_distrito_secu']){ echo "selected"; } ?>>
                        <?php echo $list['nombre_distrito']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>

<div class="col-md-12 row">
    <div class="form-group col-md-2">
        <label class="control-label text-bold">Celular:</label>
        <div class="col">
            <input type="text" class="form-control solo_numeros" id="celular_secu" name="celular_secu" maxlength="9" placeholder="Ingresar Celular" value="<?php echo $get_id[0]['celular_secu']; ?>">
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Teléfono Casa:</label>
        <div class="col">
            <input type="text" class="form-control solo_numeros" id="telf_casa_secu" name="telf_casa_secu" maxlength="9" placeholder="Ingresar Teléfono Casa" value="<?php echo $get_id[0]['telf_casa_secu']; ?>">
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Correo Personal:</label>
        <div class="col">
            <input type="text" class="form-control" id="correo_personal_secu" name="correo_personal_secu" placeholder="Ingresar Correo Personal" value="<?php echo $get_id[0]['correo_personal_secu']; ?>">
        </div>
    </div>
</div>

<div class="col-md-12 row">
    <div class="form-group col-md-2">
        <label class="control-label text-bold">Ocupación:</label>
        <div class="col">
            <input type="text" class="form-control" id="ocupacion_secu" name="ocupacion_secu" placeholder="Ingresar Ocupación" value="<?php echo $get_id[0]['ocupacion_secu']; ?>">
        </div>
    </div>

    <div class="form-group col-md-3">
        <label class="control-label text-bold">Centro de Empleo:</label>
        <div class="col">
            <input type="text" class="form-control" id="centro_empleo_secu" name="centro_empleo_secu" placeholder="Ingresar Centro de Empleo" value="<?php echo $get_id[0]['centro_empleo_secu']; ?>">
        </div>
    </div>
</div>

<div class="col-md-12 modal-footer" style="margin-top:10px;">
    <input type="hidden" id="id_temporal_datos_alumno" name="id_temporal_datos_alumno" value="<?php echo $get_id[0]['id_temporal']; ?>">
    <button type="button" class="btn btn-primary" onclick="Update_Datos_Tutor();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
</div>

<script>
    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>