
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
            console.log(product.Tipo);
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




document.addEventListener('DOMContentLoaded', function() {
    // Obtener el ID del producto de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');

    // Obtener la tabla donde se mostrarán los inscritos
    const inscritosTableBody = document.querySelector('.Voluntarios tbody');

    // Realizar una solicitud AJAX para obtener la lista de inscritos
    fetch(`../../../backend/listarinscritos.php?id=${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const inscritos = data.inscritos;
                inscritos.forEach(inscrito => {
                    // Crear una fila para cada inscrito
                    const row = document.createElement('tr');
                    console.log(inscrito.idServicio);
                    // Agregar los datos del inscrito a la fila
                    row.innerHTML = `
                        <td>${inscrito.name}</td>
                        <td>${inscrito.lastName}</td>
                        <td>${inscrito.puntos}</td>
                        <td>${inscrito.estado}</td>
                        <td>
                            <button class="btn-asistencia" data-id="${inscrito.idServicio}">Asistió</button>
                            <button class="btn-abandono" data-id="${inscrito.idServicio}">Abandonó</button>
                        </td>
                    `;

                    // Agregar la fila a la tabla
                    inscritosTableBody.appendChild(row);
                });

                // Agregar manejadores de eventos para los botones de asistencia y abandono
                inscritosTableBody.querySelectorAll('.btn-asistencia').forEach(button => {
                    button.addEventListener('click', function() {
                        actualizarEstado(button.dataset.id, 'Asistio');
                    });
                });

                inscritosTableBody.querySelectorAll('.btn-abandono').forEach(button => {
                    button.addEventListener('click', function() {
                        actualizarEstado(button.dataset.id, 'Abandono');
                    });
                });
            } else {
                console.error('Error al obtener la lista de inscritos:', data.message);
            }
        })
        .catch(error => console.error('Error al obtener la lista de inscritos:', error));

    // Función para enviar una solicitud AJAX para actualizar el estado del servicio
    function actualizarEstado(idServicio, estado) {
        fetch('../../../backend/actualizarEstado.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ idServicio: idServicio, estado: estado })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                // Actualizar la interfaz de usuario u otra lógica según sea necesario
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error al actualizar el estado:', error));
    }
});
