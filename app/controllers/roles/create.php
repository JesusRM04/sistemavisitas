<?php
include ('../../config.php');

$nombre_rol = $_POST['rol'];

    $sentencia = $pdo->prepare("INSERT INTO roles (nombre_rol) VALUES (:nombre_rol)");
    $sentencia->bindParam(':nombre_rol', $nombre_rol);
    //$sentencia->bindParam('fyh_creacion',$fechaHora);
    if($sentencia->execute()){
        session_start();
        $_SESSION['mensaje'] = "Se Registró el Rol de Manera Correcta";
        $_SESSION['icono'] = "success";
        header('Location: '.$URL.'/roles');
    }else{
        session_start();
        $_SESSION['mensaje'] = "Error, NO se pudo Registrar en la BD";
        $_SESSION['icono'] = "error";
        header('Location: '.$URL.'/roles/create.php');
    }






