<?php
// Iniciar sesión
session_start();

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php?error=Debes iniciar sesión');
    exit();
}

// Verificar que sea administrador
if ($_SESSION['usuario_tipo'] != 1) {
    header('Location: index.php?error=Acceso denegado');
    exit();
}

// Cargar controlador de usuarios
require_once __DIR__ . '/../backend/controllers/UsuarioController.php';
$usuarioController = new UsuarioController();

// Obtener lista de usuarios
$usuarios = $usuarioController->listar();

// Determinar qué sección mostrar
$seccionActiva = isset($_GET['seccion']) ? $_GET['seccion'] : 'overview';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador - Mundiales FIFA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/dashboard-admin.css">
    <style>
        /* Estilo para scroll horizontal en tabla responsive */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Asegurar que la tabla mantenga su ancho mínimo */
        .table-responsive table {
            min-width: 900px;
        }
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="index.php">
            <img src="assets/logov3.png" alt="Logo FIFA Mundiales" style="height: 48px; vertical-align: middle;">
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto" style="flex-direction: row; justify-content: center; width: 100%;">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><i class="fas fa-home me-1"></i>Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mundiales.php"><i class="fas fa-globe me-1"></i>Mundiales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="galeria.php"><i class="fas fa-images me-1"></i>Galería</a>
                </li>
            </ul>
            
            <ul class="navbar-nav ms-auto" style="flex-direction: row;">
                <li class="nav-item">
                    <span class="nav-link text-primary fw-bold">
                        <i class="fas fa-user-circle me-1"></i>
                        <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>
                    </span>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link btn-outline-warning ms-2" href="dashboard-admin.php">
                        <i class="fas fa-user-shield me-1"></i>Panel Admin
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link btn-outline-danger ms-2" href="../backend/api/auth.php?accion=logout">
                        <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Mensajes de éxito/error -->
<?php if(isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 80px; right: 20px; z-index: 9999; max-width: 400px;">
        <i class="fas fa-check-circle me-2"></i>
        <?php echo htmlspecialchars($_GET['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if(isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 80px; right: 20px; z-index: 9999; max-width: 400px;">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?php echo htmlspecialchars($_GET['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="dashboard-sidebar">
                        <!-- User Profile Card -->
                        <div class="user-profile-card">
                            <div class="profile-avatar">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <h5 class="profile-name"><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></h5>
                            <span class="profile-role">Administrador</span>
                        </div>

                        <!-- Sidebar Menu -->
                        <nav class="sidebar-menu">
                            <a href="?seccion=overview" class="menu-item <?php echo $seccionActiva === 'overview' ? 'active' : ''; ?>">
                                <i class="fas fa-chart-line"></i>
                                <span>Resumen General</span>
                            </a>
                            <a href="?seccion=publicaciones" class="menu-item <?php echo $seccionActiva === 'publicaciones' ? 'active' : ''; ?>">
                                <i class="fas fa-images"></i>
                                <span>Gestionar Publicaciones</span>
                            </a>
                            <a href="?seccion=mundiales" class="menu-item <?php echo $seccionActiva === 'mundiales' ? 'active' : ''; ?>">
                                <i class="fas fa-globe-americas"></i>
                                <span>Gestionar Mundiales</span>
                            </a>
                            <a href="?seccion=usuarios" class="menu-item <?php echo $seccionActiva === 'usuarios' ? 'active' : ''; ?>">
                                <i class="fas fa-users"></i>
                                <span>Gestionar Usuarios</span>
                            </a>
                            <a href="?seccion=categorias" class="menu-item <?php echo $seccionActiva === 'categorias' ? 'active' : ''; ?>">
                                <i class="fas fa-folder-open"></i>
                                <span>Gestionar Categorías</span>
                            </a>
                            <a href="?seccion=comentarios" class="menu-item <?php echo $seccionActiva === 'comentarios' ? 'active' : ''; ?>">
                                <i class="fas fa-comments"></i>
                                <span>Moderar Comentarios</span>
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="dashboard-content">
                        
                        <!-- Overview Section -->
                        <section id="overview" class="content-section <?php echo $seccionActiva === 'overview' ? 'active' : ''; ?>">
                            <div class="section-header">
                                <h3>
                                    <i class="fas fa-chart-line"></i>
                                    Resumen General
                                </h3>
                                <span class="current-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <?php echo date('d/m/Y'); ?>
                                </span>
                            </div>

                            <!-- Welcome Alert -->
                            <div class="welcome-alert">
                                <div class="welcome-icon">
                                    <i class="fas fa-hand-sparkles"></i>
                                </div>
                                <div class="welcome-content">
                                    <h4>¡Bienvenido de nuevo!</h4>
                                    <p>Tienes <strong>0 publicaciones pendientes</strong> de aprobación y <strong><?php echo count($usuarios); ?> usuarios</strong> registrados.</p>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <h4 class="section-subtitle">
                                <i class="fas fa-bolt"></i>
                                Acciones Rápidas
                            </h4>
                            <div class="action-cards">
                                <a href="?seccion=publicaciones" class="action-card">
                                    <span class="action-badge">0</span>
                                    <div class="action-icon">
                                        <i class="fas fa-clipboard-check"></i>
                                    </div>
                                    <h5>Aprobar Publicaciones</h5>
                                    <p>Revisar contenido pendiente</p>
                                </a>

                                <a href="?seccion=mundiales" class="action-card">
                                    <div class="action-icon">
                                        <i class="fas fa-globe"></i>
                                    </div>
                                    <h5>Gestionar Mundiales</h5>
                                    <p>Crear y editar mundiales</p>
                                </a>

                                <a href="?seccion=categorias" class="action-card">
                                    <div class="action-icon">
                                        <i class="fas fa-tags"></i>
                                    </div>
                                    <h5>Gestionar Categorías</h5>
                                    <p>Administrar categorías</p>
                                </a>

                                <a href="?seccion=usuarios" class="action-card">
                                    <div class="action-icon">
                                        <i class="fas fa-user-cog"></i>
                                    </div>
                                    <h5>Gestionar Usuarios</h5>
                                    <p>Ver y administrar usuarios</p>
                                </a>
                            </div>
                        </section>

                        <!-- Publicaciones Section -->
                        <section id="publicaciones" class="content-section <?php echo $seccionActiva === 'publicaciones' ? 'active' : ''; ?>">
                            <div class="section-header">
                                <h3>
                                    <i class="fas fa-images"></i>
                                    Gestionar Publicaciones
                                </h3>
                                <div class="header-actions">
                                    <select class="form-select form-select-sm">
                                        <option>Todas las publicaciones</option>
                                        <option>Pendientes</option>
                                        <option>Aprobadas</option>
                                        <option>Rechazadas</option>
                                    </select>
                                </div>
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                No hay publicaciones aún. Los usuarios pueden crear publicaciones desde la página principal.
                            </div>
                        </section>

                        <!-- Mundiales Section -->
                        <section id="mundiales" class="content-section <?php echo $seccionActiva === 'mundiales' ? 'active' : ''; ?>">
                            <div class="section-header">
                                <h3>
                                    <i class="fas fa-globe-americas"></i>
                                    Gestionar Mundiales
                                </h3>
                                <button class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Nuevo Mundial
                                </button>
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                La gestión de mundiales estará disponible próximamente.
                            </div>
                        </section>

                        <!-- Usuarios Section -->
                        <section id="usuarios" class="content-section <?php echo $seccionActiva === 'usuarios' ? 'active' : ''; ?>">
                            <div class="section-header">
                                <h3>
                                    <i class="fas fa-users"></i>
                                    Gestionar Usuarios
                                </h3>
                                <div class="header-actions">
                                    <span class="badge bg-info"><?php echo count($usuarios); ?> usuarios</span>
                                </div>
                            </div>

                            <!-- Users Table con scroll horizontal -->
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Usuario</th>
                                            <th>Email</th>
                                            <th>País</th>
                                            <th>Fecha Registro</th>
                                            <th>Publicaciones</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($usuarios)): ?>
                                            <?php foreach ($usuarios as $usuario): ?>
                                                <tr>
                                                    <td>
                                                        <div class="user-info-cell">
                                                            <div class="user-avatar-sm">
                                                                <?php 
                                                                $nombre = htmlspecialchars($usuario['Nombre']);
                                                                $iniciales = '';
                                                                $palabras = explode(' ', $nombre);
                                                                foreach ($palabras as $palabra) {
                                                                    if (!empty($palabra)) {
                                                                        $iniciales .= strtoupper(substr($palabra, 0, 1));
                                                                        if (strlen($iniciales) >= 2) break;
                                                                    }
                                                                }
                                                                echo $iniciales;
                                                                ?>
                                                            </div>
                                                            <span><?php echo $nombre; ?></span>
                                                        </div>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($usuario['Correo']); ?></td>
                                                    <td>
                                                        <?php 
                                                        // Manejo seguro del campo País
                                                        echo isset($usuario['Pais_Nacimiento']) ? htmlspecialchars($usuario['Pais_Nacimiento']) : 'N/A'; 
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        $fecha = new DateTime($usuario['Fecha_Registro']);
                                                        echo $fecha->format('d/m/Y'); 
                                                        ?>
                                                    </td>
                                                    <td><span class="badge bg-primary">0</span></td>
                                                    <td>
                                                        <?php if ($usuario['Activo'] == 1): ?>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" checked disabled>
                                                                <label class="form-check-label status-active">Activo</label>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" disabled>
                                                                <label class="form-check-label status-inactive">Inactivo</label>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <!-- Botón Editar -->
                                                        <button type="button" class="btn btn-sm btn-warning" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#editarUsuarioModal"
                                                                data-id="<?php echo $usuario['id_Usuario']; ?>"
                                                                data-nombre="<?php echo htmlspecialchars($usuario['Nombre']); ?>"
                                                                data-correo="<?php echo htmlspecialchars($usuario['Correo']); ?>"
                                                                data-pais="<?php echo isset($usuario['Pais_Nacimiento']) ? htmlspecialchars($usuario['Pais_Nacimiento']) : ''; ?>"
                                                                data-nacionalidad="<?php echo isset($usuario['Nacionalidad']) ? htmlspecialchars($usuario['Nacionalidad']) : ''; ?>"
                                                                data-genero="<?php echo isset($usuario['Genero']) ? htmlspecialchars($usuario['Genero']) : 'Masculino'; ?>"
                                                                data-fecha="<?php echo isset($usuario['Fecha_Nacimiento']) ? $usuario['Fecha_Nacimiento'] : ''; ?>"
                                                                data-tipo="<?php echo $usuario['Tipo_Usuario']; ?>"
                                                                data-activo="<?php echo $usuario['Activo']; ?>"
                                                                title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        
                                                        <!-- Botón Eliminar -->
                                                        <?php if ($usuario['id_Usuario'] != $_SESSION['usuario_id']): ?>
                                                            <form method="POST" action="../backend/api/usuarios.php" 
                                                                  style="display: inline;"
                                                                  onsubmit="return confirm('¿Estás seguro de eliminar a <?php echo htmlspecialchars($usuario['Nombre']); ?>?');">
                                                                <input type="hidden" name="accion" value="eliminar">
                                                                <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_Usuario']; ?>">
                                                                <button type="submit" class="btn btn-sm btn-danger" title="Desactivar">
                                                                    <i class="fas fa-ban"></i>
                                                                </button>
                                                            </form>
                                                        <?php else: ?>
                                                            <button type="button" class="btn btn-sm btn-secondary" disabled 
                                                                    title="No puedes eliminarte a ti mismo">
                                                                <i class="fas fa-user-shield"></i>
                                                            </button>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">
                                                    No hay usuarios registrados
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                        <!-- Categorías Section -->
                        <section id="categorias" class="content-section <?php echo $seccionActiva === 'categorias' ? 'active' : ''; ?>">
                            <div class="section-header">
                                <h3>
                                    <i class="fas fa-folder-open"></i>
                                    Gestionar Categorías
                                </h3>
                                <button class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Nueva Categoría
                                </button>
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                La gestión de categorías estará disponible próximamente.
                            </div>
                        </section>

                        <!-- Comentarios Section -->
                        <section id="comentarios" class="content-section <?php echo $seccionActiva === 'comentarios' ? 'active' : ''; ?>">
                            <div class="section-header">
                                <h3>
                                    <i class="fas fa-comments"></i>
                                    Moderar Comentarios
                                </h3>
                                <select class="form-select form-select-sm">
                                    <option>Todos los comentarios</option>
                                    <option>Recientes</option>
                                    <option>Reportados</option>
                                </select>
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                No hay comentarios para moderar aún.
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Usuario -->
    <div class="modal fade" id="editarUsuarioModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #6101EB, #FF0050); color: white;">
                    <h5 class="modal-title">
                        <i class="fas fa-user-edit me-2"></i>Editar Usuario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="../backend/api/usuarios.php" id="formEditarUsuario">
                    <div class="modal-body">
                        <input type="hidden" name="accion" value="actualizar">
                        <input type="hidden" name="id_usuario" id="edit_id_usuario">
                        
                        <div class="row g-3">
                            <!-- Nombre -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-user me-1"></i>Nombre Completo
                                </label>
                                <input type="text" class="form-control" name="nombre" id="edit_nombre" required>
                            </div>
                            
                            <!-- Correo -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-envelope me-1"></i>Correo Electrónico
                                </label>
                                <input type="email" class="form-control" name="correo" id="edit_correo" required>
                            </div>
                            
                            <!-- País de Nacimiento -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-flag me-1"></i>País de Nacimiento
                                </label>
                                <input type="text" class="form-control" name="pais_nacimiento" id="edit_pais" required>
                            </div>
                            
                            <!-- Nacionalidad -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-globe me-1"></i>Nacionalidad
                                </label>
                                <input type="text" class="form-control" name="nacionalidad" id="edit_nacionalidad" required>
                            </div>
                            
                            <!-- Género -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-venus-mars me-1"></i>Género
                                </label>
                                <select class="form-select" name="genero" id="edit_genero" required>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            
                            <!-- Fecha de Nacimiento -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-calendar me-1"></i>Fecha de Nacimiento
                                </label>
                                <input type="date" class="form-control" name="fecha_nacimiento" id="edit_fecha" required>
                            </div>
                            
                            <!-- Tipo de Usuario -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-user-shield me-1"></i>Tipo de Usuario
                                </label>
                                <select class="form-select" name="tipo_usuario" id="edit_tipo">
                                    <option value="0">Usuario Normal</option>
                                    <option value="1">Administrador</option>
                                </select>
                            </div>
                            
                            <!-- Estado -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-toggle-on me-1"></i>Estado
                                </label>
                                <select class="form-select" name="activo" id="edit_activo">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer pb-2 pt-4" id="main-footer">
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="text-white">FIFA Mundiales</h5>
                    <p class="text-white-50 mb-0">Proyecto académico - Bases de Datos Multimedia</p>
                    <p class="text-white-50">UANL - Facultad de Ciencias Físico Matemáticas</p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    </div>
                    <p class="text-white-50 mt-2 mb-0">&copy; 2025 FIFA Mundiales. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/dashboard-admin.js"></script>
    <script>
    // Poblar modal de edición con datos del usuario
    document.getElementById('editarUsuarioModal').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        
        // Obtener datos del botón
        const id = button.getAttribute('data-id');
        const nombre = button.getAttribute('data-nombre');
        const correo = button.getAttribute('data-correo');
        const pais = button.getAttribute('data-pais');
        const nacionalidad = button.getAttribute('data-nacionalidad');
        const genero = button.getAttribute('data-genero');
        const fecha = button.getAttribute('data-fecha');
        const tipo = button.getAttribute('data-tipo');
        const activo = button.getAttribute('data-activo');
        
        // Llenar el formulario
        document.getElementById('edit_id_usuario').value = id;
        document.getElementById('edit_nombre').value = nombre;
        document.getElementById('edit_correo').value = correo;
        document.getElementById('edit_pais').value = pais;
        document.getElementById('edit_nacionalidad').value = nacionalidad;
        document.getElementById('edit_genero').value = genero;
        document.getElementById('edit_fecha').value = fecha;
        document.getElementById('edit_tipo').value = tipo;
        document.getElementById('edit_activo').value = activo;
    });

    // Auto-cerrar alertas después de 5 segundos
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
    </script>
</body>
</html>