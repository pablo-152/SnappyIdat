<?php

include 'conexion.php';
//$nomb_estaci=$_POST['nomb_estaci'];
//$dist_estaci=$_POST['dist_estaci'];
//$direc_estaci=$_POST['direc_estaci'];

$consulta="UPDATE pago SET terminado=1 WHERE fec_fin_modulo < DATE_sub(NOW(), INTERVAL 1 HOUR) and fec_fin_modulo <> '0000-00-00 00:00:00' and terminado=0 and id_prod_final <> 8";
mysqli_query($conexion,$consulta) or die (myqli_error());
mysqli_close($conexion);

?>