<?php 
include('../../config.php');

$email = $_POST['email'];
$password_user = $_POST['password_user'];

$sql = "SELECT id_usuario, nombre, correo, contrasena, activo 
        FROM usuarios 
        WHERE correo = :email";

$query = $pdo->prepare($sql);
$query->execute([':email' => $email]);
$usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

if(count($usuarios) > 0){
    $usuario = $usuarios[0];
    
    // Verificar que el usuario esté activo
    if($usuario['activo'] == true){
        // Verificar la contraseña
        if($password_user === $usuario['contrasena']){          //No olvidar volver a poner el verify -- if(password_verify($password_user, $usuario['contrasena']))
            echo "Datos correctos";
            session_start();
            $_SESSION['sesion_email'] = $usuario['correo'];
            header('Location: '.$URL.'/index.php');
        } else {
            echo "Datos Incorrectos, Vuelva a Intentarlo";
            session_start();
            $_SESSION['mensaje'] = "Error, Datos Incorrectos";
            header('Location: '.$URL.'/login');
        }
    } else {
        echo "Usuario inactivo";
        session_start();
        $_SESSION['mensaje'] = "Error, Usuario inactivo";
        header('Location: '.$URL.'/login');
    }
} else {
    echo "Datos Incorrectos, Vuelva a Intentarlo";
    session_start();
    $_SESSION['mensaje'] = "Error, Datos Incorrectos";
    header('Location: '.$URL.'/login');
}
?>