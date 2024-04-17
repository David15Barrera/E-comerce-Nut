<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del cuerpo de la solicitud JSON
    $postData = json_decode(file_get_contents("php://input"));

    // Obtener los datos del objeto JSON
    $cantidad = $postData->cantidad;
    $total = $postData->total;
    $direccion = $postData->direccion;
    $pais = $postData->pais;
    $ciudad = $postData->ciudad;
    $codPostal = $postData->codPostal;
    $metodoPago = $postData->metodoPago;

    // Obtener el ID de usuario desde la sesión
    if (isset($_SESSION['correo'])) {
        include_once "connectionpdo.php"; // Incluir archivo de conexión a la base de datos

        $correo_usuario = $_SESSION['correo'];
        $sql_usuario = "SELECT idUser FROM USUARIO WHERE email = :correo_usuario";
        $stmt_usuario = $pdo->prepare($sql_usuario);
        $stmt_usuario->bindParam(':correo_usuario', $correo_usuario);

        if ($stmt_usuario->execute()) {
            $row_usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
            $userId = $row_usuario['idUser'];

            // Verificar si se paga por puntos y si el usuario tiene suficientes puntos
            if ($metodoPago === 'local') {
                $sql_puntos_totales = "SELECT puntosTotales FROM PUNTOS_TOTALES WHERE userId = :userId";
                $stmt_puntos_totales = $pdo->prepare($sql_puntos_totales);
                $stmt_puntos_totales->bindParam(':userId', $userId);

                if ($stmt_puntos_totales->execute()) {
                    $row_puntos_totales = $stmt_puntos_totales->fetch(PDO::FETCH_ASSOC);
                    $puntosTotales = $row_puntos_totales['puntosTotales'];

                    if ($puntosTotales >= $cantidad) {
                        // Restar puntos de la tabla PUNTOS_TOTALES
                        $nuevosPuntos = $puntosTotales - $cantidad;
                        $sql_actualizar_puntos = "UPDATE PUNTOS_TOTALES SET puntosTotales = :nuevosPuntos WHERE userId = :userId";
                        $stmt_actualizar_puntos = $pdo->prepare($sql_actualizar_puntos);
                        $stmt_actualizar_puntos->bindParam(':nuevosPuntos', $nuevosPuntos);
                        $stmt_actualizar_puntos->bindParam(':userId', $userId);

                        if ($stmt_actualizar_puntos->execute()) {
                            // Registrar en el historial de puntos
                            $sql_historial = "INSERT INTO HISTORIAL_PUNTOS (userId, puntosObtenidos, descripcion, fechaoObtencion) 
                                              VALUES (:userId, :cantidad, 'Resta por compra', NOW())";
                            $stmt_historial = $pdo->prepare($sql_historial);
                            $stmt_historial->bindParam(':userId', $userId);
                            $stmt_historial->bindParam(':cantidad', $cantidad);

                            if ($stmt_historial->execute()) {
                                // Insertar venta en la tabla VENTAS
                                $sql_venta = "INSERT INTO VENTAS (userId, cantidad, dateRegistro, timeRegistro, total, estado) 
                                              VALUES (:userId, :cantidad, CURDATE(), CURTIME(), :total, 'Entregado')";
                                $stmt_venta = $pdo->prepare($sql_venta);
                                $stmt_venta->bindParam(':userId', $userId);
                                $stmt_venta->bindParam(':cantidad', $cantidad);
                                $stmt_venta->bindParam(':total', $total);

                                if ($stmt_venta->execute()) {
                                    $ventasId = $pdo->lastInsertId(); // Obtener el ID de la venta recién insertada

                                    // Obtener los IDs de las publicaciones asociadas al carrito del usuario desde la base de datos
                                    $sql_carrito = "SELECT publicacionId FROM CARRITO WHERE userId = :userId";
                                    $stmt_carrito = $pdo->prepare($sql_carrito);
                                    $stmt_carrito->bindParam(':userId', $userId);

                                    if ($stmt_carrito->execute()) {
                                        $publicacionIds = $stmt_carrito->fetchAll(PDO::FETCH_COLUMN);

                                        // Insertar detalle de la transacción en la tabla DETALLETRANSACCIONES
                                        foreach ($publicacionIds as $publicacionId) {
                                            $sql_detalle = "INSERT INTO DETALLETRANSACCIONES (ventasid, publicacionesId, montoUnitario, moneda, direccionVenta, pais, ciudad, codPostal) 
                                                            VALUES (:ventasid, :publicacionId,:montoUnitario, 'local', :direccion, :pais, :ciudad, :codPostal)";
                                            $stmt_detalle = $pdo->prepare($sql_detalle);
                                            $stmt_detalle->bindParam(':ventasid', $ventasId);
                                            $stmt_detalle->bindParam(':publicacionId', $publicacionId);
                                            $stmt_detalle->bindParam(':montoUnitario', $total);
                                            $stmt_detalle->bindParam(':direccion', $direccion);
                                            $stmt_detalle->bindParam(':pais', $pais);
                                            $stmt_detalle->bindParam(':ciudad', $ciudad);
                                            $stmt_detalle->bindParam(':codPostal', $codPostal);

                                            $stmt_detalle->execute(); // Ejecutar la inserción
                                        }

                                        // Eliminar todos los productos del carrito del usuario
                                        $sql_eliminar_carrito = "DELETE FROM CARRITO WHERE userId = :userId";
                                        $stmt_eliminar_carrito = $pdo->prepare($sql_eliminar_carrito);
                                        $stmt_eliminar_carrito->bindParam(':userId', $userId);

                                        if ($stmt_eliminar_carrito->execute()) {
                                            echo json_encode(array("success" => true, "message" => "Venta registrada correctamente y carrito vaciado"));
                                        } else {
                                            echo json_encode(array("success" => false, "message" => "Error al vaciar el carrito"));
                                        }
                                    } else {
                                        echo json_encode(array("success" => false, "message" => "Error al obtener IDs de publicaciones del carrito"));
                                    }
                                } else {
                                    echo json_encode(array("success" => false, "message" => "Error al insertar venta"));
                                }
                            } else {
                                echo json_encode(array("success" => false, "message" => "Error al registrar en el historial de puntos"));
                            }
                        } else {
                            echo json_encode(array("success" => false, "message" => "Error al restar puntos"));
                        }
                    } else {
                        echo json_encode(array("success" => false, "message" => "No tienes suficientes puntos para realizar esta compra"));
                    }
                } else {
                    echo json_encode(array("success" => false, "message" => "Error al obtener puntos totales"));
                }
            } else {
                // Si el pago es en quetzales, no se realiza la verificación de puntos
                // Continuar con la inserción de la venta normalmente

                // Insertar venta en la tabla VENTAS
                $sql_venta = "INSERT INTO VENTAS (userId, cantidad, dateRegistro, timeRegistro, total, estado) 
                              VALUES (:userId, :cantidad, CURDATE(), CURTIME(), :total, 'Entregado')";
                $stmt_venta = $pdo->prepare($sql_venta);
                $stmt_venta->bindParam(':userId', $userId);
                $stmt_venta->bindParam(':cantidad', $cantidad);
                $stmt_venta->bindParam(':total', $total);

                if ($stmt_venta->execute()) {
                    $ventasId = $pdo->lastInsertId(); // Obtener el ID de la venta recién insertada

                    // Obtener los IDs de las publicaciones asociadas al carrito del usuario desde la base de datos
                    $sql_carrito = "SELECT publicacionId FROM CARRITO WHERE userId = :userId";
                    $stmt_carrito = $pdo->prepare($sql_carrito);
                    $stmt_carrito->bindParam(':userId', $userId);

                    if ($stmt_carrito->execute()) {
                        $publicacionIds = $stmt_carrito->fetchAll(PDO::FETCH_COLUMN);

                        // Insertar detalle de la transacción en la tabla DETALLETRANSACCIONES
                        foreach ($publicacionIds as $publicacionId) {
                            $sql_detalle = "INSERT INTO DETALLETRANSACCIONES (ventasid, publicacionesId, montoUnitario, moneda, direccionVenta, pais, ciudad, codPostal) 
                                            VALUES (:ventasid, :publicacionId,:montoUnitario, 'sistema', :direccion, :pais, :ciudad, :codPostal)";
                            $stmt_detalle = $pdo->prepare($sql_detalle);
                            $stmt_detalle->bindParam(':ventasid', $ventasId);
                            $stmt_detalle->bindParam(':publicacionId', $publicacionId);
                            $stmt_detalle->bindParam(':montoUnitario', $total);
                            $stmt_detalle->bindParam(':direccion', $direccion);
                            $stmt_detalle->bindParam(':pais', $pais);
                            $stmt_detalle->bindParam(':ciudad', $ciudad);
                            $stmt_detalle->bindParam(':codPostal', $codPostal);

                            $stmt_detalle->execute(); // Ejecutar la inserción
                        }

                        // Eliminar todos los productos del carrito del usuario
                        $sql_eliminar_carrito = "DELETE FROM CARRITO WHERE userId = :userId";
                        $stmt_eliminar_carrito = $pdo->prepare($sql_eliminar_carrito);
                        $stmt_eliminar_carrito->bindParam(':userId', $userId);
                        
                        if ($stmt_eliminar_carrito->execute()) {
                            // Agregar 50 puntos a la tabla PUNTOS_TOTALES
                            $sql_sumar_puntos = "UPDATE PUNTOS_TOTALES SET puntosTotales = puntosTotales + 50 WHERE userId = :userId";
                            $stmt_sumar_puntos = $pdo->prepare($sql_sumar_puntos);
                            $stmt_sumar_puntos->bindParam(':userId', $userId);
                        
                            if ($stmt_sumar_puntos->execute()) {
                                // Insertar registro en el historial de puntos
                                $sql_historial_puntos = "INSERT INTO HISTORIAL_PUNTOS (userId, puntosObtenidos, descripcion, fechaoObtencion) 
                                                         VALUES (:userId, 50, 'Adición de puntos por compra', NOW())";
                                $stmt_historial_puntos = $pdo->prepare($sql_historial_puntos);
                                $stmt_historial_puntos->bindParam(':userId', $userId);
                        
                                if ($stmt_historial_puntos->execute()) {
                                    echo json_encode(array("success" => true, "message" => "Venta registrada correctamente, carrito vaciado y 50 puntos agregados"));
                                } else {
                                    echo json_encode(array("success" => false, "message" => "Error al registrar los puntos en el historial"));
                                }
                            } else {
                                echo json_encode(array("success" => false, "message" => "Error al sumar los puntos"));
                            }
                        } else {
                            echo json_encode(array("success" => false, "message" => "Error al vaciar el carrito"));
                        }
                    } else {
                        echo json_encode(array("success" => false, "message" => "Error al obtener IDs de publicaciones del carrito"));
                    }
                } else {
                    echo json_encode(array("success" => false, "message" => "Error al insertar venta"));
                }
            }
        } else {
            echo json_encode(array("success" => false, "message" => "Error al obtener ID de usuario"));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "No se ha iniciado sesión"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "No se ha enviado el formulario"));
}
?>
