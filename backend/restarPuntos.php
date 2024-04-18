<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['correo'])) {
    // Incluir el archivo de conexión a la base de datos
    require_once 'connectionpdo.php'; // Ajusta la ruta según la ubicación de tu archivo de conexión

    // Obtener el correo electrónico del usuario de la sesión
    $correo = $_SESSION['correo'];

    // Verificar si se recibió una cantidad válida para retirar
    if (isset($_POST['amount'])) {
        $amount = intval($_POST['amount']);

        // Obtener los puntos totales del usuario desde la base de datos
        $sqlPuntosTotales = "SELECT puntosTotales FROM PUNTOS_TOTALES WHERE userId = (SELECT idUser FROM USUARIO WHERE email = :correo)";
        $stmtPuntosTotales = $pdo->prepare($sqlPuntosTotales);
        $stmtPuntosTotales->bindParam(':correo', $correo);
        if ($stmtPuntosTotales->execute()) {
            $rowPuntosTotales = $stmtPuntosTotales->fetch(PDO::FETCH_ASSOC);
            if ($rowPuntosTotales) {
                $puntosTotales = intval($rowPuntosTotales['puntosTotales']);

                // Verificar si el usuario tiene suficientes puntos para retirar
                if ($amount <= $puntosTotales) {
                    // Calcular los nuevos puntos totales después del retiro
                    $nuevosPuntosTotales = $puntosTotales - $amount;

                    // Actualizar los puntos totales del usuario en la base de datos
                    $sqlActualizarPuntos = "UPDATE PUNTOS_TOTALES SET puntosTotales = :nuevosPuntosTotales WHERE userId = (SELECT idUser FROM USUARIO WHERE email = :correo)";
                    $stmtActualizarPuntos = $pdo->prepare($sqlActualizarPuntos);
                    $stmtActualizarPuntos->bindParam(':nuevosPuntosTotales', $nuevosPuntosTotales, PDO::PARAM_INT);
                    $stmtActualizarPuntos->bindParam(':correo', $correo);

                    // Registrar el retiro en el historial de puntos
                    $descripcion = "Retiro de puntos";
                    $fechaRetiro = date('Y-m-d H:i:s');
                    $sqlRegistrarHistorial = "INSERT INTO HISTORIAL_PUNTOS (userId, puntosObtenidos, descripcion, fechaoObtencion) VALUES ((SELECT idUser FROM USUARIO WHERE email = :correo), :amount, :descripcion, :fechaRetiro)";
                    $stmtRegistrarHistorial = $pdo->prepare($sqlRegistrarHistorial);
                    $stmtRegistrarHistorial->bindParam(':correo', $correo);
                    $stmtRegistrarHistorial->bindParam(':amount', $amount, PDO::PARAM_INT);
                    $stmtRegistrarHistorial->bindParam(':descripcion', $descripcion);
                    $stmtRegistrarHistorial->bindParam(':fechaRetiro', $fechaRetiro);

                    // Ejecutar las consultas SQL dentro de una transacción
                    try {
                        $pdo->beginTransaction();

                        // Actualizar los puntos totales del usuario
                        $stmtActualizarPuntos->execute();

                        // Registrar el retiro en el historial de puntos
                        $stmtRegistrarHistorial->execute();

                        // Confirmar la transacción
                        $pdo->commit();

                        // Enviar una respuesta de éxito
                        echo json_encode(array("success" => true, "message" => "Retiro de puntos exitoso"));
                    } catch (PDOException $e) {
                        // Si ocurre un error, revertir la transacción y mostrar un mensaje de error
                        $pdo->rollBack();
                        echo json_encode(array("success" => false, "message" => "Error al realizar el retiro de puntos: " . $e->getMessage()));
                    }
                } else {
                    // Si el usuario intenta retirar más puntos de los que tiene
                    echo json_encode(array("success" => false, "message" => "No tienes suficientes puntos para realizar este retiro"));
                }
            } else {
                // Si no se encontraron puntos totales para el usuario
                echo json_encode(array("success" => false, "message" => "No se encontraron puntos totales para este usuario"));
            }
        } else {
            // Si hay un error al obtener los puntos totales
            echo json_encode(array("success" => false, "message" => "Error al obtener los puntos totales del usuario"));
        }
    } else {
        // Si no se proporcionó una cantidad para retirar
        echo json_encode(array("success" => false, "message" => "Cantidad de puntos para retirar no proporcionada"));
    }
} else {
    // Si el usuario no ha iniciado sesión
    echo json_encode(array("success" => false, "message" => "No se ha iniciado sesión"));
}
?>
