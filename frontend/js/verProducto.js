document.addEventListener('DOMContentLoaded', function() {
    // Obtener el ID del producto de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');

    // Realizar una solicitud AJAX para obtener los detalles del producto
    fetch(`../../backend/verProdDetalles.php?id=${productId}`)
        .then(response => response.json())
        .then(product => {

            let imageLink = product.Imagen.startsWith('../backend/') ? product.Imagen.substring(11) : product.Imagen;
            // Actualizar los elementos HTML con los detalles del producto
            document.getElementById('product-image').src = `../../backend/${imageLink}`;
            document.getElementById('product-title').textContent = product.titulo;
            document.getElementById('product-description').textContent = product.descripcion;
            document.getElementById('product-price').textContent = `Precio: Q ${product.precio}`;
            document.getElementById('product-precioLocal').textContent = `NutPoints: ${product.precioLocal}`;
            document.getElementById('product-cantidadDisponible').textContent = `Cantidad: ${product.cantidadDisponible}`;
            document.getElementById('product-FechaPublicacion').textContent = `Fecha de Publicación: ${product.FechaPublicacion}`;
            document.getElementById('product-FechaExpiracion').textContent = `Fecha de Expiración: ${product.FechaExpiracion}`;
            document.getElementById('product-Categoria').textContent = `Categoría: ${product.categoria}`;
        })
        .catch(error => console.error('Error al obtener los detalles del producto:', error));

        fetch(`../../backend/verValoraciones.php?id=${productId}`)
        .then(response => response.json())
        .then(valoraciones => {
            valoraciones.forEach(valora => {
                let commentDiv = document.createElement('div');
                commentDiv.classList.add('comment');
                commentDiv.innerHTML = `
                    <div class="comment-header">
                        <span class="comment-author">${valora.name} ${valora.lastName}</span>
                        <span class="comment-date">Fecha de Valoración: ${valora.dateValoracion}</span>
                    </div>
                    <div class="comment-body">
                        <span class="comment-rating">Puntuación: ${valora.puntuacion}</span>
                        <p class="comment-text">${valora.comentario}</p>
                    </div>
                `;
                document.querySelector('.product-comments').appendChild(commentDiv);
            });
        })
        .catch(error => console.error('Error al obtener las valoraciones:', error));
    

});
