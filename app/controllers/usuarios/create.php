<?php

include ('../../config.php');

$nombres = $_POST['nombre'];
$email = $_POST['correo'];
$ext = $_POST['extension'];
$rol = $_POST['rol'];
$password_user = $_POST['contrasena'];
$password_repeat = $_POST['password_repeat'];

if($password_user == $password_repeat){
    $password_user = password_hash($password_user, PASSWORD_DEFAULT);
    $sentencia = $pdo->prepare("INSERT INTO usuarios
       ( nombre, correo, id_rol, contrasena, extension, fecha_creacion) 
VALUES (:nombre,:correo,:id_rol,:contrasena,:extension,:fecha_creacion)");

    $sentencia->bindParam('nombre',$nombres);
    $sentencia->bindParam('correo',$email);
    $sentencia->bindParam('extension',$ext);
    $sentencia->bindParam('id_rol',$rol);
    $sentencia->bindParam('contrasena',$password_user);
    $sentencia->bindParam('fecha_creacion',$fechaHora);
    $sentencia->execute();
    session_start();
    $_SESSION['mensaje'] = "Se Registró al Usuario de Manera Correcta";
    header('Location: '.$URL.'/usuarios');

}else{
   // echo "error las contraseñas no son iguales";
    session_start();
    $_SESSION['mensaje'] = "Error, las Contraseñas NO son Iguales";
    header('Location: '.$URL.'/usuarios/create.php');
}



