<?php
session_start();
require_once 'db.php';

// Comprobar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Obtener información de usuario (simulada)
$query = "SELECT * FROM usuarios WHERE id = $user_id";
$result = pg_query($conn, $query);
$user = pg_fetch_assoc($result);

// Registrar visita al dashboard
$log_query = "INSERT INTO logs (usuario_id, accion, ip_address) VALUES 
              ($user_id, 'visita_dashboard', '{$_SERVER['REMOTE_ADDR']}')";
pg_query($conn, $log_query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Impuestos Nacionales</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        .sidebar {
            background-color: #0B3861;
            color: white;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
        }
        .sidebar a:hover {
            background-color: #0A2A52;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
        .active {
            background-color: #0A2A52;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <h4 class="text-center mb-4">Impuestos Nacionales</h4>
                <nav class="nav flex-column">
                    <a href="#" class="nav-link active">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-file-earmark-text"></i> Mis Declaraciones
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-credit-card"></i> Pagos
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-receipt"></i> Facturas
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-calendar-check"></i> Calendario Fiscal
                    </a>
                    <a href="logs.php" class="nav-link">
                        <i class="bi bi-clock-history"></i> Historial
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-gear"></i> Configuración
                    </a>
                    <a href="logout.php" class="nav-link text-danger">
                        <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 content">
                <div class="header d-flex justify-content-between align-items-center">
                    <h4>Panel de Control</h4>
                    <div class="user-info">
                        <span class="me-2"><i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($username); ?></span>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="row">
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Declaraciones</h5>
                                    <h2>3</h2>
                                    <p>Pendientes este mes</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Pagos</h5>
                                    <h2>2</h2>
                                    <p>Completados</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card bg-warning text-dark">
                                <div class="card-body">
                                    <h5 class="card-title">Facturas</h5>
                                    <h2>15</h2>
                                    <p>Este período</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Notificaciones</h5>
                                    <h2>4</h2>
                                    <p>Sin leer</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h5>Próximas Fechas Importantes</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Concepto</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>10/07/2025</td>
                                        <td>IVA Mensual</td>
                                        <td><span class="badge bg-warning">Pendiente</span></td>
                                    </tr>
                                    <tr>
                                        <td>15/07/2025</td>
                                        <td>IT Mensual</td>
                                        <td><span class="badge bg-warning">Pendiente</span></td>
                                    </tr>
                                    <tr>
                                        <td>30/07/2025</td>
                                        <td>RC-IVA</td>
                                        <td><span class="badge bg-warning">Pendiente</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>