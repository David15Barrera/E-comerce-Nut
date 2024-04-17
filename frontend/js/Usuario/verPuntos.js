document.addEventListener('DOMContentLoaded', function() {
    // Obtener el elemento donde se mostrarán los puntos
    const userPointsElement = document.getElementById('user-points');
    const puntosHistoryElement = document.querySelector('.puntos-history ul');

    // Función para cargar los puntos del usuario
    function loadUserPoints() {
        // Llamada fetch para obtener los puntos totales
        fetch('../../../backend/verPuntosTotales.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar el número de puntos en el HTML
                    userPointsElement.textContent = data.data[0].puntosTotales;

                    // Llamada fetch para obtener el historial de puntos
                    fetch('../../../backend/verPuntos.php')
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const puntos = data.data;

                                // Generar elementos de historial de puntos y agregarlos al HTML
                                puntos.forEach(punto => {
                                    const li = document.createElement('li');
                                    const dateSpan = document.createElement('span');
                                    const descriptionSpan = document.createElement('span');

                                    dateSpan.classList.add('date');
                                    dateSpan.textContent = new Date(punto.fechaoObtencion).toLocaleDateString('es-ES');

                                    descriptionSpan.textContent = `- ${punto.descripcion} (${punto.puntosObtenidos} puntos)`;

                                    li.appendChild(dateSpan);
                                    li.appendChild(descriptionSpan);

                                    puntosHistoryElement.appendChild(li);
                                });
                            } else {
                                console.error('Error al obtener los puntos:', data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error al obtener los puntos:', error);
                        });
                } else {
                    console.error('Error al obtener los puntos del usuario:', data.message);
                }
            })
            .catch(error => {
                console.error('Error al cargar los puntos del usuario:', error);
            });
    }

    // Cargar los puntos del usuario al cargar la página
    loadUserPoints();

    // Agregar un evento de clic al botón "Comprar más puntos" si es necesario
    const btnComprarPuntos = document.querySelector('.btn-comprar');
    if (btnComprarPuntos) {
        btnComprarPuntos.addEventListener('click', function() {
            // Aquí puedes agregar la lógica para comprar más puntos
            console.log('Comprar más puntos');
        });
    }
});
