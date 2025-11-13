<?php
/**
 * Configuración para Cron Jobs
 * Define constantes según el entorno
 */

// Detectar entorno
$servidor = $_SERVER['SERVER_NAME'] ?? 'localhost';

if ($servidor === 'localhost' || $servidor === '127.0.0.1') {
    // DESARROLLO (XAMPP, WAMP, etc.)
    define('ENTORNO', 'desarrollo');
    define('RUTA_BASE', 'C:/xampp/htdocs/sistemavisitas');
    define('PHP_BIN', 'C:/xampp/php/php.exe');
    
} else {
    // PRODUCCIÓN (servidor web real)
    define('ENTORNO', 'produccion');
    define('RUTA_BASE', '/var/www/html/sistemavisitas'); // Ajustar según tu servidor
    define('PHP_BIN', '/usr/bin/php'); // O /usr/local/bin/php según servidor
}

// Configuración de emails para notificaciones
define('EMAIL_ADMIN', 'admin@tudominio.com'); // Cambiar por email real
define('ENVIAR_NOTIFICACIONES', false); // Cambiar a true cuando esté en producción

// Zona horaria
define('TIMEZONE', 'America/Mexico_City'); // Ajustar según ubicación

// Retención de logs (días)
define('DIAS_RETENCION_LOGS', 90);

return [
    'entorno' => ENTORNO,
    'ruta_base' => RUTA_BASE,
    'php_bin' => PHP_BIN,
    'email_admin' => EMAIL_ADMIN,
    'enviar_notificaciones' => ENVIAR_NOTIFICACIONES,
    'timezone' => TIMEZONE,
    'dias_retencion_logs' => DIAS_RETENCION_LOGS
];
?>