<div class="col-md-12 row">
    <div class="form-group col-md-2 text-right">
        <label class="control-label text-bold margin_top">Alumno/Colaborador: </label>
    </div>
    <div class="form-group col-md-4">
        <select class="form-control basic" id="id_alumno" name="id_alumno" onchange="Update_Alumno_Nueva_Venta();"> 
            <option value="0-0">Seleccione</option>
            <?php foreach($list_alumno as $list){ ?>
                <option value="<?php echo $list['id_alumno']."-".$list['tipo_alumno']; ?>" 
                <?php if($list['id_alumno']==$get_id[0]['id_alumno']){ echo "selected"; } ?>>
                    <?php echo $list['nom_alumno']; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group col-md-1">
        <a title="Eliminar">
            <img onclick="Delete_Alumno_Nueva_Venta()" src="<?= base_url() ?>template/img/eliminar.png">
        </a>
    </div>
</div> 

<?php if($valida_alumno==1){ ?>
    <div class="col-md-12 row">
        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margin_top">Código: </label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control color_casilla" placeholder="Código" disabled value="<?php echo $get_alumno[0]['Codigo']; ?>">
        </div>

        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margin_top">Apellidos: </label> 
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control color_casilla" placeholder="Apellidos" disabled value="<?php echo $get_alumno[0]['Apellidos']; ?>">
        </div>

        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margin_top">Nombre: </label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control color_casilla" placeholder="Nombre" disabled value="<?php echo $get_alumno[0]['Nombre']; ?>">
        </div>

        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margin_top">Grupo: </label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control color_casilla" placeholder="Grupo" disabled value="<?php echo $get_alumno[0]['Grupo']; ?>">
        </div>
    </div>

    <div class="col-md-12 row">
        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margin_top">Especialidad: </label>
        </div>
        <div class="form-group col-md-3">
            <input type="text" class="form-control color_casilla" placeholder="Especialidad" disabled value="<?php echo $get_alumno[0]['Especialidad']; ?>">
        </div>
    </div>
<?php }else{ ?> 
    <div class="col-md-12 row">
        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margin_top">Código: </label> 
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control color_casilla" placeholder="Código" disabled>
        </div>

        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margin_top">Apellidos: </label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control color_casilla" placeholder="Apellidos" disabled>
        </div>

        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margin_top">Nombre: </label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control color_casilla" placeholder="Nombre" disabled>
        </div>

        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margin_top">Grupo: </label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control color_casilla" placeholder="Grupo" disabled>
        </div>
    </div>

    <div class="col-md-12 row">
        <div class="form-group col-md-1 text-right">
            <label class="control-label text-bold margin_top">Especialidad: </label>
        </div>
        <div class="form-group col-md-3">
            <input type="text" class="form-control color_casilla" placeholder="Especialidad" disabled>
        </div>
    </div>
<?php } ?>

<script>
    var ss = $(".basic").select2({
        tags: true,
    });

    //$('#id_alumno').focus().select(); 
</script>