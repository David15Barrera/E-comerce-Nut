<?php
session_start();

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID de la publicación desde el formulario
    $publicacionId = $_POST['idProducto'];
    // Obtener el mensaje desde el formulario
    $mensaje = $_POST['mensaje'];
    error_log("idProducto recibido: " . $publicacionId);
    error_log("Mensaje recibido: " . $mensaje);

    // Obtener el ID del usuario emisor desde la sesión
    if (isset($_SESSION['correo'])) {
        // Incluir el archivo de conexión a la base de datos
        include_once "connectionpdo.php"; // Asegúrate de cambiar esto al nombre correcto de tu archivo de conexión
        
        // Obtener el ID del usuario emisor utilizando su correo electrónico
        $correo_emisor = $_SESSION['correo'];
        $sql_emisor = "SELECT idUser FROM USUARIO WHERE email = :correo_emisor";
        $stmt_emisor = $pdo->prepare($sql_emisor);
        $stmt_emisor->bindParam(':correo_emisor', $correo_emisor);
        
        if ($stmt_emisor->execute()) {
            $row_emisor = $stmt_emisor->fetch(PDO::FETCH_ASSOC);
            $emisorId = $row_emisor['idUser'];
            
            // Obtener el ID del usuario receptor (dueño de la publicación) directamente desde la tabla de PUBLICACIONES
            $sql_receptor = "SELECT userId FROM PUBLICACIONES WHERE idPublicaciones = :publicacionId";
            $stmt_receptor = $pdo->prepare($sql_receptor);
            $stmt_receptor->bindParam(':publicacionId', $publicacionId);
            if ($stmt_receptor->execute()) {
                $row_receptor = $stmt_receptor->fetch(PDO::FETCH_ASSOC);
                $receptorId = $row_receptor['userId'];
                
                // Insertar el mensaje en la tabla de chats
                $sql_insert = "INSERT INTO CHATS (publicacionesId, emisor, receptor, mensaje, timeMessage) VALUES (:publicacionId, :emisorId, :receptorId, :mensaje, NOW())";
                $stmt_insert = $pdo->prepare($sql_insert);
                $stmt_insert->bindParam(':publicacionId', $publicacionId);
                $stmt_insert->bindParam(':emisorId', $emisorId);
                $stmt_insert->bindParam(':receptorId', $receptorId);
                $stmt_insert->bindParam(':mensaje', $mensaje);
                
                if (!$stmt_insert->execute()) {
                    error_log("Error al ejecutar la consulta SQL para insertar el mensaje: " . print_r($stmt_insert->errorInfo(), true));
                    echo json_encode(array("success" => false, "message" => "Error al enviar el mensaje"));
                } else {
                    echo json_encode(array("success" => true, "message" => "Mensaje enviado correctamente"));
                }
            } else {
                // No se pudo obtener el ID del usuario receptor
                echo json_encode(array("success" => false, "message" => "Error al obtener el ID del usuario receptor"));
            }
        } else {
            // No se pudo obtener el ID del usuario emisor
            echo json_encode(array("success" => false, "message" => "Error al obtener el ID del usuario emisor"));
        }
    } else {
        // La sesión del usuario no está iniciada
        echo json_encode(array("success" => false, "message" => "No se ha iniciado sesión"));
    }
} else {
    // El formulario no ha sido enviado
    echo json_encode(array("success" => false, "message" => "No se ha enviado el formulario"));
}
?>
