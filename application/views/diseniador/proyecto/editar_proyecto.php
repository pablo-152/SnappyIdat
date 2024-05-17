<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Edición <?php echo $get_id[0]['cod_proyecto'];?></b></span></h4>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid">
        <form id="from_proy" method="POST" enctype="multipart/form-data" class="formulario">
            <div class="col-md-12 row" style="margin-top:15px;margin-bottom:15px;">
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Solicitado Por:</label>
                    <select disabled name="id_solicitante" id="id_solicitante" class="form-control">
                        <option value="0" >Seleccione</option>
                        <?php foreach($solicitado as $row_p){ ?>
                            <option value="<?php echo $row_p['id_usuario']; ?>" <?php if($row_p['id_usuario']==$get_id[0]['id_solicitante']){ echo "selected"; }  ?>>
                                <?php echo $row_p['usuario_codigo']; ?>
                            </option>
                        <?php }  ?>
                    </select>
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Fecha:</label>
                    <div class="col">
                        <?php echo $get_id[0]['fec_solicitante'] ?>
                    </div> 
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold label_tabla">Empresas:</label>
                    <select name="id_empresa" id="id_empresa" class="form-control" disabled>
                        <option value="0">Seleccione</option>
                        <?php foreach($list_empresas as $list){ ?>
                            <option value="<?php echo $list['id_empresa']; ?>" <?php if($list['id_empresa']==$get_id[0]['id_empresa']){ echo "selected"; } ?>>
                                <?php echo $list['cod_empresa']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                
                <div id="div_sedes" class="form-group col-md-2">
                    <?php if($get_id[0]['id_empresa']!=0){ ?>
                        <label class="control-label text-bold" >Sedes:&nbsp;&nbsp;&nbsp;</label>
                        <div class="col">
                            <?php foreach($list_sede as $list){ ?>
                                <label>
                                    <input type="checkbox" id="id_sede[]" name="id_sede[]" value="<?php echo $list['id_sede']; ?>" <?php foreach($get_sede as $sede){ if($sede['id_sede']==$list['id_sede']){ echo "checked"; } } ?> class="check_sede" onclick="return false;">
                                    <span style="font-weight:normal"><?php echo $list['cod_sede']; ?></span>&nbsp;&nbsp;
                                </label>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="col-md-12 row" style="margin-top:15px;margin-bottom:15px;">
                <div class="form-group col-md-3">
                    <label class="control-label text-bold">Tipo:</label>
                    <select disabled id="id_tipo" name="id_tipo" class="form-control" style="width: 100%;">
                        <option  value="0"  >Seleccione</option>
                            <?php foreach($row_t as $row_t){ ?>
                            <option value="<?php echo $row_t['id_tipo']; ?>" <?php if($row_t['id_tipo']==$get_id[0]['id_tipo']){ echo "selected"; } ?>>
                                <?php echo $row_t['nom_tipo']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label class="control-label text-bold">Sub-Tipo:</label>
                    <select disabled id="id_subtipo" name="id_subtipo" class="form-control">
                        <option value="0" >Seleccione</option>
                        <?php foreach($sub_tipo as $sub){ ?> 
                            <option value="<?php echo $sub['id_subtipo']; ?>" <?php if($sub['id_subtipo']==$get_id[0]['id_subtipo']){ echo "selected"; } ?>>
                                <?php echo $sub['nom_subtipo']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-3" id="artes">
                    <label class="control-label text-bold">Week Snappy Artes:</label>
                    <input type="number" class="form-control" id="s_artes" name="s_artes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Ingresar Artes" 
                    disabled value="<?php echo $get_id[0]['s_artes']; ?>" />
                </div>

                <div class="form-group col-md-3" id="redes">
                    <label class="control-label text-bold">Week Snappy Redes:</label>
                    <input type="number" class="form-control" id="s_redes" name="s_redes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Ingresar Redes"
                    disabled  value="<?php echo $get_id[0]['s_redes']; ?>" />
                </div>
            </div>

            <div class="col-md-12 row" style="margin-top:15px;margin-bottom:15px;">
                <div class="form-group col-md-3">
                    <label class="control-label text-bold">Prioridad:</label>
                    <select class="form-control" disabled name="prioridad" id="prioridad">
                        <option value="0" <?php if (!(strcmp(0, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                        <option value="1" <?php if (!(strcmp(1, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>1</option>
                        <option value="2" <?php if (!(strcmp(2, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>2</option>
                        <option value="3" <?php if (!(strcmp(3, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>3</option>
                        <option value="4" <?php if (!(strcmp(4, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>4</option>
                        <option value="5" <?php if (!(strcmp(5, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>5</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label class="control-label text-bold">Descripción:</label>
                    <input name="descripcion" type="text" maxlength="30" class="form-control" id="descripcion" disabled value="<?php echo $get_id[0]['descripcion'] ?> ">
                </div>
                
                <?php if($get_id[0]['fec_agenda']!="0000-00-00"){ ?>
                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Agenda / Redes:</label>
                        <input type="date" class="form-control" id="fec_agenda" name="fec_agenda" disabled value="<?php echo $get_id[0]['fec_agenda']; ?>" />
                    </div>
                <?php } ?>
            </div>

            <div class=" form-group col-md-12" style="background-color:#C9C9C9;">
                <div class="row">
                    <div class="col-md-3">
                        <label for="exampleInputNombnres">Status:</label>
                        <select class="form-control" name="status" id="status" onchange="muestradiv();">
                            <option value="0">Seleccione</option>
                            <?php foreach($row_s as $row_s){ ?>
                                <option value="<?php echo $row_s['id_statusp']?>" <?php if($row_s['id_statusp']==$get_id[0]['status']){ echo "selected"; } ?>>
                                    <?php echo $row_s['nom_statusp']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-2" id="pendiente">
                        <label for="exampleInputPassword1">De:</label>
                        <select class="form-control" id="id_userpr" name="id_userpr">
                            <option value="0">Seleccione</option>
                            <?php foreach($usuario_subtipo as $row_c1){ ?>
                                <option value="<?php echo $row_c1['id_usuario']?>" <?php if($row_c1['id_usuario']==$get_id[0]['id_userpr']){ echo "selected"; } ?>>
                                    <?php echo $row_c1['usuario_codigo']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="exampleInputPassword1">Colaborador:</label>
                        <select class="form-control" id="id_asignado" name="id_asignado">
                            <option value="0">Seleccione</option>
                            <?php foreach($usuario_subtipo1 as $row_c){ ?>
                                <option value="<?php echo $row_c['id_usuario']?>" <?php if($row_c['id_usuario']== $get_id[0]['id_asignado']){ echo "selected"; } ?>>
                                    <?php echo $row_c['usuario_codigo']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <?php if ($get_id[0]['status']==5) { ?>
                        <div class="col-md-2" id="fecha">
                            <label for="exampleInputPassword1">Fecha:</label><br>
                            <?php 
                                if ($get_id[0]['fec_termino']!='0000-00-00 00:00:00'){
                                    echo date('d/m/Y', strtotime($get_id[0]['fec_termino']));
                                }else{ 
                                    echo date('d/m/Y'); 
                                } 
                            ?>
                        </div>
                        <div class="col-md-3" id="imagen">
                            <label for="exampleInputFile">Archivo:</label>
                            <input class="form-control" name="foto" type="file" id="foto">
                        </div>
                    <?php }else{ ?>
                        <div class="col-md-3" id="fecha">
                            <label for="exampleInputPassword1">Fecha:</label><br>
                            <?php 
                                if ($get_id[0]['fec_termino']!='0000-00-00 00:00:00'){
                                    echo date('d/m/Y H:i:s', strtotime($get_id[0]['fec_termino']));
                                }else{ 
                                    echo date('d/m/Y'); 
                                } 
                            ?>
                        </div>
                        <div class="col-md-3" id="imagen">
                            <label for="exampleInputFile">Archivo:</label>
                            <input class="form-control" name="foto" type="file" id="foto">
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group col-md-12" id="idstatus">
                <div class="col-xs-12">
                    <label class="control-label text-bold">Observaciones:</label>
                    <textarea name="proy_obs" rows="10" class="form-control" id="proy_obs" ><?php echo $get_id[0]['proy_obs']?></textarea>
                    <span style="color: #C8C8C8;">Utilizar siempre la configuración: DD/MM/AAAA - Observaciones (Usuario)</span>
                </div>
            </div>
        </form>
    </div>

    <div class="modal-footer">
        <input type="hidden" name="id_proyecto" id="id_proyecto" value="<?php echo $get_id[0]['id_proyecto'] ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Proyecto();">Guardar</button>&nbsp;&nbsp;
        <a type="button" href="<?= site_url('Diseniador/proyectos') ?>" class="btn btn-default">Cancelar</a>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#comunicacion").addClass('active');
        $("#hcomunicacion").attr('aria-expanded','true');
        $("#proyectos").addClass('active');
        document.getElementById("rcomunicacion").style.display = "block";

        status=document.getElementById("status").value;

        if(status==4){
            $('#pendiente').show();
        }else{
            $('#pendiente').hide();
        }

        if(status==5){
            $('#fecha').show();
            $('#imagen').show();
        }else{
            $('#fecha').hide();
            $('#imagen').hide();
        }

        if(status==5) {
            document.getElementById("proy_obs").disabled = true;
        }
    });

    function Update_Proyecto(){
        $(document)
        .ajaxStart(function() {
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
        .ajaxStop(function() {
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

        var dataString = new FormData(document.getElementById('from_proy'));
        var url="<?php echo site_url(); ?>Diseniador/update_proyecto_ds";

        var id_proyecto = $('#id_proyecto').val(); 
        dataString.append('id_proyecto', id_proyecto);

        if (Valida_Update_Proyecto()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location.reload(); 
                    });
                }
            });
        }
    }

    function Valida_Update_Proyecto(){
        if($('#status').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar status.',
                'warning'
            ).then(function() { });
            return false; 
        }
        if($('#status').val() === '4') {
            if($('#id_userpr').val() === '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar colaborador de.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if($('#status').val() === '5') {
            if($('#foto').val() === '') {
                Swal(
                    'Ups!',
                    'Debe adjuntar archivo.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        return true;
    }
    
    function muestradiv(){
        $(document)
        .ajaxStart(function() {
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
        .ajaxStop(function() {
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

        status=document.getElementById("status").value;

        if(status==5){
            $('#fecha').show();
            $('#imagen').show();
        }else{
            $('#fecha').hide();
            $('#imagen').hide();
        }

        if(status==4){
            $('#pendiente').show();
        }else{
            $('#pendiente').hide();
        }
    }
</script>

<?php $this->load->view('Admin/footer'); ?>