<?php 
$sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

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
    .margintop{
      margin-top:5px ;
    }

    .clase_boton{
        height: 32px;
        width: 150px;
        padding: 5px;
    }

    .color_casilla{
        border-color: #C8C8C8;
        color: #000;
        background-color: #C8C8C8 !important;
    }

    .img_class{
        position: absolute;
        width: 80px;
        height: 90px;
        top: 5%;
        left: 1%;
    }
</style>

<?php 
  $foto = "";
  if(count($list_foto)>0){
    $foto = $list_foto[0]['foto'];
    $array_foto = explode("/",$foto);
    $nombre_foto = $array_foto[2];
  }
?>

<div class="panel panel-flat">
    <div class="panel-heading">
      <div class="row">
        <div class="x_panel">
          <div class="page-title" style="background-color: #C1C1C1;">
            <?php if($foto!=""){ ?>
              <a onclick="Descargar_Foto_Matriculados_C('<?php echo $list_foto[0]['id_foto']; ?>');"><img class="img_class" src="<?php echo base_url().$list_foto[0]['foto']; ?>"></a>
            <?php } ?>
            <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 8%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b> <?php echo $get_id[0]['Nombre_Completo']; ?></b></span></h4>
          </div>
  
          <div class="heading-elements">
            <div class="heading-btn-group">
                <a title="Agregar Foto" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Foto_Docentes') ?>/<?php echo $get_id[0]['Id']; ?>" style="margin-right:5px;">
                  <img class="top" src="<?= base_url() ?>template/img/agregar_foto.png" alt="">
                </a>

                <a type="button" href="<?= site_url('AppIFV/Rrhh') ?>">
                  <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                </a>
            </div>
          </div>
        </div>    
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="tabset">
          <input type="radio" name="tabset" id="tab4" aria-controls="rauchbier2" checked>
          <label for="tab4">Detalles</label>

          <input type="radio" name="tabset" id="tab5" aria-controls="rauchbier3">
          <label for="tab5">Ingresos</label>   
          
          <div class="tab-panels">
            <!-- DETALLE -->
            <section id="rauchbier2" class="tab-panel">
              <div class="modal-content">
                  <div id="lista_foto">
                    <table id="example_foto" class="table table-hover table-bordered table-striped" width="100%">
                        <thead>
                            <tr style="background-color: #E5E5E5;">
                                <th>Id</th>
                                <th class="text-center" width="20%">Descripción</th>
                                <th class="text-center" width="20%">Nombre Documento</th>
                                <th class="text-center" width="20%">Subido Por</th>
                                <th class="text-center" width="15%">Fecha</th>
                                <th class="text-center" width="5%"></th> 
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $i=count($list_foto); foreach($list_foto as $list){ ?>
                                <tr class="even pointer text-center">
                                    <td class="text-left"><?php echo $list['id_foto']; ?></td>  
                                    <td class="text-left"><?php echo "Foto ".$i; ?></td> 
                                    <td class="text-left"><?php echo $list['foto']; ?></td>  
                                    <td class="text-left"><?php echo $list['usuario_codigo']; ?></td>  
                                    <td><?php echo $list['fecha']; ?></td> 
                                    <td>
                                        <a onclick="Descargar_Foto_Docentes('<?php echo $list['id_foto']; ?>');">
                                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                                        </a>
                                    </td>
                                </tr>
                            <?php $i--; } ?>
                        </tbody>
                    </table>
                  </div>
              </div>
              <!--<div class="box-body table-responsive">
                <div class="panel panel-flat content-group-lg">
                  <div class="panel-heading">
                    <h5 class="panel-title"><b>Fotos</b></h5>
                    <div class="heading-elements">
                      <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>
                      </ul>
                    </div>
                  </div>

                  <div class="panel-body" style="padding-bottom:0px;">
                      <div id="lista_foto">
                          <table id="example_foto" class="table table-hover table-bordered table-striped" width="100%">
                              <thead>
                                  <tr style="background-color: #E5E5E5;">
                                      <th>Id</th>
                                      <th class="text-center" width="20%">Descripción</th>
                                      <th class="text-center" width="20%">Nombre Documento</th>
                                      <th class="text-center" width="20%">Subido Por</th>
                                      <th class="text-center" width="15%">Fecha</th>
                                      <th class="text-center" width="5%"></th> 
                                  </tr>
                              </thead>
                              
                              <tbody>
                                  <?php $i=count($list_foto); foreach($list_foto as $list){ ?>
                                      <tr class="even pointer text-center">
                                          <td class="text-left"><?php echo $list['id_foto']; ?></td>  
                                          <td class="text-left"><?php echo "Foto ".$i; ?></td> 
                                          <td class="text-left"><?php echo $list['foto']; ?></td>  
                                          <td class="text-left"><?php echo $list['usuario_codigo']; ?></td>  
                                          <td><?php echo $list['fecha']; ?></td> 
                                          <td>
                                              <a onclick="Descargar_Foto_Docentes('<?php echo $list['id_foto']; ?>');">
                                                  <img src="<?= base_url() ?>template/img/descarga_peq.png">
                                              </a>
                                          </td>
                                      </tr>
                                  <?php $i--; } ?>
                              </tbody>
                          </table>
                      </div>
                  </div>
                </div>
              </div>-->
            </section>
 
            <!-- INGRESOS -->
            <section id="rauchbier3" class="tab-panel">
              <div class="modal-content">
                <div id="lista_registro_ingreso">
                  <table id="example_ingreso" class="table table-hover table-bordered table-striped" width="100%">
                    <thead>
                      <tr style="background-color: #E5E5E5;">
                        <th>Orden</th>
                        <th class="text-center" width="10%">Fecha</th>
                        <th class="text-center" width="10%">Hora</th>
                        <th class="text-center" width="10%">Obs</th>
                        <th class="text-center" width="15%">Tipo</th>
                        <th class="text-center" width="15%">Estado</th>
                        <th class="text-center" width="15%">Autorización</th>
                        <th class="text-center" width="15%">Registro</th>
                        <th class="text-center" width="5%"></th> 
                      </tr>
                    </thead>
                    
                    <tbody>
                    <?php foreach($list_registro_ingreso as $list) {  ?>
                          <tr class="even pointer text-center">
                            <td><?php echo $list['orden']; ?></td> 
                            <td><?php echo $list['fecha_ingreso']; ?></td> 
                            <td><?php echo $list['hora_ingreso']; ?></td>  
                            <td><?php echo $list['obs']; ?></td>  
                            <td><?php echo $list['tipo_desc']; ?></td> 
                            <td><?php echo $list['nom_estado_reporte']; ?></td>
                            <td><?php echo $list['usuario_codigo']; ?></td> 
                            <td><?php echo $list['estado_ing']; ?></td>
                            <td>
                                <?php if($list['obs']=="Si"){ ?>
                                    <a title="Historial"  data-toggle="modal" data-target="#acceso_modal_mod" 
                                    app_crear_mod="<?= site_url('AppIFV/Modal_Historial_Registro_Ingreso') ?>/<?php echo $list['codigo']; ?>">
                                        <img title="Historial" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer;"/>
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
      $("#configuraciones").addClass('active');
      $("#hconfiguraciones").attr('aria-expanded', 'true');
      $("#rrhhs").addClass('active');
		  document.getElementById("rconfiguraciones").style.display = "block";

      //TABLA FOTO 

      $('#example_foto thead tr').clone(true).appendTo( '#example_foto thead' );
      $('#example_foto thead tr:eq(1) th').each( function (i) {
          var title = $(this).text();
          
          if(title==""){
            $(this).html('');
          }else{
            $(this).html('<input type="text" placeholder="Buscar '+title+'" />');
          }
  
          $( 'input', this ).on( 'keyup change', function () {
              if ( table.column(i).search() !== this.value ) {
                  table
                      .column(i)
                      .search( this.value )
                      .draw();
              }
          } );
      } );

      var table=$('#example_foto').DataTable( {
          order: [0,"asc"],
          orderCellsTop: true,
          fixedHeader: true,
          pageLength: 50,
          "aoColumnDefs" : [ 
              {
                  'bSortable' : false,
                  'aTargets' : [ 5 ]
              },
              {
                  'targets' : [ 0 ],
                  'visible' : false
              } 
          ]
      } );

      //TABLA INGRESO

      $('#example_ingreso thead tr').clone(true).appendTo('#example_ingreso thead');
      $('#example_ingreso thead tr:eq(1) th').each(function(i) {
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

      var table = $('#example_ingreso').DataTable({
          orderCellsTop: true,
          fixedHeader: true,
          pageLength: 50,
          "aoColumnDefs" : [ 
              {
                  'bSortable' : false,
                  'aTargets' : [ 8 ]
              },
              {
                  'targets' : [ 0 ],
                  'visible' : false
              } 
          ]
      });
  } );

  function Descargar_Foto_Docentes(id){
      window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_Foto_Docentes/"+id);
  }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>