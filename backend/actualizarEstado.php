<?php
// Verificar si se recibió un ID de servicio y un estado válido
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['idServicio']) && isset($data['estado'])) {
    $idServicio = $data['idServicio'];
    $estado = $data['estado'];

    // Conectarse a la base de datos (suponiendo que ya tienes la conexión establecida)
    require_once 'connectionpdo.php'; // Ajusta la ruta según la ubicación de tu archivo de conexión

    // Verificar si el estado es "Asistió" o "Abandono"
    if ($estado == 'Asistio' || $estado == 'Abandono') {
        // Consultar el estado actual del servicio en la base de datos
        $sqlEstadoActual = "SELECT estado FROM SERVICIOS WHERE idServicio = :idServicio";
        $stmtEstadoActual = $pdo->prepare($sqlEstadoActual);
        $stmtEstadoActual->bindParam(':idServicio', $idServicio);
        $stmtEstadoActual->execute();
        $rowEstadoActual = $stmtEstadoActual->fetch(PDO::FETCH_ASSOC);

        if ($rowEstadoActual) {
            $estadoActual = $rowEstadoActual['estado'];

            // Verificar si el estado actual es "Pendiente"
            if ($estadoActual == 'Pendiente') {
                // Actualizar el estado del servicio en la base de datos
                $sqlActualizarEstado = "UPDATE SERVICIOS SET estado = :estado WHERE idServicio = :idServicio";
                $stmtActualizarEstado = $pdo->prepare($sqlActualizarEstado);
                $stmtActualizarEstado->bindParam(':estado', $estado);
                $stmtActualizarEstado->bindParam(':idServicio', $idServicio);

                if ($stmtActualizarEstado->execute()) {
                    // Obtener el ID de la publicación asociada al servicio
                    $sqlPublicacion = "SELECT idPublicacion FROM SERVICIOS WHERE idServicio = :idServicio";
                    $stmtPublicacion = $pdo->prepare($sqlPublicacion);
                    $stmtPublicacion->bindParam(':idServicio', $idServicio);
                    $stmtPublicacion->execute();
                    $rowPublicacion = $stmtPublicacion->fetch(PDO::FETCH_ASSOC);

                    if ($rowPublicacion) {
                        $idPublicacion = $rowPublicacion['idPublicacion'];

                        // Obtener los puntos asociados a la publicación
                        $sqlPuntosPublicacion = "SELECT puntos FROM PUBLICACIONES WHERE idPublicaciones = :idPublicacion";
                        $stmtPuntosPublicacion = $pdo->prepare($sqlPuntosPublicacion);
                        $stmtPuntosPublicacion->bindParam(':idPublicacion', $idPublicacion);
                        $stmtPuntosPublicacion->execute();
                        $rowPuntosPublicacion = $stmtPuntosPublicacion->fetch(PDO::FETCH_ASSOC);

                        if ($rowPuntosPublicacion) {
                            $puntosGanados = $rowPuntosPublicacion['puntos'];

                            // Obtener el ID del usuario asociado al servicio
                            $sqlUserId = "SELECT userId FROM SERVICIOS WHERE idServicio = :idServicio";
                            $stmtUserId = $pdo->prepare($sqlUserId);
                            $stmtUserId->bindParam(':idServicio', $idServicio);
                            $stmtUserId->execute();
                            $rowUserId = $stmtUserId->fetch(PDO::FETCH_ASSOC);

                            if ($rowUserId) {
                                $userId = $rowUserId['userId'];

                                // Actualizar los puntos totales del usuario en la tabla PUNTOS_TOTALES
                                $sqlActualizarPuntos = "UPDATE PUNTOS_TOTALES SET puntosTotales = puntosTotales + :puntosGanados WHERE userId = :userId";
                                $stmtActualizarPuntos = $pdo->prepare($sqlActualizarPuntos);
                                $stmtActualizarPuntos->bindParam(':puntosGanados', $puntosGanados);
                                $stmtActualizarPuntos->bindParam(':userId', $userId);
                                $stmtActualizarPuntos->execute();

                                // Registrar el historial de puntos en la tabla HISTORIAL_PUNTOS
                                $descripcion = "Puntos ganados por servicio";
                                $fechaObtencion = date('Y-m-d H:i:s');
                                $sqlRegistrarHistorial = "INSERT INTO HISTORIAL_PUNTOS (userId, puntosObtenidos, descripcion, fechaoObtencion) VALUES (:userId, :puntosGanados, :descripcion, :fechaObtencion)";
                                $stmtRegistrarHistorial = $pdo->prepare($sqlRegistrarHistorial);
                                $stmtRegistrarHistorial->bindParam(':userId', $userId);
                                $stmtRegistrarHistorial->bindParam(':puntosGanados', $puntosGanados);
                                $stmtRegistrarHistorial->bindParam(':descripcion', $descripcion);
                                $stmtRegistrarHistorial->bindParam(':fechaObtencion', $fechaObtencion);
                                $stmtRegistrarHistorial->execute();
                            }
                        }
                    }

                    echo json_encode(array("success" => true, "message" => "Estado actualizado correctamente"));
                } else {
                    echo json_encode(array("success" => false, "message" => "Error al actualizar el estado"));
                }
            } else {
                // El estado del servicio ya ha sido cambiado anteriormente
                echo json_encode(array("success" => false, "message" => "El estado del servicio ya ha sido actualizado"));
            }
        } else {
            // No se encontró ningún servicio con el ID proporcionado
            echo json_encode(array("success" => false, "message" => "No se encontró ningún servicio con el ID proporcionado"));
        }
    } else {
        // El estado proporcionado no es válido
        echo json_encode(array("success" => false, "message" => "El estado proporcionado no es válido"));
    }
} else {
    // Falta el ID de servicio o el estado
    echo json_encode(array("success" => false, "message" => "ID de servicio o estado faltante"));
}
?>
