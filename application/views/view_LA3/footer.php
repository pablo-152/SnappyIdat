						</div>
					</div>
					<div class="footer text-muted" style="font-size: 14px;">
						&copy; 2021. <span>Snappy</span> 
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
		$(document).ready(function() {
			$('#mydatatable tfoot th').each( function () {
				var title = $(this).text();
				$(this).html( '<input  style="width:100%; border-radius:40px;border-color:#eaeaea;"  placeholder="Filtrar.." />' );
			} );

			var table = $('#mydatatable').DataTable({
				
				"language": {
					"url": "<?=base_url() ?>template/assets/tabla_filtro.json"
				},
				pageLength: 21,
				
				"initComplete": function () {
					this.api().columns().every( function () {
						var that = this;

						$( 'input', this.footer() ).on( 'keyup change', function () {
							if ( that.search() !== this.value ) {
								that
									.search( this.value )
									.draw();
								}
						});
					})
				}
			});
		});
	</script>

	<script> 
		function Error_Laleli(){
			Swal({
                title: 'Acceso Denegado',
                text: "¡No tiene acceso!",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
		}

		function Cambiar_Nav_Sede(){
			$(document)
			.ajaxStart(function () {
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
			.ajaxStop(function () {
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

			var nav_cod_sede = $("#nav_cod_sede").val(); 

			if(nav_cod_sede=="LA0"){
				window.location = "<?php echo site_url(); ?>Laleli";
			}else if(nav_cod_sede=="LA1"){
				window.location = "<?php echo site_url(); ?>Laleli1";
			}else if(nav_cod_sede=="LA2"){
				window.location = "<?php echo site_url(); ?>Laleli2";
			}else if(nav_cod_sede=="LA3"){
				window.location = "<?php echo site_url(); ?>Laleli3";
			}else if(nav_cod_sede=="LA4"){
				window.location = "<?php echo site_url(); ?>Laleli4";
			}else if(nav_cod_sede=="LA5"){
				window.location = "<?php echo site_url(); ?>Laleli5";
			}else if(nav_cod_sede=="LA8"){
				window.location = "<?php echo site_url(); ?>Laleli8";
			}else if(nav_cod_sede=="LA9"){
				window.location = "<?php echo site_url(); ?>Laleli9";
			}else{
				Error_Laleli();
			}
		}
	</script>

	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>template/css/tablaprueba.css">
	<script src="<?php echo base_url(); ?>template/docs/js/bootbox.min.js"></script>
	<script src="<?php echo base_url(); ?>template/plugins/blockui/jquery.blockUI.min.js"></script>
	<script src="<?php echo base_url(); ?>template/plugins/blockui/custom-blockui.js"></script>
	<script src="<?=base_url('template/assets/assets2/libs/sweetalert2/dist/sweetalert2.min.js')?>"></script>
</body>
</html>