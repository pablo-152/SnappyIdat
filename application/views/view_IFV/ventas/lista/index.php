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
					<h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Venta (Lista)</b></span></h4>
				</div>

				<div class="heading-elements">
                    <div class="heading-btn-group">
                        <a href="<?= site_url('AppIFV/Excel_Lista_Ventas') ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
			</div>
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
        $("#ventas").addClass('active');
        $("#hventas").attr('aria-expanded', 'true');
        $("#ve_fv_lista_venta").addClass('active');
		document.getElementById("rventas").style.display = "block";

		Listar_Ventas();
	});
</script>

<script>
	function Listar_Ventas() { 
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

		var url = "<?php echo site_url(); ?>AppIFV/Listar_Ventas";

		$.ajax({
			type: "POST",
			url: url,
			success: function(data) {
				$('#busqueda').html(data);
			}
		});
	}
</script>

<?php $this->load->view('view_IFV/footer'); ?>
