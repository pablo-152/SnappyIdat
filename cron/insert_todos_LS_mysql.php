<?php
    include 'conexion.php';

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));  
    }

    $query_t = mysqli_query($conexion, "TRUNCATE TABLE todos_ls"); 

    $query_a = mysqli_query($conexion, "INSERT INTO todos_ls (Id,Apellido_Paterno,Apellido_Materno,Nombre,
                Codigo,Dni,Email,Celular,Fecha_Cumpleanos,Grado,Seccion,Curso,Clase,Anio,Fecha_Matricula,
                Usuario,Matricula,Alumno,Pago_Pendiente,Fecha_Pago_Matricula,Monto_Matricula,
                Fecha_Pago_Cuota_Ingreso,Monto_Cuota_Ingreso) 
                SELECT Id,Apellido_Paterno,Apellido_Materno,Nombre,Codigo,Dni,Email,Celular,
                Fecha_Cumpleanos,Grado,Seccion,Curso,Clase,Anio,Fecha_Matricula,Usuario,Matricula,Alumno,
                Pago_Pendiente,Fecha_Pago_Matricula,Monto_Matricula,Fecha_Pago_Cuota_Ingreso,Monto_Cuota_Ingreso
                FROM todos_ls_temporal");
?>