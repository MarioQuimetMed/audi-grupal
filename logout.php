<?php
session_start();
require_once 'db.php';

// Registrar cierre de sesión en logs
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $log_query = "INSERT INTO logs (usuario_id, accion, ip_address) VALUES 
                  ($user_id, 'cierre_sesion', '{$_SERVER['REMOTE_ADDR']}')";
    pg_query($conn, $log_query);
}

// Destruir la sesión
session_unset();
session_destroy();

// Redirigir al inicio
header('Location: index.php');
exit;
?>