<?php
include_once "connection.php"; // Incluir archivo de conexión

$sql = "SELECT * FROM PUBLICACIONES WHERE estado = 'PENDIENTE'";
$result = $conn->query($sql);

$publicaciones = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $publicacion = [
            'idPublicaciones' => $row['idPublicaciones'],
            'titulo' => $row['titulo'],
            'descripcion' => $row['Descripcion'],
            'Imagen' => $row['Imagen'],
            'precioLocal' => $row['precioLocal'],
            'precioSistema' => $row['precioSistema'],
            'estado' => $row['estado']
        ];
        $publicaciones[] = $publicacion;
    }
}

echo json_encode($publicaciones);
?>
