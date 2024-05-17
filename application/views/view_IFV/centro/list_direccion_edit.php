<input type="hidden" id="direccion_bd" name="direccion_bd" value="<?php echo $i; ?>">
<?php foreach($list_direccion as $dir){?> 
                <div class="form-group col-md-4">
                    <label class="control-label text-bold">Dirección:</label>
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
                        <img title="Editar Datos Postulante" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_DireccionCentro') ?>/<?php echo $dir["id_centro_direccion"]; ?>"  src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;"  width="20" height="20" />
                        <a href="#" class="" title="Eliminar" onclick="Eliminar_Direccion('<?php echo $dir['id_centro_direccion']; ?>')" role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;" width="22" height="22"/></a>
                    </div>
                </div> 
                
            <?php }?>

            <script>
    $(document).ready(function() {
        Cambio_Convenio();
    });
</script>