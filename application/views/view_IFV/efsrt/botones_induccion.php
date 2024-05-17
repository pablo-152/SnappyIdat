<a title="Excel" onclick="Excel_Induccion();" style="margin-right: 5px;">
    <img src="<?= base_url() ?>template/img/boton_excel_tabla.png">  
</a>

<a title="PDF" <?php if($cantidad[0]['cantidad']>0){ ?> onclick="Pdf_Induccion();" <?php }else{ ?> href="#" <?php } ?>>
    <?php if($get_id[0]['nom_turno']=="Mañana"){ ?>
        <img src="<?= base_url() ?>template/img/boton_registro_manana.png"> 
    <?php }else{ ?>
        <img src="<?= base_url() ?>template/img/boton_registro_tarde.png"> 
    <?php } ?> 
</a>