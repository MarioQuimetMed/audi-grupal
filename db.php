<?php
// Configuración de conexión a PostgreSQL usando variables de entorno
$config_file = __DIR__ . '/config.env.php';
if (file_exists($config_file)) {
    // Cargar configuración desde archivo protegido fuera del directorio web
    require_once $config_file;
} else {
    // Cargar desde variables de entorno (Docker)
    $host = getenv('DB_HOST') ? getenv('DB_HOST') : 'postgres';
    $port = getenv('DB_PORT') ? getenv('DB_PORT') : '5432';
    $dbname = getenv('DB_NAME') ? getenv('DB_NAME') : 'impuestos_db';
    $user = getenv('DB_USER') ? getenv('DB_USER') : 'postgres';
    $password = getenv('DB_PASSWORD');
}

// Verificar que tenemos las credenciales necesarias
if (empty($password)) {
    error_log("Error crítico: Credenciales de base de datos no configuradas");
    die("Error de configuración del sistema. Contacte al administrador.");
}

// Establecer conexión con manejo de errores
try {
    $conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
    // Conexión a la base de datos
    $conn = pg_connect($conn_string);
    
    // Verificar conexión
    if (!$conn) {
        throw new Exception(pg_last_error());
    }
} catch (Exception $e) {
    error_log("Error de conexión a la base de datos: " . $e->getMessage());
    // Guardar el error en un archivo de registro local
    file_put_contents(__DIR__ . '/db_error.log', date('[Y-m-d H:i:s] ') . "Error: " . $e->getMessage() . " - Detalles: host=$host dbname=$dbname user=$user\n", FILE_APPEND);
    // Mostrar mensaje simple para producción
    die("Error de conexión a la base de datos. Por favor, contacte al administrador del sistema.");
}

// Configuración adicional de seguridad para la conexión (específica para PostgreSQL)
// Establece nivel de aislamiento de transacción y otros parámetros de seguridad
pg_query($conn, "SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE");
pg_query($conn, "SET SESSION statement_timeout = '30s'"); // Tiempo máximo de consulta
?>