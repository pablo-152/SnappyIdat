<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>.:: SNAPPY ::.</title>
  <link href="<?=base_url() ?>template/chosen/chosen.css" rel="stylesheet"> 
  <!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>template/docs/css/main.css">-->
  <!-- nuevo-->
  <link href="<?=base_url() ?>template/css/core.css" rel="stylesheet" type="text/css">
  <script src="<?= base_url() ?>template/docs/js/jquery-3.2.1.min.js"></script>

  <link href="<?=base_url() ?>template/fileinput/css/fileinput.min.css" rel="stylesheet">
  <!--<link rel="stylesheet" href="<?=base_url() ?>template/font-awesome-4.7.0/font-awesome-animation.min.css">-->
  <!-- <link href="<?=base_url() ?>template/css/components.css" rel="stylesheet" type="text/css">-->
  <!--<link href="<?=base_url() ?>template/css/showPDF.css" rel="stylesheet">-->
  <link rel="icon"  href="#" sizes="32x32">
  <!-- Font-icon css-->
  <!--<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">-->
  <!--<link rel="stylesheet" type="text/css" href="<?=base_url() ?>template/font-awesome-4.7.0/css/font-awesome.min.css" >-->

  <!-- Global stylesheets -->
  <!--<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">-->
  <!--<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">-->
  <link href="<?=base_url() ?>template/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
  <link href="<?=base_url() ?>template/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
  <link href="<?=base_url() ?>template/assets/css/core.css" rel="stylesheet" type="text/css">
  <link href="<?=base_url() ?>template/assets/css/components.css" rel="stylesheet" type="text/css">
  <link href="<?=base_url() ?>template/assets/css/colors.css" rel="stylesheet" type="text/css">
  <link href="<?=base_url() ?>template/assets/css/tabla_cebra.css" rel="stylesheet" type="text/css">
  <!-- /global stylesheets -->

  <!-- Core JS files -->
  <script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/loaders/pace.min.js"></script>
  <script type="text/javascript" src="<?=base_url() ?>template/assets/js/core/libraries/jquery.min.js"></script>
  <script type="text/javascript" src="<?=base_url() ?>template/assets/js/core/libraries/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/loaders/blockui.min.js"></script>
  <!-- /core JS files -->

  <!-- Theme JS files -->
  <script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/tables/datatables/datatables.min.js"></script>
  <script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/forms/selects/select2.min.js"></script>

  <script type="text/javascript" src="<?=base_url() ?>template/assets/js/core/app.js"></script>
  <script type="text/javascript" src="<?=base_url() ?>template/assets/js/pages/datatables_basic.js"></script>
  <script type="text/javascript" src="<?=base_url() ?>template/assets/js/pages/datatables_api.js"></script>
  <script type="text/javascript" src="<?=base_url() ?>template/assets/js/pages/datatables_extension_fixed_columns.js"></script>
  <!-- /theme JS files -->
  <link rel="stylesheet" href="<?=base_url('template/assets/assets2/libs/sweetalert2/dist/sweetalert2.min.css')?>">

  <script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/ui/prism.min.js"></script>
  <!-- pruebaa-->

  <script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/ui/headroom/headroom.min.js"></script>
  <script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/ui/headroom/headroom_jquery.min.js"></script>
  <script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/ui/nicescroll.min.js"></script>

  <script type="text/javascript" src="<?=base_url() ?>template/assets/js/pages/layout_fixed_custom.js"></script>

  <!-- UPLOAD IMG-->
  <script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/uploaders/fileinput.min.js"></script>
  <script type="text/javascript" src="<?=base_url() ?>template/assets/js/pages/uploader_bootstrap.js"></script>
</head>

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

<div id="acceso_modal_pequeno" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content"></div>
  </div>
</div>

<div class="modal fade bd-example-modal-xl" id="ExtralargeModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-xl" id="myModaledit" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg" id="LargeLabelModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    </div>
  </div>
</div>

<div id="modal_form_vertical" data-backdrop="static" data-keyboard="false" onkeypress="pulsar(event)" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
    </div>
  </div>
</div>

<div id="modal_full" class="modal fade">
  <div class="modal-dialog modal-full">
    <div class="modal-content">
      
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('body').children('.navbar').first().addClass('navbar-fixed-top');
    $('body').addClass('navbar-top');

    $("#5").addClass('treeview is-expanded');
    $("#5_1").addClass('treeview-item-active');
        
    $("#acceso_modal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("app_crear_per"));
    });

    $("#acceso_modal_mod").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("app_crear_mod"));
    });

    $("#acceso_modal_eli").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("app_crear_eli"));
    });

    $("#acceso_modal_pequeno").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("app_crear_peq"));
    });

    $("#myModaledit").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("myModaledit"));
    });

    $("#ExtralargeModal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("ExtralargeModal"));
    });

    $("#LargeLabelModal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("LargeLabelModal"));
    });

    $("#modal_form_vertical").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("modal_form_vertical"));
    });

    $("#modal_full").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("modal_full"));
    });

    document.body.classList.remove("bg-gris");
  }); 
</script>