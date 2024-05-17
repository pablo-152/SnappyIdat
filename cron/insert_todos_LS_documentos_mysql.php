<?php
    include 'conexion.php';
    include 'conexion_vps.php';

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));  
    }

    $query_m = mysqli_query($conexion, "SELECT * FROM todos_ls");
    $total_m = mysqli_num_rows($query_m);
    
    $query_t = mysqli_query($conexion, "SELECT * FROM todos_ls_temporal");
    $total_t = mysqli_num_rows($query_t);

    if($total_t>$total_m){
        $query_c = mysqli_query($conexion, "SELECT Id,Fecha_Cumpleanos FROM todos_ls_temporal 
                    WHERE Id NOT IN (SELECT Id FROM todos_ls)"); 

        while ($fila = mysqli_fetch_assoc($query_c)) { 
            if($fila['Fecha_Cumpleanos']==""){
                $edad = 17;
            }else{
                $fec_de = new DateTime($fila['Fecha_Cumpleanos']);
                $fec_hasta = new DateTime(date('Y-m-d'));
                $diff = $fec_de->diff($fec_hasta);  
                $edad = $diff->y;
            }

            $query_d = mysqli_query($conexion, "SELECT id_documento,obligatorio FROM documento_alumno_empresa 
                        WHERE id_empresa=4 AND estado=2"); 
            
            while ($documento = mysqli_fetch_assoc($query_d)) { 
                if($documento['obligatorio']==2){
                    if($edad>4){
                        $insert = mysqli_query($conexion, "INSERT INTO detalle_alumno_empresa (id_alumno,id_documento,id_empresa,estado,fec_reg,user_reg) 
                                VALUES (".$fila['Id'].",".$documento['id_documento'].",4,2,NOW(),0)");
                    }
                }else if($documento['obligatorio']==3){
                    if($edad<18){
                        $insert = mysqli_query($conexion, "INSERT INTO detalle_alumno_empresa (id_alumno,id_documento,id_empresa,estado,fec_reg,user_reg) 
                                VALUES (".$fila['Id'].",".$documento['id_documento'].",4,2,NOW(),0)");
                    }
                }else{
                    $insert = mysqli_query($conexion, "INSERT INTO detalle_alumno_empresa (id_alumno,id_documento,id_empresa,estado,fec_reg,user_reg) 
                            VALUES (".$fila['Id'].",".$documento['id_documento'].",4,2,NOW(),0)");
                }
            }
        }
    }
?>