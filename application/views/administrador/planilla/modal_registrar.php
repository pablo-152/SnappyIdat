<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Planilla (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <?php if($get_id[0]['nom_contrato']=="Recibo Honorarios"){ ?>
            <div class="row">
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Horas Presencial: </label>
                </div>
                <div class="form-group col-lg-4">
                    <input type="text" class="form-control" id="horas_presencial" name="horas_presencial" placeholder="Horas Presencial" onkeypress="return solo_Numeros(event);">
                </div>

                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Horas Online: </label>
                </div>
                <div class="form-group col-lg-4">
                    <input type="text" class="form-control" id="horas_online" name="horas_online" placeholder="Horas Online" onkeypress="return solo_Numeros(event);">
                </div>
            </div>
        <?php } ?>

        <div class="row">
            <div class="form-group col-lg-12" style="display:flex;">
                <label class="control-label text-bold">Incentivos: </label>
                <a title="Registrar Incentivo" onclick="Insert_Temporal_Modal(1);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="16"></line>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Descripción: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="descripcion_1" id="descripcion_1" placeholder="Descripción">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Monto: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="monto_1" id="monto_1" placeholder="Monto" onkeypress="return solo_Numeros_Punto(event);">
            </div>
        </div>

        <div class="row" id="lista_1">
        </div>

        <div class="row">
            <div class="form-group col-lg-12" style="display:flex;">
                <label class="control-label text-bold">Deducciones: </label>
                <a title="Registrar Deducción" onclick="Insert_Temporal_Modal(2);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="16"></line>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Descripción: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="descripcion_2" id="descripcion_2" placeholder="Descripción">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Monto: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="monto_2" id="monto_2" placeholder="Monto" onkeypress="return solo_Numeros_Punto(event);">
            </div>
        </div>

        <div class="row" id="lista_2">
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Faltas: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="faltas" id="faltas" placeholder="Faltas" onkeypress="return solo_Numeros(event);">
            </div>
        </div>
    </div> 
    
    <div class="modal-footer">
        <input type="hidden" id="id_colaborador" name="id_colaborador" value="<?= $get_id[0]['id_colaborador']; ?>">
        <button type="button" class="btn btn-primary" onclick="Insert_Temporal();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Lista_Temporal_Modal(tipo){
        Cargando();

        var id_colaborador = $("#id_colaborador").val();
        var url="<?php echo site_url(); ?>Administrador/Lista_Temporal_Modal_Planilla";

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_colaborador':id_colaborador,'tipo':tipo},
            success:function (resp) {
                $('#lista_'+tipo).html(resp);
            }
        });
    }

    function Insert_Temporal_Modal(tipo){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>Administrador/Insert_Temporal_Modal_Planilla";

        dataString.append('tipo', tipo);

        if (Valida_Insert_Temporal_Modal(tipo)) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    Lista_Temporal_Modal(tipo);
                    $('#descripcion_'+tipo).val('');
                    $('#monto_'+tipo).val('');
                }
            });
        }
    }

    function Valida_Insert_Temporal_Modal(tipo) {
        if($('#monto_'+tipo).val() == '') {
            Swal(
                'Ups!',
                'Debe ingresar monto.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Delete_Temporal_Modal(id,tipo){
        Cargando();

        var url="<?php echo site_url(); ?>Administrador/Delete_Temporal_Modal_Planilla";
        
        $.ajax({
            type:"POST",
            url:url,
            data: {'id':id},
            success:function () {
                Lista_Temporal_Modal(tipo);
            }
        });
    }

    function Insert_Temporal(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>Administrador/Insert_Temporal_Planilla";

        $.ajax({
            url: url,
            data:dataString,
            type:"POST",
            processData: false,
            contentType: false,
            success:function (data) {
                Lista_Colaborador();  
                $("#acceso_modal_mod .close").click()
            }
        });
    }
</script>
