<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">

<form id="formulario_semanae" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Semana</b></h5> 
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Año:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="anioe" name="anioe">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_anio as $list){ ?>
                        <option value="<?php echo $list->nom_anio; ?>" <?php if($get_id[0]['anio']==$list->nom_anio){echo "selected";}?>><?php echo $list->nom_anio; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Semana:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="nom_semanae" id="nom_semanae" class="form-control">
                    <option value="0">Seleccione</option>
                    <?php 
                    $numeroSemanasEnAnio = 53;
                    $i = 1;
                    do{?> 
                    <option value="<?php echo $i ?>" <?php if($get_id[0]['nom_semana']==$i){echo "selected";}?>><?php echo $i ?></option>
                    <?php  $i++;  }while($i <= $numeroSemanasEnAnio)?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">De:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fec_inicioe" name="fec_inicioe" value="<?php echo $get_id[0]['fec_inicio'] ?>" placeholder="Nombre">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Hasta:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fec_fine" name="fec_fine" value="<?php echo $get_id[0]['fec_fin'] ?>" placeholder="Nombre">
            </div>
        </div>
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_semanas" name="id_semanas" value="<?php echo $get_id[0]['id_semanas']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Semana()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>