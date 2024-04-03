// Manejar la actualización de la información del usuario
document.addEventListener("DOMContentLoaded", function () {
    // Obtener la información del usuario al cargar la página
    fetch("../../../backend/editarUser.php")
        .then(response => response.json())
        .then(data => {
            // Llenar los campos de los inputs del usuario
            document.getElementById("name").value = data.name;
            document.getElementById("lastname").value = data.lastName;
            document.getElementById("dpi").value = data.dpiUser;
            document.getElementById("nit").value = data.nitUserDatos;
            document.getElementById("address").value = data.direccionUser;
            document.getElementById("phone").value = data.telefonoUser;
            document.getElementById("gender").value = data.genero;
            document.getElementById("addresUsuario").value = data.email;

            //Llenar los campos de informacion del usuario
            document.getElementById("nombreUsuario").textContent = data.name + " " +data.lastName;
            document.getElementById("rolUsuario").textContent = data.rol;
            document.getElementById("correoUsuario").textContent = "Correo:" +" " + data.email;
            document.getElementById("dpiUsuario").textContent = "DPI:"+" "+ data.dpiUser;
            document.getElementById("nitUsuario").textContent = "Nit:"+" "+ data.nitUserDatos;
            document.getElementById("addressUsuario").textContent = "Dirección:"+" "+ data.direccionUser;
            document.getElementById("phoneUsuario").textContent = "Celular"+" "+ data.telefonoUser;
            document.getElementById("genderUsuario").textContent = "Genero:"+" "+ data.genero;
            document.getElementById("fechaRegistro").textContent = "Fecha de Registro:"+" "+data.dateRegistro;
        })
        .catch(error => console.log("Error al obtener la información del usuario:", error));
});
