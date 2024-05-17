<input type="hidden" id="buscar" name="buscar" value="<?php echo count($list_alumno); ?>">
<select  class="form-control" name="InternalStudentId" id="InternalStudentId" required>
    <option value="0">Seleccione</option>
    <?php if($accion==3){
        foreach($list_alumno as $list){ ?>
            <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['codigo']." - ".$list['usuario_nombres'].", ".$list['usuario_apater']." ".$list['usuario_amater'];?></option>
        <?php }
    }else{
        foreach($list_alumno as $list){ ?>
        <option value="<?php echo $list['InternalStudentId']; ?>"><?php echo $list['InternalStudentId']." - ".$list['FirstName'].", ".$list['FatherSurname']." ".$list['MotherSurname'];?></option>
    <?php }
    }
     ?>
</select>