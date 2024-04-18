<?php
// Incluir el archivo de conexión a la base de datos
require_once 'connectionpdo.php'; // Ajusta la ruta según la ubicación de tu archivo de conexión

// Consulta SQL para obtener los datos de los usuarios reportados y los usuarios que realizaron el reporte
$sql = "SELECT udReportado.name AS nombreReportado, udReportado.lastName AS apellidoReportado, uReportado.email AS correoReportado,
        udReportador.name AS nombreReportador, udReportador.lastName AS apellidoReportador, uReportador.email AS correoReportador, 
        r.razonReporte, r.estadoReporte, r.idReporte, p.titulo AS tituloPublicacion
        FROM REPORTES r
        INNER JOIN USUARIODATOS udReportado ON r.userReportadoId = udReportado.userId
        INNER JOIN USUARIO uReportado ON udReportado.userId = uReportado.idUser
        INNER JOIN USUARIODATOS udReportador ON r.userReportadorId = udReportador.userId
        INNER JOIN USUARIO uReportador ON udReportador.userId = uReportador.idUser
        INNER JOIN PUBLICACIONES p ON r.publicacionId = p.idPublicaciones;";

$stmt = $pdo->query($sql);
$reportes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Enviar los datos de los reportes como respuesta JSON
echo json_encode($reportes);
?>
