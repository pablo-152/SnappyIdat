<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tema (Asociar) Actualizar:<?php echo $get_id[0]['desc_tema']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class=" control-label text-bold">Unidad: </label>
                <div class="col">
                    <select class="form-control" id="id_unidad" name="id_unidad">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_unidad as $list){ ?>
                            <option value="<?php echo $list['id_unidad']; ?>" <?php if($list['id_unidad']==$get_id[0]['id_unidad']){ echo "selected"; } ?>>
                                <?php echo $list['nom_unidad']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group col-md-6">
                <label class=" control-label text-bold">Área: </label>
                <div class="col">
                    <select class="form-control" id="id_area" name="id_area" onchange="Area_Asignatura();">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_area as $list){ ?>
                            <option value="<?php echo $list['id_area']; ?>" <?php if($list['id_area']==$get_id[0]['id_area']){ echo "selected"; } ?>>
                                <?php echo $list['descripcion_area']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group col-md-6">
                <label class=" control-label text-bold">Asignatura: </label>
                <div id="aasignatura" class="col">
                    <select class="form-control" name="id_asignatura" id="id_asignatura" onchange="Varios_Tema();">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_asignatura as $list){ ?>
                            <option value="<?php echo $list['id_asignatura']; ?>" <?php if($list['id_asignatura']==$get_id[0]['id_asignatura']){ echo "selected"; } ?>>
                                <?php echo $list['descripcion_asignatura']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group col-md-6">
                <label class=" control-label text-bold">Tema: </label>
                <div id="select_temas" class="col">
                    <select class="form-control" id="id_tema" name="id_tema">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_tema as $list){ ?>
                            <option value="<?php echo $list['id_tema']; ?>" <?php if($list['id_tema']==$get_id[0]['id_tema']){ echo "selected"; } ?>>
                                <?php echo $list['desc_tema'];?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-6">
                <label class=" control-label text-bold">Profesor: </label>
                <div class="col">
                    <select class="form-control" name="id_profesor" id="id_profesor">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_profesor as $list){ ?>
                            <option value="<?php echo $list['id_profesor']; ?>" <?php if($list['id_profesor']==$get_id[0]['id_profesor']){ echo "selected"; } ?>>
                                <?php echo $list['nom_profesor']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_curso" name="id_curso" value="<?php echo $get_id[0]['id_curso']; ?>">
        <input type="hidden" id="id_grado" name="id_grado" value="<?php echo $id_grado; ?>">
        <input type="hidden" id="id_tema_asociar" name="id_tema_asociar" value="<?php echo $get_id[0]['id_tema_asociar']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Asociar_Tema();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Area_Asignatura(){
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

        var id_area = $('#id_area').val();
        var url = "<?php echo site_url(); ?>Ceba2/Area_Asignatura";
        
        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_area':id_area},
            success: function(data){
                $('#aasignatura').html(data);
            }
        });
    }

    function Varios_Tema(){
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

        var id_unidad = $('#id_unidad').val();
        var id_area = $('#id_area').val();
        var id_asignatura = $('#id_asignatura').val();
        var id_grado = $('#id_grado').val();
        var url = "<?php echo site_url(); ?>Ceba2/Varios_Tema";
        
        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_unidad':id_unidad,'id_area':id_area,'id_asignatura':id_asignatura,'id_grado':id_grado},
            success: function(data){
                $('#select_temas').html(data);
            }
        });
    }

    function Update_Asociar_Tema(){
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

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>Ceba2/Update_Tema_Asociar";
        var id = $('#id_curso').val();

        if (Valida_Update_Asociar_Tema()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>Ceba2/Detalles_Curso/"+id;
                    });
                }
            });   
        }
    }

    function Valida_Update_Asociar_Tema() {
        if($('#id_unidad').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Unidad.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#id_area').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Área.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_asignatura').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Asignatura.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#id_tema').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tema.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
