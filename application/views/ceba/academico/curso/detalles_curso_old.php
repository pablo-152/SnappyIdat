<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('ceba/header'); ?>

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

    /*
    Styling
    */

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

    /*
    Demo purposes only
    */
    *,
    *:before,
    *:after {
      box-sizing: border-box;
    }

    .tabset {
      margin: 8px 15px;
    }

    /*.tabset{
    }*/



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

  
</style>

<div class="app-sidebar__overlay" data-toggle="sidebar">
</div>
<?php $this->load->view('ceba/nav'); ?>
<main class="app-content" method="POST" enctype="multipart/form-data"> 
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <div class="row tile-title line-head"  style="background-color: #C1C1C1;">
                                        <div class="col" style="vertical-align: middle;">   
                                            <b>Detalle <?php echo $get_id[0]['id_curso']; ?> Secundaria: </b>
                                        </div>
                                        <div class="col" align="right">
                                        <?php foreach($get_id as $list) {  ?>
                                          <?php if($list['estado_cierre'] ==1){ ?>
                                            <a type="button" >
                                              <img class="top" src="<?= base_url() ?>template/img/ceba/editar2.png" alt="" width="50" onclick="Curso_Cerrado();">
                                            </a>
                                            <a type="button" >
                                              <img class="top" src="<?= base_url() ?>template/img/ceba/requisitos.png" alt="" width="50" onclick="Curso_Cerrado();">
                                            </a>
                                            <a type="button" >
                                              <img class="top" src="<?= base_url() ?>template/img/ceba/asociar1.png" alt="" width="50" onclick="Curso_Cerrado();">
                                            </a>
                                            <a type="button" >
                                              <img class="top" src="<?= base_url() ?>template/img/ceba/cerrar1.png" alt="" width="50" onclick="Curso_Cerrado();">
                                            </a>
                                            <a onclick="Exportar();" style="cursor:pointer">
                                              <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                                            </a>
                                            <a type="button" href="<?= site_url('Ceba/Curso') ?>">
                                              <img class="top" src="<?= base_url() ?>template/img/ceba/regresar2.png" width="50" alt="">
                                            </a>
                                          <?php }else{ ?>
                                              <a type="button" title="Editar Curso"  data-dismiss="modal" data-toggle="modal" data-target="#LargeLabelModal" LargeLabelModal="<?= site_url('Ceba/Modal_Update_Curso') ?>/<?php echo $list["id_curso"]; ?>">
                                                <!--<img src="<?= base_url() ?>template/img/ceba/editar.png" alt="">-->
                                                <img class="top" src="<?= base_url() ?>template/img/ceba/editar2.png" width="50" alt="">
                                              </a>
                                              <a type="button" title="Nuevo Requisito"  data-dismiss="modal" data-toggle="modal" data-target="#LargeLabelModal" LargeLabelModal="<?= site_url('Ceba/Modal_Requisito') ?>/<?php echo $list["id_curso"]; ?>">
                                                <!--<img src="<?= base_url() ?>template/img/ceba/requisitos1.png" alt="">-->
                                                <img class="top" src="<?= base_url() ?>template/img/ceba/requisitos.png" width="50" alt="">
                                              </a>
                                              <a type="button" title="Asociar Tema"  data-dismiss="modal" data-toggle="modal" data-target="#LargeLabelModal" LargeLabelModal="<?= site_url('Ceba/Modal_Tema_Asociar') ?>/<?php echo $list["id_curso"]; ?>">
                                                <!--<img src="<?= base_url() ?>template/img/ceba/asociar.png" alt="">-->
                                                <img class="top" src="<?= base_url() ?>template/img/ceba/asociar1.png" width="50" alt="">
                                              </a>
                                              <a type="button" title="Cerrar Curso"  id="createProductBtn" data-loading-text="Loading..." autocomplete="off">
                                                <!--<img src="<?= base_url() ?>template/img/ceba/cerrar.png" alt="">-->
                                                <img class="top" src="<?= base_url() ?>template/img/ceba/cerrar1.png" width="50" alt="" onclick="Cerrar_Curso('<?php echo $list['id_curso']; ?>')">
                                              </a>
                                              <a  style="vertical-align: left;" href="#">
                                                <img src="<?= base_url() ?>template/img/excel.png" width="50" title="Exportar Excel" />
                                              </a>
                                              <a type="button" title="Regresar" href="<?= site_url('Ceba/Curso') ?>">
                                                <!--<img src="<?= base_url() ?>template/img/ceba/regresar.png" alt="">-->
                                                <img class="top" src="<?= base_url() ?>template/img/ceba/regresar2.png" width="50" alt="">
                                              </a>
                                        <?php }} ?>
                                            <!--<form action="../../form-result.php" target="_blank">-->
                                            
                                        </div>
                                    </div>
                                </div>
                                <!--<?php foreach($get_id as $list) {  ?>
                                  
                                        <?php if($list['estado_cierre'] ==1){ ?>

                                          <a type="button" title="Editar Curso">
                                          <div class="contenedor1">
                                              <img src="<?= base_url() ?>template/img/ceba/editar.png" alt="">
                                              <img class="top" src="<?= base_url() ?>template/img/ceba/editar2.png" alt="" onclick="Curso_Cerrado();">
                                          </div>
                                          </a>
                                          
                                          <a type="button" title="Editar Curso" >
                                          <div class="contenedor1">
                                              <img src="<?= base_url() ?>template/img/ceba/requisitos1.png" alt="">
                                              <img class="top" src="<?= base_url() ?>template/img/ceba/requisitos.png" alt="" onclick="Curso_Cerrado();">
                                          </div>
                                          </a>

                                          <a type="button" title="Nuevo Requisito">
                                          <div class="contenedor1">
                                              <img src="<?= base_url() ?>template/img/ceba/asociar.png" alt="">
                                              <img class="top" src="<?= base_url() ?>template/img/ceba/asociar1.png" alt="" onclick="Curso_Cerrado();">
                                          </div>
                                          </a>
                                          
                                          <a type="button" title="Cerrar Curso" >
                                            <div class="contenedor1">
                                                <img src="<?= base_url() ?>template/img/ceba/cerrar.png" alt="">
                                                <img class="top" src="<?= base_url() ?>template/img/ceba/cerrar1.png" alt="" onclick="Curso_Cerrado();">
                                            </div>
                                          </a>
                                        
                                        <?php }else { ?>
                                        
                                          <a type="button" title="Editar Curso"  data-dismiss="modal" data-toggle="modal" data-target="#LargeLabelModal" 
                                            LargeLabelModal="<?= site_url('Ceba/Modal_Update_Curso') ?>/<?php echo $list["id_curso"]; ?>">
                                            <div class="contenedor1">
                                                <img src="<?= base_url() ?>template/img/ceba/editar.png" alt="">
                                                <img class="top" src="<?= base_url() ?>template/img/ceba/editar2.png" alt="">
                                            </div>
                                          </a>
                                          
                                          <a type="button" title="Nuevo Requisito"  data-dismiss="modal" data-toggle="modal" data-target="#LargeLabelModal" 
                                            LargeLabelModal="<?= site_url('Ceba/Modal_Requisito') ?>/<?php echo $list["id_curso"]; ?>">
                                            <div class="contenedor1">
                                                <img src="<?= base_url() ?>template/img/ceba/requisitos1.png" alt="">
                                                <img class="top" src="<?= base_url() ?>template/img/ceba/requisitos.png" alt="">
                                            </div>
                                          </a>
                                          <a type="button" title="Asociar Tema"  data-dismiss="modal" data-toggle="modal" data-target="#LargeLabelModal" 
                                            LargeLabelModal="<?= site_url('Ceba/Modal_Tema_Asociar') ?>/<?php echo $list["id_curso"]; ?>">
                                            <div class="contenedor1">
                                                <img src="<?= base_url() ?>template/img/ceba/asociar.png" alt="">
                                                <img class="top" src="<?= base_url() ?>template/img/ceba/asociar1.png" alt="">
                                            </div>
                                          </a>
                                          
                                          <a type="button" title="Cerrar Curso"  id="createProductBtn" data-loading-text="Loading..." autocomplete="off">
                                            <div class="contenedor1">
                                                <img src="<?= base_url() ?>template/img/ceba/cerrar.png" alt="">
                                                <img class="top" src="<?= base_url() ?>template/img/ceba/cerrar1.png" alt="" onclick="Cerrar_Curso('<?php echo $list['id_curso']; ?>')">
                                            </div>
                                          </a>  
                                        <?php } ?>

                                        <a type="button" href="<?= site_url('Ceba/Curso') ?>">
                                          <div class="contenedor1">
                                              <img src="<?= base_url() ?>template/img/ceba/regresar.png" alt="">
                                              <img class="top" src="<?= base_url() ?>template/img/ceba/regresar2.png" alt="">
                                          </div>
                                        </a>
                                <?php } ?>-->
                            </div>  
                        </div> 
                    </div>

                            <div class="modal-content">
                              <br>
                              <form class="form-horizontal"    class="formulario">
                                <table width="100%" class="box-body table-responsive">
                                    <tr>
                                          <th width="10%">
                                                <div class="form-group col-md-2">
                                                <label class="col-sm-3 control-label text-bold">Grado: </label>
                                                </div>
                                          </th>
                                          <th width="20%">
                                            <div class="form-group col-md-10">
                                                  <select disabled class="form-control" name="id_grado" id="id_grado">
                                                        <option value="0">Seleccione</option>
                                                        <?php foreach($list_grado as $nivel){ 
                                                        if($get_id[0]['id_grado'] == $nivel['id_grado']){ ?>
                                                        <option  selected value="<?php echo $nivel['id_grado'] ; ?>">
                                                        <?php echo $nivel['descripcion_grado'];?></option>
                                                        <?php }else
                                                        {?>
                                                        <option value="<?php echo $nivel['id_grado']; ?>"><?php echo $nivel['nom_grado'];?></option>
                                                        <?php }} ?>
                                                </select>
                                            </div> 
                                          </th>

                                        <th width="10%">
                                            <div class="form-group col-md-2">
                                                <label class="col-sm-3 control-label text-bold">Año: </label>
                                            </div>
                                        </th>

                                        <th width="20%">
                                            <div class="form-group col-md-10">
                                                <select disabled class="form-control" name="id_anio" id="id_anio" >
                                                        <option value="0">Seleccione</option>
                                                        <?php foreach($list_anio as $nivel){ 
                                                        if($get_id[0]['id_anio'] == $nivel['id_anio']){ ?>
                                                        <option selected value="<?php echo $nivel['id_anio'] ; ?>">
                                                        <?php echo $nivel['nom_anio'];?></option>
                                                        <?php }else
                                                        {?>
                                                        <option value="<?php echo $nivel['id_anio']; ?>"><?php echo $nivel['nom_anio'];?></option>
                                                        <?php }} ?>
                                                </select>
                                            </div>
                                        </th>

                                    </tr>

                                    <tr>
                                        <th width="10%">
                                            <div class="form-group col-md-2">
                                                <label  class="col-sm-3 control-label text-bold">Inicio Matrículas: </label>
                                            </div>
                                        </th>
                                        
                                        <th width="10%">
                                            <div class="form-group col-md-10">
                                                <input disabled value="<?php echo $get_id[0]['fec_inicio']; ?>" class="form-control" required type="date" id="ini_funciones" name="ini_funciones" placeholder= "Seleccionar Fecha inicio de matricula" type="text" />
                                            </div>
                                        </th>

                                        <th width="10%">
                                            <div class="form-group col-md-2">
                                                <label class="col-sm-3 control-label text-bold">Fin Matrículas: </label>
                                            </div>
                                        </th>
                                        <th width="10%">
                                            <div class="form-group col-md-10">
                                                <input disabled value="<?php echo $get_id[0]['fec_fin']; ?>" class="form-control" required type="date" id="fec_fin" name="fec_fin" placeholder= "Seleccionar Fecha fin de matricula" type="text" />
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                      <th width="10%">
                                            <div class="form-group col-md-2">
                                                    <label class="col-sm-3 control-label text-bold">Estado: </label>
                                                </div>
                                        </th>
                                        <th width="20%">
                                            <div class="form-group col-md-10" >
                                              
                                                <select disabled class="form-control" name="id_status" id="id_status">
                                                <option value="0" <?php if (!(strcmp(0, $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                                                <?php foreach($list_estado as $estado){ ?>
                                                    <option value="<?php echo $estado['id_status']; ?>" <?php if (!(strcmp($estado['id_status'], $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>><?php echo $estado['nom_status'];?></option>
                                                <?php } ?>
                                                </select>
                                            </div>    
                                        </th>
                                        <th width="10%">
                                            <div class="form-group col-md-2">
                                                <label class="col-sm-3 control-label text-bold">Estado Cierre: </label>
                                            </div>
                                        </th>
                                        <th width="10%">
                                            
                                            <div class="form-group col-md-10">
                                            <?php if($get_id[0]['estado_cierre']==1 ) { ?>
                                                  <input disabled value="Cerrado" class="form-control" />
                                                  <?php }else{ ?>
                                                  <input disabled value="Abierto" class="form-control" />
                                            <?php } ?>
                                                  
                                            </div>
                                        </th>

                                    </tr>
                                            
                                </table>
                              </form>
                            </div>

                            <div class="tabset">
                                      <!-- Tab 1 -->
                                      <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>
                                      <label for="tab1">Requisitos</label>
                                      <!-- Tab 2 -->
                                      <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier">
                                      <label for="tab2">Salones</label>
                                      <!-- Tab 3 -->
                                      <input type="radio" name="tabset" id="tab3" aria-controls="rauchbier1">
                                      <label for="tab3">Áreas</label>                                  
                                      <!-- Tab 4 -->
                                      <input type="radio" name="tabset" id="tab4" aria-controls="rauchbier2">
                                      <label for="tab4">Asignaturas</label>
                                      <!-- Tab 5 -->
                                      <input type="radio" name="tabset" id="tab5" aria-controls="rauchbier3">
                                      <label  for="tab5">Temas</label>
                                      <!-- Tab 6 -->
                                      <input type="radio" name="tabset" id="tab6" aria-controls="rauchbier4">
                                      <label  for="tab6">Estudiantes</label>                               
                                      <!-- Tab 7 -->
                                      <input type="radio" name="tabset" id="tab7" aria-controls="rauchbier6">
                                      <label  for="tab7">Matricula Pendiente</label>                                      


                                      <div class="tab-panels">
                                          <section id="marzen" class="tab-panel">
                                                <div class="box-body table-responsive">
                                                      <!--<a  style="vertical-align: left;" href="<?= site_url('Ceba/Excel_Requisito') ?>/<?php echo $list['id_curso'] ?>">
                                                        <img src="<?= base_url() ?>template/img/excel.png" title="Exportar Excel" />
                                                      </a>-->
                                                      <table id="example2" class="table table-striped table-bordered text-center" >
                                                            <thead>
                                                                <tr style="background-color: #E5E5E5;">
                                                                  <th  width="2%" ><div align="center">Tipo de Requisito</div></th>
                                                                  <th width="3%"><div align="center">Descripción</div></th>
                                                                  <th width="5%"><div align="center">Estado</div></th>
                                                                  <th width="1%">&nbsp;</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                              <?php foreach($list_requisito_curso as $list) {  ?>
                                                                  <tr class="even pointer">
                                                                    <td  align="left"><?php echo $list['nom_tipo_requisito']; ?></td>  
                                                                    <td  align="left"><?php echo $list['desc_requisito']; ?></td> 
                                                                    <td  align="center"><?php echo $list['nom_status']; ?></td>
                                                                    <td  align="center">
                                                                  <img title="Editar Requisito" data-toggle="modal"  data-dismiss="modal" data-target="#LargeLabelModal" 
                                                                                LargeLabelModal="<?= site_url('Ceba/Requisito_Editar') ?>/<?php echo $list["id_requisito"]; ?>/<?php echo $list['id_curso']; ?>" src="<?= base_url() ?>template/img/editar.png" 
                                                                                style="cursor:pointer; cursor: hand;width:22px;height:22px;" />
                                                                    </td>
                                                                  </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                      </table>
                                                </div>  
                                          </section>

                                          <section id="rauchbier" class="tab-panel">
                                                <div class="box-body table-responsive">
                                                      ESTE AL FINAL
                                                </div>
                                          </section>

                                          <!-- DETALLES DE CURSOS - AREAS -->
                                          <section id="rauchbier1" class="tab-panel">
                                              <div class="box-body table-responsive">
                                                      
                                                <table id="example3" class="table table-striped table-bordered text-center" width="50%" >
                                                    <thead>
                                                        <tr style="background-color: #E5E5E5;">
                                                          <!--<th  width="2%" ><div VALIGN="MIDDLE" ALIGN="CENTER">Unidad</div></th>-->
                                                          <th width="3%"><div align="center">unidad</div></th>
                                                          <th width="20%"><div align="center">Area</div></th>
                                                          <!--<th width="5%"><div align="center">Nombre de Tema</div></th>-->
                                                          <th width="3%">&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      <?php foreach($list_tema_asociar_curso as $list) {  ?>
                                                          <tr class="even pointer">
                                                            <td  align="left"><?php echo $list['nom_unidad']; ?></td> 
                                                            <td   align="left"><?php echo $list['descripcion_area']; ?></td>  
                                                            <!--<td  align="center"><?php echo $list['descripcion_asignatura']; ?></td> 
                                                            <td  align="center"><?php echo $list['desc_tema']; ?></td>-->
                                                            <td  align="center">
                                                            <img title="Editar Tema Asociar" data-toggle="modal"  data-dismiss="modal" data-target="#LargeLabelModal" 
                                                                  LargeLabelModal="<?= site_url('Ceba/Modal_Tema_Asociar_Editar') ?>/<?php echo $list["id_tema_asociar"]; ?>/<?php echo $list['id_curso']; ?>" src="<?= base_url() ?>template/img/editar.png" 
                                                                  style="cursor:pointer; cursor: hand;width:22px;height:22px;" />
                                                            </td>
                                                          </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                              </div>  
                                          </section>

                                          <!-- DETALLES DE CURSOS - ASIGNATURAS -->
                                          <section id="rauchbier2" class="tab-panel">
                                                <div class="box-body table-responsive">
                                                
                                                  <table id="example4" class="table table-striped table-bordered text-center" width="80%">
                                                        <thead>
                                                            <tr style="background-color: #E5E5E5;">
                                                              <th  width="2%" ><div VALIGN="MIDDLE" ALIGN="CENTER">Unidad</div></th>
                                                              <th width="3%"><div align="center">Área</div></th>
                                                              <th width="5%"><div align="center">Nombre Asignatura</div></th>
                                                              <!--<th width="5%"><div align="center">Nombre de Tema</div></th>-->
                                                              <th width="1%">&nbsp;</th>
                                                            </tr>
                                                        </thead>
                                                      <!-- <thead class="filteredes" >
                                                                <tr align="center">
                                                                    <th class="filtered" >Unidad</th>
                                                                    <th class="filtered" >Área</th>
                                                                    <th class="filtered" >Nombre Asignatura</th>
                                                                    <th class="filtered" >Nombre de Tema</th>
                                                                    <th></th>
                                                                </tr>
                                                          </thead>-->
                                                        <tbody>
                                                          <?php foreach($list_tema_asociar_curso as $list) {  ?>
                                                              <tr class="even pointer">
                                                                <td  align="left"><?php echo $list['nom_unidad']; ?></td> 
                                                                <td  valingn="middle" align="center"><?php echo $list['descripcion_area']; ?></td>  
                                                                <td  align="left"><?php echo $list['descripcion_asignatura']; ?></td> 
                                                                <!--<td  align="center"><?php echo $list['desc_tema']; ?></td>-->
                                                                <td  align="left">
                                                                  <img title="Editar Tema Asociar" data-toggle="modal"  data-dismiss="modal" data-target="#LargeLabelModal" 
                                                                      LargeLabelModal="<?= site_url('Ceba/Modal_Tema_Asociar_Editar') ?>/<?php echo $list["id_tema_asociar"]; ?>/<?php echo $list['id_curso']; ?>" src="<?= base_url() ?>template/img/editar.png" 
                                                                      style="cursor:pointer; cursor: hand;width:22px;height:22px;" />
                                                                </td>
                                                              </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                  </table>
                                                </div>
                                          </section>

                                          <!--TEMAS -->
                                        
                                          <section id="rauchbier3" class="tab-panel">
                                              <div class="box-body table-responsive">
                                              
                                                <table id="example5" class="table table-striped table-bordered text-center" width="100%" >
                                                      <thead>
                                                          <tr style="background-color: #E5E5E5;">
                                                            <th  width="10%" ><div VALIGN="MIDDLE" ALIGN="CENTER">Unidad</div></th>
                                                            <th width="15%"><div align="center">Área</div></th>
                                                            <th width="25%"><div align="center">Nombre Asignatura</div></th>
                                                            <th width="47%"><div align="center">Nombre de Tema</div></th>
                                                            <th width="3%">&nbsp;</th>
                                                          </tr>
                                                      </thead>
                                                      <!--<thead class="filteredes" >
                                                              <tr align="center">
                                                                  <th class="filtered" >Unidad</th>
                                                                  <th class="filtered" >Área</th>
                                                                  <th class="filtered" >Nombre Asignatura</th>
                                                                  <th class="filtered" >Nombre de Tema</th>
                                                                  <th></th>
                                                              </tr>
                                                        </thead>-->
                                                      <tbody>
                                                        <?php foreach($list_tema_asociar_curso as $list) {  ?>
                                                            <tr class="even pointer">
                                                              <td  align="left"><?php echo $list['nom_unidad']; ?></td> 
                                                              <td  valingn="middle" align="left"><?php echo $list['descripcion_area']; ?></td>  
                                                              <td  align="left"><?php echo $list['descripcion_asignatura']; ?></td> 
                                                              <td  align="left"><?php echo $list['desc_tema']; ?></td>
                                                              <td  align="center">
                                                                
                                                                <img title="Editar Tema Asociar" data-toggle="modal"  data-dismiss="modal" data-target="#LargeLabelModal" 
                                                                    LargeLabelModal="<?= site_url('Ceba/Modal_Tema_Asociar_Editar') ?>/<?php echo $list["id_tema_asociar"]; ?>/<?php echo $list['id_curso']; ?>" src="<?= base_url() ?>template/img/editar.png" 
                                                                    style="cursor:pointer; cursor: hand;width:22px;height:22px;" />
                                                              </td>
                                                            </tr>
                                                          <?php } ?>
                                                      </tbody>
                                                </table>
                                              </div>
                                          </section>
                                          
                                          <!-- DETALLES DE CURSOS - ESTUDIANTES -->
                                          <section id="rauchbier4" class="tab-panel">
                                                <div class="box-body table-responsive">
                                                
                                                  <a title="Nuevo estudiante en Curso" style="cursor:pointer; cursor: hand;" data-toggle="modal" data-target="#acceso_modal" 
                                                  app_crear_per="<?= site_url('Ceba/Modal_Alumno_Curso') ?>/<?php echo $list['id_curso']; ?>">
                                                      <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo area" />
                                                  </a>
                                                  
                                                  <table id="example6" class="table table-striped table-bordered text-center" width="100%">
                                                        <thead>
                                                            <tr style="background-color: #E5E5E5;">
                                                              <!--<th  width="2%" ><div VALIGN="MIDDLE" ALIGN="CENTER">Unidad</div></th>-->
                                                              <!--<th width="3%"><div align="center">Área</div></th>-->
                                                              <th width="3%"><div align="center">Codigo</div></th>
                                                              <th width="5%"><div align="center">Nombre de Alumno</div></th>
                                                              <th width="5%"><div align="center">A. Paterno</div></th>
                                                              <th width="5%"><div align="center">A. Materno</div></th>
                                                              <th width="5%"><div align="center">Estado</div></th>
                                                              
                                                            </tr>
                                                        </thead>
                                                      <!-- <thead class="filteredes" >
                                                                <tr align="center">
                                                                <th class="filtered" >Unidad</th>
                                                                  <th class="filtered" >Área</th>
                                                                    <th class="filtered" >Codigo</th>
                                                                    <th class="filtered" >Nombre de Alumno</th>
                                                                    <th class="filtered" >A. Paterno</th>
                                                                    <th class="filtered" >A. Materno</th>
                                                                    <th class="filtered" >Estado</th>
                                                                    
                                                                </tr>
                                                          </thead>-->
                                                        <tbody>
                                                        <!--MODIFICA ACA-->
                                                          <?php foreach($list_alumno_asociar_curso as $list) {  ?>
                                                              <tr class="even pointer">
                                                              <!--<td  align="center"><?php echo $list['nom_unidad']; ?></td> -->
                                                              <!--<td  align="center"><?php echo $list['descripcion_area']; ?></td> -->
                                                                <td  align="left"><?php echo $list['cod_alum']; ?></td>    
                                                                <td  align="left"><?php echo $list['alum_nom']; ?></td> 
                                                                <td  align="left"><?php echo $list['alum_apater']; ?></td>
                                                                <td  align="left"><?php echo $list['alum_amater']; ?></td>
                                                                <td  align="center"><?php echo $list['nom_estadoa']; ?></td>
                                                                <!--
                                                                <td  align="center">

                                                                  <button  title="Editar Tema Asociar" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#LargeLabelModal" 
                                                                            LargeLabelModal="<?= site_url('Ceba/Modal_Tema_Asociar_Editar') ?>/<?php echo $list['id_alumno_asociar']; ?>/<?php echo $list['id_curso']; ?>">
                                                                              <i class="icon fa fa-pencil-square-o"></i> 
                                                                  </button>
                                                                </td>
                                                                -->
                                                              </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                  </table>
                                            
                                                </div>
                                          </section>

                                          <section id="rauchbier6" class="tab-panel">
                                                <div class="box-body table-responsive">
                                                          4444444444
                                                </div>
                                          </section>

                                      </div>
                                      
                            </div>
                            
                       
                </div>
            </div>
        </div>
    </div>    
</main>

<script>
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
            dom: 'Bfrtip',
            pageLength: 25
        } );

    } );
</script>

<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#example2 thead tr').clone(true).appendTo( '#example2 thead' );
        $('#example2 thead tr:eq(1) th').each( function (i) {
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

        var table = $('#example2').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            dom: 'Bfrtip',
            pageLength: 25
        } );

    } );
</script>

<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#example3 thead tr').clone(true).appendTo( '#example3 thead' );
        $('#example3 thead tr:eq(1) th').each( function (i) {
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

        var table = $('#example3').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            dom: 'Bfrtip',
            pageLength: 25
        } );

    } );
</script>

<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
        $('#example4 thead tr:eq(1) th').each( function (i) {
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

        var table = $('#example4').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            dom: 'Bfrtip',
            pageLength: 25
        } );

    } );
</script>

<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#example5 thead tr').clone(true).appendTo( '#example5 thead' );
        $('#example5 thead tr:eq(1) th').each( function (i) {
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

        var table = $('#example5').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            dom: 'Bfrtip',
            pageLength: 25
        } );

    } );
</script>

<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#example6 thead tr').clone(true).appendTo( '#example6 thead' );
        $('#example6 thead tr:eq(1) th').each( function (i) {
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

        var table = $('#example6').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            dom: 'Bfrtip',
            pageLength: 25
        } );

    } );
</script>


<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('ceba/footer'); ?>