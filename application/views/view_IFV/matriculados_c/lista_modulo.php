<?php  
//echo $list_meses[0]['mes'];

foreach($list_modulo as $list){ ?>
    <input type="radio" name="modulo" id="modulo<?php echo $list['modulo']?>" class="label2" style="max-height: 50px !important;" value="<?php echo $list['modulo']?>" onclick="Lista_Ingresos()" checked>
    <label class="modulo2" for="mes<?php echo $list['modulo']?>"><?php echo $list['modulo']?></label>
<?php  }?>
<script>
Lista_Ingresos();
</script>




