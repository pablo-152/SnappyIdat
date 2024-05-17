<input type="hidden" id="parametro" name="parametro" value="<?php echo $parametro ?>">
<div class="x_panel">
    <?php foreach($list_empresam as $list){?>
        <div class="col-lg-2 col-xs-6">
            <div class="small-box" style="color:#fff;background:<?php echo $list['color']; ?>">
            <div class="inner" align="center">
                <h3 style="font-size: 32px;">
                <b><?php echo $list['cod_empresa']; ?></b>
                </h3> 
            </div>
            <div>
                <table id="" class="table-total" align="center" width="100%">
                <thead style="color:#fff;background:<?php echo $list['color']; ?>">
                    <tr>
                        <th width="20%">&nbsp;</th>
                        <th width="35%">&nbsp;</th>
                        <th width="35%">&nbsp;</th>
                        <th width="10%">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>&nbsp;</td>
                    <td style="text-align: center;cursor:help" title="Sin Asignar"><b>Sa</b></td>
                    <td style="text-align: center;cursor:help" title="Asignados"><b>As</b></td>
                    </tr>
                    <?php foreach($list_sedem as $sed) {
                    if($sed['id_empresa']==$list['id_empresa']){?>
                        <tr>
                            <td>&nbsp;<?php echo $sed['cod_sede'] ?></td>
                            <td style="text-align: center;"><?php echo $sed['sin_asignar']; ?></td>
                            <td style="text-align: center;"><?php echo $sed['asignados'] ?></td>
                        </tr>
                    <?php } } ?>
                </tbody>
                </table>
                <br>
            </div>
            </div>
        </div>
    <?php } ?>
</div>

<div class="row">
    <div class="x_panel col-md-12">
    <div class="inner" style="margin-left:10px">
        <form method="post" id="formulario_excel" enctype="multipart/form-data" class="formulario" >
        <div class="heading-btn-group">
            <br>
            <a onclick="Buscar(this,0);"  id="sasignar" style="color: #ffffff;background-color: #C00000;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Sin Asignar</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Buscar(this,1);"  id="todos" style="color: #000000;background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Todos</span><i class="icon-arrow-down52"></i></a>
        </div>
        </form>
    </div>
    </div>
</div>

<div class="row">
    <form id="formulario_ibd" method="POST" enctype="multipart/form-data" class="needs-validation">
    <input type="hidden" id="anio_f" name="anio_f">
    <input type="hidden" id="folder_f" name="folder_f">
    <input type="hidden" id="tipo_folder_f" name="tipo_folder_f">
    <input type="hidden" id="sede_folder_f" name="sede_folder_f">
    <div class="col-lg-12" >
        <table width="100%" class="table table-hover table-bordered table-striped" id="example1" >
            <thead >
                <tr>
                    <th class="text-center">Folder</th>
                    <th class="text-center" width="3%">Sede</th>
                    <th class="text-center" width="3%">Código</th>
                    <th class="text-center">A.&nbsp;Paterno</th>
                    <th class="text-center">A.&nbsp;Materno</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">DNI</th>
                    <th class="text-center" title="Grado/Especialidad">Grado/Espec.</th>
                    <th class="text-center" title="Sección/Grupo">Sec./Grupo</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center help" title="Documento">Doc</th>
                    <th class="text-center help" title="Documento Nacional de Identidad">DNI</th>
                    <th class="text-center help" title="Certificado de Estudios">Cert</th>
                    <th class="text-center help" title="Foto">Foto</th>
                    
                    <th class="text-center" ></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($list_alumno as $list) {?>
                    <tr class="even pointer">
                        <td class="text-center"><?php echo $list['folder']; ?></td>
                        <td class="text-center"><?php echo $list['cod_sede']; ?></td>
                        <td class="text-center"><?php echo $list['codigo']; ?></td>
                        <td><?php echo $list['alum_apater']; ?></td>
                        <td><?php echo $list['alum_amater']; ?></td>
                        <td nowrap><?php echo $list['alum_nom']; ?></td>
                        <td class="text-center"><?php echo $list['dni_alumno']; ?></td>
                        <td><?php echo $list['grado']; ?></td>
                        <td><?php echo $list['seccion']; ?></td>
                        <td nowrap><?php echo $list['estado_arpay']; ?></td>
                        <td class="text-center"><?php echo $list['v_doc']; ?></td>
                        <td class="text-center"><?php echo $list['v_dni']; ?></td>
                        <td class="text-center"><?php echo $list['v_certificadoe']; ?></td>
                        <td class="text-center"><?php echo $list['v_foto']; ?></td>
                        <td ><img title="Validar Documentos" data-toggle="modal" data-target="#modal_small" modal_small="<?= site_url('Administrador/Modal_VDocumento_Alumno') ?>/<?php echo $list["id_alumno"]; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
                        </td>
                    </tr>
                <?php } ?>
            
            </tbody>
        </table>
    </div>
    </form>
</div>


<script>
    $(document).ready(function() {
      $('#example1 thead tr').clone(true).appendTo('#example1 thead');
        $('#example1 thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            if(title==""){
              $(this).html('');
            }else{
              $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
            }

            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#example1').DataTable({
          ordering: false,
          orderCellsTop: true,
          fixedHeader: true,
          pageLength: 100
        });

        var sasignar = document.getElementById('sasignar');
        var todos = document.getElementById('todos');
        var parametro = <?php echo $parametro; ?>;
        if(parametro==1){
            sasignar.style.color = '#000000';
            todos.style.color = '#ffffff';
        }else if(parametro==0){
            sasignar.style.color = '#ffffff';
            todos.style.color = '#000000';
        }
        
    });
</script>