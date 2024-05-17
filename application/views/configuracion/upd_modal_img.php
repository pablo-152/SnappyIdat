<form class="form-horizontal" id="from" method="POST" enctype="multipart/form-data" action="<?= site_url('Snappy/update_foto')?>/<?php echo $get_id[0]['id_fintranet'] ?>"  class="formulario">
    <div class="modal-header">
             <?php if(isset($get_id)){ ?>
               <input  type="hidden" name="id_fintranet" id="id_fintranet" value="<?php echo $get_id[0]['id_fintranet'] ?>">
          <?php } ?>
         <h5 class="modal-title" id="exampleModalLabel">Editar Imágen de Intranet</h5>
    </div>
<div class="modal-body" >
        <div class="col-md-12 row termsx">
        <div class="form-group col-md-4">
                <label class="col-sm-6 control-label text-bold">Nombre: </label>
        </div>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="nom_fintranet" name="nom_fintranet" value="<?php echo $get_id[0]['nom_fintranet'] ?>">
        </div> 

        <div class="form-group col-md-4">
        <label class="col-sm-6 control-label text-bold">Imagen: </label>
        </div>
        <div class="form-group col-md-8">
            <a href="<?php echo base_url().$get_id[0]['foto']; ?> " target="_blank" >Obtener</a>
        <div id="d_pdf" >
            <iframe id="pdf" src="<?php echo base_url().$get_id[0]['foto']; ?>" > </iframe>
        </div>
         <div id="pdf-main-container">
            <div id="pdf-contents">
             <canvas id="pdf-canvas"  height=10 0 width=195></canvas>
            <div id="pdf-meta">
                <div id="pdf-buttons">
                </div>
           </div> 
         </div>
        </div>
        </div>     

    <div class="form-group col-md-4">
        <label class="col-sm-6 control-label text-bold">Selecciona imagen:</label>
        </div>
         <div class="form-group col-md-6" id="archivo_essalud_container" align="left">
             <input name="actuimagen" id="actuimagen" type="file" class="file" data-allowed-file-extensions='["png|jpg|pdf"]'  size="100" required >
        </div>
    </div>

 
</div>

    <div class="modal-footer">
    <button type="button" class="btn btn-primary" id="actualizaProductBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Guardar</button>
    <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Cancelar</button>
            
       
    </div>

</form>
<script src="<?= base_url() ?>template/fileinput/js/fileinput.min.js"></script>


<script>

$(document).ready(function() {
    var msgDate = '';
    var inputFocus = '';
	
});

	$("#actualizaProductBtn").on('click', function(e){
       // if (img()) {
            bootbox.confirm({
                title: "Actualizar Imagen",
                message: "¿Desea Actualizar Imagen?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result) {
                        $('#from').submit();
                    }
                } 
            });

         
  /*  } else {
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function () {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
       }*/

    });

 /* function img() {
	 if($('#actuimagen').val().trim() === '') {
	        msgDate = 'Selecciona imagen.';
	        inputFocus = '#actuimagen';
	        return false;
	     }

	   return true;

	}*/
</script>
