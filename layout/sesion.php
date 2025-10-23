<?php
session_start();

// Tiempo máximo de inactividad (por ejemplo 30 minutos = 1800 segundos)
$timeout_duration = 3600;  

// Vida máxima de la sesión (opcional) — por ejemplo 8 horas = 28800 segundos
$max_session_time = 28800;  

// Verificar última actividad
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    // Inactividad mayor al límite: destruir sesión
    session_unset();
    session_destroy();
    echo "Sesión Expirada, Vuelva a Ingresar";
            session_start();
            $_SESSION['mensaje'] = "Sesión Expirada, Vuelva a Ingresar";
            header('Location: '.$URL.'/login');
    exit();
}

// Verificar vida máxima de sesión desde el momento de inicio
if (isset($_SESSION['CREATED']) && (time() - $_SESSION['CREATED']) > $max_session_time) {
    session_unset();
    session_destroy();
    echo "Sesión Expirada, Vuelva a Ingresar";
            session_start();
            $_SESSION['mensaje'] = "Sesión Expirada, Vuelva a Ingresar";
            header('Location: '.$URL.'/login');
    exit();
}

// Actualizar última actividad
$_SESSION['LAST_ACTIVITY'] = time();

// Si es una sesión nueva, establecer tiempo de creación
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
}

// Tu lógica existente para verificar que hay sesión y usuario activo
if (isset($_SESSION['sesion_email'])) {
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
        // todo OK, la sesión es válida
    } else {
        // Usuario no encontrado o inactivo
        session_unset();
        session_destroy();
        header('Location: '.$URL.'/login');
        exit();
    }
} else {
    // No hay sesión
    header('Location: '.$URL.'/login');
    exit();
}
?>
