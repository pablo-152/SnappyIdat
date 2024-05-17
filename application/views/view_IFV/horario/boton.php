<?php if($id==1){ ?>
    <button type="button" class="btn boton_principal_revisado" <?php if($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6){ ?> onclick="Primer_Estado(0);" <?php } ?>>Revisado</button>
    <?php if($id_registro!=""){ ?>
        <span class="span_volador1"><?php echo $get_id[0]['f_rev']; ?></span>
        <span class="span_volador2"><?php echo $get_id[0]['u_rev']; ?></span>
    <?php } ?>
<?php }else{ ?>
    <button type="button" class="btn boton_principal_pendiente" <?php if($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6){ ?> onclick="Primer_Estado(1);" <?php } ?>>Pendiente</button>
<?php } ?>