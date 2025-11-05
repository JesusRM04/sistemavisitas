<?php
include('../../config.php');

session_start();

// Obtener los valores del POST 
$id_usuario         = $_POST['nombre_usuario'];     
$id_area            = $_POST['nombre_area'];       
$id_delegado        = $_POST['nombre_delegado'];    
$motivo             = $_POST['motivo'];
$fecha_visita       = $_POST['fecha_visita'];
$hora_visita        = $_POST['hora_visita'];
$institucion        = $_POST['institucion'];
$estado             = $_POST['estado'];
$comentario_admin   = $_POST['comentario_admin'];

// Combinar fecha y hora en formato TIMESTAMP
$fecha_hora = $fecha_visita . ' ' . $hora_visita . ':00';

$sentencia = $pdo->prepare("
    INSERT INTO visitas 
    ( id_usuario, id_delegado, id_area, fecha_hora, motivo, institucion, estado, comentario_admin, fecha_creacion ) 
    VALUES 
    ( :id_usuario, :id_delegado, :id_area, :fecha_hora, :motivo, :institucion, :estado, :comentario_admin, :fecha_creacion )
");

$fecha_creacion = date('Y-m-d H:i:s');

$sentencia->bindParam(':id_usuario',       $id_usuario);
$sentencia->bindParam(':id_delegado',      $id_delegado);
$sentencia->bindParam(':id_area',          $id_area);
$sentencia->bindParam(':fecha_hora',       $fecha_hora);
$sentencia->bindParam(':motivo',           $motivo);
$sentencia->bindParam(':institucion',      $institucion);
$sentencia->bindParam(':estado',           $estado);
$sentencia->bindParam(':comentario_admin', $comentario_admin);
$sentencia->bindParam(':fecha_creacion',   $fecha_creacion);

// Ejecutar
if($sentencia->execute()) {
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