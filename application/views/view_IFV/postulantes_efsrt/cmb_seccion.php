<select name="seccion" id="seccion" class="form-control" onchange="Busca_Alumno_Invitar()">
    <option value="0">Seleccione</option>
    <?php foreach($list_seccion as $list){?>
    <option value="<?php echo $list['id_seccion'] ?>"><?php echo $list['id_seccion'] ?></option>
    <?php }?>
</select>