<?php
$hostname = 'localhost';
$database = 'vpssoftd_ifv_examen';
$username = 'root';
$password = '';

$conexion_vps_examen = new mysqli($hostname,$username,$password,$database); 
if($conexion_vps_examen->connect_errno){
    echo "lo sentimos, el sitio web esta experimentando problemas";
}

?>