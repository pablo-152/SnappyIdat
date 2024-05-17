<style>
    /*#tabla_estilo tbody tr{
        height: 35px;
        vertical-align: middle;
    }

    #tabla_estilo tbody tr td{
        vertical-align: middle;
    }*/
</style>
<!--id="tabla_estilo" width="100%" border="1" align="center" cellpadding="1" cellspacing="1"-->
<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr>
            <th width="11%" class="text-center">Rubro</th>
            <th width="11%" class="text-center">Subrubro</th>
            <th width="6%" class="text-center">Enero</th>
            <th width="6%" class="text-center">Febrero</th>
            <th width="6%" class="text-center">Marzo</th>
            <th width="6%" class="text-center">Abril</th>
            <th width="6%" class="text-center">Mayo</th>
            <th width="6%" class="text-center">Junio</th>
            <th width="6%" class="text-center">Julio</th>
            <th width="6%" class="text-center">Agosto</th>
            <th width="6%" class="text-center">Septiembre</th>
            <th width="6%" class="text-center">Octubre</th>
            <th width="6%" class="text-center">Noviembre</th>
            <th width="6%" class="text-center">Diciembre</th>
            <th width="6%" class="text-center">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_informe as $list){ ?>
            <tr class="text-right">
                <td class="text-left" style="background:#b7afb8;"><?php echo $list['Rubro']; ?></td>
                <td class="text-left" style="background:#e9e6e9;"><?php echo $list['Subrubro']; ?></td>
                <td <?php if($list['Enero']==0){ ?> style="background:#ffe1e2;" <?php } ?>>
                    <?php echo "S/ ".number_format($list['Enero'],2); ?>
                </td>
                <td <?php if($list['Febrero']==0){ ?> style="background:#ffe1e2;" <?php } ?>>
                    <?php echo "S/ ".number_format($list['Febrero'],2); ?>
                </td>
                <td <?php if($list['Marzo']==0){ ?> style="background:#ffe1e2;" <?php } ?>>
                    <?php echo "S/ ".number_format($list['Marzo'],2); ?>
                </td>
                <td <?php if($list['Abril']==0){ ?> style="background:#ffe1e2;" <?php } ?>>
                    <?php echo "S/ ".number_format($list['Abril'],2); ?>
                </td>
                <td <?php if($list['Mayo']==0){ ?> style="background:#ffe1e2;" <?php } ?>>
                    <?php echo "S/ ".number_format($list['Mayo'],2); ?>
                </td>
                <td <?php if($list['Junio']==0){ ?> style="background:#ffe1e2;" <?php } ?>>
                    <?php echo "S/ ".number_format($list['Junio'],2); ?>
                </td>
                <td <?php if($list['Julio']==0){ ?> style="background:#ffe1e2;" <?php } ?>>
                    <?php echo "S/ ".number_format($list['Julio'],2); ?>
                </td>
                <td <?php if($list['Agosto']==0){ ?> style="background:#ffe1e2;" <?php } ?>>
                    <?php echo "S/ ".number_format($list['Agosto'],2); ?>
                </td>
                <td <?php if($list['Septiembre']==0){ ?> style="background:#ffe1e2;" <?php } ?>>
                    <?php echo "S/ ".number_format($list['Septiembre'],2); ?>
                </td>
                <td <?php if($list['Octubre']==0){ ?> style="background:#ffe1e2;" <?php } ?>>
                    <?php echo "S/ ".number_format($list['Octubre'],2); ?>
                </td>
                <td <?php if($list['Noviembre']==0){ ?> style="background:#ffe1e2;" <?php } ?>>
                    <?php echo "S/ ".number_format($list['Noviembre'],2); ?>
                </td>
                <td <?php if($list['Diciembre']==0){ ?> style="background:#ffe1e2;" <?php } ?>>
                    <?php echo "S/ ".number_format($list['Diciembre'],2); ?>
                </td>
                <td style="background:#b7afb8;"><?php echo "S/ ".number_format($list['Total'],2); ?></td>
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
                $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
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
            ordering: false,
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25
        } );
    } );
</script>