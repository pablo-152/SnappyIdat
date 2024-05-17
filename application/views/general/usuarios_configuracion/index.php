<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $sesion['id_nivel'];
$id_usuario = $sesion['id_usuario'];
?>
<?php $this->load->view('general/header'); ?>
<?php $this->load->view('general/nav'); ?>

<style>
	#mydatatable {
      border-spacing: 0;
      border-collapse: collapse;
  }

  	#menu1 * { list-style:none;}
    #menu1 li{ line-height:180%;margin-top: -7px;	}
    #menu1 li a{color:#222; text-decoration:none;}
    #menu1 li a:before{ content:"\025b8"; color:#ddd; margin-right:4px;}
    #menu1 input[name="list"] {
        position: absolute;
        left: -1000em;
        }
    #menu1 label:before{ content:"\025b8"; margin-right:4px;}
    #menu1 input:checked ~ label:before{ content:"\025be";}
    #menu1 .interior{display: none;}
    #menu1 input:checked ~ ul{display:block; margin-left: -8px;margin-top: auto;}

	#menu2 * { list-style:none;}
    #menu2 li{ line-height:180%;}
    #menu2 li a{color:#222; text-decoration:none;}
    #menu2 li a:before{ content:"\025b8"; color:#ddd; margin-right:4px;}
    #menu2 input[name="list"] {
        position: absolute;
        left: -1000em;
        }
    #menu2 label:before{ content:"\025b8"; margin-right:4px;}
    #menu2 input:checked ~ label:before{ content:"\025be";}
    #menu2 .interior{display: none;}
    #menu2 input:checked ~ ul{display:block;}

	ul, ol {
		margin-top: -14px;
		margin-bottom: 8px;
		font-size: 14px;
		margin-left: 80px;
	}

	label {
		font-weight: 500;
	}
</style>

<div class="panel panel-flat">
	<div class="panel-heading">
		<div class="row">
			<div class="x_panel">
					
				<div class="page-title" style="background-color: #C1C1C1;">
					<h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Accesos por Nivel (Lista)</b></span></h4>
				</div>

			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<form class="form-horizontal" id="formulario_acceso" method="POST" enctype="multipart/form-data" >
					<fieldset class="content-group">
						<div class="form-group">
							<label class="control-label col-lg-1"><b>Usuario</b></label>
							<div class="col-lg-4">
								<select name="id_usuario" id="id_usuario" class="form-control" onchange="Menus();">
									<option value="0">Seleccione</option>
									<?php foreach($list_usuario as $list){ ?>
										<option  value="<?php echo $list['id_usuario'] ?>" <?php if($list['id_usuario']==$id_usuario){ echo "selected"; } ?>>
											<?php echo $list['usuario_codigo']; ?>
										</option>
									<?php }?>
								</select>
							</div>
							<div class="">
								<button type="button" style="background-color:#715d74;border-color:#715d74" class="btn btn-success" onclick="Insert_Nivel_Acceso();">Guardar</button>
							</div>
						</div>
					</fieldset>

					<fieldset class="content-group">
						<div id="div_menu" class="card-body">
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
		
<?php $this->load->view('general/footer'); ?>	

<script>
	$(document).ready(function() {
        $("#configuracion").addClass('active');
        $("#hconfiguracion").attr('aria-expanded','true');
        $("#usuario_acceso").addClass('active');
		document.getElementById("rconfiguracion").style.display = "block";

		Menus();
    });

	function Menus(){
		Cargando();

		var url = "<?php echo site_url(); ?>General/Busca_Menu_Nav";
		var dataString = new FormData(document.getElementById('formulario_acceso'));

		if (Valida_Menus()) {
			$.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    $('#div_menu').html(data);  
                }
            });
		}
	}

	function Valida_Menus() {
		if($('#id_usuario').val() == '0') {
			Swal(
				'Ups!',
				'Debe seleccionar Usuario.',
				'warning'
			).then(function() { });
			return false;
		}
		return true;
	}

	function Insert_Nivel_Acceso(){ 
		Cargando();

		var url = "<?php echo site_url(); ?>General/Insert_Nivel_Acceso";
		var dataString = new FormData(document.getElementById('formulario_acceso'));

		if (Valida_Menus()) {
			$.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function () {
					swal.fire(
                      'Actualización Exitosa!',
                      'Haga clic en el botón!',
                      'success'
					).then(function() {
						Menus();
					});
                }
            });
		}
	}

	function todo_submodulo(id_mod,id_sub){
		var id_modulo_grupo=id_mod;
		var id_modulo_subgrupo=id_sub;
		
		if (document.getElementById('id_modulo_subgrupo'+id_modulo_grupo+'-'+id_modulo_subgrupo+'[]').checked){
			//var a="'"+'input[id='+'"'+'subsub'+id_modulo_subgrupo+'-'+id_modulo_grupo+'"'+']'+"'";
			
			$('input[id='+'"'+'subsub'+id_modulo_grupo+'-'+id_modulo_subgrupo+'"'+']').each(function() { 
				this.checked = true; 
			});    
        }else{
			$('input[id='+'"'+'subsub'+id_modulo_grupo+'-'+id_modulo_subgrupo+'"'+']').each(function() { 
				this.checked = false; 
			});
		}
	}

	function todo_modulo(id_empresa,id_modulo){
		var id_empresa=id_empresa;
		var id_modulo=id_modulo;
		
		if (document.getElementById('id_modulo_grupo'+id_empresa+'-'+id_modulo+'[]').checked){
			var a="'"+'input[class='+'"'+'sub'+id_modulo+'"'+']'+"'";
			
			$('input[class='+'"'+'sub'+id_modulo+'"'+']').each(function() { 
				this.checked = true; 
			});    
        }else{
			$('input[class='+'"'+'sub'+id_modulo+'"'+']').each(function() { 
				this.checked = false; 
			});
		}
	}
</script>



		
