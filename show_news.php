<?php
// Conexión a la base de datos (modifica estas líneas según tu configuración)
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "upiih";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

// Consulta SQL para recuperar las publicaciones de la sección de noticias
$query = "SELECT * FROM publicaciones WHERE Categoria = 'Noticias' ORDER BY Fecha DESC";
$result = mysqli_query($conn, $query);

// Verificar si se encontraron publicaciones
if (mysqli_num_rows($result) > 0) {
    // Array para almacenar las publicaciones
    $publicaciones = array();

    // Recorrer los resultados y agregarlos al array de publicaciones
    while ($row = mysqli_fetch_assoc($result)) {
        $publicaciones[] = $row;
    }

    // Devolver las publicaciones en formato JSON
    header('Content-Type: application/json');
    echo json_encode($publicaciones);
} else {
    // Si no se encontraron publicaciones, devolver un mensaje de error
    echo "No se encontraron publicaciones en la sección de noticias.";
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>