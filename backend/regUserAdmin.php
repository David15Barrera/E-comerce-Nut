<?php
// Incluir el archivo de conexión
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $correo = $_POST["correo"];
    $dpi = $_POST["dpi"];
    $contraseña = $_POST["pass"];
    $cargo = $_POST["cargo"];
    $estatus = "activo";

    // Insertar el nuevo usuario en la tabla USUARIO
    $sql_usuario = "INSERT INTO USUARIO (email, password, rol, estatus) VALUES ('$correo', '$contraseña', '$cargo', '$estatus')";
    if (mysqli_query($conn, $sql_usuario)) {
        // Obtener el ID del usuario insertado
        $userId = mysqli_insert_id($conn);

        // Definir valores predeterminados para algunos campos
        $nombre = "ninguno";
        $lastname = "ninguno";
        $nit = "C/F";
        $celular = "00000000";
        $direccion = "ciudad"; // Valor predeterminado para dirección
        $genero = "otro"; // Valor predeterminado para género
        $fechaRegistro = date("Y-m-d"); // Fecha de registro

        // Insertar datos adicionales del usuario en la tabla USUARIODATOS
        $sql_usuario_datos = "INSERT INTO USUARIODATOS (userId, name, lastname, dpiUser, nitUserDatos, direccionUser, telefonoUser, genero, dateRegistro) VALUES ($userId, '$nombre', '$lastname', '$dpi', '$nit', '$direccion', '$celular', '$genero', '$fechaRegistro')";
        
        if (mysqli_query($conn, $sql_usuario_datos)) {
            // Mostrar un mensaje de éxito
            echo "Usuario agregado exitosamente.";
            // Recargar la página
            echo "<script>window.location.href = '../frontend/views/admin/AgregarUser.html';</script>";
        } else {
            echo "Error: " . $sql_usuario_datos . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error: " . $sql_usuario . "<br>" . mysqli_error($conn);
    }
}

// Cerrar la conexión
mysqli_close($conn);
?>