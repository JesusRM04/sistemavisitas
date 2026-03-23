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
    file_put_contents($log_file, "[$timestamp] $mensaje\n", FILE_APPEND | LOCK_EX);
}

try {
    escribir_log("=== INICIO PROCESO MARCAR VISITAS VENCIDAS ===");
    
    //contar cuantas colmnas se van a modificar. 
    $stmt = $pdo->query("SELECT COUNT(*) FROM visitas WHERE estado = 'APROBADO' AND fecha_fin < NOW()");
    $total = $stmt->fetchColumn();

    escribir_log("VISITAS VENCIDAS ENCONTRADAS: $total");
        if($total > 0){
            $actualizar_vencidas = $pdo -> exec("
            UPDATE visitas
            SET estado = 'VENCIDO'
            WHERE estado = 'APROBADO'
            AND fecha_fin < NOW()          
            ");
            escribir_log("VISITAS VENCIDAS ACTUALIZADAS: $actualizar_vencidas");

        };

        escribir_log("Fin de actualizacion de visitas vencidas");
        escribir_log("=== RESUMEN ===");
        escribir_log("Total procesadas: $total");
        escribir_log("=== PROCESO FINALIZADO ===\n");
        exit(0);
    
} catch (Exception $e) {
    escribir_log("ERROR: " . $e->getMessage());
    escribir_log("=== PROCESO FINALIZADO CON ERRORES ===\n");
    exit(1);
}
?>
