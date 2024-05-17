<div class="form-group col-md-12">
    <div>
        <label id="etiqueta_producto" class="control-label text-bold" >Producto Interese:&nbsp;&nbsp;</label> 
    </div>


    <input type="hidden" id="cant_interes" name="cant_interes" value="<?php echo count($list_producto_interes0); ?>">

    <!--<div class="form-group col-md-8">
    </div>-->
    <div class=" col-md-3">
        <?php foreach($list_producto_interes0 as $list){ ?>
            <label>
            <input type="checkbox" id="id_producto[]" name="id_producto[]" value="<?php echo $list['id_producto_interes']; ?>" class="check_producto grande_check">
            <span style="font-weight:normal"><?php echo $list['nom_producto_interes']; ?></span>&nbsp;&nbsp;
            </label><br>
        <?php } ?>
    </div>
    <div class="col-md-3">
        <?php  if(count($list_producto_interes)>6){?>
            
            <?php foreach($list_producto_interes10 as $list){ ?>
                <label>
                <input type="checkbox" id="id_producto[]" name="id_producto[]" value="<?php echo $list['id_producto_interes']; ?>" class="check_producto grande_check">
                <span style="font-weight:normal"><?php echo $list['nom_producto_interes']; ?></span>&nbsp;&nbsp;
                </label><br>
            <?php } ?>
            
        <?php } ?>
    </div>
    <div class="col-md-3">
        <?php 
        if(count($list_producto_interes)>12){?> 
            <div>
                <?php foreach($list_producto_interes20 as $list){ ?>
                    <label>
                    <input type="checkbox" id="id_producto[]" name="id_producto[]" value="<?php echo $list['id_producto_interes']; ?>" class="check_producto grande_check">
                    <span style="font-weight:normal"><?php echo $list['nom_producto_interes']; ?></span>&nbsp;&nbsp;
                    </label><br>
                <?php } ?>
            </div>
        <?php }
        ?>
    </div>
    <div class="col-md-3">
        <?php  if(count($list_producto_interes)>18){?>
            
            <?php foreach($list_producto_interes30 as $list){ ?>
                <label>
                <input type="checkbox" id="id_producto[]" name="id_producto[]" value="<?php echo $list['id_producto_interes']; ?>" class="check_producto grande_check">
                <span style="font-weight:normal"><?php echo $list['nom_producto_interes']; ?></span>&nbsp;&nbsp;
                </label><br>
            <?php } ?>
            
        <?php } ?>
    </div>
</div>
<!--<div>
<div>
    <?php  if(count($list_producto_interes)>10){?>
        
        <?php foreach($list_producto_interes10 as $list){ ?>
            <label>
            <input type="checkbox" id="id_producto[]" name="id_producto[]" value="<?php echo $list['id_producto_interes']; ?>" class="check_producto grande_check">
            <span style="font-weight:normal"><?php echo $list['nom_producto_interes']; ?></span>&nbsp;&nbsp;
            </label><br>
        <?php } ?>
        
    <?php } ?>
</div>
<div>-->



