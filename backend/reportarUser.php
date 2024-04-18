<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['correo'])) {
    // Incluir el archivo de conexión a la base de datos
    require_once 'connectionpdo.php'; // Ajusta la ruta según la ubicación de tu archivo de conexión

    // Obtener el ID del usuario reportador
    $correoReportador = $_SESSION['correo'];
    $sqlReportador = "SELECT idUser FROM USUARIO WHERE email = :correo";
    $stmtReportador = $pdo->prepare($sqlReportador);
    $stmtReportador->bindParam(':correo', $correoReportador);
    $stmtReportador->execute();
    $rowReportador = $stmtReportador->fetch(PDO::FETCH_ASSOC);
    $idUserReportador = $rowReportador['idUser'];

    // Verificar si se recibieron los datos del formulario
    if (isset($_POST['publicacionId']) && isset($_POST['userReportadoId']) && isset($_POST['razonReporte'])) {
        $publicacionId = $_POST['publicacionId'];
        $userReportadoId = $_POST['userReportadoId'];
        $razonReporte = $_POST['razonReporte'];
        $estadoReporte = 'pendiente'; // Estado inicial del reporte

        // Insertar el reporte en la base de datos
        $sqlInsertarReporte = "INSERT INTO REPORTES (userReportadoId, userReportadorId, publicacionId, razonReporte, estadoReporte) VALUES (:userReportadoId, :idUserReportador, :publicacionId, :razonReporte, :estadoReporte)";
        $stmtInsertarReporte = $pdo->prepare($sqlInsertarReporte);
        $stmtInsertarReporte->bindParam(':userReportadoId', $userReportadoId);
        $stmtInsertarReporte->bindParam(':idUserReportador', $idUserReportador);
        $stmtInsertarReporte->bindParam(':publicacionId', $publicacionId);
        $stmtInsertarReporte->bindParam(':razonReporte', $razonReporte);
        $stmtInsertarReporte->bindParam(':estadoReporte', $estadoReporte);

        if ($stmtInsertarReporte->execute()) {
            // Éxito al insertar el reporte
            echo json_encode(array("success" => true, "message" => "Reporte insertado correctamente"));
        } else {
            // Error al insertar el reporte
            echo json_encode(array("success" => false, "message" => "Error al insertar el reporte"));
        }
    } else {
        // Si no se recibieron los datos del formulario
        echo json_encode(array("success" => false, "message" => "Datos de reporte no proporcionados"));
    }
} else {
    // Si el usuario no ha iniciado sesión
    echo json_encode(array("success" => false, "message" => "No se ha iniciado sesión"));
}
?>
