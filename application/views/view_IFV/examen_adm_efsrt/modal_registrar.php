<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Examen de Admisión EFSRT (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Nombre:</label>
                <input type="text" class="form-control" id="nom_examen" name="nom_examen" placeholder="Nombre">
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Fecha Examen:</label>
                <input type="date" class="form-control" id="fec_limite" name="fec_limite">
            </div>
            
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Publicación de Resultados:</label>
                <input type="date" class="form-control" id="fec_resultados" name="fec_resultados">
            </div>
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Carreras</label>
                <select id="carrera" name="carrera[]" multiple="multiple" class="select form-control">
                    <?php foreach($list_especialidad as $list){?>
                    <option value="<?php echo $list['id_especialidad'] ?>" selected><?php echo $list['nom_especialidad'] ?></option>    
                    <?php }?>
                </select>
            </div>
        </div>  	           	                	        
    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Examen_Efsrt_IFV();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $('.select').select2({
        minimumResultsForSearch: Infinity
    });
    function Insert_Examen_Efsrt_IFV(){
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

        var dataString = $("#formulario_insert").serialize();
        var url="<?php echo site_url(); ?>AppIFV/Insert_Examen_Efsrt_IFV";

        if (Valida_Insert_Examen_Efsrt_IFV()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $("#acceso_modal .close").click();
                        Lista_Examen_Efsrt($('#tipo_excel').val())
                        //window.location = "<?php echo site_url(); ?>AppIFV/Examen_Efsrt";
                    });
                }
            });
        }
    }

    function Valida_Insert_Examen_Efsrt_IFV() {
        if($('#nom_examen').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#fec_limite').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Límite.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#fec_resultados').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha de Publicación de Resultados.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#carrera').val() == null) {
            Swal(
                'Ups!',
                'Debe seleccionar Carrera.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
