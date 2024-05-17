<table id="example" class="table table-hover table-striped table-bordered" >
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="5%" title="Empresa">Ref</th>
            <th class="text-center" width="5%" title="Empresa">Emp.</th>
            <th class="text-center" width="5%">Sede</th>
            <th class="text-center" width="18%">Nombre</th> 
            <th class="text-center" width="18%" title="Nombre (Documento)">Nombre (Doc.)</th> 
            <th class="text-center" width="34%">Link</th>
            <th class="text-center" width="5%">Archivo</th>
            <th class="text-center" width="5%">Estado</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_documento_pdf as $list){ ?>                                            
            <tr class="even pointer text-center">
                <td><?php echo $list['referencia']; ?></td>
                <td><?php echo $list['cod_empresa']; ?></td>
                <td><?php echo $list['cod_sede']; ?></td>
                <td class="text-left"><?php echo $list['nombre_documento_pdf']; ?></td>
                <td class="text-left"><?php echo $list['documento']; ?></td>
                <td class="text-left"><a href="<?php echo $list['link_documento_pdf']; ?>" target="_blank"><?php echo $list['link_documento_pdf']; ?></a></td>
                <td><?php echo $list['archivo']; ?></td>
                <td>
                    <span class="badge" style="background:<?php echo $list['color']; ?>;color: white;"><?php echo $list['nom_status']; ?></span>
                </td>
                <td>
                    <input type="hidden" value="<?php echo $list['id_documento_pdf']; ?>" id="id_documento_pdf" name="id_documento_pdf">
                    <input type="hidden" value="<?php echo $list['documento']; ?>" id="documento" name="documento">
                 
                    <img  title="Editar Datos Documentos PDF" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('Administrador/Modal_Update_Documentos_PDF') ?>/<?php echo $list['id_documento_pdf']; ?>" 
                    src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;">
                   
                    <img  title="Eliminar" onclick="Delete_Codigo('<?php echo $list['id_documento_pdf']; ?>','<?php echo $list['documento']; ?>')" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"/>
                
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function(i) {
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

        var table = $('#example').DataTable({
            order: [[7,"asc"],[1,"asc"],[2,"asc"],[3,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 8 ]
                }
            ]
        });
    });

    function Delete_Codigo(id,documento){
        var id = id;
        var documento = documento;
        //alert(id);
        var url="<?php echo site_url(); ?>Administrador/Delete_Codigo";
        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type:"POST",
                    url:url,
                    data: {'id_documento_pdf':id,'documento':documento},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>Administrador/Documentos_PDF";
                        });
                    }
                });
            }
        })
    }
</script>