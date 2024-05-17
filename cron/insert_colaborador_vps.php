<?php
    include 'conexion.php';
    include 'conexion_vps.php';

    sqlsrv_query($conexion_vps, "TRUNCATE TABLE colaborador");

    $query_p = mysqli_query($conexion,"SELECT id_empresa,id_sede,id_perfil,apellido_paterno,apellido_materno,
                nombres,dni,correo_personal,correo_corporativo,celular,direccion,id_departamento,
                id_provincia,id_distrito,codigo_gll,codigo_glla,inicio_funciones,fin_funciones,nickname,
                usuario,password,password_desencriptado,foto,observaciones,estado,fec_reg,user_reg
                FROM colaborador");
    
    while($fila = mysqli_fetch_assoc( $query_p) ) {
        $codigo_glla = $fila['codigo_gll']."''C";
        $query_ap1 = sqlsrv_query($conexion_vps, "INSERT INTO colaborador (id_empresa,id_sede,id_perfil,
                    apellido_paterno,apellido_materno,nombres,dni,correo_personal,correo_corporativo,
                    celular,direccion,id_departamento,id_provincia,id_distrito,codigo_gll,codigo_glla,
                    inicio_funciones,fin_funciones,nickname,usuario,password,
                    password_desencriptado,foto,observaciones,estado,fec_reg,user_reg)
                    VALUES ('".$fila['id_empresa']."','".$fila['id_sede']."','".$fila['id_perfil']."',
                    '".$fila['apellido_paterno']."','".$fila['apellido_materno']."',
                    '".$fila['nombres']."','".$fila['dni']."','".$fila['correo_personal']."',
                    '".$fila['correo_corporativo']."','".$fila['celular']."','".$fila['direccion']."',
                    '".$fila['id_departamento']."','".$fila['id_provincia']."',
                    '".$fila['id_distrito']."','".$fila['codigo_gll']."','".$codigo_glla."',
                    '".$fila['inicio_funciones']."','".$fila['fin_funciones']."','".$fila['nickname']."',
                    '".$fila['usuario']."','".$fila['password']."','".$fila['password_desencriptado']."',
                    '".$fila['foto']."','".$fila['observaciones']."','".$fila['estado']."',
                    '".$fila['fec_reg']."','".$fila['user_reg']."')");
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion)); 
    }
?>