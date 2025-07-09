<?php
// Este archivo expone una API para consulta de datos básicos
// Con autenticación mediante API key

header('Content-Type: application/json');

include_once '../db.php';

// Verificar API key
function verifyApiKey() {
    $headers = getallheaders();
    $api_key = $headers['X-Api-Key'] ?? '';
    
    // Lista de API keys válidas (en producción esto debería estar en una base de datos segura)
    $valid_keys = [
        '93fc39d2a9be518e4e6c3e63164f34fe8c305a2f59d1eae86d37758d3c'
    ];
    
    return in_array($api_key, $valid_keys);
}

// Verificar si la API key es válida
if (!verifyApiKey()) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized - API key inválida o faltante']);
    exit;
}

// Rate limiting básico
session_start();
$current_time = time();
$rate_limit_window = 60; // 60 segundos
$rate_limit = 10; // 10 peticiones por minuto

if (!isset($_SESSION['api_calls'])) {
    $_SESSION['api_calls'] = [];
}

// Limpiar llamadas antiguas
$_SESSION['api_calls'] = array_filter($_SESSION['api_calls'], function($timestamp) use ($current_time, $rate_limit_window) {
    return $current_time - $timestamp < $rate_limit_window;
});

// Verificar límite de peticiones
if (count($_SESSION['api_calls']) >= $rate_limit) {
    http_response_code(429);
    echo json_encode(['status' => 'error', 'message' => 'Demasiadas peticiones. Inténtelo de nuevo más tarde.']);
    exit;
}

// Registrar esta llamada
$_SESSION['api_calls'][] = $current_time;

// Endpoint para consultar usuario por NIT (con protección contra SQL injection)
if (isset($_GET['nit'])) {
    $nit = $_GET['nit'];
    
    // Consulta usando sentencias preparadas
    $query = "SELECT id, username, nombre, email, nit, tipo, estado, fecha_registro 
              FROM usuarios WHERE nit = $1";
    $result = pg_query_params($conn, $query, array($nit));
    
    if ($result && pg_num_rows($result) > 0) {
        $user = pg_fetch_assoc($result);
        echo json_encode(['status' => 'success', 'data' => $user]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado']);
    }
    exit;
}

// Endpoint para consultar facturas (con validación)
if (isset($_GET['facturas']) && isset($_GET['user_id'])) {
    // Validar que user_id sea numérico
    $user_id = filter_var($_GET['user_id'], FILTER_VALIDATE_INT);
    if ($user_id === false) {
        echo json_encode(['status' => 'error', 'message' => 'ID de usuario inválido']);
        exit;
    }
    
    // Consulta con parámetros preparados
    $query = "SELECT * FROM facturas WHERE usuario_id = $1";
    $result = pg_query_params($conn, $query, array($user_id));
    
    $facturas = [];
    while($row = pg_fetch_assoc($result)) {
        $facturas[] = $row;
    }
    
    echo json_encode(['status' => 'success', 'data' => $facturas]);
    exit;
}

// Si no se especificó ningún endpoint válido
echo json_encode(['status' => 'error', 'message' => 'Endpoint no válido']);
?>
