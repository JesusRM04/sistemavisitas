<?php
// Dirección base de tu API Python
$API_BASE = "http://127.0.0.1:8000";

// Intentar conexión
try {
    $ch = curl_init($API_BASE . "/users");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        // Error de conexión
        throw new Exception("Error de conexión con la API: " . curl_error($ch));
    }

    curl_close($ch);

    if ($http_code == 200) {
        echo "✅ Conexión exitosa con la API de Python";
    } else {
        echo "❌ Error al conectar. Código HTTP: " . $http_code . "<br>";
        echo "Respuesta: " . $response;
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}