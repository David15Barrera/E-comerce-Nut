<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/styleUser.css" type="text/css">
    <link rel="stylesheet" href="../../css/stylemicuenta.css" type="text/css">
    <title>Mi Cuenta</title>
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
                    <a href="#" class="link">Productos</a>
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
            <li><a href="../comun/inicioComun.php" class="active"><span>Inicio</span></a></li>
            <li><a href="#"><span class="icono-comprar">Vender</span></a></li>
            <li><a href="#"><span class="icono-productos">Chats</span></a></li>
            <li><a href="#"><span class="icono-reportes">Mis compras</span></a></li>
            <li><a href="#"><span class="icono-usuario">Mi Cuenta</span></a></li>
            <li><a href="../login.html"><span class="icono-cerrar">Cerrar sesión</span></a></li>
        </ul>
    </nav>
    <div class="container-cuenta">
        <div class="info-box">
            <h2>Información de Usuario</h2>
            <div class="user-details">
                <div class="user-name">Nombre Apellido</div>
                <div class="user-role">Rol del Usuario</div>
                <div class="user-info">
                    <p>DPI: xxxxxxxxx</p>
                    <p>NIT: xxxxxxxxx</p>
                    <p>Dirección: Dirección del Usuario</p>
                    <p>Teléfono: xxxxxxxxx</p>
                    <p>Género: Género del Usuario</p>
                    <p>Correo: correo@usuario.com</p>
                    <p>Fecha de Registro: dd/mm/yyyy</p>
                </div>
            </div>
        </div>
        <div class="edit-box">
            <form action="#" method="POST">
                <div class="input-group">
                    <div class="input-field">
                        <label for="name">Nombre:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="input-field">
                        <label for="lastname">Apellido:</label>
                        <input type="text" id="lastname" name="lastname" required>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-field">
                        <label for="dpi">  DPI:</label>
                        <input type="text" id="dpi" name="dpi" required>
                    </div>
                    <div class="input-field">
                        <label for="nit">  NIT:</label>
                        <input type="text" id="nit" name="nit" required>
                    </div>
                </div>
                 <div class="input-group">
                    <div class="input-field">
                        <label for="gender">Género:</label>
                        <input type="text" id="gender" name="gender" required>
                    </div>
                    <div class="input-field">
                        <label for="phone">Celular:</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                 </div>   
                <div class="input-field">
                    <label for="address">Dirección:</label>
                    <input type="text" id="address" name="address" required>
                </div>
                    <div class="input-field">
                    <label for="email">Correo:</label>
                    <input type="email" id="email" name="email" required>
                    </div>
                <div class="input-group">
                    <div class="input-field">
                    <label for="email">Confirmar Contraseña:</label>
                    <input type="email" id="email" name="email" required>
                    </div>
                    <div class="input-field">
                    <label for="email">Contraseña:</label>
                    <input type="email" id="email" name="email" required>
                    </div>
                </div>
                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>
</body></body>
</html>
