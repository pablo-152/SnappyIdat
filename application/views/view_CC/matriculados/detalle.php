<?php 
$sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->load->view('view_CC/header'); ?>
<?php $this->load->view('view_CC/nav'); ?>

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

<div class="panel panel-flat">
    <div class="panel-heading">
      <div class="row">
        <div class="x_panel">
          <div class="page-title" style="background-color: #C1C1C1;">
            <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b> <?php echo $get_id[0]['Nombre_Completo']; ?></b></span></h4>
          </div>
  
          <div class="heading-elements">
            <div class="heading-btn-group">
                <a type="button" href="<?= site_url('CursosCortos/Matriculados') ?>">
                  <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                </a>
            </div>
          </div>
        </div>    
      </div>
    </div>

    <?php
      $fec_de = new DateTime($get_id[0]['Fecha_Cumpleanos']);
      $fec_hasta = new DateTime(date('Y-m-d'));
      $diff = $fec_de->diff($fec_hasta); 
    ?>

    <div class="container-fluid">
      <div class="row">
          <div class="col-md-12 row">
              <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Código&nbsp;Snappy:</label>
              </div>
              <div class="form-group col-md-2">
                <input type="text" class="form-control" disabled value="<?php //echo $get_id[0]['cod_alum']; ?>">
              </div>

              <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Código&nbsp;Arpay:</label>
              </div>
              <div class="form-group col-md-2">
                  <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Codigo']; ?>">
              </div>
                
              <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Grado: </label>
              </div>

              <div class="form-group col-md-2">
                <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Grado']; ?>">
              </div>
          </div> 

          <div class="col-md-12 row">
              <div class="form-group col-md-2">
                  <label class="col-sm-3 control-label text-bold">Apellido&nbsp;Paterno: </label>
              </div>
              <div class="form-group col-md-2">
                  <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Apellido_Paterno']; ?>">
              </div>

              <div class="form-group col-md-2">
                  <label class="col-sm-3 control-label text-bold">Apellido&nbsp;Materno: </label>
              </div>
              <div class="form-group col-md-2">
                  <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Apellido_Materno']; ?>">
              </div>

              <div class="form-group col-md-2">
                  <label class=" col-sm-3 control-label text-bold">Nombres: </label>
              </div>
              <div class="form-group col-md-2">
                  <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Nombres']; ?>">
              </div>
          </div>
          
          <div class="col-md-12 row">
              <div class="form-group col-md-2">
                  <label class="col-sm-3 control-label text-bold">DNI:</label>
              </div>
              <div class="form-group col-md-2">
                  <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Documento']; ?>">
              </div>

              <div class="form-group col-md-2">
                  <label class="col-sm-3 control-label text-bold">Estado:</label>
              </div>
              <div class="form-group col-md-2">
                  <input type="text" class="form-control" disabled value="<?php //echo $get_id[0]['nom_estadoa']; ?>">
              </div>

              <div class="form-group col-md-2">
                  <label class="col-sm-3 control-label text-bold">Escuela&nbsp;Procedencia:</label>
              </div>
              <div class="form-group col-md-2">
                  <input type="text" class="form-control" disabled value="<?php //echo $get_id[0]['alumno_institucionp']; ?>">
              </div>

              <div class="form-group col-md-2">
                  <label class="col-sm-3 control-label text-bold">Edad:</label>
              </div>
              <div class="form-group col-md-2">
                  <input type="text" class="form-control" disabled value="<?php echo $diff->y; ?>">
              </div>

              <div class="form-group col-md-2">
                  <label class="col-sm-3 control-label text-bold">Celular:</label>
              </div>
              <div class="form-group col-md-2">
                <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Celular']; ?>">
              </div>

              <div class="form-group col-md-2">
                  <label class="col-sm-3 control-label text-bold">Fecha&nbsp;de&nbsp;Nacimiento:</label>
              </div>
              <div class="form-group col-md-2">
                  <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Cumpleanos']; ?>">
              </div>

              <div class="form-group col-md-2">
                  <label class="col-sm-3 control-label text-bold">Dónde&nbsp;nos&nbsp;Conociste: </label>
              </div>
              <div class="form-group col-md-2">
                  <input type="text" class="form-control" disabled value="<?php //echo $get_id[0]['nom_medio']; ?>">
              </div>

              <div class="form-group col-md-2">
                  <label class="col-sm-3 control-label text-bold">Último&nbsp;Ingreso:</label>
              </div>
              <div class="form-group col-md-2">
                  <input type="text" class="form-control" disabled value="<?php //echo $get_id[0]['ultimo_ingreso'] ?>">
              </div>              
          </div>  
      </div>

      <div class="row">
        <div class="tabset">
          <input type="radio" name="tabset" id="tab5" aria-controls="rauchbier3" checked>
          <label for="tab5">Documentos</label>                           
          
          <div class="tab-panels">
            <!-- DOCUMENTOS -->
            <section id="rauchbier3" class="tab-panel">
              <div class="modal-content">
                <div id="div_doc">
                  <table id="example" class="table table-hover table-bordered table-striped" width="100%">
                    <thead>
                      <tr style="background-color: #E5E5E5;">
                        <th class="text-center" width="10%">Año</th>
                        <th class="text-center" width="40%">Documento</th>
                        <th class="text-center" width="15%">Usuario Entrega</th>
                        <th class="text-center" width="15%">Fecha Entregado</th>
                        <th class="text-center" width="15%">Obligatorio Documento</th>
                        <td class="text-center" width="5%"></td>
                      </tr>
                    </thead>
                    
                    <tbody>
                      <?php foreach($list_documento as $list) {  ?>
                          <tr class="even pointer text-center">
                            <td><?php echo $list['Year']; ?></td> 
                            <td class="text-left"><?php echo $list['Name']; ?></td>  
                            <td class="text-left"><?php echo $list['Usuario_Entrega']; ?></td>  
                            <td><?php echo $list['Fecha_Entrega']; ?></td> 
                            <td><?php echo $list['Obligatorio_Documento']; ?></td>
                            <td>
                              <?php if($list['DocumentFilePath']!=""){ ?>
                                <a href="<?php echo "http://intranet.gllg.edu.pe/Areas/Frontoffice/Content/StudentDocument/".$list['Id']."/".str_replace(' ','%20',$list['DocumentFilePath']); ?>" target="_blank">
                                    <img title="Descargar" src="<?= base_url() ?>template/img/icono-subir.png" style="cursor:pointer; cursor: hand;" width="22" height="22">
                                </a>
                              <?php } ?>
                          </td>
                          </tr>
                        <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </section>
          </div>
        </div> 
      </div>
    </div>
</div>

<script>
  $(document).ready(function() {
      $("#alumnos").addClass('active');
      $("#halumnos").attr('aria-expanded','true');
      $("#matriculados").addClass('active');
      document.getElementById("ralumnos").style.display = "block";

      $('#example thead tr').clone(true).appendTo('#example thead');
      $('#example thead tr:eq(1) th').each(function(i) {
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

      var table = $('#example').DataTable({
          orderCellsTop: true,
          fixedHeader: true,
          pageLength: 50,
          "aoColumnDefs" : [ 
              {
                  'bSortable' : false,
                  'aTargets' : [ 5 ]
              }
          ]
      });
  } );
</script>

<?php $this->load->view('view_CC/footer'); ?>