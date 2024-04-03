<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['correo'])) {
    header("Location: login.html"); // Redirigir a la página de inicio de sesión si el usuario no está logueado
    exit();
}

include_once "connection.php";

$correo = $_SESSION['correo'];

// Obtener información del usuario desde el formulario y otros campos
// Obtener información del usuario desde el formulario y otros campos
$name = $_POST['name'];
$lastname = $_POST['lastname'];
$dpi = $_POST['dpi'];
$nit = $_POST['nit'];
$gender = $_POST['gender']; // Obtener el género seleccionado del formulario
$phone = $_POST['phone'];
$address = $_POST['address'];
$newEmail = $_POST['correoUsuario']; // Nuevo correo electrónico

// Verificar si el correo electrónico ha sido cambiado
if ($newEmail !== $correo) {
    // El correo electrónico ha sido cambiado, actualizar tanto el correo en la tabla USUARIO como en la tabla USUARIODATOS
    $updateEmail = "UPDATE USUARIO SET email = '$newEmail' WHERE email = '$correo'";
    if (!mysqli_query($conn, $updateEmail)) {
        die("Error al actualizar el correo electrónico: " . mysqli_error($conn));
    }

    // Actualizar el correo en la sesión también
    $_SESSION['correo'] = $newEmail;
}

// Verificar si se proporcionó una nueva contraseña
if (!empty($_POST['password']) && !empty($_POST['confirmPassword'])) {
    // Verificar si la contraseña y su confirmación coinciden
    if ($_POST['password'] === $_POST['confirmPassword']) {
        // Las contraseñas coinciden, actualizar la contraseña en la base de datos
        $password = $_POST['password']; // Obtener la nueva contraseña
        $updatePassword = "UPDATE USUARIO SET password = '$password' WHERE email = '$newEmail'";
        if (!mysqli_query($conn, $updatePassword)) {
            die("Error al actualizar la contraseña: " . mysqli_error($conn));
        }
    } else {
        die("Las contraseñas no coinciden");
    }
}

// Actualizar otros campos del usuario en la tabla USUARIODATOS, incluido el género
$updateUserData = "UPDATE USUARIODATOS SET name = '$name', lastName = '$lastname', dpiUser = '$dpi', nitUserDatos = '$nit', genero = '$gender', telefonoUser = '$phone', direccionUser = '$address' WHERE userId = (SELECT idUser FROM USUARIO WHERE email = '$correo')";
if (!mysqli_query($conn, $updateUserData)) {
    die("Error al actualizar la información del usuario: " . mysqli_error($conn));
}

echo "Información del usuario actualizada correctamente";

mysqli_close($conn);
