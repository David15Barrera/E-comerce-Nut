<?php

require_once 'connectionpdo.php'; // Ajusta la ruta según la ubicación de tu archivo de conexión
// Realizar la consulta SQL para obtener los servicios más usados
$sql = "SELECT p.titulo AS titulo_servicio, 
        COUNT(s.idServicio) AS inscripciones, 
        GROUP_CONCAT(ud.name) AS nombres, 
        GROUP_CONCAT(ud.lastName) AS apellidos
        FROM SERVICIOS s
        INNER JOIN PUBLICACIONES p ON s.idPublicacion = p.idPublicaciones
        INNER JOIN USUARIODATOS ud ON s.userId = ud.userId
        GROUP BY s.idPublicacion
        ORDER BY inscripciones DESC;
";

// Ejecutar la consulta SQL y obtener los resultados
$result = $pdo->query($sql);

// Crear un array para almacenar los resultados
$servicios_mas_usados = array();

// Iterar sobre los resultados y agregarlos al array
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $servicios_mas_usados[] = $row;
}

// Devolver los resultados como JSON
echo json_encode($servicios_mas_usados);
?>
