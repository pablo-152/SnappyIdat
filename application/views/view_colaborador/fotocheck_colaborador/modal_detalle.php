<form id="formulario_anular" method="POST" enctype="multipart/form-data"   class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title" id="exampleModalLabel" style="text-align: right;margin-right: 35px;">
            <b style="background-color: <?php echo $get_id[0]['color_esta_fotocheck']; ?>;color: white;font-size: 17px;font-weight: normal;padding: 5px 30px 5px 30px;">
                <?php echo $get_id[0]['esta_fotocheck']; ?>
            </b>
        </h5>
    </div>

    <div class="modal-body" >
        <div class="col-md-12 row">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <label class="text-bold" style="font-weight: 850;">FOTOS</label>
                </div>
                <div class="col-md-12 col-sm-12">
                    <label class="text-bold">• D00 - Foto Sistema: </label>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="text-left">  Fecha: <span style="font-weight: normal;"><?php echo $get_id[0]['fecha_recepcion']; ?></span></label>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="text-left">  Usuario: <span style="font-weight: normal;"> <?php echo $get_id[0]['usuario_foto']; ?></span> </label>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="text-left"> Doc: <span style="font-weight: normal;"> <?php echo $get_id[0]['nom_foto_fotocheck']; ?></span> </label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <label class="text-bold">• D01 - Foto Fotocheck: </label>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="text-bold">Fecha: <span style="font-weight: normal;"><?php echo $get_id[0]['fecha_recepcion_2']; ?></span></label>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="text-bold">Usuario: <span style="font-weight: normal;"><?php echo $get_id[0]['usuario_foto_2']; ?></span> </label>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="text-bold">Doc: <span style="font-weight: normal;"><?php echo $get_id[0]['nom_foto_fotocheck_2']; ?></span> </label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <label class="text-bold">• D01 - Foto (con Fecha): </label>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="text-bold">Fecha: <span style="font-weight: normal;"><?php echo $get_id[0]['fecha_recepcion_3']; ?></span></label>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="text-bold">Usuario: <span style="font-weight: normal;"><?php echo $get_id[0]['usuario_foto_3']; ?></span> </label>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="text-bold">Doc: <span style="font-weight: normal;"><?php echo $get_id[0]['nom_foto_fotocheck_3']; ?></span> </label>
                </div>
                <div class="col-md-12 col-sm-12">
                    <label class="text-bold">&nbsp;</label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <label class="text-bold" style="font-weight: 850;">ENVÍO: </label>
                </div>

                <div class="col-md-4 col-sm-12">
                    <label class="text-bold">Fecha: <span style="font-weight: normal;"><?php echo $get_id[0]['fecha_envio']; ?></span></label>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="text-bold">Usuario: <span style="font-weight: normal;"><?php echo $get_id[0]['usuario_encomienda']; ?></span> </label>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="text-bold">Cargo: <span style="font-weight: normal;"><?php echo $get_id[0]['cargo_envio']; ?></span> </label>
                </div>
                <div class="col-md-12 col-sm-12">
                    <label class="text-bold">&nbsp; </label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <label class="text-bold" style="font-weight: 850;">ANULACIÓN: </label>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="text-bold">Fecha: <span style="font-weight: normal;"><?php echo $get_id[0]['fecha_anulado']; ?></span> </label>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="text-bold">Usuario: <span style="font-weight: normal;"><?php echo $get_id[0]['usuario_anulado']; ?></span> </label>
                </div>
                <div class="col-md-12 col-sm-12">
                    <label class="text-bold">Observaciones: </label>
                </div>
                <div class="col-md-12 col-sm-12">
                    <input type="text" class="form-control" id="obs_anulado" name="obs_anulado" value="<?php echo $get_id[0]['obs_anulado']; ?>" disabled>
                </div>
                <div class="col-md-12 col-sm-12">
                    <label class="text-bold">&nbsp;</label>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Cancelar</button>
    </div>
</form>
