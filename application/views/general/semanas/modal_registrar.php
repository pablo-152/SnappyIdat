<form id="formulario_semana" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Semana (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Año:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="anio" name="anio">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_anio as $list){ ?>
                        <option value="<?php echo $list->nom_anio; ?>" <?php if(date('Y')==$list->nom_anio){echo "selected";}?>><?php echo $list->nom_anio; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Semana:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="nom_semana" id="nom_semana" class="form-control">
                    <option value="0">Seleccione</option>
                    <?php 
                    $numeroSemanasEnAnio = 53;
                    $i = 1;
                    do{?> 
                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                    <?php  $i++;  }while($i <= $numeroSemanasEnAnio)?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">De:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fec_inicio" name="fec_inicio" placeholder="Nombre">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Hasta:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fec_fin" name="fec_fin" placeholder="Nombre">
            </div>
        </div>

    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Semana()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>