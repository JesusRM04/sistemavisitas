<?php
/**
 * CRON JOB - Marcar visitas como VENCIDAS
 * Cambia estado de APROBADO a VENCIDO cuando pasa la fecha_fin
 * 
 * CONFIGURACIÓN CRON:
 * Ejecutar cada hora o cada 30 minutos
 * 
 * Linux (cada hora):
 * 0 * * * * /usr/bin/php /var/www/html/sistemavisitas/app/controllers/visitas/cron_marcar_vencidas.php
 * 
 * Windows (Task Scheduler):
 * Programa: C:\xampp\php\php.exe
 * Argumentos: C:\xampp\htdocs\sistemavisitas\app\controllers\visitas\cron_marcar_vencidas.php
 * Frecuencia: Cada hora
 */

// Solo permitir ejecución por CLI o cron
if (php_sapi_name() !== 'cli' && !defined('CRON_EXECUTION')) {
    http_response_code(403);
    die('Acceso denegado. Este script solo puede ejecutarse mediante cron job.');
}

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require_once __DIR__ . '/../../config.php';
date_default_timezone_set('America/Mexico_City');

// Configuración de logs
$log_dir = __DIR__ . '/../../logs';
$log_file = $log_dir . '/visitas_vencidas.log';

if (!file_exists($log_dir)) {
    mkdir($log_dir, 0755, true);
}

function escribir_log($mensaje) {
    global $log_file;
    $timestamp = date('Y-m-d H:i:s');
    $log_mensaje = "[$timestamp] $mensaje\n";
    file_put_contents($log_file, $log_mensaje, FILE_APPEND | LOCK_EX);
    echo $log_mensaje;
}

try {
    escribir_log("=== INICIO PROCESO MARCAR VISITAS VENCIDAS ===");
    
    $fecha_actual = date('Y-m-d H:i:s');
    escribir_log("Fecha/hora actual: $fecha_actual");
    
    // Buscar visitas APROBADAS cuya fecha_fin ya pasó
    $sql_vencidas = "SELECT 
        v.id_visita,
        v.fecha_hora,
        v.fecha_fin,
        u.nombre AS solicitante,
        v.motivo
    FROM visitas v
    JOIN usuarios u ON v.id_usuario = u.id_usuario
    WHERE v.estado = 'APROBADO'
    AND v.fecha_fin < :fecha_actual";
    
    $stmt = $pdo->prepare($sql_vencidas);
    $stmt->execute([':fecha_actual' => $fecha_actual]);
    $visitas_vencidas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $total = count($visitas_vencidas);
    escribir_log("Visitas vencidas encontradas: $total");
    
    if ($total == 0) {
        escribir_log("No hay visitas para marcar como vencidas");
        escribir_log("=== PROCESO FINALIZADO ===\n");
        exit(0);
    }
    
    // Actualizar estado a VENCIDO
    $sql_update = "UPDATE visitas 
                   SET estado = 'VENCIDO'
                   WHERE id_visita = :id_visita";
    
    $stmt_update = $pdo->prepare($sql_update);
    
    $actualizadas = 0;
    foreach ($visitas_vencidas as $visita) {
        try {
            $stmt_update->execute([':id_visita' => $visita['id_visita']]);
            $actualizadas++;
            
            $fecha_fin_fmt = date('d/m/Y H:i', strtotime($visita['fecha_fin']));
            escribir_log("✓ Visita #{$visita['id_visita']} marcada como VENCIDA (fin: $fecha_fin_fmt)");
            
        } catch (PDOException $e) {
            escribir_log("✗ Error al actualizar visita #{$visita['id_visita']}: " . $e->getMessage());
        }
    }
    
    escribir_log("=== RESUMEN ===");
    escribir_log("Total procesadas: $total");
    escribir_log("Actualizadas exitosamente: $actualizadas");
    escribir_log("=== PROCESO FINALIZADO ===\n");
    
    exit(0);
    
} catch (Exception $e) {
    escribir_log("ERROR: " . $e->getMessage());
    escribir_log("=== PROCESO FINALIZADO CON ERRORES ===\n");
    exit(1);
}
?>