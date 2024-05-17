<form id="formulario_centroe" method="POST" enctype="multipart/form-data" class="formulario">
    
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Centro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Referencia:</label>
                <input type="text" class="form-control" id="referenciae" name="referenciae" value="<?php echo $get_id[0]['referencia']; ?>">
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Nombre Comercial:</label>
                <input type="text" class="form-control" id="nom_comerciale" name="nom_comerciale" value="<?php echo $get_id[0]['nom_comercial']; ?>">
            </div>


            <div class="form-group col-md-4">
                <label class="control-label text-bold">Convenio:</label>
                <input type="text" class="form-control" id="convenioe" name="convenioe" value="<?php echo $get_id[0]['convenio']; ?>">
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Empresa:</label>
                <input type="text" class="form-control" id="empresae" name="empresae" value="<?php echo $get_id[0]['empresa']; ?>">
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Ruc:</label>
                <input type="text" class="form-control" maxlength="11" id="ruce" name="ruce" value="<?php echo $get_id[0]['ruc']; ?>">
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Teléfono:</label>
                <input type="text" class="form-control" maxlength="9" id="telefonoe" name="telefonoe" value="<?php echo $get_id[0]['telefono']; ?>">
            </div>
        </div>

        <div id="div_direccione" class="col-md-12 row">
            <?php foreach($list_direccion as $dir){?> 
                <div class="form-group col-md-5">
                    <label class="control-label text-bold">Dirección:</label>
                    <input readonly type="text" class="form-control" value="<?php echo $dir['direccion'] ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Departamento:</label>
                    <select disabled class="form-control" >
                        <option value="0" selected><?php echo $dir['nombre_departamento'] ?></option>
                        
                    </select>
                </div>

                <div  class="form-group col-md-2">
                    <label class="control-label text-bold">Provincia:</label>
                    <select disabled id="provincia_1" name="provincia_1" class="form-control">
                        <option value="0" selected ><?php echo $dir['nombre_provincia'] ?></option>
                    </select>
                </div>

                <div  class="form-group col-md-2">
                    <label class="control-label text-bold">Distrito:</label>
                    <select disabled id="distrito_1" name="distrito_1" class="form-control">
                        <option value="0" selected ><?php echo $dir['nombre_distrito'] ?></option>
                    </select>
                </div>

                <div class="form-group col-md-1">
                    <br>
                    <div class="row">
                        &nbsp;&nbsp;
                        <input type="checkbox" disabled <?php if($dir['cp']==1){ echo "checked"; } ?> value="1" class="mt-1"> 
                        &nbsp;&nbsp;
                        <label class="control-label text-bold">CP</label>
                        &nbsp;&nbsp;
                        <a href="#" class="" title="Eliminar" onclick="Eliminar_Direccion('<?php echo $dir['id_centro_direccion']; ?>')" role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;" width="22" height="22"/></a>
                    </div>
                </div> 
                
            <?php }?>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-5">
                <label class="control-label text-bold">Dirección:</label>
                <input type="text" class="form-control" id="direccion" name="direccion">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Departamento:</label>
                <select id="departamento" name="departamento" class="form-control" onchange="Provincia();">
                    <option value="0" >Seleccione</option>
                    <?php foreach($list_departamento as $list){ ?>
                        <option value="<?php echo $list['id_departamento']; ?>"><?php echo $list['nombre_departamento'];?></option>
                    <?php } ?>
                </select>
            </div>

            <div id="mprovincia" class="form-group col-md-2">
                <label class="control-label text-bold">Provincia:</label>
                <select id="provincia" name="provincia" class="form-control" onchange="Distrito();">
                    <option value="0" >Seleccione</option>
                </select>
            </div>

            <div id="mdistrito" class="form-group col-md-2">
                <label class="control-label text-bold">Distrito:</label>
                <select id="distrito" name="distrito" class="form-control">
                    <option value="0" >Seleccione</option>
                </select>
            </div>

            <div class="form-group col-md-1">
                <br>
                <div class="row">
                    &nbsp;&nbsp;
                    <input type="checkbox" id="cp" name="cp" value="1" class="mt-1"> 
                    &nbsp;&nbsp;
                    <label class="control-label text-bold">CP</label>
                </div>
            </div>
        </div>

        <div id="div_2" class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Otra Dirección</label>
            </div>

            <div class="form-group col-md-2">
                <a onclick="Agregar_Direccione()" title="Agregar">
                    <i><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="45" height="45" version="1.1" viewBox="0 0 512 512" enable-background="new 0 0 512 512"><g><g><path d="M256,11C120.9,11,11,120.9,11,256s109.9,245,245,245s245-109.9,245-245S391.1,11,256,11z M256,460.2    c-112.6,0-204.2-91.6-204.2-204.2S143.4,51.8,256,51.8S460.2,143.4,460.2,256S368.6,460.2,256,460.2z"/><path d="m357.6,235.6h-81.2v-81.2c0-11.3-9.1-20.4-20.4-20.4-11.3,0-20.4,9.1-20.4,20.4v81.2h-81.2c-11.3,0-20.4,9.1-20.4,20.4s9.1,20.4 20.4,20.4h81.2v81.2c0,11.3 9.1,20.4 20.4,20.4 11.3,0 20.4-9.1 20.4-20.4v-81.2h81.2c11.3,0 20.4-9.1 20.4-20.4s-9.1-20.4-20.4-20.4z"/></g></g></svg></i>
                </a>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-7">
                <label class="control-label text-bold">Web:</label>
                <input type="text" class="form-control" id="webe" name="webe" value="<?php echo $get_id[0]['web']; ?>">
            </div>

            <div class="form-group col-md-5">
            </div>

            <div class="form-group col-md-12 mt-3">
                <label class="control-label text-bold">Centros Prácticas para:</label>
            </div>

            <!--<div class="form-group col-md-6">
                <label id="etiqueta_carrera" class="control-label text-bold">Carreras:&nbsp;&nbsp;&nbsp;</label>
                <?php foreach($list_carrera as $list){ ?>
                    <label>
                        <input type="checkbox" id="id_carrera" name="id_carrera" value="<?php echo $list['id_carrera']; ?>" class="check_carrera" onchange="Carrera(this)">
                        <span style="font-weight:normal"><?php echo $list['codigo']; ?></span>&nbsp;&nbsp;
                    </label>
                <?php } ?>
            </div>

            <div id="div_asignacion" class="form-group col-md-6">
            </div>

            <?php if($id_nivel==1 || $id_nivel==6){ ?>
                <div class="form-group col-md-4">
                    <label class="control-label text-bold">Fecha Firma:</label>
                    <input type="date" class="form-control" id="fecha_firma" name="fecha_firma" value="<?php echo $get_id[0]['fecha_firma']; ?>">
                </div>

                <div class="form-group col-md-4">
                    <label class="control-label text-bold">Validad de:</label>
                    <input type="text" class="form-control" id="val_de" name="val_de" value="<?php echo $get_id[0]['val_de']; ?>">
                </div>

                <div class="form-group col-md-4">
                    <label class="control-label text-bold">A:</label>
                    <input type="text" class="form-control" id="val_a" name="val_a" value="<?php echo $get_id[0]['val_a']; ?>">
                </div>

                <div class="form-group col-md-6">
                    <label class="control-label text-bold">Documento:</label>
                    <br>
                    <input name="documento" id="documento" type="file" size="100" required data-allowed-file-extensions='["jpeg|png|jpg|pdf|gif"]'>
                    <?php if($get_id[0]['documento']!=""){ ?>
                        <a style="cursor:pointer;" title="Documento" data-toggle="modal" data-target="#documento" data-imagen="<?php echo $get_id[0]['documento']; ?>" >
                            <i style="color:#FF0000;" class="fa fa-search mano"></i>
                        </a>
                    <?php } ?>
                </div>

                <div class="form-group col-md-6">
                    <label class="control-label text-bold">Observaciones:</label>
                    <textarea class="form-control" id="observaciones_admin" name="observaciones_admin" rows="5"><?php echo $get_id[0]['observaciones_admin']; ?></textarea>
                </div>
            <?php } ?>-->

        </div>
        
        <div id="div_especialidade" class="col-md-12 row" style="background-color:#d8d7d75c">
            <?php 
            foreach($list_especialidad as $list){?>

                <div class="form-group col-md-2" >
                    <label id="etiqueta_carrera" class="control-label text-bold"><?php echo $list['nom_tipo_especialidad']." ".$list['nom_especialidad'] ?></label><br>
                    <?php 
                        foreach($list_producto as $prod){
                            if($prod['id_tipo_especialidad']==$list['id_tipo_especialidad'] && $prod['id_especialidad']==$list['id_especialidad']){?>
                                <label>
                                    <input type="checkbox" id="id_producto" <?php if($prod['id_centro_especialidad']!=""){echo "checked"; }?> name="id_producto[]" value="<?php echo $prod['id_producto']."-".$list['id_especialidad']; ?>" class="check_carrera" >
                                    <span style="font-weight:normal"><?php echo $prod['nom_producto']; ?></span>&nbsp;&nbsp;
                                </label><br>
                            <?php }  ?>
                            
                        <?php }
                    ?>
                </div>

            <?php } ?>

            <div class="form-group col-md-12 row" >
                <div class="form-group col-md-6" >
                    <label class="control-label text-bold">Fecha Firma:</label>
                    <div class="col">
                        <input type="date" class="form-control" id="fecha_firmae" name="fecha_firmae" value="<?php echo $get_id[0]['fec_firma'] ?>">

                        <label class="control-label text-bold">Documento:</label>
                        <br>
                        <input name="documentoe" id="documentoe" type="file" size="100" required data-allowed-file-extensions='["jpeg|png|jpg|pdf|gif"]'>

                        <label class="control-label text-bold">Observaciones:</label>
                        <textarea class="form-control" id="observaciones_admine" name="observaciones_admine" rows="5"><?php echo $get_id[0]['observaciones_admin'] ?></textarea>
                    </div>
                </div>
                <div class="form-group col-md-6" >
                    <label class="control-label text-bold">Validad de:</label>
                    <div class="col">
                    <input type="text" class="form-control" id="val_dee" name="val_dee" value="<?php echo $get_id[0]['val_de'] ?>">

                        <label class="control-label text-bold">A:</label>
                        <input type="text" class="form-control" id="val_ae" name="val_ae" value="<?php echo $get_id[0]['val_a'] ?>">

                        <br>
                        <button class="btn " onclick="Cancelar_Update_Especialidad()" style="background-color:red;color:white" type="button" title="Cancelar" >Cancelar</button>


                        <button class="btn " onclick="Update_Especialidad()" style="background-color:green;color:white" type="button" title="Guardar" >Guardar</button>
                        <?php if($get_id[0]['documento']!=""){?>
                        <span>&nbsp;</span>
                            <iframe style="width:230px;height:120px" id="pdf" src="<?php echo base_url().$get_id[0]['documento']; ?>" > </iframe>
                        <?php }?>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Observaciones:</label>
                <textarea class="form-control" id="observacionese" name="observacionese" rows="5"><?php echo $get_id[0]['observaciones']; ?></textarea>
            </div>
        </div>
    </div> 
    
    <div class="modal-footer">
        <input type="hidden" id="id_centro" name="id_centro" value="<?php echo $get_id[0]['id_centro']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Centro();" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $('#ruce').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('#telefonoe').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    function Provincia(){
        var url = "<?php echo site_url(); ?>AppIFV/Busca_Provincia";
        var id_departamento = $('#departamento').val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_departamento':id_departamento},
            success: function(data){
                $('#mprovincia').html(data);
            }
        });
    }

    function Distrito(){
        var url = "<?php echo site_url(); ?>AppIFV/Busca_Distrito";
        var id_departamento = $('#departamento').val();
        var id_provincia = $('#provincia').val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_departamento':id_departamento,'id_provincia':id_provincia},
            success: function(data){
                $('#mdistrito').html(data);
            }
        });
    }

    function Update_Centro(){
        var dataString = $("#formulario_centroe").serialize();
        var url="<?php echo site_url(); ?>AppIFV/Update_Centro";
        if (Valida_Centro()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡La última dirección ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            'Actualización Exitosa!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>AppIFV/Centro";
                        });
                    }
                    
                }
            });
        }
    }

    function Valida_Centro() {
        if($('#empresae').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#ruce').val() == '') {
            Swal(
                'Ups!',
                'Debe ingresar RUC.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#direccion').val().trim() != '' || $('#departamento').val() != '0' || $('#provincia').val() != '0' || $('#distrito').val() != '0') {
            if($('#direccion').val().trim() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar dirección.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#departamento').val() === '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar departamento.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#provincia').val() === '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar provincia.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#distrito').val() === '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar distrito.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        return true;
    }

    function Update_Especialidad(){
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
        var dataString = new FormData(document.getElementById('formulario_centroe'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Especialidad";
        if (Valida_Especialidad()) {
            Swal({
                title: 'Actualizar Especialidades',
                text: "¿Realmente desea actualizar especialidades?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type:"POST",
                        url: url,
                        data:dataString,
                        processData: false,
                        contentType: false,
                        success:function (data) {
                            swal.fire(
                                'Actualización Exitosa!',
                                'Haga clic en el botón!',
                                'success'
                                ).then(function() {
                                    var url2="<?php echo site_url(); ?>AppIFV/List_Guardado_Especialidad";
                                    var dataString2 = new FormData(document.getElementById('formulario_centroe'));
                                    
                                    $.ajax({
                                        type:"POST",
                                        url: url2,
                                        data:dataString2,
                                        processData: false,
                                        contentType: false,
                                        success:function (data) {
                                        $('#div_especialidade').html(data);
                                        //$("#ModalUpdate .close").click()
                                    }
                                    });
                                    
                                });
                            
                        }
                    });
                }
            })

            
        }
    }

    function Valida_Especialidad() {
        if($('#fecha_firmae').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar fecha firma.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#val_dee').val() == '') {
            Swal(
                'Ups!',
                'Debe ingresar Valida de.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#val_ae').val() == '') {
            Swal(
                'Ups!',
                'Debe ingresar Valida a.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Cancelar_Update_Especialidad(){
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
        var url2="<?php echo site_url(); ?>AppIFV/List_Guardado_Especialidad";
        var dataString2 = new FormData(document.getElementById('formulario_centroe'));
        
        $.ajax({
            type:"POST",
            url: url2,
            data:dataString2,
            processData: false,
            contentType: false,
            success:function (data) {
            $('#div_especialidade').html(data);
            //$("#ModalUpdate .close").click()
        }
        });
    }

    function Agregar_Direccione() {
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

        var dataString = new FormData(document.getElementById('formulario_centroe'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Direccion_Centro";
        if (Valida_Direccione()) {
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
                            text: "¡La dirección ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        var url2="<?php echo site_url(); ?>AppIFV/List_Guardado_Direccion";
                        var dataString2 = new FormData(document.getElementById('formulario_centroe'));
                        
                        $.ajax({
                            type:"POST",
                            url: url2,
                            data:dataString2,
                            processData: false,
                            contentType: false,
                            success:function (data) {
                            $('#div_direccione').html(data);
                            //$("#ModalUpdate .close").click()
                            document.getElementById("direccion").value = "";
                            document.getElementById("departamento").value = "0";
                            document.getElementById("provincia").value = "0";
                            document.getElementById("distrito").value = "0";
                            $("#cp").prop('checked', false); 
                        }
                        });
                    }
                    
                    
                    
                }
            });
        }
        
    }

    function Valida_Direccione() {
        if($('#direccion').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar dirección.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#departamento').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar departamento.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#provincia').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar provincia.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#distrito').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar distrito.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Eliminar_Direccion(id) {
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
        var id_centro_direccion=id;
        var url="<?php echo site_url(); ?>AppIFV/Delete_Direccion";
        $.ajax({
            type:"POST",
            url: url,
            data:{'id_centro_direccion':id_centro_direccion},
            success:function () {
                var url2="<?php echo site_url(); ?>AppIFV/List_Guardado_Direccion";
                var dataString2 = new FormData(document.getElementById('formulario_centroe'));
                
                $.ajax({
                    type:"POST",
                    url: url2,
                    data:dataString2,
                    processData: false,
                    contentType: false,
                    success:function (data) {
                    $('#div_direccione').html(data);
                }
                });
        }
        });
        
    }
</script>
