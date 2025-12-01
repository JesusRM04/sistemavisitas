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

// 🔒 VERIFICAR PERMISO GENERAL DE ELIMINAR
if (!$permisos->puedeEliminar('visitas')) {
    $_SESSION['mensaje'] = "No tienes permiso para eliminar visitas";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/visitas');
    exit;
}

$id_visita = $_POST['id_visita'];

// 🔒 VERIFICAR PROPIETARIO DE LA VISITA
$sql_check = "SELECT id_usuario FROM visitas WHERE id_visita = :id_visita";
$stmt_check = $pdo->prepare($sql_check);
$stmt_check->execute([':id_visita' => $id_visita]);
$visita = $stmt_check->fetch(PDO::FETCH_ASSOC);

if (!$visita) {
    $_SESSION['mensaje'] = "Visita no encontrada";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/visitas');
    exit;
}

// 🔒 VERIFICAR SI PUEDE MODIFICAR ESTE REGISTRO ESPECÍFICO
if (!$permisos->puedeModificarRegistro('visitas', $visita['id_usuario'])) {
    $_SESSION['mensaje'] = "No tienes permiso para eliminar esta visita";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/visitas');
    exit;
}

// Proceder con la eliminación
$sentencia = $pdo->prepare("DELETE FROM visitas WHERE id_visita=:id_visita");

if($sentencia->execute([':id_visita' => $id_visita])){
    $_SESSION['mensaje'] = "Se Eliminó la Visita de Manera Correcta";
    $_SESSION['icono'] = "success";
    header('Location: '.$URL.'/visitas');
} else {
    $_SESSION['mensaje'] = "Error al Eliminar la Visita";
    $_SESSION['icono'] = "error";
    header('Location: '.$URL.'/visitas');
}
?>