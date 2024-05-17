<label class="text-bold">Status:</label>
<select readonly class="form-control" name="id_status_ticket" id="id_status_ticket" >
    <?php foreach($list_status as $list){ ?>
        <option selected value="<?php echo $list['id_status_general']; ?>"><?php echo $list['nom_status'];?></option>
    <?php } ?>
</select>