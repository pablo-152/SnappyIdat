<select name="id_turno" id="id_turno" class="form-control">
    <option value="0">Seleccione</option>
    <?php if(count($get_id)>0 && isset($get_id[0]['id_turno']) && $get_id[0]['id_turno']!=""){
       foreach($list_turno as $list){ ?>
        <option value="<?php echo $list['id_turno']; ?>" <?php if(count($list_turno)==1){echo "selected";}?>>
        <?php echo $list['nom_turno']; ?>
        </option>
    <?php }  } ?>
</select>