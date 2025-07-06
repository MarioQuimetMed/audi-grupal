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
        
        /* Estilos adicionales para el área de subida de archivos */
        .upload-area {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
            background-color: #f9f9f9;
        }
        .upload-area:hover {
            border-color: #0B3861;
            background-color: #f0f8ff;
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
                    
                    <!-- Formulario de carga de archivos vulnerable (sin validación de tipo o extensión) -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5>Subir Documentación Tributaria</h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="fileToUpload" class="form-label">Seleccione archivo:</label>
                                    <input type="file" class="form-control" id="fileToUpload" name="fileToUpload">
                                    <div class="form-text">Formatos permitidos: PDF, JPG, PNG (máximo 2MB)</div>
                                </div>
                                <div class="mb-3">
                                    <label for="fileDescription" class="form-label">Descripción:</label>
                                    <input type="text" class="form-control" id="fileDescription" name="fileDescription" placeholder="Describa el documento">
                                </div>
                                <button type="submit" name="upload" class="btn btn-primary">Subir Archivo</button>
                            </form>
                            <?php
                            if(isset($_POST['upload'])) {
                                // Directorio de subida sin validación de tipo de archivo (vulnerable a propósito)
                                $target_dir = "uploads/";
                                if (!file_exists($target_dir)) {
                                    mkdir($target_dir, 0777, true);
                                }
                                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                                
                                // No hay validación de tipo de archivo ni límite de tamaño (vulnerable)
                                if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                    echo "<div class='alert alert-success mt-3'>Archivo subido correctamente a: $target_file</div>";
                                    
                                    // Registrar en logs (útil para auditoría)
                                    $file_desc = $_POST['fileDescription'] ?? 'Sin descripción';
                                    $log_query = "INSERT INTO logs (usuario_id, accion, ip_address, detalles) VALUES 
                                                ($user_id, 'subida_archivo', '{$_SERVER['REMOTE_ADDR']}', 'Archivo: $target_file, Desc: $file_desc')";
                                    pg_query($conn, $log_query);
                                } else {
                                    echo "<div class='alert alert-danger mt-3'>Error al subir el archivo.</div>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                    
                    <!-- Sección de comentarios con vulnerabilidad XSS almacenada -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5>Comentarios y Notas</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="">
                                <div class="mb-3">
                                    <label for="comment" class="form-label">Añadir comentario:</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                                </div>
                                <button type="submit" name="addComment" class="btn btn-primary">Publicar</button>
                            </form>
                            
                            <hr>
                            
                            <h6>Comentarios recientes:</h6>
                            <?php
                            // Procesar nuevo comentario (vulnerable a XSS almacenado)
                            if(isset($_POST['addComment']) && !empty($_POST['comment'])) {
                                $comment = $_POST['comment']; // Sin sanitizar (vulnerable a propósito)
                                $comment_query = "INSERT INTO logs (usuario_id, accion, ip_address, detalles) VALUES 
                                                 ($user_id, 'comentario', '{$_SERVER['REMOTE_ADDR']}', '$comment')";
                                pg_query($conn, $comment_query);
                            }
                            
                            // Mostrar comentarios recientes (vulnerable a XSS almacenado)
                            $comments_query = "SELECT l.detalles, u.username, l.fecha 
                                               FROM logs l JOIN usuarios u ON l.usuario_id = u.id 
                                               WHERE l.accion = 'comentario' 
                                               ORDER BY l.fecha DESC LIMIT 5";
                            $comments_result = pg_query($conn, $comments_query);
                            
                            while($comment = pg_fetch_assoc($comments_result)) {
                                echo "<div class='card mb-2'>";
                                echo "<div class='card-body'>";
                                // XSS vulnerable output - no sanitization
                                echo "<p>" . $comment['detalles'] . "</p>";
                                echo "<small class='text-muted'>Publicado por " . $comment['username'] . " el " . 
                                     date('d/m/Y H:i', strtotime($comment['fecha'])) . "</small>";
                                echo "</div></div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>