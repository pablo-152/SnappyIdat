<div class="form-group col-md-2">
    <select class="form-control" name="id_meses" id="id_meses" onchange="Lista_Ingresos()">
        <?php foreach($list_meses as $list){ ?>
            <option value="<?php echo $list['numero']; ?>"><?php echo $list['mes']; ?></option>
        <?php } ?>
    </select>
</div>

<script>
    Lista_Ingresos();
</script>




