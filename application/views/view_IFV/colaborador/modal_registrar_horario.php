<form id="formulario_insert_horario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Horario</h5>
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
                <input type="date" id="desde_horario" name="desde_horario" class="form-control">
            </div>
            <div class="form-group col-md-1">
                <label class="control-label text-bold">A:</label>
            </div>
            <div class="form-group col-md-3">
                <input type="date" id="hasta_horario" name="hasta_horario" class="form-control">
            </div>
            
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-1">
                <label class="control-label text-bold" title="Días de Semana">Días:</label>
            </div>
            <div class="form-group col-md-11">
                <label for="ch_lun"><input type="checkbox" name="ch_lun" id="ch_lun" value="1" checked onclick="Habilitar_Dia('lun')"> Lunes </label>
                <label for="ch_mar"><input type="checkbox" name="ch_mar" id="ch_mar" value="1" checked onclick="Habilitar_Dia('mar')"> Martes </label>
                <label for="ch_mier"><input type="checkbox" name="ch_mier" id="ch_mier" value="1" checked onclick="Habilitar_Dia('mier')"> Miércoles </label>
                <label for="ch_jue"><input type="checkbox" name="ch_jue" id="ch_jue" value="1" checked onclick="Habilitar_Dia('jue')"> Jueves </label>
                <label for="ch_vie"><input type="checkbox" name="ch_vie" id="ch_vie" value="1" checked onclick="Habilitar_Dia('vie')"> Viernes </label>
                <label for="ch_sab"><input type="checkbox" name="ch_sab" id="ch_sab" value="1" onclick="Habilitar_Dia('sab')"> Sábado </label>
                <label for="ch_dom"><input type="checkbox" name="ch_dom" id="ch_dom" value="1" onclick="Habilitar_Dia('dom')"> Domingo </label>
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="tabbable">
                <ul class="nav nav-tabs nav-tabs-highlight nav-justified">
                    <li id="li_lun" class="active" ><a  href="#tab-lun" data-toggle="tab">Lunes</a></li>
                    <li id="li_mar"><a href="#tab-mar" data-toggle="tab">Martes</a></li>
                    <li id="li_mier"><a href="#tab-mier" data-toggle="tab">Miércoles</a></li>
                    <li id="li_jue"><a href="#tab-jue" data-toggle="tab">Jueves</a></li>
                    <li id="li_vie"><a href="#tab-vie" data-toggle="tab">Viernes</a></li>
                    <li id="li_sab" class="oculto"><a href="#tab-sab" data-toggle="tab" >Sábado</a></li>
                    <li id="li_dom" class="oculto"><a href="#tab-dom" data-toggle="tab" >Domingo</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="tab-lun">
                        <div id="div_lun">
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_m_lun"><input type="checkbox" name="ch_m_lun" id="ch_m_lun" value="1" onclick="Habilitar_Rango('m_lun')"> Mañana </label>                
                                </div>
                                <div class="form-group col-md-1" >
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_m_lun" id="ingreso_m_lun" class="form-control" disabled>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_m_lun" id="salida_m_lun" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_alm_lun"><input type="checkbox" name="ch_alm_lun" id="ch_alm_lun" value="1" onclick="Habilitar_Rango('alm_lun')"> Almuerzo </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_alm_lun" id="ingreso_alm_lun" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_alm_lun" id="salida_alm_lun" class="form-control" disabled>
                                </div>
                                
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_t_lun"><input type="checkbox"  name="ch_t_lun" id="ch_t_lun" value="1" onclick="Habilitar_Rango('t_lun')"> Tarde </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_t_lun" id="ingreso_t_lun" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_t_lun" id="salida_t_lun" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_c_lun"><input type="checkbox" name="ch_c_lun" id="ch_c_lun" value="1" onclick="Habilitar_Rango('c_lun')"> Cena </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div> 
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_c_lun" id="ingreso_c_lun" class="form-control" disabled>
                                </div>
                                        
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_c_lun" id="salida_c_lun" class="form-control" disabled>
                                </div> 
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_n_lun"><input type="checkbox" name="ch_n_lun" id="ch_n_lun" value="1" onclick="Habilitar_Rango('n_lun')"> Noche </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_n_lun" id="ingreso_n_lun" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_n_lun" id="salida_n_lun" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab-mar">
                        <div id="div_mar">
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_m_mar"><input type="checkbox" name="ch_m_mar" id="ch_m_mar" value="1" onclick="Habilitar_Rango('m_mar')"> Mañana </label>                
                                </div>
                                <div class="form-group col-md-1" >
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_m_mar" id="ingreso_m_mar" class="form-control" disabled>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_m_mar" id="salida_m_mar" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_alm_mar"><input type="checkbox" name="ch_alm_mar" id="ch_alm_mar" value="1" onclick="Habilitar_Rango('alm_mar')"> Almuerzo </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_alm_mar" id="ingreso_alm_mar" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_alm_mar" id="salida_alm_mar" class="form-control" disabled>
                                </div>
                                
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_t_mar"><input type="checkbox"  name="ch_t_mar" id="ch_t_mar" value="1" onclick="Habilitar_Rango('t_mar')"> Tarde </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_t_mar" id="ingreso_t_mar" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_t_mar" id="salida_t_mar" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_c_mar"><input type="checkbox" name="ch_c_mar" id="ch_c_mar" value="1" onclick="Habilitar_Rango('c_mar')"> Cena </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div> 
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_c_mar" id="ingreso_c_mar" class="form-control" disabled>
                                </div>
                                        
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_c_mar" id="salida_c_mar" class="form-control" disabled>
                                </div> 
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_n_mar"><input type="checkbox" name="ch_n_mar" id="ch_n_mar" value="1" onclick="Habilitar_Rango('n_mar')"> Noche </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_n_mar" id="ingreso_n_mar" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_n_mar" id="salida_n_mar" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab-mier">
                        <div id="div_mier">
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_m_mier"><input type="checkbox" name="ch_m_mier" id="ch_m_mier" value="1" onclick="Habilitar_Rango('m_mier')"> Mañana </label>                
                                </div>
                                <div class="form-group col-md-1" >
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_m_mier" id="ingreso_m_mier" class="form-control" disabled>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_m_mier" id="salida_m_mier" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_alm_mier"><input type="checkbox" name="ch_alm_mier" id="ch_alm_mier" value="1" onclick="Habilitar_Rango('alm_mier')"> Almuerzo </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_alm_mier" id="ingreso_alm_mier" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_alm_mier" id="salida_alm_mier" class="form-control" disabled>
                                </div>
                                
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_t_mier"><input type="checkbox"  name="ch_t_mier" id="ch_t_mier" value="1" onclick="Habilitar_Rango('t_mier')"> Tarde </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_t_mier" id="ingreso_t_mier" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_t_mier" id="salida_t_mier" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_c_mier"><input type="checkbox" name="ch_c_mier" id="ch_c_mier" value="1" onclick="Habilitar_Rango('c_mier')"> Cena </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div> 
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_c_mier" id="ingreso_c_mier" class="form-control" disabled>
                                </div>
                                        
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_c_mier" id="salida_c_mier" class="form-control" disabled>
                                </div> 
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_n_mier"><input type="checkbox" name="ch_n_mier" id="ch_n_mier" value="1" onclick="Habilitar_Rango('n_mier')"> Noche </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_n_mier" id="ingreso_n_mier" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_n_mier" id="salida_n_mier" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab-jue">
                        <div id="div_jue">
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_m_jue"><input type="checkbox" name="ch_m_jue" id="ch_m_jue" value="1" onclick="Habilitar_Rango('m_jue')"> Mañana </label>                
                                </div>
                                <div class="form-group col-md-1" >
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_m_jue" id="ingreso_m_jue" class="form-control" disabled>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_m_jue" id="salida_m_jue" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_alm_jue"><input type="checkbox" name="ch_alm_jue" id="ch_alm_jue" value="1" onclick="Habilitar_Rango('alm_jue')"> Almuerzo </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_alm_jue" id="ingreso_alm_jue" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_alm_jue" id="salida_alm_jue" class="form-control" disabled>
                                </div>
                                
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_t_jue"><input type="checkbox"  name="ch_t_jue" id="ch_t_jue" value="1" onclick="Habilitar_Rango('t_jue')"> Tarde </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_t_jue" id="ingreso_t_jue" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_t_jue" id="salida_t_jue" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_c_jue"><input type="checkbox" name="ch_c_jue" id="ch_c_jue" value="1" onclick="Habilitar_Rango('c_jue')"> Cena </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div> 
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_c_jue" id="ingreso_c_jue" class="form-control" disabled>
                                </div>
                                        
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_c_jue" id="salida_c_jue" class="form-control" disabled>
                                </div> 
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_n_jue"><input type="checkbox" name="ch_n_jue" id="ch_n_jue" value="1" onclick="Habilitar_Rango('n_jue')"> Noche </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_n_jue" id="ingreso_n_jue" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_n_jue" id="salida_n_jue" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-vie">
                        <div id="div_vie">
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_m_vie"><input type="checkbox" name="ch_m_vie" id="ch_m_vie" value="1" onclick="Habilitar_Rango('m_vie')"> Mañana </label>                
                                </div>
                                <div class="form-group col-md-1" >
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_m_vie" id="ingreso_m_vie" class="form-control" disabled>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_m_vie" id="salida_m_vie" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_alm_vie"><input type="checkbox" name="ch_alm_vie" id="ch_alm_vie" value="1" onclick="Habilitar_Rango('alm_vie')"> Almuerzo </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_alm_vie" id="ingreso_alm_vie" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_alm_vie" id="salida_alm_vie" class="form-control" disabled>
                                </div>
                                
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_t_vie"><input type="checkbox"  name="ch_t_vie" id="ch_t_vie" value="1" onclick="Habilitar_Rango('t_vie')"> Tarde </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_t_vie" id="ingreso_t_vie" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_t_vie" id="salida_t_vie" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_c_vie"><input type="checkbox" name="ch_c_vie" id="ch_c_vie" value="1" onclick="Habilitar_Rango('c_vie')"> Cena </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div> 
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_c_vie" id="ingreso_c_vie" class="form-control" disabled>
                                </div>
                                        
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_c_vie" id="salida_c_vie" class="form-control" disabled>
                                </div> 
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_n_vie"><input type="checkbox" name="ch_n_vie" id="ch_n_vie" value="1" onclick="Habilitar_Rango('n_vie')"> Noche </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_n_vie" id="ingreso_n_vie" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_n_vie" id="salida_n_vie" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-sab">
                        <div id="div_sab" style="display:none">
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_m_sab"><input type="checkbox" name="ch_m_sab" id="ch_m_sab" value="1" onclick="Habilitar_Rango('m_sab')"> Mañana </label>                
                                </div>
                                <div class="form-group col-md-1" >
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_m_sab" id="ingreso_m_sab" class="form-control" disabled>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_m_sab" id="salida_m_sab" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_alm_sab"><input type="checkbox" name="ch_alm_sab" id="ch_alm_sab" value="1" onclick="Habilitar_Rango('alm_sab')"> Almuerzo </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_alm_sab" id="ingreso_alm_sab" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_alm_sab" id="salida_alm_sab" class="form-control" disabled>
                                </div>
                                
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_t_sab"><input type="checkbox"  name="ch_t_sab" id="ch_t_sab" value="1" onclick="Habilitar_Rango('t_sab')"> Tarde </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_t_sab" id="ingreso_t_sab" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_t_sab" id="salida_t_sab" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_c_sab"><input type="checkbox" name="ch_c_sab" id="ch_c_sab" value="1" onclick="Habilitar_Rango('c_sab')"> Cena </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div> 
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_c_sab" id="ingreso_c_sab" class="form-control" disabled>
                                </div>
                                        
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_c_sab" id="salida_c_sab" class="form-control" disabled>
                                </div> 
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_n_sab"><input type="checkbox" name="ch_n_sab" id="ch_n_sab" value="1" onclick="Habilitar_Rango('n_sab')"> Noche </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_n_sab" id="ingreso_n_sab" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_n_sab" id="salida_n_sab" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-dom">
                        <div id="div_dom" style="display:none">
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_m_dom"><input type="checkbox" name="ch_m_dom" id="ch_m_dom" value="1" onclick="Habilitar_Rango('m_dom')"> Mañana </label>                
                                </div>
                                <div class="form-group col-md-1" >
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_m_dom" id="ingreso_m_dom" class="form-control" disabled>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_m_dom" id="salida_m_dom" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_alm_dom"><input type="checkbox" name="ch_alm_dom" id="ch_alm_dom" value="1" onclick="Habilitar_Rango('alm_dom')"> Almuerzo </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_alm_dom" id="ingreso_alm_dom" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_alm_dom" id="salida_alm_dom" class="form-control" disabled>
                                </div>
                                
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_t_dom"><input type="checkbox"  name="ch_t_dom" id="ch_t_dom" value="1" onclick="Habilitar_Rango('t_dom')"> Tarde </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_t_dom" id="ingreso_t_dom" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_t_dom" id="salida_t_dom" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2" >
                                    <label for="ch_c_dom"><input type="checkbox" name="ch_c_dom" id="ch_c_dom" value="1" onclick="Habilitar_Rango('c_dom')"> Cena </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div> 
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_c_dom" id="ingreso_c_dom" class="form-control" disabled>
                                </div>
                                        
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_c_dom" id="salida_c_dom" class="form-control" disabled>
                                </div> 
                            </div>
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label for="ch_n_dom"><input type="checkbox" name="ch_n_dom" id="ch_n_dom" value="1" onclick="Habilitar_Rango('n_dom')"> Noche </label>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">Ingreso</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="ingreso_n_dom" id="ingreso_n_dom" class="form-control" disabled>
                                </div>   
                                <div class="form-group col-md-1">
                                    <label for="">Salida</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="time" name="salida_n_dom" id="salida_n_dom" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary mt-3" type="button" onclick="Insert_Horario_Colaborador_V2();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>
