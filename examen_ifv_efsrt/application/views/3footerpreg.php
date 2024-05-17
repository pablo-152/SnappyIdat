<div class="modal-contenedor11">
	<div class="popup11 modal-cerrar11" id="quitaragregarer11">
		<p class="cerrar11"></p>
		<div class="cuerpo11">
		<p style="color:white" ><b>Todas las respuestas son obligatorias.</b><br><br>
		Tienes pendiente contestar la pregunta <span id="pregunta"></span>.</p>
		</div>
	</div>
</div>
<div class="modal-contenedor13">
	<div class="popup13 modal-cerrar13" id="quitaragregarer13">
		<p class="cerrar13"></p>
		<div class="cuerpo13">
		<p style="color:white" ><b>Estimado Postulante.</b><br><br>
		Te quedan 10 minutos para terminar el examen.
								</p>
		</div>
	</div>
</div>

<div class="modal-contenedor14">
	<div class="popup14 modal-cerrar14" id="quitaragregarer14">
		<p class="cerrar14"></p>
		<div class="cuerpo14">
		<p style="text-align: justify;color:white;" >Hola! 
		Excediste los 30 minutos limites para hacer tu examen.<br><br>
		Alguna duda por favor entra en contacto con nosotros.
								</p>
		</div>
	</div>
</div>
<script>
	$('.cerrar11').click(function(){
    document.getElementById("quitaragregarer11").classList.add("modal-cerrar11");
            setTimeout(function(){
                $(".modal-contenedor11").css("opacity", "0");
                $(".modal-contenedor11").css("visibility", "hidden");
            },850) 

    });
    $('.cerrar13').click(function(){
    document.getElementById("quitaragregarer13").classList.add("modal-cerrar13");
            setTimeout(function(){
                $(".modal-contenedor13").css("opacity", "0");
                $(".modal-contenedor13").css("visibility", "hidden");
            },850) 

    });
    $('.cerrar14').click(function(){
    document.getElementById("quitaragregarer14").classList.add("modal-cerrar14");
            setTimeout(function(){
                $(".modal-contenedor14").css("opacity", "0");
                $(".modal-contenedor14").css("visibility", "hidden");
            },850) 

    });
</script>
		
<script src="template/corck/assets/js/libs/jquery-3.1.1.min.js"></script>
		<script src="template/corck/bootstrap/js/popper.min.js"></script>
		<script src="template/corck/bootstrap/js/bootstrap.min.js"></script>
		<script src="template/corck/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="template/corck/assets/js/app.js"></script>
		
		<script>
			$(document).ready(function() {
				App.init();
			});
		</script>
		<script src="template/corck/plugins/highlight/highlight.pack.js"></script>
		<script src="template/corck/assets/js/custom.js"></script>
		<!-- END GLOBAL MANDATORY SCRIPTS -->
		<script src="template/corck/assets/js/scrollspyNav.js"></script>

		<script src="<?= base_url() ?>template/js/jquery-3.2.1.min.js"></script>
        <script src="<?= base_url() ?>template/js/popper.min.js"></script>
        <script src="<?= base_url() ?>template/js/bootstrap.js"></script>
        <script src="<?= base_url() ?>template/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="<?= base_url() ?>template/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="<?= base_url() ?>template/plugins/datatables/datatables.js"></script>
		<script  src="<?= base_url() ?>template/js/script.js"></script>
		<script src="<?=base_url('template/assets/assets2/libs/sweetalert2/dist/sweetalert2.min.js')?>"></script>
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
</div>
</body>

</html>