function registrarUsuario() {
    // Obtener los valores de los campos del formulario
    var email = document.getElementById("email").value.trim();
    var password = document.getElementById("password").value.trim();
    var name = document.getElementById("name").value.trim();
    var lastName = document.getElementById("lastname").value.trim();
    var dpi = document.getElementById("dpi").value.trim();
    var nit = "CF"; // Agregar la obtención del NIT
    var direccion = document.getElementById("direccion").value.trim();
    var telefono = document.getElementById("numeroCelular").value.trim();
    var genero = document.getElementById("genero").value; // Agregar la obtención del género

    // Verificar que todos los campos estén llenos
    if (email === "" || password === "" || name === "" || lastName === "" || dpi === "" || nit === "" || direccion === "" || telefono === "" || genero === "") {
        alert("Por favor, llene todos los campos del formulario.");
        return; // Detener la ejecución si falta algún campo
    }

    // Enviar los datos al servidor mediante AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../../backend/registrar.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Respuesta del servidor
            alert(xhr.responseText);
            // Si la respuesta es exitosa, limpiar los campos del formulario
            if (xhr.responseText === "Usuario registrado correctamente.") {
                document.getElementById("email").value = "";
                document.getElementById("password").value = "";
                document.getElementById("name").value = "";
                document.getElementById("lastname").value = "";
                document.getElementById("dpi").value = "";
                document.getElementById("nit").value = ""; // Limpiar el campo NIT
                document.getElementById("direccion").value = "";
                document.getElementById("numeroCelular").value = "";
                document.getElementById("genero").selectedIndex = 0;
            }
        }
    };
    var params = "email=" + email + "&password=" + password + "&name=" + name + "&lastName=" + lastName + "&dpi=" + dpi + "&nit=" + nit + "&direccion=" + direccion + "&telefono=" + telefono + "&genero=" + genero;
    xhr.send(params);
}