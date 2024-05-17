<?php
$serverName = "connect.arpay.org.pe,1433";
$connectionInfo = array( "Database"=>"Snappy", "UID"=>"intranet_fidel", "PWD"=>"NDTBhrU+|\G4", "Encrypt" => 0);
$conexion_arpay = sqlsrv_connect( $serverName, $connectionInfo);

if($conexion_arpay) {
    echo "Conexión establecida.<br />";
}else{
    echo "Conexión no se pudo establecer.<br />";
    die( print_r(sqlsrv_errors(),true));
}
?>