<!--<form id="formulario_requisitar" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Requisitar (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Alumno:</label>
            </div>
            
            <div  class="form-group col-md-10">
                <select name="InternalStudentId" id="InternalStudentId" class="placeholderpermisos js-states custom-select form-control" required>
                    <option value="0">Seleccione</option>
                    <?php foreach($list_alumno as $list){?>
                        <option value="<?php echo $list['InternalStudentId']; ?>"><?php echo $list['FirstName']." ".$list['FatherSurname']." ".$list['MotherSurname'];?></option> 
                    <?php } ?>
                </select>
            </div>
            <input type="hidden" id="opcion" name="opcion" value="1">
        </div>  	           	                	        
    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Buscar_Alumno()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>-->

<!--<script src="<?= base_url() ?>template/docs/js/jquery-3.2.1.min.js"></script>-->
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
    <title>Seleccionar Alumno</title>
    <link href="<?= base_url() ?>template/scanner/style2.css" rel="stylesheet" type="text/css">
  </head>
  <body>
 		<div class="form-group">
			<label class="control-label text-bold">Como Registrar:</label><br>
			<input type="radio" name="estado" id="estadosi" value="1" checked="checked" onclick="Como_Registrar('1')">
			Escanear<br>
			<input type="radio" name="estado" id="estadono" value="2"  onclick="Como_Registrar('2')"> 
			Digitar
		</div>
		<div id="div_scanner">
			<p id="resultado">Aquí aparecerá el código</p>
        	<input type="hidden" class="form-control" id="codigo" name="codigo" >
		</div>
		<div id="div_digitar" style="display:none">
			<p id="resultado">Digitar código:</p>
			<input type="text" class="form-control" id="codigo_d" name="codigo_d" >
		</div>
		<input type="hidden" name="accion" id="accion" value="1">
		
		
		<p>A continuación, capture el codigo de barras: </p>
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
  <script src="<?=base_url('template/assets/assets2/libs/sweetalert2/dist/sweetalert2.min.js')?>"></script>
<script>
    document.addEventListener(" ", () => {
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

	function Como_Registrar(c){
		var div1 = document.getElementById("div_scanner");
		var div2 = document.getElementById("div_digitar");
		if(c==1){
			div1.style.display = "block";
			div2.style.display = "none";
		}else{
			div1.style.display = "none";
			div2.style.display = "block";
		}
	}
    function Cerrar_Ventana_Emegente()
    {
		window.close(); 
    }

    function Validar()
    {
        var url="<?php echo site_url(); ?>AppIFV/Buscar_Alumno";
        var codigo=$('#codigo').val();
		var codigo_d=$('#codigo_d').val();
		if ($('#estadosi').is(":checked")){
			var cod=codigo;
		}else{
			var cod=codigo_d;
		}
        if(cod.trim()===""){
		   Swal(
                '',
                '<b>Debe ingresar o escanear código para validar!</b>',
                'warning'
            ).then(function() { });
        }else{
            $.ajax({
                type:"POST",
                url: url,
                data:{'codigo':cod},
                success:function (data) {
                    if(data=="error"){
						Swal(
							'Sin Resultados',
							'¡No se encontró alumno!',
							'error'
						).then(function() { });
                    }else{
						//$('#div_alumno').html(data);
						Consulta_Almuno_Temporal_Biblioteca();
						//window.close();
                    }
                }
            });
        }
        
        
    }
</script>
</html>

<!--<script>
    $(".placeholderpermisos").select2({
        placeholder: "Haz una selección",
        allowClear: true,
        dropdownParent: $('#acceso_modal')
    });
    $('#ciclo').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Buscar_Alumno(){
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

        var dataString = new FormData(document.getElementById('formulario_requisitar'));
        var url="<?php echo site_url(); ?>AppIFV/Buscar_Alumno";

        if (Valida_Busqueda()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    $('#div_alumno').html(data);
                    $("#acceso_modal .close").click()
                }
            });
        }
    }

    function Valida_Busqueda() {
        if($('#InternalStudentId').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Alumno.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>-->
