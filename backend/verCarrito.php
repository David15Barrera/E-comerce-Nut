<?php
session_start();
include_once "connection.php";

if (isset($_SESSION['correo'])) {
    $correo = $_SESSION['correo'];

    // Consulta para recuperar los productos en el carrito del usuario
    $sql = "SELECT P.titulo, P.precioSistema, C.idCarrito, C.cantidad, (P.precioSistema * C.cantidad) AS total FROM CARRITO AS C INNER JOIN PUBLICACIONES AS P ON C.publicacionId = P.idPublicaciones INNER JOIN USUARIO AS U ON C.userId = U.idUser WHERE U.email = '$correo'";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $productos = array();
        while ($row = $result->fetch_assoc()) {
            $productos[] = array(
                'titulo' => $row['titulo'],
                'precioSistema' => $row['precioSistema'],
                'idCarrito' => $row['idCarrito'],
                'cantidad' => $row['cantidad'],
                'total' => $row['total']
            );
        }
        echo json_encode($productos);
    } else {
        echo json_encode(array()); // Si no hay productos en el carrito
    }
} else {
    echo json_encode(array('error' => 'No has iniciado sesión'));
}
?>
