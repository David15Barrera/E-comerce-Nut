<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    echo "El formulario se envió correctamente. Nombre: $nombre";
} else {
    echo "Error: Método de solicitud no válido.";
}

?>
