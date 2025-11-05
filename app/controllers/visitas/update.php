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