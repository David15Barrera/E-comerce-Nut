
function convertirPrecioNutPoints() {
    const precioSistemaInput = document.getElementById('product-price');
    const precioLocalInput = document.getElementById('product-precioLocal');
    const precioSistema = parseFloat(precioSistemaInput.value);
    
    if (!isNaN(precioSistema)) {
        const precioLocal = precioSistema * 10; // Tasa de conversión (1 Quetzal = 10 nutPoints)
        precioLocalInput.value = precioLocal.toFixed(2);
    } else {
        precioLocalInput.value = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Obtener el ID del producto de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');

    // Realizar una solicitud AJAX para obtener los detalles del producto
    fetch(`../../../backend/verProdDetalles.php?id=${productId}`)
        .then(response => response.json())
        .then(product => {

            let imageLink = product.Imagen.startsWith('../backend/') ? product.Imagen.substring(11) : product.Imagen;
            // Actualizar los elementos HTML con los detalles del producto
            document.getElementById('product-image').src = `../../../backend/${imageLink}`;
            document.getElementById('product-title').value = product.titulo;
            document.getElementById('product-description').value = product.descripcion;
            document.getElementById('product-price').value = product.precio;
            document.getElementById('product-precioLocal').value = product.precioLocal;
            document.getElementById('product-cantidadDisponible').value = product.cantidadDisponible;
            document.getElementById('product-Categoria').value = product.categoria;
            
        })
        .catch(error => console.error('Error al obtener los detalles del producto:', error));

        fetch(`../../../backend/verValoraciones.php?id=${productId}`)
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