<?php

$sql_visitas = "SELECT 
    v.id_visita,
    u.nombre AS nombre_usuario,
    d.nombre AS nombre_delegado,
    a.nombre_area AS nombre_area,
    v.fecha_hora,
    v.motivo,
    v.estado,
    v.comentario_admin
FROM visitas v
JOIN usuarios u ON v.id_usuario = u.id_usuario
JOIN delegados d ON v.id_delegado = d.id_delegado
JOIN areas a ON v.id_area = a.id_area
WHERE v.estado = 'APROBADO'
ORDER BY v.fecha_hora DESC";

$query_visitas = $pdo->prepare($sql_visitas);
$query_visitas->execute();
$visitas_datos = $query_visitas->fetchAll(PDO::FETCH_ASSOC);

?>