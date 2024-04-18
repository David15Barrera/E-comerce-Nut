<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['correo'])) {
    // Incluir el archivo de conexión a la base de datos
    include_once "connectionpdo.php"; // Asegúrate de cambiar esto al nombre correcto de tu archivo de conexión

    // Obtener el ID del usuario utilizando su correo electrónico
    $correo_usuario = $_SESSION['correo'];
    $sql_usuario = "SELECT idUser FROM USUARIO WHERE email = :correo_usuario";
    $stmt_usuario = $pdo->prepare($sql_usuario);
    $stmt_usuario->bindParam(':correo_usuario', $correo_usuario);

    if ($stmt_usuario->execute()) {
        $row_usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
        $idUser = $row_usuario['idUser'];

        // Consultar las ventas del usuario
        $sql_ventas = "SELECT p.FechaExpiracion, p.titulo, p.tipo, p.precioSistema, p.precioLocal, s.duracion, s.estado 
                       FROM SERVICIOS s 
                       INNER JOIN PUBLICACIONES p ON s.idPublicacion = p.idPublicaciones 
                       WHERE s.userId = :idUser";
        $stmt_ventas = $pdo->prepare($sql_ventas);
        $stmt_ventas->bindParam(':idUser', $idUser);

        if ($stmt_ventas->execute()) {
            $ventas = $stmt_ventas->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array("success" => true, "data" => $ventas));
        } else {
            // Error al obtener las ventas del usuario
            echo json_encode(array("success" => false, "message" => "Error al obtener las ventas del usuario"));
        }
    } else {
        // Error al obtener el ID del usuario
        echo json_encode(array("success" => false, "message" => "Error al obtener el ID del usuario"));
    }
} else {
    // La sesión del usuario no está iniciada
    echo json_encode(array("success" => false, "message" => "No se ha iniciado sesión"));
}
?>
