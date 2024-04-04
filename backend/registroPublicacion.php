<?php
session_start();

// Habilitar la visualización de errores de PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Resto del código para obtener y validar otros campos del formulario
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $tipo = $_POST['tipo'];
    $categoria = $_POST['categoria'];
    $precioSistema = $_POST['precioSistema'];
    $precioSistema = $_POST['precioSistema'];
    $precioLocal = $_POST['precioLocal'];
    $cantidadDisponible = $_POST['cantidadDisponible'];
    $ubicacion = $_POST['ubicacion'];

    // Manejo de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen_temporal = $_FILES['imagen']['tmp_name'];
        $nombre_imagen = $_FILES['imagen']['name'];
        $ruta_imagen = '../backend/img/' . $nombre_imagen; // Cambia esto por la ruta donde quieras guardar la imagen

        // Mover la imagen del directorio temporal al directorio de destino
        if (move_uploaded_file($imagen_temporal, $ruta_imagen)) {
            // Obtener el correo del usuario de la sesión
            $correo_usuario = $_SESSION['correo'];

            // Incluir archivo de configuración de la base de datos
            include_once "connectionpdo.php"; // Asegúrate de cambiar esto al nombre correcto de tu archivo de configuración

            // Insertar datos en la base de datos
            $sql = "INSERT INTO PUBLICACIONES (userId, Tipo, titulo, Descripcion, categoria, estado, precioSistema, precioLocal, cantidadDisponible, ubicacion, imagen, FechaPublicacion, FechaExpiracion, puntos) 
                    VALUES ((SELECT idUser FROM USUARIO WHERE email = :correo_usuario), :Tipo, :titulo, :Descripcion, :categoria, :estado, :precioSistema, :precioLocal, :cantidadDisponible, :ubicacion, :imagen, NOW(), NOW() + INTERVAL 1 MONTH, :puntos)";

            // Preparar la declaración
            $stmt = $pdo->prepare($sql);

            // Enlazar parámetros
            $stmt->bindParam(':correo_usuario', $correo_usuario);
            $stmt->bindParam(':Tipo', $tipo);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':Descripcion', $descripcion);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindValue(':estado', 'PENDIENTE'); // Estado predeterminado
            $stmt->bindParam(':precioSistema', $precioSistema);
            $stmt->bindParam(':precioLocal', $precioLocal);
            $stmt->bindParam(':cantidadDisponible', $cantidadDisponible);
            $stmt->bindParam(':ubicacion', $ubicacion);
            $stmt->bindParam(':imagen', $ruta_imagen);
            $stmt->bindValue(':puntos', ($precioSistema * 10)); // Convertir precioSistema a puntos (1 Quetzal = 10 NutPoints)
 
            // Ejecutar la declaración
            if ($stmt->execute()) {
                // Redireccionar después de la inserción exitosa
                echo "<script>window.location.href = '../frontend/views/comun/publicacion.html';</script>";
                exit();
            } else {
                // Mostrar mensaje de error si la inserción falla
                echo "Error al guardar la publicación en la base de datos.". $_FILES['imagen']['error'];
                error_log($error_message, 3, 'errores.log');
                echo "Se ha producido un error. Por favor, inténtalo de nuevo más tarde.";
            }
        } else {
            echo "Error al mover la imagen al servidor.". $_FILES['imagen']['error'];
            error_log($error_message, 3, 'errores.log');

        }
    } else {
        echo "Error al subir la imagen.";
    }
} else {
    // Si no se ha enviado el formulario, redirigir a alguna página apropiada
    echo "No funciono";
}
?>