<?php
/*
define('DB_HOST', 'localhost');//DB_HOST:  generalmente suele ser "127.0.0.1"
define('DB_USER', 'root');//Usuario de tu base de datos
define('DB_PASS', '');//Contraseña del usuario de la base de datos
define('DB_NAME', 'snappy');//Nombre de la base de datos
*/

define('DB_HOST', 'snappytest.db.9383827.dff.hostedresource.net');//DB_HOST:  generalmente suele ser "127.0.0.1"
define('DB_USER', 'snappytest');//Usuario de tu base de datos
define('DB_PASS', 'Snappy1@!');//Contraseña del usuario de la base de datos
define('DB_NAME', 'snappytest');//Nombre de la base de datos
$con=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!$con){
    die("imposible conectarse1: ".mysqli_error($con));
}
if (@mysqli_connect_errno()) {
    die("Conexión falló: ".mysqli_connect_errno()." : ". mysqli_connect_error());
}


$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$anio=date('Y');
$id_empresa=$id_empresa."1";
$id_mes=$id_mes;

$query_t=mysqli_query($con, "SELECT  COUNT( * ) as total, id_tipo, id_subtipo, nom_tipo , nom_subtipo FROM 
(SELECT s.id_tipo, s.id_subtipo, s.nom_subtipo, t.nom_tipo
FROM subtipo s
LEFT JOIN tipo t ON t.id_tipo = s.id_tipo
where s.rep_redes=1
ORDER BY t.nom_tipo, s.nom_subtipo)
AS tmp_table GROUP BY id_tipo");
$row_t=mysqli_fetch_array($query_t);
$totalRows_t = mysqli_num_rows($query_t);

$dia1 = strtotime($anio.'-'.$id_mes.'-01');
$nom_mes=substr($meses[date('n', $dia1)-1],0,3);
?>

<table width="100%" border="1" align="center" cellpadding="1" cellspacing="1">
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "1-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "2-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "3-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "4-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "5-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "6-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "7-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "8-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "9-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "10-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "11-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "12-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "13-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "14-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "15-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "16-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "17-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "18-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "19-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "20-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "21-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "22-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "23-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "24-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "25-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "26-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "27-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "28-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "29-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "30-".$nom_mes;
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 12px">
                <?php 
                    echo "31-".$nom_mes;
                ?>
            </div>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia1 = strtotime($anio.'-'.$id_mes.'-01');
                    $nom_dia1=$dias[date('w', $dia1)];
                    echo substr($nom_dia1, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia2 = strtotime($anio.'-'.$id_mes.'-02');
                    $nom_dia2=$dias[date('w', $dia2)];
                    echo substr($nom_dia2, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia3 = strtotime($anio.'-'.$id_mes.'-03');
                    $nom_dia3=$dias[date('w', $dia3)];
                    echo substr($nom_dia3, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia4 = strtotime($anio.'-'.$id_mes.'-04');
                    $nom_dia4=$dias[date('w', $dia4)];
                    echo substr($nom_dia4, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia5 = strtotime($anio.'-'.$id_mes.'-05');
                    $nom_dia5=$dias[date('w', $dia5)];
                    echo substr($nom_dia5, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia6 = strtotime($anio.'-'.$id_mes.'-06');
                    $nom_dia6=$dias[date('w', $dia6)];
                    echo substr($nom_dia6, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia7 = strtotime($anio.'-'.$id_mes.'-07');
                    $nom_dia7=$dias[date('w', $dia7)];
                    echo substr($nom_dia7, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia8 = strtotime($anio.'-'.$id_mes.'-08');
                    $nom_dia8=$dias[date('w', $dia8)];
                    echo substr($nom_dia8, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia9 = strtotime($anio.'-'.$id_mes.'-09');
                    $nom_dia9=$dias[date('w', $dia9)];
                    echo substr($nom_dia9, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia10 = strtotime($anio.'-'.$id_mes.'-10');
                    $nom_dia10=$dias[date('w', $dia10)];
                    echo substr($nom_dia10, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia11 = strtotime($anio.'-'.$id_mes.'-11');
                    $nom_dia11=$dias[date('w', $dia11)];
                    echo substr($nom_dia11, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia12 = strtotime($anio.'-'.$id_mes.'-12');
                    $nom_dia12=$dias[date('w', $dia12)];
                    echo substr($nom_dia12, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia13 = strtotime($anio.'-'.$id_mes.'-13');
                    $nom_dia13=$dias[date('w', $dia13)];
                    echo substr($nom_dia13, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia14 = strtotime($anio.'-'.$id_mes.'-14');
                    $nom_dia14=$dias[date('w', $dia14)];
                    echo substr($nom_dia14, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia15 = strtotime($anio.'-'.$id_mes.'-15');
                    $nom_dia15=$dias[date('w', $dia15)];
                    echo substr($nom_dia15, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia16 = strtotime($anio.'-'.$id_mes.'-16');
                    $nom_dia16=$dias[date('w', $dia16)];
                    echo substr($nom_dia16, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia17 = strtotime($anio.'-'.$id_mes.'-17');
                    $nom_dia17=$dias[date('w', $dia17)];
                    echo substr($nom_dia17, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia18 = strtotime($anio.'-'.$id_mes.'-18');
                    $nom_dia18=$dias[date('w', $dia18)];
                    echo substr($nom_dia18, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia19 = strtotime($anio.'-'.$id_mes.'-19');
                    $nom_dia19=$dias[date('w', $dia19)];
                    echo substr($nom_dia19, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia20 = strtotime($anio.'-'.$id_mes.'-20');
                    $nom_dia20=$dias[date('w', $dia20)];
                    echo substr($nom_dia20, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia21 = strtotime($anio.'-'.$id_mes.'-21');
                    $nom_dia21=$dias[date('w', $dia21)];
                    echo substr($nom_dia21, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia22 = strtotime($anio.'-'.$id_mes.'-22');
                    $nom_dia22=$dias[date('w', $dia22)];
                    echo substr($nom_dia19, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia23 = strtotime($anio.'-'.$id_mes.'-23');
                    $nom_dia23=$dias[date('w', $dia23)];
                    echo substr($nom_dia23, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia24 = strtotime($anio.'-'.$id_mes.'-24');
                    $nom_dia24=$dias[date('w', $dia24)];
                    echo substr($nom_dia24, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia25 = strtotime($anio.'-'.$id_mes.'-25');
                    $nom_dia25=$dias[date('w', $dia25)];
                    echo substr($nom_dia25, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia26 = strtotime($anio.'-'.$id_mes.'-26');
                    $nom_dia26=$dias[date('w', $dia26)];
                    echo substr($nom_dia26, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia27 = strtotime($anio.'-'.$id_mes.'-27');
                    $nom_dia27=$dias[date('w', $dia27)];
                    echo substr($nom_dia27, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia28 = strtotime($anio.'-'.$id_mes.'-28');
                    $nom_dia28=$dias[date('w', $dia28)];
                    echo substr($nom_dia28, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia29 = strtotime($anio.'-'.$id_mes.'-29');
                    $nom_dia29=$dias[date('w', $dia29)];
                    echo substr($nom_dia29, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia30 = strtotime($anio.'-'.$id_mes.'-30');
                    $nom_dia30=$dias[date('w', $dia30)];
                    echo substr($nom_dia30, 0, 1);
                ?>
            </div>
        </td>
        <td>
            <div align="center" style="font-size: 11px">
                <?php 
                    $dia31 = strtotime($anio.'-'.$id_mes.'-31');
                    $nom_dia31=$dias[date('w', $dia31)];
                    echo substr($nom_dia31, 0, 1);
                ?>
            </div>
        </td>
    </tr>
    <?php if ($totalRows_t<1) 
    {echo "No existen registros para mostrar";}
    else{
        do{
    ?>
    
    <tr>
        <td rowspan="<?php echo $row_t['total']; ?>"><?php echo $row_t['nom_tipo']; ?></td>
        <td><?php echo $row_t['nom_subtipo']; ?></td>
        <td
        <?php
            $dia1 = strtotime($anio.'-'.$id_mes.'-01');
            $dia=$anio.'-'.$id_mes.'-01';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    /*echo "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop";*/
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-02');
            $dia=$anio.'-'.$id_mes.'-02';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-03');
            $dia=$anio.'-'.$id_mes.'-03';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-04');
            $dia=$anio.'-'.$id_mes.'-04';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-05');
            $dia=$anio.'-'.$id_mes.'-05';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-06');
            $dia=$anio.'-'.$id_mes.'-06';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-07');
            $dia=$anio.'-'.$id_mes.'-07';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-08');
            $dia=$anio.'-'.$id_mes.'-08';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-09');
            $dia=$anio.'-'.$id_mes.'-09';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-10');
            $dia=$anio.'-'.$id_mes.'-10';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-11');
            $dia=$anio.'-'.$id_mes.'-11';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-12');
            $dia=$anio.'-'.$id_mes.'-12';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-13');
            $dia=$anio.'-'.$id_mes.'-13';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-14');
            $dia=$anio.'-'.$id_mes.'-14';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-15');
            $dia=$anio.'-'.$id_mes.'-15';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-16');
            $dia=$anio.'-'.$id_mes.'-16';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-17');
            $dia=$anio.'-'.$id_mes.'-17';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-18');
            $dia=$anio.'-'.$id_mes.'-18';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-19');
            $dia=$anio.'-'.$id_mes.'-19';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-20');
            $dia=$anio.'-'.$id_mes.'-20';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-21');
            $dia=$anio.'-'.$id_mes.'-21';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-22');
            $dia=$anio.'-'.$id_mes.'-22';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-23');
            $dia=$anio.'-'.$id_mes.'-23';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-24');
            $dia=$anio.'-'.$id_mes.'-24';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-25');
            $dia=$anio.'-'.$id_mes.'-25';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-26');
            $dia=$anio.'-'.$id_mes.'-26';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-27');
            $dia=$anio.'-'.$id_mes.'-27';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-28');
            $dia=$anio.'-'.$id_mes.'-28';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-29');
            $dia=$anio.'-'.$id_mes.'-29';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-30');
            $dia=$anio.'-'.$id_mes.'-30';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-31');
            $dia=$anio.'-'.$id_mes.'-31';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_t['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
    </tr>
    <?php
            $total=$row_t['total'];
            $id_tipo=$row_t['id_tipo'];
            $id_subtipo=$row_t['id_subtipo'];
            if ($total>1)
            {
            $query_e=mysqli_query($con, "SELECT s.id_tipo, s.id_subtipo, s.nom_subtipo
            FROM subtipo s where s.id_tipo=$id_tipo and id_subtipo not in ($id_subtipo) and rep_redes=1
            ORDER BY s.nom_subtipo");
            $row_e=mysqli_fetch_array($query_e);
            $totalRows_e = mysqli_num_rows($query_e);
            do{
    ?>
    <tr>
        <td><?php echo $row_e['nom_subtipo']; ?></td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-01');
            $dia = $anio.'-'.$id_mes.'-01';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-02');
            $dia = $anio.'-'.$id_mes.'-02';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-03');
            $dia = $anio.'-'.$id_mes.'-03';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-04');
            $dia = $anio.'-'.$id_mes.'-04';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-05');
            $dia = $anio.'-'.$id_mes.'-05';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-06');
            $dia = $anio.'-'.$id_mes.'-06';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-07');
            $dia = $anio.'-'.$id_mes.'-07';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-08');
            $dia = $anio.'-'.$id_mes.'-08';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-09');
            $dia = $anio.'-'.$id_mes.'-09';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-10');
            $dia = $anio.'-'.$id_mes.'-10';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-11');
            $dia = $anio.'-'.$id_mes.'-11';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-12');
            $dia = $anio.'-'.$id_mes.'-12';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-13');
            $dia = $anio.'-'.$id_mes.'-13';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-14');
            $dia = $anio.'-'.$id_mes.'-14';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-15');
            $dia = $anio.'-'.$id_mes.'-15';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-16');
            $dia = $anio.'-'.$id_mes.'-16';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-17');
            $dia = $anio.'-'.$id_mes.'-17';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-18');
            $dia = $anio.'-'.$id_mes.'-18';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-19');
            $dia = $anio.'-'.$id_mes.'-19';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-20');
            $dia = $anio.'-'.$id_mes.'-20';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-21');
            $dia = $anio.'-'.$id_mes.'-21';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-22');
            $dia = $anio.'-'.$id_mes.'-22';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-23');
            $dia = $anio.'-'.$id_mes.'-23';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-24');
            $dia = $anio.'-'.$id_mes.'-24';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-25');
            $dia = $anio.'-'.$id_mes.'-25';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-26');
            $dia = $anio.'-'.$id_mes.'-26';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-27');
            $dia = $anio.'-'.$id_mes.'-27';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-28');
            $dia = $anio.'-'.$id_mes.'-28';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-29');
            $dia = $anio.'-'.$id_mes.'-29';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-30');
            $dia = $anio.'-'.$id_mes.'-30';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
        <td
        <?php 
            $dia1 = strtotime($anio.'-'.$id_mes.'-31');
            $dia = $anio.'-'.$id_mes.'-31';
            $nom_dia1=$dias[date('w', $dia1)];
            if(substr($nom_dia1, 0, 1)=="D") { echo "style='background-color: #C8C8C8;'"; } ;
        ?>
        >
            <div align="center">
                <?php
                    $id_subtipop=$row_e['id_subtipo'];
                    $query_tp=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and id_subtipo=$id_subtipop");
                    $row_tp=mysqli_fetch_array($query_tp);
                    $totalRows_tp = mysqli_num_rows($query_tp);

                    $query_tp1=mysqli_query($con, "SELECT s_redes FROM proyecto
                    where $id_empresa=1 and fec_agenda='$dia' and subido=1 and id_subtipo=$id_subtipop");
                    $row_tp1=mysqli_fetch_array($query_tp1);
                    $totalRows_tp1 = mysqli_num_rows($query_tp1);
                    if($totalRows_tp>0) echo $totalRows_tp1." | ".$totalRows_tp;
                ?>
            </div>
        </td>
    </tr>
    <?php
    
        /**/} while (
        $row_e=mysqli_fetch_array($query_e));
        }
    } while (
        $row_t=mysqli_fetch_array($query_t));
    
    }
    ?>
</table>