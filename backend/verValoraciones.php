<?php
include_once "connection.php"; // Incluir archivo de conexión

if (isset($_GET['id'])) {
    $idProducto = $_GET['id'];
    $sql = "SELECT UD.name, UD.lastName, V.puntuacion, V.userEvaluadorId, V.publicacionId, V.comentario, V.dateValoracion FROM VALORACIONES V JOIN PUBLICACIONES P ON V.publicacionId = P.idPublicaciones JOIN USUARIO U ON V.userEvaluadorId = U.idUser JOIN USUARIODATOS UD ON U.idUser = UD.userId WHERE P.idPublicaciones = $idProducto";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $valoraciones = [];

        while ($row = $result->fetch_assoc()) {
            $valoraciones[] = [
                'name' => $row['name'],
                'lastName' => $row['lastName'],
                'puntuacion' => $row['puntuacion'],
                'userEvaluadorId' => $row['userEvaluadorId'],
                'publicacionId' => $row['publicacionId'],
                'comentario' => $row['comentario'],
                'dateValoracion' => $row['dateValoracion']
            ];
        }

        echo json_encode($valoraciones);
    } else {
        // Si no hay resultados, devuelve un mensaje de error
        echo json_encode(['error' => 'No se encontraron valoraciones para este producto']);
    }
} else {
    // Si no se proporcionó el ID del producto, devolver un mensaje de error
    echo json_encode(['error' => 'ID del producto no especificado']);
}
?>
