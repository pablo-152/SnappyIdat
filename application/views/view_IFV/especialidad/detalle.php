<?php
$sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
?>

<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<style>
	.tabset>input[type="radio"] {
		position: absolute;
		left: -200vw;
	}

	.tabset .tab-panel {
		display: none;
	}

	.tabset>input:first-child:checked~.tab-panels>.tab-panel:first-child,
	.tabset>input:nth-child(3):checked~.tab-panels>.tab-panel:nth-child(2),
	.tabset>input:nth-child(5):checked~.tab-panels>.tab-panel:nth-child(3),
	.tabset>input:nth-child(7):checked~.tab-panels>.tab-panel:nth-child(4),
	.tabset>input:nth-child(9):checked~.tab-panels>.tab-panel:nth-child(5),
	.tabset>input:nth-child(11):checked~.tab-panels>.tab-panel:nth-child(6),
	.tabset>input:nth-child(13):checked~.tab-panels>.tab-panel:nth-child(7),
	#tab8:checked~.tab-panels>#rauchbier8 {
		display: block;
	}


	.tabset>label {
		position: relative;
		display: inline-block;
		padding: 15px 15px 25px;
		border: 1px solid transparent;
		border-bottom: 0;
		cursor: pointer;
		font-weight: 600;
		background: #799dfd5c;
	}

	.tabset>label::after {
		content: "";
		position: absolute;
		left: 15px;
		bottom: 10px;
		width: 22px;
		height: 4px;
		background: #8d8d8d;
	}

	.tabset>label:hover,
	.tabset>input:focus+label {
		color: #06c;
	}

	.tabset>label:hover::after,
	.tabset>input:focus+label::after,
	.tabset>input:checked+label::after {
		background: #06c;
	}

	.tabset>input:checked+label {
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
	.margintop {
		margin-top: 5px;
	}

	.clase_boton {
		height: 32px;
		width: 150px;
		padding: 5px;
	}

	.color_casilla {
		border-color: #C8C8C8;
		color: #000;
		background-color: #C8C8C8 !important;
	}

	.img_class {
		position: absolute;
		width: 80px;
		height: 90px;
		top: 5%;
		left: 1%;
	}

	.boton_exportable {
		margin: 0 0 10px 0;
	}

	.cabecera_pagos {
		margin: 5px 0 0 5px;
	}

	.x_panel {
		background-color: #C1C1C1;
		min-height: 10rem;
		display: grid;
		grid-template-columns: 1fr 1fr;
		grid-template-rows: 1fr;
	}

	.page-title h4 {
		font-size: 40px;
		color: white;
		position: absolute;
		top: 40%;
		left: 5%;
		margin: -25px 0 0 -25px;
	}

	@media (max-width: 1280px) {
		.x_panel {
			height: 20rem;
			grid-template-columns: 1fr;
			grid-template-rows: 1fr 1fr;
		}

		.page-title h4 {
			width: 100%;
			text-align: center;
			left: 0;
		}

		.heading-elements {
			position: relative;
			justify-self: center;
		}
	}

	@media (max-width: 768px) {
		.x_panel {
			height: 15rem;
		}
	}
</style>

<div class="panel panel-flat">
	<div class="panel-heading">
		<div class="row">
			<div class="x_panel">
				<div class="page-title">
					<h4><span class="text-semibold"><b> <?php echo $get_id[0]['nom_especialidad']; ?></b></span></h4>
				</div>

				<div class="heading-elements">
					<div class="heading-btn-group">
						<a title="Nueva Area" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Area') ?>/<?php echo $get_id[0]['id_especialidad']; ?>" style="margin-right:5px;">
							<img src="<?= base_url() ?>template/img/boton_area.png" alt="Exportar Excel">
						</a>

						<a title="Nuevo Módulo" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Modulo') ?>/<?php echo $get_id[0]['id_especialidad']; ?>" style="margin-right:5px;">
							<img src="<?= base_url() ?>template/img/boton_modulo.png" alt="Exportar Excel">
						</a>

						<a title="Nuevo Ciclo" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Ciclo') ?>/<?php echo $get_id[0]['id_especialidad']; ?>" style="margin-right:5px;">
							<img src="<?= base_url() ?>template/img/boton_ciclo.png" alt="Exportar Excel">
						</a>

						<a title="Nuevo Turno" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Turno') ?>/<?php echo $get_id[0]['id_especialidad']; ?>" style="margin-right:5px;">
							<img src="<?= base_url() ?>template/img/boton_turno.png" alt="Exportar Excel">
						</a>

						<a title="Nueva Unidad Didactica" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Unidad_Didactica') ?>/<?php echo $get_id[0]['id_especialidad']; ?>" style="margin-right:5px;">
							<img src="<?= base_url() ?>template/img/boton_unidad_didactica.png" alt="Exportar Excel">
						</a>

						<a title="Nueva Evaluación 1" href="#" style="margin-right:5px;">
							<img src="<?= base_url() ?>template/img/boton_eval1.png" alt="Exportar Excel">
						</a>

						<a title="Nueva Evaluación 2" href="#" style="margin-right:5px;">
							<img src="<?= base_url() ?>template/img/boton_eval2.png" alt="Exportar Excel">
						</a>

						<a title="Horas" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Horas_EFSRT') ?>/<?php echo $get_id[0]['id_especialidad']; ?>" style="margin-right:5px;">
							<svg style="display: inline;vertical-align: middle;" xmlns="http://www.w3.org/2000/svg" width="66" height="75" viewBox="0 0 66 75" fill="none">
								<rect width="66" height="75" fill="#9F9DA0" />
								<path d="M20.4403 66V60.1818H24.4972V61.3239H21.8466V62.517H24.2898V63.6619H21.8466V64.858H24.4972V66H20.4403ZM25.3778 66V60.1818H29.3494V61.3239H26.7841V62.517H29.0966V63.6619H26.7841V66H25.3778ZM33.2024 61.9261C33.1835 61.7178 33.0992 61.5559 32.9496 61.4403C32.8018 61.3229 32.5907 61.2642 32.3161 61.2642C32.1342 61.2642 31.9827 61.2879 31.8615 61.3352C31.7403 61.3826 31.6494 61.4479 31.5888 61.5312C31.5282 61.6127 31.4969 61.7064 31.495 61.8125C31.4912 61.8996 31.5083 61.9763 31.5462 62.0426C31.5859 62.1089 31.6428 62.1676 31.7166 62.2188C31.7924 62.268 31.8833 62.3116 31.9893 62.3494C32.0954 62.3873 32.2147 62.4205 32.3473 62.4489L32.8473 62.5625C33.1352 62.625 33.389 62.7083 33.6087 62.8125C33.8303 62.9167 34.0159 63.0407 34.1655 63.1847C34.317 63.3286 34.4316 63.4943 34.5092 63.6818C34.5869 63.8693 34.6267 64.0795 34.6286 64.3125C34.6267 64.6799 34.5339 64.9953 34.3501 65.2585C34.1664 65.5218 33.9022 65.7235 33.5575 65.8636C33.2147 66.0038 32.8009 66.0739 32.3161 66.0739C31.8293 66.0739 31.4051 66.0009 31.0433 65.8551C30.6816 65.7093 30.4003 65.4877 30.1996 65.1903C29.9988 64.893 29.8956 64.517 29.8899 64.0625H31.2365C31.2479 64.25 31.2981 64.4062 31.3871 64.5312C31.4761 64.6562 31.5982 64.7509 31.7536 64.8153C31.9107 64.8797 32.0926 64.9119 32.299 64.9119C32.4884 64.9119 32.6494 64.8864 32.782 64.8352C32.9164 64.7841 33.0196 64.7131 33.0916 64.6222C33.1636 64.5312 33.2005 64.4271 33.2024 64.3097C33.2005 64.1998 33.1664 64.1061 33.1001 64.0284C33.0339 63.9489 32.9316 63.8807 32.7933 63.8239C32.657 63.7652 32.4827 63.7112 32.2706 63.6619L31.6626 63.5199C31.1589 63.4044 30.7621 63.2178 30.4723 62.9602C30.1825 62.7008 30.0386 62.3504 30.0405 61.9091C30.0386 61.5492 30.1352 61.2339 30.3303 60.9631C30.5253 60.6922 30.7952 60.4811 31.1399 60.3295C31.4846 60.178 31.8776 60.1023 32.3189 60.1023C32.7696 60.1023 33.1607 60.179 33.4922 60.3324C33.8255 60.4839 34.084 60.697 34.2678 60.9716C34.4515 61.2462 34.5452 61.5644 34.549 61.9261H33.2024ZM35.3388 66V60.1818H37.7422C38.1778 60.1818 38.5537 60.2604 38.87 60.4176C39.1882 60.5729 39.4335 60.7964 39.6058 61.0881C39.7782 61.3778 39.8643 61.7216 39.8643 62.1193C39.8643 62.5227 39.7763 62.8655 39.6001 63.1477C39.424 63.428 39.174 63.642 38.8501 63.7898C38.5263 63.9356 38.1428 64.0085 37.6996 64.0085H36.1797V62.9006H37.4382C37.6503 62.9006 37.8274 62.8731 37.9695 62.8182C38.1134 62.7614 38.2223 62.6761 38.2962 62.5625C38.37 62.447 38.407 62.2992 38.407 62.1193C38.407 61.9394 38.37 61.7907 38.2962 61.6733C38.2223 61.554 38.1134 61.465 37.9695 61.4062C37.8255 61.3456 37.6484 61.3153 37.4382 61.3153H36.745V66H35.3388ZM38.6143 63.3409L40.0632 66H38.5291L37.1087 63.3409H38.6143ZM40.4453 61.3239V60.1818H45.3629V61.3239H43.5987V66H42.2124V61.3239H40.4453Z" fill="white" />
								<g clip-path="url(#clip0_101_16)">
									<path d="M20.3334 41.0833V23.6667H45.6667V28.8758C46.8067 29.2242 47.8834 29.7308 48.8334 30.4117V23.6667C48.8334 21.9092 47.4242 20.5 45.6667 20.5H39.3334V17.3333C39.3334 15.5758 37.9242 14.1667 36.1667 14.1667H29.8334C28.0759 14.1667 26.6667 15.5758 26.6667 17.3333V20.5H20.3334C18.5759 20.5 17.1826 21.9092 17.1826 23.6667L17.1667 41.0833C17.1667 42.8408 18.5759 44.25 20.3334 44.25H32.4934C32.0184 43.2683 31.7017 42.2075 31.5434 41.0833H20.3334ZM29.8334 17.3333H36.1667V20.5H29.8334V17.3333Z" fill="white" />
									<path d="M42.4999 31.5833C38.1299 31.5833 34.5833 35.13 34.5833 39.5C34.5833 43.87 38.1299 47.4167 42.4999 47.4167C46.8699 47.4167 50.4166 43.87 50.4166 39.5C50.4166 35.13 46.8699 31.5833 42.4999 31.5833ZM45.1124 43.2208L41.7083 39.8167V34.75H43.2916V39.1675L46.2208 42.0967L45.1124 43.2208Z" fill="white" />
								</g>
								<defs>
									<clipPath id="clip0_101_16">
										<rect width="38" height="38" fill="white" transform="translate(14 11)" />
									</clipPath>
								</defs>
							</svg>
						</a>

						<a type="button" href="<?= site_url('AppIFV/Especialidad') ?>">
							<img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 row">
				<div class="form-group col-md-1">
					<label class="col-sm-3 control-label text-bold margintop">Licenciamiento:</label>
				</div>
				<div class="form-group col-md-2">
					<input type="text" class="form-control" disabled value="<?php echo $get_id[0]['nom_licenciamiento']; ?>">
				</div>

				<div class="form-group col-md-1">
				</div>

				<div class="form-group col-md-1">
					<label class="col-sm-3 control-label text-bold margintop">Código:</label>
				</div>
				<div class="form-group col-md-2">
					<input type="text" class="form-control" disabled value="<?php echo $get_id[0]['abreviatura']; ?>">
				</div>

				<div class="form-group col-md-1">
				</div>

				<div class="form-group col-md-1">
					<label class="col-sm-3 control-label text-bold margintop">Nombre: </label>
				</div>
				<div class="form-group col-md-3">
					<input type="text" class="form-control" disabled value="<?php echo $get_id[0]['nom_especialidad']; ?>">
				</div>
			</div>

			<div class="col-md-12 row">
				<div class="form-group col-md-1">
					<label class="col-sm-3 control-label text-bold margintop">N°&nbsp;Módulos: </label>
				</div>
				<div class="form-group col-md-2">
					<input type="text" class="form-control" disabled value="<?php echo $get_id[0]['nmodulo']; ?>">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="tabset">
				<input type="radio" name="tabset" id="tab1" aria-controls="rauchbier1" checked>
				<label for="tab1">Áreas</label>

				<input type="radio" name="tabset" id="tab2" aria-controls="rauchbier2">
				<label for="tab2">Módulos</label>

				<input type="radio" name="tabset" id="tab3" aria-controls="rauchbier3">
				<label for="tab3">Ciclos</label>

				<input type="radio" name="tabset" id="tab4" aria-controls="rauchbier4">
				<label for="tab4">Turnos</label>

				<input type="radio" name="tabset" id="tab5" aria-controls="rauchbier5">
				<label for="tab5">Unid. Didácticas</label>

				<input type="radio" name="tabset" id="tab6" aria-controls="rauchbier6">
				<label for="tab6">Item Eval. 1</label>

				<input type="radio" name="tabset" id="tab7" aria-controls="rauchbier7">
				<label for="tab7">Item Eval. 2</label>

				<input type="radio" name="tabset" id="tab8" aria-controls="rauchbier8">
				<label for="tab8">EFSRT</label>

				<input type="hidden" id="id_especialidad" name="id_especialidad" value="<?php echo $get_id[0]['id_especialidad']; ?>">

				<div class="tab-panels">
					<!-- AREAS -->
					<section id="rauchbier1" class="tab-panel">
						<div class="boton_exportable">
							<a title="Excel" onclick="Excel_Area();">
								<img src="<?= base_url() ?>template/img/boton_excel_tabla.png">
							</a>
						</div>

						<div class="modal-content">
							<div id="lista_area">
							</div>
						</div>
					</section>

					<!-- MODULOS -->
					<section id="rauchbier2" class="tab-panel">
						<div class="boton_exportable">
							<a title="Excel" onclick="Excel_Modulo();">
								<img src="<?= base_url() ?>template/img/boton_excel_tabla.png">
							</a>
						</div>

						<div class="modal-content">
							<div id="lista_modulo">
							</div>
						</div>
					</section>

					<!-- CICLOS -->
					<section id="rauchbier3" class="tab-panel">
						<div class="boton_exportable">
							<a title="Excel" onclick="Excel_Ciclo();">
								<img src="<?= base_url() ?>template/img/boton_excel_tabla.png">
							</a>
						</div>

						<div class="modal-content">
							<div id="lista_ciclo">
							</div>
						</div>
					</section>

					<!-- TURNOS -->
					<section id="rauchbier4" class="tab-panel">
						<div class="boton_exportable">
							<a title="Excel" onclick="Excel_Turno();">
								<img src="<?= base_url() ?>template/img/boton_excel_tabla.png">
							</a>
						</div>

						<div class="modal-content">
							<div id="lista_turno">
							</div>
						</div>
					</section>

					<!-- UNIDADES DIDACTICAS -->
					<section id="rauchbier5" class="tab-panel">
						<div class="boton_exportable">
							<a title="Excel" onclick="Excel_Unidad_Didactica();">
								<img src="<?= base_url() ?>template/img/boton_excel_tabla.png">
							</a>
						</div>

						<div class="modal-content">
							<div id="lista_unidad_didactica">
							</div>
						</div>
					</section>

					<!-- EVALUACIÓN 1 -->
					<section id="rauchbier6" class="tab-panel">
						<div class="modal-content">
							<div id="lista_evaluacion1">
							</div>
						</div>
					</section>

					<!-- EVALUACIÓN 2 -->
					<section id="rauchbier7" class="tab-panel">
						<div class="modal-content">
							<div id="lista_evaluacion2">
							</div>
						</div>
					</section>

					<!-- EFSRT -->
					<section id="rauchbier8" class="tab-panel">
						<div class="boton_exportable">
							<a title="Excel" onclick="Excel_Horas_EFSRT();">
								<img src="<?= base_url() ?>template/img/boton_excel_tabla.png">
							</a>
						</div>

						<div class="modal-content">
							<div id="list_horas_efsrt">
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
		$("#especialidades").addClass('active');
		document.getElementById("rconfiguraciones").style.display = "block";

		Lista_Area();
		Lista_Modulo();
		Lista_Ciclo();
		Lista_Turno();
		Lista_Unidad_Didactica();
		Lista_Horas_EFSRT();
	});

	function Lista_Area() {
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

		var id_especialidad = $("#id_especialidad").val();
		var url = "<?php echo site_url(); ?>AppIFV/Lista_Area";

		$.ajax({
			type: "POST",
			url: url,
			data: {
				'id_especialidad': id_especialidad
			},
			success: function(data) {
				$('#lista_area').html(data);
			}
		});
	}

	function Delete_Area(id) {
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

		var url = "<?php echo site_url(); ?>AppIFV/Delete_Area";

		Swal({
			title: '¿Realmente desea eliminar el registro',
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
						'id_area': id
					},
					success: function() {
						Lista_Area();
					}
				});
			}
		})
	}

	function Excel_Area() {
		var id_especialidad = $('#id_especialidad').val();
		window.location = "<?php echo site_url(); ?>AppIFV/Excel_Area_Especialidad/" + id_especialidad;
	}

	function Lista_Modulo() {
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

		var id_especialidad = $("#id_especialidad").val();
		var url = "<?php echo site_url(); ?>AppIFV/Lista_Modulo";

		$.ajax({
			type: "POST",
			url: url,
			data: {
				'id_especialidad': id_especialidad
			},
			success: function(data) {
				$('#lista_modulo').html(data);
			}
		});
	}

	function Delete_Modulo(id) {
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

		var url = "<?php echo site_url(); ?>AppIFV/Delete_Modulo";
		Swal({
			title: '¿Realmente desea eliminar el registro',
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
						'id_modulo': id
					},
					success: function() {
						Lista_Modulo();
					}
				});
			}
		})
	}

	function Excel_Modulo() {
		var id_especialidad = $('#id_especialidad').val();
		window.location = "<?php echo site_url(); ?>AppIFV/Excel_Modulo_Especialidad/" + id_especialidad;
	}

	function Lista_Ciclo() {
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

		var id_especialidad = $("#id_especialidad").val();
		var url = "<?php echo site_url(); ?>AppIFV/Lista_Ciclo";

		$.ajax({
			type: "POST",
			url: url,
			data: {
				'id_especialidad': id_especialidad
			},
			success: function(data) {
				$('#lista_ciclo').html(data);
			}
		});
	}

	function Delete_Ciclo(id) {
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

		var url = "<?php echo site_url(); ?>AppIFV/Delete_Ciclo";
		Swal({
			title: '¿Realmente desea eliminar el registro',
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
						'id_ciclo': id
					},
					success: function() {
						Lista_Ciclo();
					}
				});
			}
		})
	}

	function Excel_Ciclo() {
		var id_especialidad = $('#id_especialidad').val();
		window.location = "<?php echo site_url(); ?>AppIFV/Excel_Ciclo_Especialidad/" + id_especialidad;
	}

	function Lista_Turno() {
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

		var id_especialidad = $("#id_especialidad").val();
		var url = "<?php echo site_url(); ?>AppIFV/Lista_Turno";

		$.ajax({
			type: "POST",
			url: url,
			data: {
				'id_especialidad': id_especialidad
			},
			success: function(data) {
				$('#lista_turno').html(data);
			}
		});
	}

	function Delete_Turno(id) {
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

		var url = "<?php echo site_url(); ?>AppIFV/Delete_Turno";

		Swal({
			title: '¿Realmente desea eliminar el registro',
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
						'id_turno': id
					},
					success: function() {
						Lista_Turno();
					}
				});
			}
		})
	}

	function Excel_Turno() {
		var id_especialidad = $('#id_especialidad').val();
		window.location = "<?php echo site_url(); ?>AppIFV/Excel_Turno_Especialidad/" + id_especialidad;
	}

	function Lista_Unidad_Didactica() {
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

		var id_especialidad = $("#id_especialidad").val();
		var url = "<?php echo site_url(); ?>AppIFV/Lista_Unidad_Didactica";

		$.ajax({
			type: "POST",
			url: url,
			data: {
				'id_especialidad': id_especialidad
			},
			success: function(data) {
				$('#lista_unidad_didactica').html(data);
			}
		});
	}

	function Delete_Unidad_Didactica(id) {
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

		var url = "<?php echo site_url(); ?>AppIFV/Delete_Unidad_Didactica";

		Swal({
			title: '¿Realmente desea eliminar el registro',
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
						'id_unidad_didactica': id
					},
					success: function() {
						Lista_Unidad_Didactica();
					}
				});
			}
		})
	}

	function Excel_Unidad_Didactica() {
		var id_especialidad = $('#id_especialidad').val();
		window.location = "<?php echo site_url(); ?>AppIFV/Excel_Unidad_Didactica_Especialidad/" + id_especialidad;
	}

	function Lista_Horas_EFSRT() {
		Cargando();

		var id_especialidad = $("#id_especialidad").val();
		var url = "<?php echo site_url(); ?>AppIFV/Lista_Horas_EFSRT";

		$.ajax({
			type: "POST",
			url: url,
			data: {
				'id_especialidad': id_especialidad
			},
			success: function(data) {
				$('#list_horas_efsrt').html(data);
			}
		});
	}

	function Delete_Horas_EFSRT(id) {
		Cargando();
		var url = "<?php echo site_url(); ?>AppIFV/Delete_Horas_EFSRT";
		Swal({
			title: '¿Realmente desea eliminar el registro',
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
						'id_horas': id
					},
					success: function() {
						Lista_Horas_EFSRT();
					}
				});
			}
		})
	}

	function Excel_Horas_EFSRT() {
		var id_especialidad = $('#id_especialidad').val();
		window.location = "<?php echo site_url(); ?>AppIFV/Excel_Horas_EFSRT/" + id_especialidad;
	}
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>
