<input type="hidden" id="cadena" name="cadena" value="">
<input type="hidden" id="cantidad" name="cantidad" value="0">
<input type="hidden" id="prueba" name="prueba">
    
<table id="example_alumno" class="table table-hover table-bordered">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="3%"><input type="checkbox" id="total" name="total" value="1"></th>
            <th>Id</th>
            <th class="text-center" width="21%">Apellido Paterno</th>
            <th class="text-center" width="21%">Apellido Materno</th>
            <th class="text-center" width="29%">Nombre</th>
            <th class="text-center" width="10%">Código</th>
            <th class="text-center" width="8%">Matricula</th>
            <th class="text-center" width="8%">Alumno</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_alumno as $list){ ?>
            <tr class="even pointer">
                <td><input type="checkbox" id="array_alumno[]" name="array_alumno[]"></td>
                <td><?php echo $list['Id']; ?></td> 
                <td><?php echo $list['Apellido_Paterno']; ?></td>  
                <td><?php echo $list['Apellido_Materno']; ?></td> 
                <td><?php echo $list['Nombre']; ?></td> 
                <td><?php echo $list['Codigo']; ?></td> 
                <td><?php echo $list['Matricula']; ?></td> 
                <td><span class="badge" <?php if($list['Alumno']=="Retirado"){ echo "style='background-color:#C00000;'"; }else{ echo "style='background-color:#9cd5d1;'"; } ?>><?php echo $list['Alumno']; ?></span></td>                        
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $("#grupos").addClass('active');
        $("#hgrupos").attr('aria-expanded', 'true'); 
        $("#grupos_c").addClass('active');
		document.getElementById("rgrupos").style.display = "block";

        $('#example_alumno thead tr').clone(true).appendTo('#example_alumno thead');
        $('#example_alumno thead tr:eq(1) th').each(function(i) {
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

        var table = $('#example_alumno').DataTable({
            order: [[2,"asc"],[3,"asc"],[4,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 0 ]
                },
                {
                    'targets' : [ 1 ],
                    'visible' : false
                } 
            ]
        });

        // Seleccionar todo en la tabla
        let $dt = $('#example_alumno');
        let $total = $('#total');
        let $cadena = $('#cadena');
        let $cantidad = $('#cantidad');
        let $span_cantidad = $('#span_cantidad');

        // Cuando hacen click en el checkbox del thead
        $dt.on('change', 'thead input', function (evt) {
            var tipo=$('#prueba').val();
            if(tipo==""){
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
                $span_cantidad.html(total);
            }else{
                if (document.getElementById('total').checked){
                    var inp=document.getElementsByTagName('input');
                    for(var i=0, l=inp.length;i<l;i++){
                        if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='array_alumno')
                            inp[i].checked=1;
                    }
                }else{
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
                    $span_cantidad.html(total);
                } 
            }
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
            //total += this.checked ? price : price * -1;
            
            if(this.checked==false){
                q = q.replace(cadena2, "");
                cantidad = parseFloat(cantidad)-1;
            }else{
                q += this.checked ? cadena2 : cadena2+",";
                cantidad = parseFloat(cantidad)+1;
            }
            $cadena.val(q);
            $cantidad.val(cantidad);
            $span_cantidad.html(cantidad);
            //cadena += this.checked ? cadena2 : info[1]+", ";
        });
    });
</script>