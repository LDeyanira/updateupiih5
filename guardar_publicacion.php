<?php

// Verifica si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos (modifica estas líneas según tu configuración)
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "upiih";

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (!$conn) {
        die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
    }

    // Obtener los datos del formulario
    $titulo = $_POST["txttitulo"];
    $descripcion = $_POST["body"];
    $fecha = $_POST["trip-start"];
    $url = $_POST["txturl"];
    $archivo = $_POST["txtfile"];
    $categoria = $_POST["selection"];

    // Escapar los datos para prevenir la inyección de SQL
    $titulo = mysqli_real_escape_string($conn, $titulo);
    $descripcion = mysqli_real_escape_string($conn, $descripcion);
    $fecha = mysqli_real_escape_string($conn, $fecha);
    $url = mysqli_real_escape_string($conn, $url);
    $archivo = mysqli_real_escape_string($conn, $archivo);
    $categoria = mysqli_real_escape_string($conn, $categoria);

    // Construir la consulta SQL para insertar la publicación en la base de datos
    $query = "INSERT INTO publicaciones (Titulo, Descripcion, Fecha, URL, Archivo, Categoria) 
              VALUES ('$titulo', '$descripcion', '$fecha', '$url', '$archivo', '$categoria')";

    // Ejecutar la consulta
    if (mysqli_query($conn, $query)) {
        // Publicación guardada exitosamente, redirigir a la página correspondiente según la categoría
        switch ($categoria) {
            case "Noticias":
                header("Location: news3.html");
                break;
            case "Eventos":
                header("Location: events.html");
                break;
            case "Posiciones abiertas":
                header("Location: openpositions.html");
                break;
            case "Publicaciones":
                header("Location: publications.html");
                break;
            default:
                // Si la categoría no coincide con ninguna de las opciones anteriores, redirigir a una página predeterminada
                header("Location: index.html");
                break;
        }
        exit(); // Asegúrate de terminar la ejecución del script después de la redirección
    } else {
        // Si hay un error al guardar la publicación, mostrar un mensaje de error
        echo "Error al guardar la publicación: " . mysqli_error($conn);
    }
} else {
    // Si no se han enviado datos del formulario, mostrar un mensaje de error
    echo "Error: No se han recibido datos del formulario.";
}
?>
