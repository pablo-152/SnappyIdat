<?php
$serverName = "198.38.93.144"; //serverName\instanceName
$connectionInfo = array( "Database"=>"vpssoftd_snappy", "UID"=>"vpssoftd_snappy", "PWD"=>"SnapPY2023@#!");
$conexion_vps = sqlsrv_connect( $serverName, $connectionInfo);   

if($conexion_vps) {
     echo "Conexión establecida.<br />"; 
}else{
     echo "Conexión no se pudo establecer.<br />";
     die( print_r(sqlsrv_errors(),true));
}
?>