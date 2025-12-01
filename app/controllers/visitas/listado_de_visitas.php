<?php
// Construir filtro de alcance dinámicamente
$filtro_alcance = $permisos->aplicarFiltroAlcance('visitas', 'id_usuario', 'v');

$sql_visitas = "SELECT 
    v.id_visita,
    v.id_usuario,
    u.nombre AS nombre_usuario,
    d.nombre AS nombre_delegado,
    a.nombre_area AS nombre_area,
    v.fecha_hora,
    v.fecha_fin,
    v.motivo,
    v.institucion,
    v.estado,
    v.comentario_admin,
    STRING_AGG(i.nombre, '<br> ' ORDER BY i.fecha_creacion) AS invitados
FROM visitas v
JOIN usuarios u ON v.id_usuario = u.id_usuario
JOIN delegados d ON v.id_delegado = d.id_delegado
JOIN areas a ON v.id_area = a.id_area
LEFT JOIN invitados i ON v.id_visita = i.id_visita
WHERE v.estado = 'PENDIENTE'
$filtro_alcance
GROUP BY v.id_visita, v.id_usuario, u.nombre, d.nombre, a.nombre_area, v.fecha_hora, v.fecha_fin, v.motivo, v.institucion, v.estado, v.comentario_admin
ORDER BY v.fecha_hora DESC";

$query_visitas = $pdo->prepare($sql_visitas);
$query_visitas->execute();
$visitas_datos = $query_visitas->fetchAll(PDO::FETCH_ASSOC);
?>