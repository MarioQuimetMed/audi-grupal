<?php
// Este archivo expone una API para consulta de datos básicos
// ADVERTENCIA: No tiene autenticación adecuada (vulnerable a propósito)

header('Content-Type: application/json');

include_once '../db.php';

// Endpoint para consultar usuario por NIT
if (isset($_GET['nit'])) {
    $nit = $_GET['nit'];
    
    // Consulta vulnerable a inyección SQL (a propósito para auditoría)
    $query = "SELECT id, username, nombre, email, nit, tipo, estado, fecha_registro 
              FROM usuarios WHERE nit = '$nit'";
    $result = pg_query($conn, $query);
    
    if ($result && pg_num_rows($result) > 0) {
        $user = pg_fetch_assoc($result);
        echo json_encode(['status' => 'success', 'data' => $user]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado']);
    }
    exit;
}

// Endpoint para consultar facturas (sin autenticación adecuada)
if (isset($_GET['facturas']) && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id']; // Sin validación (vulnerable)
    
    $query = "SELECT * FROM facturas WHERE usuario_id = $user_id";
    $result = pg_query($conn, $query);
    
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
