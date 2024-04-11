<?php
session_start();

// Habilitar la visualización de errores de PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);




    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Resto del código para obtener y validar otros campos del formulario
        $titulo = $_POST['product-title'];
        $descripcion = $_POST['product-description'];
        $tipo = "Productos";
        $categoria = $_POST['product-Categoria'];
        $precioSistema = $_POST['product-price'];
        $precioLocal = $_POST['product-precioLocal'];
        $cantidadDisponible = $_POST['product-cantidadDisponible'];
        $estado = "PENDIENTE";
        $idProducto = $_POST['idProducto'];

        var_dump($idProducto);
        // Obtener el correo del usuario de la sesión
        $correo_usuario = $_SESSION['correo'];

        // Incluir archivo de configuración de la base de datos
        include_once "connectionpdo.php"; // Asegúrate de cambiar esto al nombre correcto de tu archivo de configuración

        // Verificar si se subió una nueva imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen_temporal = $_FILES['imagen']['tmp_name'];
            $nombre_imagen = $_FILES['imagen']['name'];
            $ruta_imagen = '../backend/img/' . $nombre_imagen; // Cambia esto por la ruta donde quieras guardar la imagen

            // Mover la imagen del directorio temporal al directorio de destino
            if (move_uploaded_file($imagen_temporal, $ruta_imagen)) {
                // Actualizar la imagen en la base de datos
                $sql = "UPDATE PUBLICACIONES 
                SET titulo = :titulo, Descripcion = :descripcion, categoria = :categoria, estado =:estado, Imagen = :imagen, precioSistema = :precioSistema, precioLocal = :precioLocal, cantidadDisponible = :cantidadDisponible
                WHERE idPublicaciones = :idProducto";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':titulo', $titulo);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':categoria', $categoria);
                $stmt->bindParam(':estado', $estado);
                $stmt->bindParam(':imagen', $ruta_imagen);
                $stmt->bindParam(':precioSistema', $precioSistema);
                $stmt->bindParam(':precioLocal', $precioLocal);
                $stmt->bindParam(':cantidadDisponible', $cantidadDisponible);
                $stmt->bindParam(':idProducto', $idProducto);
    
                // Ejecutar la declaración
                if ($stmt->execute()) {
                    // Mostrar alerta de éxito
                    // Redireccionar después de la actualización exitosa
                    echo "<script>window.location.href = '../frontend/views/comun/editProd.html';</script>";
                    echo "<script>alert('¡El producto se actualizó con éxito!');</script>";
                    exit();
                } else {
                    // Mostrar mensaje de error si la actualización falla
                    echo "Error al actualizar los datos del producto en la base de datos.";
                    error_log($error_message, 3, 'errores.log');
                    echo "Se ha producido un error. Por favor, inténtalo de nuevo más tarde.";
                }
            } else {
                echo "Error al mover la imagen al servidor.";
                error_log($error_message, 3, 'errores.log');
            }
        } else {
            // No se subió una nueva imagen, solo actualizar los demás campos
            $sql = "UPDATE PUBLICACIONES 
                    SET titulo = :titulo, Descripcion = :descripcion, categoria = :categoria, estado =:estado, precioSistema = :precioSistema, precioLocal = :precioLocal, cantidadDisponible = :cantidadDisponible
                    WHERE idPublicaciones = :idProducto";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':precioSistema', $precioSistema);
            $stmt->bindParam(':precioLocal', $precioLocal);
            $stmt->bindParam(':cantidadDisponible', $cantidadDisponible);
            $stmt->bindParam(':idProducto', $idProducto);
    
            // Ejecutar la declaración
            if ($stmt->execute()) {
                // Mostrar alerta de éxito
                // Redireccionar después de la actualización exitosa
                echo "<script>window.location.href = '../frontend/views/comun/editProd.html';</script>";
                echo "<script>alert('¡El producto se actualizó con éxito!');</script>";
                exit();
            } else {
                // Mostrar mensaje de error si la actualización falla
                echo "Error al actualizar los datos del producto en la base de datos.";
                error_log($error_message, 3, 'errores.log');
                echo "Se ha producido un error. Por favor, inténtalo de nuevo más tarde.";
            }
        }
    } else {
        // Si no se ha enviado el formulario, redirigir a alguna página apropiada
        echo "No funcionó";
    }
?>
