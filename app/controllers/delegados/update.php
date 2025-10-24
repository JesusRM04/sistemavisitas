<?php
include ('../../config.php');

$nombres = $_POST['nombre'];
$email = $_POST['correo'];
$ext = $_POST['extension'];
$id_delegado = $_POST['id_delegado'];

$sentencia = $pdo->prepare("UPDATE delegados
    SET nombre = :nombre,
        correo = :correo,
        ext = :ext
    WHERE id_delegado = :id_delegado");

$sentencia->bindParam(':nombre', $nombres);
$sentencia->bindParam(':correo', $email);
$sentencia->bindParam(':ext', $ext);
$sentencia->bindParam(':id_delegado', $id_delegado);

if($sentencia->execute()){
    session_start();
    $_SESSION['mensaje'] = "Se actualizó al Delegado de manera correcta";
    $_SESSION['icono'] = "success";
    header('Location: '.$URL.'/delegados');
} else {
    session_start();
    $_SESSION['mensaje'] = "Error, no se pudo actualizar al Delegado";
    $_SESSION['icono'] = "error";
    header('Location: '.$URL.'/delegados/update.php?id='.$id_delegado);
}
?>
