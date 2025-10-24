<?php
include ('../../config.php');

    $id_delegado = $_POST['id_delegado'];

    $sentencia = $pdo->prepare("DELETE FROM delegados WHERE id_delegado=:id_delegado ");

    $sentencia->bindParam('id_delegado',$id_delegado);
    $sentencia->execute();
    session_start();
    $_SESSION['mensaje'] = "Se Eliminó al Delegado de Manera Correcta";
    $_SESSION['icono'] = "success";
    header('Location: '.$URL.'/delegados');

