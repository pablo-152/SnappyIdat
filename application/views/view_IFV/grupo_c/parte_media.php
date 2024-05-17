<?php if(count($get_id)>0){ ?>
    
    <div class="col-md-12 row" style="margin-top:25px;">
        <?php $i = 1;
        while ($i <= 20) { ?>
            <div class="form-group" style="width:4%;text-align:center;display:inline-block;">
                <label class="control-label text-bold">S<?php echo $i; ?></label>
                <input type="text" class="form-control solo_numeros" id="s<?php echo $i; ?>" name="s<?php echo $i; ?>" placeholder="S<?php echo $i; ?>" value="<?php echo $get_id[0]['s'.$i]; ?>">
            </div>
        <?php $i++;
        } ?>
        <div class="form-group" style="width:4%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">+1</label>
            <input type="text" class="form-control solo_numeros" id="mas1" name="mas1" placeholder="+1" value="<?php echo $get_id[0]['mas1']; ?>">
        </div>
    </div>

    <div class="col-md-12 row">
        <div class="form-group" style="width:10%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">Matriculados</label>
            <input type="text" class="form-control solo_numeros" id="c_matriculados_1" name="c_matriculados_1" placeholder="Matriculados" value="<?php echo $get_id[0]['c_matriculados_1']; ?>">
        </div>

        <div class="form-group" style="width:10%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">Proyección</label>
            <input type="text" class="form-control solo_numeros" id="c_proyeccion" name="c_proyeccion" placeholder="Proyección" value="<?php echo $get_id[0]['c_proyeccion']; ?>">
        </div>

        <div class="form-group" style="width:10%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">Postulados</label>
            <input type="text" class="form-control solo_numeros" id="c_postulados" name="c_postulados" placeholder="Postulados" value="<?php echo $get_id[0]['c_postulados']; ?>">
        </div>

        <div class="form-group" style="width:10%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">Rechazados</label>
            <input type="text" class="form-control solo_numeros" id="c_rechazados" name="c_rechazados" placeholder="Rechazados" value="<?php echo $get_id[0]['c_rechazados']; ?>">
        </div>

        <div class="form-group" style="width:10%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">Admitidos</label>
            <input type="text" class="form-control solo_numeros" id="c_admitidos" name="c_admitidos" placeholder="Admitidos" value="<?php echo $get_id[0]['c_admitidos']; ?>">
        </div>

        <div class="form-group" style="width:10%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">Matriculados</label>
            <input type="text" class="form-control solo_numeros" id="c_matriculados_2" name="c_matriculados_2" placeholder="Matriculados" value="<?php echo $get_id[0]['c_matriculados_2']; ?>">
        </div>
    </div>

<?php }else{ ?>

    <div class="col-md-12 row" style="margin-top:25px;">
        <?php $i = 1;
        while ($i <= 20) { ?>
            <div class="form-group" style="width:4%;text-align:center;display:inline-block;">
                <label class="control-label text-bold">S<?php echo $i; ?></label>
                <input type="text" class="form-control solo_numeros" id="s<?php echo $i; ?>" name="s<?php echo $i; ?>" placeholder="S<?php echo $i; ?>">
            </div>
        <?php $i++;
        } ?>
        <div class="form-group" style="width:4%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">+1</label>
            <input type="text" class="form-control solo_numeros" id="mas1" name="mas1" placeholder="+1">
        </div>
    </div>

    <div class="col-md-12 row">
        <div class="form-group" style="width:10%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">Matriculados</label>
            <input type="text" class="form-control solo_numeros" id="c_matriculados_1" name="c_matriculados_1" placeholder="Matriculados">
        </div>

        <div class="form-group" style="width:10%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">Proyección</label>
            <input type="text" class="form-control solo_numeros" id="c_proyeccion" name="c_proyeccion" placeholder="Proyección">
        </div>

        <div class="form-group" style="width:10%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">Postulados</label>
            <input type="text" class="form-control solo_numeros" id="c_postulados" name="c_postulados" placeholder="Postulados">
        </div>

        <div class="form-group" style="width:10%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">Rechazados</label>
            <input type="text" class="form-control solo_numeros" id="c_rechazados" name="c_rechazados" placeholder="Rechazados">
        </div>

        <div class="form-group" style="width:10%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">Admitidos</label>
            <input type="text" class="form-control solo_numeros" id="c_admitidos" name="c_admitidos" placeholder="Admitidos">
        </div>

        <div class="form-group" style="width:10%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">Matriculados</label>
            <input type="text" class="form-control solo_numeros" id="c_matriculados_2" name="c_matriculados_2" placeholder="Matriculados">
        </div>
    </div>

<?php } ?>