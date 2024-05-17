<?php
    include 'conexion.php';
    include 'conexion_vps.php';

    $query_p = mysqli_query($conexion,"SELECT em.id_colaborador, em.dni, em.correo_corporativo,
                em.apellido_paterno, em.apellido_materno, em.nombres, em.codigo_gll
                FROM colaborador em
                WHERE em.id_empresa IN (1,2,3,4) AND em.estado=2 AND
                (em.fin_funciones IS NULL or em.fin_funciones='0000-00-00')
                ORDER BY em.apellido_paterno ASC,em.apellido_materno ASC,em.nombres ASC");
    
    while( $fila_p = mysqli_fetch_assoc( $query_p) ) { 
        $codigoa=$fila_p['codigo_gll']."'C"; 
        $query_ap = mysqli_query($conexion, "INSERT INTO matriculados_ls (Tipo,Id,Dni,Email,Apellido_Paterno,Apellido_Materno,Nombre,
                    Codigo, Codigoa, fec_reg) 
                    VALUES (2,'".$fila_p['id_colaborador']."','".$fila_p['dni']."',
                    '".$fila_p['correo_corporativo']."','".$fila_p['apellido_paterno']."',
                    '".$fila_p['apellido_materno']."','".$fila_p['nombres']."',
                    '".$fila_p['codigo_gll']."', '".addslashes($codigoa)."',NOW())");
        
        $codigoa=$fila_p['codigo_gll']."''C"; 
        $query_ap2 = sqlsrv_query($conexion_vps, "INSERT INTO matriculados_ls (Tipo,Id,Dni,Email,
                    Apellido_Paterno,Apellido_Materno,Nombre, Codigo, Codigoa,fec_reg) 
                    VALUES (2,'".$fila_p['id_colaborador']."','".$fila_p['dni']."',
                    '".$fila_p['correo_corporativo']."','".$fila_p['apellido_paterno']."',
                    '".$fila_p['apellido_materno']."','".$fila_p['nombres']."',
                    '".$fila_p['codigo_gll']."','".$codigoa."', getdate())");
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion)); 
    }

?>