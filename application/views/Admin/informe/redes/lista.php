<?php
/*
define('DB_HOST', 'localhost:3306');//DB_HOST:  generalmente suele ser "127.0.0.1"
define('DB_USER', 'sis123temas_snappy');//Usuario de tu base de datos
define('DB_PASS', 'Snappy2021@');//ContraseÃ±a del usuario de la base de datos
define('DB_NAME', 'sis123temas_snappy');//Nombre de la base de datos
*/

define('DB_HOST', 'localhost');//DB_HOST:  generalmente suele ser "127.0.0.1"
define('DB_USER', 'root');//Usuario de tu base de datos
define('DB_PASS', '');//Contraseña del usuario de la base de datos
define('DB_NAME', 'snappy');//Nombre de la base de datos
$con=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!$con){
    die("imposible conectarse1: ".mysqli_error($con));
}
if (@mysqli_connect_errno()) {
    die("Conexión falló: ".mysqli_connect_errno()." : ". mysqli_connect_error());
}


$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$anio=$nom_anio;
$id_empresa=$id_empresa;
$id_mes=$id_mes;

$query_t=mysqli_query($con, "SELECT  COUNT( * ) as total, id_tipo, id_subtipo, nom_tipo , nom_subtipo FROM 
(SELECT s.id_tipo, s.id_subtipo, s.nom_subtipo, t.nom_tipo
FROM subtipo s
LEFT JOIN tipo t ON t.id_tipo = s.id_tipo
where s.rep_redes=1 AND s.id_empresa=$id_empresa and s.id_tipo <> '20'
ORDER BY t.nom_tipo, s.nom_subtipo)
AS tmp_table GROUP BY id_tipo");

$row_t=mysqli_fetch_array($query_t);
$totalRows_t = mysqli_num_rows($query_t);

$dia1 = strtotime($anio.'-'.$id_mes.'-01');
$nom_mes=substr($meses[date('n', $dia1)-1],0,3);
?>

<?php if($totalRows_t>0){ ?>
    <table class="table table-hover table-bordered table-striped" id="example" width="100%">
        <thead>
            <tr>
                <!--<th class="text-center">Tipo</th>-->
                <th class="text-center">Sub-Tipo</th>
                <?php 
                    $fecha_repetidor="01-".$id_mes."-".$anio;
                    $repetidor=date('t',strtotime($fecha_repetidor));
                    $i=1;
                    while($i<=$repetidor){ ?>
                        <th class="text-center" width="2.8%" title="<?php echo $i."-".$nom_mes; ?>" style="cursor:help;"><?php echo $i; ?></th>
                        <?php $i++;
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <!--<td></td>-->
                <td></td>
                <?php 
                    $i=1;
                    while($i<=$repetidor){ 
                        $fecha=str_pad($i,2,"0",STR_PAD_LEFT)."-".$id_mes."-".$anio;
                        $dia=date("l",strtotime($fecha));
                        if($dia=="Monday"){ $nom_dia="L"; }
                        if($dia=="Tuesday"){ $nom_dia="M"; }
                        if($dia=="Wednesday"){ $nom_dia="M"; }
                        if($dia=="Thursday"){ $nom_dia="J"; }
                        if($dia=="Friday"){ $nom_dia="V"; }
                        if($dia=="Saturday"){ $nom_dia="S"; }
                        if($dia=="Sunday"){ $nom_dia="D"; }
                        ?>
                        <td class="text-center"><?php echo $nom_dia; ?></td>
                        <?php $i++;
                    }
                ?>
            </tr>
            <?php 
                if ($totalRows_t<1){
                    echo "No existen registros para mostrar";
                }else{
                    do{ ?>
                        <tr>
                            <!--<td><?php echo utf8_encode($row_t['nom_tipo']); ?></td>-->
                            <td><?php echo utf8_encode($row_t['nom_subtipo']); ?></td>
                            <?php 
                                $i=1;
                                while($i<=$repetidor){ ?>
                                    <td class="text-center"
                                        <?php
                                            $dia1 = strtotime($anio.'-'.$id_mes.'-'.str_pad($i,2,"0",STR_PAD_LEFT));
                                            $dia=$anio.'-'.$id_mes.'-'.str_pad($i,2,"0",STR_PAD_LEFT);
                                            $nom_dia1=$dias[date('w', $dia1)];
                                            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
                                        ?>
                                    >
                                        <?php
                                            $id_subtipop=$row_t['id_subtipo'];
                                            
                                            $query_tp=mysqli_query($con, "SELECT c.snappy_redes FROM 
                                            calendar_redes c left join proyecto pr on pr.cod_proyecto=c.cod_proyecto
                                            WHERE pr.id_empresa=$id_empresa AND c.inicio='$dia' AND 
                                            pr.id_subtipo=$id_subtipop AND pr.status NOT IN (8,9) AND c.estado <>1");
                                            $row_tp=mysqli_fetch_array($query_tp);
                                            $totalRows_tp = mysqli_num_rows($query_tp);

                                            $query_tp1=mysqli_query($con, "SELECT c.snappy_redes FROM 
                                            calendar_redes c left join proyecto pr on pr.cod_proyecto=c.cod_proyecto
                                            WHERE pr.id_empresa=$id_empresa AND c.inicio='$dia' AND 
                                            pr.id_subtipo=$id_subtipop AND pr.status IN (5,6,7) AND c.estado <>1");
                                            $row_tp1=mysqli_fetch_array($query_tp1);
                                            $totalRows_tp1 = mysqli_num_rows($query_tp1);

                                            if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                                        ?>
                                    </td>
                            <?php $i++; } ?>
                        </tr>

                        <?php
                            $total=$row_t['total'];
                            $id_tipo=$row_t['id_tipo'];
                            $id_subtipo=$row_t['id_subtipo'];
                            if ($total>1){
                                $query_e=mysqli_query($con, "SELECT s.id_tipo, s.id_subtipo, s.nom_subtipo
                                FROM subtipo s WHERE s.id_tipo=$id_tipo AND s.id_subtipo NOT IN ($id_subtipo) AND s.id_empresa=$id_empresa AND s.rep_redes=1
                                ORDER BY s.nom_subtipo");
                                $row_e=mysqli_fetch_array($query_e);
                                $totalRows_e = mysqli_num_rows($query_e);

                                do{ ?>
                                    <tr>
                                        <!--<td><?php echo utf8_encode($row_t['nom_tipo']); ?></td>-->
                                        <td><?php echo utf8_encode($row_e['nom_subtipo']); ?></td>
                                        <?php 
                                            $i=1;
                                            while($i<=$repetidor){ ?>
                                                <td class="text-center"
                                                    <?php
                                                        $dia1 = strtotime($anio.'-'.$id_mes.'-'.str_pad($i,2,"0",STR_PAD_LEFT));
                                                        $dia=$anio.'-'.$id_mes.'-'.str_pad($i,2,"0",STR_PAD_LEFT);
                                                        $nom_dia1=$dias[date('w', $dia1)];
                                                        if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
                                                    ?>
                                                >
                                                    <?php
                                                        $id_subtipop=$row_e['id_subtipo'];
                                                        
                                                        $query_tp=mysqli_query($con, "SELECT c.snappy_redes FROM 
                                                        calendar_redes c left join proyecto pr on pr.cod_proyecto=c.cod_proyecto
                                                        WHERE pr.id_empresa=$id_empresa AND c.inicio='$dia' AND 
                                                        pr.id_subtipo=$id_subtipop AND pr.status NOT IN (8,9) AND c.estado <>1");
                                                        $row_tp=mysqli_fetch_array($query_tp);
                                                        $totalRows_tp = mysqli_num_rows($query_tp);

                                                        $query_tp1=mysqli_query($con, "SELECT c.snappy_redes FROM 
                                                        calendar_redes c left join proyecto pr on pr.cod_proyecto=c.cod_proyecto
                                                        WHERE pr.id_empresa=$id_empresa AND c.inicio='$dia' AND 
                                                        pr.id_subtipo=$id_subtipop AND pr.status IN (5,6,7) AND c.estado <>1");
                                                        $row_tp1=mysqli_fetch_array($query_tp1);
                                                        $totalRows_tp1 = mysqli_num_rows($query_tp1);

                                                        if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                                                    ?>
                                                </td>
                                        <?php $i++; } ?>
                                    </tr>
                                <?php  }while($row_e=mysqli_fetch_array($query_e));
                            }
                    }while($row_t=mysqli_fetch_array($query_t));
                }
            ?>
        </tbody>
    </table>
<?php }else{ ?>
    <p style="font-size:15px;">NO HAY REGISTROS</p>
<?php }  ?>

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
            pageLength: 100
        } );
    } );
</script>