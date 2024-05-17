<?php 
$sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->load->view('ceba2/header'); ?>

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

<?php $this->load->view('ceba2/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
      <div class="row">
        <div class="x_panel">
          <div class="page-title" style="background-color: #C1C1C1;">
            <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Detalle <?php echo $get_id[0]['id_curso']; ?> Secundaria: </b></span></h4>
          </div>
  
          <div class="heading-elements">
            <div class="heading-btn-group" >
                <?php if($get_id[0]['estado_cierre'] ==1){ ?>
                  <a style="margin-right:5px;" type="button" >
                    <img class="top" src="<?= base_url() ?>template/img/editar_grande.png" alt="" onclick="Curso_Cerrado();">
                  </a>
                  <a style="margin-right:5px;" type="button" >
                    <img class="top" src="<?= base_url() ?>template/img/ceba/crear_requisito.png" alt="" onclick="Curso_Cerrado();">
                  </a>
                  <a style="margin-right:5px;" type="button" >
                    <img class="top" src="<?= base_url() ?>template/img/ceba/asociar_tema.png" alt="" onclick="Curso_Cerrado();">
                  </a>
                  <a style="margin-right:5px;" type="button" >
                    <img class="top" src="<?= base_url() ?>template/img/ceba/cerrar_curso.png" alt="" onclick="Curso_Cerrado();">
                  </a>
                  <a type="button" href="<?= site_url('Ceba2/Curso') ?>">
                    <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                  </a>
                  <a style="margin-left:5px;" onclick="Exportar();" style="cursor:pointer">
                    <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                  </a>
                <?php }else{ ?>
                    <a style="margin-right:5px;" type="button" title="Editar Curso" href="<?= site_url('Ceba2/Modal_Update_Curso') ?>/<?php echo $get_id[0]['id_curso']; ?>">
                      <img class="top" src="<?= base_url() ?>template/img/editar_grande.png" alt="">
                    </a>
                    <a style="margin-right:5px;" type="button" title="Nuevo Requisito"  data-dismiss="modal" data-toggle="modal" data-target="#LargeLabelModal" LargeLabelModal="<?= site_url('Ceba2/Modal_Requisito') ?>/<?php echo $get_id[0]['id_curso']; ?>">
                      <img class="top" src="<?= base_url() ?>template/img/ceba/crear_requisito.png" alt="">
                    </a>
                    <a style="margin-right:5px;" type="button" title="Asociar Tema"  data-dismiss="modal" data-toggle="modal" data-target="#LargeLabelModal" LargeLabelModal="<?= site_url('Ceba2/Modal_Tema_Asociar') ?>/<?php echo $get_id[0]['id_curso']; ?>">
                      <img class="top" src="<?= base_url() ?>template/img/ceba/asociar_tema.png" alt="">
                    </a>
                    <a style="margin-right:5px;" type="button" title="Cerrar Curso" id="createProductBtn" data-loading-text="Loading..." autocomplete="off">
                      <img class="top" src="<?= base_url() ?>template/img/ceba/cerrar_curso.png" alt="" onclick="Cerrar_Curso('<?php echo $get_id[0]['id_curso']; ?>')">
                    </a>
                    <a type="button" title="Regresar" href="<?= site_url('Ceba2/Curso') ?>">
                      <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                    </a>
                    <a style="margin-left:5px;" style="vertical-align: left;" href="#">
                      <img src="<?= base_url() ?>template/img/excel.png" title="Exportar Excel" />
                    </a>
              <?php } ?>
            </div>
          </div>
        </div>    
      </div>
    </div>

    <div class="container-fluid">
      <div class="row" style="margin-bottom:15px;">
          <div class="col-md-12 row">
              <div class="col-md-2">
                <label class="text-bold">Grado:</label>
                <div class="col">
                  <select class="form-control" disabled>
                    <option value="0">Seleccione</option>
                    <?php foreach($list_grado as $list){ ?>
                      <option value="<?php echo $list['id_grado']; ?>" <?php if($list['id_grado']==$get_id[0]['id_grado']){ echo "selected"; } ?>>
                        <?php echo $list['descripcion_grado']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              
              <div class="col-md-2">
                <label class="text-bold">Año:</label>
                <div class="col">
                  <select class="form-control" disabled>
                    <option value="0">Seleccione</option>
                    <?php foreach($list_anio as $list){ ?>
                      <option value="<?php echo $list['id_anio']; ?>" <?php if($list['id_anio']==$get_id[0]['id_anio']){ echo "selected"; } ?>>
                        <?php echo $list['nom_anio']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              
              <div class="col-md-2">
                <label class="text-bold">Inicio Matriculas:</label>
                <div class="col">
                  <input type="date" class="form-control" disabled value="<?php echo $get_id[0]['fec_inicio']; ?>"/>
                </div>
              </div>
              
              <div class="col-md-2">
                <label class="text-bold">Fin Matrículas: </label>
                <div class="col">
                  <input type="date" class="form-control" disabled value="<?php echo $get_id[0]['fec_fin']; ?>"/>
                </div>
              </div>
              
              <div class="col-md-2">
                <label class="text-bold">Estado: </label>
                <div class="col">
                  <select class="form-control" disabled>
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                      <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                        <?php echo $list['nom_status']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              
              <div class="col-md-2">
                <label class="text-bold">Estado Cierre: </label>
                <div class="col">
                  <?php if($get_id[0]['estado_cierre']==1) { ?>
                    <input class="form-control" disabled value="Cerrado"/>
                  <?php }else{ ?>
                    <input class="form-control" disabled value="Abierto"/>
                  <?php } ?>
                </div>
              </div>
          </div>  
      </div>

      <div class="row">
        <div class="tabset">
          <input type="radio" name="tabset" id="marzen" aria-controls="marzen" checked>
          <label for="marzen">Requisitos</label>
          <!-- Tab 2 -->
          <input type="radio" name="tabset" id="rauchbier" aria-controls="rauchbier">
          <label for="rauchbier">Salones</label>
          <!-- Tab 3 -->
          <input type="radio" name="tabset" id="rauchbier1" aria-controls="rauchbier1">
          <label for="rauchbier1">Áreas</label>                                  
          <!-- Tab 4 -->
          <input type="radio" name="tabset" id="rauchbier2" aria-controls="rauchbier2">
          <label for="rauchbier2">Asignaturas</label>
          <!-- Tab 5 -->
          <input type="radio" name="tabset" id="rauchbier3" aria-controls="rauchbier3">
          <label  for="rauchbier3">Temas</label>
          <!-- Tab 6 -->
          <input type="radio" name="tabset" id="rauchbier4" aria-controls="rauchbier4">
          <label  for="rauchbier4">Estudiantes</label>                               
          <!-- Tab 7 -->
          <input type="radio" name="tabset" id="rauchbier5" aria-controls="rauchbier5">
          <label  for="rauchbier5">Matricula </label>
          
          
          <!-- DETALLES -->
            <div class="tab-panels">
              <!-- REQUISITOS -->
              <section id="marzen" class="tab-panel">
                <div class="box-body table-responsive">
                  <table id="example2" class="table table-hover table-striped table-bordered text-center" >
                    <thead>
                        <tr style="background-color: #E5E5E5;">
                          <th class="text-center" width="15%">Tipo de Requisito</th>
                          <th class="text-center" width="65%">Descripción</th>
                          <th class="text-center" width="15%">Estado</th>
                          <th class="text-center" width="5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach($list_requisito_curso as $list) {  ?>
                          <tr class="even pointer text-center">
                            <td><?php echo $list['nom_tipo_requisito']; ?></td>  
                            <td class="text-left"><?php echo $list['desc_requisito']; ?></td> 
                            <td><?php echo $list['nom_status']; ?></td>
                            <td>
                              <img title="Editar Requisito" data-toggle="modal"  data-dismiss="modal" data-target="#LargeLabelModal" 
                              LargeLabelModal="<?= site_url('Ceba2/Modal_Update_Requisito') ?>/<?php echo $list['id_requisito']; ?>" 
                              src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer;"/>
                            </td>
                          </tr>
                        <?php } ?>
                    </tbody>
                  </table>
                </div>  
              </section>

              <!-- SALONES -->
              <section id="rauchbier" class="tab-panel">
                <div class="box-body table-responsive">
                    
                  <table id="example3" class="table table-hover table-striped table-bordered text-center" >
                        <thead>
                            <tr style="background-color: #E5E5E5;">
                              <th width="1%">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                              <tr class="even pointer">
                                <td  align="left"></td> 
                                
                              </tr>
                        </tbody>
                  </table>
                </div>
              </section>

              <!-- AREAS -->
              <section id="rauchbier1" class="tab-panel">
                  <div class="box-body table-responsive">
                    <table id="example4" class="table table-hover table-striped table-bordered text-center" >
                        <thead>
                            <tr style="background-color: #E5E5E5;">
                              <th class="text-center" width="25%">Unidad</th>
                              <th class="text-center" width="35%">Area</th>
                              <th class="text-center" width="35%">Profesor</th>
                              <th class="text-center" width="5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach($list_tema_asociar_curso as $list) {  ?>
                              <tr class="even pointer text-center">
                                <td><?php echo $list['nom_unidad']; ?></td> 
                                <td class="text-left"><?php echo $list['descripcion_area']; ?></td>  
                                <td class="text-left"><?php echo $list['nom_profesor']; ?></td>  
                                <td>
                                <img title="Editar Tema Asociar" data-toggle="modal" data-dismiss="modal" data-target="#LargeLabelModal" 
                                      LargeLabelModal="<?= site_url('Ceba2/Modal_Tema_Asociar_Editar') ?>/<?php echo $list["id_tema_asociar"]; ?>/<?php echo $list['id_curso']; ?>" src="<?= base_url() ?>template/img/editar.png" 
                                      style="cursor:pointer; cursor: hand;width:22px;height:22px;" />
                                </td>
                              </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                  </div>  
              </section>

              <!-- ASIGNATURAS -->
              <section id="rauchbier2" class="tab-panel">
                    <div class="box-body table-responsive">
                      <table id="example5" class="table table-hover table-striped table-bordered text-center" >
                            <thead>
                                <tr style="background-color: #E5E5E5;">
                                  <th class="text-center" width="25%">Unidad</th>
                                  <th class="text-center" width="35%">Área</th>
                                  <th class="text-center" width="35%">Asignatura</th>
                                  <th class="text-center" width="5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php foreach($list_tema_asociar_curso as $list) {  ?>
                                  <tr class="even pointer text-center">
                                    <td><?php echo $list['nom_unidad']; ?></td> 
                                    <td class="text-left"><?php echo $list['descripcion_area']; ?></td>  
                                    <td class="text-left"><?php echo $list['descripcion_asignatura']; ?></td> 
                                    <td>
                                      <img title="Editar Tema Asociar" data-toggle="modal"  data-dismiss="modal" data-target="#LargeLabelModal" 
                                          LargeLabelModal="<?= site_url('Ceba2/Modal_Tema_Asociar_Editar') ?>/<?php echo $list['id_tema_asociar']; ?>" src="<?= base_url() ?>template/img/editar.png" 
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
                    <table id="example6" class="table table-hover table-striped table-bordered text-center" width="100%" >
                          <thead>
                              <tr style="background-color: #E5E5E5;">
                                <th class="text-center" width="10%">Unidad</th>
                                <th class="text-center" width="20%">Área</th>
                                <th class="text-center" width="30%">Asignatura</th>
                                <th class="text-center" width="35%">Tema</th>
                                <th class="text-center" width="5%"></th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php foreach($list_tema_asociar_curso as $list) {  ?>
                                <tr class="even pointer text-center">
                                  <td><?php echo $list['nom_unidad']; ?></td> 
                                  <td class="text-left"><?php echo $list['descripcion_area']; ?></td>  
                                  <td class="text-left"><?php echo $list['descripcion_asignatura']; ?></td> 
                                  <td class="text-left"><?php echo $list['desc_tema']; ?></td>
                                  <td>
                                    <img title="Editar Tema Asociar" data-toggle="modal"  data-dismiss="modal" data-target="#LargeLabelModal" 
                                        LargeLabelModal="<?= site_url('Ceba2/Modal_Tema_Asociar_Editar') ?>/<?php echo $list["id_tema_asociar"]; ?>" src="<?= base_url() ?>template/img/editar.png" 
                                        style="cursor:pointer; cursor: hand;width:22px;height:22px;" />
                                  </td>
                                </tr>
                              <?php } ?>
                          </tbody>
                    </table>
                  </div>
              </section>
              
              <!-- ESTUDIANTES -->
              <section id="rauchbier4" class="tab-panel">
                    <div class="box-body table-responsive">
                      <div style="margin-bottom: 15px;">
                        <a title="Nuevo estudiante en Curso" style="cursor:pointer;" data-toggle="modal" data-target="#acceso_modal" 
                        app_crear_per="<?= site_url('Ceba2/Modal_Alumno_Curso') ?>/<?php echo $list['id_curso']; ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo area" />
                        </a>
                      </div>
                      
                      <table id="example7" class="table table-hover table-striped table-bordered text-center">
                        <thead>
                            <tr style="background-color: #E5E5E5;">
                              <th class="text-center" width="20%">Codigo</th>
                              <th class="text-center" width="20%">Nombres</th>
                              <th class="text-center" width="20%">A. Paterno</th>
                              <th class="text-center" width="20%">A. Materno</th>
                              <th class="text-center" width="20%">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach($list_alumno_asociar_curso as $list) {  ?>
                              <tr class="even pointer text-center">
                                <td><?php echo $list['cod_alum']; ?></td>    
                                <td class="text-left"><?php echo $list['alum_nom']; ?></td> 
                                <td class="text-left"><?php echo $list['alum_apater']; ?></td>
                                <td class="text-left"><?php echo $list['alum_amater']; ?></td>
                                <td><?php echo $list['nom_estadoa']; ?></td>
                              </tr>
                            <?php } ?>
                        </tbody>
                      </table>
                    </div>
              </section>

              <!-- MATRICULA -->
              <section id="rauchbier5" class="tab-panel">
                <div class="box-body table-responsive">
                  <table id="example8" class="table table-hover table-striped table-bordered text-center" >
                        <thead>
                            <tr style="background-color: #E5E5E5;">
                              <th width="1%">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                              <tr class="even pointer">
                                <td  align="left"></td> 
                              </tr>
                        </tbody>
                  </table>
                </div>
              </section>
          </div>
        </div> 
      </div>
    </div>
</div>

<script>
  $(document).ready(function() {
      $("#academico").addClass('active');
      $("#hcurso").attr('aria-expanded','true');
      $("#curso").addClass('active');
      document.getElementById("rcurso").style.display = "block";

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
          "Tipo": [[0,"asc"]],
          orderCellsTop: true,
          fixedHeader: true,
          dom: 'Bfrtip',
          pageLength: 25
      } );
  } );

  $(document).ready(function() {
        $('#example2 thead tr').clone(true).appendTo('#example2 thead');
        $('#example2 thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            if(title==""){
              $(this).html('');
            }else{
              $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
            }

            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#example2').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
              {
                'bSortable' : false,
                'aTargets' : [ 3 ]
              }
            ]
        });

        $('#example3 thead tr').clone(true).appendTo('#example3 thead');
        $('#example3 thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');

            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#example3').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25
        });

        $('#example4 thead tr').clone(true).appendTo('#example4 thead');
        $('#example4 thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            if(title==""){
              $(this).html('');
            }else{
              $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
            }

            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#example4').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
              {
                'bSortable' : false,
                'aTargets' : [ 3 ]
              }
            ]
        });

        $('#example5 thead tr').clone(true).appendTo('#example5 thead');
        $('#example5 thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            if(title==""){
              $(this).html('');
            }else{
              $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
            }

            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#example5').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
              {
                'bSortable' : false,
                'aTargets' : [ 3 ]
              }
            ]
        });

        $('#example6 thead tr').clone(true).appendTo('#example6 thead');
        $('#example6 thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            if(title==""){
              $(this).html('');
            }else{
              $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
            }

            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#example6').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
              {
                'bSortable' : false,
                'aTargets' : [ 4 ]
              }
            ]
        });

        $('#example7 thead tr').clone(true).appendTo('#example7 thead');
        $('#example7 thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');

            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#example7').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25
        });

        $('#example8 thead tr').clone(true).appendTo('#example8 thead');
        $('#example8 thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');

            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#example8').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25
        });
  } );

  

  $(function(){
  $(".fold-table tr.view").on("click", function(){
    $(this).toggleClass("open").next(".fold").toggleClass("open");
  });
});
</script>

<?php $this->load->view('ceba2/footer'); ?>

<script>
    $(document).ready(function() {
      $('#tabla_obs thead tr').clone(true).appendTo('#tabla_obs thead');
        $('#tabla_obs thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');

            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#tabla_obs').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25
        });
    } );

    
</script>

<script>
  $(document).ready(function() {
      // Setup - add a text input to each footer cell
      $('#ejemplo .filteredes th.filtered').each( function () {
          var title = $('#ejemplo thead th').eq( $(this).index() ).text();
          $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
      } );
  
      // DataTable
      var table = $('#ejemplo').DataTable( {
          orderCellsTop: true,
          fixedHeader: true,
          dom: 'Brtip',
          
      } );
      // Apply the search
      table.columns().eq( 0 ).each( function ( colIdx ) {
          $( 'input', $('.filteredes th')[colIdx] ).on( 'keyup change', function () {
              table
                  .column( colIdx )
                  .search( this.value )
                  .draw();
          } );
      } );
  } );
</script>

<script>
  $(document).ready(function() {
      // Setup - add a text input to each footer cell
      $('#curso_detalles_area .filtros th.filtered').each( function () {
          var title = $('#curso_detalles_area thead th').eq( $(this).index() ).text();
          $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
      } );
  
      // DataTable
      var table = $('#curso_detalles_area').DataTable( {
          orderCellsTop: true,
          fixedHeader: true,
          dom: 'Brtip',
          
      } );
      // Apply the search
      table.columns().eq( 0 ).each( function ( colIdx ) {
          $( 'input', $('.filteredes th')[colIdx] ).on( 'keyup change', function () {
              table
                  .column( colIdx )
                  .search( this.value )
                  .draw();
          } );
      } );
  } );

  function Cerrar_Curso(id){
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
        
    var id = id;
    var url="<?php echo site_url(); ?>Ceba2/Cerrar_Curso";
    var self = this;

    Swal({
        title: '¿Realmente quieres cerrar curso '+ id +'?',
        text: "El registro será cerrado permanentemente",
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
                data: {'id_curso':id},
                success:function (data) {
                  if(data=="error"){
                      Swal({
                          title: 'Cierre Denegado',
                          text: "¡Alumnos Matriculados encontrados!",
                          type: 'error',
                          showCancelButton: false,
                          confirmButtonColor: '#3085d6',
                          confirmButtonText: 'OK',
                      });
                  }else{
                      Swal(
                          'Cerrado!',
                          'El curso ha sido cerrado satisfactoriamente.',
                          'success'
                      ).then(function() {
                        window.location = "<?php echo site_url(); ?>Ceba2/Detalles_Curso/"+id;
                      });
                  }
                }
            });
        }
    })
  }

  function Curso_Cerrado(){
      Swal({
          title: 'Curso Cerrado!',
          text: "Acción denegada porque el curso está cerrado!",
          type: 'warning',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK',
      });
  }
</script>


<?php $this->load->view('ceba2/validaciones'); ?>