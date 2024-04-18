<?php
// Realizar la consulta SQL para obtener el ranking de puntos
require_once 'connectionpdo.php'; // Ajusta la ruta según la ubicación de tu archivo de conexión
$sql = "SELECT ud.name AS nombre, ud.lastName AS apellido, pt.puntosTotales AS puntos_totales
        FROM PUNTOS_TOTALES pt
        INNER JOIN USUARIODATOS ud ON pt.userId = ud.userId
        ORDER BY pt.puntosTotales DESC";

// Ejecutar la consulta SQL y obtener los resultados
$result = $pdo->query($sql);

// Crear un array para almacenar los resultados
$ranking_puntos = array();

// Iterar sobre los resultados y agregarlos al array
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $ranking_puntos[] = $row;
}

// Devolver los resultados como JSON
echo json_encode($ranking_puntos);
?>
