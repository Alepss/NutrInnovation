<?php
// Recibir datos del formulario
$nombre = $_POST['Nombre'];
$correo = $_POST['email'];
$telefono = $_POST['Telefono'];

// Validar datos
if (empty($nombre) || empty($correo) || empty($telefono)) {
    echo "Error: Por favor, complete todos los campos.";
    exit;
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo "Error: Dirección de correo electrónico no válida.";
    exit;
}

if (!preg_match("/^[0-9]{10}$/", $telefono)) {
    echo "Error: Número telefónico no válido. Debe tener 10 dígitos.";
    exit;
}

// Conectar a la base de datos
$servername = "localhost";
$username = "root"; // Nombre de usuario de MySQL (por defecto en XAMPP es 'root')
$password = ""; // Contraseña de MySQL (por defecto está vacía en XAMPP)
$dbname = "clientes"; // Nombre de la base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Preparar y ejecutar la inserción
$stmt = $conn->prepare("INSERT INTO datos (nombre, email, numero) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nombre, $correo, $telefono);

if ($stmt->execute()) {
    echo "Datos guardados correctamente.";
} else {
    echo "Error: " . $stmt->error;
}

// Comprobar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    echo "Conexión exitosa";
}


// Cerrar conexión
$stmt->close();
$conn->close();

// Redireccionar a la página de agradecimiento
header('Location: gracias.html');
exit;
?>
