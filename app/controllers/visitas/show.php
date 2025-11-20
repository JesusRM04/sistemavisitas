<?php

$id_visita_get = $_GET['id'];

$sql_visitas = "SELECT
    v.id_visita,
    u.nombre AS nombre_usuario,
    d.nombre AS nombre_delegado,
    a.nombre_area AS nombre_area,
    v.fecha_hora,
    v.fecha_fin,
    v.motivo,
    v.institucion,
    v.estado,
    v.comentario_admin
FROM visitas v
JOIN usuarios u ON v.id_usuario = u.id_usuario
JOIN delegados d ON v.id_delegado = d.id_delegado
JOIN areas a ON v.id_area = a.id_area
WHERE v.id_visita = :id_visita";

$query_visitas = $pdo->prepare($sql_visitas);
$query_visitas->execute([':id_visita' => $id_visita_get]);
$visitas_datos = $query_visitas->fetchAll(PDO::FETCH_ASSOC);

foreach ($visitas_datos as $visita_dato){
    $id_visita = $visita_dato['id_visita'];
    $nombre_usuario = $visita_dato['nombre_usuario'];
    $nombre_delegado = $visita_dato['nombre_delegado'];
    $nombre_area = $visita_dato['nombre_area'];
    $fecha_hora = $visita_dato['fecha_hora'];
    $fecha_fin = $visita_dato['fecha_fin'];  // ❗ ESTA FALTA
    $motivo = $visita_dato['motivo'];
    $institucion = $visita_dato['institucion'];
    $estado = $visita_dato['estado'];
    $comentario_admin = $visita_dato['comentario_admin'];
}

// Obtener invitados de esta visita
$sql_invitados = "SELECT nombre FROM invitados WHERE id_visita = :id_visita ORDER BY fecha_creacion ASC";
$query_invitados = $pdo->prepare($sql_invitados);
$query_invitados->execute([':id_visita' => $id_visita_get]);
$invitados_datos = $query_invitados->fetchAll(PDO::FETCH_ASSOC);

// Convertir invitados a texto (uno por línea)
$invitados_texto = '';
foreach ($invitados_datos as $invitado) {
    $invitados_texto .= $invitado['nombre'] . "\n";
}
$invitados_texto = rtrim($invitados_texto); // Quitar último salto de línea
?>