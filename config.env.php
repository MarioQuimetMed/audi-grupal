<?php
// Archivo de configuración seguro - Debe estar fuera del directorio web accesible
// o con permisos restrictivos y bloqueado por .htaccess

// Credenciales de base de datos
$host = 'postgres';
$port = '5432';
$dbname = 'impuestos_db';
$user = 'postgres';
$password = 'secretpassword'; // Misma contraseña usada en docker-compose.yml

// Configuración de seguridad
$security_config = [
    'session_timeout' => 1800, // 30 minutos
    'max_login_attempts' => 5,
    'login_lockout_time' => 900, // 15 minutos
    'require_ssl' => true,
    'api_keys' => [
        '93fc39d2a9be518e4e6c3e63164f34fe8c305a2f59d1eae86d37758d3c' // En producción, usar una API key aleatoria
    ]
];

// No permitir acceso directo a este archivo
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}
?>
