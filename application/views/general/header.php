<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>.:: SNAPPY ::.</title>


  <link href="<?=base_url() ?>template/chosen/chosen.css" rel="stylesheet"> 

	

<!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>template/docs/css/main.css">-->
  <!--<link href="<?=base_url() ?>template/chosen/chosen.css" rel="stylesheet">-->
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

	<!-- /core JS files -->

	<!-- Theme JS files -->
	
	<script type="text/javascript" src="assets/js/core/app.js"></script>
  <script>
    function Cargando(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<div class="loader_ifv"><svg width="200" height="200" viewBox="0 0 200 200" color="#0E4FA0" fill="none" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="spinner-secondHalf"><stop offset="0%" stop-opacity="0" stop-color="currentColor" /><stop offset="100%" stop-opacity="0.5" stop-color="currentColor" /></linearGradient><linearGradient id="spinner-firstHalf"><stop offset="0%" stop-opacity="1" stop-color="currentColor" /><stop offset="100%" stop-opacity="0.5" stop-color="currentColor" /></linearGradient></defs><g stroke-width="15"><path stroke="url(#spinner-secondHalf)" d="M 4 100 A 96 96 0 0 1 196 100" /><path stroke="url(#spinner-firstHalf)" d="M 196 100 A 96 96 0 0 1 4 100" /><path stroke="currentColor" stroke-linecap="round" d="M 4 100 A 96 96 0 0 1 4 98" /></g><animateTransform from="0 0 0" to="360 0 0" attributeName="transform" type="rotate" repeatCount="indefinite" dur="1300ms" /></svg><img src="<?= base_url() ?>template/img/intranetadminc.png"></div>',
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
                message: '<div class="loader_ifv"><svg width="200" height="200" viewBox="0 0 200 200" color="#0E4FA0" fill="none" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="spinner-secondHalf"><stop offset="0%" stop-opacity="0" stop-color="currentColor" /><stop offset="100%" stop-opacity="0.5" stop-color="currentColor" /></linearGradient><linearGradient id="spinner-firstHalf"><stop offset="0%" stop-opacity="1" stop-color="currentColor" /><stop offset="100%" stop-opacity="0.5" stop-color="currentColor" /></linearGradient></defs><g stroke-width="15"><path stroke="url(#spinner-secondHalf)" d="M 4 100 A 96 96 0 0 1 196 100" /><path stroke="url(#spinner-firstHalf)" d="M 196 100 A 96 96 0 0 1 4 100" /><path stroke="currentColor" stroke-linecap="round" d="M 4 100 A 96 96 0 0 1 4 98" /></g><animateTransform from="0 0 0" to="360 0 0" attributeName="transform" type="rotate" repeatCount="indefinite" dur="1300ms" /></svg><img src="<?= base_url() ?>template/img/intranetadminc.png"></div>',
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
    }
  </script>
  <style>
      .loader_ifv {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 0 auto;
        background: #fff;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
      }
      .loader_ifv svg{
          width: 100%;
          height: 100%;
      }
      .loader_ifv img{
          position: absolute;
      }
  </style>
	
</head>

    <div id="acceso_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

    <div id="acceso_modal-md" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" style="display:flex;justify-content:center;">
            <div class="modal-content" style="border-radius:1rem;width:50rem;"></div>
        </div>
    </div>

    <div id="acceso_modal_mod" onkeypress="pulsar(event)" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg">
          <div class="modal-content"></div>
      </div>
    </div>

    <div id="acceso_modal_mod-md" onkeypress="pulsar(event)" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" style="display:flex;justify-content:center;">
          <div class="modal-content" style="border-radius:1rem;width:50rem;"></div>
      </div>
    </div>

    <div id="acceso_modal_eli" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg">
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

      $("#acceso_modal-md").on("show.bs.modal", function(e) {
          var link = $(e.relatedTarget);
          $(this).find(".modal-content").load(link.attr("app_crear_per"));
      });

      $("#acceso_modal_mod").on("show.bs.modal", function(e) {
          var link = $(e.relatedTarget);
          $(this).find(".modal-content").load(link.attr("app_crear_mod"));
      });

      $("#acceso_modal_mod-md").on("show.bs.modal", function(e) {
          var link = $(e.relatedTarget);
          $(this).find(".modal-content").load(link.attr("app_crear_mod"));
      });

      $("#acceso_modal_eli").on("show.bs.modal", function(e) {
          var link = $(e.relatedTarget);
          $(this).find(".modal-content").load(link.attr("app_crear_eli"));
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