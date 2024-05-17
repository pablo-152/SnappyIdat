<form id="formulario_update_horario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Horario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>    
    
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Selecciona los días laborados: </label>
            </div>

            <div class="form-group col-md-12">
                <?php 
                    $lunes="style='display:none'";
                    $martes="style='display:none'";
                    $miercoles="style='display:none'";
                    $jueves="style='display:none'";
                    $viernes="style='display:none'";
                    $sabado="style='display:none'";
                    $domingo="style='display:none'"; 
                ?>
                <?php 
                    $busq_detalle = in_array('1', array_column($get_detalle, 'dia')); 
                    if($busq_detalle != false){ 
                        $lunes="style='display:block'"; 
                    }
                ?>
                <label style="margin-right:10px;">
                    <input type="checkbox" id="ch_lunes_u" name="ch_lunes_u" value="1" <?php if($busq_detalle!=false){ echo "checked"; } ?> onclick="Mostrar_Dia('1')">
                    Lunes
                </label>

                <?php 
                    $busq_detalle = in_array('2', array_column($get_detalle, 'dia')); 
                    if($busq_detalle != false){ 
                        $martes="style='display:block'"; 
                    }
                ?>
                <label style="margin-right:10px;">
                    <input type="checkbox" id="ch_martes_u" name="ch_martes_u" value="1" <?php if($busq_detalle!=false){ echo "checked"; } ?> onclick="Mostrar_Dia('2')">
                    Martes
                </label>

                <?php 
                    $busq_detalle = in_array('3', array_column($get_detalle, 'dia')); 
                    if($busq_detalle != false){ 
                        $miercoles="style='display:block'"; 
                    }
                ?>
                <label style="margin-right:10px;">
                    <input type="checkbox" id="ch_miercoles_u" name="ch_miercoles_u" value="1" <?php if($busq_detalle!=false){ echo "checked"; } ?> onclick="Mostrar_Dia('3')">
                    Miércoles
                </label>

                <?php 
                    $busq_detalle = in_array('4', array_column($get_detalle, 'dia')); 
                    if($busq_detalle != false){ 
                        $jueves="style='display:block'"; 
                    }
                ?>
                <label style="margin-right:10px;">
                    <input type="checkbox" id="ch_jueves_u" name="ch_jueves_u" value="1" <?php if($busq_detalle!=false){ echo "checked"; } ?> onclick="Mostrar_Dia('4')">
                    Jueves
                </label>

                <?php 
                    $busq_detalle = in_array('5', array_column($get_detalle, 'dia')); 
                    if($busq_detalle != false){ 
                        $viernes="style='display:block'"; 
                    }
                ?>
                <label style="margin-right:10px;">
                    <input type="checkbox" id="ch_viernes_u" name="ch_viernes_u" value="1" <?php if($busq_detalle!=false){ echo "checked"; } ?> onclick="Mostrar_Dia('5')">
                    Viernes
                </label>

                <?php 
                    $busq_detalle = in_array('6', array_column($get_detalle, 'dia')); 
                    if($busq_detalle != false){ 
                        $sabado="style='display:block'"; 
                    }
                ?>
                <label style="margin-right:10px;">
                    <input type="checkbox" id="ch_sabado_u" name="ch_sabado_u" value="1" <?php if($busq_detalle!=false){ echo "checked"; } ?> onclick="Mostrar_Dia('6')">
                    Sábado
                </label>

                <?php 
                    $busq_detalle = in_array('7', array_column($get_detalle, 'dia')); 
                    if($busq_detalle != false){ 
                        $domingo="style='display:block'"; 
                    }
                ?>
                <label style="margin-right:10px;">
                    <input type="checkbox" id="ch_domingo_u" name="ch_domingo_u" value="1" <?php if($busq_detalle!=false){ echo "checked"; } ?> onclick="Mostrar_Dia('7')">
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
                    <div class="form-group col-md-2" id="div_lunes1_u" <?php echo $lunes ?>>
                        <label class=" control-label text-bold">Lunes: </label>
                    </div>
                    <div class="form-group col-md-10 container" id="div_lunes2_u" <?php echo $lunes ?>>
                        <div id="nonLinearLunese"></div>
                        <div class="row mt-4 mb-4">
                        
                            <input type="hidden" name="hora_entrada_lu_u" id="hora_entrada_lu_u" >
                            <input type="hidden" name="hora_salida_lu_u" id="hora_salida_lu_u">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_martes1_u" <?php echo $martes ?>>
                        <label class=" control-label text-bold">Martes: </label>
                    </div>
                    <div class="form-group col-md-10 container" id="div_martes2_u" <?php echo $martes ?>>
                        <div id="nonLinearMartese"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_entrada_ma_u" id="hora_entrada_ma_u">
                            <input type="hidden" name="hora_salida_ma_u" id="hora_salida_ma_u">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_miercoles1_u" <?php echo $miercoles ?>>
                        <label class=" control-label text-bold">Miércoles: </label>
                    </div>
                    <div class="form-group col-md-10 container" id="div_miercoles2_u" <?php echo $miercoles ?>>
                        <div id="nonLinearMiercolese"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_entrada_mi_u" id="hora_entrada_mi_u">
                            <input type="hidden" name="hora_salida_mi_u" id="hora_salida_mi_u">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_jueves1_u" <?php echo $jueves ?>>
                        <label class=" control-label text-bold">Jueves: </label>
                    </div>
                    <div class="form-group col-md-10 container" id="div_jueves2_u" <?php echo $jueves ?>>
                        <div id="nonLinearJuevese"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_entrada_ju_u" id="hora_entrada_ju_u">
                            <input type="hidden" name="hora_salida_ju_u" id="hora_salida_ju_u">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_viernes1_u" <?php echo $viernes ?>>
                        <label class=" control-label text-bold">Viernes: </label>
                    </div>
                    <div class="form-group col-md-10 container" id="div_viernes2_u" <?php echo $viernes ?>>
                        <div id="nonLinearViernese"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_entrada_vi_u" id="hora_entrada_vi_u">
                            <input type="hidden" name="hora_salida_vi_u" id="hora_salida_vi_u">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_sabado1_u" <?php echo $sabado ?>>
                        <label class=" control-label text-bold">Sábado: </label>
                    </div>
                    <div class="form-group col-md-10 container" id="div_sabado2_u" <?php echo $sabado ?>>
                        <div id="nonLinearSabadoe"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_entrada_sa_u" id="hora_entrada_sa_u">
                            <input type="hidden" name="hora_salida_sa_u" id="hora_salida_sa_u">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_domingo1_u" <?php echo $domingo ?>>
                        <label class=" control-label text-bold">Domingo: </label>
                    </div>
                    <div class="form-group col-md-10 container" id="div_domingo2_u" <?php echo $domingo ?>>
                        <div id="nonLinearDomingoe"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_entrada_do_u" id="hora_entrada_do_u">
                            <input type="hidden" name="hora_salida_do_u" id="hora_salida_do_u">
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_lunes3_u" <?php echo $lunes ?>>
                        <label class=" control-label text-bold">Lunes: </label>
                    </div>
                    <div class="form-group col-md-2" id="div_lunes4_u" <?php echo $lunes ?>>
                        <?php 
                            $busq_detalle = in_array('1', array_column($get_detalle, 'dia')); 
                            $posicion = array_search('1', array_column($get_detalle, 'dia'));
                        ?>
                        <input type="checkbox" id="no_aplica_lu_u" name="no_aplica_lu_u" value="1" <?php if($busq_detalle!=false && $get_detalle[$posicion]['no_aplica']==1){ echo "checked"; } ?>>
                        <label class="control-label text-bold">No Aplica</label>
                    </div>
                    <div class="form-group col-md-8 container" id="div_lunes5_u" <?php echo $lunes ?>>
                        <div id="nonLinearLunes_descansoe"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_descanso_e_lu_u" id="hora_descanso_e_lu_u">
                            <input type="hidden" name="hora_descanso_s_lu_u" id="hora_descanso_s_lu_u">
                        </div>
                    </div>
                </div>
                    
                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_martes3_u" <?php echo $martes ?>>
                        <label class=" control-label text-bold">Martes: </label>
                    </div>
                    <div class="form-group col-md-2" id="div_martes4_u" <?php echo $martes ?>>
                        <?php 
                            $busq_detalle = in_array('2', array_column($get_detalle, 'dia')); 
                            $posicion = array_search('2', array_column($get_detalle, 'dia'));
                        ?>
                        <input type="checkbox" id="no_aplica_ma_u" name="no_aplica_ma_u" value="1" <?php if($busq_detalle!=false && $get_detalle[$posicion]['no_aplica']==1){ echo "checked"; } ?>>
                        <label class="control-label text-bold">No Aplica</label>
                    </div>
                    <div class="form-group col-md-8 container" id="div_martes5_u" <?php echo $martes ?>>
                        <div id="nonLinearMartes_descansoe"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_descanso_e_ma_u" id="hora_descanso_e_ma_u">
                            <input type="hidden" name="hora_descanso_s_ma_u" id="hora_descanso_s_ma_u">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_miercoles3_u" <?php echo $miercoles ?>>
                        <label class=" control-label text-bold">Miercoles: </label>
                    </div>
                    <div class="form-group col-md-2" id="div_miercoles4_u" <?php echo $miercoles ?>>
                        <?php 
                            $busq_detalle = in_array('3', array_column($get_detalle, 'dia')); 
                            $posicion = array_search('3', array_column($get_detalle, 'dia'));
                        ?>
                        <input type="checkbox" id="no_aplica_mi_u" name="no_aplica_mi_u" value="1" <?php if($busq_detalle!=false && $get_detalle[$posicion]['no_aplica']==1){ echo "checked"; } ?>>
                        <label class="control-label text-bold">No Aplica</label>
                    </div>
                    <div class="form-group col-md-8 container" id="div_miercoles5_u" <?php echo $miercoles ?>>
                        <div id="nonLinearMiercoles_descansoe"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_descanso_e_mi_u" id="hora_descanso_e_mi_u">
                            <input type="hidden" name="hora_descanso_s_mi_u" id="hora_descanso_s_mi_u">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_jueves3_u" <?php echo $jueves ?>>
                        <label class=" control-label text-bold">Jueves: </label>
                    </div>
                    <div class="form-group col-md-2" id="div_jueves4_u" <?php echo $jueves ?>>
                        <?php 
                            $busq_detalle = in_array('4', array_column($get_detalle, 'dia')); 
                            $posicion = array_search('4', array_column($get_detalle, 'dia'));
                        ?>
                        <input type="checkbox" id="no_aplica_ju_u" name="no_aplica_ju_u" value="1" <?php if($busq_detalle!=false && $get_detalle[$posicion]['no_aplica']==1){ echo "checked"; } ?>>
                        <label class="control-label text-bold">No Aplica</label>
                    </div>
                    <div class="form-group col-md-8 container" id="div_jueves5_u" <?php echo $jueves ?>>
                        <div id="nonLinearJueves_descansoe"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_descanso_e_ju_u" id="hora_descanso_e_ju_u">
                            <input type="hidden" name="hora_descanso_s_ju_u" id="hora_descanso_s_ju_u">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_viernes3_u" <?php echo $viernes ?>>
                        <label class=" control-label text-bold">Viernes: </label>
                    </div>
                    <div class="form-group col-md-2" id="div_viernes4_u" <?php echo $viernes ?>>
                        <?php 
                            $busq_detalle = in_array('5', array_column($get_detalle, 'dia')); 
                            $posicion = array_search('5', array_column($get_detalle, 'dia'));
                        ?>
                        <input type="checkbox" id="no_aplica_vi_u" name="no_aplica_vi_u" value="1" <?php if($busq_detalle!=false && $get_detalle[$posicion]['no_aplica']==1){ echo "checked"; } ?>>
                        <label class="control-label text-bold">No Aplica</label>
                    </div>
                    <div class="form-group col-md-8 container" id="div_viernes5_u" <?php echo $viernes ?>>
                        <div id="nonLinearViernes_descansoe"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_descanso_e_vi_u" id="hora_descanso_e_vi_u">
                            <input type="hidden" name="hora_descanso_s_vi_u" id="hora_descanso_s_vi_u">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_sabado3_u" <?php echo $sabado ?>>
                        <label class=" control-label text-bold">Sábado: </label>
                    </div>
                    <div class="form-group col-md-2" id="div_sabado4_u" <?php echo $sabado ?>>
                        <?php 
                            $busq_detalle = in_array('6', array_column($get_detalle, 'dia')); 
                            $posicion = array_search('6', array_column($get_detalle, 'dia'));
                        ?>
                        <input type="checkbox" id="no_aplica_sa_u" name="no_aplica_sa_u" value="1" <?php if($busq_detalle!=false && $get_detalle[$posicion]['no_aplica']==1){ echo "checked"; } ?>>
                        <label class="control-label text-bold">No Aplica</label>
                    </div>
                    <div class="form-group col-md-8 container" id="div_sabado5_u" <?php echo $sabado ?>>
                        <div id="nonLinearSabado_descansoe"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_descanso_e_sa_u" id="hora_descanso_e_sa_u">
                            <input type="hidden" name="hora_descanso_s_sa_u" id="hora_descanso_s_sa_u">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row" style="margin-top:40px;">
                    <div class="form-group col-md-2" id="div_domingo3_u" <?php echo $domingo ?>>
                        <label class=" control-label text-bold">Domingo: </label>
                    </div>
                    <div class="form-group col-md-2" id="div_domingo4_u" <?php echo $domingo ?>>
                        <?php 
                            $busq_detalle = in_array('7', array_column($get_detalle, 'dia')); 
                            $posicion = array_search('7', array_column($get_detalle, 'dia'));
                        ?>
                        <input type="checkbox" id="no_aplica_do_u" name="no_aplica_do_u" value="1" <?php if($busq_detalle!=false && $get_detalle[$posicion]['no_aplica']==1){ echo "checked"; } ?>>
                        <label class="control-label text-bold">No Aplica</label>
                    </div>
                    <div class="form-group col-md-8 container" id="div_domingo5_u" <?php echo $domingo ?>>
                        <div id="nonLinearDomingo_descansoe"></div>
                        <div class="row mt-4 mb-4">
                            <input type="hidden" name="hora_descanso_e_do_u" id="hora_descanso_e_do_u"> 
                            <input type="hidden" name="hora_descanso_s_do_u" id="hora_descanso_s_do_u">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="horario_tipo" name="horario_tipo" value="u">
        <input type="hidden" id="id_colaborador" name="id_colaborador" value="<?php echo $id_colaborador; ?>">
        <button class="btn btn-primary mt-3" type="button" onclick="Update_Horario();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Mostrar_Dia(dia){
        var div_lunes1 = document.getElementById("div_lunes1_u");
        var div_lunes2 = document.getElementById("div_lunes2_u");
        var div_lunes3 = document.getElementById("div_lunes3_u");
        var div_lunes4 = document.getElementById("div_lunes4_u");
        var div_lunes5 = document.getElementById("div_lunes5_u");
        var div_martes1 = document.getElementById("div_martes1_u");
        var div_martes2 = document.getElementById("div_martes2_u");
        var div_martes3 = document.getElementById("div_martes3_u");
        var div_martes4 = document.getElementById("div_martes4_u");
        var div_martes5 = document.getElementById("div_martes5_u");
        var div_miercoles1 = document.getElementById("div_miercoles1_u");
        var div_miercoles2 = document.getElementById("div_miercoles2_u");
        var div_miercoles3 = document.getElementById("div_miercoles3_u");
        var div_miercoles4 = document.getElementById("div_miercoles4_u");
        var div_miercoles5 = document.getElementById("div_miercoles5_u");
        var div_jueves1 = document.getElementById("div_jueves1_u");
        var div_jueves2 = document.getElementById("div_jueves2_u");
        var div_jueves3 = document.getElementById("div_jueves3_u");
        var div_jueves4 = document.getElementById("div_jueves4_u");
        var div_jueves5 = document.getElementById("div_jueves5_u");
        var div_viernes1 = document.getElementById("div_viernes1_u");
        var div_viernes2 = document.getElementById("div_viernes2_u");
        var div_viernes3 = document.getElementById("div_viernes3_u");
        var div_viernes4 = document.getElementById("div_viernes4_u");
        var div_viernes5 = document.getElementById("div_viernes5_u");
        var div_sabado1 = document.getElementById("div_sabado1_u");
        var div_sabado2 = document.getElementById("div_sabado2_u");
        var div_sabado3 = document.getElementById("div_sabado3_u");
        var div_sabado4 = document.getElementById("div_sabado4_u");
        var div_sabado5 = document.getElementById("div_sabado5_u");
        var div_domingo1 = document.getElementById("div_domingo1_u");
        var div_domingo2 = document.getElementById("div_domingo2_u");
        var div_domingo3 = document.getElementById("div_domingo3_u");
        var div_domingo4 = document.getElementById("div_domingo4_u");
        var div_domingo5 = document.getElementById("div_domingo5_u");
        if(dia==1){
            if ($('#ch_lunes_u').is(":checked")){
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
            if ($('#ch_martes_u').is(":checked")){
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
            if ($('#ch_miercoles_u').is(":checked")){
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
            if ($('#ch_jueves_u').is(":checked")){
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
            if ($('#ch_viernes_u').is(":checked")){
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
            if ($('#ch_sabado_u').is(":checked")){
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
            if ($('#ch_domingo_u').is(":checked")){
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
    <?php 
        $busq_detalle = in_array('1', array_column($get_detalle, 'dia'));
        $posicion = array_search('1', array_column($get_detalle, 'dia'));
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['entrada']; }else{ echo "8"; } ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['salida']; }else{ echo "18"; } ?>';
        
    var nonLinearLunese = document.getElementById('nonLinearLunese');
    noUiSlider.create(nonLinearLunese, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
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

    nonLinearLunese.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_lu_u').val(values[0]);
        $('#hora_salida_lu_u').val(values[1]);
    });

    //martes
    <?php 
        $busq_detalle = in_array('2', array_column($get_detalle, 'dia'));
        $posicion = array_search('2', array_column($get_detalle, 'dia'));
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['entrada']; }else{ echo "8"; } ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['salida']; }else{ echo "18"; } ?>';

    var nonLinearMartese = document.getElementById('nonLinearMartese');
    noUiSlider.create(nonLinearMartese, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
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

    nonLinearMartese.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_ma_u').val(values[0]);
        $('#hora_salida_ma_u').val(values[1]);
    });

    //miercoles
    <?php 
        $busq_detalle = in_array('3', array_column($get_detalle, 'dia'));
        $posicion = array_search('3', array_column($get_detalle, 'dia'));
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['entrada']; }else{ echo "8"; } ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['salida']; }else{ echo "18"; } ?>';

    var nonLinearMiercolese = document.getElementById('nonLinearMiercolese');
    noUiSlider.create(nonLinearMiercolese, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
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

    nonLinearMiercolese.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_mi_u').val(values[0]);
        $('#hora_salida_mi_u').val(values[1]);
    });

    //jueves
    <?php 
        $busq_detalle = in_array('4', array_column($get_detalle, 'dia'));
        $posicion = array_search('4', array_column($get_detalle, 'dia'));
        ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['entrada']; }else{ echo "8"; } ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['salida']; }else{ echo "18"; } ?>';

    var nonLinearJuevese = document.getElementById('nonLinearJuevese');
    noUiSlider.create(nonLinearJuevese, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
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

    nonLinearJuevese.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_ju_u').val(values[0]);
        $('#hora_salida_ju_u').val(values[1]);
    });

    //viernes
    <?php 
        $busq_detalle = in_array('5', array_column($get_detalle, 'dia'));
        $posicion = array_search('5', array_column($get_detalle, 'dia'));
        ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['entrada']; }else{ echo "8"; } ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['salida']; }else{ echo "18"; } ?>';

    var nonLinearViernese = document.getElementById('nonLinearViernese');
    noUiSlider.create(nonLinearViernese, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
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

    nonLinearViernese.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_vi_u').val(values[0]);
        $('#hora_salida_vi_u').val(values[1]);
    });

    //sabado
    <?php 
        $busq_detalle = in_array('6', array_column($get_detalle, 'dia'));
        $posicion = array_search('6', array_column($get_detalle, 'dia'));
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['entrada']; }else{ echo "8"; } ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['salida']; }else{ echo "18"; } ?>';

    var nonLinearSabadoe = document.getElementById('nonLinearSabadoe');
    noUiSlider.create(nonLinearSabadoe, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
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

    nonLinearSabadoe.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_sa_u').val(values[0]);
        $('#hora_salida_sa_u').val(values[1]);
    });

    //domingo
    <?php 
        $busq_detalle = in_array('7', array_column($get_detalle, 'dia'));
        $posicion = array_search('7', array_column($get_detalle, 'dia'));
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['entrada']; }else{ echo "8"; } ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['salida']; }else{ echo "18"; } ?>';

    var nonLinearDomingoe = document.getElementById('nonLinearDomingoe');
    noUiSlider.create(nonLinearDomingoe, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
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

    nonLinearDomingoe.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_entrada_do_u').val(values[0]);
        $('#hora_salida_do_u').val(values[1]);
    });

    //descanso
    //lunes
    <?php 
        $busq_detalle = in_array('1', array_column($get_detalle, 'dia'));
        $posicion = array_search('1', array_column($get_detalle, 'dia'));
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['descanso_e']; }else{ echo "13"; } ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['descanso_s']; }else{ echo "14"; } ?>';

    var nonLinearLunes_descansoe = document.getElementById('nonLinearLunes_descansoe');
    noUiSlider.create(nonLinearLunes_descansoe, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
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

    nonLinearLunes_descansoe.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_descanso_e_lu_u').val(values[0]);
        $('#hora_descanso_s_lu_u').val(values[1]);
    });

    //martes
    <?php 
        $busq_detalle = in_array('2', array_column($get_detalle, 'dia'));
        $posicion = array_search('2', array_column($get_detalle, 'dia'));
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['descanso_e']; }else{ echo "13"; } ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['descanso_s']; }else{ echo "14"; } ?>';

    var nonLinearMartes_descansoe = document.getElementById('nonLinearMartes_descansoe');
    noUiSlider.create(nonLinearMartes_descansoe, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
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

    nonLinearMartes_descansoe.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_descanso_e_ma_u').val(values[0]);
        $('#hora_descanso_s_ma_u').val(values[1]);
    });

    //miercoles
    <?php 
        $busq_detalle = in_array('3', array_column($get_detalle, 'dia'));
        $posicion = array_search('3', array_column($get_detalle, 'dia'));
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['descanso_e']; }else{ echo "13"; } ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['descanso_s']; }else{ echo "14"; } ?>';

    var nonLinearMiercoles_descansoe = document.getElementById('nonLinearMiercoles_descansoe');
    noUiSlider.create(nonLinearMiercoles_descansoe, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
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

    nonLinearMiercoles_descansoe.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_descanso_e_mi_u').val(values[0]);
        $('#hora_descanso_s_mi_u').val(values[1]);
    });

    //jueves
    <?php 
        $busq_detalle = in_array('4', array_column($get_detalle, 'dia'));
        $posicion = array_search('4', array_column($get_detalle, 'dia'));
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['descanso_e']; }else{ echo "13"; } ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['descanso_s']; }else{ echo "14"; } ?>';

    var nonLinearJueves_descansoe = document.getElementById('nonLinearJueves_descansoe');
    noUiSlider.create(nonLinearJueves_descansoe, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
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

    nonLinearJueves_descansoe.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_descanso_e_ju_u').val(values[0]);
        $('#hora_descanso_s_ju_u').val(values[1]);
    });

    //viernes
    <?php 
        $busq_detalle = in_array('5', array_column($get_detalle, 'dia'));
        $posicion = array_search('5', array_column($get_detalle, 'dia'));
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['descanso_e']; }else{ echo "13"; } ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['descanso_s']; }else{ echo "14"; } ?>';

    var nonLinearViernes_descansoe = document.getElementById('nonLinearViernes_descansoe');
    noUiSlider.create(nonLinearViernes_descansoe, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
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

    nonLinearViernes_descansoe.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_descanso_e_vi_u').val(values[0]);
        $('#hora_descanso_s_vi_u').val(values[1]);
    });

    //sabado
    <?php 
        $busq_detalle = in_array('6', array_column($get_detalle, 'dia'));
        $posicion = array_search('6', array_column($get_detalle, 'dia'));
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['descanso_e']; }else{ echo "13"; } ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['descanso_s']; }else{ echo "14"; } ?>';

    var nonLinearSabado_descansoe = document.getElementById('nonLinearSabado_descansoe');
    noUiSlider.create(nonLinearSabado_descansoe, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
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

    nonLinearSabado_descansoe.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_descanso_e_sa_u').val(values[0]);
        $('#hora_descanso_s_sa_u').val(values[1]);
    });
    
    //domingo
    <?php 
        $busq_detalle = in_array('7', array_column($get_detalle, 'dia'));
        $posicion = array_search('7', array_column($get_detalle, 'dia'));
    ?>
    var desde='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['descanso_e']; }else{ echo "13"; } ?>';
    var hasta='<?php if ($busq_detalle != false){ echo $get_detalle[$posicion]['descanso_s']; }else{ echo "14"; } ?>';

    var nonLinearDomingo_descansoe = document.getElementById('nonLinearDomingo_descansoe');
    noUiSlider.create(nonLinearDomingo_descansoe, {
        connect: true,
        behaviour: 'tap',
        tooltips: true,
        start: [ desde, hasta ],
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

    nonLinearDomingo_descansoe.noUiSlider.on('update', function ( values, handle, unencoded, isTap, positions ) {
        $('#hora_descanso_e_do_u').val(values[0]);
        $('#hora_descanso_s_do_u').val(values[1]);
    });

    function Update_Horario() {
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

        var dataString = new FormData(document.getElementById('formulario_update_horario'));
        var url = "<?php echo site_url(); ?>Administrador/Insert_Horario_Colaborador";

        if (Valida_Update_Horario()) {
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

    function Valida_Update_Horario() {
        if(!$('#ch_lunes_u').is(":checked") && !$('#ch_martes_u').is(":checked") && 
        !$('#ch_miercoles_u').is(":checked") && !$('#ch_jueves_u').is(":checked") && 
        !$('#ch_viernes_u').is(":checked") && !$('#ch_sabado_u').is(":checked") && 
        !$('#ch_domingo_u').is(":checked")){
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
