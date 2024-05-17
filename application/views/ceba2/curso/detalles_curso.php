<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('Ceba/header'); ?>
<div class="app-sidebar__overlay" data-toggle="sidebar">
</div>
<?php $this->load->view('Ceba/nav'); ?>
<main class="app-content" method="POST" enctype="multipart/form-data"> 
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <div class="row tile-title line-head"  style="background-color: #E59866";>
                                        <div class="col" style="vertical-align: middle;">
                                            
                                            <b>Detalle de curso: <?php echo $get_id[0]['id_curso']; ?></b> 
            
                                        </div>
                                        </div>
                                        <div class="modal-header"> 

                
                                    </div>
                                </div>
                                <?php foreach($get_id as $list) {  ?>

                                <button type="button" title="Nuevo Curso" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#acceso_modal" 
                                            app_crear_per="<?= site_url('Ceba/Modal_Update_Curso') ?>/<?php echo $list["id_curso"]; ?>">
                                            <i class="glyphicon glyphicon-remove-sign"></i> Editar
                                </button>
                                <button type="button" title="Nuevo Curso" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#acceso_modal" 
                                            app_crear_per="<?= site_url('Ceba/Modal_Requisito') ?>">
                                            <i class="glyphicon glyphicon-remove-sign"></i> Crear Requisito
                                </button>
                                <button type="button" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..." autocomplete="off">
                                        <i class="glyphicon glyphicon-ok-sign"></i> Asociar Tema
                                </button>
                                <button type="button" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..." autocomplete="off">
                                        <i class="glyphicon glyphicon-ok-sign"></i> Crear Requisito
                                </button>
                                <button type="button" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..." autocomplete="off">
                                        <i class="glyphicon glyphicon-ok-sign"></i> Cerrar Curso
                                </button>
                                <button type="button" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..." autocomplete="off">
                                        <i class="glyphicon glyphicon-ok-sign"></i> Regresar
                                </button>
                                <?php } ?>

                                </div>
                              
                            </div> </div>

            <div class="modal-content">

                <form class="form-horizontal"    class="formulario">

                    <div class="modal-body" style="max-height:200px; overflow:auto;">

                        <table width="100%" class="box-body table-responsive">
                            <tr>

                            <th width="10%">
                                <div class="form-group col-md-2">
                                    <label class="col-sm-3 control-label text-bold">Año: </label>
                                    </div></th>

                            <th width="20%">
                                <div class="form-group col-md-10">
                                    <select disabled class="form-control" name="id_anio" id="id_anio" >
                                            <option value="0">Seleccione</option>
                                            <?php foreach($list_anio as $nivel){ 
                                            if($get_id[0]['id_anio'] == $nivel['id_anio']){ ?>
                                            <option selected value="<?php echo $nivel['id_anio'] ; ?>">
                                            <?php echo "".$nivel['nom_anio'];?></option>
                                            <?php }else
                                            {?>
                                            <option value="<?php echo $nivel['id_anio']; ?>"><?php echo "".$nivel['nom_anio'];?></option>
                                            <?php }} ?>
                                    </select>
                                    </div>

                                  </th>

                            <th width="10%">
                                <div class="form-group col-md-2">
                                    <label class="col-sm-3 control-label text-bold">Grado: </label>
                                    </div></th>
                            <th width="20%">
                                <div class="form-group col-md-10">
                                      <select disabled class="form-control" name="id_grado" id="id_grado">
                                            <option value="0">Seleccione</option>
                                            <?php foreach($list_grado as $nivel){ 
                                            if($get_id[0]['id_grado'] == $nivel['id_grado']){ ?>
                                            <option  selected value="<?php echo $nivel['id_grado'] ; ?>">
                                            <?php echo "".$nivel['nom_grado'];?></option>
                                            <?php }else
                                            {?>
                                            <option value="<?php echo $nivel['id_grado']; ?>"><?php echo "".$nivel['nom_grado'];?></option>
                                            <?php }} ?>
                                    </select>
                                    </div> 
                                  </th>
                            <th width="10%">
                                <div class="form-group col-md-2">
                                        <label class="col-sm-3 control-label text-bold">Estado: </label>
                                    </div></th>
                            <th width="20%">
                                <div class="form-group col-md-10" style="text-align: center;">
                                   
                                    <select disabled class="form-control" name="id_status" id="id_status">
                                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                                    <?php foreach($list_estado as $estado){ ?>
                                        <option value="<?php echo $estado['id_status']; ?>" <?php if (!(strcmp($estado['id_status'], $get_id[0]['estado']))) {echo "selected=\"selected\"";} ?>><?php echo $estado['nom_status'];?></option>
                                    <?php } ?>
                                    </select>
                               
                                    </div>

                                    
                                  </th>

                            </tr>
                            <tr>
                                <th width="10%">
                                    <div class="form-group col-md-2">
                                        <label  class="col-sm-3 control-label text-bold">Inicio Matrículas: </label>
                                    </div></th>
                                <th width="10%">
                                    <div class="form-group col-md-10">
                                             <input disabled value="<?php echo $get_id[0]['fec_inicio']; ?>" class="form-control" required type="date" id="ini_funciones" name="ini_funciones" placeholder= "Seleccionar Fecha inicio de matricula" type="text" />
                                            </div></th>

                                <th width="10%"><div class="form-group col-md-2">
                                        <label class="col-sm-3 control-label text-bold">Fin Matrículas: </label>
                                    </div></th>
                                <th width="10%">
                                    <div class="form-group col-md-10">
                                             <input disabled value="<?php echo $get_id[0]['fec_fin']; ?>" class="form-control" required type="date" id="fec_fin" name="fec_fin" placeholder= "Seleccionar Fecha fin de matricula" type="text" />


                                    
                                    </div></th>
                            </tr>
                                    
                                </table>
                                    </div>
                    </form>

                            
            
            <div class="modal-body" style="max-height:200px; overflow:auto;">
                        <table id="example"  class="table table-striped table-bordered" >
                            <div class="x_title" width="100%">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="requisitos-tab" data-toggle="tab" href="#requisitos" role="tab" aria-controls="requisitos" aria-selected="true">Requisitos</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="salones-tab" data-toggle="tab" href="#salones" role="tab" aria-controls="salones" aria-selected="false">Salones</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="areas-tab" data-toggle="tab" href="#areas" role="tab" aria-controls="areas" aria-selected="false">Áreas</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="asignaturas-tab" data-toggle="tab" href="#asignaturas" role="tab" aria-controls="asignaturas" aria-selected="false">Asignaturas</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="temas-tab" data-toggle="tab" href="#temas" role="tab" aria-controls="temas" aria-selected="false">Temas</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="estudiantes-tab" data-toggle="tab" href="#estudiantes" role="tab" aria-controls="estudiantes" aria-selected="false">Estudiantes</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="pendientes-tab" data-toggle="tab" href="#pendientes" role="tab" aria-controls="pendientes" aria-selected="false">Pendientes Mat</a>
                          </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                          <div class="tab-pane fade show active" id="requisitos" role="tabpanel" aria-labelledby="requisitos-tab">Requisitos 123</div>
                          <div class="tab-pane fade" id="salones" role="tabpanel" aria-labelledby="salones-tab">Salones 2</div>
                          <div class="tab-pane fade" id="areas" role="tabpanel" aria-labelledby="areas-tab">Áreas 12</div>
                          <div class="tab-pane fade" id="asignaturas" role="tabpanel" aria-labelledby="asignaturas-tab">Asignatura 1</div>
                          <div class="tab-pane fade" id="temas" role="tabpanel" aria-labelledby="temas-tab">Temas 3</div>
                          <div class="tab-pane fade" id="estudiantes" role="tabpanel" aria-labelledby="estudiantes-tab">estudiante 2 </div>
                          <div class="tab-pane fade" id="pendientes" role="tabpanel" aria-labelledby="pendientes-tab">1 Pendiente</div>
                        </div>
                            </div>
        
                                </table>

                            </div>
                            <div class="modal-footer">

                              <a type="button" class="btn btn-primary" href="<?= site_url('Ceba/Curso') ?>">
                              Volver</i>
                              </a>

            
                        </div>
                        </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</main>


<style type="text/css">
  td, th {
      padding: 1px;
      padding-top: 5px;
      padding-right: 5px;
    padding-bottom: 1px;
      padding-left: 8px;
      line-height: 1;
      vertical-align: top;
  }

  .table-total {
      border-spacing: 0;
      border-collapse: collapse;
  }
</style>
<script>
  $(function () {
    $('#myTab li:last-child a').tab('show')
  })
</script>



<?php $this->load->view('Ceba/footer'); ?>