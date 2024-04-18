document.addEventListener('DOMContentLoaded', function() {
    // Obtener los elementos donde se mostrarán los puntos totales y los puntos por servicio y compra
    const totalPointsElement = document.querySelector('.total-points');
    const servicePointsElement = document.querySelector('.service-points');
    const purchasePointsElement = document.querySelector('.purchase-points');

    // Realizar una solicitud AJAX para obtener los puntos totales del usuario
    fetch('../../../backend/verPuntosTotales.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Obtener los puntos totales del usuario
                const puntosTotales = data.data[0].puntosTotales;

                // Calcular el 40% y el 60% de los puntos totales
                const servicePoints = Math.round(puntosTotales * 0.4);
                const purchasePoints = Math.round(puntosTotales * 0.6);

                // Actualizar los elementos HTML con los puntos totales, puntos por servicio y puntos por compra
                totalPointsElement.textContent = puntosTotales;
                servicePointsElement.textContent = servicePoints;
                purchasePointsElement.textContent = purchasePoints;
            } else {
                console.error('Error al obtener los puntos totales del usuario:', data.message);
            }
        })
        .catch(error => console.error('Error al obtener los puntos totales del usuario:', error));
});

// Seleccionar el campo de entrada de cantidad y el campo de entrada de conversión
const amountInput = document.getElementById("amount");
const conversionInput = document.getElementById("conver");

// Agregar un evento de escucha para detectar cambios en el campo de entrada de cantidad
amountInput.addEventListener("input", function() {
    // Obtener el valor ingresado en el campo de entrada de cantidad
    const amount = parseFloat(amountInput.value);
    
    // Realizar la conversión de puntos a quetzales (1 punto = Q10)
    const conversion = amount / 10;

    // Actualizar el valor del campo de entrada de conversión con el resultado de la conversión
    conversionInput.value = conversion;
});

// Obtener la cantidad de puntos por servicio
const servicePointsElement = document.querySelector(".service-points");

// Seleccionar el formulario
// Obtener el formulario
const form = document.querySelector('.conversion-form form');

// Agregar un evento de escucha para el envío del formulario
form.addEventListener('submit', function(event) {
    event.preventDefault();

    // Obtener el valor del campo de cantidad
    const amount = parseFloat(document.getElementById('amount').value);


    const servicePointsValue = parseFloat(servicePointsElement.textContent);
    if (amount > servicePointsValue) {
        // Mostrar un mensaje de error
        alert('No puedes ingresar una cantidad mayor que los puntos por servicio.');
        return; // Detener la ejecución adicional del código
    }else{
     
            // Crear un nuevo objeto FormData
    const formData = new FormData();

    // Agregar el valor del campo de cantidad al FormData
    formData.append('amount', amount);

    // Realizar la solicitud AJAX utilizando FormData
    fetch('../../../backend/restarPuntos.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Retiro de puntos exitoso');
            location.reload();
        } else {
            alert('Error al retirar puntos: ' + data.message);
        }
    })
    .catch(error => console.error('Error al retirar puntos:', error));


    }

});
