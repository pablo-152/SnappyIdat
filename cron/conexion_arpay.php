<?php
//$serverName = "tcp:84.232.33.232,1433"; //serverName\instanceName
$serverName = "connect.arpay.org.pe,1433"; //serverName\instanceName
$connectionInfo = array( "Database"=>"Intranet", "UID"=>"intranet_fidel", "PWD"=>"NDTBhrU+|\G4", "Encrypt" => 0);
$conexion_arpay = sqlsrv_connect( $serverName, $connectionInfo);

if($conexion_arpay) {
     echo "Conexión establecida.<br />";
}else{
     echo "Conexión no se pudo establecer.<br />";
     die( print_r(sqlsrv_errors(),true));
}
?>