<table id="example_contrato" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th>Fecha Firma</th>
            <th>Fecha Envío</th>
            <th class="text-center" width="10%">Código</th>
            <th class="text-center" width="6%">Año</th>
            <th class="text-center" width="32%">Documento / Contrato</th>
            <th class="text-center" width="21%">Subido / Firmado Por</th>
            <th class="text-center" width="12%">Fecha Carga / Firma</th> 
            <th class="text-center" width="6%">Vencido</th> 
            <th class="text-center" width="10%">Estado</th>
            <th width="3%"></th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach($list_contrato as $list){ ?>  
            <tr class="even pointer text-center">
                <td><?php echo $list['fecha_firma']; ?></td>  
                <td><?php echo $list['fecha_envio']; ?></td>  
                <td><?php echo $list['referencia']; ?></td>  
                <td><?php echo $list['anio']; ?></td>  
                <td class="text-left"><?php echo $list['descripcion']; ?></td>   
                <td><?php echo $list['Parentesco']; ?></td>  
                <td><?php echo $list['fec_firma']; ?></td> 
                <td><?php echo $list['vencido']; ?></td> 
                <td><span class="badge" style="background:<?php echo $list['color_status'] ?>;"><?php echo $list['nom_status']; ?></span></td>  
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('LeadershipSchool/Modal_Update_Contrato_Matriculados') ?>/<?php echo $list['id_documento_firma']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;">
                    </a>
                </td>   
            </tr>
        <?php } ?>
    </tbody>  
</table>

<script>
    $('#example_contrato thead tr').clone(true).appendTo('#example_contrato thead'); 
    $('#example_contrato thead tr:eq(1) th').each(function(i) { 
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

    var table = $('#example_contrato').DataTable({
        order: [[0,"desc"],[1,"desc"]],
        orderCellsTop: true,
        fixedHeader: true,
        pageLength: 50,
        "aoColumnDefs" : [ 
            {
                'bSortable' : false,
                'aTargets' : [ 9 ] 
            },
            {
                'targets' : [ 0,1 ],
                'visible' : false
            } 
        ]
    });
</script>