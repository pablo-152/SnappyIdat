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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Editar Cargo</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo archivo" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Ca/Modal_Archivo_Cargo') ?>" style="margin-right:5px;">
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
                                    <option value="<?= $list['id_usuario']; ?>" <?php if($list['id_usuario']==$get_id[0]['id_usuario_de']){ echo "selected"; } ?>>
                                        <?= $list['usuario_codigo']; ?>
                                    </option>
                                <?php }?>
                            </select>
                        <?php }else{ ?>
                            <input id="id_usuario_de" name="id_usuario_de" type="hidden" value="<?= $_SESSION['usuario'][0]['id_usuario']; ?>" readonly>
                            <input id="nom" name="nom" type="text" value="<?= $_SESSION['usuario'][0]['usuario_codigo']; ?>" readonly>
                        <?php } ?>
                    </div>

                    <div class="form-group col-lg-1 text-right">
                        <label class="control-label text-bold label_tabla margintop">Estado:</label>
                    </div>
                    <div class="form-group col-lg-2">
                        <select class="form-control" disabled>
                            <option value="0"><?= $get_id[0]['nom_status']; ?></option>
                        </select>
                    </div>

                    <div class="form-group col-lg-4 text-right">
                        <label class="control-label text-bold label_tabla margintop"></label>
                    </div>
                    <div class="form-group col-lg-1" style="width: 150px !important;">
                        <input type="text" class="form-control" title="Referencia automática" readonly value="<?= $get_id[0]['codigo']; ?>" style="cursor:help;background-color:rgb(90, 73, 91);color:#fff;font-weight:bold;">
                    </div>
                </div>

                <div class="col-lg-12"> 
                    <div class="form-group col-lg-1 text-right">
                        <label class="control-label text-bold label_tabla margintop">Descripción:</label>
                    </div>
                    <div class="form-group col-lg-11">
                        <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Ingresar Descripción" maxlength="50" value="<?= $get_id[0]['descripcion']; ?>" onkeypress="if(event.keyCode == 13){ Update_Cargo(); }">
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
                                        <option value="<?= $list['id_empresa']; ?>" <?php if($list['id_empresa']==$get_id[0]['id_empresa_1']){ echo "selected"; } ?>>
                                            <?= $list['cod_empresa']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-lg-2 text-right">
                                <label class="control-label text-bold margintop">Sede:</label>
                            </div>
                            <div class="form-group col-lg-4">
                                <select class="form-control" id="id_sede_1" name="id_sede_1">
                                    <option value="0" selected>Seleccione</option>
                                    <?php foreach($list_sede_1 as $list){ ?>
                                        <option value="<?= $list['id_sede']; ?>" <?php if($list['id_sede']==$get_id[0]['id_sede_1']){ echo "selected"; } ?>>
                                            <?= $list['cod_sede']; ?>
                                        </option>
                                    <?php } ?>
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
                                        <option value="<?= $list['id_usuario']; ?>" <?php if($list['id_usuario']==$get_id[0]['id_usuario_1']){ echo "selected"; } ?>>
                                            <?= $list['usuario_codigo']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-lg-2 text-right">
                                <label class="control-label text-bold label_tabla margintop">Correo:</label>
                            </div>
                            <div class="form-group col-lg-4">
                                <input type="text" class="form-control" id="correo_1" placeholder="Ingresar Correo" readonly value="<?= $get_id[0]['correo_1']; ?>">
                            </div>
                        </div>

                        <div class="col-lg-12" style="padding: 0px;">
                            <div class="form-group col-lg-2 text-right">
                                <label class="control-label text-bold label_tabla margintop">Celular:</label>
                            </div>
                            <div class="form-group col-lg-4">
                                <input type="text" class="form-control" id="celular_1" placeholder="Ingresar Celular" readonly value="<?= $get_id[0]['celular_1']; ?>">
                            </div>

                            <?php if ($_SESSION['usuario'][0]['id_nivel'] == 1 || $_SESSION['usuario'][0]['id_nivel'] == 2 || $_SESSION['usuario'][0]['id_nivel'] == 6) { ?>
                                <div class="form-group col-lg-2 text-right">
                                    <label class="control-label text-bold label_tabla margintop">Otro:</label>
                                </div>
                                <div class="form-group col-lg-4">
                                    <input type="text" class="form-control" id="otro_1" name="otro_1" placeholder="Ingresar Persona Externa" maxlength="50" value="<?= $get_id[0]['otro_1']; ?>" onkeypress="if(event.keyCode == 13){ Update_Cargo(); }">
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
                                        <option value="<?= $list['id_empresa']; ?>" <?php if($list['id_empresa']==$get_id[0]['id_empresa_2']){ echo "selected"; } ?>>
                                            <?= $list['cod_empresa']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-lg-2 text-right">
                                <label class="control-label text-bold margintop">Sede:</label>
                            </div>
                            <div class="form-group col-lg-4">
                                <select class="form-control" id="id_sede_2" name="id_sede_2">
                                    <option value="0" selected>Seleccione</option>
                                    <?php foreach($list_sede_2 as $list){ ?>
                                        <option value="<?= $list['id_sede']; ?>" <?php if($list['id_sede']==$get_id[0]['id_sede_2']){ echo "selected"; } ?>>
                                            <?= $list['cod_sede']; ?>
                                        </option>
                                    <?php } ?>
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
                                    <option value="<?= $list['id_usuario']; ?>" <?php if($list['id_usuario']==$get_id[0]['id_usuario_2']){ echo "selected"; } ?>>
                                        <?= $list['usuario_codigo']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-lg-2 text-right">
                                <label class="control-label text-bold label_tabla margintop">Correo:</label>
                            </div>
                            <div class="form-group col-lg-4">
                                <input type="text" class="form-control" id="correo_2" placeholder="Ingresar Correo" readonly value="<?= $get_id[0]['correo_2']; ?>">
                            </div>
                        </div>

                        <div class="col-lg-12" style="padding: 0px;">
                            <div class="form-group col-lg-2 text-right">
                                <label class="control-label text-bold label_tabla margintop">Celular:</label>
                            </div>
                            <div class="form-group col-lg-4">
                                <input type="text" class="form-control" id="celular_2" placeholder="Ingresar Celular" readonly value="<?= $get_id[0]['celular_2']; ?>">
                            </div>

                            <div class="form-group col-lg-2 text-right">
                                <label class="control-label text-bold label_tabla margintop">Otro:</label>
                            </div>
                            <div class="form-group col-lg-4">
                                <input type="text" class="form-control" id="otro_2" name="otro_2" placeholder="Ingresar Persona Externa" maxlength="50" value="<?= $get_id[0]['otro_2']; ?>" onkeypress="if(event.keyCode == 13){ Update_Cargo(); }">
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
                        <input type="text" class="form-control" id="empresa_transporte" name="empresa_transporte" placeholder="Ingresar Empresa Transporte" maxlength="50" value="<?= $get_id[0]['empresa_transporte']; ?>" onkeypress="if(event.keyCode == 13){ Update_Cargo(); }">
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group col-lg-1 text-right">
                        <label class="control-label text-bold label_tabla margintop">Referencia:</label>
                    </div>
                    <div class="form-group col-lg-5">
                        <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Ingresar Referencia" maxlength="50" value="<?= $get_id[0]['referencia']; ?>" onkeypress="if(event.keyCode == 13){ Update_Cargo(); }">
                    </div>

                    <div class="form-group col-lg-1 text-right">
                        <label class="control-label text-bold label_tabla margintop">Rubro:</label>
                    </div>
                    <div class="form-group col-lg-3">
                        <select class="form-control" id="id_rubro" name="id_rubro">
                            <option value="0">Seleccione</option>
                            <?php foreach ($list_rubro as $list) { ?>
                                <option value="<?= $list['id_rubro']; ?>" <?php if($list['id_rubro']==$get_id[0]['id_rubro']){ echo "selected"; } ?>>
                                    <?= $list['nom_rubro']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group col-lg-1 text-right">
                        <label class="control-label text-bold label_tabla margintop">Observaciones:</label>
                    </div>
                    <div class="form-group col-lg-11">
                        <textarea class="form-control" id="observacion" name="observacion" placeholder="Ingresar Observaciones" maxlength="500" rows="5"><?= $get_id[0]['observacion']; ?></textarea>
                    </div>
                </div>

                <div class="col-lg-12">
                    <table class="table table-hover table-bordered table-striped" id="example" width="100%">
                        <thead>
                            <tr>
                                <td class="text-center" width="10%"></td>
                                <th class="text-center" width="25%">Estado</th>
                                <th class="text-center" width="25%">Usuario</th>
                                <th class="text-center" width="15%">Fecha y hora</th>
                                <td class="text-center" width="15%"></td>
                                <td class="text-center" width="10%"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                                foreach($list_historial as $list){ ?>
                                    <tr>
                                        <td class="text-center"><?= "0".$i; ?></td>
                                        <td class="text-center">
                                            <span class="badge" style="background:<?= $list['color']; ?>;"><?= $list['nom_status'] ?></span> 
                                        </td>
                                        <td><?= $list['usuario_registro']; ?></td>
                                        <td class="text-center"><?= $list['fecha_registro']; ?></td>
                                        <td><?= $list['informacion']; ?></td>
                                        <td class="text-center">
                                            <a title="Observación/Mensaje" data-toggle="modal"  data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Ca/Modal_Observacion_Cargo_Historial') ?>/<?= $list['id']; ?>">
                                                <img src="<?= base_url() ?>template/img/ver.png">
                                            </a>
                                            <?php if($list['estado_c']!=43 && $list['estado_c']!=47 && $list['estado_c']!=63){ ?>
                                                <a title="Reenviar Correo" onclick="Reenviar_Email('<?= $list['id']; ?>')">
                                                    <img src="<?= base_url() ?>template/img/Botón_Edición_Reenviar correo.png">
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-lg-12" id="div_temporal">
                    <?php if(count($list_archivo)>0){ ?>
                        <div class="form-group col-lg-12">
                            <label class="control-label text-bold label_tabla">Archivos:</label>
                        </div> 
                        <?php foreach($list_archivo as $list){?>
                            <div id="i_<?=  $list['id']; ?>" class="form-group col-lg-3">
                                <?= $list['nombre']; ?> 
                                <a onclick="Descargar_Archivo_Cargo('<?= $list['id']; ?>');">
                                    <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                                </a>
                                <a onclick="Delete_Archivo_Cargo('<?= $list['id']; ?>')">
                                    <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                                </a>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <input type="hidden" id="id" name="id" value="<?= $get_id[0]['id']; ?>">
            <button type="button" class="btn btn-primary" onclick="Update_Cargo();">
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

        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            
            $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
    
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        var table = $('#example').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ {
                'bSortable' : false,
                'aTargets' : [ 0,5 ]
            } ]
        } );
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

    function Update_Cargo(){ 
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?= site_url(); ?>Ca/Update_Cargo";

        if (Valida_Cargo()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    window.location.reload();
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
        window.location.replace("<?= site_url(); ?>Ca/Descargar_Archivo_Cargo/"+id);
    }

    function Delete_Archivo_Cargo(id){
        var file_col = $('#i_' + id);
        var url = "<?= site_url(); ?>Ca/Delete_Archivo_Cargo";

        $.ajax({
            type: 'POST',
            url: url,
            data: {'id': id},
            success: function (data) {
                file_col.remove();            
            }
        });
    }

    function Reenviar_Email(id){
        Cargando();

        var url = "<?php echo site_url(); ?>Ca/Reenviar_Email";

        $.ajax({
            type:"POST",
            url:url,
            data:{'id':id},
            success:function () {
                console.log('Envío exitoso');
            }
        });
    }
</script>

<?php $this->load->view('view_CA/footer'); ?>