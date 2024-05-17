<script>
	// cambiar de simbolo de monto
	$(document).ready(function() {
	    $('.tipo-descuento-select').on('change', function() {
	        var selectedValue = $(this).val();
	        var modal = $(this).closest('.modal'); // Encuentra la modal padre
		
	        var montoSimbolo = modal.find('.monto-simbolo'); // Encuentra el span monto-simbolo dentro de la modal

	        if (selectedValue === '1') { // '%' option value
	            montoSimbolo.text('%');
	        } else {
	            montoSimbolo.text('S/.');
	        }
	    });
	});

	function activateEnterKeyForFunction(funcToCall) {
	    $('.formulario input, .formulario select').keydown(function(event) {
	        if (event.keyCode === 13) {
	            event.preventDefault();
	            funcToCall();
	        }
	    });
	}
</script>