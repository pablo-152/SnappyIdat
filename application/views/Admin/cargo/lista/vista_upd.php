<?php 
$sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<style>
    .margintop{
        margin-top:5px ;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;height:80px">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Actualizar Cargo</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                      <a title="Nuevo Archivo" style="cursor:pointer; cursor: hand;margin-right:5px" data-toggle="modal"  data-target="#modal_form_vertical" modal_form_vertical="<?= site_url('Snappy/Modal_archivo_cargo/') ?><?php echo $get_id[0]['id_cargo'] ?>">
                        <img src="<?= base_url() ?>template/img/icono-subir.png" alt="Exportar Excel">
                      </a>
                      <a type="button" href="<?= site_url('Snappy/Cargo') ?>" >
                          <img src="<?= base_url() ?>template/img/icono-regresar.png">
                      </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="formulario_cargoe" method="POST" enctype="multipart/form-data"  class="horizontal">
        <div class="container-fluid">
            <div class="row">
                

                <div class="col-md-12">
                  <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold label_tabla margintop">De: </label>
                  </div>
                  <div class="form-group col-md-2">
                    <?php if ($_SESSION['usuario'][0]['id_nivel'] == 1 || $_SESSION['usuario'][0]['id_nivel'] == 6) { ?>
                        <select class="form-control" name="id_usuario_de" id="id_usuario_de">
                          <option value="0">Seleccione</option>
                          <?php foreach ($list_usuario as $list) { ?>
                            <option value="<?php echo $list['id_usuario']; ?>" <?php if($list['id_usuario']==$get_id[0]['id_usuario_de']){ echo "selected"; } ?>>
                              <?php echo $list['usuario_codigo']; ?>
                            </option>
                          <?php }?>
                        </select>
                    <?php }else{ ?>
                      <input id="id_usuario_de" name="id_usuario_de" type="hidden" value="<?php echo $_SESSION['usuario'][0]['id_usuario']; ?>" readonly>
                      <input id="nom" name="nom" type="text" value="<?php echo $_SESSION['usuario'][0]['usuario_codigo']; ?>" readonly>
                    <?php } ?>
                  </div>

                  <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold label_tabla margintop">Estado:</label>
                  </div>
                  <div class="form-group col-md-2">
                    <select class="form-control" name="id_est_men" id="id_est_men" disabled>
                      <option value="0"><?php echo $get_id[0]['nom_estado'] ?></option>
                    </select>
                  </div>

                  <!--<div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold label_tabla margintop">Referencia:</label>
                  </div>-->
                  <div class="form-group col-md-4 text-right">
                    <label class="control-label text-bold label_tabla margintop"></label>
                  </div>
                  <div class="form-group col-md-1" style="width: 150px !important;">
                    <input id="cod_cargo"  name="cod_cargo" type="text"  title="Referencia automática" style="cursor:help;background-color:rgb(90, 73, 91);color:#fff;font-weight:bold;" maxlength="50" class="form-control"  value="<?php echo $get_id[0]['cod_cargo']; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-12"> 
                  <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold label_tabla margintop">Descripción:</label>
                  </div>
                  <div class="form-group col-md-11">
                    <input name="desc_cargo" type="text" maxlength="50" class="form-control" id="desc_cargo" placeholder="Ingresar Descripción" value="<?php echo $get_id[0]['desc_cargo'] ?>" onkeypress="if(event.keyCode == 13){ Update_Cargo(); }">
                  </div>
                </div>

                <div class="col-md-12" style="margin-top: 15px;">
                  <div class="form-group col-md-6">
                    <label class="control-label text-bold label_tabla">Para:</label>
                  </div>
                  <div class="form-group col-md-6">
                    <label class="control-label text-bold label_tabla">Intermediario:</label>
                  </div>

                  <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold label_tabla margintop">Empresa</label>
                  </div>
                  <div class="form-group col-md-2">
                    <select class="form-control" name="id_empresa" id="id_empresa" onchange="Buscar_Sede()">
                      <option value="0">Seleccione</option>
                      <?php foreach ($list_empresam as $list){ ?>
                        <option value="<?php echo $list['id_empresa']; ?>" <?php if($list['id_empresa']==$get_id[0]['id_empresa_1']){ echo "selected"; } ?>>
                          <?php echo $list['cod_empresa']; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Sede:</label>
                  </div>
                  <div class="form-group col-md-2" id="msede">
                    <select class="form-control" name="id_sede" id="id_sede">
                      <option value="0" selected>Seleccione</option>
                      <?php foreach ($list_sede1 as $list){ ?> 
                        <option value="<?php echo $list['id_sede']; ?>" <?php if($list['id_sede']==$get_id[0]['id_sede_1']){ echo "selected"; } ?>>
                          <?php echo $list['cod_sede']; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>


                  <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold label_tabla margintop">Empresa</label>
                  </div>
                  <div class="form-group col-md-2">
                    <select class="form-control" name="id_empresa2" id="id_empresa2" onchange="Buscar_Sede2()">
                      <option value="0">Seleccione</option>
                      <?php foreach ($list_empresam as $list){ ?> 
                        <option value="<?php echo $list['id_empresa']; ?>" <?php if($list['id_empresa']==$get_id[0]['id_empresa_2']){ echo "selected"; } ?>>
                          <?php echo $list['cod_empresa']; ?>
                        </option>
                      <?php } ?>
                  </select>
                  </div>

                  <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold margintop">Sede:</label>
                  </div>
                  <div class="form-group col-md-2" id="msede2">
                    <select class="form-control" name="id_sede2" id="id_sede2">
                      <option value="0" selected>Seleccione</option>
                      <?php foreach ($list_sede2 as $list){ ?> 
                        <option value="<?php echo $list['id_sede']; ?>" <?php if($list['id_sede']==$get_id[0]['id_sede_2']){ echo "selected"; } ?>>
                          <?php echo $list['cod_sede']; ?>
                        </option>
                      <?php } ?>
                    </select>
                      </div>
                  </div>
                  
                

                <div class="col-md-12">
                  <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold  ">Usuario:</label>
                  </div>
                  <div class="form-group col-md-2">
                    <select class="form-control" name="id_usuario_1" id="id_usuario_1">
                      <option value="0">Seleccione</option>
                      <?php foreach ($list_usuario as $list){ ?>
                        <option value="<?php echo $list['id_usuario']; ?>" <?php if($list['id_usuario']==$get_id[0]['id_usuario_1']){ echo "selected"; } ?>>
                          <?php echo $list['usuario_codigo']; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold label_tabla margintop">Correo:</label>
                  </div>
                  <div class="form-group col-md-2">
                    <input name="correo_1" type="text" maxlength="50" class="form-control" id="correo_1" readonly placeholder="Ingresar Correo" value="<?php echo $get_id[0]['correo_1'] ?>" onkeypress="if(event.keyCode == 13){ Update_Cargo(); }">
                  </div>
                  


                  <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold label_tabla margintop">Usuario:</label>
                  </div>
                  <div class="form-group col-md-2">
                    <select class="form-control" name="id_usuario_2" id="id_usuario_2">
                      <option value="0">Seleccione</option>
                      <?php foreach ($list_usuario as $list){ ?>
                        <option value="<?php echo $list['id_usuario']; ?>" <?php if($list['id_usuario']==$get_id[0]['id_usuario_2']){ echo "selected"; } ?>>
                          <?php echo $list['usuario_codigo']; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold label_tabla margintop">Correo:</label>
                  </div>
                  <div class="form-group col-md-2">
                    <input name="correo_2" type="text" maxlength="50" class="form-control" id="correo_2" readonly placeholder="Ingresar Correo" value="<?php echo $get_id[0]['correo_2'] ?>" onkeypress="if(event.keyCode == 13){ Update_Cargo(); }">
                  </div>
                
                  

                </div>

                <div class="col-md-12">
                  

                  

                  <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold label_tabla margintop">Celular:</label>
                  </div>
                  <div class="form-group col-md-2">
                    <input name="celular_1" type="text" maxlength="9" class="form-control" id="celular_1" readonly placeholder="Ingresar Celular" value="<?php echo $get_id[0]['celular_1'] ?>" onkeypress="if(event.keyCode == 13){ Update_Cargo(); }">
                  </div>

                  <?php if ($_SESSION['usuario'][0]['id_nivel'] == 1 || $_SESSION['usuario'][0]['id_nivel'] == 2 || $_SESSION['usuario'][0]['id_nivel'] == 6) { ?>
                    <div class="form-group col-md-1 text-right">
                      <label class="control-label text-bold label_tabla margintop">Otro:</label>
                    </div>
                    <div class="form-group col-md-2">
                      <input id="otro_1" name="otro_1" type="text" maxlength="50" class="form-control"  placeholder="Ingresar Persona Externa" value="<?php echo $get_id[0]['otro_1'] ?>" onkeypress="if(event.keyCode == 13){ Update_Cargo(); }">
                    </div>
                  <?php } ?> 

                  

                  <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold label_tabla margintop">Celular:</label>
                  </div>
                  <div class="form-group col-md-2">
                    <input name="celular_2" type="text" maxlength="9" class="form-control" id="celular_2" readonly placeholder="Ingresar Celular" value="<?php echo $get_id[0]['celular_2'] ?>" onkeypress="if(event.keyCode == 13){ Update_Cargo(); }">
                  </div>

                  <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold label_tabla margintop">Otro:</label>
                  </div>
                  <div class="form-group col-md-2">
                    <input name="otro_2" type="text" maxlength="50" class="form-control" id="otro_2" placeholder="Ingresar Persona Externa" value="<?php echo $get_id[0]['otro_2'] ?>" onkeypress="if(event.keyCode == 13){ Update_Cargo(); }">
                  </div>

                </div>

                <div class="col-md-12" style="margin-top: 15px;">
                  <div class="form-group col-md-12">
                    <label class="control-label text-bold label_tabla">Transporte:</label>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold label_tabla margintop" title="Empresa Transporte">Emp. Transporte:</label>
                  </div>
                  <div class="form-group col-md-5">
                    <input name="empresa_transporte" type="text" maxlength="50" class="form-control" id="empresa_transporte" placeholder="Ingresar Empresa Transporte" value="<?php echo $get_id[0]['empresa_transporte'] ?>" onkeypress="if(event.keyCode == 13){ Update_Cargo(); }">
                  </div>
                </div>
                  <div class="col-md-12" style="margin-top: 15px;">
                  <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold label_tabla margintop">Referencia:</label>
                  </div>
                  <div class="form-group col-md-5">
                    <input name="referencia" type="text" maxlength="50" class="form-control" id="referencia" placeholder="Ingresar Referencia" value="<?php echo $get_id[0]['referencia'] ?>" onkeypress="if(event.keyCode == 13){ Update_Cargo(); }">
                  </div>
                  <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold label_tabla margintop">Rubro:</label>
                  </div>
                  <div class="form-group col-md-2">
                    <select class="form-control" name="id_rubro" id="id_rubro">
                      <option value="0">Seleccione</option>
                      <?php foreach ($list_rubro as $list) { ?>
                        <option value="<?php echo $list['id_rubro']; ?>" <?php if($list['id_rubro']==$get_id[0]['id_rubro']){ echo "selected"; } ?>>
                        <?php echo $list['nom_rubro']; ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold label_tabla margintop">Observaciones:</label>
                  </div>
                  <div class="form-group col-md-11">
                    <textarea name="obs_cargo" type="text" maxlength="500" rows="5" class="form-control" id="obs_cargo" placeholder="Ingresar Observaciones"><?php echo $get_id[0]['obs_cargo'] ?></textarea>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="container-fluid">
                      <div class="row">
                          <div class="col-lg-12" >
                            <label for="">Historia</label>
                              <table class="table table-hover table-bordered table-striped" id="example" width="100%">
                              <thead>
                                  <tr>
                                      <td class="text-center" width="2%"></td>
                                      <th class="text-center" width="20%">Estado</th>
                                      <th class="text-center" width="20%">Usuario</th>
                                      <th class="text-center" width="10%">Fecha y hora</th>
                                      <td class="text-center" width="10%"></td>
                                      <td class="text-center" width="4%"></td>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php $ini=1;/*$b=count($list_historial);*/ 
                                  foreach($list_historial as $prod){?>
                                      <tr>
                                          <td class="text-center"><?php echo "0".$ini; ?></td>
                                          <td class="text-center"><?php if($prod['id_estado']==43){?>
                                              <span class="badge" style="background:#7030a0;color: white;"><?php echo $prod['nom_status'] ?></span> 
                                              <?php }elseif($prod['id_estado']==44){?> 
                                              <span class="badge" style="background:#bf9000;color: white;"><?php echo $prod['nom_status'] ?></span>
                                              <?php }elseif($prod['id_estado']==45){?>
                                              <span class="badge" style="background:#c55a11;color: white;"><?php echo $prod['nom_status'] ?></span> 
                                              <?php }elseif($prod['id_estado']==46){?>
                                              <span class="badge" style="background:#c55a11;color: white;"><?php echo $prod['nom_status'] ?></span> 
                                              <?php }elseif($prod['id_estado']==47){?>
                                              <span class="badge" style="background:#00b050;color: white;"><?php echo $prod['nom_status'] ?></span> 
                                              <?php }?>
                                          </td>
                                          <td><?php if($prod['editado']!=0){echo $prod['user1']." (Editado)";}else{echo $prod['user1'];}  ?></td>
                                          <td class="text-center"><?php echo $prod['fecha_registro']; ?></td>
                                          <td ><?php if($prod['id_estado']==43){
                                            echo "De";
                                            }elseif($prod['id_estado']==44){echo "De";
                                            }elseif($prod['id_estado']==45){echo "Transportista/Intermediario";
                                            }elseif($prod['id_estado']==46){echo "Para";
                                            }elseif($prod['id_estado']==47){echo "Para";
                                            }?>
                                          </td>
                                          <td class="text-center">
                                            <a title="Observación/Mensaje" data-toggle="modal"  data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Snappy/Modal_Observacion_Cargo_Historial') ?>/<?php echo $prod["id_cargo_historial"]; ?>">
                                                <img title="Más Información" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;">
                                            </a>
                                            <?php //if($b==1){?>
                                              <a title="Reenviar Correo" onclick="Reenviar_Email('<?php echo $prod['id_cargo_historial']; ?>')">
                                                <!--<i class="glyphicon glyphicon-envelope"></i>-->
                                                <img src="<?= base_url() ?>template/img/Botón_Edición_Reenviar correo.png" style="cursor:pointer; cursor: hand;">
                                              </a>
                                            <?php //} ?>
                                          </td>
                                      </tr>
                                  <?php $ini=$ini+1; /*$b=$b-1;*/ } ?>
                              </tbody>
                              </table>
                          </div>
                      </div>
                  </div>
                </div>

                <div class="col-md-12" >
                  <div class="container-fluid" >
                    <div class="row" >
                      <div class="col-lg-12" > <!-- style="background-color:#e5e5e5" -->
                        <?php if(count($list_archivo)>0){ ?>
                            <div class="form-group col-md-1 text-right"  id="div_verificar">
                              <label class="control-label text-bold label_tabla">Archivos:</label>
                            </div>
                        <?php } ?> 

                        <?php foreach($list_archivo as $list){ ?>
                          
                          <div id="i_<?php echo  $list['id_cargo_archivo']?>" class="form-group col-sm-1" >
                              <div id="lista_escogida"> <!-- style="background-color:#4473c5;color:white" -->
                              &nbsp;<?php echo $list['nombre'] ?>&nbsp;
                                <a style="cursor:pointer;" class="download" type="button" id="download_file_historial" data-image_id="<?php echo $list['id_cargo_archivo']?>">
                                  <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                                </a>
                                <?php if($ultimo_historial['0']['id_estado']!=47) { ?>
                                  <a style="cursor:pointer;" class="delete" type="button" id="delete_file_historial" data-image_id="<?php echo  $list['id_cargo_archivo']?>">
                                    <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                                  </a>
                                <?php } ?>
                              </div>
                          </div>  
                        <?php } ?>
                      </div>  
                    </div>
                  </div>
                </div>

            </div>
        </div>

        <div class="modal-footer">
          <?php if($get_id[0]['ultimo_estado']!=47){ ?>
            <input name="id_cargo" type="hidden" maxlength="50" class="form-control" id="id_cargo" placeholder="Ingresar Descripción" value="<?php echo $get_id[0]['id_cargo'] ?>">
            <button type="button" class="btn btn-primary" onclick="Update_Cargo()" data-loading-text="Loading..." autocomplete="off">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
            </button>
          <?php }else{ ?>
            <?php if($id_nivel==1 || $id_nivel==6 || $id_nivel==7){ ?>
              <input name="id_cargo" type="hidden" maxlength="50" class="form-control" id="id_cargo" placeholder="Ingresar Descripción" value="<?php echo $get_id[0]['id_cargo'] ?>">
              <button type="button" class="btn btn-primary" onclick="Update_Cargo()" data-loading-text="Loading..." autocomplete="off">
                  <i class="glyphicon glyphicon-ok-sign"></i> Guardar
              </button>
              <!--<button type="button" class="btn btn-default" data-dismiss="modal">
                  <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
              </button>-->
          <?php } } ?>
        </div>
    </form>
</div>

<script>

    $('#celular_1').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.]/g, '');
    });
    $('#celular_2').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $(document).ready(function() {
        var msgDate = '';
        var inputFocus = '';
    });
    $(document).ready(function() {
        $("#cargo").addClass('active');
        $("#hcargo").attr('aria-expanded', 'true');
        $("#slista").addClass('active');
        /*$("#hlista").attr('aria-expanded', 'true');
        $("#nuevocargo").addClass('active');
        document.getElementById("rlista").style.display = "block";*/
        document.getElementById("rcargo").style.display = "block";
    });

    function Reenviar_Email(id){
      Cargando();

      var id_cargo=$('#id_cargo').val();
      var url="<?php echo site_url(); ?>Snappy/Reenviar_Email";

      $.ajax({
          type:"POST",
          url:url,
          data:{'id_cargo_historial':id},
          success:function () {
            swal.fire(
                'Reenvio de Correo Exitoso!',
                'Haga clic en el botón!',
                'success'
            ).then(function() {
                  window.location = "<?php echo site_url('Snappy/Vista_Upd_Cargo/')?>"+id_cargo;
            });
          }
      });
    }

    $(document).ready(function() {
        // Setup - add a text input to each footer cell
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

    } );

    $('#archivos').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        maxTotalFileCount: 5,
        showUpload: false,
        overwriteInitial: false,
        initialPreviewAsData: true,
        allowedFileExtensions: ['png','jpeg','jpg','xls','xlsx','pdf'],
    });

    function Buscar_Sede(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_cargoe'));
        var url="<?php echo site_url(); ?>Snappy/Buscar_Sede_Cargo";

        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#msede').html(data);
                
            }
        });
    }

    function Buscar_Sede2() {
      Cargando();

      var dataString = new FormData(document.getElementById('formulario_cargoe'));
      var url="<?php echo site_url(); ?>Snappy/Buscar_Sede_Cargo2";

      $.ajax({
          type:"POST",
          url: url,
          data:dataString,
          processData: false,
          contentType: false,
          success:function (data) {
              $('#msede2').html(data);
              
          }
      });
    }

    function Update_Cargo(){
      Cargando();

      var dataString = new FormData(document.getElementById('formulario_cargoe'));
      var url="<?php echo site_url(); ?>Snappy/Update_Cargo";

      if (valida_registros_cargoe()) {
        if ($('#div_verificar').length > 0) {
          $.ajax({
              type:"POST",
              url:url,
              data:dataString,
              processData: false,
              contentType: false,
              success:function (data) {
                  
                  if(data=="error"){
                      Swal({
                          title: 'Actualización Denegada',
                          text: 'El registro ya existe',
                          type: 'error',
                          showCancelButton: false,
                          confirmButtonColor: '#3085d6',
                          confirmButtonText: 'OK',
                      });
                  }else{
                      swal.fire(
                          'Actualización Exitosa!',
                          '',
                          'success'
                      ).then(function() {
                            window.location = "<?php echo site_url('Snappy/Cargo')?>";
                      });
                  }
              }
          });
        }else{
          Swal({
                title: '¿Realmente desea guardar el cargo?',
                text: "Es recomendable poner foto o archivo",
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
                  url:url,
                  data:dataString,
                  processData: false,
                  contentType: false,
                  success:function (data) {
                      
                      if(data=="error"){
                          Swal({
                              title: 'Actualización Denegada',
                              text: 'El registro ya existe',
                              type: 'error',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              confirmButtonText: 'OK',
                          });
                      }else{
                          swal.fire(
                              'Actualización Exitosa!',
                              '',
                              'success'
                          ).then(function() {
                                window.location = "<?php echo site_url('Snappy/Cargo')?>";
                          });
                      }
                    }
                });
              }
            }) 
        }
      }
    }
    
    function valida_registros_cargoe() {
      if($('#id_remi').val() == '0') {
          Swal(
              'Ups!',
              'Debe seleccionar Usuario que realiza el registro.',
              'warning'
          ).then(function() { });
          return false;
      }

      if($('#desc_cargo').val().trim() === '') {
              Swal(
                  'Ups!',
                  'Debe ingresar una Descripción.',
                  'warning'
              ).then(function() { });
              return false;
          }

      return true;
    }
    
    $(".img_post_historial").click(function () {
        window.open($(this).attr("src"), 'popUpWindow', 
        "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
    });

    $(document).on('click', '#download_file_historial', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>Snappy/Descargar_Imagen_Cargo/" + image_id);
    });

    $(document).on('click', '#delete_file_historial', function () {
        var image_id = $(this).data('image_id');
        var file_col = $('#i_' + image_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>Snappy/Delete_Imagen_Cargo',
            data: {'image_id': image_id},
            success: function (data) {
                file_col.remove();            
            }
        });
    });
</script>

<?php $this->load->view('Admin/footer'); ?>