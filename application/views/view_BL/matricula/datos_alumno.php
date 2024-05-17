<?php
    $fec_de = new DateTime($get_id[0]['fec_nac_alum']);
    $fec_hasta = new DateTime(date('Y-m-d'));
    $diff = $fec_de->diff($fec_hasta); 
?>

<div class="col-md-12 row">
    <div class="form-group col-md-2">
        <label class="control-label text-bold">Tipo de Doc.:</label>
        <div class="col">
            <select class="form-control" id="id_tipo_documento_alum" name="id_tipo_documento_alum">
                <option value="0" <?php if($get_id[0]['id_tipo_documento_alum']==0){ echo "selected"; } ?>>Seleccione</option>
                <option value="1" <?php if($get_id[0]['id_tipo_documento_alum']==1){ echo "selected"; } ?>>DNI</option>
            </select>
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Nr. Doc.:</label>
        <div class="col">
            <input type="text" class="form-control solo_numeros" id="n_doc_alum" name="n_doc_alum" maxlength="8" placeholder="Ingresar Nr. Doc." value="<?php echo $get_id[0]['n_doc_alum']; ?>">
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Fecha Nac.:</label>
        <div class="col">
            <input type="date" class="form-control" id="fec_nac_alum" name="fec_nac_alum" onblur="Edad();" value="<?php echo $get_id[0]['fec_nac_alum']; ?>">
        </div>
    </div>

    <div class="form-group col-md-1">
        <label class="control-label text-bold">Edad:</label>
        <div class="col">
            <input type="text" class="form-control solo_numeros" id="edad_alum" placeholder="Ingresar Edad" readonly value="<?php echo $diff->y; ?>">
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Sexo:</label>
        <div class="col">
            <select class="form-control" id="id_sexo_alum" name="id_sexo_alum">
                <option value="0" <?php if($get_id[0]['id_sexo_alum']==0){ echo "selected"; } ?>>Seleccione</option>
                <option value="1" <?php if($get_id[0]['id_sexo_alum']==1){ echo "selected"; } ?>>Femenino</option>
                <option value="2" <?php if($get_id[0]['id_sexo_alum']==2){ echo "selected"; } ?>>Masculino</option>
            </select>
        </div>
    </div>
</div>
    
<div class="col-md-12 row">
    <div class="form-group col-md-3">
        <label class="control-label text-bold">Apellido(s) Pat.:</label>
        <div class="col">
            <input type="text" class="form-control" id="apater_alum" name="apater_alum" placeholder="Ingresar Apellido(s) Pat." value="<?php echo $get_id[0]['apater_alum']; ?>">
        </div>
    </div>

    <div class="form-group col-md-3">
        <label class="control-label text-bold">Apellido(s) Mat.:</label>
        <div class="col">
            <input type="text" class="form-control" id="amater_alum" name="amater_alum" placeholder="Ingresar Apellido(s) Mat." value="<?php echo $get_id[0]['amater_alum']; ?>">
        </div>
    </div>

    <div class="form-group col-md-3">
        <label class="text-bold">Nombre(s):</label>
        <div class="col">
            <input type="text" class="form-control" id="nombres_alum" name="nombres_alum" placeholder="Ingresar Nombre(s)" value="<?php echo $get_id[0]['nombres_alum']; ?>">
        </div>
    </div>
</div>

<div class="col-md-12 row">
    <div class="form-group col-md-3">
        <label class="control-label text-bold">Dirección:</label>
        <div class="col">
            <input type="text" class="form-control" id="direccion_alum" name="direccion_alum" placeholder="Ingresar Dirección" value="<?php echo $get_id[0]['direccion_alum']; ?>">
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="control-label text-bold">Departamento:</label>
        <div class="col">
            <select class="form-control" id="id_departamento_alum" name="id_departamento_alum" onchange="Provincia_Alum();">
                <option value="0">Seleccione</option>
                <?php foreach($list_departamento as $list){ ?>
                    <option value="<?php echo $list['id_departamento']; ?>" <?php if($list['id_departamento']==$get_id[0]['id_departamento_alum']){ echo "selected"; } ?>>
                        <?php echo $list['nombre_departamento']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="text-bold">Provincia:</label>
        <div id="mprovincia" class="col">
            <select class="form-control" id="id_provincia_alum" name="id_provincia_alum" onchange="Distrito_Alum();">
                <option value="0">Seleccione</option>
                <?php foreach($list_provincia_alum as $list){ ?>
                    <option value="<?php echo $list['id_provincia']; ?>" <?php if($list['id_provincia']==$get_id[0]['id_provincia_alum']){ echo "selected"; } ?>>
                        <?php echo $list['nombre_provincia']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="form-group col-md-2">
        <label class="text-bold">Distrito:</label>
        <div id="mdistrito" class="col">
            <select class="form-control" id="id_distrito_alum" name="id_distrito_alum">
                <option value="0">Seleccione</option>
                <?php foreach($list_distrito_alum as $list){ ?>
                    <option value="<?php echo $list['id_distrito']; ?>" <?php if($list['id_distrito']==$get_id[0]['id_distrito_alum']){ echo "selected"; } ?>>
                        <?php echo $list['nombre_distrito']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>

<div class="col-md-12 row">
    <div class="form-group col-md-2">
        <label class="text-bold">Correo Corporativo:</label>
        <div class="col">
            <input type="text" class="form-control" id="correo_corporativo_alum" name="correo_corporativo_alum" placeholder="Ingresar Correo Corporativo" value="<?php echo $get_id[0]['correo_corporativo_alum']; ?>">
        </div>
    </div>
</div>

<div class="col-md-12 modal-footer" style="margin-top:10px;">
    <input type="hidden" id="id_temporal_datos_alumno" name="id_temporal_datos_alumno" value="<?php echo $get_id[0]['id_temporal']; ?>">
    <button type="button" class="btn btn-primary" onclick="Update_Datos_Alumno();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
</div>

<script>
    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>