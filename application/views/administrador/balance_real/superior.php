<style>
    .clase_empresa_<?php echo $empresa; ?>{
        background-color: #C8C8C8;
    }

    .clase_anio_<?php echo $anio; ?>{
        background-color: #3C3C3C;
    }
</style>

<script>
      $(document).ready(function(){
        $('.color').click(function(){
          $('.color').each(function(){
           
            $(this).css('background-color', '');
          });
         
          $(this).css('background-color', '#0074c5');
        });
      });

      $(document).ready(function(){
        $('.gris').click(function(){
          $('.gris').each(function(){
           
            $(this).css('background-color', '');
          });
         
          $(this).css('background-color', '#3C3C3C');
        });
      });
</script>

<div class="row">
    <?php 
    $array_ingreso=explode("_",$ingreso);
    $array_gasto=explode("_",$gasto);
    $array_utilidad=explode("_",$utilidad);
    $array_diferencia=explode("_",$diferencia);
    $i=0;
    foreach ($list_empresas as $list) { ?>
        <a onclick="Cambiar_Empresa('<?php echo $list['cod_empresa']; ?>')">
            <div id="div_empresa" class="col-lg-1 col-md-4 col-sm-6 col-12 text-center color clase_empresa_<?php echo $list['cod_empresa']; ?>" <?php if($list['cod_empresa']==$empresa){ ?> style="background-color:#0074c5;" <?php } ?>>
                <img src="<?= base_url().$list['imagen']; ?>" id="imagen_empresa" class="img-circle" alt="Imagen" title="<?php echo $list['nom_empresa']; ?>">
                <label class="verde"><?php echo number_format($array_ingreso[$i],2); ?></label>
                <label class="rojo"><?php echo number_format($array_gasto[$i],2); ?></label>
                <label class="azul"><?php echo number_format($array_utilidad[$i],2); ?></label>
                <label class="blanco" <?php if( (number_format($array_diferencia[$i],2)) > 0){?>
                    style="border: 1px solid #008fed;"
                             <?php   } else {?>
                                style="border: 1px solid #ff4262;"
                                 <?php } ?>><?php echo number_format($array_diferencia[$i],2)."%"; ?></label>
                    </div>
        </a>
    <?php $i++; } ?>
</div>

<div class="row">
    <?php foreach ($list_anio as $list) { ?>
        <div class="col-lg-1 col-md-4 col-sm-6 col-12 text-center">
            <a class="btn negro clase_anio_<?php echo $list['nom_anio']; ?>" onclick="Cambiar_Anio('<?php echo $list['nom_anio']; ?>');"><?php echo $list['nom_anio']; ?></a>
        </div>
    <?php } ?>
    <!--<div class="col-lg-3 text-center">
    </div>
    <div class="col-lg-2 text-center">
        <a style="color:#1b55e2;">BI Real</a>&nbsp;&nbsp;&nbsp;
        <a style="color:#1b55e2;">BI Oficial</a>&nbsp;&nbsp;&nbsp;
        <a style="color:#1b55e2;">BI General</a>
    </div>-->
</div>