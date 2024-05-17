<?php $this->load->view($vista.'/header'); ?>
<?php $this->load->view($vista.'/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Editar Colaborador</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group"> 
                        <a type="button" href="<?= site_url('Colaborador/Detalle_Colaborador') ?>/<?= $get_id[0]['id_colaborador']; ?>/<?= $get_sede[0]['id_sede']; ?>">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt=""> 
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
            <div class="col-lg-12 row">
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Perfil:</label>
                    <select class="form-control" id="id_perfil" name="id_perfil">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_perfil as $list){ ?> 
                            <option value="<?= $list['id_perfil']; ?>" <?php if($get_id[0]['id_perfil']==$list['id_perfil']){ echo "selected"; } ?>>
                                <?= $list['nom_perfil']; ?>
                            </option>    
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-lg-2">
                    <label class="control-label text-bold" title="Cargo Fotocheck">Car.&nbsp;F.:</label>
                    <select class="form-control" id="id_cargo" name="id_cargo">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_cargo as $list){ ?> 
                            <option value="<?= $list['id_cf']; ?>" <?php if($get_id[0]['id_cargo_foto']==$list['id_cf']){ echo "selected"; } ?>>
                                <?= $list['nom_cf']; ?>
                            </option>    
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Apellido Paterno: </label>
                    <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" placeholder="Apellido Paterno" value="<?= $get_id[0]['apellido_paterno']; ?>">
                </div>

                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Apellido Materno: </label>
                    <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" placeholder="Apellido Materno" value="<?= $get_id[0]['apellido_materno']; ?>">
                </div>

                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Nombre(s): </label>
                    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres" value="<?= $get_id[0]['nombres']; ?>">
                </div>

                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">DNI: </label>
                    <input type="text" class="form-control solo_numeros" id="dni" name="dni" placeholder="DNI" maxlength="12" value="<?= $get_id[0]['dni']; ?>">
                </div>
            </div>

            <div class="col-lg-12 row">
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Correo Personal: </label>
                    <input type="text" class="form-control" id="correo_personal" name="correo_personal" placeholder="Correo Personal" value="<?= $get_id[0]['correo_personal']; ?>">
                </div>

                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Correo Corporativo: </label>
                    <input type="text" class="form-control" id="correo_corporativo" name="correo_corporativo" placeholder="Correo Corporativo" value="<?= $get_id[0]['correo_corporativo']; ?>">
                </div>

                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Celular: </label>
                    <input type="text" class="form-control solo_numeros" id="celular" name="celular" placeholder="Celular" maxlength="9" value="<?= $get_id[0]['celular']; ?>">
                </div>

                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Fec. Nacimiento: </label>
                    <input type="date" class="form-control" id="fec_nacimiento" name="fec_nacimiento" value="<?= $get_id[0]['fec_nacimiento']; ?>">
                </div>
            </div>

            <div class="col-lg-12 row">
                <div class="form-group col-lg-4">
                    <label class="control-label text-bold">Dirección: </label>
                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección" value="<?= $get_id[0]['direccion']; ?>">
                </div>

                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Departamento: </label>
                    <select class="form-control" name="id_departamento" id="id_departamento" onchange="Traer_Provincia_Colaborador();">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_departamento as $list){ ?>
                            <option value="<?= $list['id_departamento']; ?>" <?php if($list['id_departamento']==$get_id[0]['id_departamento']){ echo "selected"; } ?>>
                                <?= $list['nombre_departamento'];?>
                            </option>
                        <?php } ?>
                    </select>  
                </div>

                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Provincia: </label>
                    <select class="form-control" name="id_provincia" id="id_provincia" onchange="Traer_Distrito_Colaborador();">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_provincia as $list){ ?>
                            <option value="<?= $list['id_provincia']; ?>" <?php if($list['id_provincia']==$get_id[0]['id_provincia']){ echo "selected"; } ?>>
                                <?= $list['nombre_provincia'];?>
                            </option>
                        <?php } ?>
                    </select> 
                </div>

                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Distrito: </label>
                    <select class="form-control" name="id_distrito" id="id_distrito">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_distrito as $list){ ?>
                            <option value="<?= $list['id_distrito']; ?>" <?php if($list['id_distrito']==$get_id[0]['id_distrito']){ echo "selected"; } ?>>
                                <?= $list['nombre_distrito'];?>
                            </option>
                        <?php } ?>
                    </select>  
                </div>
            </div>

            <div class="col-lg-12 row">
                <div class="form-group col-lg-1">
                    <label class="control-label text-bold">Código: </label>
                    <input type="text" class="form-control" id="codigo_gll" name="codigo_gll" placeholder="Código" maxlength="5" value="<?= $get_id[0]['codigo_gll']; ?>">
                </div>
                
                <div class="form-group col-lg-1">
                    <label class="control-label text-bold">Cód&nbsp;Snappy: </label>
                    <div>
                        <label for=""><?= $get_id[0]['codigo_glla']; ?></label>
                    </div>
                </div>

                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Nickname: </label>
                    <input type="text" class="form-control" id="nickname" name="nickname" placeholder="Nickname" value="<?= $get_id[0]['nickname']; ?>">
                </div>

                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Usuario: </label>
                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" value="<?= $get_id[0]['usuario']; ?>">
                </div>

                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Clave: </label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="¿Cambiar Clave?">
                </div>

                
            </div>

            <div class="col-lg-12 row">
                <div class="form-group col-lg-4">
                    <label class="control-label text-bold">Banco: </label>
                    <input type="text" class="form-control" id="banco" name="banco" placeholder="Banco" value="<?= $get_id[0]['banco']; ?>">
                </div>

                <div class="form-group col-lg-4">
                    <label class="control-label text-bold">Cuenta: </label>
                    <input type="text" class="form-control solo_numeros" id="cuenta_bancaria" name="cuenta_bancaria" placeholder="Cuenta" value="<?= $get_id[0]['cuenta_bancaria']; ?>">
                </div>
            </div>

            <div class="col-lg-12 row"> 
                <div class="form-group col-lg-4">
                    <label class="control-label text-bold">Foto: </label>
                    <div class="col">
                        <button type="button" onclick="Abrir('foto')">Seleccionar archivo</button>
                        <input type="file" id="foto" name="foto" onchange="Nombre_Archivo(this,'span_documento')" style="display: none">
                        <span id="span_documento"><?php if($get_id[0]['foto']!=""){ echo $get_id[0]['nom_documento']; }else{ echo "No se eligió archivo"; } ?></span>
                    </div>
                </div>

                <?php if($get_id[0]['foto']!=""){ ?>
                    <div class="col-lg-2">
                        <label class="text-bold" style="margin-right: 25px;">Descargar:</label>
                        <a style="cursor:pointer;" title="Descargar" class="download" type="button" onclick="Descargar_Foto_Colaborador('<?= $get_id[0]['id_colaborador']; ?>',1)">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                        </a>
                    </div>
                <?php } ?>
            </div>
            
            <div class="modal-footer">
                <input type="hidden" id="id_colaborador" name="id_colaborador" value="<?= $get_id[0]['id_colaborador'] ?>">
                <input type="hidden" id="foto_actual" name="foto_actual" value="<?= $get_id[0]['foto'] ?>">
                <input type="hidden" name="correo_personal_actual" value="<?= $get_id[0]['correo_personal']; ?>">
                <button type="button" class="btn btn-primary" onclick="Update_Colaborador();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
                <a type="button" class="btn btn-default" href="<?= site_url('Colaborador/Detalle_Colaborador') ?>/<?= $get_id[0]['id_colaborador']; ?>/<?= $get_sede[0]['id_sede']; ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#colaboradores").addClass('active');
        $("#hcolaboradores").attr('aria-expanded', 'true');
        $("#colabores_lista").addClass('active');
		document.getElementById("rcolaboradores").style.display = "block";
    });

    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Traer_Provincia_Colaborador(){
        Cargando();
        
        var id_departamento = $("#id_departamento").val();
        var url="<?= site_url(); ?>Colaborador/Traer_Provincia_Colaborador";

        $.ajax({
            type:"POST",
            url: url,
            data:{'id_departamento':id_departamento},
            success:function (data) {
                $("#id_provincia").html(data);
                $("#id_distrito").html('<option value="">Seleccione</option>');
            }
        });
    }

    function Traer_Distrito_Colaborador(){
        Cargando();
        
        var id_provincia = $("#id_provincia").val();
        var url="<?= site_url(); ?>Colaborador/Traer_Distrito_Colaborador";

        $.ajax({
            type:"POST",
            url: url,
            data:{'id_provincia':id_provincia},
            success:function (data) {
                $("#id_distrito").html(data);
            }
        });       
    }

    function Abrir(id) {
        var file = document.getElementById(id);
        file.dispatchEvent(new MouseEvent('click', {
            view: window,
            bubbles: true,
            cancelable: true
        }));
    }

    function Nombre_Archivo(element,glosa) {
        var glosa = document.getElementById(glosa);

        if(element=="") {
            glosa.innerText = "No se eligió archivo";
        } else {
            if(element.files[0].name.substr(-3)=='jpeg' || element.files[0].name.substr(-3)=='png' || element.files[0].name.substr(-3)=='jpg'){
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
            }else{
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
            }
        }
    }

    
    function Descargar_Foto_Colaborador(id){
        window.location.replace("<?php echo site_url(); ?>Colaborador/Descargar_Foto_Colaborador/"+id);
    }

    function Update_Colaborador() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url = "<?= site_url(); ?>Colaborador/Update_Colaborador";
        var id_colaborador=$('#id_colaborador').val();

        if (Valida_Update_Colaborador()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    if(data=="error"){
                        Swal({
                            title: 'Actualización Denegada',
                            text: "¡El usuario ya está en uso!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        window.location = "<?= site_url(); ?>Colaborador/Detalle_Colaborador/"+id_colaborador+"/<?= $get_sede[0]['id_sede']; ?>";
                    }
                }
            });
        }
    }

    function Valida_Update_Colaborador() {
        if ($('#id_perfil').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Perfil.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#id_cargo').val().trim() === '0') { 
            Swal(
                'Ups!',
                'Debe seleccionar Perfil.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#nombres').val().trim() === '') { 
            Swal(
                'Ups!',
                'Debe ingresar Nombres.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#apellido_paterno').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Apellido Paterno.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#apellido_materno').val().trim() === '') { 
            Swal(
                'Ups!',
                'Debe ingresar Apellido Materno.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#correo_personal').val().trim() == '') {
            Swal(
                'Ups!',
                'Debe ingresar correo personal.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#correo_personal').val().trim() != '') {
            var dominioOutlook = /@outlook\.(com|es)$/i;
            if (dominioOutlook.test($('#correo_personal').val())) {
                Swal(
                    'Ups!',
                    'No se permiten correos de Outlook como correo personal.',
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        if ($('#correo_corporativo').val().trim() != '') {
            var dominioOutlook = /@outlook\.(com|es)$/i;
            if (dominioOutlook.test($('#correo_corporativo').val())) {
                Swal(
                    'Ups!',
                    'No se permiten correos de Outlook como correo corporativo.',
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        return true;
    }
</script>

<?php $this->load->view($vista.'/footer'); ?>