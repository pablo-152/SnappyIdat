<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<div class="panel panel-flat">
	<div class="panel-heading">
		<div class="row">
			<div class="x_panel">
				<div class="page-title" style="background-color: #C1C1C1;">
					<h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>FUT Recibidos (Lista)</b></span></h4>
				</div>

				<div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Fut_Recibido();" style="margin-left: 5px;">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
			</div>
		</div>
	</div>
	<input type="hidden" id="tipo_excel" value="1">

	<div class="container-fluid" style="margin-top:15px;margin-bottom:15px;">
		<div class="row col-md-12 col-sm-12 col-xs-12">
			<a onclick="Listar_Fut_Recibidos(0);" id="activos" style="color: #000000;background-color: #00C000;height:32px;width:150px;padding:5px;" class="form-group btn ">
				<span>Pendientes</span><i class="icon-arrow-down52"></i>
			</a>
			<a onclick="Listar_Fut_Recibidos(1);" id="terminados" style="color: #000000;background-color: #7F7F7F;height:32px;width:150px;padding:5px;" class="form-group btn ">
				<span>Todos</span><i class="icon-arrow-down52"></i>
			</a>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12" id="busqueda">
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
        $("#tramites").addClass('active');
        $("#rtramites").attr('aria-expanded', 'true');
        $("#trami_fv_gut").addClass('active');
		document.getElementById("rtramites").style.display = "block";

		Listar_Fut_Recibidos(0);
	});

	function Listar_Fut_Recibidos(id) {
		$(document)
		.ajaxStart(function() {
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
		.ajaxStop(function() {
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

		var url = "<?php echo site_url(); ?>AppIFV/Listar_Fut_Recibidos";

		$.ajax({
			type: "POST",
			url: url,
			data:{'id':id},
			success: function(data) {
				$('#busqueda').html(data);
				$('#tipo_excel').val(id);
			}
		});
	}

	function Excel_Fut_Recibido(){
        var tipo_excel=$('#tipo_excel').val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Fut_Recibido/"+tipo_excel;
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>
