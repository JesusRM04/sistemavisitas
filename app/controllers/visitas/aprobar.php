<?php

include ('../../config.php');

$id_visita = $_GET['id'];

// Actualizar el estado a APROBADO
$sentencia = $pdo->prepare("UPDATE visitas
    SET estado = 'APROBADO'
    WHERE id_visita = :id_visita ");

$sentencia->bindParam('id_visita', $id_visita);

if($sentencia->execute()){
    session_start();
    $_SESSION['mensaje'] = "Visita Autorizada Correctamente";
    $_SESSION['icono'] = "success";
    header('Location: '.$URL.'/visitas');
}else{
    session_start();
    $_SESSION['mensaje'] = "Error, NO se pudo Autorizar la Visita";
    $_SESSION['icono'] = "error";
    header('Location: '.$URL.'/visitas');
}

?>