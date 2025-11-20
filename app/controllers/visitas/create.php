<?php
include('../../config.php');

session_start();

// Obtener los valores del POST 
$id_usuario         = $_POST['nombre_usuario'];     
$id_area            = $_POST['nombre_area'];       
$id_delegado        = $_POST['nombre_delegado'];    
$motivo             = $_POST['motivo'];
$fecha_inicio       = $_POST['fecha_inicio'];
$hora_inicio        = $_POST['hora_inicio'];
$fecha_fin          = $_POST['fecha_fin'];
$hora_fin           = $_POST['hora_fin'];
$institucion        = $_POST['institucion'];
$estado             = $_POST['estado'];
$comentario_admin   = $_POST['comentario_admin'];
$invitados_texto    = $_POST['invitados'];

// Combinar fechas y horas en formato TIMESTAMP
$fecha_hora_inicio = $fecha_inicio . ' ' . $hora_inicio . ':00';
$fecha_hora_fin = $fecha_fin . ' ' . $hora_fin . ':00';

// Validar que fecha fin sea posterior a fecha inicio
if (strtotime($fecha_hora_fin) <= strtotime($fecha_hora_inicio)) {
    $_SESSION['mensaje'] = "Error: La fecha/hora de fin debe ser posterior a la de inicio";
    $_SESSION['icono'] = "error";
    header('Location: '.$URL.'/visitas/create.php');
    exit;
}

$sentencia = $pdo->prepare("
    INSERT INTO visitas 
    ( id_usuario, id_delegado, id_area, fecha_hora, fecha_fin, motivo, institucion, estado, comentario_admin, fecha_creacion ) 
    VALUES 
    ( :id_usuario, :id_delegado, :id_area, :fecha_hora, :fecha_fin, :motivo, :institucion, :estado, :comentario_admin, :fecha_creacion )
");

$fecha_creacion = date('Y-m-d H:i:s');

$sentencia->bindParam(':id_usuario',       $id_usuario);
$sentencia->bindParam(':id_delegado',      $id_delegado);
$sentencia->bindParam(':id_area',          $id_area);
$sentencia->bindParam(':fecha_hora',       $fecha_hora_inicio);
$sentencia->bindParam(':fecha_fin',        $fecha_hora_fin);
$sentencia->bindParam(':motivo',           $motivo);
$sentencia->bindParam(':institucion',      $institucion);
$sentencia->bindParam(':estado',           $estado);
$sentencia->bindParam(':comentario_admin', $comentario_admin);
$sentencia->bindParam(':fecha_creacion',   $fecha_creacion);

// Ejecutar
if($sentencia->execute()) {
    // Obtener el ID de la visita recién creada
    $id_visita = $pdo->lastInsertId();
    
    // Procesar invitados (separar por líneas)
    $invitados_array = array_filter(array_map('trim', explode("\n", $invitados_texto)));
    
    // Insertar cada invitado
    $sentencia_invitado = $pdo->prepare("
        INSERT INTO invitados (id_visita, nombre, fecha_creacion)
        VALUES (:id_visita, :nombre, :fecha_creacion)
    ");
    
    foreach ($invitados_array as $nombre_invitado) {
        if (!empty($nombre_invitado)) {
            $sentencia_invitado->execute([
                ':id_visita' => $id_visita,
                ':nombre' => $nombre_invitado,
                ':fecha_creacion' => $fecha_creacion
            ]);
        }
    }
    
    $_SESSION['mensaje'] = "Se Registró la Visita de Manera Correcta";
    $_SESSION['icono']   = "success";
    header('Location: '.$URL.'/visitas');
    exit;
} else {
    $_SESSION['mensaje'] = "Error, NO se pudo Registrar la Visita en la BD";
    $_SESSION['icono']   = "error";
    header('Location: '.$URL.'/visitas/create.php');
    exit;
}
?>