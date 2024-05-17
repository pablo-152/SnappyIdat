<form id="from_foto" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" style="color: black;"><b>Curso (Nuevo)</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class=" control-label text-bold">Grado: </label>
                <div class="col">
                    <select class="form-control" name="id_grado" id="id_grado">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_grado as $nivel){ ?>
                            <option value="<?php echo $nivel['id_grado'] ; ?>"><?php echo $nivel['descripcion_grado'];?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
    
            <div class="form-group col-md-6">
                <label class=" control-label text-bold">Año: </label>
                <div class="col">
                    <select class="form-control" name="id_anio" id="id_anio">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_anio as $nivel){ ?>
                            <option value="<?php echo $nivel['id_anio'] ; ?>"><?php echo $nivel['nom_anio'];?></option>
                        <?php } ?>
                    </select>
                </div> 
            </div>             
    
            <div class="form-group col-md-6">
                <label class=" control-label text-bold">Inicio Matrículas: </label>
                <div class="col">
                    <input class="form-control" required type="date" id="fec_inicio" name="fec_inicio" placeholder= "Seleccionar Inicio de Matrícula" />
                </div>
            </div>
            
            <div class="form-group col-md-6">
                <label class=" control-label text-bold">Fin Matrículas: </label>
                <div class="col">
                    <input class="form-control" required type="date" id="fec_fin" name="fec_fin" placeholder= "Seleccionar Fin de Matrícula"  />
                </div>
            </div>
            
            <div class="form-group col-md-6 ">
                <label class=" control-label text-bold">Curso&nbsp;a Copiar: </label>
                <div class="col">
                    <select disabled class="form-control" name="id_copiar" id="id_copiar">
                        <option  value="0">Seleccione</option>
                        <?php foreach($list_ as $nivel){ ?>
                            <option value="<?php echo $nivel['id_asignatura'] ; ?>"><?php echo $nivel['nom_asignatura'];?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group col-md-12">
                <label class=" control-label text-bold">Observaciones:</label>
                <div class="col">
                    <textarea name="obs_curso" rows="5" class="form-control" id="obs_curso" placeholder="Observaciones"></textarea>
                </div>
            </div>
        </div>
    </div> 

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Curso();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Curso(){
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

        var dataString = new FormData(document.getElementById('from_foto'));
        var url="<?php echo site_url(); ?>Ceba/Insert_Listado_Curso";

        if (valida_curso()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>Ceba/Curso";
                        });
                }
            }); 
        }    
    }

    function valida_curso() {
        if($('#id_anio').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Año.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#id_grado').val().trim() === '0') { 
            Swal(
                'Ups!',
                'Debe seleccionar Grado.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#fec_inicio').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Fecha Inicio.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#fec_fin').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Fecha Fin.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fec_fin').val().trim() < $('#fec_inicio').val().trim()) {
            Swal(
                'Ups!',
                'Fecha Fin debe ser despues de Fecha Inicio.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
