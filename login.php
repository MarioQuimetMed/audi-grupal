<?php
// Configuración temporal para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Verificar que la conexión está establecida
    if (!$conn) {
        error_log("Error: Conexión a base de datos no disponible en login.php");
        die("Error de conexión a la base de datos");
    }
    
    // Consulta usando sentencias preparadas para prevenir inyección SQL
    $query = "SELECT id, username, password_hash FROM usuarios WHERE username = $1";
    $result = pg_query_params($conn, $query, array($username));
    
    // Verificar si hubo error en la consulta
    if (!$result) {
        error_log("Error en consulta SQL: " . pg_last_error($conn));
        file_put_contents(__DIR__ . '/query_error.log', date('[Y-m-d H:i:s] ') . "Error en consulta: " . pg_last_error($conn) . " - Usuario: $username\n", FILE_APPEND);
    }
    
    if ($result && pg_num_rows($result) > 0) {
        $user = pg_fetch_assoc($result);
        
        // Temporalmente usando MD5 para la verificación de contraseñas
        // Nota: Esto es solo para compatibilidad con los hashes existentes
        if (md5($password) === $user['password_hash']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            // Registrar el inicio de sesión usando sentencias preparadas
            $log_query = "INSERT INTO logs (usuario_id, accion, ip_address) VALUES 
                          ($1, $2, $3)";
            pg_query_params($conn, $log_query, array($user['id'], 'inicio_sesion', $_SERVER['REMOTE_ADDR']));
            
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container login-container">
        <div class="login-header">
            <img src="assets/images/logo.png" alt="Logo Impuestos Nacionales" class="login-logo">
            <h2>Servicio de Impuestos Nacionales</h2>
            <p class="text-muted">República de Bolivia</p>
        </div>

        <div class="login-card card">
            <div class="login-card-header">
                <h4 class="mb-0"><i class="bi bi-shield-lock"></i> Acceso al Sistema</h4>
            </div>
            <div class="card-body login-form">
                <?php if ($error): ?>
                <div class="alert alert-danger text-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>

                <form method="post" action="login.php">
                    <div class="mb-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-person-fill text-primary"></i></span>
                            <input type="text" class="form-control login-form-input" id="username" name="username" placeholder="Ingrese su usuario" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-key-fill text-primary"></i></span>
                            <input type="password" class="form-control login-form-input" id="password" name="password" placeholder="Ingrese su contraseña" required>
                        </div>
                    </div>
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Recordarme</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 login-button">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Ingresar
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="#" class="text-decoration-none"><i class="bi bi-question-circle me-1"></i>¿Olvidó su contraseña?</a>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-outline-secondary">
                <i class="bi bi-house-fill me-2"></i>Volver al inicio
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>