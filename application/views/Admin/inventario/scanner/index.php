<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lectura de código de barras</title>
</head>
<body>
		<input id="codigo" type="text">
		<br>
		<button id="btnEscanear">Escanear</button>
</body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", () => {
	const $btnEscanear = document.querySelector("#btnEscanear"),
	$input = document.querySelector("#codigo");
	$btnEscanear.addEventListener("click", ()=>{
		window.open("<?= site_url('Snappy/Leer') ?>");
	});

	window.onCodigoLeido = datosCodigo => {
		console.log("Oh sí, código leído: ")
		console.log(datosCodigo)
		$input.value = datosCodigo.codeResult.code;
	}
});
</script>