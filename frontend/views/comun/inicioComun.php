<?php 
session_start();
if(isset($_SESSION['nombreUsuario']) && isset($_SESSION['apellidoUsuario'])) {
    $nombreUsuario = $_SESSION['nombreUsuario'];
    $apellidoUsuario = $_SESSION['apellidoUsuario'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/styleUser.css" type="text/css">

    <title>InicioUsuario</title>
</head>
<body>
<header>
        <nav class="nav__hero">
            <div class="container nav__container">
                <div class="logo">
                    <h2 class="logo__name">Ecommerce<span class="point">.</span></h2>
                </div>
                <div class="links">
                    <a href="../comun/inicioComun.php" class="link">Cuenta</a>
                    <a href="../comun/productosUser.html" class="link">Productos</a>
                    <a href="../comun/carrito.html" class="link link--active">Carrito</a>
                </div>
            </div>
        </nav>
    </header>
    <br>
    <br>
    <br>
    <br>
    <nav class="sidebar">
        <h3>nut</h3>
        <ul>
            <li><a href="#" class="active"><span>Inicio</span></a></li>
            <li><a href="../comun/publicacion.html"><span class="icono-comprar">Vender</span></a></li>
            <li><a href="../comun/chats.html"><span class="icono-productos">Chats</span></a></li>
            <li><a href="#"><span class="icono-reportes">Mis compras</span></a></li>
            <li><a href="../comun/editProd.html"><span class="icono-prodEditar">Mis Productos</span></a></li>
            <li><a href="../comun/micuenta.php"><span class="icono-usuario">Mi Cuenta</span></a></li>
            <li><a href="../login.html"><span class="icono-cerrar">Cerrar sesión</span></a></li>
        </ul>
    </nav>
    <div class="content">
        <div class="container">
            <h1 class="animate__animated animate__fadeInDown">Bienvenido, <?php echo $nombreUsuario . " " . $apellidoUsuario; ?></h1>
            <p class="animate__animated animate__fadeInUp">¡Disfruta de tu sesión como Usuario!</p>
        </div>
    </div>
</body>
</html>

<?php 
} else {
    // Si las variables de sesión no están configuradas, redirige al usuario a la página de inicio de sesión
    header("Location: login.html");
    exit();
}
?>
