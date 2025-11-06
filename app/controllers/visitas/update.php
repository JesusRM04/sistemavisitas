<?php

include ('../../config.php');

// Recibir datos del formulario
$id_visita = $_POST['id_visita'];
$id_usuario = $_POST['id_usuario'];
$id_delegado = $_POST['id_delegado'];
$id_area = $_POST['id_area'];
$fecha_visita = $_POST['fecha_visita'];
$hora_visita = $_POST['hora_visita'];
$motivo = $_POST['motivo'];
$institucion = $_POST['institucion'];
$estado = $_POST['estado'];
$comentario_admin = $_POST['comentario_admin'];
$invitados_texto = $_POST['invitados'];

// Combinar fecha y hora en formato TIMESTAMP
$fecha_hora = $fecha_visita . ' ' . $hora_visita . ':00';

// Actualizar visita en la base de datos
$sentencia = $pdo->prepare("UPDATE visitas
    SET id_usuario=:id_usuario,
        id_delegado=:id_delegado,
        id_area=:id_area,
        fecha_hora=:fecha_hora,
        motivo=:motivo,
        institucion=:institucion,
        estado=:estado,
        comentario_admin=:comentario_admin
    WHERE id_visita = :id_visita ");

$sentencia->bindParam('id_usuario',$id_usuario);
$sentencia->bindParam('id_delegado',$id_delegado);
$sentencia->bindParam('id_area',$id_area);
$sentencia->bindParam('fecha_hora',$fecha_hora);
$sentencia->bindParam('motivo',$motivo);
$sentencia->bindParam('institucion',$institucion);
$sentencia->bindParam('estado',$estado);
$sentencia->bindParam('comentario_admin',$comentario_admin);
$sentencia->bindParam('id_visita',$id_visita);

if($sentencia->execute()){
    // Eliminar invitados anteriores
    $delete_invitados = $pdo->prepare("DELETE FROM invitados WHERE id_visita = :id_visita");
    $delete_invitados->execute([':id_visita' => $id_visita]);
    
    // Procesar nuevos invitados (separar por líneas)
    $invitados_array = array_filter(array_map('trim', explode("\n", $invitados_texto)));
    
    // Insertar cada invitado
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
    
    session_start();
    $_SESSION['mensaje'] = "Se Actualizó la Visita de Manera Correcta";
    $_SESSION['icono'] = "success";
    header('Location: '.$URL.'/visitas');
}else{
    session_start();
    $_SESSION['mensaje'] = "Error, no se pudo Actualizar en la BD";
    $_SESSION['icono'] = "error";
    header('Location: '.$URL.'/visitas/update.php?id='.$id_visita);
}

?>