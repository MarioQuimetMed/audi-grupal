<?php
// Archivo de configuración para gestionar backups
// Este archivo debe estar en una ubicación segura, no accesible vía web

// Configuración de base de datos para backups
$backup_config = [
    'db_host' => 'postgres',
    'db_port' => '5432',
    'db_name' => 'impuestos_db',
    'db_user' => 'postgres',
    'db_password' => 'tu_contraseña_segura_aleatoria', // En producción usar una contraseña fuerte
    'backup_path' => '/var/backup',
    'backup_retention_days' => 30
];

// Script de backup seguro
function performBackup() {
    global $backup_config;
    
    $date = date('Ymd_His');
    $backup_file = "{$backup_config['backup_path']}/impuestos_db_$date.sql";
    
    // Comando seguro para backup usando variables de entorno en lugar de parámetros de línea de comandos
    putenv("PGPASSWORD={$backup_config['db_password']}");
    $command = sprintf(
        'pg_dump -h %s -p %s -U %s -d %s -f %s',
        escapeshellarg($backup_config['db_host']),
        escapeshellarg($backup_config['db_port']),
        escapeshellarg($backup_config['db_user']),
        escapeshellarg($backup_config['db_name']),
        escapeshellarg($backup_file)
    );
    
    exec($command, $output, $return_var);
    putenv("PGPASSWORD"); // Limpiar la variable de entorno
    
    if ($return_var === 0) {
        // Compresión
        exec("gzip $backup_file");
        return true;
    }
    
    return false;
}

// Impedir acceso directo a este archivo
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}
?>
