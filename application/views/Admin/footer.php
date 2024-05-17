					</div>
					</div>
					<div class="footer text-muted" style="font-size: 14px;">
						&copy; 2021. <span>Snappy</span> 
					</div>
				</div>
			</div>
		</div>
	</div>

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