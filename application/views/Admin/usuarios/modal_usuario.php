
<div class="modal-content">
    <form class="form-horizontal" id="from_foto" method="POST" enctype="multipart/form-data" action="<?= site_url('Snappy/Insert_Usuario')?>"  class="formulario">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        
        <div class="modal-body" style="max-height:700px; overflow:auto;">
            <div class="col-md-12 row">
                      <!--      -----------------------------              -->
                <div class="form-group col-md-2">
                    <label class="col-sm-3 text-bold">Perfil:</label>
                </div>
                
                <div class="form-group col-md-10">
                    <select required class="form-control" name="id_nivel" id="id_nivel" >
                    <option value="0">Seleccione</option>
                    <?php foreach($list_nivel as $tipo){ ?>
                        <option value="<?php echo $tipo['id_nivel']; ?>"><?php echo $tipo['nom_nivel'];?></option>
                    <?php } ?>
                    </select>
                </div>
                    <!--         ----------------------------            -->
                        <div class="form-group col-md-4 mb-3">
                                <label class="form-group col text-bold">Apellido Paterno:</label>
                            <div class="col">
                                <input  type="text" required class="form-control" id="usuario_apater" name="usuario_apater" placeholder="Ingresar A. Paterno" autofocus>

                            </div>
                        </div>
                        
                        <div class="form-group col-md-4 mb-3">
                                <label class="form-group col text-bold">Apellido Materno:</label>
                            <div class="col">
                            <input  type="text" required class="form-control" id="usuario_amater" name="usuario_amater" placeholder="Ingresar A. Materno" autofocus>
                            </div>
                        </div>

                        <div class="form-group col-md-4 mb-3">
                                <label class="form-group col text-bold">Nombres:</label>
                            <div class="col">
                            <input  type="text" required class="form-control" id="usuario_nombres" name="usuario_nombres" placeholder="Ingresar Nombres" autofocus>
                            </div>
                        </div>

                        <div class="form-group col-md-4 mb-3">
                                <label class="form-group col text-bold" for="emailp" >Correo:</label>
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-envelope">
                                    </i> </div>
                                    </div>
                                    <input type="email"  required class="form-control"  id="emailp" name="emailp" aria-describedby="emailHelp" placeholder="Email">
                                </div> 
                            <div class="input-group col"> 
                                <small id="emailOK" class="form-text text-muted"></small> 
                            </div>     
                        </div>

                        <div class="form-group col-md-4 mb-3">
                                <label class="form-group col text-bold">Celular:</label>
                                <div class="input-group col">
                                <div class="input-group-prepend" >
                                    <div class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i>
                                    </div>
                                 </div>
                                    <input  type="text" required maxlength="9" class="form-control" id="num_celp" name="num_celp" maxlength="9" placeholder="Ingresar Celular" autofocus>

                                </div>
                            <div class="input-group col"> 
                            <small id="emailHelp" class="form-text text-muted">Solo números.</small> 
                            </div>               
                        </div>



                        <div class="form-group col-md-4 mb-3">
                                <label class="form-group col text-bold">Codigo GLL:</label>
                                <div class="input-group col">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-code" aria-hidden="true"></i>
                                    </div>
                                 </div>
                                 <input  type="text" required maxlength="5" class="form-control" id="codigo_gllg" name="codigo_gllg" placeholder="Ingresar Código" autofocus>
                            </div>
                            <div class="input-group col"> 
                            <small id="emailHelp" class="form-text text-muted">Solo números</small> 
                            </div>   
                        </div>


                        <div class="form-group col-md-4 mb-3">
                                <label class="form-group col text-bold">Inicio Funciones:</label> 
                            <div class="col">
                                 <input class="form-control" required type="date" id="ini_funciones" name="ini_funciones" placeholder= "Seleccionar Fecha de Inicio" type="text" />
                            </div>     
                                <div class="input-group col"> 
                                    <small id="emailHelp" class="form-text text-muted">Inicio</small> 
                                </div>         
                        </div>

                        <div class="form-group col-md-4 mb-3">
                                <label class="form-group col text-bold">Termino Funciones:</label>
                            <div class="col">
                                 <input class="form-control" required type="date" id="fin_funciones" name="fin_funciones" placeholder= "Seleccione Fecha de Fin" type="text" />
                            </div> 
                                <div class="input-group col"> 
                                    <small id="emailHelp" class="form-text text-muted">Fin</small> 
                                </div>       
                        </div>

                        <div class="form-group col-md-4 mb-3">
                                <label class="form-group col text-bold">Status:</label>
                            <div class="col">
                            <select class="form-control" name="id_status" id="id_status">
                            <option value="0">Seleccione</option>
                            <?php foreach($list_estado as $estado){ ?>
                                <option value="<?php echo $estado['id_status']; ?>"><?php echo $estado['nom_status'];?></option>
                            <?php } ?>
                            </select>
                        </div>
                        </div>

                        <div class="form-group col-md-6 mb-3">
                                <label class="form-group col text-bold" for="usuario_codigo" >Usuario:</label>
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend2">@</span>
                                    </div>
                                    <input type="text" required class="form-control" id="usuario_codigo" name="usuario_codigo" placeholder="Ingresar Usuario" aria-describedby="inputGroupPrepend2" required>
                                </div>
                                <div class="input-group col"> 
                                <small id="emailHelp" class="form-text text-muted">Recomendación: p.ejemplo</small> 
                                </div> 
                        </div>
                  
                        
                        <div class="form-group col-md-6 mb-3">
                                <label class="form-group col text-bold">Clave:</label>
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend2"><i class="fa fa-key" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="password" required class="form-control" id="usuario_password" name="usuario_password" placeholder="Ingresar Clave " aria-describedby="inputGroupPrepend2" required>
                                </div>
                                <div class="input-group col"> 
                                    <small id="emailHelp" class="form-text text-muted">Puede usar</small> 
                                </div> 
                        </div>


                        <div class="form-group col-md-6 mb-3">
                                <label class="form-group col text-bold">Week Snappy Artes:</label>
                            <div class="col">
                            <input  type="number" required class="form-control" id="artes" name="artes" min="1" maxlength="3"   oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"   placeholder="Ingresar Artes" autofocus>
                            </div>
                        </div>


                        <div class="form-group col-md-6 mb-3">
                                <label class="form-group col text-bold">Week Snappy Redes:</label>
                            <div class="col">
                            <input  type="number" required class="form-control" id="redes" name="redes" min="1" maxlength="3"   oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"   placeholder="Ingresar Redes" autofocus>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label class="col-sm-3 control-label text-bold">Observaciones: </label>
                        </div>
                        <div class="col-sm-10">
                            <textarea name="observaciones" required rows="4" class="form-control" id="observaciones"></textarea>
                        </div>


            </div>  	           	                	        
        </div> 


        <div class="modal-footer">
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
                    valido.innerText = "válido";
                    } else {
                    valido.innerText = "incorrecto";
                    
                    }
                });
                </script>


