<?php
include('../../config.php');

date_default_timezone_set('America/Mexico_City');

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

// 🔒 VERIFICAR PERMISO GENERAL DE EDITAR
if (!$permisos->puedeEditar('visitas')) {
    $_SESSION['mensaje'] = "No tienes permiso para editar visitas";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/visitas');
    exit;
}

// Recibir datos del formulario
$id_visita = $_POST['id_visita'];
$id_usuario = $_POST['id_usuario'];
$id_delegado = $_POST['id_delegado'];
$id_area = $_POST['id_area'];
$fecha_inicio = isset($_POST['fecha_visita']) ? trim($_POST['fecha_visita']) : '';
$hora_inicio = isset($_POST['hora_visita']) ? trim($_POST['hora_visita']) : '';
$fecha_fin = isset($_POST['fecha_fin']) ? trim($_POST['fecha_fin']) : '';
$hora_fin = isset($_POST['hora_fin']) ? trim($_POST['hora_fin']) : '';
$motivo = isset($_POST['motivo']) ? trim($_POST['motivo']) : '';
$institucion = isset($_POST['institucion']) ? trim($_POST['institucion']) : '';
$estado = isset($_POST['estado']) ? trim($_POST['estado']) : '';
$comentario_admin = isset($_POST['comentario_admin']) ? trim($_POST['comentario_admin']) : '';
$invitados_texto = isset($_POST['invitados']) ? trim($_POST['invitados']) : '';

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
    $_SESSION['mensaje'] = "No tienes permiso para editar esta visita";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/visitas');
    exit;
}

// Combinar fechas y horas en formato TIMESTAMP
$fecha_hora_inicio = $fecha_inicio . ' ' . $hora_inicio . ':00';
$fecha_hora_fin = $fecha_fin . ' ' . $hora_fin . ':00';

// Validar que fecha fin sea posterior a fecha inicio
if (strtotime($fecha_hora_fin) <= strtotime($fecha_hora_inicio)) {
    $_SESSION['mensaje'] = "Error: La fecha/hora de fin debe ser posterior a la de inicio";
    $_SESSION['icono'] = "error";
    header('Location: '.$URL.'/visitas/update.php?id='.$id_visita);
    exit;
}

// Validar que la fecha de inicio no sea anterior a ahora
$fecha_actual = date('Y-m-d H:i:s');
if (strtotime($fecha_hora_inicio) < strtotime($fecha_actual)) {
    $_SESSION['mensaje'] = "Error: La fecha/hora de inicio no puede ser anterior a la fecha y hora actual";
    $_SESSION['icono'] = "error";
    header('Location: '.$URL.'/visitas/update.php?id='.$id_visita);
    exit;
}

try {
    // Actualizar visita en la base de datos
    $sentencia = $pdo->prepare("
        UPDATE visitas
        SET id_usuario = :id_usuario,
            id_delegado = :id_delegado,
            id_area = :id_area,
            fecha_hora = :fecha_hora,
            fecha_fin = :fecha_fin,
            motivo = :motivo,
            institucion = :institucion,
            estado = :estado,
            comentario_admin = :comentario_admin
        WHERE id_visita = :id_visita
    ");

    $sentencia->bindParam(':id_usuario', $id_usuario);
    $sentencia->bindParam(':id_delegado', $id_delegado);
    $sentencia->bindParam(':id_area', $id_area);
    $sentencia->bindParam(':fecha_hora', $fecha_hora_inicio);
    $sentencia->bindParam(':fecha_fin', $fecha_hora_fin);
    $sentencia->bindParam(':motivo', $motivo);
    $sentencia->bindParam(':institucion', $institucion);
    $sentencia->bindParam(':estado', $estado);
    $sentencia->bindParam(':comentario_admin', $comentario_admin);
    $sentencia->bindParam(':id_visita', $id_visita);

    if ($sentencia->execute()) {
        // Eliminar invitados anteriores
        $delete_invitados = $pdo->prepare("DELETE FROM invitados WHERE id_visita = :id_visita");
        $delete_invitados->execute([':id_visita' => $id_visita]);

        // Procesar nuevos invitados
        $invitados_array = array_filter(array_map('trim', explode("\n", $invitados_texto)));

        $sentencia_invitado = $pdo->prepare("
            INSERT INTO invitados (id_visita, nombre, fecha_creacion)
            VALUES (:id_visita, :nombre, :fecha_creacion)
        ");

        $fecha_creacion = date('Y-m-d H:i:s');

        foreach ($invitados_array as $nombre_invitado) {
            if (!empty($nombre_invitado)) {
                $sentencia_invitado->execute([
                    ':id_visita' => $id_visita,
                    ':nombre' => $nombre_invitado,
                    ':fecha_creacion' => $fecha_creacion
                ]);
            }
        }

        $_SESSION['mensaje'] = "Se Actualizó la Visita de Manera Correcta";
        $_SESSION['icono'] = "success";
        header('Location: '.$URL.'/visitas');
        exit;
    } else {
        $_SESSION['mensaje'] = "Error, no se pudo Actualizar en la BD";
        $_SESSION['icono'] = "error";
        header('Location: '.$URL.'/visitas/update.php?id='.$id_visita);
        exit;
    }
} catch (Exception $e) {
    $_SESSION['mensaje'] = "Error en el servidor: " . $e->getMessage();
    $_SESSION['icono'] = "error";
    header('Location: '.$URL.'/visitas/update.php?id='.$id_visita);
    exit;
}
?>