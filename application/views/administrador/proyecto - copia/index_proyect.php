<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
    <!-- Navbar-->
   <?php $this->load->view('Admin/header'); ?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <?php $this->load->view('Admin/nav'); ?>
      <link href="<?=base_url() ?>template/css/AdminLTE.css" rel="stylesheet" type="text/css">
      <main class="app-content">

        <div class="row">
        <div class="col-md-12" class="collapse" id="collapseExample">
          <div class="tile">
            <h3 class="tile-title line-head">Lista de Proyectos</h3>
            <div class="tile-body" >
              <div class="row">
                <div class="col-lg-2 col-xs-12">
                    <div class="small-box bg-blue">
                      <div class="inner" align="center">
                         <h3><?php echo $row_st[0]['total'];?> | <span style="font-size: 32px;"><?php echo $row_st[0]['artes'] + $row_st[0]['redes'];?></span></h3> 
                      </div>
                      <div>
                          <table id="" class="table-total" align="center">
                            <tr>
                              <th>&nbsp;</th>
                              <th>&nbsp;</th>
                              <th>&nbsp;</th>
                            </tr>                  
                          </table>
                            <br>
                      </div>
                          <a onclick="Buscar(1);" class="small-box-footer" style="cursor:pointer; cursor: hand;">Solicitado<i class="fa fa-arrow-circle-down"></i>
                         </a>
                   </div>
                </div>

                <div class="col-lg-2 col-xs-12">
                    <div class="small-box bg-aqua">
                       <div class="inner" align="center">
                            <h3><?php echo $row_at[0]['total'];?> | <span style="font-size: 32px;"><?php echo $row_at[0]['artes'] + $row_at[0]['redes'];?></span></h3>
                         </div>
                           <div>
                             <table id="" class="table-total" align="center">
                              <thead>
                                <tr>
                                    <th></th>
                                    <th><img src="<?= base_url() ?>images/sp-b.png" width="20" height="20" /></th>
                                    <th><img src="<?= base_url() ?>images/tt-b.png" width="20" height="20" /></th>
                                </tr> 
                              </thead>
                               <tbody>
                                 <?php foreach($row_a as $row_a) {  ?>
                                  <tr >
                                    <td> <?php echo $row_a['usuario_codigo']; ?></td>
                                    <td style="text-align: center;"> <?php echo $row_a['total']; ?></td>
                                    <td style="text-align: center;"> <?php echo $row_a['artes']+$row_a['redes']; ?></td>
                                  </tr>
                              <?php  } ?>
                               </tbody>
                              </table>
                                <br>
                            </div>                                            
                            <a onclick="Buscar(2);" class="small-box-footer" style="cursor:pointer; cursor: hand;"> Asignados  
                              <i class="fa fa-arrow-circle-down"></i>
                            </a>
                    </div>
                </div>

                <div class="col-lg-2 col-xs-12" style="color:#fff;">
                   <div class="small-box bg-gray">
                      <div class="inner" align="center">
                       <h3><?php echo $row_ett[0]['total'];?> | <span style="font-size: 32px;"><?php echo $row_ett[0]['artes'] + $row_ett[0]['redes'];?></span></h3>
                      </div>
                      <div>
                         <table id="" class="table-total" align="center">
                          <thead>
                           <tr>
                              <th></th>
                              <th><img src="<?= base_url() ?>images/sp-b.png" width="20" height="20" /></th>
                              <th><img src="<?= base_url() ?>images/tt-b.png" width="20" height="20" /></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($row_et as $row_et) {  ?>
                             <tr>
                               <td> <?php echo $row_et['usuario_codigo']; ?></td>
                               <td style="text-align: center;"> <?php echo $row_et['total']; ?></td>
                               <td style="text-align: center;"> <?php echo $row_et['artes']+$row_et['redes']; ?></td>
                             </tr>
                             <?php  } ?>
                          </tbody>

                          </table>
                            <br>
                      </div>                                            
                         <a onclick="Buscar(3);" class="small-box-footer" style="cursor:pointer; cursor: hand;"> En Trámite 
                          <i class="fa fa-arrow-circle-down"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-xs-12">
                    <div class="small-box bg-yellow">
                      <div class="inner" align="center">
                          <h3><?php echo $row_prt[0]['total'];?> | <span style="font-size: 32px;"><?php echo $row_prt[0]['artes'] + $row_prt[0]['redes'];?></span></h3>
                      </div>
                       <div>
                          <table id="" class="table-total" align="center">
                            <thead>
                              <tr>                                                        
                                <th></th>
                                <th><img src="<?= base_url() ?>images/sp-b.png" width="20" height="20" /></th>
                                <th><img src="<?= base_url() ?>images/tt-b.png" width="20" height="20" /></th>
                             </tr>
                           </thead>
                           <tbody>
                             <?php foreach($row_pr as $row_pr) {  ?>
                             <tr >
                              <td> <?php echo $row_pr['usuario_codigo']; ?></td>
                              <td style="text-align: center;"> <?php if ($row_pr['artes']!=null || $row_pr['redes']!=null) echo $row_pr['total']; else echo "0"; ?></td>
                              <td style="text-align: center;"> <?php echo $row_pr['artes']+$row_pr['redes']; ?></td>
                               </tr>
                              <?php  } ?>
                           </tbody>
                          </table><br>
                       </div>
                          <a onclick="Buscar(4);" class="small-box-footer" style="cursor:pointer; cursor: hand;"> Pendientes 
                            <i class="fa fa-arrow-circle-down"></i>
                          </a>
                    </div>
                </div>

                <div class="col-lg-4 col-xs-12">
                      <div class="small-box bg-yellow">
                        <div class="small-box bg-snappy" style="color:#fff;background:#3BB9AE">
                             <?php
                                $ts=0;
                                $tu=0;
                                 foreach($row_tp2 as $row_tp2){
                                    $ts=$ts+$row_tp2['artest'] + $row_tp2['redest'];
                                    $tu=$tu+ $row_tp2['artes'] + $row_tp2['redes'];
                                      } 
                                    ?>
                           <div align="center">
                              <h3>WEEK Snappy's</h3>Terminados - Enviados - Archivados
                            </div>
                             <div>
                                <table id="" width="90%" class="table-total" align="center">
                                  <thead>
                                  <tr align="center">
                                    <td>&nbsp;</td>
                                    <td><img src="<?= base_url() ?>images/spt-b.png" width="20" height="20" /></td>
                                    <td><img src="<?= base_url() ?>images/sp-b.png" width="20" height="20" /></td>
                                    <td><img src="<?= base_url() ?>images/porcentaje-b.png" width="20" height="20" /></td>
                                    <td width="45%" rowspan="4">
                                      <span style="text-align: center; font-size: 38px;font-weight: bold;"><?php echo $ts; ?></span>
                                      <br><span style="text-align: center; font-size: 32px;"><?php if($tu!=0 && $tu!="") echo round(($ts/$tu)*100); ?> %
                                      </span>
                                    </td>  
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php foreach($row_tp as $row_tp) {  ?>
                                   <tr>
                                      <td><?php echo $row_tp['usuario_codigo']; ?></td>
                                      <td style="text-align: center;"><?php if ($row_tp['artest']=="" && $row_tp['redest']=="") {echo "0";} else {echo $row_tp['total'] ;} ?></td>
                                      <td style="text-align: center;"><?php echo $row_tp['artest'] + $row_tp['redest']; ?></td>
                                      <td style="text-align: center;"><?php if($row_tp['artes']!=0 && $row_tp['artes']!="") echo round((($row_tp['artest'] + $row_tp['redest'])/($row_tp['artes'] + $row_tp['redes']))*100); ?> %</td>
                                    </tr>
                                   <?php  } ?>
                                </tbody>
                              </table>
                                    <br>
                              </div>
                                <a onclick="Buscar(0);" class="small-box-footer" style="cursor:pointer; cursor: hand;"> Terminados 
                                  <i class="fa fa-arrow-circle-down"></i>
                                </a>
                          </div>
                        </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
             <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <!--<div class="x_title">
                        <h2 class="tile-title line-head">Listado de Papeletas</h2>
                        <div class="clearfix"></div>
                    </div>-->
                    <div class="x_content">
                        <!--<div class="toolbar">
                            <div align="right">
                            <button class="btn btn-info" type="button" title="Nueva Papeleta" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Papeletas/registro') ?>"><i class="fa fa-plus"></i> Nueva Papeleta </button>
                            </div>
                        </div>-->
                        <div class="col-xs-12" Style="background-color:#C4ADB2;">
                                    <div class="row form-group">
                                        <div class="col-xs-8">

                                          <a href="<?= site_url('Administrador/nuevo_proyect') ?>"> 

                                            <img  src="<?= base_url() ?>images/bnew.png" onClick="Nuevo()" style="cursor:pointer; cursor: hand;" width="75" height="25" />

                                            </a>

                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <span style="color:#fff;font-size: 16px;font-weight: 700;">Buscar:</span>&nbsp;&nbsp;<input style="margin-top:2%; width: 60%;height: 30px;" name="busqueda" type="text" id="busqueda">
                                        </div>
                                        <div class="col-xs-4">
                                        <img align="right" style="margin-top:5%;" src="<?= base_url() ?>images/exportarxls.png" onClick="Exportar()" style="cursor:pointer; cursor: hand;" width="100" height="25" />
                                        </div>
                                    </div>
                                </div>


                      <div class="table-responsive table-bordered">
                        <table class="table table-bordered table-striped" id="papeletas">
                           <thead>
                             <tr>
                                <th colspan="9" style="border: none;"></th>
                                <th align="center" colspan="2" bgcolor="#000F9F" style="border: none; color:#fff; text-align:center;">Solicitado</th>
                                 <th align="center" colspan="2" bgcolor="#C4ADB2" style="border: none; color:#fff; text-align:center;">Terminado</th>
                                <th></th>
                              </tr>
                               <tr>
                                  <th><div align="center">Pri.</div></th>
                                  <th><div align="center">Código</div></th>
                                  <th><div align="center">Status</div></th>
                                  <th><div align="center">Empresa(s)</div></th>
                                  <th><div align="center">Tipo</div></th>
                                  <th><div align="center">SubTipo</div></th>
                                  <th><div align="center">Descripción</div></th>
                                  <th><div align="center">Snappy's</div></th>
                                  <th><div align="center">Agenda</div></th>
                                  <th><div align="center">Usuario</div></th>
                                  <th><div align="center">Fecha</div></th>
                                  <th><div align="center">Usuario</div></th>
                                  <th><div align="center">Fecha</div></th>
                                  <th>&nbsp;</th>
                             </tr>
                          </thead>
                           <tbody>
                             <?php foreach($row_p as $row_p) {  ?>
                              <tr>
                                <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['prioridad']; ?></td>
                                                <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo utf8_encode($row_p['cod_proyecto']); ?></td>
                                                <td style="background-color:<?php echo $row_p['color']; ?>"><?php echo $row_p['nom_statusp']; ?></td>
                                                <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>>
                                                <?php
                                                if($row_p['GL0']==1) {echo "GL0";}
                                                if($row_p['GL0']==1 && $row_p['GL1']==1) {echo ", GL1";} else{ if($row_p['GL1']==1) {echo "GL1";}}
                                                if(($row_p['GL0']==1 || $row_p['GL1']==1) && $row_p['GL2']==1) {echo ", GL2";} else{ if($row_p['GL2']==1) {echo "GL2";}}
                                                if(($row_p['GL0']==1 || $row_p['GL1']==1 || $row_p['GL2']==1) && $row_p['BL1']==1) {echo ", BL1";} else{ if($row_p['BL1']==1) {echo "BL1";}}
                                                if(($row_p['GL0']==1 || $row_p['GL1']==1 || $row_p['GL2']==1 || $row_p['BL1']==1) && $row_p['LL1']==1) {echo ", LL1";} else{ if($row_p['LL1']==1) {echo "LL1";}}
                                                if(($row_p['GL0']==1 || $row_p['GL1']==1 || $row_p['GL2']==1 || $row_p['BL1']==1 || $row_p['LL1']==1) && $row_p['LL2']==1) {echo ", LL2";} else{ if($row_p['LL2']==1) {echo "LL2";}}
                                                if(($row_p['GL0']==1 || $row_p['GL1']==1 || $row_p['GL2']==1 || $row_p['BL1']==1 || $row_p['LL1']==1 || $row_p['LL2']==1) && $row_p['LS1']==1) {echo ", LS1";} else{ if($row_p['LS1']==1) {echo "LS1";}}
                                                if(($row_p['GL0']==1 || $row_p['GL1']==1 || $row_p['GL2']==1 || $row_p['BL1']==1 || $row_p['LL1']==1 || $row_p['LL2']==1 || $row_p['LS1']==1) && $row_p['LS2']==1) {echo ", LS2";} else{ if($row_p['LS2']==1) {echo "LS2";}}
                                                if(($row_p['GL0']==1 || $row_p['GL1']==1 || $row_p['GL2']==1 || $row_p['BL1']==1 || $row_p['LL1']==1 || $row_p['LL2']==1 || $row_p['LS1']==1 || $row_p['LS2']==1) && $row_p['EP1']==1) {echo ", EP1";} else{ if($row_p['EP1']==1) {echo "EP1";}}
                                                if(($row_p['GL0']==1 || $row_p['GL1']==1 || $row_p['GL2']==1 || $row_p['BL1']==1 || $row_p['LL1']==1 || $row_p['LL2']==1 || $row_p['LS1']==1 || $row_p['LS2']==1 || $row_p['EP1']==1) && $row_p['EP2']==1) {echo ", EP2";} else{ if($row_p['EP2']==1) {echo "EP2";}}
                                                if(($row_p['GL0']==1 || $row_p['GL1']==1 || $row_p['GL2']==1 || $row_p['BL1']==1 || $row_p['LL1']==1 || $row_p['LL2']==1 || $row_p['LS1']==1 || $row_p['LS2']==1 || $row_p['EP1']==1 || $row_p['EP2']==1) && $row_p['FV1']==1) {echo ", FV1";} else{ if($row_p['FV1']==1) {echo "FV1";}}
                                                if(($row_p['GL0']==1 || $row_p['GL1']==1 || $row_p['GL2']==1 || $row_p['BL1']==1 || $row_p['LL1']==1 || $row_p['LL2']==1 || $row_p['LS1']==1 || $row_p['LS2']==1 || $row_p['EP1']==1 || $row_p['EP2']==1 || $row_p['FV1']==1) && $row_p['FV2']==1) {echo ", FV2";} else{ if($row_p['FV2']==1) {echo "FV2";}}
                                                if(($row_p['GL0']==1 || $row_p['GL1']==1 || $row_p['GL2']==1 || $row_p['BL1']==1 || $row_p['LL1']==1 || $row_p['LL2']==1 || $row_p['LS1']==1 || $row_p['LS2']==1 || $row_p['EP1']==1 || $row_p['EP2']==1 || $row_p['FV1']==1 || $row_p['FV2']==1) && $row_p['LA0']==1) {echo ", LA0";} else{ if($row_p['LA0']==1) {echo "LA0";}}
                                                if(($row_p['GL0']==1 || $row_p['GL1']==1 || $row_p['GL2']==1 || $row_p['BL1']==1 || $row_p['LL1']==1 || $row_p['LL2']==1 || $row_p['LS1']==1 || $row_p['LS2']==1 || $row_p['EP1']==1 || $row_p['EP2']==1 || $row_p['FV1']==1 || $row_p['FV2']==1 || $row_p['LA0']==1) && $row_p['VJ1']==1) {echo ", VJ1";} else{ if($row_p['VJ1']==1) {echo "VJ1";}}
                                                ?></td>
                                                <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['nom_tipo']; ?></td>
                                                <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['nom_subtipo']; ?></td>
                                                <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['descripcion']; ?></td>
                                                <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['s_artes']+$row_p['s_redes']; ?></td>
                                                <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php if ($row_p['fec_agenda']!='0000-00-00') echo date('d/m/Y', strtotime($row_p['fec_agenda'])); ?></td>
                                                <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['ucodigo_solicitado']; ?></td>
                                                <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php if ($row_p['fec_solicitante']!='0000-00-00') echo date('d/m/Y', strtotime($row_p['fec_solicitante'])); ?></td>
                                                <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['ucodigo_asignado']; ?></td>
                                                <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php if ($row_p['fec_termino']!='0000-00-00 00:00:00') echo date('d/m/Y', strtotime($row_p['fec_termino']));?></td>
                                                <td align="center"

                                                <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>>
                                                 <a href="<?= site_url('Administrador/editar_proyect') ?>/<?php echo $row_p['id_proyecto']; ?>"> 

                                                <img src="<?= base_url() ?>images/editar.png" 
                                                onClick="Editar('<?php echo $row_p['id_proyecto']; ?>')" style="cursor:pointer; cursor: hand;" width="22" height="22" />
                                              </a>
                                                &nbsp;
                                                <?php if ($row_p['imagen']!='') { ?>
                                                <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#dataUpdate" data-imagen="<?php echo $row_p['imagen']?>" title="Ver Imágen"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>
                                                <?php } ?>

                                                </td>

                              </tr>

                           <?php  } ?>
                           </tbody>
                        </table>
                      </div>


                 </div>
               </div>
             </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    

  



    <div id="acceso_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>
    <div id="acceso_modal_mod" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>
    <div id="acceso_modal_eli" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>
    <?php $this->load->view('Admin/footer'); ?>

    <script type="text/javascript">
 
function corregirpapeleta()
{
  frmlmotivocorregir.submit();
}
  

  </script>
