					</div>
					</div>
					<div class="footer text-muted" style="font-size: 14px;">
						&copy; 2021. <span>Snappy</span> 
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>template/css/tablaprueba.css">
	<script src="<?php echo base_url(); ?>template/docs/js/bootbox.min.js"></script>
	<script src="<?php echo base_url(); ?>template/plugins/blockui/jquery.blockUI.min.js"></script>
	<script src="<?php echo base_url(); ?>template/plugins/blockui/custom-blockui.js"></script>

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

			if(nav_cod_sede=="EP1"){
				window.location = "<?php echo site_url(); ?>Ceba2";
			}else{
				window.location = "<?php echo site_url(); ?>Ceba";
			}
		}
	</script>
	
	
<script src="<?=base_url('template/assets/assets2/libs/sweetalert2/dist/sweetalert2.min.js')?>"></script>
</body>
</html>