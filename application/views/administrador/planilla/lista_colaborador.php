<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <!--<th class="text-center" width="8%">Ap. Paterno</th>
            <th class="text-center" width="8%">Ap. Materno</th> 
            <th class="text-center" width="10%">Nombre(s)</th>
            <th class="text-center" width="5%">Código</th>
            <th class="text-center" width="5%">Contrato</th>
            <th class="text-center" width="5%">Cargo</th> 
            <th class="text-center" width="5%">Sueldo Bruto</th>
            <th class="text-center" width="5%">Planilla</th>
            <th class="text-center" width="5%">Incentivos</th>
            <th class="text-center" width="5%">Deducciones</th> 
            <th class="text-center" width="5%">Faltas</th>
            <th class="text-center" width="5%">ONP</th>
            <th class="text-center" width="5%">AFP Profuturo</th>
            <th class="text-center" width="5%">Prima Seguro</th> 
            <th class="text-center" width="5%">Comisión AFP</th>
            <th class="text-center" width="5%">ESSALUD</th>
            <th class="text-center" width="5%">Líquido a Recibir</th>
            <th class="text-center" width="4%"></th>-->
            <th class="text-center" nowrap>Ap. Paterno</th>
            <th class="text-center" nowrap>Ap. Materno</th> 
            <th class="text-center" nowrap>Nombre(s)</th>
            <th class="text-center" nowrap>Código</th>
            <th class="text-center" nowrap>Contrato</th>
            <th class="text-center" nowrap>Cargo</th> 
            <th class="text-center" nowrap>Sueldo Bruto</th>
            <th class="text-center" nowrap>Planilla</th>
            <th class="text-center" nowrap>Incentivos</th>
            <th class="text-center" nowrap>Deducciones</th> 
            <th class="text-center" nowrap>Faltas</th>
            <th class="text-center" nowrap>ONP</th>
            <th class="text-center" nowrap>AFP Profuturo</th>
            <th class="text-center" nowrap>Prima Seguro</th> 
            <th class="text-center" nowrap>Comisión AFP</th>
            <th class="text-center" nowrap>ESSALUD</th>
            <th class="text-center" nowrap>Líquido a Recibir</th>
            <th class="text-center" nowrap></th>
        </tr>
    </thead> 

    <tbody>
        <?php foreach($list_colaborador as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td nowrap class="text-left"><?= $list['apellido_paterno']; ?></td>
                <td nowrap class="text-left"><?= $list['apellido_materno']; ?></td>
                <td nowrap class="text-left"><?= $list['nombres']; ?></td>
                <td nowrap><?= $list['codigo_gll']; ?></td>
                <td nowrap class="text-left"><?= $list['nom_contrato']; ?></td>
                <td nowrap><?= $list['nom_perfil']; ?></td>
                <td nowrap class="text-right"><?= $list['sueldo_bruto']; ?></td>
                <td nowrap class="text-right"><?= $list['planilla']; ?></td>
                <td nowrap class="text-right"><?= $list['incentivo']; ?></td>
                <td nowrap class="text-right"><?= $list['deduccion']; ?></td>
                <td nowrap class="text-right"><?= $list['falta']; ?></td>
                <td nowrap class="text-right"><?= $list['onp']; ?></td>
                <td nowrap class="text-right"><?= $list['afp_aporte']; ?></td>
                <td nowrap class="text-right"><?= $list['prima_seguro']; ?></td>
                <td nowrap class="text-right"><?= $list['afp_comision']; ?></td>
                <td nowrap class="text-right"><?= $list['essalud']; ?></td>
                <td nowrap class="text-right"><?= $list['liquido_pagar']; ?></td>
                <td nowrap>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Modal_Colaborador_Planilla') ?>/<?= $list['id_contrato']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>
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
                $(this).html('<input type="text" placeholder="Buscar '+title+'" />');
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
            order: [[0,"asc"],[1,"asc"],[2,"asc"],[3,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 17 ]
                }
            ]
        } );
    });
</script>