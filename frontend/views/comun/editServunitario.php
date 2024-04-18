<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/styleUser.css" type="text/css">
    <link rel="stylesheet" href="../../css/styleEditServuser.css" type="text/css">    
    <title>Detalle Producto</title>
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
    <div class="product-details">
        <div class="image-container">
            <img alt="Producto" id="product-image">
        </div>
        <form action="../../../backend/editarPublicacion.php" method="POST" enctype="multipart/form-data" class="form-grid" id="product-form">
        <label for="product-title">Nombre del Producto:</label>
            <input type="text" id="product-title" name="product-title">

            <label for="product-description">Descripción del producto:</label>
            <textarea type="text" id="product-description" name="product-description"></textarea>
        <div class="precio-lado">
            <label for="product-price">Precio:</label>
            <input type="number" id="product-price" name="product-price" oninput="convertirPrecioNutPoints()">
        
            <label for="product-precioLocal">Puntos</label>
            <input type="number" id="product-precioLocal" name="product-precioLocal" readonly>
        </div>
            <label for="product-cantidadDisponible">Cantidad Disponible:</label>
            <input type="number" id="product-cantidadDisponible" name="product-cantidadDisponible">

            <input type="hidden" id="idProducto" name="idProducto" value="<?php echo $_GET['id']; ?>">


            <label for="product-Categoria">Categoría:</label>
                        <select id="product-Categoria" name="product-Categoria" required>
                            <option value="">Selecciona una categoría</option>
                            <option value="Electronica">Electronica</option>
                            <option value="Ropa">Ropa</option>
                            <option value="Calzado">Calzado</option>
                            <option value="Electrodomestico">Electrodomestico</option>
                            <option value="Comida">Comida</option>
                            <option value="Hogar">Hogar</option>
                            <option value="Muebles">Muebles</option>
                            <option value="Juguetes">Juguetes</option>
                            <option value="Servicio">Servicio Comunitario</option>
                            <option value="Evento">Evento Social</option>
                        </select>

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/*">

            <div class="buttons">
                <button type="submit" class="btn-guardar">Guardar</button>
                <button type="button" class="btn-Eliminar">Eliminar</button>
            </div>
        </form>
    </div>


    <div class="comments-and-contact">
        <!-- Espacio para comentarios del producto -->
        <div class="product-comments">
            <h2>Comentarios del Producto</h2>
            <!-- Otros comentarios se pueden agregar aquí -->

        </div>
        <div class="Voluntarios">
            <br>
            <input type="hidden" id="idProducto" name="idProducto" value="<?php echo $_GET['id']; ?>">
            <h2>Personas Inscritas</h2>
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Puntos a dar</th>
                        <th>Estado</th>
                         <th>Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    <!-- Datos del inscrito-->
                    <tr>

                    </tr>
                    <!-- Agregar más filas según sea necesario -->
                </tbody>
            </table>
        </div>
    </div>
</body>
<script src="../../js/Usuario/editProdComun.js"></script>
</html>
