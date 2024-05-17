<form id="formulario_invitar" method="POST" enctype="multipart/form-data"  class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Invitar a: </b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-3">
                <label class="control-label text-bold">Grupo: </label>
                <div class="">
                    <select name="grupo" id="grupo" class="form-control" onchange="Busca_Especialidad_Invitar()">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_grupo as $list){?> 
                            <option value="<?php echo $list['Grupo'] ?>"><?php echo $list['Grupo'] ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            
            <div class="form-group col-md-5">
                <label class="control-label text-bold">Especialidad: </label>
                <div class="" id="cmb_especialidad">
                    <select name="especialidad" id="especialidad" class="form-control">
                        <option value="0">Seleccione</option>
                    </select>
                </div>
            </div>
            

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Módulo: </label>
                <div class="" id="cmb_modulo">
                    <select name="modulo" id="modulo" class="form-control">
                        <option value="0">Seleccione</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Ciclo: </label>
                <div class="" id="cmb_ciclo">
                    <select name="ciclo" id="ciclo" class="form-control">
                        <option value="0">Seleccione</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Turno: </label>
                <div class="" id="cmb_turno">
                    <select name="turno" id="turno" class="form-control">
                        <option value="0">Seleccione</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Sección: </label>
                <div class="" id="cmb_seccion">
                    <select name="seccion" id="seccion" class="form-control">
                        <option value="0">Seleccione</option>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Inicio de Examen: </label>
                <div class="" id="cmb_seccion">
                    <input type="time" name="hora_inicio" id="hora_inicio" class="form-control">
                </div>
            </div>
            
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Alumno: <input type="checkbox" name="todos" id="todos" value="1" onclick="Todos_Invitar()">&nbsp;Todos</label>
                <div class="" id="cmb_alumno">
                    <select name="alumno[]" id="alumno" class="form-control select" multiple="multiple">
                    </select>
                </div>
            </div>
            
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Invitar_Efsrt();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $('.select').select2({
        minimumResultsForSearch: Infinity
    });
    
    function Busca_Especialidad_Invitar(){
        Cargar_Bloqueo();
        var dataString = new FormData(document.getElementById('formulario_invitar'));
        var url="<?php echo site_url(); ?>AppIFV/Busca_Especialidad_Invitar";  
        $.ajax({
            type:"POST",
            url:url,
            data: dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#cmb_especialidad').html(data);
                Busca_Modulo_Invitar();
            }
        });  
    }

    function Busca_Modulo_Invitar(){
        Cargar_Bloqueo();
        var dataString = new FormData(document.getElementById('formulario_invitar'));
        var url="<?php echo site_url(); ?>AppIFV/Busca_Modulo_Invitar";  
        $.ajax({
            type:"POST",
            url:url,
            data: dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#cmb_modulo').html(data);
                Busca_Ciclo_Invitar();
            }
        });  
    }
    function Busca_Ciclo_Invitar(){
        Cargar_Bloqueo();
        var dataString = new FormData(document.getElementById('formulario_invitar'));
        var url="<?php echo site_url(); ?>AppIFV/Busca_Ciclo_Invitar";  
        $.ajax({
            type:"POST",
            url:url,
            data: dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#cmb_ciclo').html(data);
                Busca_Turno_Invitar();
            }
        });  
    }
    function Busca_Turno_Invitar(){
        Cargar_Bloqueo();
        var dataString = new FormData(document.getElementById('formulario_invitar'));
        var url="<?php echo site_url(); ?>AppIFV/Busca_Turno_Invitar";  
        $.ajax({
            type:"POST",
            url:url,
            data: dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#cmb_turno').html(data);
                Busca_Seccion_Invitar();
            }
        });  
    }
    function Busca_Seccion_Invitar(){
        Cargar_Bloqueo();
        var dataString = new FormData(document.getElementById('formulario_invitar'));
        var url="<?php echo site_url(); ?>AppIFV/Busca_Seccion_Invitar";  
        $.ajax({
            type:"POST",
            url:url,
            data: dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#cmb_seccion').html(data);
                Busca_Alumno_Invitar();
            }
        });  
    }

    function Busca_Alumno_Invitar(){
        Cargar_Bloqueo();
        var dataString = new FormData(document.getElementById('formulario_invitar'));
        var url="<?php echo site_url(); ?>AppIFV/Busca_Alumno_Invitar";  
        $.ajax({
            type:"POST",
            url:url,
            data: dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#cmb_alumno').html(data);
            }
        });  
    }
    function Todos_Invitar(){
        Busca_Alumno_Invitar();
    }

    
    function Insert_Invitar_Efsrt(){
        Cargar_Bloqueo();

        var dataString = new FormData(document.getElementById('formulario_invitar'));
        var url="<?php echo site_url(); ?>AppIFV/Invitar_Postulantes_Efsrt"; 

        if (Valida_Update_Postulante_Efsrt()) {
            $.ajax({
                type:"POST",
                url:url,
                data: dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    var cadena = data;
                    validacion = cadena.substr(0, 1);
                    mensaje = cadena.substr(1);
                    if (validacion == 1) {
                        swal.fire(
                            'Invitación Denegada',
                            mensaje,
                            'error'
                        ).then(function() {
                        });
                    }else if(validacion==2){
                        swal.fire(
                            'Invitación parcial!',
                            mensaje,
                            'warning'
                        ).then(function() {
                            $("#acceso_modal .close").click()
                            Lista_Postulantes_Efsrt(1);
                        });
                    }else if(validacion==3){
                        swal.fire(
                            'Invitación exitosa!',
                            mensaje,
                            'success'
                        ).then(function() {
                            $("#acceso_modal .close").click()
                            Lista_Postulantes_Efsrt(1);
                        });
                    }
                }
            });     
        }
    }

    function Valida_Update_Postulante_Efsrt() {
        if($('#grupo').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar grupo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#especialidad').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar especialidad.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#modulo').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar módulo.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#ciclo').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar ciclo.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#turno').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar turno.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#seccion').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar sección.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#hora_inicio').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar hora de inicio de examen.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#alumno').val() == '' || $('#alumno').val() == null) {
            Swal(
                'Ups!',
                'Debe seleccionar al menos un alumno.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>