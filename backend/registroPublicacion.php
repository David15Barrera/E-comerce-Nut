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
    $precioLocal = $_POST['precioLocal'];
    $cantidadDisponible = $_POST['cantidadDisponible'];
    $pais = $_POST['pais'];
    $ciudad = $_POST['ciudad'];
    
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

            // Buscar si la ubicación ya existe en la tabla de ubicaciones
            $sql_buscar_ubicacion = "SELECT idUbicacion FROM UBICACION WHERE pais = :pais AND ciudad = :ciudad";
            $stmt_buscar_ubicacion = $pdo->prepare($sql_buscar_ubicacion);
            $stmt_buscar_ubicacion->bindParam(':pais', $pais);
            $stmt_buscar_ubicacion->bindParam(':ciudad', $ciudad);
            $stmt_buscar_ubicacion->execute();
            
            $fila_ubicacion = $stmt_buscar_ubicacion->fetch(PDO::FETCH_ASSOC);
            
            if ($fila_ubicacion) {
                // Si la ubicación ya existe, obtenemos su ID
                $idUbicacion = $fila_ubicacion['idUbicacion'];
            } else {
                // Si la ubicación no existe, la insertamos y obtenemos su ID
                $sql_insertar_ubicacion = "INSERT INTO UBICACION (pais, ciudad) VALUES (:pais, :ciudad)";
                $stmt_insertar_ubicacion = $pdo->prepare($sql_insertar_ubicacion);
                $stmt_insertar_ubicacion->bindParam(':pais', $pais);
                $stmt_insertar_ubicacion->bindParam(':ciudad', $ciudad);
                $stmt_insertar_ubicacion->execute();
                
                $idUbicacion = $pdo->lastInsertId();
            }

            // Insertar datos en la tabla de publicaciones
            $sql = "INSERT INTO PUBLICACIONES (userId, idUbicacion, Tipo, titulo, Descripcion, categoria, estado, Imagen, precioSistema, precioLocal, cantidadDisponible, FechaPublicacion, FechaExpiracion, puntos) 
                    VALUES ((SELECT idUser FROM USUARIO WHERE email = :correo_usuario), :idUbicacion, :Tipo, :titulo, :Descripcion, :categoria, :estado, :imagen, :precioSistema, :precioLocal, :cantidadDisponible, NOW(), NOW() + INTERVAL 1 MONTH, :puntos)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':correo_usuario', $correo_usuario);
            $stmt->bindParam(':idUbicacion', $idUbicacion);
            $stmt->bindParam(':Tipo', $tipo);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':Descripcion', $descripcion);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindValue(':estado', 'PENDIENTE'); // Estado predeterminado
            $stmt->bindParam(':imagen', $ruta_imagen);
            $stmt->bindParam(':precioSistema', $precioSistema);
            $stmt->bindParam(':precioLocal', $precioLocal);
            $stmt->bindParam(':cantidadDisponible', $cantidadDisponible);
            $stmt->bindValue(':puntos', ($precioSistema * 10)); // Convertir precioSistema a puntos (1 Quetzal = 10 NutPoints)
 
            // Ejecutar la declaración
            if ($stmt->execute()) {
                 // Mostrar alerta de éxito
                // Redireccionar después de la inserción exitosa
                echo "<script>window.location.href = '../frontend/views/comun/publicacion.html';</script>";
                echo "<script>alert('¡El producto se creó con éxito!');</script>";
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
    echo "No funcionó";
}
?>