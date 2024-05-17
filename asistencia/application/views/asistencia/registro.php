<?php $Documento_Pendiente = $get_id[0]['documentos_obligatorios']-($get_id[0]['documentos_subidos']+$get_id[0]['Primer_Documento']+$get_id[0]['Segundo_Documento']); ?>
<input type="hidden" id="simbolo" value="<?php echo $simbolo; ?>">
<input type="hidden" id="cod_alum" name="cod_alum" value="<?php echo $get_id[0]['Codigoa']; ?>">
<div class="contenedor-nombre-foto">
    <div class="contenedor-fondo">
        <img src="<?= base_url() ?>template/img/huella_Mesa_trabajo.png">
    </div>
    <div class="contenedor-nombre">
        <?php if($get_id[0]['Tipo']==3){ ?>
	        <label class="descrip2"><?php echo $get_id[0]['Nombre']." ".$get_id[0]['Codigoa']; ?></label>
        <?php }else{ ?>
            <label class="descrip2"><?php echo $get_id[0]['apellidos']; ?>,<br><b><?php echo $get_id[0]['Nombre']; ?></b></label>
        <?php } ?>
	</div> 
    <div class="contenedor-foto">
        <?php if(count($get_foto)>0){ ?> 
            <?php if($get_foto[0]['foto']!=""){ ?>
                <img class="avatar" src="<?php echo "https://snappy.org.pe/".$get_foto[0]['foto']; ?>"> 
            <?php }else{ ?>
                <img class="avatar" src="<?= base_url() ?>template/img/avatar1.jpg">
            <?php } ?>
        <?php }else{ ?>
            <img class="avatar" src="<?= base_url() ?>template/img/avatar1.jpg">
        <?php } ?>
    </div>
</div>
<div class="contenedor-mostrar-datos">
    
    <div class="contenedor-mostrar-inputs">
        <div class="text1"><label>&nbsp;&nbsp;<b>Código:</b> <?php echo $get_id[0]['Codigoa']; ?></label></div>
        <div class="text2"><label>&nbsp;&nbsp;<b>Grupo:</b> <?php echo $get_id[0]['Grupo']; ?></label></div>
        <div class="text3"><label style="width: 75%;">&nbsp;&nbsp;<b>Modulo:</b> <?php echo $get_id[0]['Modulo']; ?></label><div style="width: 25%; text-align:end;"> <img src="<?= base_url() ?>template/img/iconslupa.png" style="width: 50%;" data-toggle="modal" data-target="#modal_ver2" app_crear_ver="<?= site_url('Asistencia/Lista_Historico')?>/<?php echo $get_id[0]['Codigo']; ?>"></div></div>
        <div class="text4"><label>&nbsp;&nbsp;<b>Especialidad:</b> <?php echo $get_id[0]['especialidad']; ?></label></div>
    </div>
    <div class="contenedor-mostrar-text-img">
        <div class="text5">
            <?php if($get_id[0]['Tipo']==1){ ?>
                <?php if($get_id[0]['Pago_Pendiente']>0){ ?>
                    <label class="descrip">&nbsp;&nbsp;Pendiente pagar <?php echo $get_id[0]['Pago_Pendiente']; ?> pensión(es)</label>
                <?php }else{ ?>
                    <label class="descrip">&nbsp;&nbsp;Pensiones al día</label>
                <?php } ?>

                <?php if($Documento_Pendiente>0){ ?>
                    <label class="descrip">&nbsp;&nbsp;Pendiente entregar <?php echo $Documento_Pendiente; ?> documento(s)</label>
                <?php }else{ ?>
                    <label class="descrip">&nbsp;&nbsp;Documentos completos</label>
                <?php } ?>

                <?php if($get_id[0]['Fotocheck']>0){ ?>
                    <label class="descrip">&nbsp;&nbsp;Pago Fotocheck Efectuado</label>
                <?php }else{ ?>
                    <label class="descrip">&nbsp;&nbsp;Pendiente Pago Fotocheck</label>
                <?php } ?>

                <?php if($duplicidad>0){ ?>
                    <label class="descrip">&nbsp;&nbsp;<?php echo count($get_duplicidad); ?> Registro manual</label>
                <?php } ?>
            <?php }else{ ?>
                <?php if($duplicidad>0){ ?> 
                    <label class="descrip">&nbsp;&nbsp;<?php echo count($get_duplicidad); ?> Registro manual</label>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="text6">
            <?php if($simbolo==1){ ?>
                <img src="<?= base_url() ?>template/img/signo_sheck_Mesa_trabajo.png" onclick="abrirmodal()">
            <?php }elseif($simbolo==2){ ?>
                <img src="<?= base_url() ?>template/img/signo_admiracion_Mesa_trabajo.png" onclick="abrirmodal()">
            <?php }else{ ?>
                <img src="<?= base_url() ?>template/img/signo_aspa_Mesa_trabajo.png" onclick="abrirmodal()">
            <?php } ?>
        </div>
    </div>
</div>