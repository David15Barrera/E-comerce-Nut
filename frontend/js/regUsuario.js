document.addEventListener("DOMContentLoaded", function() {
    // Obtener la tabla de usuarios
    var tablaUsuarios = document.getElementById("tabla-usuarios");

    // Realizar la solicitud Fetch a verUser.php
    fetch("../../../backend/verUser.php")
    .then(response => response.json())
    .then(data => {
        // Limpiar la tabla
        tablaUsuarios.innerHTML = "";

        // Iterar sobre los datos obtenidos y agregarlos a la tabla
        data.forEach(usuario => {
            var row = tablaUsuarios.insertRow();
            var cellNombre = row.insertCell(0);
            var cellDpi = row.insertCell(1);
            var cellCorreo = row.insertCell(2);
            var cellAccion = row.insertCell(3);

            cellNombre.innerHTML = usuario.name;
            cellDpi.innerHTML = usuario.dpiUser;
            cellCorreo.innerHTML = usuario.email;

            // Agregar botones de editar y eliminar
            cellAccion.innerHTML = `
                <button class="editar">Editar</button>
                <button class="eliminar">Eliminar</button>
            `;
        });
    })
    .catch(error => console.error("Error al obtener los usuarios:", error));
});

document.addEventListener("DOMContentLoaded", function() {
    // Obtener el formulario y los campos de contraseña
    var form = document.getElementById("insertUser");
    var passInput = document.getElementById("pass");
    var confirmPasswordInput = document.getElementById("confirmPassword");

    // Agregar un evento de escucha al formulario cuando se envíe
    form.addEventListener("submit", function(event) {
        // Verificar si las contraseñas son iguales
        if (passInput.value !== confirmPasswordInput.value) {
            alert("Las contraseñas no coinciden");
            event.preventDefault(); // Evitar que el formulario se envíe
        }
    });
});
