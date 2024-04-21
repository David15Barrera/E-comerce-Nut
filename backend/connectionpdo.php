<!-- Hay dos conneciones porque queria probar otra estructura durnate la creacion de esta aplicacion solo porque si xD-->

<?php
$servername = "localhost:3306"; // Cambia esto si tu servidor MySQL no está en localhost
$username = "nombre_base_datos"; // Reemplaza con tu nombre de usuario de MySQL
$password = "Contraseña_base_datos"; // Reemplaza con tu contraseña de MySQL
$database = "ECOMARCEDB"; // Reemplaza con el nombre de tu base de datos

// Intentar establecer la conexión usando PDO
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Habilitar el modo de errores de PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Si hay un error al conectar, mostrar el mensaje de error
    die("Conexión fallida: " . $e->getMessage());
}
?>
