<?php
$SERVIDOR = "localhost";
$PORT = "5432";
$USUARIO = "admininfotec";
$PASSWORD = "InfotecAdmi1.";
$BD = "sisvisitas";

$dsn = "pgsql:host=$SERVIDOR;port=$PORT;dbname=$BD";

try {
    $pdo = new PDO($dsn, $USUARIO, $PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES 'UTF8'");
    //echo "La conexión a la base de datos fue con éxito";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

$URL = "/sistemavisitas";

//Definir zona horaria para las fechas
date_default_timezone_set("America/Mexico_City");
$fechaHora = date('Y-m-d H:i:s');
