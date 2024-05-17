<style>
    #example tbody tr td:nth-child(1),#example tbody tr td:nth-child(2),#example tbody tr td:nth-child(3),#example tbody tr td:nth-child(4),
    #example tbody tr td:nth-child(7){ 
        text-align: center;
    }
</style>

<input type="hidden" id="cadena" name="cadena" value=""> 
<input type="hidden" id="cantidad" name="cantidad" value="0">

<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <table id="example" class="table table-hover table-striped table-bordered" width="100%">
        <thead>
            <tr style="background-color: #E5E5E5;">
                <th class="text-center" width="3%"><input type="checkbox" id="total" name="total" value="1"></th>
                <th>Id</th>
                <th class="text-center" width="4%" title="Referencia">Ref</th>
                <th class="text-center" width="5%">Tipo</th>
                <th class="text-center" width="5%" title="Fecha Contacto">Fec&nbsp;Cont</th>
                <th class="text-center" width="26%" title="Nombres y Apellidos">Nom&nbsp;y&nbsp;Ape</th>
                <th class="text-center" width="9%">Acción</th>
                <th class="text-center" width="3%" title="Empresa">Emp</th>
                <th class="text-center" width="36%">Mensaje</th>
                <th class="text-center" width="9%">Status</th>
                <th>Orden</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list_registro as $list) {  ?>
                <tr class="even pointer">
                    <td><input type="checkbox"></td>
                    <td><?php echo $list['id_registro']; ?></td>
                    <td><?php echo $list['cod_registro']; ?></td>
                    <td><?php echo $list['nom_informe']; ?></td>
                    <td><?php echo $list['fec_inicial']; ?></td>
                    <td><?php echo substr($list['nombres_apellidos'], 0, 30); ?></td>
                    <td><?php echo $list['nom_accion']; ?></td>
                    <td><?php echo $list['cod_empresa']; ?></td>
                    <td><?php echo substr($list['mensaje'], 0, 75); ?></td>
                    <td><?php echo $list['nom_status']; ?></td>
                    <td><?php echo $list['fecha_inicial']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</form>

<script>
    $(document).ready(function() {
        $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            if (title == "") {
                $(this).html('');
            } else {
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
            order: [
                [10, "desc"]
            ],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [0]
                },
                {
                    'targets': [1, 10],
                    'visible': false
                }
            ]
        });

        // Seleccionar todo en la tabla
        let $dt = $('#example');
        let $total = $('#total');
        let $cadena = $('#cadena');
        let $cantidad = $('#cantidad');

        // Cuando hacen click en el checkbox del thead
        $dt.on('change', 'thead input', function (evt) {
            let checked = this.checked;
            let total = 0;
            let data = [];
            let cadena='';
            
            table.data().each(function (info) {
            var txt = info[0];
                if (checked) {
                    total += 1;
                    txt = txt.substr(0, txt.length - 1) + ' checked>';
                    cadena += info[1]+",";
                } else {
                    txt = txt.replace(' checked', '');
                }
                info[0] = txt;
                data.push(info);
            });
            
            table.clear().rows.add(data).draw();
            $cantidad.val(total);
            $cadena.val(cadena);
        });

        // Cuando hacen click en los checkbox del tbody
        $dt.on('change', 'tbody input', function() {
            let q= $('#cadena').val();
            let cantidad= $('#cantidad').val();
            let info = table.row($(this).closest('tr')).data();
            let total = parseFloat($total.val());
            let cadena = $cadena.val();
            let price = parseFloat(info[1]);
            let cadena2 = info[1]+",";
            
            if(this.checked==false){
                q = q.replace(cadena2, "");
                cantidad = parseFloat(cantidad)-1;
            }else{
                q += this.checked ? cadena2 : cadena2+",";
                cantidad = parseFloat(cantidad)+1;
            }
            $cadena.val(q);
            $cantidad.val(cantidad);
        });
    });
</script>