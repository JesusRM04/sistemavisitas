<?php
/**
 * CRON JOB OPTIMIZADO PARA PRODUCCIÓN
 * Elimina visitas PASADAS del mes anterior (día 5 de cada mes)
 * 
 * CONFIGURACIÓN CRON:
 * 
 * Linux/Unix:
 * 0 2 5 * * /usr/bin/php /var/www/html/sistemavisitas/app/controllers/visitas/cron_eliminar_visitas_produccion.php >> /var/www/html/sistemavisitas/app/logs/cron_output.log 2>&1
 * 
 * Windows Task Scheduler:
 * Programa: C:\php\php.exe
 * Argumentos: C:\inetpub\wwwroot\sistemavisitas\app\controllers\visitas\cron_eliminar_visitas_produccion.php
 * Frecuencia: Mensual, día 5, 02:00 AM
 * 
 * cPanel:
 * 0 2 5 * * /usr/local/bin/php /home/usuario/public_html/sistemavisitas/app/controllers/visitas/cron_eliminar_visitas_produccion.php
 */

// Solo permitir ejecución por CLI o cron (seguridad)
if (php_sapi_name() !== 'cli' && !defined('CRON_EXECUTION')) {
    http_response_code(403);
    die('Acceso denegado. Este script solo puede ejecutarse mediante cron job.');
}

// Configuración de errores para producción
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Incluir configuración
require_once __DIR__ . '/../../config.php';

// Configurar zona horaria
date_default_timezone_set('America/Mexico_City'); // Ajusta según tu ubicación

// Iniciar log
$log_dir = __DIR__ . '/../../logs';
$log_file = $log_dir . '/eliminacion_visitas.log';
$error_log_file = $log_dir . '/eliminacion_visitas_errores.log';

if (!file_exists($log_dir)) {
    mkdir($log_dir, 0755, true);
}

// Función para escribir en log
function escribir_log($mensaje, $es_error = false) {
    global $log_file, $error_log_file;
    $timestamp = date('Y-m-d H:i:s');
    $log_mensaje = "[$timestamp] $mensaje\n";
    
    file_put_contents($log_file, $log_mensaje, FILE_APPEND | LOCK_EX);
    
    if ($es_error) {
        file_put_contents($error_log_file, $log_mensaje, FILE_APPEND | LOCK_EX);
    }
    
    echo $log_mensaje; // Para salida de cron
}

try {
    escribir_log("=== INICIO PROCESO DE ELIMINACIÓN DE VISITAS ===");
    
    // Verificar conexión a BD
    if (!isset($pdo)) {
        throw new Exception("Error: No se pudo conectar a la base de datos");
    }
    
    // Calcular fechas
    $primer_dia_mes_anterior = date('Y-m-01', strtotime('-1 month'));
    $ultimo_dia_mes_anterior = date('Y-m-t', strtotime('-1 month'));
    $fecha_actual = date('Y-m-d');
    $mes_nombre = date('F Y', strtotime($primer_dia_mes_anterior));
    
    escribir_log("Procesando mes: $mes_nombre");
    escribir_log("Rango: $primer_dia_mes_anterior al $ultimo_dia_mes_anterior");
    escribir_log("Fecha límite: $fecha_actual (solo se eliminan visitas anteriores)");
    
    // PASO 1: Contar visitas a eliminar (pasadas)
    $sql_count = "SELECT COUNT(*) as total 
                  FROM visitas 
                  WHERE fecha_hora >= :primer_dia::timestamp
                  AND fecha_hora <= :ultimo_dia::timestamp
                  AND fecha_hora < :fecha_actual::timestamp";
    
    $stmt_count = $pdo->prepare($sql_count);
    $stmt_count->execute([
        ':primer_dia' => $primer_dia_mes_anterior . ' 00:00:00',
        ':ultimo_dia' => $ultimo_dia_mes_anterior . ' 23:59:59',
        ':fecha_actual' => $fecha_actual . ' 00:00:00'
    ]);
    $resultado = $stmt_count->fetch(PDO::FETCH_ASSOC);
    $total_a_eliminar = (int)$resultado['total'];
    
    escribir_log("Visitas pasadas encontradas: $total_a_eliminar");
    
    // PASO 2: Contar visitas futuras (que se conservarán)
    $sql_count_futuras = "SELECT COUNT(*) as total 
                          FROM visitas 
                          WHERE fecha_hora >= :primer_dia::timestamp
                          AND fecha_hora <= :ultimo_dia::timestamp
                          AND fecha_hora >= :fecha_actual::timestamp";
    
    $stmt_futuras = $pdo->prepare($sql_count_futuras);
    $stmt_futuras->execute([
        ':primer_dia' => $primer_dia_mes_anterior . ' 00:00:00',
        ':ultimo_dia' => $ultimo_dia_mes_anterior . ' 23:59:59',
        ':fecha_actual' => $fecha_actual . ' 00:00:00'
    ]);
    $resultado_futuras = $stmt_futuras->fetch(PDO::FETCH_ASSOC);
    $total_futuras = (int)$resultado_futuras['total'];
    
    escribir_log("Visitas futuras a conservar: $total_futuras");
    
    // PASO 3: Eliminar si hay visitas pasadas
    if ($total_a_eliminar > 0) {
        
        // Iniciar transacción para seguridad
        $pdo->beginTransaction();
        
        try {
            // Eliminar SOLO visitas pasadas
            $sql_delete = "DELETE FROM visitas 
                           WHERE fecha_hora >= :primer_dia::timestamp
                           AND fecha_hora <= :ultimo_dia::timestamp
                           AND fecha_hora < :fecha_actual::timestamp";
            
            $stmt_delete = $pdo->prepare($sql_delete);
            $stmt_delete->execute([
                ':primer_dia' => $primer_dia_mes_anterior . ' 00:00:00',
                ':ultimo_dia' => $ultimo_dia_mes_anterior . ' 23:59:59',
                ':fecha_actual' => $fecha_actual . ' 00:00:00'
            ]);
            
            $registros_eliminados = $stmt_delete->rowCount();
            
            // Confirmar transacción
            $pdo->commit();
            
            escribir_log("✓ ÉXITO: Eliminadas $registros_eliminados visitas pasadas");
            escribir_log("✓ Conservadas $total_futuras visitas futuras");
            
            // Enviar notificación por email (opcional)
            if ($registros_eliminados > 0) {
                // Descomentar y configurar si deseas notificación por email
                /*
                $to = "admin@tudominio.com";
                $subject = "Limpieza automática de visitas - " . date('d/m/Y');
                $message = "Se eliminaron $registros_eliminados visitas pasadas de $mes_nombre.\n";
                $message .= "Se conservaron $total_futuras visitas futuras.\n";
                $message .= "Fecha de ejecución: " . date('Y-m-d H:i:s');
                mail($to, $subject, $message);
                */
            }
            
        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $pdo->rollBack();
            throw $e;
        }
        
    } else {
        escribir_log("No hay visitas pasadas para eliminar");
    }
    
    // PASO 4: Limpiar logs antiguos (mantener solo últimos 90 días)
    $fecha_limite_logs = date('Y-m-d H:i:s', strtotime('-90 days'));
    $lineas_log = file($log_file);
    $lineas_nuevas = [];
    
    foreach ($lineas_log as $linea) {
        if (preg_match('/\[([\d\-]+ [\d:]+)\]/', $linea, $matches)) {
            if ($matches[1] >= $fecha_limite_logs) {
                $lineas_nuevas[] = $linea;
            }
        }
    }
    
    if (count($lineas_nuevas) < count($lineas_log)) {
        file_put_contents($log_file, implode('', $lineas_nuevas), LOCK_EX);
        escribir_log("Limpieza de logs: eliminadas " . (count($lineas_log) - count($lineas_nuevas)) . " entradas antiguas");
    }
    
    escribir_log("=== PROCESO FINALIZADO EXITOSAMENTE ===\n");
    
    exit(0); // Código de salida exitoso
    
} catch (PDOException $e) {
    $error = "ERROR DE BASE DE DATOS: " . $e->getMessage();
    escribir_log($error, true);
    escribir_log("=== PROCESO FINALIZADO CON ERRORES ===\n", true);
    exit(1); // Código de error
    
} catch (Exception $e) {
    $error = "ERROR GENERAL: " . $e->getMessage();
    escribir_log($error, true);
    escribir_log("=== PROCESO FINALIZADO CON ERRORES ===\n", true);
    exit(1); // Código de error
}
?>