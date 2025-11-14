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

// Cargar controlador de categorías
require_once __DIR__ . '/../backend/controllers/CategoriaControler.php';
$categoriaController = new CategoriaController();

// Obtener lista de categorías
$categorias = $categoriaController->listar();

// Cargar controlador de mundiales
require_once __DIR__ . '/../backend/controllers/MundialController.php';
$mundialController = new MundialController();

// Obtener lista de mundiales
$mundiales = $mundialController->listar();

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
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .table-responsive table {
            min-width: 900px;
        }
    </style>
</head>
<body>
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

<?php if(isset($_GET['exito'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 80px; right: 20px; z-index: 9999; max-width: 400px;">
        <i class="fas fa-check-circle me-2"></i>
        <?php echo htmlspecialchars($_GET['exito']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

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

    <div class="dashboard-container">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="dashboard-sidebar">
                        <div class="user-profile-card">
                            <div class="profile-avatar">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <h5 class="profile-name"><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></h5>
                            <span class="profile-role">Administrador</span>
                        </div>

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

                <div class="col-lg-9">
                    <div class="dashboard-content">
                        
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

                            <div class="welcome-alert">
                                <div class="welcome-icon">
                                    <i class="fas fa-hand-sparkles"></i>
                                </div>
                                <div class="welcome-content">
                                    <h4>¡Bienvenido de nuevo!</h4>
                                    <p>Tienes <strong>0 publicaciones pendientes</strong> de aprobación y <strong><?php echo count($usuarios); ?> usuarios</strong> registrados.</p>
                                </div>
                            </div>

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

                        <section id="mundiales" class="content-section <?php echo $seccionActiva === 'mundiales' ? 'active' : ''; ?>">
                            <div class="section-header">
                                <h3>
                                    <i class="fas fa-globe-americas"></i>
                                    Gestionar Mundiales
                                </h3>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearMundialModal">
                                    <i class="fas fa-plus"></i> Nuevo Mundial
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Año</th>
                                            <th>Nombre</th>
                                            <th>Sede</th>
                                            <th>Descripción</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($mundiales && count($mundiales) > 0): ?>
                                            <?php foreach ($mundiales as $mundial): ?>
                                                <tr>
                                                    <td><strong><?php echo htmlspecialchars($mundial['Anio']); ?></strong></td>
                                                    <td><?php echo htmlspecialchars($mundial['Nombre']); ?></td>
                                                    <td>
                                                        <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                                        <?php echo htmlspecialchars($mundial['Sede']); ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        $desc = $mundial['Descripcion'];
                                                        echo $desc ? (strlen($desc) > 50 ? substr(htmlspecialchars($desc), 0, 50) . '...' : htmlspecialchars($desc)) : '<span class="text-muted">Sin descripción</span>';
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-warning" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#editarMundialModal"
                                                                data-id="<?php echo $mundial['id_Mundial']; ?>"
                                                                data-nombre="<?php echo htmlspecialchars($mundial['Nombre']); ?>"
                                                                data-anio="<?php echo $mundial['Anio']; ?>"
                                                                data-sede="<?php echo htmlspecialchars($mundial['Sede']); ?>"
                                                                data-descripcion="<?php echo htmlspecialchars($mundial['Descripcion'] ?? ''); ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    <i class="fas fa-info-circle me-2"></i>
                                                    No hay mundiales registrados. Crea uno nuevo para comenzar.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>

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
                                                                data-activo="<?php echo $usuario['Activo']; ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        
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

                        <section id="categorias" class="content-section <?php echo $seccionActiva === 'categorias' ? 'active' : ''; ?>">
                            <div class="section-header">
                                <h3>
                                    <i class="fas fa-folder-open"></i>
                                    Gestionar Categorías
                                </h3>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearCategoriaModal">
                                    <i class="fas fa-plus"></i> Nueva Categoría
                                </button>
                            </div>

                            <div class="row g-4">
                                <?php if ($categorias && count($categorias) > 0): ?>
                                    <?php foreach ($categorias as $categoria): ?>
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="category-card">
                                            <div class="category-icon">
                                                <i class="fas fa-folder"></i>
                                            </div>
                                            <h5><?php echo htmlspecialchars($categoria['Nombre']); ?></h5>
                                            <div class="category-stats">
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-images me-1"></i>0 publicaciones
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            No hay categorías registradas. Crea una nueva categoría para comenzar.
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </section>

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

    <div class="modal fade" id="crearMundialModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="../backend/api/mundiales.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="accion" value="crear">
                    <div class="modal-header" style="background: linear-gradient(135deg, #6101EB, #FF0050); color: white;">
                        <h5 class="modal-title">
                            <i class="fas fa-globe me-2"></i>Nuevo Mundial
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre_mundial" class="form-label">
                                    <i class="fas fa-trophy me-1"></i>Nombre del Mundial
                                </label>
                                <input type="text" class="form-control" id="nombre_mundial" name="nombre" placeholder="Ej: Copa Mundial de la FIFA" maxlength="100" required>
                            </div>
                            <div class="col-md-6">
                                <label for="anio_mundial" class="form-label">
                                    <i class="fas fa-calendar me-1"></i>Año
                                </label>
                                <input type="number" class="form-control" id="anio_mundial" name="anio" placeholder="2026" min="1930" max="2100" required>
                            </div>
                            <div class="col-12">
                                <label for="sede_mundial" class="form-label">
                                    <i class="fas fa-map-marker-alt me-1"></i>Sede
                                </label>
                                <input type="text" class="form-control" id="sede_mundial" name="sede" placeholder="Ej: México, Estados Unidos y Canadá" maxlength="100" required>
                            </div>
                            <div class="col-12">
                                <label for="logo_mundial" class="form-label">
                                    <i class="fas fa-image me-1"></i>Logo (Opcional)
                                </label>
                                <input type="file" class="form-control" id="logo_mundial" name="logo" accept="image/jpeg,image/png,image/gif,image/webp">
                                <div class="form-text">Formatos: JPG, PNG, GIF, WEBP. Máximo 5MB</div>
                            </div>
                            <div class="col-12">
                                <label for="descripcion_mundial" class="form-label">
                                    <i class="fas fa-align-left me-1"></i>Descripción (Opcional)
                                </label>
                                <textarea class="form-control" id="descripcion_mundial" name="descripcion" rows="3" placeholder="Información adicional sobre el mundial..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Crear Mundial
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarMundialModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="../backend/api/mundiales.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="accion" value="actualizar">
                    <input type="hidden" name="id_mundial" id="edit_id_mundial">
                    <div class="modal-header" style="background: linear-gradient(135deg, #6101EB, #FF0050); color: white;">
                        <h5 class="modal-title">
                            <i class="fas fa-edit me-2"></i>Editar Mundial
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="edit_nombre_mundial" class="form-label">
                                    <i class="fas fa-trophy me-1"></i>Nombre del Mundial
                                </label>
                                <input type="text" class="form-control" id="edit_nombre_mundial" name="nombre" maxlength="100" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_anio_mundial" class="form-label">
                                    <i class="fas fa-calendar me-1"></i>Año
                                </label>
                                <input type="number" class="form-control" id="edit_anio_mundial" name="anio" min="1930" max="2100" required>
                            </div>
                            <div class="col-12">
                                <label for="edit_sede_mundial" class="form-label">
                                    <i class="fas fa-map-marker-alt me-1"></i>Sede
                                </label>
                                <input type="text" class="form-control" id="edit_sede_mundial" name="sede" maxlength="100" required>
                            </div>
                            <div class="col-12">
                                <label for="edit_logo_mundial" class="form-label">
                                    <i class="fas fa-image me-1"></i>Cambiar Logo (Opcional)
                                </label>
                                <input type="file" class="form-control" id="edit_logo_mundial" name="logo" accept="image/jpeg,image/png,image/gif,image/webp">
                                <div class="form-text">Deja vacío si no deseas cambiar el logo. Formatos: JPG, PNG, GIF, WEBP. Máximo 5MB</div>
                            </div>
                            <div class="col-12">
                                <label for="edit_descripcion_mundial" class="form-label">
                                    <i class="fas fa-align-left me-1"></i>Descripción (Opcional)
                                </label>
                                <textarea class="form-control" id="edit_descripcion_mundial" name="descripcion" rows="3"></textarea>
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

    <div class="modal fade" id="crearCategoriaModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="../backend/api/categorias.php" method="POST">
                    <input type="hidden" name="accion" value="crear">
                    <div class="modal-header" style="background: linear-gradient(135deg, #6101EB, #FF0050); color: white;">
                        <h5 class="modal-title">
                            <i class="fas fa-folder-plus me-2"></i>Nueva Categoría
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre_categoria" class="form-label">
                                <i class="fas fa-tag me-1"></i>Nombre de la Categoría
                            </label>
                            <input type="text" class="form-control" id="nombre_categoria" name="nombre" placeholder="Ej: Goles Memorables, Jugadores Legendarios..." minlength="3" maxlength="100" required>
                            <div class="form-text">Mínimo 3 caracteres, máximo 100</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Crear Categoría
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarUsuarioModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #6101EB, #FF0050); color: white;">
                    <h5 class="modal-title">
                        <i class="fas fa-user-edit me-2"></i>Editar Usuario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="../backend/api/usuarios.php">
                    <div class="modal-body">
                        <input type="hidden" name="accion" value="actualizar">
                        <input type="hidden" name="id_usuario" id="edit_id_usuario">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-user me-1"></i>Nombre Completo
                                </label>
                                <input type="text" class="form-control" name="nombre" id="edit_nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-envelope me-1"></i>Correo Electrónico
                                    <small class="text-muted">(No editable)</small>
                                </label>
                                <input type="email" class="form-control" name="correo" id="edit_correo" readonly required style="background-color: #f8f9fa; cursor: not-allowed;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-flag me-1"></i>País de Nacimiento
                                </label>
                                <input type="text" class="form-control" name="pais_nacimiento" id="edit_pais" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-globe me-1"></i>Nacionalidad
                                </label>
                                <input type="text" class="form-control" name="nacionalidad" id="edit_nacionalidad" required>
                            </div>
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
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-calendar me-1"></i>Fecha de Nacimiento
                                </label>
                                <input type="date" class="form-control" name="fecha_nacimiento" id="edit_fecha" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-user-shield me-1"></i>Tipo de Usuario
                                </label>
                                <select class="form-select" name="tipo_usuario" id="edit_tipo">
                                    <option value="0">Usuario Normal</option>
                                    <option value="1">Administrador</option>
                                </select>
                            </div>
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
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalUsuario = document.getElementById('editarUsuarioModal');
        if (modalUsuario) {
            modalUsuario.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (button) {
                    document.getElementById('edit_id_usuario').value = button.getAttribute('data-id') || '';
                    document.getElementById('edit_nombre').value = button.getAttribute('data-nombre') || '';
                    document.getElementById('edit_correo').value = button.getAttribute('data-correo') || '';
                    document.getElementById('edit_pais').value = button.getAttribute('data-pais') || '';
                    document.getElementById('edit_nacionalidad').value = button.getAttribute('data-nacionalidad') || '';
                    document.getElementById('edit_genero').value = button.getAttribute('data-genero') || 'Masculino';
                    document.getElementById('edit_fecha').value = button.getAttribute('data-fecha') || '';
                    document.getElementById('edit_tipo').value = button.getAttribute('data-tipo') || '0';
                    document.getElementById('edit_activo').value = button.getAttribute('data-activo') || '1';
                }
            });
        }
        
        const modalMundial = document.getElementById('editarMundialModal');
        if (modalMundial) {
            modalMundial.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (button) {
                    document.getElementById('edit_id_mundial').value = button.getAttribute('data-id') || '';
                    document.getElementById('edit_nombre_mundial').value = button.getAttribute('data-nombre') || '';
                    document.getElementById('edit_anio_mundial').value = button.getAttribute('data-anio') || '';
                    document.getElementById('edit_sede_mundial').value = button.getAttribute('data-sede') || '';
                    document.getElementById('edit_descripcion_mundial').value = button.getAttribute('data-descripcion') || '';
                }
            });
        }
        
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(alert => {
                if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            });
        }, 5000);
    });
    </script>
    <script src="assets/js/dashboard-admin.js"></script>
</body>
</html>