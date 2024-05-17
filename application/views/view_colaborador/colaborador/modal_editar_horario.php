<form id="formulario_update_horario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Actualizar Horario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>    
    
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-1" >
                <label class="control-label text-bold">De:</label>
            </div>
            <div class="form-group col-md-3">
                <input type="date" id="desde_horarioe" name="desde_horarioe" value="<?php echo $get_id[0]['de'] ?>" class="form-control">
            </div>
            <div class="form-group col-md-1">
                <label class="control-label text-bold">A:</label>
            </div>
            <div class="form-group col-md-3">
                <input type="date" id="hasta_horarioe" name="hasta_horarioe" value="<?php echo $get_id[0]['a'] ?>" class="form-control">
            </div>
            <div class="form-group col-md-1">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-md-3">
                <select name="estado_registro_horarioe" id="estado_registro_horarioe" class="form-control">
                    <option value="0">Seleccione</option>
                    <option value="1" <?php if($get_id[0]['estado_registro']==1){echo "selected";}?>>Activo</option>
                    <option value="2" <?php if($get_id[0]['estado_registro']==2){echo "selected";}?>>Inactivo</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-1">
                <label class="control-label text-bold" title="Días de Semana">Días:</label>
            </div>
            <div class="form-group col-md-11">
                <label for="ch_lune"><input type="checkbox" name="ch_lune" id="ch_lune" value="1" <?php if($get_id[0]['ch_lun']==1){echo "checked";}?> onclick="Habilitar_Diae('lune')"> Lunes </label>
                <label for="ch_mare"><input type="checkbox" name="ch_mare" id="ch_mare" value="1" <?php if($get_id[0]['ch_mar']==1){echo "checked";}?> onclick="Habilitar_Diae('mare')"> Martes </label>
                <label for="ch_miere"><input type="checkbox" name="ch_miere" id="ch_miere" value="1" <?php if($get_id[0]['ch_mier']==1){echo "checked";}?> onclick="Habilitar_Diae('miere')"> Miércoles </label>
                <label for="ch_juee"><input type="checkbox" name="ch_juee" id="ch_juee" value="1" <?php if($get_id[0]['ch_jue']==1){echo "checked";}?> onclick="Habilitar_Diae('juee')"> Jueves </label>
                <label for="ch_viee"><input type="checkbox" name="ch_viee" id="ch_viee" value="1" <?php if($get_id[0]['ch_vie']==1){echo "checked";}?> onclick="Habilitar_Diae('viee')"> Viernes </label>
                <label for="ch_sabe"><input type="checkbox" name="ch_sabe" id="ch_sabe" value="1" <?php if($get_id[0]['ch_sab']==1){echo "checked";}?> onclick="Habilitar_Diae('sabe')"> Sábado </label>
                <label for="ch_dome"><input type="checkbox" name="ch_dome" id="ch_dome" value="1" <?php if($get_id[0]['ch_dom']==1){echo "checked";}?> onclick="Habilitar_Diae('dome')"> Domingo</label>
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="tabbable">
                <?php $ul=1;?>
                <ul class="nav nav-tabs nav-tabs-highlight nav-justified">
                    <li id="li_lune" class="<?php if($get_id[0]['ch_lun']==1){if($ul>0){echo "active";$ul=$ul-1;}}else{echo "oculto";}?>" ><a  href="#tab-lune" data-toggle="tab">Lunes</a></li>
                    <li id="li_mare" class="<?php if($get_id[0]['ch_mar']==1){if($ul>0){echo "active";$ul=$ul-1;}}else{echo "oculto";}?>"><a href="#tab-mare" data-toggle="tab">Martes</a></li>
                    <li id="li_miere" class="<?php if($get_id[0]['ch_mier']==1){if($ul>0){echo "active";$ul=$ul-1;}}else{echo "oculto";}?>"><a href="#tab-miere" data-toggle="tab">Miércoles</a></li>
                    <li id="li_juee" class="<?php if($get_id[0]['ch_jue']==1){if($ul>0){echo "active";$ul=$ul-1;}}else{echo "oculto";}?>"><a href="#tab-juee" data-toggle="tab">Jueves</a></li>
                    <li id="li_viee" class="<?php if($get_id[0]['ch_vie']==1){if($ul>0){echo "active";$ul=$ul-1;}}else{echo "oculto";}?>"><a href="#tab-viee" data-toggle="tab">Viernes</a></li>
                    <li id="li_sabe" class="<?php if($get_id[0]['ch_sab']==1){if($ul>0){echo "active";$ul=$ul-1;}}else{echo "oculto";}?>"><a href="#tab-sabe" data-toggle="tab">Sábado</a></li>
                    <li id="li_dome" class="<?php if($get_id[0]['ch_dom']==1){if($ul>0){echo "active";$ul=$ul-1;}}else{echo "oculto";}?>"><a href="#tab-dome" data-toggle="tab">Domingo</a></li>
                </ul>

                <div class="tab-content">
                    <?php $tab=1;?>
                    <div class="tab-pane <?php if($get_id[0]['ch_lun']==1){if($tab>0){echo "active";$tab=$tab-1;} }?>" id="tab-lune">
                        <div id="div_lune" style="display:<?php if($get_id[0]['ch_lun']==0){echo "none";}else{echo "block";}?>">
                            <?php $busqueda = in_array(1, array_column($get_dia, 'dia'));
                                  $posicion = array_search(1, array_column($get_dia, 'dia')); 
                                  $id_horario_detalle="";
                                  $disabled_m="disabled";
                                  $checked_m="";
                                  $ingreso_m="";
                                  $salida_m="";

                                  $disabled_alm="disabled";
                                  $checked_alm="";
                                  $ingreso_alm="";
                                  $salida_alm="";

                                  $disabled_t="disabled";
                                  $checked_t="";
                                  $ingreso_t="";
                                  $salida_t="";
                                  
                                  $disabled_c="disabled";
                                  $checked_c="";
                                  $ingreso_c="";
                                  $salida_c="";

                                  $disabled_n="disabled";
                                  $checked_n="";
                                  $ingreso_n="";
                                  $salida_n="";
                                  if($busqueda!= false){
                                    $id_horario_detalle=$get_dia[$posicion]['id_horario_detalle'];
                                    if($get_dia[$posicion]['ch_m']==1){
                                        $checked_m="checked";
                                        $disabled_m="";
                                        $ingreso_m=$get_dia[$posicion]['ingreso_m'];
                                        $salida_m=$get_dia[$posicion]['salida_m'];
                                    }
                                    if($get_dia[$posicion]['ch_alm']==1){
                                        $checked_alm="checked";
                                        $disabled_alm="";
                                        $ingreso_alm=$get_dia[$posicion]['ingreso_alm'];
                                        $salida_alm=$get_dia[$posicion]['salida_alm'];
                                    }
                                    if($get_dia[$posicion]['ch_t']==1){
                                        $checked_t="checked";
                                        $disabled_t="";
                                        $ingreso_t=$get_dia[$posicion]['ingreso_t'];
                                        $salida_t=$get_dia[$posicion]['salida_t'];
                                    }
                                    if($get_dia[$posicion]['ch_c']==1){
                                        $checked_c="checked";
                                        $disabled_c="";
                                        $ingreso_c=$get_dia[$posicion]['ingreso_c'];
                                        $salida_c=$get_dia[$posicion]['salida_c'];
                                    }
                                    if($get_dia[$posicion]['ch_n']==1){
                                        $checked_n="checked";
                                        $disabled_n="";
                                        $ingreso_n=$get_dia[$posicion]['ingreso_n'];
                                        $salida_n=$get_dia[$posicion]['salida_n'];
                                    }
                                  }
                            ?>
                            <input type="hidden" name="id_horario_detalle_lun" id="id_horario_detalle_lun" value="<?php echo $id_horario_detalle ?>">
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_m_lune"><input type="checkbox" name="ch_m_lune" id="ch_m_lune" value="1" onclick="Habilitar_Rangoe('m_lune')" <?php echo $checked_m ?>> Mañana </label>                
                                </div>
                                <div class="form-group col-md-1" >
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_m_lune" id="ingreso_m_lune"  class="form-control" value="<?php echo $ingreso_m ?>" <?php echo $disabled_m; ?>>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_m_lune" id="salida_m_lune" class="form-control" value="<?php echo $salida_m ?>" <?php echo $disabled_m; ?>>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_alm_lune"><input type="checkbox" name="ch_alm_lune" id="ch_alm_lune" value="1" onclick="Habilitar_Rangoe('alm_lune')" <?php echo $checked_alm ?>> Almuerzo </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_alm_lune" id="ingreso_alm_lune" class="form-control" value="<?php echo $ingreso_alm ?>" <?php echo $disabled_alm ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_alm_lune" id="salida_alm_lune" class="form-control" value="<?php echo $salida_alm ?>" <?php echo $disabled_alm ?>>
                                </div>
                                
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_t_lune"><input type="checkbox"  name="ch_t_lune" id="ch_t_lune" value="1" onclick="Habilitar_Rangoe('t_lune')" <?php echo $checked_t ?>> Tarde </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_t_lune" id="ingreso_t_lune" class="form-control" value="<?php echo $ingreso_t ?>" <?php echo $disabled_t ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_t_lune" id="salida_t_lune" class="form-control" value="<?php echo $salida_t ?>" <?php echo $disabled_t ?>>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_c_lune"><input type="checkbox" name="ch_c_lune" id="ch_c_lune" value="1" onclick="Habilitar_Rangoe('c_lune')" <?php echo $checked_c ?>> Cena </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div> 
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_c_lune" id="ingreso_c_lune" class="form-control" value="<?php echo $ingreso_c ?>" <?php echo $disabled_c ?>>
                                </div>
                                        
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_c_lune" id="salida_c_lune" class="form-control" value="<?php echo $salida_c ?>" <?php echo $disabled_c ?>>
                                </div> 
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_n_lune"><input type="checkbox" name="ch_n_lune" id="ch_n_lune" value="1" onclick="Habilitar_Rangoe('n_lune')" <?php echo $checked_n ?>> Noche </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_n_lune" id="ingreso_n_lune" class="form-control" value="<?php echo $ingreso_n ?>" <?php echo $disabled_n ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_n_lune" id="salida_n_lune" class="form-control" value="<?php echo $ingreso_n ?>" <?php echo $disabled_n ?>>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane <?php if($get_id[0]['ch_mar']==1){if($tab>0){echo "active";$tab=$tab-1;}}?>" id="tab-mare">
                        <?php $busqueda = in_array(2, array_column($get_dia, 'dia'));
                            $posicion = array_search(2, array_column($get_dia, 'dia')); 
                            $disabled_m="disabled";
                            $id_horario_detalle="";
                            $checked_m="";
                            $ingreso_m="";
                            $salida_m="";

                            $disabled_alm="disabled";
                            $checked_alm="";
                            $ingreso_alm="";
                            $salida_alm="";

                            $disabled_t="disabled";
                            $checked_t="";
                            $ingreso_t="";
                            $salida_t="";
                            
                            $disabled_c="disabled";
                            $checked_c="";
                            $ingreso_c="";
                            $salida_c="";

                            $disabled_n="disabled";
                            $checked_n="";
                            $ingreso_n="";
                            $salida_n="";
                            if($busqueda!= false){
                            $id_horario_detalle=$get_dia[$posicion]['id_horario_detalle'];
                            if($get_dia[$posicion]['ch_m']==1){
                                $checked_m="checked";
                                $disabled_m="";
                                $ingreso_m=$get_dia[$posicion]['ingreso_m'];
                                $salida_m=$get_dia[$posicion]['salida_m'];
                            }
                            if($get_dia[$posicion]['ch_alm']==1){
                                $checked_alm="checked";
                                $disabled_alm="";
                                $ingreso_alm=$get_dia[$posicion]['ingreso_alm'];
                                $salida_alm=$get_dia[$posicion]['salida_alm'];
                            }
                            if($get_dia[$posicion]['ch_t']==1){
                                $checked_t="checked";
                                $disabled_t="";
                                $ingreso_t=$get_dia[$posicion]['ingreso_t'];
                                $salida_t=$get_dia[$posicion]['salida_t'];
                            }
                            if($get_dia[$posicion]['ch_c']==1){
                                $checked_c="checked";
                                $disabled_c="";
                                $ingreso_c=$get_dia[$posicion]['ingreso_c'];
                                $salida_c=$get_dia[$posicion]['salida_c'];
                            }
                            if($get_dia[$posicion]['ch_n']==1){
                                $checked_n="checked";
                                $disabled_n="";
                                $ingreso_n=$get_dia[$posicion]['ingreso_n'];
                                $salida_n=$get_dia[$posicion]['salida_n'];
                            }
                            }
                        ?>
                        <div id="div_mare" style="display:<?php if($get_id[0]['ch_mar']==0){echo "none";}else{echo "block";}?>">
                            <input type="hidden" name="id_horario_detalle_mar" id="id_horario_detalle_mar" value="<?php echo $id_horario_detalle ?>">
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_m_mare"><input type="checkbox" name="ch_m_mare" id="ch_m_mare" value="1" onclick="Habilitar_Rangoe('m_mare')" <?php echo $checked_m ?>> Mañana </label>                
                                </div>
                                <div class="form-group col-md-1" >
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_m_mare" id="ingreso_m_mare" class="form-control" value="<?php echo $ingreso_m ?>" <?php echo $disabled_m; ?>>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_m_mare" id="salida_m_mare" class="form-control" value="<?php echo $salida_m ?>" <?php echo $disabled_m; ?>>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_alm_mare"><input type="checkbox" name="ch_alm_mare" id="ch_alm_mare" value="1" onclick="Habilitar_Rangoe('alm_mare')" <?php echo $checked_alm ?>> Almuerzo </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_alm_mare" id="ingreso_alm_mare" class="form-control" value="<?php echo $ingreso_alm ?>" <?php echo $disabled_alm; ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_alm_mare" id="salida_alm_mare" class="form-control" value="<?php echo $salida_alm ?>" <?php echo $disabled_alm; ?>>
                                </div>
                                
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_t_mare"><input type="checkbox"  name="ch_t_mare" id="ch_t_mare" value="1" onclick="Habilitar_Rangoe('t_mare')" <?php echo $checked_t ?>> Tarde </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_t_mare" id="ingreso_t_mare" class="form-control" value="<?php echo $ingreso_t ?>" <?php echo $disabled_t; ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_t_mare" id="salida_t_mare" class="form-control" value="<?php echo $salida_t ?>" <?php echo $disabled_t; ?>>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_c_mare"><input type="checkbox" name="ch_c_mare" id="ch_c_mare" value="1" onclick="Habilitar_Rangoe('c_mare')" <?php echo $checked_c ?>> Cena </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div> 
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_c_mare" id="ingreso_c_mare" class="form-control" value="<?php echo $ingreso_c ?>" <?php echo $disabled_c; ?>>
                                </div>
                                        
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_c_mare" id="salida_c_mare" class="form-control" value="<?php echo $salida_c ?>" <?php echo $disabled_c; ?>>
                                </div> 
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_n_mare"><input type="checkbox" name="ch_n_mare" id="ch_n_mare" value="1" onclick="Habilitar_Rangoe('n_mare')" <?php echo $checked_n ?>> Noche </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_n_mare" id="ingreso_n_mare" class="form-control" value="<?php echo $salida_n ?>" <?php echo $disabled_n; ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_n_mare" id="salida_n_mare" class="form-control" value="<?php echo $salida_n ?>" <?php echo $disabled_n; ?>>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane <?php if($get_id[0]['ch_mier']==1){if($tab>0){echo "active";$tab=$tab-1;}}?>" id="tab-miere">
                        <?php $busqueda = in_array(3, array_column($get_dia, 'dia'));
                            $posicion = array_search(3, array_column($get_dia, 'dia')); 
                            $disabled_m="disabled";
                            $id_horario_detalle="";
                            $checked_m="";
                            $ingreso_m="";
                            $salida_m="";

                            $disabled_alm="disabled";
                            $checked_alm="";
                            $ingreso_alm="";
                            $salida_alm="";

                            $disabled_t="disabled";
                            $checked_t="";
                            $ingreso_t="";
                            $salida_t="";
                            
                            $disabled_c="disabled";
                            $checked_c="";
                            $ingreso_c="";
                            $salida_c="";

                            $disabled_n="disabled";
                            $checked_n="";
                            $ingreso_n="";
                            $salida_n="";
                            if($busqueda!= false){
                            $id_horario_detalle=$get_dia[$posicion]['id_horario_detalle'];
                            if($get_dia[$posicion]['ch_m']==1){
                                $checked_m="checked";
                                $disabled_m="";
                                $ingreso_m=$get_dia[$posicion]['ingreso_m'];
                                $salida_m=$get_dia[$posicion]['salida_m'];
                            }
                            if($get_dia[$posicion]['ch_alm']==1){
                                $checked_alm="checked";
                                $disabled_alm="";
                                $ingreso_alm=$get_dia[$posicion]['ingreso_alm'];
                                $salida_alm=$get_dia[$posicion]['salida_alm'];
                            }
                            if($get_dia[$posicion]['ch_t']==1){
                                $checked_t="checked";
                                $disabled_t="";
                                $ingreso_t=$get_dia[$posicion]['ingreso_t'];
                                $salida_t=$get_dia[$posicion]['salida_t'];
                            }
                            if($get_dia[$posicion]['ch_c']==1){
                                $checked_c="checked";
                                $disabled_c="";
                                $ingreso_c=$get_dia[$posicion]['ingreso_c'];
                                $salida_c=$get_dia[$posicion]['salida_c'];
                            }
                            if($get_dia[$posicion]['ch_n']==1){
                                $checked_n="checked";
                                $disabled_n="";
                                $ingreso_n=$get_dia[$posicion]['ingreso_n'];
                                $salida_n=$get_dia[$posicion]['salida_n'];
                            }
                            }
                        ?>
                        <div id="div_miere" style="display:<?php if($get_id[0]['ch_mier']==0){echo "none";}else{echo "block";}?>">
                            <input type="hidden" name="id_horario_detalle_mier" id="id_horario_detalle_mier" value="<?php echo $id_horario_detalle ?>">
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_m_miere"><input type="checkbox" name="ch_m_miere" id="ch_m_miere" value="1" onclick="Habilitar_Rangoe('m_miere')" <?php echo $checked_m ?>> Mañana </label>                
                                </div>
                                <div class="form-group col-md-1" >
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_m_miere" id="ingreso_m_miere" class="form-control" value="<?php echo $ingreso_m ?>" <?php echo $disabled_m; ?>>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_m_miere" id="salida_m_miere" class="form-control" value="<?php echo $salida_m ?>" <?php echo $disabled_m; ?>>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_alm_miere"><input type="checkbox" name="ch_alm_miere" id="ch_alm_miere" value="1" onclick="Habilitar_Rangoe('alm_miere')" <?php echo $checked_alm ?>> Almuerzo </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_alm_miere" id="ingreso_alm_miere" class="form-control" value="<?php echo $ingreso_alm ?>" <?php echo $disabled_alm; ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_alm_miere" id="salida_alm_miere" class="form-control" value="<?php echo $salida_alm ?>" <?php echo $disabled_alm; ?>>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_t_miere"><input type="checkbox"  name="ch_t_miere" id="ch_t_miere" value="1" onclick="Habilitar_Rangoe('t_miere')" <?php echo $checked_t ?>> Tarde </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_t_miere" id="ingreso_t_miere" class="form-control" value="<?php echo $ingreso_t ?>" <?php echo $disabled_t; ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_t_miere" id="salida_t_miere" class="form-control" value="<?php echo $salida_t ?>" <?php echo $disabled_t; ?>>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_c_miere"><input type="checkbox" name="ch_c_miere" id="ch_c_miere" value="1" onclick="Habilitar_Rangoe('c_miere')" <?php echo $checked_c ?>> Cena </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div> 
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_c_miere" id="ingreso_c_miere" class="form-control" value="<?php echo $ingreso_c ?>" <?php echo $disabled_c; ?>>
                                </div>
                                        
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_c_miere" id="salida_c_miere" class="form-control" value="<?php echo $salida_c ?>" <?php echo $disabled_c; ?>>
                                </div> 
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_n_miere"><input type="checkbox" name="ch_n_miere" id="ch_n_miere" value="1" onclick="Habilitar_Rangoe('n_miere')" <?php echo $checked_n ?>> Noche </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_n_miere" id="ingreso_n_miere" class="form-control" value="<?php echo $ingreso_n ?>" <?php echo $disabled_n; ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_n_miere" id="salida_n_miere" class="form-control" value="<?php echo $salida_n ?>" <?php echo $disabled_n; ?>>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane <?php if($get_id[0]['ch_jue']==1){if($tab>0){echo "active";$tab=$tab-1;}}?>" id="tab-juee">
                        <?php $busqueda = in_array(4, array_column($get_dia, 'dia'));
                            $posicion = array_search(4, array_column($get_dia, 'dia')); 
                            $disabled_m="disabled";
                            $id_horario_detalle="";
                            $checked_m="";
                            $ingreso_m="";
                            $salida_m="";

                            $disabled_alm="disabled";
                            $checked_alm="";
                            $ingreso_alm="";
                            $salida_alm="";

                            $disabled_t="disabled";
                            $checked_t="";
                            $ingreso_t="";
                            $salida_t="";
                            
                            $disabled_c="disabled";
                            $checked_c="";
                            $ingreso_c="";
                            $salida_c="";

                            $disabled_n="disabled";
                            $checked_n="";
                            $ingreso_n="";
                            $salida_n="";
                            if($busqueda!= false){
                            $id_horario_detalle=$get_dia[$posicion]['id_horario_detalle'];
                            if($get_dia[$posicion]['ch_m']==1){
                                $checked_m="checked";
                                $disabled_m="";
                                $ingreso_m=$get_dia[$posicion]['ingreso_m'];
                                $salida_m=$get_dia[$posicion]['salida_m'];
                            }
                            if($get_dia[$posicion]['ch_alm']==1){
                                $checked_alm="checked";
                                $disabled_alm="";
                                $ingreso_alm=$get_dia[$posicion]['ingreso_alm'];
                                $salida_alm=$get_dia[$posicion]['salida_alm'];
                            }
                            if($get_dia[$posicion]['ch_t']==1){
                                $checked_t="checked";
                                $disabled_t="";
                                $ingreso_t=$get_dia[$posicion]['ingreso_t'];
                                $salida_t=$get_dia[$posicion]['salida_t'];
                            }
                            if($get_dia[$posicion]['ch_c']==1){
                                $checked_c="checked";
                                $disabled_c="";
                                $ingreso_c=$get_dia[$posicion]['ingreso_c'];
                                $salida_c=$get_dia[$posicion]['salida_c'];
                            }
                            if($get_dia[$posicion]['ch_n']==1){
                                $checked_n="checked";
                                $disabled_n="";
                                $ingreso_n=$get_dia[$posicion]['ingreso_n'];
                                $salida_n=$get_dia[$posicion]['salida_n'];
                            }
                            }
                        ?>
                        <div id="div_juee" style="display:<?php if($get_id[0]['ch_jue']==0){echo "none";}?>">
                            <input type="hidden" name="id_horario_detalle_jue" id="id_horario_detalle_jue" value="<?php echo $id_horario_detalle ?>">
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_m_juee"><input type="checkbox" name="ch_m_juee" id="ch_m_juee" value="1" onclick="Habilitar_Rangoe('m_juee')" <?php echo $checked_m ?>> Mañana </label>                
                                </div>
                                <div class="form-group col-md-1" >
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_m_juee" id="ingreso_m_juee" class="form-control" value="<?php echo $ingreso_m ?>" <?php echo $disabled_m; ?>>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_m_juee" id="salida_m_juee" class="form-control" value="<?php echo $salida_m ?>" <?php echo $disabled_m; ?>>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_alm_juee"><input type="checkbox" name="ch_alm_juee" id="ch_alm_juee" value="1" onclick="Habilitar_Rangoe('alm_juee')" <?php echo $checked_alm ?>> Almuerzo </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_alm_juee" id="ingreso_alm_juee" class="form-control" value="<?php echo $ingreso_alm ?>" <?php echo $disabled_alm; ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_alm_juee" id="salida_alm_juee" class="form-control" value="<?php echo $salida_alm ?>" <?php echo $disabled_alm; ?>>
                                </div>
                                
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_t_juee"><input type="checkbox"  name="ch_t_juee" id="ch_t_juee" value="1" onclick="Habilitar_Rangoe('t_juee')" <?php echo $checked_t ?>> Tarde </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_t_juee" id="ingreso_t_juee" class="form-control" value="<?php echo $ingreso_t ?>" <?php echo $disabled_t; ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_t_juee" id="salida_t_juee" class="form-control" value="<?php echo $salida_t ?>" <?php echo $disabled_t; ?>>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_c_juee"><input type="checkbox" name="ch_c_juee" id="ch_c_juee" value="1" onclick="Habilitar_Rangoe('c_juee')" <?php echo $checked_c ?>> Cena </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div> 
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_c_juee" id="ingreso_c_juee" class="form-control" value="<?php echo $ingreso_c ?>" <?php echo $disabled_c; ?>>
                                </div>
                                        
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_c_juee" id="salida_c_juee" class="form-control" value="<?php echo $salida_c ?>" <?php echo $disabled_c; ?>>
                                </div> 
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_n_juee"><input type="checkbox" name="ch_n_juee" id="ch_n_juee" value="1" onclick="Habilitar_Rangoe('n_juee')" <?php echo $checked_n ?>> Noche </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_n_juee" id="ingreso_n_juee" class="form-control" value="<?php echo $ingreso_n ?>" <?php echo $disabled_n; ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_n_juee" id="salida_n_juee" class="form-control" value="<?php echo $salida_n ?>" <?php echo $disabled_n; ?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane <?php if($get_id[0]['ndias']>1 && $get_id[0]['ch_vie']==1 && $tab>0){echo "active";}?>" id="tab-viee">
                        <?php $busqueda = in_array(5, array_column($get_dia, 'dia'));
                            $posicion = array_search(5, array_column($get_dia, 'dia')); 
                            $disabled_m="disabled";
                            $id_horario_detalle="";
                            $checked_m="";
                            $ingreso_m="";
                            $salida_m="";

                            $disabled_alm="disabled";
                            $checked_alm="";
                            $ingreso_alm="";
                            $salida_alm="";

                            $disabled_t="disabled";
                            $checked_t="";
                            $ingreso_t="";
                            $salida_t="";
                            
                            $disabled_c="disabled";
                            $checked_c="";
                            $ingreso_c="";
                            $salida_c="";

                            $disabled_n="disabled";
                            $checked_n="";
                            $ingreso_n="";
                            $salida_n="";
                            if($busqueda!= false){
                            $id_horario_detalle=$get_dia[$posicion]['id_horario_detalle'];
                            if($get_dia[$posicion]['ch_m']==1){
                                $checked_m="checked";
                                $disabled_m="";
                                $ingreso_m=$get_dia[$posicion]['ingreso_m'];
                                $salida_m=$get_dia[$posicion]['salida_m'];
                            }
                            if($get_dia[$posicion]['ch_alm']==1){
                                $checked_alm="checked";
                                $disabled_alm="";
                                $ingreso_alm=$get_dia[$posicion]['ingreso_alm'];
                                $salida_alm=$get_dia[$posicion]['salida_alm'];
                            }
                            if($get_dia[$posicion]['ch_t']==1){
                                $checked_t="checked";
                                $disabled_t="";
                                $ingreso_t=$get_dia[$posicion]['ingreso_t'];
                                $salida_t=$get_dia[$posicion]['salida_t'];
                            }
                            if($get_dia[$posicion]['ch_c']==1){
                                $checked_c="checked";
                                $disabled_c="";
                                $ingreso_c=$get_dia[$posicion]['ingreso_c'];
                                $salida_c=$get_dia[$posicion]['salida_c'];
                            }
                            if($get_dia[$posicion]['ch_n']==1){
                                $checked_n="checked";
                                $disabled_n="";
                                $ingreso_n=$get_dia[$posicion]['ingreso_n'];
                                $salida_n=$get_dia[$posicion]['salida_n'];
                            }
                            }
                        ?>
                        <div id="div_viee" style="display:<?php if($get_id[0]['ch_vie']==0){echo "none";}?>">
                            <input type="hidden" name="id_horario_detalle_vie" id="id_horario_detalle_vie" value="<?php echo $id_horario_detalle ?>">
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_m_viee"><input type="checkbox" name="ch_m_viee" id="ch_m_viee" value="1" onclick="Habilitar_Rangoe('m_viee')" <?php echo $checked_m ?>> Mañana </label>                
                                </div>
                                <div class="form-group col-md-1" >
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_m_viee" id="ingreso_m_viee" class="form-control" value="<?php echo $ingreso_m ?>" <?php echo $disabled_m; ?>>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_m_viee" id="salida_m_viee" class="form-control" value="<?php echo $salida_m ?>" <?php echo $disabled_m; ?>>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_alm_viee"><input type="checkbox" name="ch_alm_viee" id="ch_alm_viee" value="1" onclick="Habilitar_Rangoe('alm_viee')" <?php echo $checked_alm ?>> Almuerzo </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_alm_viee" id="ingreso_alm_viee" class="form-control" value="<?php echo $ingreso_alm ?>" <?php echo $disabled_alm; ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_alm_viee" id="salida_alm_viee" class="form-control" value="<?php echo $salida_alm ?>" <?php echo $disabled_alm; ?>>
                                </div>
                                
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_t_viee"><input type="checkbox"  name="ch_t_viee" id="ch_t_viee" value="1" onclick="Habilitar_Rangoe('t_viee')" <?php echo $checked_t ?>> Tarde </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_t_viee" id="ingreso_t_viee" class="form-control" value="<?php echo $ingreso_t ?>" <?php echo $disabled_t; ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_t_viee" id="salida_t_viee" class="form-control" value="<?php echo $salida_t ?>" <?php echo $disabled_t; ?>>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_c_viee"><input type="checkbox" name="ch_c_viee" id="ch_c_viee" value="1" onclick="Habilitar_Rangoe('c_viee')" <?php echo $checked_c ?>> Cena </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div> 
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_c_viee" id="ingreso_c_viee" class="form-control" value="<?php echo $ingreso_c ?>" <?php echo $disabled_c; ?>>
                                </div>
                                        
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_c_viee" id="salida_c_viee" class="form-control" value="<?php echo $salida_c ?>" <?php echo $disabled_c; ?>>
                                </div> 
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_n_viee"><input type="checkbox" name="ch_n_viee" id="ch_n_viee" value="1" onclick="Habilitar_Rangoe('n_viee')" <?php echo $checked_n ?>> Noche </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_n_viee" id="ingreso_n_viee" class="form-control" value="<?php echo $ingreso_n ?>" <?php echo $disabled_n; ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_n_viee" id="salida_n_viee" class="form-control" value="<?php echo $salida_n ?>" <?php echo $disabled_n; ?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane <?php if($get_id[0]['ndias']>1 && $get_id[0]['ch_sab']==1 && $tab>0){echo "active";}?>" id="tab-sabe" >
                        <?php $busqueda = in_array(6, array_column($get_dia, 'dia'));
                            $posicion = array_search(6, array_column($get_dia, 'dia')); 
                            $disabled_m="disabled";
                            $id_horario_detalle="";
                            $checked_m="";
                            $ingreso_m="";
                            $salida_m="";

                            $disabled_alm="disabled";
                            $checked_alm="";
                            $ingreso_alm="";
                            $salida_alm="";

                            $disabled_t="disabled";
                            $checked_t="";
                            $ingreso_t="";
                            $salida_t="";
                            
                            $disabled_c="disabled";
                            $checked_c="";
                            $ingreso_c="";
                            $salida_c="";

                            $disabled_n="disabled";
                            $checked_n="";
                            $ingreso_n="";
                            $salida_n="";
                            if($busqueda!= false){
                            $id_horario_detalle=$get_dia[$posicion]['id_horario_detalle'];
                            if($get_dia[$posicion]['ch_m']==1){
                                $checked_m="checked";
                                $disabled_m="";
                                $ingreso_m=$get_dia[$posicion]['ingreso_m'];
                                $salida_m=$get_dia[$posicion]['salida_m'];
                            }
                            if($get_dia[$posicion]['ch_alm']==1){
                                $checked_alm="checked";
                                $disabled_alm="";
                                $ingreso_alm=$get_dia[$posicion]['ingreso_alm'];
                                $salida_alm=$get_dia[$posicion]['salida_alm'];
                            }
                            if($get_dia[$posicion]['ch_t']==1){
                                $checked_t="checked";
                                $disabled_t="";
                                $ingreso_t=$get_dia[$posicion]['ingreso_t'];
                                $salida_t=$get_dia[$posicion]['salida_t'];
                            }
                            if($get_dia[$posicion]['ch_c']==1){
                                $checked_c="checked";
                                $disabled_c="";
                                $ingreso_c=$get_dia[$posicion]['ingreso_c'];
                                $salida_c=$get_dia[$posicion]['salida_c'];
                            }
                            if($get_dia[$posicion]['ch_n']==1){
                                $checked_n="checked";
                                $disabled_n="";
                                $ingreso_n=$get_dia[$posicion]['ingreso_n'];
                                $salida_n=$get_dia[$posicion]['salida_n'];
                            }
                            }
                        ?>
                        <div id="div_sabe" style="display:<?php if($get_id[0]['ch_sab']==0){echo "none";}?>">
                            <input type="hidden" name="id_horario_detalle_sab" id="id_horario_detalle_sab" value="<?php echo $id_horario_detalle ?>">
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_m_sabe"><input type="checkbox" name="ch_m_sabe" id="ch_m_sabe" value="1" onclick="Habilitar_Rangoe('m_sabe')" <?php echo $checked_m ?>> Mañana </label>                
                                </div>
                                <div class="form-group col-md-1" >
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_m_sabe" id="ingreso_m_sabe" class="form-control" value="<?php echo $ingreso_m ?>" <?php echo $disabled_m; ?>>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_m_sabe" id="salida_m_sabe" class="form-control" value="<?php echo $salida_m ?>" <?php echo $disabled_m; ?>>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_alm_sabe"><input type="checkbox" name="ch_alm_sabe" id="ch_alm_sabe" value="1" onclick="Habilitar_Rangoe('alm_sabe')" <?php echo $checked_alm ?>> Almuerzo </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_alm_sabe" id="ingreso_alm_sabe" class="form-control" value="<?php echo $ingreso_alm ?>" <?php echo $disabled_alm; ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_alm_sabe" id="salida_alm_sabe" class="form-control" value="<?php echo $salida_alm ?>" <?php echo $disabled_alm; ?>>
                                </div>
                                
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_t_sabe"><input type="checkbox"  name="ch_t_sabe" id="ch_t_sabe" value="1" onclick="Habilitar_Rangoe('t_sabe')" <?php echo $checked_t ?>> Tarde </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_t_sabe" id="ingreso_t_sabe" class="form-control" value="<?php echo $ingreso_t ?>" <?php echo $disabled_t; ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_t_sabe" id="salida_t_sabe" class="form-control" value="<?php echo $salida_t ?>" <?php echo $disabled_t; ?>>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_c_sabe"><input type="checkbox" name="ch_c_sabe" id="ch_c_sabe" value="1" onclick="Habilitar_Rangoe('c_sabe')" <?php echo $checked_c ?>> Cena </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div> 
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_c_sabe" id="ingreso_c_sabe" class="form-control" value="<?php echo $ingreso_c ?>" <?php echo $disabled_c; ?>>
                                </div>
                                        
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_c_sabe" id="salida_c_sabe" class="form-control" value="<?php echo $salida_c ?>" <?php echo $disabled_c; ?>>
                                </div> 
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_n_sabe"><input type="checkbox" name="ch_n_sabe" id="ch_n_sabe" value="1" onclick="Habilitar_Rangoe('n_sabe')" <?php echo $checked_n ?>> Noche </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_n_sabe" id="ingreso_n_sabe" class="form-control" value="<?php echo $ingreso_n ?>" <?php echo $disabled_n; ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_n_sabe" id="salida_n_sabe" class="form-control" value="<?php echo $salida_n ?>" <?php echo $disabled_n; ?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane <?php if($get_id[0]['ndias']>1 && $get_id[0]['ch_dom']==1 && $tab>0){echo "active";}?>" id="tab-dome">
                        <?php $busqueda = in_array(7, array_column($get_dia, 'dia'));
                            $posicion = array_search(7, array_column($get_dia, 'dia')); 
                            $disabled_m="disabled";
                            $id_horario_detalle="";
                            $checked_m="";
                            $ingreso_m="";
                            $salida_m="";

                            $disabled_alm="disabled";
                            $checked_alm="";
                            $ingreso_alm="";
                            $salida_alm="";

                            $disabled_t="disabled";
                            $checked_t="";
                            $ingreso_t="";
                            $salida_t="";
                            
                            $disabled_c="disabled";
                            $checked_c="";
                            $ingreso_c="";
                            $salida_c="";

                            $disabled_n="disabled";
                            $checked_n="";
                            $ingreso_n="";
                            $salida_n="";
                            if($busqueda!= false){
                            $id_horario_detalle=$get_dia[$posicion]['id_horario_detalle'];
                            if($get_dia[$posicion]['ch_m']==1){
                                $checked_m="checked";
                                $disabled_m="";
                                $ingreso_m=$get_dia[$posicion]['ingreso_m'];
                                $salida_m=$get_dia[$posicion]['salida_m'];
                            }
                            if($get_dia[$posicion]['ch_alm']==1){
                                $checked_alm="checked";
                                $disabled_alm="";
                                $ingreso_alm=$get_dia[$posicion]['ingreso_alm'];
                                $salida_alm=$get_dia[$posicion]['salida_alm'];
                            }
                            if($get_dia[$posicion]['ch_t']==1){
                                $checked_t="checked";
                                $disabled_t="";
                                $ingreso_t=$get_dia[$posicion]['ingreso_t'];
                                $salida_t=$get_dia[$posicion]['salida_t'];
                            }
                            if($get_dia[$posicion]['ch_c']==1){
                                $checked_c="checked";
                                $disabled_c="";
                                $ingreso_c=$get_dia[$posicion]['ingreso_c'];
                                $salida_c=$get_dia[$posicion]['salida_c'];
                            }
                            if($get_dia[$posicion]['ch_n']==1){
                                $checked_n="checked";
                                $disabled_n="";
                                $ingreso_n=$get_dia[$posicion]['ingreso_n'];
                                $salida_n=$get_dia[$posicion]['salida_n'];
                            }
                            }
                        ?>
                        <div id="div_dome" style="display:<?php if($get_id[0]['ch_dom']==0){echo "none";}?>">
                            <input type="hidden" name="id_horario_detalle_dom" id="id_horario_detalle_dom" value="<?php echo $id_horario_detalle ?>">
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_m_dome"><input type="checkbox" name="ch_m_dome" id="ch_m_dome" value="1" onclick="Habilitar_Rangoe('m_dome')" <?php echo $checked_m ?>> Mañana </label>                
                                </div>
                                <div class="form-group col-md-1" >
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_m_dome" id="ingreso_m_dome" class="form-control" value="<?php echo $ingreso_m ?>" <?php echo $disabled_m; ?>>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_m_dome" id="salida_m_dome" class="form-control" value="<?php echo $salida_m ?>" <?php echo $disabled_m; ?>>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_alm_dome"><input type="checkbox" name="ch_alm_dome" id="ch_alm_dome" value="1" onclick="Habilitar_Rangoe('alm_dome')" <?php echo $checked_alm ?>> Almuerzo </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_alm_dome" id="ingreso_alm_dome" class="form-control" value="<?php echo $ingreso_alm ?>" <?php echo $disabled_alm; ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_alm_dome" id="salida_alm_dome" class="form-control" value="<?php echo $salida_alm ?>" <?php echo $disabled_alm; ?>>
                                </div>
                                
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_t_dome"><input type="checkbox"  name="ch_t_dome" id="ch_t_dome" value="1" onclick="Habilitar_Rangoe('t_dome')" <?php echo $checked_t ?>> Tarde </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_t_dome" id="ingreso_t_dome" class="form-control" value="<?php echo $ingreso_t ?>" <?php echo $disabled_t; ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_t_dome" id="salida_t_dome" class="form-control" value="<?php echo $salida_t ?>" <?php echo $disabled_t; ?>>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_c_dome"><input type="checkbox" name="ch_c_dome" id="ch_c_dome" value="1" onclick="Habilitar_Rangoe('c_dome')" <?php echo $checked_c ?>> Cena </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div> 
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_c_dome" id="ingreso_c_dome" class="form-control" value="<?php echo $ingreso_c ?>" <?php echo $disabled_c; ?>>
                                </div>
                                        
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_c_dome" id="salida_c_dome" class="form-control" value="<?php echo $salida_c ?>" <?php echo $disabled_c; ?>>
                                </div> 
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_n_dome"><input type="checkbox" name="ch_n_dome" id="ch_n_dome" value="1" onclick="Habilitar_Rangoe('n_dome')" <?php echo $checked_n ?>> Noche </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_n_dome" id="ingreso_n_dome" class="form-control" value="<?php echo $ingreso_n ?>" <?php echo $disabled_n; ?>>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_n_dome" id="salida_n_dome" class="form-control" value="<?php echo $salida_n ?>" <?php echo $disabled_n; ?>>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" name="id_horario" id="id_horario" value="<?php echo $get_id[0]['id_horario']; ?>">
        <input type="hidden" name="id_colaborador" id="id_colaborador" value="<?php echo $get_id[0]['id_colaborador']; ?>">
        <button class="btn btn-primary" type="button" onclick="Update_Horario_Colaborador();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Habilitar_Diae(v){
        $("#ingreso_m_"+v).val('');
        $("#salida_m_"+v).val('');
        $("#ingreso_alm_"+v).val('');
        $("#salida_alm_"+v).val('');
        $("#ingreso_t_"+v).val('');
        $("#salida_t_"+v).val('');
        $("#ingreso_c_"+v).val('');
        $("#salida_c_"+v).val('');
        $("#ingreso_n_"+v).val('');
        $("#salida_n_"+v).val('');

        $('#ch_m_'+v).prop('checked', false);
        $('#ch_alm_'+v).prop('checked', false);
        $('#ch_t_'+v).prop('checked', false);
        $('#ch_c_'+v).prop('checked', false);
        $('#ch_n_'+v).prop('checked', false);

        $("#ingreso_m_"+v).prop('disabled', true);
        $("#salida_m_"+v).prop('disabled', true);
        $("#ingreso_alm_"+v).prop('disabled', true);
        $("#salida_alm_"+v).prop('disabled', true);
        $("#ingreso_t_"+v).prop('disabled', true);
        $("#salida_t_"+v).prop('disabled', true);
        $("#ingreso_c_"+v).prop('disabled', true);
        $("#salida_c_"+v).prop('disabled', true);
        $("#ingreso_n_"+v).prop('disabled', true);
        $("#salida_n_"+v).prop('disabled', true);
        if($('#ch_'+v).is(":checked")){
            var div1 = document.getElementById("li_"+v);
            var div2 = document.getElementById("div_"+v);
            div1.classList.remove("oculto");
            div2.style.display = "block";
        }else{
            var div1 = document.getElementById("li_"+v);
            var div2 = document.getElementById("div_"+v);
            div1.classList.add("oculto");
            div2.style.display = "none";
        }
    }

    function Habilitar_Rangoe(v){
        $("#ingreso_"+v).val('');
        $("#salida_"+v).val('');
        if($('#ch_'+v).is(":checked")){
            $("#ingreso_"+v).prop('disabled', false);
            $("#salida_"+v).prop('disabled', false);
        }else{
            $("#ingreso_"+v).prop('disabled', true);
            $("#salida_"+v).prop('disabled', true);
        }
    }

    function Update_Horario_Colaborador(){ 
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update_horario'));
        var url="<?php echo site_url(); ?>Colaborador/Update_Horario_Colaborador";

        if (Valida_Horario('e')) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if (data == "error") {
                        Swal({
                            title: 'Actualización Denegada',
                            text: "¡Existe un horario activo!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Horario();
                        $("#modal_form_vertical .close").click()
                    }
                }
            });
        }
    }

    function Valida_Horario(t) { 
        if($('#desde_horario'+t).val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha de Inicio de Horario.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#hasta_horario'+t).val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha de Fin de Horario.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#hasta_horario'+t).val()<$('#desde_horario'+t).val()){
            Swal(
                'Ups!',
                'Fecha de Fin de Horario no debe ser antes que la fecha de Inicio.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_registro_horario'+t).val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar estado de Horario.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#ch_lun'+t).is(":checked")){
            if (!$('#ch_m_lun'+t).is(":checked") && !$('#ch_alm_lun'+t).is(":checked") && !$('#ch_t_lun'+t).is(":checked")
            && !$('#ch_c_lun'+t).is(":checked") && !$('#ch_n_lun'+t).is(":checked")){
                Swal(
                    'Ups!',
                    'Debe seleccionar al menos un turno de marcaciones del Lunes para continuar.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#ch_m_lun'+t).is(":checked")){
                if($('#ingreso_m_lun'+t).val() === '' || $('#ingreso_m_lun'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Mañana (Lunes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_m'+t).val() === '' || $('#salida_m'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Mañana (Lunes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_alm_lun'+t).is(":checked")){
                if($('#ingreso_alm_lun'+t).val() === '' || $('#ingreso_alm_lun'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en el Almuerzo (Lunes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_alm_lun'+t).val() === '' || $('#salida_alm_lun'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en el Almuerzo (Lunes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_t_lun'+t).is(":checked")){
                if($('#ingreso_t_lun'+t).val() === '' || $('#ingreso_t_lun'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Tarde (Lunes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_t_lun'+t).val() === '' || $('#salida_t_lun'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Tarde (Lunes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_c_lun'+t).is(":checked")){
                if($('#ingreso_c_lun'+t).val() === '' || $('#ingreso_c_lun'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Cena (Lunes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_c_lun'+t).val() === '' || $('#salida_c_lun'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Cena (Lunes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            if($('#ch_n_lun'+t).is(":checked")){
                if($('#ingreso_n_lun'+t).val() === '' || $('#ingreso_n_lun'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Noche (Lunes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_n_lun'+t).val() === '' || $('#salida_n_lun'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Noche (Lunes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            
        }
        if($('#ch_mar'+t).is(":checked")){
            if (!$('#ch_m_mar'+t).is(":checked") && !$('#ch_alm_mar'+t).is(":checked") && !$('#ch_t_mar'+t).is(":checked")
            && !$('#ch_c_mar'+t).is(":checked") && !$('#ch_n_mar'+t).is(":checked")){
                Swal(
                    'Ups!',
                    'Debe seleccionar al menos un turno de marcaciones del Martes para continuar.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#ch_m_mar'+t).is(":checked")){
                if($('#ingreso_m_mar'+t).val() === '' || $('#ingreso_m_mar'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Mañana (Martes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_m'+t).val() === '' || $('#salida_m'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Mañana (Martes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_alm_mar'+t).is(":checked")){
                if($('#ingreso_alm_mar'+t).val() === '' || $('#ingreso_alm_mar'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en el Almuerzo (Martes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_alm_mar'+t).val() === '' || $('#salida_alm_mar'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en el Almuerzo (Martes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_t_mar'+t).is(":checked")){
                if($('#ingreso_t_mar'+t).val() === '' || $('#ingreso_t_mar'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Tarde (Martes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_t_mar'+t).val() === '' || $('#salida_t_mar'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Tarde (Martes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_c_mar'+t).is(":checked")){
                if($('#ingreso_c_mar'+t).val() === '' || $('#ingreso_c_mar'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Cena (Martes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_c_mar'+t).val() === '' || $('#salida_c_mar'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Cena (Martes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            if($('#ch_n_mar'+t).is(":checked")){
                if($('#ingreso_n_mar'+t).val() === '' || $('#ingreso_n_mar'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Noche (Martes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_n_mar'+t).val() === '' || $('#salida_n_mar'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Noche (Martes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            
        }
        if($('#ch_mier'+t).is(":checked")){
            if (!$('#ch_m_mier'+t).is(":checked") && !$('#ch_alm_mier'+t).is(":checked") && !$('#ch_t_mier'+t).is(":checked")
            && !$('#ch_c_mier'+t).is(":checked") && !$('#ch_n_mier'+t).is(":checked")){
                Swal(
                    'Ups!',
                    'Debe seleccionar al menos un turno de marcaciones del Miércoles para continuar.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#ch_m_mier'+t).is(":checked")){
                if($('#ingreso_m_mier'+t).val() === '' || $('#ingreso_m_mier'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Mañana (Miércoles).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_m'+t).val() === '' || $('#salida_m'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Mañana (Miércoles).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_alm_mier'+t).is(":checked")){
                if($('#ingreso_alm_mier'+t).val() === '' || $('#ingreso_alm_mier'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en el Almuerzo (Miércoles).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_alm_mier'+t).val() === '' || $('#salida_alm_mier'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en el Almuerzo (Miércoles).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_t_mier'+t).is(":checked")){
                if($('#ingreso_t_mier'+t).val() === '' || $('#ingreso_t_mier'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Tarde (Miércoles).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_t_mier'+t).val() === '' || $('#salida_t_mier'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Tarde (Miércoles).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_c_mier'+t).is(":checked")){
                if($('#ingreso_c_mier'+t).val() === '' || $('#ingreso_c_mier'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Cena (Miércoles).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_c_mier'+t).val() === '' || $('#salida_c_mier'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Cena (Miércoles).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            if($('#ch_n_mier'+t).is(":checked")){
                if($('#ingreso_n_mier'+t).val() === '' || $('#ingreso_n_mier'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Noche (Miércoles).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_n_mier'+t).val() === '' || $('#salida_n_mier'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Noche (Miércoles).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            
        }
        if($('#ch_jue'+t).is(":checked")){
            if (!$('#ch_m_jue'+t).is(":checked") && !$('#ch_alm_jue'+t).is(":checked") && !$('#ch_t_jue'+t).is(":checked")
            && !$('#ch_c_jue'+t).is(":checked") && !$('#ch_n_jue'+t).is(":checked")){
                Swal(
                    'Ups!',
                    'Debe seleccionar al menos un turno de marcaciones del Jueves para continuar.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#ch_m_jue'+t).is(":checked")){
                if($('#ingreso_m_jue'+t).val() === '' || $('#ingreso_m_jue'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Mañana (Jueves).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_m'+t).val() === '' || $('#salida_m'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Mañana (Jueves).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_alm_jue'+t).is(":checked")){
                if($('#ingreso_alm_jue'+t).val() === '' || $('#ingreso_alm_jue'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en el Almuerzo (Jueves).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_alm_jue'+t).val() === '' || $('#salida_alm_jue'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en el Almuerzo (Jueves).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_t_jue'+t).is(":checked")){
                if($('#ingreso_t_jue'+t).val() === '' || $('#ingreso_t_jue'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Tarde (Jueves).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_t_jue'+t).val() === '' || $('#salida_t_jue'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Tarde (Jueves).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_c_jue'+t).is(":checked")){
                if($('#ingreso_c_jue'+t).val() === '' || $('#ingreso_c_jue'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Cena (Jueves).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_c_jue'+t).val() === '' || $('#salida_c_jue'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Cena (Jueves).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            if($('#ch_n_jue'+t).is(":checked")){
                if($('#ingreso_n_jue'+t).val() === '' || $('#ingreso_n_jue'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Noche (Jueves).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_n_jue'+t).val() === '' || $('#salida_n_jue'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Noche (Jueves).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            
        }
        if($('#ch_vie'+t).is(":checked")){
            if (!$('#ch_m_vie'+t).is(":checked") && !$('#ch_alm_vie'+t).is(":checked") && !$('#ch_t_vie'+t).is(":checked")
            && !$('#ch_c_vie'+t).is(":checked") && !$('#ch_n_vie'+t).is(":checked")){
                Swal(
                    'Ups!',
                    'Debe seleccionar al menos un turno de marcaciones del Viernes para continuar.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#ch_m_vie'+t).is(":checked")){
                if($('#ingreso_m_vie'+t).val() === '' || $('#ingreso_m_vie'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Mañana (Viernes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_m'+t).val() === '' || $('#salida_m'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Mañana (Viernes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_alm_vie'+t).is(":checked")){
                if($('#ingreso_alm_vie'+t).val() === '' || $('#ingreso_alm_vie'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en el Almuerzo (Viernes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_alm_vie'+t).val() === '' || $('#salida_alm_vie'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en el Almuerzo (Viernes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_t_vie'+t).is(":checked")){
                if($('#ingreso_t_vie'+t).val() === '' || $('#ingreso_t_vie'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Tarde (Viernes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_t_vie'+t).val() === '' || $('#salida_t_vie'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Tarde (Viernes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_c_vie'+t).is(":checked")){
                if($('#ingreso_c_vie'+t).val() === '' || $('#ingreso_c_vie'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Cena (Viernes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_c_vie'+t).val() === '' || $('#salida_c_vie'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Cena (Viernes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            if($('#ch_n_vie'+t).is(":checked")){
                if($('#ingreso_n_vie'+t).val() === '' || $('#ingreso_n_vie'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Noche (Viernes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_n_vie'+t).val() === '' || $('#salida_n_vie'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Noche (Viernes).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            
        }
        if($('#ch_sab'+t).is(":checked")){
            if (!$('#ch_m_sab'+t).is(":checked") && !$('#ch_alm_sab'+t).is(":checked") && !$('#ch_t_sab'+t).is(":checked")
            && !$('#ch_c_sab'+t).is(":checked") && !$('#ch_n_sab'+t).is(":checked")){
                Swal(
                    'Ups!',
                    'Debe seleccionar al menos un turno de marcaciones del Sábado para continuar.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#ch_m_sab'+t).is(":checked")){
                if($('#ingreso_m_sab'+t).val() === '' || $('#ingreso_m_sab'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Mañana (Sábado).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_m'+t).val() === '' || $('#salida_m'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Mañana (Sábado).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_alm_sab'+t).is(":checked")){
                if($('#ingreso_alm_sab'+t).val() === '' || $('#ingreso_alm_sab'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en el Almuerzo (Sábado).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_alm_sab'+t).val() === '' || $('#salida_alm_sab'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en el Almuerzo (Sábado).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_t_sab'+t).is(":checked")){
                if($('#ingreso_t_sab'+t).val() === '' || $('#ingreso_t_sab'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Tarde (Sábado).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_t_sab'+t).val() === '' || $('#salida_t_sab'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Tarde (Sábado).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_c_sab'+t).is(":checked")){
                if($('#ingreso_c_sab'+t).val() === '' || $('#ingreso_c_sab'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Cena (Sábado).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_c_sab'+t).val() === '' || $('#salida_c_sab'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Cena (Sábado).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            if($('#ch_n_sab'+t).is(":checked")){
                if($('#ingreso_n_sab'+t).val() === '' || $('#ingreso_n_sab'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Noche (Sábado).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_n_sab'+t).val() === '' || $('#salida_n_sab'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Noche (Sábado).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            
        }
        if($('#ch_dom'+t).is(":checked")){
            if (!$('#ch_m_dom'+t).is(":checked") && !$('#ch_alm_dom'+t).is(":checked") && !$('#ch_t_dom'+t).is(":checked")
            && !$('#ch_c_dom'+t).is(":checked") && !$('#ch_n_dom'+t).is(":checked")){
                Swal(
                    'Ups!',
                    'Debe seleccionar al menos un turno de marcaciones del Domingo para continuar.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#ch_m_dom'+t).is(":checked")){
                if($('#ingreso_m_dom'+t).val() === '' || $('#ingreso_m_dom'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Mañana (Domingo).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_m'+t).val() === '' || $('#salida_m'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Mañana (Domingo).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_alm_dom'+t).is(":checked")){
                if($('#ingreso_alm_dom'+t).val() === '' || $('#ingreso_alm_dom'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en el Almuerzo (Domingo).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_alm_dom'+t).val() === '' || $('#salida_alm_dom'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en el Almuerzo (Domingo).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_t_dom'+t).is(":checked")){
                if($('#ingreso_t_dom'+t).val() === '' || $('#ingreso_t_dom'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Tarde (Domingo).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_t_dom'+t).val() === '' || $('#salida_t_dom'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Tarde (Domingo).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }

            if($('#ch_c_dom'+t).is(":checked")){
                if($('#ingreso_c_dom'+t).val() === '' || $('#ingreso_c_dom'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Cena (Domingo).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_c_dom'+t).val() === '' || $('#salida_c_dom'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Cena (Domingo).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            if($('#ch_n_dom'+t).is(":checked")){
                if($('#ingreso_n_dom'+t).val() === '' || $('#ingreso_n_dom'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Ingreso en la Noche (Domingo).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
                if($('#salida_n_dom'+t).val() === '' || $('#salida_n_dom'+t).val()=="00:00") {
                    Swal(
                        'Ups!',
                        'Debe ingresar hora válida de Salida en la Noche (Domingo).',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            
        }
        return true;
    }
</script>