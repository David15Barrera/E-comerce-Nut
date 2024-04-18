<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del producto desde el formulario
    $productId = $_POST['productId'];

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

            // Verificar si el usuario ya está inscrito en este servicio
            $sql_verificar_inscripcion = "SELECT COUNT(*) AS count FROM SERVICIOS WHERE idPublicacion = :productId AND userId = :userId";
            $stmt_verificar_inscripcion = $pdo->prepare($sql_verificar_inscripcion);
            $stmt_verificar_inscripcion->bindParam(':productId', $productId);
            $stmt_verificar_inscripcion->bindParam(':userId', $userId);
            $stmt_verificar_inscripcion->execute();
            $inscrito = $stmt_verificar_inscripcion->fetch(PDO::FETCH_ASSOC)['count'];

            if ($inscrito > 0) {
                echo json_encode(array("success" => false, "message" => "Ya estás inscrito en este servicio"));
            } else {
                // Insertar la inscripción en la tabla de servicios
                $sql_inscripcion = "INSERT INTO SERVICIOS (idPublicacion, userId, duracion, estado) VALUES (:productId, :userId, :duracion, :estado)";
                $stmt_inscripcion = $pdo->prepare($sql_inscripcion);
                $duracion = '1 dia'; // Aquí debes definir la duración del servicio
                $estado = 'Pendiente'; // El estado inicial del servicio puede ser 'Pendiente' u otro según tu lógica
                $stmt_inscripcion->bindParam(':productId', $productId);
                $stmt_inscripcion->bindParam(':userId', $userId);
                $stmt_inscripcion->bindParam(':duracion', $duracion);
                $stmt_inscripcion->bindParam(':estado', $estado);

                if ($stmt_inscripcion->execute()) {
                    // Restar uno a la cantidad de la tabla de publicaciones
                    $sql_restar_cantidad = "UPDATE PUBLICACIONES SET cantidadDisponible = cantidadDisponible - 1 WHERE idPublicaciones = :productId";
                    $stmt_restar_cantidad = $pdo->prepare($sql_restar_cantidad);
                    $stmt_restar_cantidad->bindParam(':productId', $productId);
                    $stmt_restar_cantidad->execute();

                    echo json_encode(array("success" => true, "message" => "Te has inscrito exitosamente en este servicio"));
                } else {
                    echo json_encode(array("success" => false, "message" => "Error al inscribirse en el servicio"));
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
