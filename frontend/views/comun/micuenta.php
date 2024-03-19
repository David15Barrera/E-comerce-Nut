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
    <nav class="sidebar">
        <h3>nut</h3>
        <ul>
            <li><a href="../comun/inicioComun.php" class="active"><span>Inicio</span></a></li>
            <li><a href="#"><span class="icono-comprar">Vender</span></a></li>
            <li><a href="#"><span class="icono-productos">Productos</span></a></li>
            <li><a href="../comun/carrito.html"><span class="icono-carrito">Carrito</span></a></li>
            <li><a href="#"><span class="icono-reportes">Mis compras</span></a></li>
            <li><a href="#"><span class="icono-usuario">Mi Cuenta</span></a></li>
            <li><a href="../login.html"><span class="icono-cerrar">Cerrar sesión</span></a></li>
        </ul>
    </nav>
    <div class="container-form">
        <h2>Mi Cuenta</h2>
        <div id="message"></div>
        <div class="form-column">
            <div class="update-section">
                <h3>Actualizar Datos</h3>
                <form id="updateForm">
                    <div>
                        <label for="name">Correo:</label>
                        <input type="text" id="name" name="name">
                    </div>
                    <div>
                        <label for="name">Nombre:</label>
                        <input type="text" id="name" name="name">
                    </div>
                    <div>
                        <label for="lastName">Apellido:</label>
                        <input type="text" id="lastName" name="lastName">
                    </div>
                    <div>
                        <label for="dpi">DPI:</label>
                        <input type="text" id="dpi" name="dpi" maxlength="13" inputmode="numeric" pattern="[0-9]{13}" placeholder="Ingrese su DPI (13 dígitos)" required>
                    </div>
                    <div>
                        <label for="nit">NIT:</label>
                        <input type="text" id="nit" name="nit">
                    </div>
                    <div>
                        <label for="direccion">Dirección:</label>
                        <input type="text" id="direccion" name="direccion">
                    </div>
                    <div>
                        <label for="telefono">Teléfono:</label>
                        <input type="text" id="telefono" name="telefono">
                    </div>
                    <div>
                        <label for="genero">Género:</label>
                        <select id="genero" name="genero">
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Masculino">Femenino</option>
                        </select>
                    </div>
                    <button type="submit">Actualizar Datos</button>
                </form>
            </div>
        </div>
        <div class="form-column">
            <div class="update-section">
                <h3>Actualizar Contraseña</h3>
                <form id="updatePasswordForm">
                    <div>
                        <label for="currentPassword">Contraseña Actual:</label>
                        <input type="password" id="currentPassword" name="currentPassword">
                    </div>
                    <div>
                        <label for="newPassword">Nueva Contraseña:</label>
                        <input type="password" id="newPassword" name="newPassword">
                    </div>
                    <div>
                        <label for="confirmPassword">Confirmar Nueva Contraseña:</label>
                        <input type="password" id="confirmPassword" name="confirmPassword">
                    </div>
                    <button type="submit">Actualizar Contraseña</button>
                </form>
            </div>
        </div>
    </div>
    <script src="../../js/update.js"></script>
</body>
</html>
