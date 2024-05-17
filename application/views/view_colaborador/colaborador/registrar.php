<?php $this->load->view($vista.'/header'); ?>
<?php $this->load->view($vista.'/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Colaborador (Nuevo)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group"> 
                        <a type="button" href="<?= site_url('Colaborador/Colaborador') ?>/<?= $get_id[0]['id_sede']; ?>">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid"> 
        <form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Perfil: </label>
                    <select class="form-control" id="id_perfil" name="id_perfil">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_perfil as $list){ ?> 
                            <option value="<?php echo $list['id_perfil']; ?>"><?php echo $list['nom_perfil']; ?></option>    
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold" title="Cargo Fotocheck">Car.&nbsp;F.:</label>
                    <select class="form-control" id="id_cargo" name="id_cargo">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_cargo as $list){ ?> 
                            <option value="<?php echo $list['id_cf']; ?>"><?php echo $list['nom_cf']; ?></option>    
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Apellido Paterno: </label>
                    <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" placeholder="Apellido Paterno">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Apellido Materno: </label>
                    <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" placeholder="Apellido Materno">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Nombre(s): </label>
                    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">DNI: </label>
                    <input type="text" class="form-control solo_numeros" id="dni" name="dni" placeholder="DNI" maxlength="8">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Correo Personal: </label>
                    <input type="text" class="form-control" id="correo_personal" name="correo_personal" placeholder="Correo Personal">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Correo Corporativo: </label>
                    <input type="text" class="form-control" id="correo_corporativo" name="correo_corporativo" placeholder="Correo Corporativo">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Celular: </label>
                    <input type="text" class="form-control solo_numeros" id="celular" name="celular" placeholder="Celular" maxlength="9">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Fec. Nacimiento: </label>
                    <input type="date" class="form-control" id="fec_nacimiento" name="fec_nacimiento">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-4">
                    <label class="control-label text-bold">Dirección: </label>
                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Departamento: </label>
                    <select class="form-control" name="id_departamento" id="id_departamento" onchange="Traer_Provincia_Colaborador();">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_departamento as $list){ ?>
                            <option value="<?php echo $list['id_departamento']; ?>"><?php echo $list['nombre_departamento'];?></option>
                        <?php } ?>
                    </select>  
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Provincia: </label>
                    <select class="form-control" name="id_provincia" id="id_provincia" onchange="Traer_Distrito_Colaborador();">
                        <option value="0">Seleccione</option>
                    </select> 
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Distrito: </label>
                    <select class="form-control" name="id_distrito" id="id_distrito">
                        <option value="0">Seleccione</option>
                    </select>  
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Código: </label>
                    <input type="text" class="form-control" id="codigo_gll" name="codigo_gll" placeholder="Código" maxlength="5">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Nickname: </label>
                    <input type="text" class="form-control" id="nickname" name="nickname" placeholder="Nickname">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Usuario: </label>
                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Clave: </label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Clave">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-4">
                    <label class="control-label text-bold">Banco: </label>
                    <input type="text" class="form-control" id="banco" name="banco" placeholder="Banco">
                </div>

                <div class="form-group col-md-4">
                    <label class="control-label text-bold">Cuenta: </label>
                    <input type="text" class="form-control solo_numeros" id="cuenta_bancaria" name="cuenta_bancaria" placeholder="Cuenta">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-12">
                    <label class="control-label text-bold">Foto: </label>
                    <input type="file" id="foto" name="foto" onchange="validarExt();">
                </div>
            </div>
            
            <div class="modal-footer">
                <input type="hidden" name="id_sede" value="<?= $get_id[0]['id_sede']; ?>">
                <button type="button" class="btn btn-primary" onclick="Insert_Colaborador();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
                <a type="button" class="btn btn-default" href="<?= site_url('Colaborador/Colaborador') ?>/<?= $get_id[0]['id_sede']; ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#colaboradores").addClass('active');
        $("#hcolaboradores").attr('aria-expanded', 'true');
        $("#colaboradores_lista").addClass('active');
		document.getElementById("rcolaboradores").style.display = "block";
    });

    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Traer_Provincia_Colaborador(){
        Cargando();
        
        var id_departamento = $("#id_departamento").val();
        var url="<?php echo site_url(); ?>Colaborador/Traer_Provincia_Colaborador";

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
        var url="<?php echo site_url(); ?>Colaborador/Traer_Distrito_Colaborador";

        $.ajax({
            type:"POST",
            url: url,
            data:{'id_provincia':id_provincia},
            success:function (data) {
                $("#id_distrito").html(data);
            }
        });       
    }

    function validarExt(){
        var archivoInput = document.getElementById('foto'); 
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
                    return true;
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

    function Insert_Colaborador() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "<?php echo site_url(); ?>Colaborador/Insert_Colaborador";

        if (Valida_Insert_Colaborador()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    if(data=="error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡El usuario ya está en uso!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        window.location = "<?php echo site_url(); ?>Colaborador/Colaborador/<?= $get_id[0]['id_sede']; ?>";
                    }
                }
            });
        }
    }

    function Valida_Insert_Colaborador() {
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