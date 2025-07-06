<?php
// Configuración de respaldo - NO USAR EN PRODUCCIÓN
// Este archivo está aquí temporalmente y debe ser eliminado

$host = 'db.impuestos.internal';
$port = '5432';
$dbname = 'impuestos_prod';
$user = 'postgres_admin';
$password = 'P@ssw0rd123!';  

$admin_users = array(
    'admin' => array(
        'password' => '0192023a7bbd73250516f069df18b500', // admin123
        'email' => 'admin@impuestos.gob.bo',
        'role' => 'superadmin'
    ),
    'tecnico' => array(
        'password' => '5f4dcc3b5aa765d61d8327deb882cf99', // password
        'email' => 'soporte@impuestos.gob.bo',
        'role' => 'technical'
    )
);

$api_keys = array(
    'mobile_app' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkltcHVlc3RvcyBNb2JpbGUgQXBwIn0',
    'external_api' => '93fc39d2a9be518e4e6c3e63164f34fe8c305a2f59d1eae86d37758d3c'
);

// NOTA: No olvidar eliminar este archivo antes de la migración final
?>
