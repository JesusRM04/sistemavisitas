<?php

include ('../../config.php');

$id_rol = $_POST['id_rol'];
$nombre_rol = $_POST['rol'];

        $sentencia = $pdo->prepare("UPDATE roles
    SET nombre_rol=:nombre_rol
    WHERE id_rol = :id_rol ");

        $sentencia->bindParam('nombre_rol',$nombre_rol);
        //$sentencia->bindParam('fyh_actualizacion',$fechaHora);
        $sentencia->bindParam('id_rol',$id_rol);
        if($sentencia->execute()){
            session_start();
            $_SESSION['mensaje'] = "Se Actualizó el Rol de Manera Correcta";
            $_SESSION['icono'] = "success";
            header('Location: '.$URL.'/roles');
        }else{
            session_start();
            $_SESSION['mensaje'] = "Error, NO se pudo Actualizar en la BD";
            $_SESSION['icono'] = "error";
            header('Location: '.$URL.'/roles/update.php?id='.$id_rol);
        }








