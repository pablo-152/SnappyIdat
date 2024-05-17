<?php $this->load->view('view_CA/header'); ?>
<?php $this->load->view('view_CA/nav'); ?>

<style>
    .margintop{
        margin-top: 5px;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;height:80px">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Cargo (Nuevo)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo archivo" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Ca/Modal_Archivo_Cargo_Temporal') ?>" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/icono-subir.png">
                        </a>
                        <a title="Regresar" href="<?= site_url('Ca/Cargo') ?>">
                            <img src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="formulario" method="POST" enctype="multipart/form-data">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group col-lg-1 text-right">
                        <label class="control-label text-bold label_tabla margintop">De: </label>
                    </div>
                    <div class="form-group col-lg-2">
                        <?php if($_SESSION['usuario'][0]['id_nivel'] == 1 || $_SESSION['usuario'][0]['id_nivel'] == 6){ ?>
                            <select class="form-control" id="id_usuario_de" name="id_usuario_de">
                                <option value="0">Seleccione</option>
                                <?php foreach ($list_usuario as $list) { ?>
                                    <option value="<?= $list['id_usuario']; ?>"><?= $list['usuario_codigo']; ?></option>
                                <?php }?>
                            </select>
                        <?php }else{ ?>
                            <input id="id_usuario_de" name="id_usuario_de" type="hidden" value="<?= $_SESSION['usuario'][0]['id_usuario']; ?>" readonly>
                        <?php } ?>
                    </div>

                    <div class="form-group col-lg-1 text-right">
                        <label class="control-label text-bold label_tabla margintop">Estado:</label>
                    </div>
                    <div class="form-group col-lg-2">
                        <select class="form-control" disabled>
                            <option value="0">Creado</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-4 text-right">
                        <label class="control-label text-bold label_tabla margintop"></label>
                    </div>
                    <div class="form-group col-lg-1" style="width: 150px !important;">
                        <input type="text" class="form-control" title="Referencia automática" readonly style="cursor:help;background-color:#715d7436">
                    </div>
                </div>

                <div class="col-lg-12"> 
                    <div class="form-group col-lg-1 text-right">
                        <label class="control-label text-bold label_tabla margintop">Descripción:</label>
                    </div>
                    <div class="form-group col-lg-11">
                        <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Ingresar Descripción" maxlength="50" onkeypress="if(event.keyCode == 13){ Insert_Cargo(); }">
                    </div>
                </div>

                <div class="col-lg-12" style="margin-top: 15px; padding: 0px;">
                    <div class="col-lg-6" style="padding-right: 0px;">
                        <div class="col-lg-12">
                            <label class="control-label text-bold label_tabla">Para:</label>
                        </div>

                        <div class="col-lg-12" style="padding: 0px;">
                            <div class="form-group col-lg-2 text-right">
                                <label class="control-label text-bold label_tabla margintop">Empresa:</label>
                            </div>
                            <div class="form-group col-lg-4">
                                <select class="form-control" id="id_empresa_1" name="id_empresa_1" onchange="Buscar_Sede(1);">
                                    <option value="0">Seleccione</option>
                                    <?php foreach ($list_empresam as $list) { ?>
                                        <option value="<?= $list['id_empresa']; ?>"><?= $list['cod_empresa']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-lg-2 text-right">
                                <label class="control-label text-bold margintop">Sede:</label>
                            </div>
                            <div class="form-group col-lg-4">
                                <select class="form-control" id="id_sede_1" name="id_sede_1">
                                    <option value="0" selected>Seleccione</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12" style="padding: 0px;">
                            <div class="form-group col-lg-2 text-right">
                                <label class="control-label text-bold label_tabla margintop">Usuario:</label>
                            </div>
                            <div class="form-group col-lg-4">
                                <select class="form-control" id="id_usuario_1" name="id_usuario_1" onchange="Buscar_Datos_Usuario(1);">
                                    <option value="0">Seleccione</option>
                                    <?php foreach ($list_usuario as $list) { ?>
                                        <option value="<?= $list['id_usuario']; ?>"><?= $list['usuario_codigo']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-lg-2 text-right">
                                <label class="control-label text-bold label_tabla margintop">Correo:</label>
                            </div>
                            <div class="form-group col-lg-4">
                                <input type="text" class="form-control" id="correo_1" placeholder="Ingresar Correo" readonly>
                            </div>
                        </div>

                        <div class="col-lg-12" style="padding: 0px;">
                            <div class="form-group col-lg-2 text-right">
                                <label class="control-label text-bold label_tabla margintop">Celular:</label>
                            </div>
                            <div class="form-group col-lg-4">
                                <input type="text" class="form-control" id="celular_1" placeholder="Ingresar Celular" readonly>
                            </div>

                            <?php if ($_SESSION['usuario'][0]['id_nivel'] == 1 || $_SESSION['usuario'][0]['id_nivel'] == 2 || $_SESSION['usuario'][0]['id_nivel'] == 6) { ?>
                                <div class="form-group col-lg-2 text-right">
                                    <label class="control-label text-bold label_tabla margintop">Otro:</label>
                                </div>
                                <div class="form-group col-lg-4">
                                    <input type="text" class="form-control" id="otro_1" name="otro_1" placeholder="Ingresar Persona Externa" maxlength="50" onkeypress="if(event.keyCode == 13){ Insert_Cargo(); }">
                                </div>
                            <?php } ?> 
                        </div>
                    </div>

                    <div class="col-lg-6" style="padding-left: 0px;">
                        <div class="col-lg-12">
                            <label class="control-label text-bold label_tabla">Intermediario:</label>
                        </div>

                        <div class="col-lg-12" style="padding: 0px;">
                            <div class="form-group col-lg-2 text-right">
                                <label class="control-label text-bold label_tabla margintop">Empresa</label>
                            </div>
                            <div class="form-group col-lg-4">
                                <select class="form-control" id="id_empresa_2" name="id_empresa_2" onchange="Buscar_Sede(2);">
                                    <option value="0">Seleccione</option>
                                    <?php foreach ($list_empresam as $list) { ?>
                                        <option value="<?= $list['id_empresa']; ?>"><?= $list['cod_empresa']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-lg-2 text-right">
                                <label class="control-label text-bold margintop">Sede:</label>
                            </div>
                            <div class="form-group col-lg-4">
                                <select class="form-control" id="id_sede_2" name="id_sede_2">
                                    <option value="0" selected>Seleccione</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12" style="padding: 0px;">
                            <div class="form-group col-lg-2 text-right">
                                <label class="control-label text-bold label_tabla margintop">Usuario:</label>
                            </div>
                            <div class="form-group col-lg-4">
                                <select class="form-control" id="id_usuario_2" name="id_usuario_2" onchange="Buscar_Datos_Usuario(2);">
                                    <option value="0">Seleccione</option>
                                    <?php foreach ($list_usuario as $list) { ?>
                                    <option value="<?= $list['id_usuario']; ?>"><?= $list['usuario_codigo']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-lg-2 text-right">
                                <label class="control-label text-bold label_tabla margintop">Correo:</label>
                            </div>
                            <div class="form-group col-lg-4">
                                <input type="text" class="form-control" id="correo_2" placeholder="Ingresar Correo" readonly>
                            </div>
                        </div>

                        <div class="col-lg-12" style="padding: 0px;">
                            <div class="form-group col-lg-2 text-right">
                                <label class="control-label text-bold label_tabla margintop">Celular:</label>
                            </div>
                            <div class="form-group col-lg-4">
                                <input type="text" class="form-control" id="celular_2" placeholder="Ingresar Celular" readonly>
                            </div>

                            <div class="form-group col-lg-2 text-right">
                                <label class="control-label text-bold label_tabla margintop">Otro:</label>
                            </div>
                            <div class="form-group col-lg-4">
                                <input type="text" class="form-control" id="otro_2" name="otro_2" placeholder="Ingresar Persona Externa" maxlength="50" onkeypress="if(event.keyCode == 13){ Insert_Cargo(); }">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12" style="margin-top: 15px;">
                    <div class="form-group col-lg-12">
                        <label class="control-label text-bold label_tabla">Transporte:</label>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group col-lg-1 text-right">
                        <label class="control-label text-bold label_tabla margintop" title="Empresa Transporte">Emp. Transporte:</label>
                    </div>
                    <div class="form-group col-lg-5">
                        <input type="text" class="form-control" id="empresa_transporte" name="empresa_transporte" placeholder="Ingresar Empresa Transporte" maxlength="50" onkeypress="if(event.keyCode == 13){ Insert_Cargo(); }">
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group col-lg-1 text-right">
                        <label class="control-label text-bold label_tabla margintop">Referencia:</label>
                    </div>
                    <div class="form-group col-lg-5">
                        <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Ingresar Referencia" maxlength="50" onkeypress="if(event.keyCode == 13){ Insert_Cargo(); }">
                    </div>

                    <div class="form-group col-lg-1 text-right">
                        <label class="control-label text-bold label_tabla margintop">Rubro:</label>
                    </div>
                    <div class="form-group col-lg-3">
                        <select class="form-control" id="id_rubro" name="id_rubro">
                            <option value="0">Seleccione</option>
                            <?php foreach ($list_rubro as $list) { ?>
                                <option value="<?= $list['id_rubro']; ?>"><?= $list['nom_rubro']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group col-lg-1 text-right">
                        <label class="control-label text-bold label_tabla margintop">Observaciones:</label>
                    </div>
                    <div class="form-group col-lg-11">
                        <textarea class="form-control" id="observacion" name="observacion" placeholder="Ingresar Observaciones" maxlength="500" rows="5"></textarea>
                    </div>
                </div>

                <div class="col-lg-12" id="div_temporal">
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="Insert_Cargo();">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            </button>
            <a type="button" class="btn btn-default" href="<?= site_url('Ca/Cargo') ?>">
                <i class="glyphicon glyphicon-remove-sign"></i>Cancelar
            </a> 
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $("#cargo").addClass('active');
        $("#hcargo").attr('aria-expanded','true');
        $("#listas").addClass('active');
        document.getElementById("rcargo").style.display = "block";  
    });

    function Buscar_Sede(num){
        Cargando();

        var id_empresa = $('#id_empresa_'+num).val();
        var url="<?= site_url(); ?>Ca/Buscar_Sede_Cargo";

        $.ajax({
            type: "POST",
            url: url,
            data: {'id_empresa':id_empresa},
            success:function (data){
                $('#id_sede_'+num).html(data);
            }
        });
    }

    function Buscar_Datos_Usuario(num){
        Cargando();

        var id_usuario = $('#id_usuario_'+num).val();

        if(id_usuario=="0"){
            $('#correo_'+num).val('');
            $('#celular_'+num).val('');
        }else{
            var url="<?= site_url(); ?>Ca/Buscar_Datos_Usuario_Cargo";
            
            $.ajax({
                type: "POST",
                url: url,
                data: {'id_usuario':id_usuario},
                success:function (data) {
                    $('#correo_'+num).val(data.split('/')[0]);
                    $('#celular_'+num).val(data.split('/')[1]);
                }
            });
        }
    }

    function Insert_Cargo(){ 
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?= site_url(); ?>Ca/Insert_Cargo";

        if (Valida_Cargo()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="cantidad"){
                        Swal({
                            title: 'Registro Denegado',
                            text: 'El usuario no puede tener más de 2 cargos asignados',
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            'Registro Exitoso!',
                            'Se registró y envió correo de un Nuevo cargo!</br>Referencia de Cargo <b>'+data,
                            'success'
                        ).then(function() {
                            window.location = "<?= site_url('Ca/Cargo')?>";
                        });
                    }
                }
            });
        }
    }

    function Valida_Cargo() {
        if($('#id_usuario_de').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar usuario que realiza el registro.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#descripcion').val().trim() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar descripción.',
                    'warning'
                ).then(function() { });
                return false;
        }
        if($('#id_empresa_1').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar empresa (para).',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_sede_1').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar sede (para).',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_usuario_1').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar usuario de destino.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_rubro').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar rubro.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Descargar_Archivo_Cargo(id){
        window.location.replace("<?= site_url(); ?>Ca/Descargar_Archivo_Cargo_Temporal/"+id);
    }

    function Delete_Archivo_Cargo(id){
        var file_col = $('#i_' + id);
        var url = "<?= site_url(); ?>Ca/Delete_Archivo_Cargo_Temporal";

        $.ajax({
            type: 'POST',
            url: url,
            data: {'id': id},
            success: function (data) {
                file_col.remove();            
            }
        });
    }
</script>

<?php $this->load->view('view_CA/footer'); ?>