<?php
session_start();
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Consulta simple sin prevenir inyección SQL (para demostración de vulnerabilidad)
    $query = "SELECT id, username, password_hash FROM usuarios WHERE username = '$username'";
    $result = pg_query($conn, $query);
    
    if ($result && pg_num_rows($result) > 0) {
        $user = pg_fetch_assoc($result);
        
        // Verificación simple de contraseña (hash no seguro para demostrar vulnerabilidad)
        if (md5($password) === $user['password_hash']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            // Registrar el inicio de sesión
            $log_query = "INSERT INTO logs (usuario_id, accion, ip_address) VALUES 
                          ({$user['id']}, 'inicio_sesion', '{$_SERVER['REMOTE_ADDR']}')";
            pg_query($conn, $log_query);
            
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Contraseña incorrecta';
        }
    } else {
        $error = 'Usuario no encontrado';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Impuestos Nacionales</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 450px;
            margin: 100px auto;
        }
        .header-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #0B3861;
            color: white;
            text-align: center;
            border-radius: 10px 10px 0 0 !important;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="header-logo">
            <h2>Servicio de Impuestos Nacionales</h2>
            <p>República de Bolivia</p>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Acceso al Sistema</h4>
            </div>
            <div class="card-body p-4">
                <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="post" action="login.php">
                    <div class="mb-3">
                        <label for="username" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Recordarme</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                </form>
                
                <div class="text-center mt-3">
                    <a href="#" class="text-decoration-none">¿Olvidó su contraseña?</a>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-3">
            <a href="index.php" class="btn btn-outline-secondary btn-sm">Volver al inicio</a>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>