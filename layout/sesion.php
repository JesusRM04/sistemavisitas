<?php
/** 
 * Archivo de sesión - Verifica login, expiración y carga permisos 
 */
session_start();

// ========================
// CONFIGURACIÓN DE TIEMPOS
// ========================
$timeout_duration = 3600;      // 1 hora de inactividad
$max_session_time = 28800;     // 8 horas de vida total

// ====================================
// VERIFICAR INACTIVIDAD (última acción)
// ====================================
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['mensaje'] = "Sesión expirada por inactividad, vuelva a ingresar";
    header('Location: ' . $URL . '/login');
    exit();
}

// =======================================
// VERIFICAR VIDA TOTAL DE LA SESIÓN
// =======================================
if (isset($_SESSION['CREATED']) && (time() - $_SESSION['CREATED']) > $max_session_time) {
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['mensaje'] = "Sesión expirada, vuelva a ingresar";
    header('Location: ' . $URL . '/login');
    exit();
}

// Actualizar última actividad
$_SESSION['LAST_ACTIVITY'] = time();
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
}

// =======================================
// VERIFICAR SI HAY SESIÓN ACTIVA
// =======================================
if (!isset($_SESSION['sesion_email'])) {
    header('Location: ' . $URL . '/login');
    exit();
}

$email_sesion = $_SESSION['sesion_email'];

// ==================================================
// VERIFICAR USUARIO EN BD Y OBTENER DATOS DEL ROL
// ==================================================
$sql = "SELECT 
            u.id_usuario, u.nombre, u.correo, u.id_rol, 
            r.nombre_rol 
        FROM usuarios AS u 
        INNER JOIN roles AS r ON u.id_rol = r.id_rol 
        WHERE u.correo = :email AND u.activo = TRUE";

$query = $pdo->prepare($sql);
$query->execute([':email' => $email_sesion]);
$usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

if (count($usuarios) > 0) {
    foreach ($usuarios as $usuario) {
        $id_usuario_sesion = $usuario['id_usuario'];    // 👈 NECESARIO PARA PERMISOS
        $nombres_sesion    = $usuario['nombre'];
        $email_sesion_db   = $usuario['correo'];
        $rol_sesion        = $usuario['nombre_rol'];
        $id_rol_sesion     = $usuario['id_rol'];        // 👈 NECESARIO PARA PERMISOS
    }
} else {
    session_unset();
    session_destroy();
    header('Location: ' . $URL . '/login');
    exit();
}

// ==================================================
// CARGAR SISTEMA DE PERMISOS (CON ID USUARIO)
// ==================================================
require_once __DIR__ . '/../app/helpers/PermisosHelper.php';

// AHORA LE PASAMOS TAMBIÉN EL ID_USUARIO (YA SIRVE PARA ALCANCE: propios/todos)
$permisos = new PermisosHelper($pdo, $id_rol_sesion, $id_usuario_sesion);
$GLOBALS['permisos'] = $permisos;

/**
 * Helper para verificar permisos rápidamente
 * Ejemplo: if (tienePermiso('visitas', 'crear')) { ... }
 */
function tienePermiso($modulo, $accion = 'ver') {
    global $permisos;
    switch ($accion) {
        case 'ver':      return $permisos->puedeVer($modulo);
        case 'crear':    return $permisos->puedeCrear($modulo);
        case 'editar':   return $permisos->puedeEditar($modulo);
        case 'eliminar': return $permisos->puedeEliminar($modulo);
        default:         return false;
    }
}

/**
 * Protege páginas completas
 * Ejemplo: protegerPagina('visitas', 'editar');
 */
function protegerPagina($modulo, $accion = 'ver') {
    global $permisos;
    $permisos->verificarPermiso($modulo, $accion);
}
?>
