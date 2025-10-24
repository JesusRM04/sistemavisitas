<?php

$sql_delegados = "SELECT 
    id_delegado AS id_delegado, 
    nombre AS nombres, 
    correo AS email, 
    ext AS extension
FROM delegados;
";
$query_delegados = $pdo->prepare($sql_delegados);
$query_delegados->execute();
$delegados_datos = $query_delegados->fetchAll(PDO::FETCH_ASSOC);