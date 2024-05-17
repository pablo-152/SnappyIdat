<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Nueva Admisión</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Grupo:</label>
            </div>
            <div class="form-group col-md-4">
                <input id="grupo_i" name="grupo_i" type="text" class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Especialidad:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="esp_grupo_i" name="esp_grupo_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_programa_interes as $list){ ?>
                        <option value="<?php echo $list['id_especialidad']; ?>"><?php echo $list['nom_especialidad']; ?></option>   
                    <?php } ?> 
                </select>
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Modalidad:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="mod_grupo_i" id="mod_grupo_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_modalidad as $list){ ?>
                        <option value="<?php echo $list['id_confgen']; ?>"><?php echo $list['nom_confgen']; ?></option>   
                    <?php } ?>  
                </select>
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Turno:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="tur_grupo_i" id="tur_grupo_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_turno as $list){ ?>
                        <option value="<?php echo $list['id_confgen']; ?>"><?php echo $list['nom_confgen']; ?></option>   
                    <?php } ?> 
                </select>
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Registro Web</label>
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Inicio:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" name="inicio_grupo_i" id="inicio_grupo_i">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fin:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" name="fin_grupo_i" id="fin_grupo_i">
            </div>
        </div>
        <!--<div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado_i" id="estado_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estados as $list){ ?>
                        <option value="<?php echo $list['id_maestro_detalle']; ?>"><?php echo $list['nom_maestro_detalle']; ?></option>   
                    <?php } ?> 
                </select>
            </div>
        </div> -->
        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Observaciones:</label>
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <textarea class="form-control" name="obs_grupo_i" id="obs_grupo_i"></textarea>
            </div>
        </div>         	                	        
    </div> 
    
    <div class="modal-footer">
        <!--<input type="hidden" id="grupo_i" name="grupo_i" value="<?php echo $grupo; ?>">-->
        
        <button type="button" class="btn btn-primary" onclick="Insert_C_Admision()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_C_Admision(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>AppIFV/Insert_C_Admision";

        if (Valida_Insert_Estado()){   
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=='error'){
                        Swal(
                            'Ups!',
                            'Ya existe un grupo con esas características.',
                            'warning'
                        ).then(function() { });
                    }else{
                        window.location = "<?php echo site_url(); ?>AppIFV/C_Admision";
                    }
                }
            });
        }
    }

    function Valida_Insert_Estado() {
        if($('#grupo_i').val().trim() == '') {
            Swal(
                'Ups!',
                'Debes Ingresar un grupo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#esp_grupo_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debes seleccionar una Especialidad.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#mod_grupo_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar una Modalidad.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#tur_grupo_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debes seleccionar un Turno.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#inicio_grupo_i').val().trim() == '') {
            Swal(
                'Ups!',
                'Debes ingresar una Fecha Inicio.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fin_grupo_i').val().trim() == '') {
            Swal(
                'Ups!',
                'Debes ingresar una Fecha Fin.',
                'warning'
            ).then(function() { });
            return false;
        }

        var fechaInicio = new Date(document.getElementById('inicio_grupo_i').value);
        var fechaFin = new Date(document.getElementById('fin_grupo_i').value);
        if (fechaInicio > fechaFin) {
        Swal(
                'Ups!',
                'La Fecha Fin tiene que ser mayor a la Fecha inicio.',
                'error'
            ).then(function() { });
            return false;
        }

        /*if($('#estado_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un Estado.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        return true;
    }

    function validarFechas() {
      // Obtener los valores de las fechas
      var fechaInicio = new Date(document.getElementById('inicio_grupo_i').value);
      var fechaFin = new Date(document.getElementById('fin_grupo_i').value);

      // Comparar las fechas
      if (fechaInicio > fechaFin) {
        Swal(
                'Ups!',
                'La Fecha Fin tiene que ser mayor a la Fecha inicio.',
                'error'
            ).then(function() { });
        fechaFin = 'dd/mm/aaaa';
      }
    }
</script>
