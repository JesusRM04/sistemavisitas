<?php
include ('../../config.php');

$nombres = $_POST['nombre'];
$email = $_POST['correo'];
$ext = $_POST['extension'];
$password_user = $_POST['contrasena'];
$password_repeat = $_POST['password_repeat'];
$id_usuario = $_POST['id_usuario'];
$rol = $_POST['rol'];

session_start();

if($password_user != ""){
    // Quiere cambiar contraseña
    if($password_user == $password_repeat){
        $password_user = password_hash($password_user, PASSWORD_DEFAULT);
        $sentencia = $pdo->prepare("UPDATE usuarios
            SET nombre=:nombre,
                correo=:correo,
                id_rol=:id_rol,
                extension=:extension,
                contrasena=:contrasena
            WHERE id_usuario = :id_usuario");

        $sentencia->bindParam('nombre', $nombres);
        $sentencia->bindParam('correo', $email);
        $sentencia->bindParam('id_rol', $rol);
        $sentencia->bindParam('extension', $ext);
        $sentencia->bindParam('contrasena', $password_user);
        $sentencia->bindParam('id_usuario', $id_usuario);
        $sentencia->execute();

        $_SESSION['mensaje'] = "Se Actualizó al Usuario de Manera Correcta";
        $_SESSION['icono'] = "success";
        header('Location: '.$URL.'/usuarios');
    } else {
        $_SESSION['mensaje'] = "Error las Contraseñas NO son Iguales";
        $_SESSION['icono'] = "error";
        header('Location: '.$URL.'/usuarios/update.php?id='.$id_usuario);
    }
} else {
    // No quiere cambiar contraseña, omitir ese campo
    $sentencia = $pdo->prepare("UPDATE usuarios
        SET nombre=:nombre,
            correo=:correo,
            id_rol=:id_rol,
            extension=:extension
        WHERE id_usuario = :id_usuario");

    $sentencia->bindParam('nombre', $nombres);
    $sentencia->bindParam('correo', $email);
    $sentencia->bindParam('id_rol', $rol);
    $sentencia->bindParam('extension', $ext);
    $sentencia->bindParam('id_usuario', $id_usuario);
    $sentencia->execute();

    $_SESSION['mensaje'] = "Se Actualizó al Usuario de Manera Correcta";
    $_SESSION['icono'] = "success";
    header('Location: '.$URL.'/usuarios');
}