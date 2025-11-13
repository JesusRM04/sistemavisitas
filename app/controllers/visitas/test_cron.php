<?php
/**
 * =======================================================
 *  TEST CRON - LIMPIEZA AUTOMÁTICA DE VISITAS (MODO PRUEBA)
 * =======================================================
 *  Simula lo que haría el cron real que elimina visitas
 *  ocurridas entre el día 5 del mes anterior y el día 5
 *  del mes actual.
 * 
 *  ⚠️ NO ELIMINA NADA - SOLO MUESTRA RESULTADOS
 */

require_once __DIR__ . '/../../config.php';

echo "=== MODO PRUEBA - NO SE ELIMINARÁ NADA ===\n\n";

try {
    // 📅 Fecha actual
    $fecha_actual = date('Y-m-d');
    $hora_actual = date('H:i:s');

    // 🧮 Calcular rango de fechas (del 5 al 5)
    $inicio_rango = date('Y-m-05 00:00:00', strtotime('-1 month'));
    $fin_rango = date('Y-m-05 00:00:00');

    echo "Fecha actual: {$fecha_actual} {$hora_actual}\n";
    echo "Rango analizado: {$inicio_rango} → {$fin_rango}\n\n";

    // 🔹 VISITAS PASADAS (se eliminarían)
    $sql_pasadas = "
        SELECT 
            v.id_visita,
            v.fecha_hora,
            u.nombre AS usuario,
            v.estado
        FROM visitas v
        JOIN usuarios u ON v.id_usuario = u.id_usuario
        WHERE v.fecha_hora >= :inicio_rango::timestamp
        AND v.fecha_hora < :fin_rango::timestamp
        AND v.fecha_hora < :fecha_actual::timestamp
        ORDER BY v.fecha_hora DESC
    ";

    $stmt = $pdo->prepare($sql_pasadas);
    $stmt->execute([
        ':inicio_rango' => $inicio_rango,
        ':fin_rango' => $fin_rango,
        ':fecha_actual' => $fecha_actual
    ]);
    $visitas_pasadas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "📋 VISITAS PASADAS (se eliminarían): " . count($visitas_pasadas) . "\n";
    echo str_repeat("-", 80) . "\n";

    if (count($visitas_pasadas) > 0) {
        foreach ($visitas_pasadas as $visita) {
            $fecha = date('d/m/Y H:i', strtotime($visita['fecha_hora']));
            echo "  ID: {$visita['id_visita']} | Fecha: {$fecha} | Usuario: {$visita['usuario']} | Estado: {$visita['estado']}\n";
        }
    } else {
        echo "  No hay visitas pasadas para eliminar\n";
    }

    echo "\n";

    // 🔹 VISITAS FUTURAS (se conservarían)
    $sql_futuras = "
        SELECT 
            v.id_visita,
            v.fecha_hora,
            u.nombre AS usuario,
            v.estado
        FROM visitas v
        JOIN usuarios u ON v.id_usuario = u.id_usuario
        WHERE v.fecha_hora >= :inicio_rango::timestamp
        AND v.fecha_hora < :fin_rango::timestamp
        AND v.fecha_hora >= :fecha_actual::timestamp
        ORDER BY v.fecha_hora ASC
    ";

    $stmt2 = $pdo->prepare($sql_futuras);
    $stmt2->execute([
        ':inicio_rango' => $inicio_rango,
        ':fin_rango' => $fin_rango,
        ':fecha_actual' => $fecha_actual
    ]);
    $visitas_futuras = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    echo "✅ VISITAS FUTURAS (se conservarían): " . count($visitas_futuras) . "\n";
    echo str_repeat("-", 80) . "\n";

    if (count($visitas_futuras) > 0) {
        foreach ($visitas_futuras as $visita) {
            $fecha = date('d/m/Y H:i', strtotime($visita['fecha_hora']));
            echo "  ID: {$visita['id_visita']} | Fecha: {$fecha} | Usuario: {$visita['usuario']} | Estado: {$visita['estado']}\n";
        }
    } else {
        echo "  No hay visitas futuras dentro de este rango\n";
    }

    echo "\n" . str_repeat("=", 80) . "\n";
    echo "RESUMEN:\n";
    echo "  - Visitas pasadas (a eliminar): " . count($visitas_pasadas) . "\n";
    echo "  - Visitas futuras (a conservar): " . count($visitas_futuras) . "\n";
    echo str_repeat("=", 80) . "\n\n";

    echo "✓ Prueba completada. Revisa los resultados antes de ejecutar el cron real.\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
?>
