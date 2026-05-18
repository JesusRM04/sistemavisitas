<?php

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../config/utils/mail.php';

function creation_mail($id_visita)
{
    global $pdo;

    // Aqui se obtienen datos de la visita para incluir en el correo
    $sql_visita = "SELECT 
        v.id_visita,
        v.motivo,
        v.institucion,
        v.fecha_hora,
        v.fecha_fin,
        u.nombre AS nombre_usuario
    FROM visitas v
    JOIN usuarios u 
        ON v.id_usuario = u.id_usuario
    WHERE v.id_visita = :id_visita";

    $stmt = $pdo->prepare($sql_visita);

    $stmt->execute([
        ':id_visita' => $id_visita
    ]);

    $visita = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$visita) {
        error_log("No se encontró la visita");
        return false;
    }

    // Obtener admins
    $sql_admins = "SELECT 
        nombre,
        correo
    FROM usuarios
    WHERE id_rol = 3";

    $stmt_admins = $pdo->query($sql_admins);

    $admins = $stmt_admins->fetchAll(PDO::FETCH_ASSOC);

    if (!$admins) {
        error_log("No se encontraron administradores");
        return false;
    }

    $asunto = "Nueva visita programada #" . $visita['id_visita'];

    $mensaje = "
    <p>Se ha programado una nueva visita.</p>

    <p><strong>Solicitante:</strong> {$visita['nombre_usuario']}</p>

    <p><strong>Motivo:</strong> {$visita['motivo']}</p>

    <p><strong>Institución:</strong> {$visita['institucion']}</p>

    <p><strong>Inicio:</strong> {$visita['fecha_hora']}</p>

    <p><strong>Fin:</strong> {$visita['fecha_fin']}</p>
    ";

    // Enviar a cada admin
    foreach ($admins as $admin) {

        enviarCorreo(
            $admin['correo'],
            $admin['nombre'],
            $asunto,
            $mensaje
        );
    }

    return true;
}
