<?php
include('../app/config.php');

// Redirigir automáticamente al reporte de visitas del mes
header('Location: ' . $URL . '/reportes/visitas_mes.php');
exit;
?>