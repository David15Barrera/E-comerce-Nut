<?php
session_start();

if (isset($_SESSION['correo'])) {
    include_once "connectionpdo.php"; // Incluir archivo de conexión a la base de datos

    // Obtener el ID del producto desde el formulario
    $productId = $_GET['id'];

    // Obtener información de las personas inscritas en el servicio
    $sql_inscritos = "SELECT UD.name, UD.lastName, P.puntos, S.estado, S.idServicio 
    FROM SERVICIOS S 
    INNER JOIN USUARIO U ON S.userId = U.idUser 
    INNER JOIN USUARIODATOS UD ON U.idUser = UD.userId 
    INNER JOIN PUBLICACIONES P ON S.idPublicacion = P.idPublicaciones
    WHERE S.idPublicacion = :productId";

    $stmt_inscritos = $pdo->prepare($sql_inscritos);
    $stmt_inscritos->bindParam(':productId', $productId);
    
    if ($stmt_inscritos->execute()) {
        $inscritos = $stmt_inscritos->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array("success" => true, "inscritos" => $inscritos));
    } else {
        echo json_encode(array("success" => false, "message" => "Error al obtener la lista de inscritos"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "No se ha iniciado sesión"));
}
?>
