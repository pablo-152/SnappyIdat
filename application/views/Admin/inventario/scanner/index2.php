<script src="<?= base_url() ?>template/docs/js/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="<?= base_url('template/assets/assets2/libs/sweetalert2/dist/sweetalert2.min.css') ?>">
<!DOCTYPE html>
<style>
	.btn {
    display: inline-block;
    margin-bottom: 0;
    font-weight: normal;
    text-align: center;
    vertical-align: middle;
    touch-action: manipulation;
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
    white-space: nowrap;
    padding: 7px 12px;
    font-size: 13px;
    line-height: 1.5384616;
    border-radius: 3px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
	}

	body {
    font-family: "Roboto", Helvetica Neue, Helvetica, Arial, sans-serif;
    font-size: 16px;
    line-height: 1.5384616;
    color: #333333;
    background-color: #f5f5f5;
	}
</style>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Leer código de barras de producton</title>
    <link href="<?= base_url() ?>template/scanner/style2.css" rel="stylesheet" type="text/css">
  </head>
  <body>
		<p id="resultado">Aquí aparecerá el código</p>
        <input type="hidden" class="form-control"  id="codigo" name="codigo" autofocus>
		<p>A continuación, capture el codigo de barras: </p>
        <!--<button class="btn btn-secondary mt-3" style="width:150px;" type="button" onclick="Cerrar_Ventana_Emegente();"><i class="flaticon-cancel-12"></i>Cerrar</button>
        <button class="btn btn-secondary mt-3" style="width:150px;" type="button" onclick="Validar();"><i class="flaticon-cancel-12"></i>Validar</button>-->

		<button type="button" class="btn btn-primary" onclick="Validar()" style="color: #fff;background-color: #715d74;border-color: #715d74;position: relative;" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Validar
        </button>
        <button type="button" class="btn btn-default" onclick="Cerrar_Ventana_Emegente();" style="color: #333;background-color: #fcfcfc;border-color: #ddd;position: relative;">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
<br><br>
		<div id="contenedor"></div>
		<script src="<?= base_url() ?>template/scanner/quagga.min.js"></script>
  </body>
</html>
<script src="<?=base_url('template/assets/assets2/libs/sweetalert2/dist/sweetalert2.min.js')?>"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
	const $resultados = document.querySelector("#resultado");
    const $codigos = document.querySelector("#codigo");
	Quagga.init({
		inputStream: {
			constraints: {
				width: 1920,
				height: 1080,
			},
			name: "Live",
			type: "LiveStream",
			target: document.querySelector('#contenedor'), // Pasar el elemento del DOM
		},
		decoder: {
			readers: ["code_39_reader"]
		}
	}, function (err) {
		if (err) {
			console.log(err);
			return
		}
		console.log("Iniciado correctamente");
		Quagga.start();
	});

	Quagga.onDetected((data) => {
		$resultados.textContent = data.codeResult.code;
        $codigos.value = data.codeResult.code;
        
        
		// Imprimimos todo el data para que puedas depurar
		console.log(data);
	});

	Quagga.onProcessed(function (result) {
		var drawingCtx = Quagga.canvas.ctx.overlay,
			drawingCanvas = Quagga.canvas.dom.overlay;

		if (result) {
			if (result.boxes) {
				drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
				result.boxes.filter(function (box) {
					return box !== result.box;
				}).forEach(function (box) {
					Quagga.ImageDebug.drawPath(box, { x: 0, y: 1 }, drawingCtx, { color: "green", lineWidth: 2 });
				});
			}

			if (result.box) {
				Quagga.ImageDebug.drawPath(result.box, { x: 0, y: 1 }, drawingCtx, { color: "#00F", lineWidth: 2 });
			}

			if (result.codeResult && result.codeResult.code) {
				Quagga.ImageDebug.drawPath(result.line, { x: 'x', y: 'y' }, drawingCtx, { color: 'red', lineWidth: 3 });
			}
		}
	});
	});

    function Cerrar_Ventana_Emegente()
    {
		window.close();
        
    }

    function Validar()
    {
        var url="<?php echo site_url(); ?>Snappy/Validar_Codigo_Scanner";
        var codigo=$('#codigo').val();
        if($('#codigo').val().trim()===""){
		   Swal(
                '',
                '<b>Debe capturar un código para validar!</b>',
                'warning'
            ).then(function() { });
        }else{
            $.ajax({
                type:"POST",
                url: url,
                data:{'codigo':codigo},
                success:function (data) {
					
                    if(data=="1"){
						Swal(
							'',
							'<b>Código no encontrado!</b>',
							'warning'
						).then(function() { });
                    }else if(data=="2"){
                        
						Swal(
							'',
							'<b>Código ya esta validado!</b>',
							'warning'
						).then(function() { });
                    }else{
                        
						Swal(
							'',
							'<b>Código validado exitosamente!</b>',
							'success'
						).then(function() { 
							window.close();
						});
						
                    }
                    
                }
            });
        }
        
        
    }
</script>