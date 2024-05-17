<div class="contenedor-boton1">
    <button class="cssbuttons-io-button "> <?php echo $ingresados; ?>
        <div class="icon colorboton1">
            Ingresados
        </div>
    </button>
</div>
<div class="contenedor-boton2">
    <button class="cssbuttons-io-button "> <?php echo $pendientes; ?>
        <div class="icon colorboton2">
            Pendientes
        </div>
    </button>
</div>		
<div class="contenedor-boton3">
    <button class="cssbuttons-io-button" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Asistencia/Modal_Registro_Salida') ?>"> <?php echo $sin_salida; ?>
        <div class="icon colorboton3">
            Sin Salida
        </div>
    </button>
</div>	
<div class="contenedor-boton4">
    <button class="btn4" onclick="Salir();">Salir</button>
</div>