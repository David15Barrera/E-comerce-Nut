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

        // Obtener los puntos del usuario desde la tabla de PUNTOS
        $sql_puntos = "SELECT Monto, Descripcion, fechaoObtencion FROM PUNTOS WHERE userId = :idUser";
        $stmt_puntos = $pdo->prepare($sql_puntos);
        $stmt_puntos->bindParam(':idUser', $idUser);

        if ($stmt_puntos->execute()) {
            $puntos = $stmt_puntos->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array("success" => true, "data" => $puntos));
        } else {
            // Error al obtener los puntos del usuario
            echo json_encode(array("success" => false, "message" => "Error al obtener los puntos del usuario"));
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
