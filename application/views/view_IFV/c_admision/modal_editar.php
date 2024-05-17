<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Admisión</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Grupo:</label>
            </div>
            <div class="form-group col-md-4">
                <input id="grupo_e" name="grupo_e" type="text" class="form-control" value="<?php echo $get_id[0]['grupo'] ?>">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Especialidad:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="esp_grupo_e" name="esp_grupo_e">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_programa_interes as $list){ ?>
                        <option value="<?php echo $list['id_especialidad']; ?>" <?php if($get_id[0]['esp_grupo']==$list['id_especialidad']){echo('Selected');}?>><?php echo $list['nom_especialidad']; ?></option>   
                    <?php } ?> 
                </select>
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Modalidad:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="mod_grupo_e" id="mod_grupo_e">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_modalidad as $list){ ?>
                        <option value="<?php echo $list['id_confgen']; ?>" <?php if($get_id[0]['mod_grupo']==$list['id_confgen']){echo('Selected');}?>><?php echo $list['nom_confgen']; ?></option>   
                    <?php } ?>  
                </select>
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Turno:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="tur_grupo_e" id="tur_grupo_e">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_turno as $list){ ?>
                        <option value="<?php echo $list['id_confgen']; ?>" <?php if($get_id[0]['tur_grupo']==$list['id_confgen']){echo('Selected');}?>><?php echo $list['nom_confgen']; ?></option>   
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
                <input type="date" class="form-control" name="inicio_grupo_e" id="inicio_grupo_e" value="<?php echo $get_id[0]['inicio_grupo'] ?>">
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fin:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" name="fin_grupo_e" id="fin_grupo_e" value="<?php echo $get_id[0]['fin_grupo'] ?>">
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado_e" id="estado_e">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estados as $list){ ?>
                        <option value="<?php echo $list['id_confgen']; ?>" <?php if($get_id[0]['estado']==$list['id_confgen']){echo('Selected');}?>><?php echo $list['nom_confgen']; ?></option>   
                    <?php } ?> 
                </select>
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Observaciones:</label>
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <textarea class="form-control" name="obs_grupo_e" id="obs_grupo_e"><?php echo $get_id[0]['obs_grupo'] ?></textarea>
            </div>
        </div>         	                	        
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_grupo_e" name="id_grupo_e" value="<?php echo $get_id[0]['id_grupo']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_C_Admision()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    function Update_C_Admision(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });
        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>AppIFV/Update_C_Admision";

        if (Valida_Update_Estado()){      
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

    function Valida_Update_Estado() {
        if($('#grupo_e').val().trim() == '') {
            Swal(
                'Ups!',
                'Debes Ingresar un grupo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#esp_grupo_e').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debes seleccionar una Especialidad.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#mod_grupo_e').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar una Modalidad.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#tur_grupo_e').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debes seleccionar un Turno.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#inicio_grupo_e').val().trim() == '') {
            Swal(
                'Ups!',
                'Debes ingresar una Fecha Inicio.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fin_grupo_e').val().trim() == '') {
            Swal(
                'Ups!',
                'Debes ingresar una Fecha Fin.',
                'warning'
            ).then(function() { });
            return false;
        }

        var fechaInicio = new Date(document.getElementById('inicio_grupo_e').value);
        var fechaFin = new Date(document.getElementById('fin_grupo_e').value);
        if (fechaInicio > fechaFin) {
        Swal(
                'Ups!',
                'La Fecha Fin tiene que ser mayor a la Fecha inicio.',
                'error'
            ).then(function() { });
        }

        /*if($('#estado_e').val().trim() === '0') {
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
      var fechaInicio = new Date(document.getElementById('inicio_grupo_e').value);
      var fechaFin = new Date(document.getElementById('fin_grupo_e').value);

      // Comparar las fechas
      if (fechaInicio > fechaFin) {
        Swal(
                'Ups!',
                'La Fecha Fin tiene que ser mayor a la Fecha inicio.',
                'error'
            ).then(function() { });
      }
    }
</script>