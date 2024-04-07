<?php
include_once "connection.php"; // Incluir archivo de conexión

if (isset($_GET['id'])) {
    $idValoracion = $_GET['id'];
    $sql = "SELECT UD.name, UD.lastName, V.puntuacion, V.comentario, V.dateValoracion FROM VALORACIONES V JOIN PUBLICACIONES P ON V.publicacionId = P.idPublicaciones JOIN USUARIO U ON V.userEvaluadorId = U.idUser JOIN USUARIODATOS UD ON U.idUser = UD.userId WHERE P.idPublicaciones = $idValoracion";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $valoraciones = [];

        while ($row = $result->fetch_assoc()) {
            $valoracion = [
                'name' => $row['name'],
                'lastName' => $row['lastName'],
                'puntuacion' => $row['puntuacion'],
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
