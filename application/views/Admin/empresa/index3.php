<?php 
//$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php //$sesion =  $_SESSION['usuario'][0];?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta property="og:type" content="website">
    <meta property="og:title" content="sbn">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <!--
    <link href="<?=base_url() ?>template/chosen/chosen.css" rel="stylesheet"> 
       nuevo
      <link href="<?=base_url() ?>template/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url() ?>template/fileinput/css/fileinput.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url() ?>template/font-awesome-4.7.0/font-awesome-animation.min.css">
   <link href="<?=base_url() ?>template/css/components.css" rel="stylesheet" type="text/css">-->
     <!--<link href="<?=base_url() ?>template/css/showPDF.css" rel="stylesheet">-->

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>template/docs/css/main.css">
    <link rel="stylesheet" href="<?=base_url() ?>template/content/css/web/kendo.common.min.css" >
    <link href="<?=base_url() ?>template/content/css/web/kendo.rtl.min.css" rel="stylesheet" />
    <link href="<?=base_url() ?>template/content/css/web/kendo.default.min.css" rel="stylesheet" />
    <link href="<?=base_url() ?>template/content/css/web/kendo.default.mobile.min.css" rel="stylesheet" />
    <link href="<?=base_url() ?>template/content/css/dataviz/kendo.dataviz.min.css" rel="stylesheet" />
    <link href="<?=base_url() ?>template/content/css/dataviz/kendo.dataviz.default.min.css" rel="stylesheet" />
    <link href="<?=base_url() ?>template/content/shared/styles/examples-offline.css" rel="stylesheet">
    <link rel="icon"  href="#" sizes="32x32">
    <!-- Font-icon css-->
    <!--<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
     <link rel="stylesheet" type="text/css" href="<?=base_url() ?>template/font-awesome-4.7.0/css/font-awesome.min.css" >-->
    <title>.:: SNAPPY ::.</title>    
  </head>
  <body class="app sidebar-mini rtl pace-done sidenav-toggled">
  <header class="app-header"><a class="app-header__logo" href="#"><img src="<?= base_url() ?>template/img/logo2.png" style=" color :black; font-size: 11px;margin-left: 0px ;"></a>
      <a onclick="ocultarDes()" class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar" ></a>
      
      <ul class="app-nav" >
        <div class="app-sidebar__user2">
          <img src="<?= base_url() ?>template/img/intranetlogogllg.png" class="img-circle" alt="Imagen de Usuario" />
          <img src="<?= base_url() ?>template/img/intranetlogobaby-b.png" class="img-circle" alt="Imagen de Usuario" />
          <img src="<?= base_url() ?>template/img/intranetlogolittle-b.png" class="img-circle" alt="Imagen de Usuario" />
          <img src="<?= base_url() ?>template/img/intranetlogoleader-b.png" class="img-circle" alt="Imagen de Usuario" />
          <img src="<?= base_url() ?>template/img/intranetlogo05-b.png" class="img-circle" alt="Imagen de Usuario" />
          <img src="<?= base_url() ?>template/img/intranetlogojosef-b.png" class="img-circle" alt="Imagen de Usuario" />
          <img src="<?= base_url() ?>template/img/intranetlogoifv-b.png" class="img-circle" alt="Imagen de Usuario" />
          <img src="<?= base_url() ?>template/img/intranetlogofviajes-b.png" class="img-circle" alt="Imagen de Usuario" />
          <img src="<?= base_url() ?>template/img/intranetlogoemotions-b.png" class="img-circle" alt="Imagen de Usuario" />
        </div>

       <!-- User Menu-->
      
        <li class="dropdown">
          <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu">
            <i class="fa fa-user fa-lg">&nbsp;
              <?php //echo $_SESSION['usuario'][0]['usuario_nombres']." ".$_SESSION['usuario'][0]['usuario_apater']; ?></i> 
              <i class="fa fa-chevron-down" aria-hidden="true"></i>
          </a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <!--<li><a class="dropdown-item" href="#"><i class="fa fa-cog fa-lg"></i> Configurar</a></li>-->
            <li><button type="button" class="dropdown-item" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Snappy/Cambiar_clave') ?>"><i class="fa fa-user fa-lg"></i>Cambiar clave</button>
            </li>
            <li><a class="dropdown-item" href="<?= site_url('login/logout') ?>"><i class="fa fa-sign-out fa-lg"></i> Salir</a></li>
          </ul>
        </li>

      </ul>
    </header>

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
       
<div class="app-sidebar__overlay" data-toggle="sidebar">
</div>
<aside class="app-sidebar">
    <div class="app-sidebar__user"> 
        <center>
            <img class="app-sidebar__user-avatar" src="<?php echo "fotos/avatar_2x.png"; ?>" alt="User Image" style="width: 100% ;height: 100%;">
            <div id="des-usuario">
                <?php echo $sesion['usuario_codigo'];?><br>
                <?php echo $sesion['nom_nivel'];?>
            </div>
        </center>
    </div>

    <ul class="app-menu">
        <section class="treeview" id="1">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-users"></i>
                <span class="app-menu__label">Comunicación</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu header sidebar-menu" style="display:block !important; position:relative !important;">
                <li id="1_2" class="treeview-item">
                    <a class="treeview-item" href="<?= site_url('Snappy/index') ?>">
                        <i class="icon fa fa-anchor"></i> Inicio
                    </a>
                </li>
                
                <li id="1_3" class="treeview-item">
                    <a class="treeview-item" href="<?= site_url('Snappy/Agenda')?>">
                        <i class="icon fa fa-anchor"></i> Agenda
                    </a>
                </li>

                <li id="1_4" class="treeview-item">
                    <a class="treeview-item" href="<?= site_url('Administrador/proyectos')?>">
                        <i class="icon fa fa-industry"></i> Proyectos
                    </a>
                </li>

                <li id="1_5" class="treeview-item">
                    <a class="treeview-item" href="<?= site_url('Snappy/Redes')?>">
                        <i class="icon fa fa-anchor"></i>  Redes
                    </a>
                </li>

                <li class="treeview" style="position:relative !important;">
                    <a href="#">
                        <i class="icon fa fa-cogs"></i> Informes
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu pl-3" style="position:static !important;">
                        <li>
                            <a href="<?= site_url('Snappy/Busqueda')?>"><i class="fa fa-user-plus"></i> Busqueda</a>
                            <a href="<?= site_url('Snappy/Redes_Mensual')?>"><i class="fa fa-industry"></i> Redes (Mensual)</a>
                            <a href="<?= site_url('Snappy/Estado_Snappy')?>"><i class="fa fa-cube"></i> Estado Snappy</a>
                        </li>
                    </ul>
                </li>

                <li class="treeview" style="position:relative !important;">
                    <a href="#">
                        <i class="icon fa fa-cogs"></i> Configuración
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu pl-3" style="position:static !important;">
                        <li>
                            <a href="<?= site_url('Snappy/Usuario')?>"><i class="fa fa-user-plus"></i> Usuarios</a>
                            <a href="<?= site_url('Snappy/Empresa')?>"><i class="fa fa-industry"></i> Empresas</a>
                            <a href="<?= site_url('Snappy/Tipo')?>"><i class="fa fa-cube"></i> Tipos</a>
                            <a href="<?= site_url('Snappy/Subtipo')?>"><i class="fa fa-cubes"></i> Sub-Tipos</a>
                            <a href="<?= site_url('Snappy/Festivo')?>"><i class="fa fa-calendar-plus-o"></i> Festivos & Fechas Imp.</a>
                            <a href="<?= site_url('Snappy/configuracion')?>"><i class="fa fa-file-image-o"></i> Fondo Snappy</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </section>
        <section class="treeview" id="2">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-tachometer"></i>
                <span class="app-menu__label">Mantenimiento</span>
                <i class="treeview-indicator"></i>
            </a>
        </section>
    </ul>
</aside>
<main class="app-content">
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2 class="tile-title line-head">Lista de Empresas</h2>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="toolbar">
                                    <div align="right">
                                        <button class="btn btn-info" type="button" title="Nueva Empresa" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Snappy/Modal_Empresa') ?>"><i class="fa fa-plus"></i> Nueva Empresa</button>
                                        <a href="<?= site_url('Snappy/Excel_Empresa') ?>" target="_blank"> Generar excel</a>
                                    </div>
                                </div>
                                <br>
                                <div class="box-body table-responsive">
                                </div>

                                <div id="example">
                                    <div id="grid"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</main>
<script src="<?=base_url() ?>template/content/js/jquery.min.js"></script>
<script src="<?=base_url() ?>template/content/js/kendo.all.min.js"></script>
<script>
    $(document).ready(function() {
        //alert("<?=base_url() ?>index.php?Snappy/EmpresaJ")
        $("#grid").kendoGrid({
            dataSource: {
                pageSize: 25,
                transport: {
                    read:  {
                        url: "<?=base_url() ?>index.php?Snappy/EmpresaJ/?",
                        dataType: "jsonp"
                    }
                },
                schema: {
                    model: {
                        id: "id_empresa",
                        fields: {
                            id_empresa: { type: "number" },
                            nom_empresa: { type: "string" },
                            cod_empresa: { type: "string" },
                            orden_empresa: { type: "number" },
                            observaciones_empresa: { type: "string" },
                            rep_redes: { type: "number" },
                            nom_status: { type: "string" }
                        }
                    }
                }
            },
            filterable: {
                mode: "row"
            },
            pageable: true,
            scrollable: false,
            persistSelection: true,
            sortable: true,
            columns: 
            [{
                field: "nom_empresa",
                title: "Empresa",
                filterable: {
                    cell: {
                        operator: "contains",
                        suggestionOperator: "contains"
                    }
                }
            },{
                field: "cod_empresa",
                title: "Código",
                filterable: {
                    cell: {
                        operator: "contains",
                        suggestionOperator: "contains"
                    }
                }
            },{
                field: "orden_empresa",
                title: "Orden",
                filterable: {
                    cell: {
                        operator: "contains",
                        suggestionOperator: "contains"
                    }
                }
            },{
                field: "observaciones_empresa",
                title: "Observaciones",
                filterable: {
                    cell: {
                        operator: "contains",
                        suggestionOperator: "contains"
                    }
                }
            },{
                field: "rep_redes",
                //width: 100,
                title: "Rep. Redes",
                filterable: {
                    cell: {
                        operator: "contains",
                        suggestionOperator: "contains"
                    }
                }
            },{
                field: "nom_status",
                //width: 50,
                title: "Status",
                filterable: {
                    cell: {
                        operator: "contains",
                        suggestionOperator: "contains"
                    }
                }
            },{ command: [
    {name: "edit", 
        click: function (e, id) {
            alert(id)
        } ,        
        text: { edit: " ", update: " ", cancel: "nda " }}
    ], title: "&nbsp;", width: "250px" }],
    //editable: true,
        });
    });
</script>
</body>
</html>