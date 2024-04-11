<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/styleUser.css" type="text/css">
    <link rel="stylesheet" href="../../css/styleEditProduser.css" type="text/css">    
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
        <form id="product-form">
        <label for="product-title">Nombre del Producto:</label>
            <input type="text" id="product-title" name="product-title">

            <label for="product-description">Descripción del producto:</label>
            <textarea type="text" id="product-description" name="product-description"></textarea>
        <div class="precio-lado">
            <label for="product-price">Precio:</label>
            <input type="number" id="product-price" name="product-price">
        
            <label for="product-precioLocal">Puntos</label>
            <input type="number" id="product-precioLocal" name="product-precioLocal">
        </div>
            <label for="product-cantidadDisponible">Cantidad Disponible:</label>
            <input type="number" id="product-cantidadDisponible" name="product-cantidadDisponible">
            

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
                            <option value="Juguetes">Servicio Comunitario</option>
                            <option value="Juguetes">Evento Social</option>
                        </select>

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/*" required>

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

    </div>
</body>
<script src="../../js/Usuario/editProdComun.js"></script>
</html>
