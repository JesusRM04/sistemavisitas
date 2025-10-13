<?php

define('SERVIDOR', 'localhost');
define('USUARIO', 'root');
define('PASSWORD', '');
define('BD', 'sisvisitas');

// Incluimos charset directamente en el DSN
$dsn = "mysql:host=" . SERVIDOR . ";dbname=" . BD . ";charset=utf8";

try {
    // Usamos la clase global \PDO
    $pdo = new \PDO($dsn, USUARIO, PASSWORD);
    // Después puedes forzar el conjunto de caracteres si quieres
    $pdo->exec("SET NAMES utf8");
    // Opcional: configurar manejo de errores
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    echo"Conexion a la BD exitosa";
} catch (\PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
    exit;
}

date_default_timezone_set("America/Caracas");
$fechaHora = date('Y-m-d H:i:s');
