<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "upiih";

// Conexión a la base de datos
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}

// Obtener los datos del formulario y limpiarlos
$nombre = mysqli_real_escape_string($conn, $_POST["txtusuario"]);
$pass = mysqli_real_escape_string($conn, $_POST["txtpassword"]);

// Consulta preparada para prevenir la inyección SQL
$query = mysqli_prepare($conn, "SELECT * FROM login WHERE usuario = ? AND password = ?");
mysqli_stmt_bind_param($query, "ss", $nombre, $pass);
mysqli_stmt_execute($query);

// Obtener el resultado de la consulta
$result = mysqli_stmt_get_result($query);

// Verificar si se encontró un usuario con las credenciales proporcionadas
if (mysqli_num_rows($result) == 1) {
    // Inicio de sesión exitoso, redireccionar al usuario a la página de publicación
    header("Location: publication.html");
    exit();
} else {
    // Credenciales incorrectas, mostrar un mensaje de error y redirigir de nuevo a la página de inicio de sesión
    echo "<script>alert('Usuario o contraseña incorrectos. Por favor, verifica e intenta nuevamente.');</script>";
    header("Location: login.html");
    exit();
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
