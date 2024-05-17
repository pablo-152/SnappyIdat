<script>
function Provincia(mode = 'registrar') {
    var id_departamento = mode === 'editar' ? $('#departamento_e').val() : $('#departamento').val();
    
    var distritoSelector = mode === 'editar' ? 'distrito_e' : 'distrito';
    var provinciaSelector = mode === 'editar' ? 'provincia_e' : 'provincia';
    console.log('Provincia','#m'+provinciaSelector);

    var url = "<?php echo site_url(); ?>AppIFV/Util_Busca_Provincia/"+mode;
    $.ajax({
        type: "POST",
        url: url,
        data: {
            id_departamento
        },
        success: function(data) {
            $('#'+distritoSelector).html('<option value="0">Seleccione</option>');
            $('#'+provinciaSelector).html('<option value="0">Seleccione</option>');
            $('#m'+provinciaSelector).html(data);
        }
    });
}


function Distrito(mode = 'registrar') {
    var id_provincia = mode === 'editar' ? $('#provincia_e').val() : $('#provincia').val();
    var id_departamento = mode === 'editar' ? $('#departamento_e').val() : $('#departamento').val();

    var distritoSelector = mode === 'editar' ? 'distrito_e' : 'distrito';

    var url = "<?php echo site_url(); ?>AppIFV/Util_Busca_Distrito/"+mode;
    $.ajax({
        type: "POST",
        url: url,
        data: {
            id_departamento: id_departamento,
            id_provincia: id_provincia
        },
        success: function(data) {
            $('#m'+distritoSelector).html(data);
        }
    });
}


function activateEnterKeyForFunction(funcToCall) {
	$('.formulario input, .formulario select').keydown(function(event) {
	    if (event.keyCode === 13) {
	        event.preventDefault();
	        funcToCall();
	    }
	});
}

    
</script>