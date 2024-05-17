<?php 
    $cadena = "";
    foreach($list_documento as $list){
        $cadena = $cadena.$list['nom_documento'].", ";
    } 
    $cadena = substr($cadena,0,-2).".";
?>

<div class="cuadro1">
    <label class="cuardro1-text">Recuerda</label>
</div>
<div class="cuadro2">
    <img src="<?= base_url() ?>template/img/IMG_alerta.png" class="cuadro2-img">
    <label class="cuadro2-text">Son documentos obligatorios: <?php echo $cadena; ?><br>Puedes enviar solo un documento a la vez.</label>
</div>