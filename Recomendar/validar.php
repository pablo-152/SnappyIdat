<?php
	require_once ("config/db.php");
    require_once ("config/conexion.php")
?>

<?php
	$otro_1=$_POST['otro_1'];

	$sql1 = mysqli_query($con, "SELECT * FROM matriculados_l14 WHERE Dni='$otro_1'");
    $total1 = mysqli_num_rows($sql1);

    $sql2 = mysqli_query($con, "SELECT * FROM matriculados_l20 WHERE Dni='$otro_1'");
    $total2 = mysqli_num_rows($sql2);

	if(($total1+$total2)>0){
        echo "existe";
    }else{
        echo "no-existe";
    }
?>