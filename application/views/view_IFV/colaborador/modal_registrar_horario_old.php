<form id="formulario_insert_horario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Horario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>    
    
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Selecciona los días laborados: </label>
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Ref&nbsp;Contrato: </label>
            </div>
            <div class="form-group col-md-4">
                <select name="id_contrato_i" id="id_contrato_i" class="form-control">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_contrato as $list){?>
                    <option value="<?php echo $list['id_contrato'] ?>"><?php echo $list['referencia'] ?></option>    
                    <?php }?>
                </select>
            </div>

            <div class="form-group col-md-12">
                <label style="margin-right:10px;">
                    <input type="checkbox" id="ch_lunes_i" name="ch_lunes_i" value="1" checked onclick="Mostrar_Dia('1')">
                    Lunes
                </label>
                <label style="margin-right:10px;">
                    <input type="checkbox" id="ch_martes_i" name="ch_martes_i" value="1" checked onclick="Mostrar_Dia('2')">
                    Martes
                </label>
                <label style="margin-right:10px;">
                    <input type="checkbox" id="ch_miercoles_i" name="ch_miercoles_i" value="1" checked onclick="Mostrar_Dia('3')">
                    Miércoles
                </label>
                <label style="margin-right:10px;">
                    <input type="checkbox" id="ch_jueves_i" name="ch_jueves_i" value="1" checked onclick="Mostrar_Dia('4')">
                    Jueves
                </label>
                <label style="margin-right:10px;">
                    <input type="checkbox" id="ch_viernes_i" name="ch_viernes_i" value="1" checked onclick="Mostrar_Dia('5')">
                    Viernes
                </label>
                <label style="margin-right:10px;">
                    <input type="checkbox" id="ch_sabado_i" name="ch_sabado_i" value="1" onclick="Mostrar_Dia('6')">
                    Sábado
                </label>
                <label style="margin-right:10px;">
                    <input type="checkbox" id="ch_domingo_i" name="ch_domingo_i" value="1" onclick="Mostrar_Dia('7')">
                    Domingo
                </label>
            </div>
        </div>

        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
            <li class="nav-item active">
                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Conf. Básica</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Conf. Descanso</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade active in" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_lunes1_i">
                        <label class=" control-label text-bold">Lunes: </label>
                    </div>
                    <div class="form-group col-md-10 container" id="div_lunes2_i">
                        <div id="nonLinearLunes"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_entrada_lu_i" id="hora_entrada_lu_i">
                            <input type="hidden" name="hora_salida_lu_i" id="hora_salida_lu_i">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_martes1_i">
                        <label class=" control-label text-bold">Martes: </label>
                    </div>
                    <div class="form-group col-md-10 container" id="div_martes2_i">
                        <div id="nonLinearMartes"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_entrada_ma_i" id="hora_entrada_ma_i">
                            <input type="hidden" name="hora_salida_ma_i" id="hora_salida_ma_i">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_miercoles1_i">
                        <label class=" control-label text-bold">Miercoles: </label>
                    </div>
                    <div class="form-group col-md-10 container" id="div_miercoles2_i">
                        <div id="nonLinearMiercoles"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_entrada_mi_i" id="hora_entrada_mi_i">
                            <input type="hidden" name="hora_salida_mi_i" id="hora_salida_mi_i">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_jueves1_i">
                        <label class=" control-label text-bold">Jueves: </label>
                    </div>
                    <div class="form-group col-md-10 container" id="div_jueves2_i">
                        <div id="nonLinearJueves"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_entrada_ju_i" id="hora_entrada_ju_i">
                            <input type="hidden" name="hora_salida_ju_i" id="hora_salida_ju_i">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_viernes1_i">
                        <label class=" control-label text-bold">Viernes: </label>
                    </div>
                    <div class="form-group col-md-10 container" id="div_viernes2_i">
                        <div id="nonLinearViernes"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_entrada_vi_i" id="hora_entrada_vi_i">
                            <input type="hidden" name="hora_salida_vi_i" id="hora_salida_vi_i">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_sabado1_i" style="display:none">
                        <label class=" control-label text-bold">Sábado: </label>
                    </div>
                    <div class="form-group col-md-10 container" id="div_sabado2_i" style="display:none">
                        <div id="nonLinearSabado"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_entrada_sa_i" id="hora_entrada_sa_i">
                            <input type="hidden" name="hora_salida_sa_i" id="hora_salida_sa_i">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_domingo1_i" style="display:none">
                        <label class=" control-label text-bold">Domingo: </label>
                    </div>
                    <div class="form-group col-md-10 container" id="div_domingo2_i" style="display:none">
                        <div id="nonLinearDomingo"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_entrada_do_i" id="hora_entrada_do_i">
                            <input type="hidden" name="hora_salida_do_i" id="hora_salida_do_i">
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_lunes3_i">
                        <label class=" control-label text-bold">Lunes: </label>
                    </div>
                    <div class="form-group col-md-2" id="div_lunes4_i">
                        <input type="checkbox" id="no_aplica_lu_i" name="no_aplica_lu_i" value="1">
                        <label class="control-label text-bold">No Aplica</label>
                    </div>
                    <div class="form-group col-md-8 container" id="div_lunes5_i">
                        <div id="nonLinearLunes_descanso"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_descanso_e_lu_i" id="hora_descanso_e_lu_i">
                            <input type="hidden" name="hora_descanso_s_lu_i" id="hora_descanso_s_lu_i">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_martes3_i">
                        <label class=" control-label text-bold">Martes: </label>
                    </div>
                    <div class="form-group col-md-2" id="div_martes4_i">
                        <input type="checkbox" id="no_aplica_ma_i" name="no_aplica_ma_i" value="1">
                        <label class="control-label text-bold">No Aplica</label>
                    </div>
                    <div class="form-group col-md-8 container" id="div_martes5_i">
                        <div id="nonLinearMartes_descanso"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_descanso_e_ma_i" id="hora_descanso_e_ma_i">
                            <input type="hidden" name="hora_descanso_s_ma_i" id="hora_descanso_s_ma_i">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_miercoles3_i">
                        <label class=" control-label text-bold">Miercoles: </label>
                    </div>
                    <div class="form-group col-md-2" id="div_miercoles4_i">
                        <input type="checkbox" id="no_aplica_mi_i" name="no_aplica_mi_i" value="1">
                        <label class="control-label text-bold">No Aplica</label>
                    </div>
                    <div class="form-group col-md-8 container" id="div_miercoles5_i">
                        <div id="nonLinearMiercoles_descanso"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_descanso_e_mi_i" id="hora_descanso_e_mi_i">
                            <input type="hidden" name="hora_descanso_s_mi_i" id="hora_descanso_s_mi_i">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_jueves3_i">
                        <label class=" control-label text-bold">Jueves: </label>
                    </div>
                    <div class="form-group col-md-2" id="div_jueves4_i">
                        <input type="checkbox" id="no_aplica_ju_i" name="no_aplica_ju_i" value="1">
                        <label class="control-label text-bold">No Aplica</label>
                    </div>
                    <div class="form-group col-md-8 container" id="div_jueves5_i">
                        <div id="nonLinearJueves_descanso"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_descanso_e_ju_i" id="hora_descanso_e_ju_i">
                            <input type="hidden" name="hora_descanso_s_ju_i" id="hora_descanso_s_ju_i">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_viernes3_i">
                        <label class=" control-label text-bold">Viernes: </label>
                    </div>
                    <div class="form-group col-md-2" id="div_viernes4_i">
                        <input type="checkbox" id="no_aplica_vi_i" name="no_aplica_vi_i" value="1">
                        <label class="control-label text-bold">No Aplica</label>
                    </div>
                    <div class="form-group col-md-8 container" id="div_viernes5_i">
                        <div id="nonLinearViernes_descanso"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_descanso_e_vi_i" id="hora_descanso_e_vi_i">
                            <input type="hidden" name="hora_descanso_s_vi_i" id="hora_descanso_s_vi_i">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_sabado3_i" style="display:none">
                        <label class=" control-label text-bold">Sábado: </label>
                    </div>
                    <div class="form-group col-md-2" id="div_sabado4_i" style="display:none">
                        <input type="checkbox" id="no_aplica_sa_i" name="no_aplica_sa_i" value="1">
                        <label class="control-label text-bold">No Aplica</label>
                    </div>
                    <div class="form-group col-md-8 container" id="div_sabado5_i" style="display:none">
                        <div id="nonLinearSabado_descanso"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_descanso_e_sa_i" id="hora_descanso_e_sa_i">
                            <input type="hidden" name="hora_descanso_s_sa_i" id="hora_descanso_s_sa_i">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_domingo3_i" style="display:none">
                        <label class=" control-label text-bold">Domingo: </label>
                    </div>
                    <div class="form-group col-md-2" id="div_domingo4_i" style="display:none">
                        <input type="checkbox" id="no_aplica_do_i" name="no_aplica_do_i" value="1">
                        <label class="control-label text-bold">No Aplica</label>
                    </div>
                    <div class="form-group col-md-8 container" id="div_domingo5_i" style="display:none">
                        <div id="nonLinearDomingo_descanso"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_descanso_e_do_i" id="hora_descanso_e_do_i">
                            <input type="hidden" name="hora_descanso_s_do_i" id="hora_descanso_s_do_i">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="horario_tipo" name="horario_tipo" value="i">
        <input type="hidden" id="id_colaborador" name="id_colaborador" value="<?php echo $id_colaborador; ?>">
        <button class="btn btn-primary mt-3" type="button" onclick="Insert_Horario();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Mostrar_Dia(dia){
        var div_lunes1 = document.getElementById("div_lunes1_i");
        var div_lunes2 = document.getElementById("div_lunes2_i");
        var div_lunes3 = document.getElementById("div_lunes3_i");
        var div_lunes4 = document.getElementById("div_lunes4_i");
        var div_lunes5 = document.getElementById("div_lunes5_i");
        var div_martes1 = document.getElementById("div_martes1_i");
        var div_martes2 = document.getElementById("div_martes2_i");
        var div_martes3 = document.getElementById("div_martes3_i");
        var div_martes4 = document.getElementById("div_martes4_i");
        var div_martes5 = document.getElementById("div_martes5_i");
        var div_miercoles1 = document.getElementById("div_miercoles1_i");
        var div_miercoles2 = document.getElementById("div_miercoles2_i");
        var div_miercoles3 = document.getElementById("div_miercoles3_i");
        var div_miercoles4 = document.getElementById("div_miercoles4_i");
        var div_miercoles5 = document.getElementById("div_miercoles5_i");
        var div_jueves1 = document.getElementById("div_jueves1_i");
        var div_jueves2 = document.getElementById("div_jueves2_i");
        var div_jueves3 = document.getElementById("div_jueves3_i");
        var div_jueves4 = document.getElementById("div_jueves4_i");
        var div_jueves5 = document.getElementById("div_jueves5_i");
        var div_viernes1 = document.getElementById("div_viernes1_i");
        var div_viernes2 = document.getElementById("div_viernes2_i");
        var div_viernes3 = document.getElementById("div_viernes3_i");
        var div_viernes4 = document.getElementById("div_viernes4_i");
        var div_viernes5 = document.getElementById("div_viernes5_i");
        var div_sabado1 = document.getElementById("div_sabado1_i");
        var div_sabado2 = document.getElementById("div_sabado2_i");
        var div_sabado3 = document.getElementById("div_sabado3_i");
        var div_sabado4 = document.getElementById("div_sabado4_i");
        var div_sabado5 = document.getElementById("div_sabado5_i");
        var div_domingo1 = document.getElementById("div_domingo1_i");
        var div_domingo2 = document.getElementById("div_domingo2_i");
        var div_domingo3 = document.getElementById("div_domingo3_i");
        var div_domingo4 = document.getElementById("div_domingo4_i");
        var div_domingo5 = document.getElementById("div_domingo5_i");
        if(dia==1){
            if ($('#ch_lunes_i').is(":checked")){
                div_lunes1.style.display = "block";
                div_lunes2.style.display = "block";
                div_lunes3.style.display = "block";
                div_lunes4.style.display = "block";
                div_lunes5.style.display = "block";
            }else{
                div_lunes1.style.display = "none";
                div_lunes2.style.display = "none";
                div_lunes3.style.display = "none";
                div_lunes4.style.display = "none";
                div_lunes5.style.display = "none";
            }
        }
        if(dia==2){ 
            if ($('#ch_martes_i').is(":checked")){
                div_martes1.style.display = "block";
                div_martes2.style.display = "block";
                div_martes3.style.display = "block";
                div_martes4.style.display = "block";
                div_martes5.style.display = "block";
            }else{
                div_martes1.style.display = "none";
                div_martes2.style.display = "none";
                div_martes3.style.display = "none";
                div_martes4.style.display = "none";
                div_martes5.style.display = "none";
            }
        }
        if(dia==3){
            if ($('#ch_miercoles_i').is(":checked")){
                div_miercoles1.style.display = "block";
                div_miercoles2.style.display = "block";
                div_miercoles3.style.display = "block";
                div_miercoles4.style.display = "block";
                div_miercoles5.style.display = "block";
            }else{
                div_miercoles1.style.display = "none";
                div_miercoles2.style.display = "none";
                div_miercoles3.style.display = "none";
                div_miercoles4.style.display = "none";
                div_miercoles5.style.display = "none";
            }
        }
        if(dia==4){
            if ($('#ch_jueves_i').is(":checked")){
                div_jueves1.style.display = "block";
                div_jueves2.style.display = "block";
                div_jueves3.style.display = "block";
                div_jueves4.style.display = "block";
                div_jueves5.style.display = "block";
            }else{
                div_jueves1.style.display = "none";
                div_jueves2.style.display = "none";
                div_jueves3.style.display = "none";
                div_jueves4.style.display = "none";
                div_jueves5.style.display = "none";
            }
        }
        if(dia==5){
            if ($('#ch_viernes_i').is(":checked")){
                div_viernes1.style.display = "block";
                div_viernes2.style.display = "block";
                div_viernes3.style.display = "block";
                div_viernes4.style.display = "block";
                div_viernes5.style.display = "block";
            }else{
                div_viernes1.style.display = "none";
                div_viernes2.style.display = "none";
                div_viernes3.style.display = "none";
                div_viernes4.style.display = "none";
                div_viernes5.style.display = "none";
            }
        }
        if(dia==6){
            if ($('#ch_sabado_i').is(":checked")){
                div_sabado1.style.display = "block";
                div_sabado2.style.display = "block";
                div_sabado3.style.display = "block";
                div_sabado4.style.display = "block";
                div_sabado5.style.display = "block";
            }else{
                div_sabado1.style.display = "none";
                div_sabado2.style.display = "none";
                div_sabado3.style.display = "none";
                div_sabado4.style.display = "none";
                div_sabado5.style.display = "none";
            }
        }
        if(dia==7){
            if ($('#ch_domingo_i').is(":checked")){
                div_domingo1.style.display = "block";
                div_domingo2.style.display = "block";
                div_domingo3.style.display = "block";
                div_domingo4.style.display = "block";
                div_domingo5.style.display = "block";
            }else{
                div_domingo1.style.display = "none";
                div_domingo2.style.display = "none";
                div_domingo3.style.display = "none";
                div_domingo4.style.display = "none";
                div_domingo5.style.display = "none";
            }
        }
    }

    //lunes
    var nonLinearLunes = document.getElementById('nonLinearLunes');
    noUiSlider.create(nonLinearLunes, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ 8, 18 ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 22 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' +  minutes.toString().padStart(2, '0');
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearLunes.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_lu_i').val(values[0]);
        $('#hora_salida_lu_i').val(values[1]);
    });

    //martes
    var nonLinearMartes = document.getElementById('nonLinearMartes');
    noUiSlider.create(nonLinearMartes, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ 8, 18 ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 22 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearMartes.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_ma_i').val(values[0]);
        $('#hora_salida_ma_i').val(values[1]);
    });

    //miercoles
    var nonLinearMiercoles = document.getElementById('nonLinearMiercoles');
    noUiSlider.create(nonLinearMiercoles, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ 8, 18 ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 22 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearMiercoles.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_mi_i').val(values[0]);
        $('#hora_salida_mi_i').val(values[1]);
    });

    //jueves
    var nonLinearJueves = document.getElementById('nonLinearJueves');
    noUiSlider.create(nonLinearJueves, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ 8, 18 ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 22 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearJueves.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_ju_i').val(values[0]);
        $('#hora_salida_ju_i').val(values[1]);
    });

    //viernes
    var nonLinearViernes = document.getElementById('nonLinearViernes');
    noUiSlider.create(nonLinearViernes, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ 8, 18 ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 22 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearViernes.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_vi_i').val(values[0]);
        $('#hora_salida_vi_i').val(values[1]);
    });

    //sabado
    var nonLinearSabado = document.getElementById('nonLinearSabado');
    noUiSlider.create(nonLinearSabado, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ 8, 18 ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 22 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearSabado.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_sa_i').val(values[0]);
        $('#hora_salida_sa_i').val(values[1]);
    });

    //domingo
    var nonLinearDomingo = document.getElementById('nonLinearDomingo');
    noUiSlider.create(nonLinearDomingo, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ 8, 18 ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 22 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearDomingo.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_do_i').val(values[0]);
        $('#hora_salida_do_i').val(values[1]);
    });

    //descanso
    //lunes
    var nonLinearLunes_descanso = document.getElementById('nonLinearLunes_descanso');
    noUiSlider.create(nonLinearLunes_descanso, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ 13, 14 ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 22 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' +  minutes.toString().padStart(2, '0');
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearLunes_descanso.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_descanso_e_lu_i').val(values[0]);
        $('#hora_descanso_s_lu_i').val(values[1]);
    });

    //martes
    var nonLinearMartes_descanso = document.getElementById('nonLinearMartes_descanso');
    noUiSlider.create(nonLinearMartes_descanso, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ 13, 14 ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 22 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearMartes_descanso.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_descanso_e_ma_i').val(values[0]);
        $('#hora_descanso_s_ma_i').val(values[1]);
    });

    //miercoles
    var nonLinearMiercoles_descanso = document.getElementById('nonLinearMiercoles_descanso');
    noUiSlider.create(nonLinearMiercoles_descanso, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ 13, 14 ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 22 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearMiercoles_descanso.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_descanso_e_mi_i').val(values[0]);
        $('#hora_descanso_s_mi_i').val(values[1]);
    });

    //jueves
    var nonLinearJueves_descanso = document.getElementById('nonLinearJueves_descanso');
    noUiSlider.create(nonLinearJueves_descanso, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ 13, 14 ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 22 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearJueves_descanso.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_descanso_e_ju_i').val(values[0]);
        $('#hora_descanso_s_ju_i').val(values[1]);
    });

    //viernes
    var nonLinearViernes_descanso = document.getElementById('nonLinearViernes_descanso');
    noUiSlider.create(nonLinearViernes_descanso, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ 13, 14 ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 22 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearViernes_descanso.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_descanso_e_vi_i').val(values[0]);
        $('#hora_descanso_s_vi_i').val(values[1]);
    });

    //sabado
    var nonLinearSabado_descanso = document.getElementById('nonLinearSabado_descanso');
    noUiSlider.create(nonLinearSabado_descanso, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ 13, 14 ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 22 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearSabado_descanso.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_descanso_e_sa_i').val(values[0]);
        $('#hora_descanso_s_sa_i').val(values[1]);
    });

    //domingo
    var nonLinearDomingo_descanso = document.getElementById('nonLinearDomingo_descanso');
    noUiSlider.create(nonLinearDomingo_descanso, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ 13, 14 ],
        step: 300,
        range: {
            'min': 7 * 60 * 60,
            'max': 22 * 60 * 60
        },
        format: {
            to: function (value) {
                var hours = Math.floor(value / 3600);
                var minutes = Math.floor((value - (hours * 3600)) / 60);
                var seconds = value - (hours * 3600) - (minutes * 60);
                return hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0')
            },
            from: function (value) {
                var parts = value.split(':');
                var hours = parseInt(parts[0], 10) || 0;
                var minutes = parseInt(parts[1], 10) || 0;
                return (hours * 3600) + (minutes * 60);
            }
        }
    });

    nonLinearDomingo_descanso.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) { 
        $('#hora_descanso_e_do_i').val(values[0]);
        $('#hora_descanso_s_do_i').val(values[1]);
    });

    function Insert_Horario() {
        $(document)
        .ajaxStart(function() {
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
        .ajaxStop(function() {
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

        var dataString = new FormData(document.getElementById('formulario_insert_horario'));
        var url = "<?php echo site_url(); ?>AppIFV/Insert_Horario_Colaborador/1";

        if (Valida_Insert_Horario()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    Lista_Horario();  
                    $("#acceso_modal .close").click()
                }
            });
        }
    }

    function Valida_Insert_Horario() {
        if($('#id_contrato_i').val()=="0"){
            Swal(
                'Ups!',
                'Debe seleccionar Contrato.',
                'warning'
            ).then(function() { });
            return false;  
        }
        if(!$('#ch_lunes_i').is(":checked") && !$('#ch_martes_i').is(":checked") && 
        !$('#ch_miercoles_i').is(":checked") && !$('#ch_jueves_i').is(":checked") && 
        !$('#ch_viernes_i').is(":checked") && !$('#ch_sabado_i').is(":checked") && 
        !$('#ch_domingo_i').is(":checked")){
            Swal(
                'Ups!',
                'Debe seleccionar al menos un día de la semana.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
