<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$nivel = $_SESSION['usuario'][0]['id_nivel'];
?>
<?php $this->load->view('view_IFV/header'); ?>

<style>
    .tabset > input[type="radio"] {
      position: absolute;
      left: -200vw;
    }

    .tabset .tab-panel {
      display: none;
    }

    .tabset > input:first-child:checked ~ .tab-panels > .tab-panel:first-child,
    .tabset > input:nth-child(3):checked ~ .tab-panels > .tab-panel:nth-child(2),
    .tabset > input:nth-child(5):checked ~ .tab-panels > .tab-panel:nth-child(3),
    .tabset > input:nth-child(7):checked ~ .tab-panels > .tab-panel:nth-child(4),
    .tabset > input:nth-child(9):checked ~ .tab-panels > .tab-panel:nth-child(5),
    .tabset > input:nth-child(11):checked ~ .tab-panels > .tab-panel:nth-child(6){
      display: block;
    }


    .tabset > label {
      position: relative;
      display: inline-block;
      padding: 15px 15px 25px;
      border: 1px solid transparent;
      border-bottom: 0;
      cursor: pointer;
      font-weight: 600;
      background: #799dfd5c;
    }

    .tabset > label::after {
      content: "";
      position: absolute;
      left: 15px;
      bottom: 10px;
      width: 22px;
      height: 4px;
      background: #8d8d8d;
    }

    .tabset > label:hover,
    .tabset > input:focus + label {
      color: #06c;
    }

    .tabset > label:hover::after,
    .tabset > input:focus + label::after,
    .tabset > input:checked + label::after {
      background: #06c;
    }

    .tabset > input:checked + label {
      border-color: #ccc;
      border-bottom: 1px solid #fff;
      margin-bottom: -1px;
    }

    .tab-panel {
      padding: 30px 0;
      border-top: 1px solid #ccc;
    }

    *,
    *:before,
    *:after {
      box-sizing: border-box;
    }

    .tabset {
      margin: 8px 15px;
    }

    .contenedor1 {
      position: relative;
      height: 80px;
      width: 80px;
      float: left;

    }

    .contenedor1 img {
      position: absolute;
      left: 0;
      transition: opacity 0.3s ease-in-out;
      height: 80px;
      width: 80px;
    }

    .contenedor1 img.top:hover {
      opacity: 0;
      height: 80px;
      width: 80px;
    }

    table th {
      text-align: center;
    }

</style>

<style>
    #div_especialidade{
        background-color:#d8d7d75c;
        padding-top:25px;
        padding-bottom:25px;
    }

    #parte_especialidad{
        width: 19.7%;
        display: inline-block;
        vertical-align: text-top;
    }
    
    #p_especialidad{
        font-weight: bold;
        width: 100%;
        text-overflow: ellipsis;
    }

    .input_little{
        width: 40px;
    }

    .color_little{
        background-color: #F7BD56;
        border-color: #F7BD56;
    }
</style>

<?php $this->load->view('view_IFV/nav'); ?>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;height:80px">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Detalle Centro - <?php echo $get_id[0]['referencia'] ?></b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a type="button" data-toggle="modal" data-target="#modal_form_vertical" modal_form_vertical="<?= site_url('AppIFV/Modal_Accion') ?>/<?php echo $get_id[0]['id_centro'] ?>"> 
                            <img style="margin-right:5px;cursor:pointer;" src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo Ticket" />
                        </a>
                        <a type="button" href="<?= site_url('AppIFV/Vista_Update_Centro') ?>/<?php echo $get_id[0]['id_centro']; ?>">
                            <img title="Editar Ticket" style="margin-right:5px;cursor:pointer;"  src="<?= base_url() ?>template/img/editar_grande.png" alt="">
                        </a>
                        <a title="Nueva Dirección" style="cursor:pointer; cursor: hand;margin-right:5px" data-toggle="modal"  data-target="#modal_full" modal_full="<?= site_url('AppIFV/Modal_agregar_direccion/') ?><?php echo $get_id[0]['id_centro'] ?>">
                            <img src="<?= base_url() ?>template/img/direccion.png" alt="Exportar Excel">
                        </a>
                        <a title="Nuevo Archivo" style="cursor:pointer; cursor: hand;margin-right:5px" data-toggle="modal"  data-target="#modal_form_vertical" modal_form_vertical="<?= site_url('AppIFV/Modal_archivo_centro/') ?><?php echo $get_id[0]['id_centro'] ?>">
                            <img src="<?= base_url() ?>template/img/icono-subir-fv.png" alt="Exportar Excel">
                        </a>
                        <a type="button" href="<?= site_url('AppIFV/Centro') ?>" >
                            <img src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-md-12 row">
                    <div class="form-group col-md-1">
                        <label class="control-label text-bold">Ref.:</label>
                        <input type="hidden" class="form-control" id="hoy" name="hoy" value="<?php echo date('Y-m-d'); ?>">
                        <input type="text" class="form-control" style="background-color:#715d74;color:white" readonly id="referenciae" name="referenciae" value="<?php echo $get_id[0]['referencia']; ?>">
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Nombre Comercial:</label>
                        <input type="text" readonly class="form-control" id="nom_comerciale" name="nom_comerciale" value="<?php echo $get_id[0]['nom_comercial']; ?>">
                    </div>

                    <div class="form-group col-md-4">
                        <label class="control-label text-bold">Empresa: <span style="color:#939393;font-size:13px">(.SAC o .EIRL)</span></label>
                        <input type="text" readonly class="form-control" id="empresae" name="empresae" value="<?php echo $get_id[0]['empresa']; ?>">
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Convenio:</label>
                        <select disabled id="convenioe" name="convenioe" class="form-control" style="background-color:<?php if($get_id[0]['id_statush']==48){echo "#c5e0b4"; }if($get_id[0]['id_statush']==49){echo "#bdd7ee";}if($get_id[0]['id_statush']==50){echo "red";}if($get_id[0]['id_statush']==51){echo "#eaeaa3";}?>;color:<?php if($get_id[0]['id_statush']==48){echo "white"; }if($get_id[0]['id_statush']==50){echo "white";}?>">
                            <option style="background-color:#fff;color:black" selected ><?php echo $get_id[0]['nom_status'];?></option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Ruc:</label>
                        <input type="text" readonly class="form-control" maxlength="11" id="ruce" name="ruce" value="<?php echo $get_id[0]['ruc']; ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Web:</label>
                        <input type="text" readonly class="form-control" id="webe" name="webe" value="<?php echo $get_id[0]['web']; ?>">
                    </div>
                    <div class="form-group col-md-2" >
                        <label class="control-label text-bold" title="Contacto Princial" style="cursor:help">Cont. Principal (CP):</label>
                        <input type="text" readonly class="form-control" value="<?php echo $get_id[0]['persona'] ?>">
                    </div>
                    <div class="form-group col-md-2" >
                        <label class="control-label text-bold" title="Celular de Contacto Princial" style="cursor:help">Celular (CP):</label>
                        <input type="text" readonly class="form-control" value="<?php if($get_id[0]['celular_pprin']!=0){echo $get_id[0]['celular_pprin'];} ?>">
                    </div>
                    <div class="form-group col-md-3" >
                        <label class="control-label text-bold" title="Correo de Contacto Princial" style="cursor:help">Correo (CP):</label>
                        <input type="text" readonly class="form-control" value="<?php echo $get_id[0]['correo_pprin'] ?>">
                    </div>
                </div>

                
                <div class="col-md-12" style="background-color:#d8d7d75c" >
                    
                        <div class="col-lg-12">
                        <?php if(count($list_documentos)>0){ ?>
                            <div class="form-group col-md-12">
                                <label class="control-label text-bold label_tabla">Archivos:</label>
                            </div>
                        <?php } ?>

                        <?php foreach($list_documentos as $list) {  ?>
                            
                            <div id="i_<?php echo  $list['id_centro_documento']?>" class="form-group col-sm-2" >
                                <div id="lista_escogida" style="background-color:#4473c5;color:white">
                                    <?php echo $list['nombre'] ?><br>
                                    <a style="cursor:pointer;" class="download" type="button" id="download_documento_historial" data-image_id="<?php echo $list['id_centro_documento']?>">
                                        <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                                    </a>
                                    <a style="cursor:pointer;" class="delete" type="button" id="delete_documento_historial" data-image_id="<?php echo  $list['id_centro_documento']?>">
                                        <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                                    </a>
                                </div>
                            </div>  
                        <?php } ?>
                    </div>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-12">
                        <label class="control-label text-bold">Observaciones:</label>
                        <textarea class="form-control" disabled id="observacionese" name="observacionese" rows="2"><?php echo $get_id[0]['observaciones']; ?></textarea>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="row">
            <div class="tabset">
                <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>
                <label for="tab1">Direcciones</label>
                
                <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier">
                <label for="tab2">Historia</label>
                
                <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==10 || $_SESSION['usuario'][0]['id_usuario']==45 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                    <input type="radio" name="tabset" id="tab3" aria-controls="rauchbier1">
                    <label for="tab3">Contrato</label>     
                <?php } ?>                             
                
                <input type="radio" name="tabset" id="tab4" aria-controls="rauchbier2">
                <label for="tab4">Alumnos</label>
                
                <input type="radio" name="tabset" id="tab5" aria-controls="rauchbier3">
                <label  for="tab5">Visitas</label>                            
                
                <div class="tab-panels">
                    <!-- Direcciones -->
                    <section id="marzen" class="tab-panel">
                        <?php $u=1; foreach($list_direccion as $dir){?> 
                            <div class="col-md-12 row">
                                <div class="form-group col-md-6">
                                    <label class="control-label text-bold">Dirección <?php echo $u; ?>:</label>
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
                            
                                <div class="form-group col-md-2">
                                    <label class="control-label text-bold">Persona Cont: </label>
                                    <input type="text" readonly class="form-control" value="<?php echo $dir['contacto_dir']; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="control-label text-bold">Celular:</label>
                                    <input type="text" readonly class="form-control"  value="<?php if($dir['celular_dir']!=0){ echo $dir['celular_dir']; } ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="control-label text-bold">Tel Fijo:</label>
                                    <input type="text" readonly class="form-control"  value="<?php  echo $dir['tel_fijo']; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="control-label text-bold">Correo:</label>
                                    <input type="text" readonly class="form-control" value="<?php echo $dir['correo_dir'] ?>">
                                </div>

                                <div class="form-group col-md-2">
                                    <div class="row">
                                        &nbsp;&nbsp;
                                        <input type="checkbox" onclick="return false" <?php if($dir['cp']==1){ echo "checked"; } ?> value="1" class="mt-1"> 
                                        &nbsp;&nbsp;
                                        <label class="control-label text-bold">CP</label>
                                        &nbsp;&nbsp;
                                        <img title="Editar Dirección" data-toggle="modal" data-target="#modal_full" modal_full="<?= site_url('AppIFV/Modal_Update_DireccionCentro') ?>/<?php echo $dir["id_centro_direccion"]; ?>/<?php echo $get_id[0]['id_centro']; ?>"  src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;"  width="22" height="22" />
                                        <a href="#" class="" title="Eliminar" onclick="Eliminar_Direccion('<?php echo $dir['id_centro_direccion']; ?>','<?php echo $get_id[0]['id_centro']; ?>')" role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;" width="22" height="22"/></a>
                                    </div>
                                </div>
                            </div>
                        <?php $u=$u+1;} ?>
                    </section>

                    <!-- Historia -->                                
                    <section id="rauchbier" class="tab-panel">
                        <div id="div_historial">
                            <table width="100%" id="documentos_tb" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr style="background-color: #E5E5E5;">
                                        <th class="text-center" width="6%">Fecha</th>
                                        <th class="text-center" width="8%">Usuario</th>
                                        <th class="text-center" width="8%">Acción</th>
                                        <th class="text-center">Comentario</th>
                                        <th class="text-center" width="8%">Estado</th>
                                        <?php if($id_nivel==1 || $id_nivel==6 || $id_nivel==7 || $id_nivel==9 || $_SESSION['usuario'][0]['id_usuario']==45){ ?> 
                                        <td class="text-center" width="3%"></td>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php foreach($list_historial as $list) {  ?>
                                        <tr class="even pointer text-center">
                                            <td class="text-center"><?php echo $list['fec_accion']; ?></td> 
                                            <td><?php echo $list['usuario_codigo']; ?></td> 
                                            <td class="text-center"><?php if($list['id_accion']!=0){echo $list['nom_accion']; }else{echo "Observación"; } ?></td>  
                                            <td><?php echo $list['comentario']; ?></td>  
                                            <td class="text-center"><?php echo $list['nom_status']; ?></td>   
                                            <td class="text-center">
                                            <?php if($id_nivel==1 || $id_nivel==6 || $id_nivel==7 || $id_nivel==9 || $_SESSION['usuario'][0]['id_usuario']==45){ ?> 
                                                <img title="Editar" data-toggle="modal"  data-dismiss="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Update_Historial_Centro') ?>/<?php echo $list["id_centro_historial"]; ?>/<?php echo $get_id[0]['id_centro']; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;width:22px;height:22px;" />
                                                <a href="#" class="" title="Eliminar" onclick="Eliminar_Historial_Centro('<?php echo $list['id_centro_historial']; ?>','<?php echo $get_id[0]['id_centro']; ?>')" role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;" width="22" height="22"/></a>
                                            <?php } ?> 
                                            </td>
                                        </tr>
                                        <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                    
                    <!-- Contrato -->
                    <section id="rauchbier1" class="tab-panel">
                        <div class="col-md-12 row">
                            <div class="form-group col-md-5">
                            </div>

                            <div class="form-group col-md-12 mt-3">
                                <label class="control-label text-bold">Centros Prácticas para:</label>
                            </div>
                        </div>
                        
                        <div id="div_especialidade" class="form-group col-md-12">
                            <div class="form-group col-md-12 div_especilidad">
                                <?php $i=1; foreach($list_especialidad as $list){
                                    $cant_acu_par = 0;
                                    $p_esp = array_search($list['id_especialidad'],array_column($v_cen_esp,'id_especialidad')); 
                                    $p_esp_tot = array_search($list['id_especialidad'],array_column($v_cen_esp_tot,'id_especialidad')); 
    
                                    if(is_numeric($p_esp_tot)){
                                        $cantidad_esp = $v_cen_esp_tot[$p_esp_tot]['total'];
                                    }else{
                                        $cantidad_esp = "";
                                    }
                                    ?>
                                    <div id="parte_especialidad">
                                        <p nowrap id="p_especialidad"><?php echo $list['nom_tipo_especialidad']." ".$list['abreviatura'] ?></p><br>
                                        <p><input type="text" class="input_little" readonly value="<?php echo $cantidad_esp; ?>"></p>
                                        <?php 
                                            foreach($list_producto as $prod){
                                                if($prod['id_tipo_especialidad']==$list['id_tipo_especialidad'] && $prod['id_especialidad']==$list['id_especialidad']){
                                                    $posicion = array_search($prod['id_producto'],array_column($v_cen_esp,'id_producto'));

                                                    if(is_numeric($posicion)){
                                                        $cantidad = $v_cen_esp[$posicion]['cantidad'];
                                                        if($cantidad==""){
                                                            $canti = 0;
                                                        }else{
                                                            $canti = $v_cen_esp[$posicion]['cantidad'];
                                                        }
                                                    }else{
                                                        $cantidad = "";
                                                        $canti = 0;
                                                    }
    
                                                    $cant_acu_par = $cant_acu_par + $canti;
                                                    ?>
                                                    <label>
                                                        <input type="text" class="input_little" readonly value="<?php echo $cantidad; ?>">
                                                        <input onclick="return false" type="checkbox" id="id_producto" <?php if($prod['id_centro_especialidad']!=""){echo "checked"; }?> name="id_producto[]" value="<?php echo $prod['id_producto']."-".$list['id_especialidad']; ?>" class="check_carrera" >
                                                        <span style="font-weight:normal"><?php echo $prod['nom_producto']; ?></span>&nbsp;&nbsp;
                                                    </label><br>
                                                <?php }  ?>
                                            <?php }
                                        ?>
                                        <p><input type="text" class="input_little color_little" readonly value="<?php if($cantidad_esp!=""){ echo $cantidad_esp; }else{ echo $cant_acu_par; } ?>"></p>
                                    </div>
                                <?php $i=$i+1; } ?>
                            </div>

                            <div class="form-group col-md-12">
                                <div class="form-group col-md-2">
                                    <label class="control-label text-bold">Fecha Firma:</label>
                                    <input type="date" class="form-control" readonly id="fecha_firmae" name="fecha_firmae" value="<?php echo $get_id[0]['fec_firma'] ?>">
                                </div>
                                
                                <div class="form-group col-md-2">
                                    <label class="control-label text-bold">Validad de:</label>
                                    <input type="date" readonly class="form-control" id="val_dee" name="val_dee" value="<?php echo $get_id[0]['val_de'] ?>">
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="control-label text-bold">A:</label>
                                    <input type="date" readonly class="form-control" id="val_ae" name="val_ae" onchange="Cambio_Convenio()" value="<?php echo $get_id[0]['val_a'] ?>">
                                </div>

                                <div class="form-group col-md-1">
                                    <label class="control-label text-bold">Documento:</label>
                                    <!--<input name="documentoe" readonly id="documentoe" type="file" size="100" required data-allowed-file-extensions='["jpeg|png|jpg|pdf|gif"]'>-->
                                    <?php if($get_id[0]['documento']!="" && ($nivel==1 || $nivel==6 || $nivel==7)){?> 
                                        <div id="div_img">
                                            <a style="cursor:pointer;" class="download" type="button" id="download_file_centro" data-image_id="<?php echo $get_id[0]['id_centro'] ?>">
                                                <img src="<?= base_url() ?>template/img/descarga_peq.png" style="cursor:pointer; cursor: hand;"/>
                                            </a>
                                            <a style="cursor:pointer;" class="delete" type="button" id="delete_file_centro" data-image_id="<?php echo  $get_id[0]['id_centro'] ?>">
                                                <img src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"/>
                                            </a>
                                        </div>
                                    <?php }?>
                                </div>
                                <?php if($nivel==1 || $nivel==6 || $nivel==7 || $nivel==12){?> 
                                    <div class="form-group col-md-3">
                                        <input type="checkbox" <?php if($get_id[0]['firmasf']==1){echo "checked"; } ?>>
                                        <span style="font-weight:normal"><b>Activo sin firma&nbsp;&nbsp;&nbsp;&nbsp;</b><?php 
                                        echo $get_id[0]['usuario_codigo']."&nbsp;".$get_id[0]['fecha_registro'] ?></span>
                                    </div>
                                <?php } ?>
                                
                                <div class="form-group col-md-12">
                                    <label class="control-label text-bold">Observaciones:</label>
                                    <textarea class="form-control"  rows="2"><?php echo $get_id[0]['observaciones_admin'] ?></textarea>
                                </div>
                            </div>
                        </div>
                    </section>
                    
                    <!-- Alumnos -->
                    <section id="rauchbier2" class="tab-panel">
                    </section>
                    
                    <!-- Visitas -->
                    <section id="rauchbier3" class="tab-panel">
                    </section>
                </div>
            </div>                         
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#practicas").addClass('active');
        $("#hpracticas").attr('aria-expanded', 'true');
        $("#centros").addClass('active');
		document.getElementById("rpracticas").style.display = "block";

    });

    $(document).ready(function() {
      $('#documentos_tb thead tr').clone(true).appendTo( '#documentos_tb thead' );
      $('#documentos_tb thead tr:eq(1) th').each( function (i) {
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

      var table=$('#documentos_tb').DataTable( {
          orderCellsTop: true,
          fixedHeader: true,
          pageLength: 50,
          "targets": 'no-sort',
            "aoColumnDefs" : [ {
            'bSortable' : false,
            'aTargets' : [ 0,1,2,3,4,5 ]
            } ]
      } );
  } );
</script>

<script>

    function Cambio_Convenio(){
        var cp =document.getElementById("cp").checked;
        var en_bd=parseFloat($('#direccion_bd').val());
        var v_a=$('#val_ae').val();
        
        const date1 = new Date($('#hoy').val()),
        date2 = new Date($('#val_ae').val()),
        time_difference = difference(date1,date2);

        var convenioe = document.getElementById('convenioe');

        if(en_bd=="0"){
            if(cp==true && time_difference>=0){
                //$('#convenioe').val('Activo');
                $('#estado').val('48');
                $('#convenioe').val('48');
                convenioe.style.backgroundColor  = 'green';
                convenioe.style.color  = 'white';
            }else if(cp==true && time_difference<0){
                //$('#convenioe').val('Renovar');
                $('#estado').val('50');
                $('#convenioe').val('50');
                convenioe.style.backgroundColor  = 'red';
                convenioe.style.color  = 'white';
            }else if(cp==false && v_a!=""){
                //$('#convenioe').val('Sin Convenio');
                $('#estado').val('51');
                $('#convenioe').val('51');
                convenioe.style.backgroundColor  = 'yellow';
                convenioe.style.color  = 'black';
            }else if(cp==false && v_a==""){
                //$('#convenioe').val('Inactivo'); 
                $('#estado').val('49');
                $('#convenioe').val('49');
                convenioe.style.backgroundColor  = 'skyblue';
            }
        }else{
            if(time_difference>=0){
                //$('#convenioe').val('Activo');
                $('#estado').val('48');
                $('#convenioe').val('48');
                convenioe.style.backgroundColor  = 'green';
            }
            else if(time_difference<0){
                //$('#convenioe').val('Renovar');
                $('#estado').val('50');
                $('#convenioe').val('50');
                convenioe.style.backgroundColor  = 'red';
            }
                
        }
        
    }

    function Estado(){
        var c=$('#convenioe').val();

        var convenioe = document.getElementById('convenioe');
        
        if(c==48){
            //$('#convenioe').val('Activo');
            $('#estado').val('48');
            $('#convenioe').val('48');
            convenioe.style.backgroundColor  = 'green';
            convenioe.style.color  = 'white';
        }else if(c==50){
            //$('#convenioe').val('Renovar');
            $('#estado').val('50');
            $('#convenioe').val('50');
            convenioe.style.backgroundColor  = 'red';
            convenioe.style.color  = 'white';
        }else if(c==51){
            //$('#convenioe').val('Sin Convenio');
            $('#estado').val('51');
            $('#convenioe').val('51');
            convenioe.style.backgroundColor  = 'yellow';
            convenioe.style.color  = 'black';
        }else if(c==49){
            //$('#convenioe').val('Inactivo'); 
            $('#estado').val('49');
            $('#convenioe').val('49');
            convenioe.style.backgroundColor  = 'skyblue';
        }
        else if(c==53){
            //$('#convenioe').val('Inactivo'); 
            $('#estado').val('53');
            $('#convenioe').val('53');
            convenioe.style.backgroundColor  = '';
        }
    }

    function difference(date1, date2) {  
        const date1utc = Date.UTC(date1.getFullYear(), date1.getMonth(), date1.getDate());
        const date2utc = Date.UTC(date2.getFullYear(), date2.getMonth(), date2.getDate());
            day = 1000*60*60*24;
        return(date2utc - date1utc)/day
    }

    $('#ruce').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('#telefonoe').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    function Provincia(){
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
        Distrito();
    }

    function Distrito(){
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
        var cp =document.getElementById("cp").checked;
        if($('#direccion').val().trim() != '' || $('#departamento').val() != '0' || $('#provincia').val() != '0' || $('#distrito').val() != '0' || cp==true) {
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


    

    function Eliminar_Direccion(id,id_c) {
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
        var id_centro=id_c;
        var url="<?php echo site_url(); ?>AppIFV/Delete_Direccion";
        $.ajax({
            type:"POST",
            url: url,
            data:{'id_centro_direccion':id_centro_direccion,'id_centro':id_centro},
            success:function () {
                window.location = "<?php echo site_url(); ?>AppIFV/Detalle_Centro/"+id_centro;
        }
        });
        
    }

    $(document).on('click', '#download_file_centro', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_Imagen_Centro/" + image_id);
    });

    $(document).on('click', '#delete_file_centro', function () {
        var image_id = $(this).data('image_id');
        var file_col = $('#div_img');
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>AppIFV/Delete_Imagen_Centro',
            data: {'image_id': image_id},
            success: function (data) {
                file_col.remove();            
            }
        });
    });

    $(document).on('click', '#download_documento_historial', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_Documento_Centro/" + image_id);
    });

    $(document).on('click', '#delete_documento_historial', function () {
        var image_id = $(this).data('image_id');
        var file_col = $('#i_' + image_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>AppIFV/Delete_Documento_Centro',
            data: {'image_id': image_id},
            success: function (data) {
                file_col.remove();            
            }
        });
    });

    function Eliminar_Historial_Centro(id,id_c) {
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
        var id_historial=id;
        var id_centro=id_c;
        var url="<?php echo site_url(); ?>AppIFV/Delete_historial_centro";
        $.ajax({
            type:"POST",
            url: url,
            data:{'id_historial':id_historial},
            success:function () {
                window.location = "<?php echo site_url(); ?>AppIFV/Detalle_Centro/"+id_centro;
        }
        });
        
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>
