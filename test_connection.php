<?php
// test_connection.php - Archivo para probar la conexión a la base de datos
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Prueba de conexión a PostgreSQL</h1>";

// Comprobar que el módulo PostgreSQL está instalado
if (!extension_loaded('pgsql')) {
    die("ERROR: La extensión pgsql no está instalada o activada");
}

echo "<p>✅ Extensión pgsql está instalada</p>";

// Credenciales de prueba
$host = 'postgres';
$port = '5432';
$dbname = 'impuestos_db';
$user = 'postgres';
$password = 'secretpassword';

echo "<p>Intentando conectar a: host=$host, port=$port, dbname=$dbname, user=$user</p>";

// Intentar la conexión
try {
    $conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
    $conn = pg_connect($conn_string);
    
    if ($conn) {
        echo "<p>✅ Conexión exitosa a PostgreSQL</p>";
        
        // Probar una consulta simple
        $query = "SELECT version()";
        $result = pg_query($conn, $query);
        
        if ($result) {
            $row = pg_fetch_row($result);
            echo "<p>Versión de PostgreSQL: " . htmlspecialchars($row[0]) . "</p>";
            
            // Probar una consulta a la tabla de usuarios
            $test_query = "SELECT COUNT(*) FROM usuarios";
            $test_result = pg_query($conn, $test_query);
            
            if ($test_result) {
                $count_row = pg_fetch_row($test_result);
                echo "<p>Total de usuarios en la base de datos: " . $count_row[0] . "</p>";
            } else {
                echo "<p>❌ Error al consultar tabla usuarios: " . pg_last_error($conn) . "</p>";
            }
        } else {
            echo "<p>❌ Error al consultar versión: " . pg_last_error($conn) . "</p>";
        }
    } else {
        echo "<p>❌ Error de conexión: " . pg_last_error() . "</p>";
    }
} catch (Exception $e) {
    echo "<p>❌ Excepción: " . $e->getMessage() . "</p>";
}

echo "<p><a href='login.php'>Ir a página de login</a></p>";
?>
