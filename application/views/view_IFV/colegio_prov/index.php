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
					<h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Colegio Proveniencia (Lista)</b></span></h4>
				</div>

				<div class="heading-elements">
					<div class="heading-btn-group">
						<a title="Nueva Módulo" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Registrar_Colegio_Prov') ?>">
							<img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
						</a>
						<a href="<?= site_url('AppIFV/Excel_Colegio_Prov') ?>">
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


		$("#configuraciones").addClass('active');
		$("#hconfiguraciones").attr('aria-expanded', 'true');
		document.getElementById("rconfiguraciones").style.display = "block";
		$("#configuraciones_ifvonline").addClass('active');
		$("#hconfiguraciones_ifvonline").attr('aria-expanded', 'true');
		document.getElementById("rconfiguraciones_ifvonline").style.display = "block";
		$("#colegio_prov").addClass('active');
		Listar_Colegio_Prov();
	});
</script>

<script>
	function Listar_Colegio_Prov() {
		Cargando()

		var url = "<?php echo site_url(); ?>AppIFV/Listar_Colegio_Prov";

		$.ajax({
			type: "POST",
			url: url,
			success: function(data) {
				$('#busqueda').html(data);
			}
		});
	}

	function Eliminar_Colegio_Prov(id) {
		Cargando()

		var url = "<?php echo site_url(); ?>AppIFV/Eliminar_Colegio_Prov";

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
						'id_colegio_prov': id
					},
					success: function() {
						Listar_Colegio_Prov();
					}
				});
			}
		})
	}
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>
<?php $this->load->view('view_IFV/utils/index.php'); ?>