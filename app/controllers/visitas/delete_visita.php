<?php
include ('../../config.php');

$id_visita = $_POST['id_visita'];

$sentencia = $pdo->prepare("DELETE FROM visitas WHERE id_visita=:id_visita");

if($sentencia->execute([':id_visita' => $id_visita])){
    session_start();
    $_SESSION['mensaje'] = "Se Eliminó la Visita de Manera Correcta";
    $_SESSION['icono'] = "success";
    header('Location: '.$URL.'/visitas');
} else {
    session_start();
    $_SESSION['mensaje'] = "Error al Eliminar la Visita";
    $_SESSION['icono'] = "error";
    header('Location: '.$URL.'/visitas');
}
?>