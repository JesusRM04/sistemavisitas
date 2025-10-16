<?php
session_start();
if(isset($_SESSION['sesion_email'])){
    $email_sesion = $_SESSION['sesion_email'];
    
    $sql = "SELECT u.id_usuario, u.nombre, u.correo, r.nombre_rol 
            FROM usuarios AS u 
            INNER JOIN roles AS r ON u.id_rol = r.id_rol 
            WHERE u.correo = :email AND u.activo = TRUE";
    
    $query = $pdo->prepare($sql);
    $query->execute([':email' => $email_sesion]);
    $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
    
    if(count($usuarios) > 0){
        foreach ($usuarios as $usuario){
            $id_usuario_sesion = $usuario['id_usuario'];
            $nombres_sesion = $usuario['nombre'];
            $email_sesion_db = $usuario['correo'];
            $rol_sesion = $usuario['nombre_rol'];
        }
    } else {
        // Usuario no encontrado o inactivo
        session_destroy();
        header('Location: '.$URL.'/login');
        exit();
    }
} else {
    echo "no existe sesion";
    header('Location: '.$URL.'/login');
    exit();
}
?>