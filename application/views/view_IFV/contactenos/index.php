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
					<h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Contáctenos</b></span></h4>
				</div>

				<div class="heading-elements">
					<div class="heading-btn-group">
						<!--<a title="Nueva Módulo" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Registrar_Tipo_Documento') ?>">
							<img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
						</a>
						<a href="<?= site_url('AppIFV/Excel_Tipo_Documento') ?>">
							<img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
						</a>-->
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Listar_Contactenos(1);" id="btn_activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Listar_Contactenos(2);" id="btn_todos" style="color: #000000; background-color: #0070C0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i></a>
            <input type="hidden" id="tipo_excel" name="tipo_excel">
        </div>

        <div class="row">
            <div id="lista_Contactenos" class="col-lg-12"> 
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


		$("#informes").addClass('active');
		$("#hinformes").attr('aria-expanded', 'true');
		document.getElementById("rinformes").style.display = "block";
		//$("#configuraciones_ifvonline").addClass('active');
		//$("#hconfiguraciones_ifvonline").attr('aria-expanded', 'true');
		//document.getElementById("rconfiguraciones_ifvonline").style.display = "block";
		$("#contactenos").addClass('active');
		/*$("#sconf_fv_ifvonline").addClass('active');
		
		$("#hconf_fv_ifvonline").attr('aria-expanded', 'true');
		document.getElementById("rconf_fv_ifvonline").style.display = "block";*/

		Listar_Contactenos();
	});
</script>

<script>
	function Listar_Contactenos(tipo) {
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

		var url = "<?php echo site_url(); ?>AppIFV/Listar_Contactenos/"+tipo;

		$.ajax({
			type: "POST",
			url: url,
			success: function(data) {
				$('#busqueda').html(data);
			}
		});
	}

	function Eliminar_Tipo_Documento(id) {
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

		var url = "<?php echo site_url(); ?>AppIFV/Eliminar_Tipo_Documento";

		Swal({
			title: '¿Realmente desea eliminar el registro?',
			text: "El registro será eliminado permanentemente",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si',
			cancelButtonText: 'No',
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: "POST",
					url: url,
					data: {
						'id_status_general': id
					},
					success: function() {
						Swal(
							'Eliminado!',
							'El registro ha sido eliminado satisfactoriamente.',
							'success'
						).then(function() {
							Listar_Tipo_Documento();
						});
					}
				});
			}
		})
	}
</script>

<?php $this->load->view('view_IFV/footer'); ?>
