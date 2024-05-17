<form id="formulario_foto" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" style="position: relative;">&times;</button>
        <h5 class="modal-title" id="exampleModalLabel" ><b>CARGAR FOTOS</b></h5>
        <div class="col-md-12 row">       
            <div class="form-group col-md-6">                
                <h5><b>Alumno(a): </b><?php echo $get_id[0]['Apellido_Paterno']."&nbsp".$get_id[0]['Apellido_Materno'].",&nbsp".$get_id[0]['Nombre']; ?></h5>
                <h5><b>Especialidad: </b><?php echo $get_id[0]['Especialidad']; ?></h5>
            </div>
            <div class="form-group col-md-6">
                <h5><b>Código: </b><span><?php echo $get_id[0]['Codigo']; ?></span></h5>
            </div>                
        </div>
    </div>

    <div class="modal-body" >
        <div class="col-md-12 row">  
            <div class="row">                
                <div class="col-md-3 col-sm-12">
                    <label class="text-bold">D01 - Foto Fotocheck:<sup style="color: #C00000;">(*)</sup> </label>
                </div>        
                <?php if($get_id[0]['cargo_envio']==""){ ?>        
                    <div class="col-md-8 col-sm-12">
                        <button type="button" onclick="Abrir('foto_fotocheck_2')">Seleccionar archivo</button>
                        <input type="file" id="foto_fotocheck_2" name="foto_fotocheck_2" onchange="Nombre_Archivo_2(this,'span_foto_fotocheck_2')" style="display: none">
                        <span id="span_foto_fotocheck_2"><?php if($get_id[0]['foto_fotocheck_2']!=""){ echo $get_id[0]['nom_foto_fotocheck_2']; }else{ echo "No se eligió archivo"; } ?></span>
                    </div>
                <?php }else{?>
                    <div class="col-md-8 col-sm-12">
                        <span id="span_foto_fotocheck_2"><?php if($get_id[0]['foto_fotocheck_2']!=""){ echo $get_id[0]['nom_foto_fotocheck']; }else{ echo "No se eligió archivo"; } ?></span>
                    </div>  
                <?php }   ?>

                <?php if($get_id[0]['foto_fotocheck_2']!=""){ ?>
                    <div id="i_2" class="col-md-1 col-sm-12">
                        <a href="<?= site_url('AppIFV/Descargar_Foto_Fotocheck') ?>/<?php echo $get_id[0]['id_fotocheck'] ?>/2" title="Descargar Imágen"> 
                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                        </a> 
                        <?php if($get_id[0]['cargo_envio'] == ""){ ?>
                            <a href="javascript:void(0);" title="Eliminar" onclick="Eliminar_Foto_Fotocheck('<?php echo $get_id[0]['id_fotocheck'] ?>',2)" id="delete" role="button">
                                <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                            </a>
                        <?php }  ?>
                    </div>
                <?php } ?> 
            </div>

            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <label class="text-bold">D00 - Foto Sistema:&nbsp</label>
                </div>
                <?php if($get_id[0]['cargo_envio']==""){ ?>
                    <div class="col-md-8 col-sm-12">
                        <button type="button" onclick="Abrir('foto_fotocheck')">Seleccionar archivo</button>
                        <input type="file" id="foto_fotocheck" name="foto_fotocheck" onchange="Nombre_Archivo_1(this,'span_foto_fotocheck')" style="display: none">
                        <span id="span_foto_fotocheck"><?php if($get_id[0]['foto_fotocheck']!=""){ echo $get_id[0]['nom_foto_fotocheck']; }else{ echo "No se eligió archivo"; } ?></span>          
                    </div>   
                <?php }else{?>
                    <div class="col-md-8 col-sm-12">
                        <span id="span_foto_fotocheck"><?php if($get_id[0]['foto_fotocheck']!=""){ echo $get_id[0]['nom_foto_fotocheck']; }else{ echo "No se eligió archivo"; } ?></span>
                    </div>  
                <?php }   ?>

                <?php if($get_id[0]['foto_fotocheck']!=""){ ?>
                    <div id="i_1" class="col-md-1 col-sm-12">
                        <a href="<?= site_url('AppIFV/Descargar_Foto_Fotocheck') ?>/<?php echo $get_id[0]['id_fotocheck'] ?>/1" title="Descargar Imágen"> 
                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                        </a> 
                        <?php if($get_id[0]['cargo_envio'] ==  ""){ ?>
                            <a href="javascript:void(0);" title="Eliminar" onclick="Eliminar_Foto_Fotocheck('<?php echo $get_id[0]['id_fotocheck'] ?>',1)" id="delete" role="button">
                                <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                            </a>
                        <?php }  ?>
                    </div>
                <?php } ?> 
            </div>

            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <label class="text-bold">D01 - Foto (con Fecha): </label>
                </div>
                <?php if($get_id[0]['cargo_envio']==""){ ?>
                    <div class="col-md-8 col-sm-12">
                        <button type="button" onclick="Abrir('foto_fotocheck_3')">Seleccionar archivo</button>
                        <input type="file" id="foto_fotocheck_3" name="foto_fotocheck_3" onchange="Nombre_Archivo_3(this,'span_foto_fotocheck_3')" style="display: none">
                        <span id="span_foto_fotocheck_3"><?php if($get_id[0]['foto_fotocheck_3']!=""){ echo $get_id[0]['nom_foto_fotocheck_3']; }else{ echo "No se eligió archivo"; } ?></span>
                    </div>  
                <?php }else{?>
                    <div class="col-md-8 col-sm-12">
                        <span id="span_foto_fotocheck_3"><?php if($get_id[0]['foto_fotocheck_3']!=""){ echo $get_id[0]['nom_foto_fotocheck_3']; }else{ echo "No se eligió archivo"; } ?></span>
                    </div>  
                <?php }   ?>
                 

                <?php if($get_id[0]['foto_fotocheck_3']!=""){ ?>
                    <div id="i_3" class="col-md-1 col-sm-12">
                        <a href="<?= site_url('AppIFV/Descargar_Foto_Fotocheck') ?>/<?php echo $get_id[0]['id_fotocheck'] ?>/3" title="Descargar Imágen"> 
                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                        </a> 
                        <?php if($get_id[0]['cargo_envio'] ==  ""){ ?>
                            <a href="javascript:void(0);" title="Eliminar" onclick="Eliminar_Foto_Fotocheck('<?php echo $get_id[0]['id_fotocheck'] ?>',3)" id="delete" role="button">
                                <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                            </a>
                        <?php }  ?>
                    </div>
                <?php } ?> 
            </div>  
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_fotocheck" name="id_fotocheck" value="<?php echo $get_id[0]['id_fotocheck']; ?>">
        <input type="hidden" id="Id" name="Id" value="<?php echo $get_id[0]['Id']; ?>">
        <input type="hidden" id="actual_foto_fotocheck" name="actual_foto_fotocheck" value="<?php echo $get_id[0]['foto_fotocheck']; ?>">
        <input type="hidden" id="actual_foto_fotocheck_2" name="actual_foto_fotocheck_2" value="<?php echo $get_id[0]['foto_fotocheck_2']; ?>">
        <input type="hidden" id="actual_foto_fotocheck_3" name="actual_foto_fotocheck_3" value="<?php echo $get_id[0]['foto_fotocheck_3']; ?>">
        <button type="button" class="btn btn-primary" onclick="Agregar_Foto();"> 
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar 
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal"> 
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Abrir(id) { 
        var file = document.getElementById(id);
        file.dispatchEvent(new MouseEvent('click', {
            view: window,
            bubbles: true,
            cancelable: true
        }));
    }

    function Nombre_Archivo_1(element,glosa) {
        var glosa = document.getElementById(glosa);
        if(element=="") {
            glosa.innerText = "No se eligió archivo";
        } else {
            var archivoInput = document.getElementById('foto_fotocheck'); 
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.jpeg|.png|.jpg)$/i;
            
            if(!extPermitidas.exec(archivoRuta)){
                Swal({
                    title: 'Registro Denegado',
                    text: "Asegurese de ingresar foto con extensiones .jpeg, .png y .jpg.",
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
                archivoInput.value = '';
                return false;
            }else{   
                let img = new Image()
                img.src = window.URL.createObjectURL(event.target.files[0])
                img.onload = () => {
                    if(img.width === 225 && img.height === 225){
                        glosa.innerText = element.files[0].name;
                    }else{
                        Swal({
                            title: 'Registro Denegado',
                            text: "Asegurese de ingresar foto con dimensión de 225x225.",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                        archivoInput.value = '';
                        return false;
                    }                
                }
            }
        }
    }

    function Nombre_Archivo_2(element,glosa) {
        var glosa = document.getElementById(glosa);
        if(element=="") {
            glosa.innerText = "No se eligió archivo";
        } else {
            var archivoInput = document.getElementById('foto_fotocheck_2'); 
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.jpeg|.png|.jpg)$/i;
            
            if(!extPermitidas.exec(archivoRuta)){
                Swal({
                    title: 'Registro Denegado',
                    text: "Asegurese de ingresar foto con extensiones .jpeg, .png y .jpg.",
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
                archivoInput.value = '';
                return false;
            }else{   
                glosa.innerText = element.files[0].name;
                /*let img = new Image()
                img.src = window.URL.createObjectURL(event.target.files[0])
                img.onload = () => {
                    if(img.width === 225 && img.height === 225){
                        glosa.innerText = element.files[0].name;
                    /*}else{
                        Swal({
                            title: 'Registro Denegado',
                            text: "Asegurese de ingresar foto con dimensión de 225x225.",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                        archivoInput.value = '';
                        return false;
                    }                
                }*/
            }
        }
    }

    function Nombre_Archivo_3(element,glosa) {
        var glosa = document.getElementById(glosa);
        if(element=="") {
            glosa.innerText = "No se eligió archivo";
        } else {
            var archivoInput = document.getElementById('foto_fotocheck_3'); 
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.jpeg|.png|.jpg)$/i;
            
            if(!extPermitidas.exec(archivoRuta)){
                Swal({
                    title: 'Registro Denegado',
                    text: "Asegurese de ingresar foto con extensiones .jpeg, .png y .jpg.",
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
                archivoInput.value = '';
                return false;
            }else{   
                glosa.innerText = element.files[0].name;
            }
        }
    }

    function Eliminar_Foto_Fotocheck(id_fotocheck,op){
        Cargando();

        var tipo_excel = $('#tipo_excel').val();
        var url="<?php echo site_url(); ?>AppIFV/Eliminar_Foto_Fotocheck";
        
        $.ajax({
            type:"POST",
            url:url,
            data: {'id_fotocheck':id_fotocheck,'op':op},
            success:function () {
                $('#i_'+op).remove()    
                Lista_Fotocheck_Alumnos(tipo_excel);                       
            }
        });
    }   
    
    function Agregar_Foto() {
        Cargando();

        var tipo_excel = $('#tipo_excel').val();
        var dataString = new FormData(document.getElementById('formulario_foto'));
        var url="<?php echo site_url(); ?>AppIFV/Guardar_Foto";

        if (Valida_Agregar_Foto()){
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡Existe una foto con el mismo nombre!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });                                
                    }else{
                        Lista_Fotocheck_Alumnos(tipo_excel);
                        $("#acceso_modal_mod .close").click()
                    }                              
                }
            });
        }
    }

    function Valida_Agregar_Foto() {
        if($('#actual_foto_fotocheck_2').val().trim() === '') {
            if($('#foto_fotocheck_2').val().trim() === '') {
                Swal(
                    'Ups!',
                    'Debe adjuntar D01 - Foto Fotocheck.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        return true;
    }
</script>

