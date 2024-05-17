<?php
    include 'conexion.php';

    $query_c = mysqli_query($conexion,"SELECT Id,Matricula,Alumno 
                FROM todos_l20 
                WHERE Tipo=1 
                ORDER BY Apellido_Paterno ASC,Apellido_Materno ASC,Nombre ASC");

    while($fila = mysqli_fetch_assoc($query_c)) { 
        $query_a = mysqli_query($conexion, "SELECT id FROM alumno_grupo 
                        WHERE id_alumno='".$fila['Id']."'");
        $get_id = mysqli_fetch_assoc($query_a);
        $total_a = mysqli_num_rows($query_a); 

        if($total_a>0){
            mysqli_query($conexion, "UPDATE alumno_grupo SET matricula='".$fila['Matricula']."',
            alumno='".$fila['Alumno']."'
            WHERE id='".$get_id['id']."'");
        }
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }
?>