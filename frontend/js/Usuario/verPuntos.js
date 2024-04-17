document.addEventListener('DOMContentLoaded', function() {
    const puntosContainer = document.querySelector('.puntos-container');
    const userPointsElement = document.getElementById('user-points');
    const puntosHistoryElement = document.querySelector('.puntos-history ul');

    // Llamada fetch para obtener los puntos del usuario
    fetch('../../../backend/verPuntos.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const puntos = data.data;
                const totalPoints = puntos.reduce((total, punto) => total + parseInt(punto.Monto), 0);

                // Actualizar el total de puntos del usuario en el HTML
                userPointsElement.textContent = totalPoints;

                // Generar elementos de historial de puntos y agregarlos al HTML
                puntos.forEach(punto => {
                    const li = document.createElement('li');
                    const dateSpan = document.createElement('span');
                    const descriptionSpan = document.createElement('span');

                    dateSpan.classList.add('date');
                    dateSpan.textContent = new Date(punto.fechaoObtencion).toLocaleDateString('es-ES');

                    descriptionSpan.textContent = `- ${punto.Descripcion} (${punto.Monto} puntos)`;

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
});
