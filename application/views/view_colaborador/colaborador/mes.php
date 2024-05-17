<option value="0">Seleccione</option>
<?php foreach($list_meses as $list){ ?>
    <option value="<?php echo $list['numero']; ?>" <?php if($list['numero']==date('m')){ echo "selected"; } ?>>
        <?php echo $list['mes']; ?>
    </option>
<?php } ?>

<script>
    Lista_Asistencia();
</script>