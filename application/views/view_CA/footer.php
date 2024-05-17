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
	</script>

	<script src="<?php echo base_url(); ?>template/docs/js/bootbox.min.js"></script>
	<script src="<?php echo base_url(); ?>template/plugins/blockui/jquery.blockUI.min.js"></script>
	<script src="<?php echo base_url(); ?>template/plugins/blockui/custom-blockui.js"></script>
	<script src="<?=base_url('template/assets/assets2/libs/sweetalert2/dist/sweetalert2.min.js')?>"></script>
</body>
</html>