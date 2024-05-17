<?php foreach($list_follow_up as $list){ ?>
    <option value="<?php echo $list['id_usuario']; ?>">
    <?php echo $list['usuario_codigo']; ?>
    </option>
<?php } ?>