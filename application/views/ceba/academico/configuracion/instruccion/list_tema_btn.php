<form  method="post" id="formularioxls" enctype="multipart/form-data" action="<?= site_url('Ceba/Excel_Instruccion')?>" class="formulario">
    <input type="hidden" name="parametro" id="parametro" value="<?php echo $parametro?> "> 
</form>

<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="10%">Grado</th>
            <th class="text-center" width="8%">Módulo</th>
            <th class="text-center" width="20%">Tema</th>
            <th class="text-center" width="32%">Descripción</th>
            <th class="text-center" width="8%" title="Creado Por">Cre. Por</th>
            <th class="text-center" width="8%" title="Fecha Creación">Fec. Cre.</th>
            <th class="text-center" width="8%">Estado</th>
            <th class="text-center" width="6%"></th>
        </tr>
    </thead>

    <tbody >
        <?php foreach ($list_instruccion as $list) {  ?>
            <tr class="even pointer">
                <td nowrap ><?php echo $list['descripcion_grado']; ?></td>
                <td class="text-center" nowrap ><?php echo $list['nom_unidad']; ?></td>
                <td class="text-center" nowrap ><?php echo $list['referencia']; ?></td>
                <td nowrap ><?php echo substr($list['regla'], 0, 30); ?></td>
                <td class="text-center" nowrap ><?php echo $list['usuario_codigo']; ?></td>
                <td class="text-center" nowrap ><?php echo $list['fecha_registro']; ?></td>
                <td class="text-center" nowrap ><?php echo $list['nom_status']; ?></td>
                <td class="text-center" nowrap >
                    <img title="Editar Instruccion" data-toggle="modal" data-dismiss="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Ceba/Modal_Update_Instruccion') ?>/<?php echo $list["id_instruccion"]; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;width:22px;height:22px;" />
                    <a style="cursor:pointer;" class="" data-toggle="modal" data-target="#slide" data-imagen="<?php echo $list['imagen'] ?>" title="Ver Imagen"> <img title="Imagen 1" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;" width="22" height="22" /></a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            
            if(title==""){
                $(this).html('');
            }else{
                $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
            }
    
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        var table = $('#example').DataTable( {
            ordering:false,
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25
        } );

    } );
</script>