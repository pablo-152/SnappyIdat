

<div class="modal-content">
    <form class="form-horizontal" id="from_foto" method="POST" enctype="multipart/form-data" action="<?= site_url('Snappy/Update_Usuario')?>"  class="formulario">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualiza a Usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        
        <div class="modal-body" style="max-height:700px; overflow:auto;">
            <div class="col-md-12 row">

                      <!--      -----------------------------              -->
                <div class="form-group col-md-2">
                    <label class="col-sm-3 text-bold">Perfil:</label>
                </div>
                
                <div class="form-group col-md-10">
                <select class="form-control" name="id_nivel" id="id_nivel">
                        <option value="0"<?php if (!(strcmp(0, $get_id[0]['id_nivel']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                        <?php foreach($list_nivel as $tipo){ ?>
                            <option value="<?php echo $tipo['id_nivel']; ?>" <?php if (!(strcmp($tipo['id_nivel'], $get_id[0]['id_nivel']))) {echo "selected=\"selected\"";} ?>><?php echo $tipo['nom_nivel'];?></option>
                        <?php } ?>
                    </select>
                </div>


                    <!--         ----------------------------            -->
                        <div class="form-group col-md-4 mb-3">
                                <label class="form-group col text-bold">Apellido Paterno:</label>
                            <div class="col">
                                <input  type="text" required class="form-control" id="usuario_apater" name="usuario_apater" value="<?php echo $get_id[0]['usuario_apater']; ?>" placeholder="Ingresar A. Paterno" autofocus>

                            </div>
                        </div>
                        
                        <div class="form-group col-md-4 mb-3">
                                <label class="form-group col text-bold" for="usuario_amater" >Apellido Materno:</label>
                            <div class="col">
                            <input  type="text" required class="form-control" id="usuario_amater" name="usuario_amater" value="<?php echo $get_id[0]['usuario_amater']; ?>" placeholder="Ingresar A. Materno" autofocus>
                            </div>
                        </div>

                        <div class="form-group col-md-4 mb-3">
                                <label class="form-group col text-bold" for="usuario_nombres" >Nombres:</label>
                            <div class="col">
                            <input  type="text" required class="form-control" id="usuario_nombres" name="usuario_nombres" value="<?php echo $get_id[0]['usuario_nombres']; ?>" placeholder="Ingresar Nombres" autofocus>
                            </div>
                        </div>

                        <div class="form-group col-md-4 mb-3">
                                <label class="form-group col text-bold" for="emailp">Correo:</label>
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-envelope">
                                    </i> </div>
                                    </div>
                                    <input type="email" required class="form-control" id="emailp" name="emailp" value="<?php echo $get_id[0]['emailp']; ?>" aria-describedby="emailHelp" placeholder="Email">
                                </div> 
                            <div class="input-group col"> 
                                <small id="emailOK" class="form-text text-muted"></small> 
                            </div>     
                        </div>

                        <div class="form-group col-md-4 mb-3">
                                <label class="form-group col text-bold"  for="num_celp" >Celular:</label>
                                <div class="input-group col">
                                <div class="input-group-prepend" >
                                    <div class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i>
                                    </div>
                                 </div>
                                    <input  type="text" required onkeypress='return validaNumericos(event)'  maxlength="9" class="form-control" id="num_celp" name="num_celp" value="<?php echo $get_id[0]['num_celp']; ?>" placeholder="Ingresar Celular" autofocus>

                                </div>
                            <div class="input-group col"> 
                            <small id="emailHelp" class="form-text text-muted">Solo números.</small> 
                            </div>               
                        </div>



                        <div class="form-group col-md-4 mb-3">
                                <label class="form-group col text-bold" for="codigo_gllg"  >Codigo GLL:</label>
                                <div class="input-group col">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-code" aria-hidden="true"></i>
                                    </div>
                                 </div>
                                 <input  type="text" required maxlength="5" class="form-control" id="codigo_gllg" name="codigo_gllg" value="<?php echo $get_id[0]['codigo_gllg']; ?>"  placeholder="Ingresar Código" autofocus>
                            </div>
                            <div class="input-group col"> 
                            <small id="emailHelp" class="form-text text-muted">Solo números</small> 
                            </div>   
                        </div>


                        <div class="form-group col-md-4 mb-3">
                                <label class="form-group col text-bold" for="ini_funciones" >Inicio Funciones:</label> 
                            <div class="col">
                                 <input class="form-control" required type="date" id="ini_funciones" name="ini_funciones" value="<?php echo $get_id[0]['ini_funciones']; ?>" placeholder= "Seleccionar Fecha de Inicio" type="text" />
                            </div>     
                                <div class="input-group col"> 
                                    <small id="emailHelp"  class="form-text text-muted">Inicio</small> 
                                </div>         
                        </div>

                        <div class="form-group col-md-4 mb-3">
                                <label class="form-group col text-bold" for="fin_funciones" >Termino Funciones:</label>
                            <div class="col">
                                 <input class="form-control" required type="date" id="fin_funciones" name="fin_funciones" value="<?php echo $get_id[0]['fin_funciones']; ?>" placeholder= "Seleccione Fecha de Fin" type="text" />
                            </div> 
                                <div class="input-group col"> 
                                    <small id="emailHelp" class="form-text text-muted">Fin</small> 
                                </div>       
                        </div>

                        <div class="form-group col-md-4 mb-3">
                                <label class="form-group col text-bold"  for="id_status"  >Status:</label>
                                <div class="col">
                                    <select class="form-control" name="id_status" id="id_status">
                                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                                    <?php foreach($list_estado as $estado){ ?>
                                        <option value="<?php echo $estado['id_status']; ?>" <?php if (!(strcmp($estado['id_status'], $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>><?php echo $estado['nom_status'];?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                        </div>

                        <div class="form-group col-md-6 mb-3">
                                <label class="form-group col text-bold"  for="usuario_codigo"   >Usuario:</label>
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend2">@</span>
                                    </div>
                                    <input type="text" required  class="form-control" id="usuario_codigo" name="usuario_codigo" value="<?php echo $get_id[0]['usuario_codigo']; ?>" placeholder="Ingresar Usuario" aria-describedby="inputGroupPrepend2" required>
                                </div>
                                <div class="input-group col"> 
                                <small id="emailHelp" class="form-text text-muted">Recomendación: p.ejemplo</small> 
                                </div> 
                        </div>
                  
                        
                        <div class="form-group col-md-6 mb-3">
                                <label class="form-group col text-bold"   for="usuario_password"    >Clave:</label>
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"  id="inputGroupPrepend2"><i class="fa fa-key" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="password"  required  class="form-control" id="usuario_password" name="usuario_password" value="<?php echo $get_id[0]['usuario_password']; ?>" placeholder="Ingresar Clave " aria-describedby="inputGroupPrepend2" required>
                                </div>
                                <div class="input-group col"> 
                                    <small id="emailHelp"  class="form-text text-muted">Puede usar</small> 
                                </div> 
                        </div>


                        <div class="form-group col-md-6 mb-3">
                                <label class="form-group col text-bold" for="artes"  >Week Snappy Artes:</label>
                            <div class="col">
                            <input  type="number" required class="form-control" value="<?php echo $get_id[0]['artes']; ?>" id="artes" name="artes" min="1" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Ingresar Artes" autofocus>
                            </div>
                        </div>


                        <div class="form-group col-md-6 mb-3">
                                <label class="form-group col text-bold"  for="redes"   >Week Snappy Redes:</label>
                            <div class="col">
                            <input  type="number" required class="form-control" id="redes" name="redes" value="<?php echo $get_id[0]['redes']; ?>"  min="1" maxlength="3"   oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"  placeholder="Ingresar Redes" autofocus>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label class="col-sm-3 control-label text-bold"  for="observaciones"  >Observaciones: </label>
                        </div>
                        <div class="col-sm-10">
                            <textarea  rows="4" required class="form-control" id="observaciones" name="observaciones"  placeholder="Escribir observación" ><?php echo $get_id[0]['observaciones']; ?></textarea>
                        </div>


            </div>  	           	                	        
        </div> 


        <div class="modal-footer">
        <input name="id_usuario" type="hidden" class="form-control" id="id_usuario" value="<?php echo $get_id[0]['id_usuario']; ?>">
            <button type="submit" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..." autocomplete="off">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
            </button>
            
        </div>
    </form>
</div>


                            <script type="text/javascript">
                            $(document).ready(function() {
                                $("form").keypress(function(e) {
                                    if (e.which == 13) {
                                        return false;
                                    }
                                });
                            });
                            </script>


                <script>
                document.getElementById('emailp').addEventListener('input', function() {
                    campo = event.target;
                    valido = document.getElementById('emailOK');
                        
                    emailRegex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
                    //Se muestra un texto a modo de ejemplo, luego va a ser un icono
                    if (emailRegex.test(campo.value)) {
                    valido.innerHTML  = " <div class='valid-feedback'> válido </div> ";      
                    } else {
                    valido.innerHTML = "<div class='invalid-feedback'>incorrecto.</div>";  
                    }
                });
                </script>









