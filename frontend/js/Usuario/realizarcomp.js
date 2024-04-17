document.addEventListener('DOMContentLoaded', function() {
    // Obtener el contenedor de productos del carrito
    const cartItemsContainer = document.querySelector('.list-products');
    // Obtener el contenedor del precio total y el total de puntos
    const totalPriceContainer = document.getElementById('total-quetzales');
    const totalPointsContainer = document.getElementById('total-points');

    // Realizar una solicitud AJAX para obtener los detalles del carrito
    fetch('../../../backend/verCarrito.php')
    .then(response => response.json())
    .then(data => {
        // Limpiar el contenedor de productos del carrito
        cartItemsContainer.innerHTML = '';

        // Inicializar variables para el precio total y el total de puntos
        let precioTotal = 0;
        let totalPuntos = 0;

        // Renderizar los detalles de los productos en el carrito
        data.forEach(producto => {
            const productHTML = `
            <ul>
                <li>${producto.titulo} - Cantidad: ${producto.cantidad} - Q${producto.total} ${producto.publicacionId} </li>
            </ul>
            `;
            cartItemsContainer.innerHTML += productHTML;
            // Sumar el precio total y calcular el total de puntos
            precioTotal += parseFloat(producto.total);
            totalPuntos += parseFloat(producto.total) * 10;
            console.log(producto.idCarrito);
        });

        // Actualizar el precio total y el total de puntos en el contenedor correspondiente
        totalPriceContainer.textContent = precioTotal.toFixed(2);
        totalPointsContainer.textContent = totalPuntos.toFixed(2);

    })
    .catch(error => {
        console.error('Error al obtener el carrito:', error);
    });
    
});


function cargarCiudades() {
    var paisSeleccionado = document.getElementById("pais").value;
    var ciudadSelect = document.getElementById("ciudad");
    ciudadSelect.innerHTML = ""; // Limpiar opciones anteriores

    if (paisSeleccionado === "Estados Unidos") {
        ciudades = ["Nueva York", "Los Angeles", "Chicago", "Houston"];
    } else if (paisSeleccionado === "Canada") {
        ciudades = ["Toronto", "Montreal", "Vancouver", "Ottawa"];
    } else if (paisSeleccionado === "Mexico") {
        ciudades = ["Ciudad de Mexico", "Guadalajara", "Monterrey", "Puebla", "Chiapas", "Chihuahua", "Baja California", "Campeche", "Coahuila", "Colima", "Durango", "Guanajuato"];
    } else if (paisSeleccionado === "Guatemala") {
        ciudades = ["Guatemala City", "Quetzaltenango", "Escuintla", "Chichicastenango", "Quiche", "Huehuetenango", "Santa Rosa", "Baja Verapaz", "Alta Verapaz", "Progreso", "Solola", "Totonicapan", "Suchitepequez", "Retalhuleu", "San Marcos", "Peten", "Izabal", "Zacapa", "Chimaltenango"];
    } else if (paisSeleccionado === "Espana") {
        ciudades = ["Madrid", "Barcelona", "Valencia", "Sevilla", "Bilbao", "Malaga", "Alicante", "Murcia", "Cordoba", "Valladolid", "Vigo", "Gijon", "LHospitalet de Llobregat"];
    } else if (paisSeleccionado === "Japon") {
        ciudades = ["Tokio", "Osaka", "Nagoya", "Sapporo", "Fukuoka", "Kobe", "Yokohama", "Kyoto", "Kawasaki", "Hiroshima", "Sendai", "Kitakyushu", "Chiba"];
    } else if (paisSeleccionado === "El Salvador") {
        ciudades = ["San Salvador", "Santa Ana", "Soyapango", "San Miguel", "Mejicanos", "Apopa", "Delgado", "Sonsonate", "Ilopango", "Usulutan", "Cojutepeque", "San Marcos", "Zacatecoluca"];
    } else if (paisSeleccionado === "Brasil") {
        ciudades = ["Sao Paulo", "Rio de Janeiro", "Brasilia", "Salvador", "Fortaleza", "Belo Horizonte", "Manaos", "Curitiba", "Recife", "Goiania", "Belem", "Porto Alegre", "Campinas"];
    } else if (paisSeleccionado === "Argentina") {
        ciudades = ["Buenos Aires", "Cordoba", "Rosario", "Mendoza", "Tucuman", "La Plata", "Mar del Plata", "Salta", "Santa Fe", "San Juan", "Resistencia", "Corrientes", "Posadas"];
    } else if (paisSeleccionado === "Chile") {
        ciudades = ["Santiago", "Valparaiso", "Concepción", "Antofagasta", "Viña del Mar", "Temuco", "Rancagua", "Talca", "Arica", "Iquique", "Puerto Montt", "La Serena", "Chillán"];
    } else if (paisSeleccionado === "Costa Rica") {
        ciudades = ["San Jose", "Alajuela", "Cartago", "Heredia", "Liberia", "Puntarenas", "Limon", "San Francisco", "San Rafael", "San Antonio", "Tibas", "Pavas", "Escazu"];
    } else if (paisSeleccionado === "Panama") {
        ciudades = ["Panama", "Colon", "David", "La Chorrera", "Tocumen", "Arraijan", "Las Cumbres", "La Cabima", "Santiago de Veraguas", "Chitre", "San Miguelito", "Penonome", "Pedregal"];
    } else {
        var ciudades = []; // Si no se selecciona un país válido, no se muestran ciudades
    }

    // Agregar opciones de ciudades al select
    ciudades.forEach(function(ciudad) {
        var option = document.createElement("option");
        option.text = ciudad;
        option.value = ciudad;
        ciudadSelect.add(option);
    });
}


document.addEventListener("DOMContentLoaded", function () {
    // Obtener la información del usuario al cargar la página
    fetch("../../../backend/editarUser.php")
        .then(response => response.json())
        .then(data => {
            // Llenar los campos de los inputs del usuario
            document.getElementById("nombre").value = data.name;
            document.getElementById("apellido").value = data.lastName;
            document.getElementById("nit").value = data.nitUserDatos;
            document.getElementById("direccion").value = data.direccionUser;
            document.getElementById("phone").value = data.telefonoUser;
            document.getElementById("correo").value = data.email;
        })
        .catch(error => console.log("Error al obtener la información del usuario:", error));
});

function cambiarMetodoPago() {
    var metodoPagoSelect = document.getElementById("metodo-pago");
    var nombreTarjetaInput = document.getElementById("nombre-tarjeta");
    var numeroTarjetaInput = document.getElementById("numero-tarjeta");
    var fechaExpiracionInput = document.getElementById("fecha-expiracion");

    if (metodoPagoSelect.value === "precioLocal") {
        nombreTarjetaInput.readOnly = true;
        numeroTarjetaInput.readOnly = true;
        fechaExpiracionInput.readOnly = true;
    } else {
        nombreTarjetaInput.readOnly = false;
        numeroTarjetaInput.readOnly = false;
        fechaExpiracionInput.readOnly = false;
    }
}



document.addEventListener('DOMContentLoaded', function() {
    const checkoutBtn = document.getElementById('checkout-btn');

    checkoutBtn.addEventListener('click', function(event) {
        event.preventDefault();

        const cantidad = document.getElementById('total-points').textContent; // Cantidad de puntos
        const total = document.getElementById('total-quetzales').textContent; // Total en quetzales
        const direccion = document.getElementById('direccion').value;
        const pais = document.getElementById('pais').value;
        const ciudad = document.getElementById('ciudad').value;
        const codPostal = document.getElementById('postal').value;
        const metodoPago = document.getElementById('metodo-pago').value; // Nuevo campo agregado


        console.log(metodoPago);
        // Crear un objeto con los datos a enviar
        const data = {
            cantidad: cantidad,
            total: total,
            direccion: direccion,
            pais: pais,
            ciudad: ciudad,
            codPostal: codPostal,
            metodoPago: metodoPago // Pasar el método de pago al backend 
        };

        // Realizar la solicitud Fetch
        fetch('../../../backend/registrarVenta.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data) // Convertir el objeto a JSON
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                    window.location.href = 'inicioComun.php';
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error al realizar la venta:', error);
        });
    });
});

