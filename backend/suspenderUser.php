<?php
// Verificar si se recibió un ID de reporte válido
if (isset($_POST['reportId'])) {
    $reportId = $_POST['reportId'];

    // Incluir el archivo de conexión a la base de datos
    require_once 'connectionpdo.php'; // Ajusta la ruta según la ubicación de tu archivo de conexión

    // Cambiar el estado del reporte a "resuelto" en la base de datos
    $sql = "UPDATE REPORTES SET estadoReporte = 'resuelto' WHERE idReporte = :reportId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':reportId', $reportId, PDO::PARAM_INT);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Enviar una respuesta JSON indicando que el cambio se realizó con éxito
        echo json_encode(array("success" => true, "message" => "El estado del reporte se ha cambiado correctamente."));
    } else {
        // Enviar una respuesta JSON indicando que ocurrió un error al cambiar el estado del reporte
        echo json_encode(array("success" => false, "message" => "Error al cambiar el estado del reporte."));
    }
} else {
    // Si no se proporcionó un ID de reporte válido, enviar una respuesta JSON de error
    echo json_encode(array("success" => false, "message" => "ID de reporte no proporcionado."));
}
?>
