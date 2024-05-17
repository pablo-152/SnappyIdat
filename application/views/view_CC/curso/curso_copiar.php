<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="col-md-12 row" style="margin-bottom:15px;">
        <div class="form-group col-md-1">
            <label class=" control-label text-bold margintop">Curso&nbsp;a&nbsp;Copiar: </label> 
        </div>
        <div class="form-group col-md-2">
            <select class="form-control" id="id_copiar" name="id_copiar" onchange="Curso_Copiar();">
                <option  value="0">Seleccione</option>
                <?php foreach($list_curso_copiar as $list){ ?>
                    <option value="<?php echo $list['id_curso']; ?>" <?php if($list['id_curso']==$get_id[0]['id_curso']){ echo "selected"; } ?>>
                        <?php echo $list['nom_curso']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <!--<div class="col-md-12 row" style="margin-bottom:15px;">
        <div class="form-group col-md-1">
            <label class="control-label text-bold margintop">Grupo:</label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control" id="grupo" name="grupo" placeholder="Grupo" value="<?php echo $get_id[0]['grupo']; ?>">
        </div>

        <div class="form-group col-md-1">
            <label class="control-label text-bold margintop">Unidad:</label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control" id="unidad" name="unidad" placeholder="Unidad" value="<?php echo $get_id[0]['unidad']; ?>">
        </div>

        <div class="form-group col-md-1">
            <label class="control-label text-bold margintop">Turno:</label>
        </div>
        <div class="form-group col-md-2">
            <select class="form-control" id="turno" name="turno">
                <option value="0" <?php if($get_id[0]['turno']==0){ echo "selected"; } ?>>Seleccione</option>
                <option value="1" <?php if($get_id[0]['turno']==1){ echo "selected"; } ?>>L-M-V</option>
            </select>
        </div>
    </div>-->

    <div class="col-md-12 row" style="margin-bottom:15px;">
        <div class="form-group col-md-1">
            <label class="control-label text-bold margintop">Nombre:</label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control" id="nom_curso" name="nom_curso" placeholder="Nombre" value="<?php echo $get_id[0]['nom_curso']; ?>">
        </div>

        <div class="form-group col-md-1">
            <label class="control-label text-bold margintop">Curso:</label>
        </div>
        <div class="form-group col-md-2">
            <select class="form-control" name="id_grado" id="id_grado">
                <option value="0">Seleccione</option>
                <?php foreach($list_grado as $list){ ?>
                    <option value="<?php echo $list['id_grado']; ?>" <?php if($list['id_grado']==$get_id[0]['id_grado']){ echo "selected"; } ?>>
                        <?php echo $list['nom_grado'];?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group col-md-1">
            <label class="control-label text-bold margintop">Año:</label>
        </div>
        <div class="form-group col-md-2">
            <select class="form-control" name="id_anio" id="id_anio">
                <option value="0">Seleccione</option>
                <?php foreach($list_anio as $list){ ?>
                    <option value="<?php echo $list['id_anio']; ?>" <?php if($list['id_anio']==$get_id[0]['id_anio']){ echo "selected"; } ?>>
                        <?php echo $list['nom_anio'];?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="col-md-12 row" style="margin-bottom:15px;">
        <div class="form-group col-md-1">
            <label class="control-label text-bold margintop">Inicio Matrícula: </label>
        </div>
        <div class="form-group col-md-2">
            <input type="date" class="form-control" id="fec_inicio" name="fec_inicio">
        </div>

        <div class="form-group col-md-1">
            <label class="control-label text-bold margintop">Fin Matrícula: </label>
        </div>
        <div class="form-group col-md-2">
            <input type="date" class="form-control" id="fec_fin" name="fec_fin">
        </div>

        <div class="form-group col-md-1">
            <label class="control-label text-bold margintop">Inicio Curso: </label>
        </div>
        <div class="form-group col-md-2">
            <input type="date" class="form-control" id="inicio_curso" name="inicio_curso">
        </div>

        <div class="form-group col-md-1">
            <label class="control-label text-bold margintop">Fin Curso: </label>
        </div>
        <div class="form-group col-md-2">
            <input type="date" class="form-control" id="fin_curso" name="fin_curso">
        </div>
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Curso();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
        <a type="button" class="btn btn-default" href="<?= site_url('Ceba2/Curso') ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
    </div>
</form>