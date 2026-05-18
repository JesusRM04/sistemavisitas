<?php

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../config/utils/mail.php';

date_default_timezone_set('America/Mexico_City');

try {

    $sql = "
    SELECT
        v.id_visita,
        v.fecha_hora,
        v.fecha_fin,
        v.motivo,
        v.institucion,
        u.nombre,
        u.correo
    FROM visitas v
    JOIN usuarios u
        ON v.id_usuario = u.id_usuario
    WHERE DATE(v.fecha_hora) = CURRENT_DATE + INTERVAL '1 day'
    AND v.estado = 'APROBADO'
    AND v.recordatorio_manana_enviado = FALSE
    ";

    $stmt = $pdo->query($sql);

    $visitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($visitas as $visita) {

        $asunto = "Recordatorio de visita para mañana";

        $mensaje = "
        <p>Hola {$visita['nombre']},</p>

        <p>Te recordamos que hay una visita programada para mañana.</p>

        <p><strong>Motivo:</strong> {$visita['motivo']}</p>

        <p><strong>Institución:</strong> {$visita['institucion']}</p>

        <p><strong>Inicio:</strong> {$visita['fecha_hora']}</p>

        <p><strong>Fin:</strong> {$visita['fecha_fin']}</p>

        <p>Saludos,<br>Sistema de Visitas</p>
        ";

        $enviado = enviarCorreo(
            $visita['correo'],
            $visita['nombre'],
            $asunto,
            $mensaje
        );

        if ($enviado) {

            $update = $pdo->prepare("
                UPDATE visitas
                SET recordatorio_manana_enviado = TRUE
                WHERE id_visita = :id_visita
            ");

            $update->execute([
                ':id_visita' => $visita['id_visita']
            ]);
        }
    }

} catch (Exception $e) {

    error_log(
        "Error cron recordatorio mañana: " .
        $e->getMessage()
    );
}