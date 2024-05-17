
		<!-- jQuery -->
		<script src="<?= base_url() ?>template/js/jquery-3.2.1.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="<?= base_url() ?>template/js/popper.min.js"></script>
        <script src="<?= base_url() ?>template/js/bootstrap.js"></script>
		<!-- Slimscroll JS -->
        <script src="<?= base_url() ?>template/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<!-- Datatables JS -->
		<script src="<?= base_url() ?>template/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="<?= base_url() ?>template/plugins/datatables/datatables.js"></script>
		<!-- Custom JS -->
		<script  src="<?= base_url() ?>template/js/script.js"></script>

		<!-- SweetAlert -->    
		<script src="<?=base_url('template/assets/assets2/libs/sweetalert2/dist/sweetalert2.min.js')?>"></script>
		<!-- SweetAlert -->

        <script>
            $(document).ready(function(){
                $(".modall-container").show();
                                $(".modall-container").css("opacity", "1");
                                $(".modall-container").css("visibility", "visible");
                            document.getElementById("quitaragregar").classList.remove("modal-closer");


				$('a.ingresa_tu ').click(function(){
					document.getElementById("quitaragregar").classList.add("modal-closer");
					setTimeout(function(){
						$(".modall-container").css("opacity", "0");
						$(".modall-container").css("visibility", "hidden");
					},850)  
				});
            });
        </script>

		<script>
			window.onload = function(){
				setInterval(function(){
						var contenedor = document.getElementById("contenedor_pequeñacarga");
						contenedor.style.visibility ='hidden';
						contenedor.style.opacity='0';
						$("body").css("overflow-y", "visible");
						$(".main-wrapper").css("opacity", "1");
				}, 1000);
			};

			timeout = setTimeout(function () {
				$(".sidebar").css("visibility", "visible");
				$(".sidebar").css("opacity", "1");
				$(".sidebar").css("visibility", "visible");
				$(".sidebar").css("opacity", "1");
				$(".sidebar-menu").css("visibility", "visible");
				$(".sidebar-menu").css("opacity", "1");
				$(".main-wrapper").css("visibility", "visible");
				$(".main-wrapper").css("opacity", "1"); 
			}, 1000);


			timeout = setTimeout(function () {
				$(".puntajealterno").css("visibility", "visible");
				$(".puntajealterno").css("opacity", "1");
				$(".progreso-contenedoralterno ").css("display", "block");
				//$(".progreso-contenedoralterno").css("height", "25px");
			}, 2000);
		</script>
	
		<script>
			if($('.contenedor_pequeñacarga').length > 0 ){
				var height = $(window).height();	
				$(".contenedor_pequeñacarga").css("min-height", height);
			}
			
			// Page Content Height Resize
			
			$(window).resize(function(){
				if($('.contenedor_pequeñacarga').length > 0 ){
					var height = $(window).height();
					$(".contenedor_pequeñacarga").css("min-height", height);
				}
			});
		</script>
		<script>
			function Avanzar() {
				var dataString = $("#formulario").serialize();
				if (Valida()) {
					$('#formulario').submit();
				}
			}
			function Pasar_Siosi() {
				var dataString = $("#formulariosiosi").serialize();
				if (Valida()) {
					$('#formulariosiosi').submit();
				}
			}
			function Pasar_Siosi_sinmoneda() {
				var dataString = $("#formulariosiosisinmodena").serialize();
				if (Valida()) {
					$('#formulariosiosisinmodena').submit();
				}
			}
			function Valida(){
				return true;
			}
			function Reintentar_Tema() {
				var dataString = $("#formulariointento2").serialize();
				if (Valida()) {
					$('#formulariointento2').submit();
				}
			}
		</script>
		<script>
			function Reintentar_Examen(){
				
				var dataString = $("#formularioex").serialize();
				var url="<?php echo site_url(); ?>Alumno/Valida_Cantidad_Moneda";
					if (Valida()) {
						$.ajax({
								type:"POST",
								url:url,
								data:dataString,
								success:function (data) {
									if(data=="error")
									{
										alert("¡UPS! \rNo cuentas con monedas suficientes");

									}
									else
									{
										$('#formularioex').submit();
									}
								}
							});
				}
				else{
					bootbox.alert(msgDate)
					var input = $(inputFocus).parent();
					$(input).addClass("has-error");
					$(input).on("change", function () {
						if ($(input).hasClass("has-error")) {
							$(input).removeClass("has-error");
						}
					});
				}
			}
			function Valida(){
				return true;
			}
		</script>
</div>
</body>
</html>