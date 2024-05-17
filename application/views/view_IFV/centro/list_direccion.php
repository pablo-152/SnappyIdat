<input type="hidden" id="direccion_bd" name="direccion_bd" value="<?php echo $i; ?>">
    <?php $u=1; foreach($list_direccion as $dir){?> 
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Dirección <?php echo $u; ?>:</label>
                <input readonly type="text" class="form-control" value="<?php echo $dir['direccion'] ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Departamento:</label>
                <select disabled class="form-control" >
                    <option value="0" selected><?php echo $dir['nombre_departamento'] ?></option>
                    
                </select>
            </div>

            <div  class="form-group col-md-2">
                <label class="control-label text-bold">Provincia:</label>
                <select disabled id="provincia_1" name="provincia_1" class="form-control">
                    <option value="0" selected ><?php echo $dir['nombre_provincia'] ?></option>
                </select>
            </div>

            <div  class="form-group col-md-2">
                <label class="control-label text-bold">Distrito:</label>
                <select disabled id="distrito_1" name="distrito_1" class="form-control">
                    <option value="0" selected ><?php echo $dir['nombre_distrito'] ?></option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <br>
                <div class="row">
                    &nbsp;&nbsp;
                    <input type="checkbox" disabled <?php if($dir['cp']==1){ echo "checked"; } ?> value="1" class="mt-1"> 
                    &nbsp;&nbsp;
                    <label class="control-label text-bold">CP</label>
                    &nbsp;&nbsp;
                    <a href="#" class="" title="Eliminar" onclick="Eliminar_Direccion_Temporal('<?php echo $dir['id_direccion_temporal']; ?>')" role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;" width="22" height="22"/></a>
                </div>
            </div>   
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Persona Cont: </label>
                <input type="text" readonly class="form-control" value="<?php  echo $dir['contacto_dir'];   ?>">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Celular:</label>
                <input type="text" readonly class="form-control"  value="<?php if($dir['celular_dir']!=0){ echo $dir['celular_dir']; } ?>">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tel Fijo:</label>
                <input type="text" readonly class="form-control"  value="<?php echo $dir['tel_fijo'];    ?>">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Correo:</label>
                <input type="text" readonly class="form-control" value="<?php echo $dir['correo_dir'] ?>">
            </div>
        </div>
    <?php $u=$u+1;}
    
    ?>
<script>
    $(document).ready(function() {
        Cambio_Convenio();
    });
</script>