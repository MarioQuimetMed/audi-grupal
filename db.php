<?php
// Configuración de conexión a PostgreSQL
$host = getenv('DB_HOST') ? getenv('DB_HOST') : 'postgres';
$port = '5432';
$dbname = 'impuestos_db';
$user = 'postgres';
$password = 'tu_contraseña';  // Contraseña hardcodeada (vulnerabilidad intencionada)

// Establecer conexión
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
$conn = pg_connect($conn_string);

// Verificar conexión
if (!$conn) {
    die("Error al conectar a la base de datos: " . pg_last_error());
}
?>