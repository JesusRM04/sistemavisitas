<?php
include('../../config.php');

session_start();

// 🔒 CARGAR SISTEMA DE PERMISOS
require_once __DIR__ . '/../../helpers/PermisosHelper.php';

// Obtener datos de sesión
$sql = "SELECT id_usuario, id_rol FROM usuarios WHERE correo = :email AND activo = TRUE";
$query = $pdo->prepare($sql);
$query->execute([':email' => $_SESSION['sesion_email']]);
$usuario = $query->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    $_SESSION['mensaje'] = "Sesión inválida";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/login');
    exit;
}

$permisos = new PermisosHelper($pdo, $usuario['id_rol'], $usuario['id_usuario']);


// 🔒 VERIFICAR PERMISO DE EDITAR (para aprobar se necesita poder editar)
if (!$permisos->puedeEditar('visitas')) {
    $_SESSION['mensaje'] = "No tienes permiso para aprobar visitas";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/visitas');
    exit;
}

// 🔒 VERIFICAR ALCANCE - Solo quien puede ver "todos" puede aprobar
if (!$permisos->puedoVerTodos('visitas')) {
    $_SESSION['mensaje'] = "Solo administradores pueden aprobar visitas";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/visitas');
    exit;
}

$id_visita = $_GET['id'];
$id_usuario = $usuario['id_usuario'];



// Actualizar el estado a APROBADO
$sentencia = $pdo->prepare("UPDATE visitas
    SET estado = 'APROBADO', aprobador = :id_usuario
    WHERE id_visita = :id_visita ");

$sentencia->bindParam('id_visita', $id_visita);
$sentencia->bindParam('id_usuario', $id_usuario);

if($sentencia->execute()){
    $_SESSION['mensaje'] = "Visita Autorizada Correctamente";
    $_SESSION['icono'] = "success";
    header('Location: '.$URL.'/visitas');
}else{
    $_SESSION['mensaje'] = "Error, NO se pudo Autorizar la Visita";
    $_SESSION['icono'] = "error";
    header('Location: '.$URL.'/visitas');
}
?>