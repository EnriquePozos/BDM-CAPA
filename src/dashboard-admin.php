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
</head>
<body>
    <?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si hay sesión activa
$sesionActiva = isset($_SESSION['usuario_id']);
?>
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
                    <a class="nav-link active" href="index.php"><i class="fas fa-home me-1"></i>Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mundiales.php"><i class="fas fa-globe me-1"></i>Mundiales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="galeria.php"><i class="fas fa-images me-1"></i>Galería</a>
                </li>
            </ul>
            
            <ul class="navbar-nav ms-auto" style="flex-direction: row;">
                <?php if ($sesionActiva): ?>
                    <!-- Usuario CON sesión activa -->
                    <li class="nav-item">
                        <span class="nav-link text-primary fw-bold">
                            <i class="fas fa-user-circle me-1"></i>
                            <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>
                        </span>
                    </li>
                    
                    <?php if ($_SESSION['usuario_tipo'] == 1): ?>
                        <li class="nav-item">
                            <a class="nav-link btn-outline-warning ms-2" href="dashboard-admin.php">
                                <i class="fas fa-user-shield me-1"></i>Panel Admin
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <li class="nav-item">
                        <a class="nav-link btn-outline-danger ms-2" href="../backend/api/auth.php?accion=logout">
                            <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                        </a>
                    </li>
                    
                <?php else: ?>
                    <!-- Usuario SIN sesión -->
                    <li class="nav-item">
                        <a class="nav-link btn-outline-primary ms-2" href="login.php">
                            <i class="fas fa-sign-in-alt me-1"></i>Iniciar Sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-primary text-white ms-2" href="registro.php">
                            <i class="fas fa-user-plus me-1"></i>Registrarse
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

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
                            <h5 class="profile-name">Admin Principal</h5>
                            <span class="profile-role">Administrador</span>
                        </div>

                        <!-- Sidebar Menu -->
                        <nav class="sidebar-menu">
                            <a href="#" class="menu-item active" data-section="overview">
                                <i class="fas fa-chart-line"></i>
                                <span>Resumen General</span>
                            </a>
                            <a href="#" class="menu-item" data-section="publicaciones">
                                <i class="fas fa-images"></i>
                                <span>Gestionar Publicaciones</span>
                            </a>
                            <a href="#" class="menu-item" data-section="mundiales">
                                <i class="fas fa-globe-americas"></i>
                                <span>Gestionar Mundiales</span>
                            </a>
                            <a href="#" class="menu-item" data-section="usuarios">
                                <i class="fas fa-users"></i>
                                <span>Gestionar Usuarios</span>
                            </a>
                            <a href="#" class="menu-item" data-section="categorias">
                                <i class="fas fa-folder-open"></i>
                                <span>Gestionar Categorías</span>
                            </a>
                            <a href="#" class="menu-item" data-section="comentarios">
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
                        <section id="overview" class="content-section active">
                            <div class="section-header">
                                <h3>
                                    <i class="fas fa-chart-line"></i>
                                    Resumen General
                                </h3>
                                <span class="current-date">
                                    <i class="far fa-calendar-alt"></i>
                                    23 de Octubre, 2025
                                </span>
                            </div>

                            <!-- Welcome Alert -->
                            <div class="welcome-alert">
                                <div class="welcome-icon">
                                    <i class="fas fa-hand-sparkles"></i>
                                </div>
                                <div class="welcome-content">
                                    <h4>¡Bienvenido de nuevo!</h4>
                                    <p>Tienes <strong>15 publicaciones pendientes</strong> de aprobación y <strong>3 nuevos usuarios</strong> registrados hoy.</p>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <h4 class="section-subtitle">
                                <i class="fas fa-bolt"></i>
                                Acciones Rápidas
                            </h4>
                            <div class="action-cards">
                                <a href="#" class="action-card" data-goto="publicaciones">
                                    <span class="action-badge">15</span>
                                    <div class="action-icon">
                                        <i class="fas fa-clipboard-check"></i>
                                    </div>
                                    <h5>Aprobar Publicaciones</h5>
                                    <p>Revisar contenido pendiente</p>
                                </a>

                                <a href="#" class="action-card" data-goto="mundiales">
                                    <div class="action-icon">
                                        <i class="fas fa-globe"></i>
                                    </div>
                                    <h5>Gestionar Mundiales</h5>
                                    <p>Crear y editar mundiales</p>
                                </a>

                                <a href="#" class="action-card" data-goto="categorias">
                                    <div class="action-icon">
                                        <i class="fas fa-tags"></i>
                                    </div>
                                    <h5>Gestionar Categorías</h5>
                                    <p>Administrar categorías</p>
                                </a>

                                <a href="#" class="action-card" data-goto="usuarios">
                                    <div class="action-icon">
                                        <i class="fas fa-user-cog"></i>
                                    </div>
                                    <h5>Gestionar Usuarios</h5>
                                    <p>Ver y administrar usuarios</p>
                                </a>
                            </div>
                        </section>

                        <!-- Publicaciones Section -->
                        <section id="publicaciones" class="content-section">
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

                            <!-- Filter Tabs -->
                            <ul class="filter-tabs">
                                <li class="tab-item active">Todas (1558)</li>
                                <li class="tab-item">Pendientes (15)</li>
                                <li class="tab-item">Aprobadas (1543)</li>
                            </ul>

                            <!-- Publications List -->
                            <div class="publications-grid">
                                <!-- Publication Item 1 -->
                                <div class="publication-card pending">
                                    <div class="publication-image">
                                        <img src="https://via.placeholder.com/400x250" alt="Publicación">
                                        <span class="status-badge pending">Pendiente</span>
                                    </div>
                                    <div class="publication-body">
                                        <h5 class="publication-title">Gol histórico de Maradona en México 86</h5>
                                        <div class="publication-meta">
                                            <span><i class="fas fa-user"></i> Juan Pérez</span>
                                            <span><i class="fas fa-trophy"></i> México 1986</span>
                                            <span><i class="fas fa-tag"></i> Jugadas</span>
                                        </div>
                                        <div class="publication-stats">
                                            <span><i class="fas fa-heart"></i> 0</span>
                                            <span><i class="fas fa-comment"></i> 0</span>
                                            <span><i class="fas fa-eye"></i> 0</span>
                                        </div>
                                    </div>
                                    <div class="publication-actions">
                                        <button class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i> Aprobar
                                        </button>
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-times"></i> Rechazar
                                        </button>
                                        <button class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Ver
                                        </button>
                                    </div>
                                </div>

                                <!-- Publication Item 2 -->
                                <div class="publication-card approved">
                                    <div class="publication-image">
                                        <img src="https://via.placeholder.com/400x250" alt="Publicación">
                                        <span class="status-badge approved">Aprobada</span>
                                    </div>
                                    <div class="publication-body">
                                        <h5 class="publication-title">La final más emocionante: Brasil 2014</h5>
                                        <div class="publication-meta">
                                            <span><i class="fas fa-user"></i> María García</span>
                                            <span><i class="fas fa-trophy"></i> Brasil 2014</span>
                                            <span><i class="fas fa-tag"></i> Partidos</span>
                                        </div>
                                        <div class="publication-stats">
                                            <span><i class="fas fa-heart"></i> 234</span>
                                            <span><i class="fas fa-comment"></i> 45</span>
                                            <span><i class="fas fa-eye"></i> 1,234</span>
                                        </div>
                                    </div>
                                    <div class="publication-actions">
                                        <button class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Ver
                                        </button>
                                        <button class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </div>

                                <!-- Publication Item 3 -->
                                <div class="publication-card pending">
                                    <div class="publication-image">
                                        <img src="https://via.placeholder.com/400x250" alt="Publicación">
                                        <span class="status-badge pending">Pendiente</span>
                                    </div>
                                    <div class="publication-body">
                                        <h5 class="publication-title">Estadio Azteca: Sede legendaria</h5>
                                        <div class="publication-meta">
                                            <span><i class="fas fa-user"></i> Carlos López</span>
                                            <span><i class="fas fa-trophy"></i> México 1986</span>
                                            <span><i class="fas fa-tag"></i> Sedes</span>
                                        </div>
                                        <div class="publication-stats">
                                            <span><i class="fas fa-heart"></i> 0</span>
                                            <span><i class="fas fa-comment"></i> 0</span>
                                            <span><i class="fas fa-eye"></i> 0</span>
                                        </div>
                                    </div>
                                    <div class="publication-actions">
                                        <button class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i> Aprobar
                                        </button>
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-times"></i> Rechazar
                                        </button>
                                        <button class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Ver
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <nav class="pagination-nav">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                                    </li>
                                </ul>
                            </nav>
                        </section>

                        <!-- Mundiales Section -->
                        <section id="mundiales" class="content-section">
                            <div class="section-header">
                                <h3>
                                    <i class="fas fa-globe-americas"></i>
                                    Gestionar Mundiales
                                </h3>
                                <button class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Nuevo Mundial
                                </button>
                            </div>

                            <!-- Mundiales Table -->
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Año</th>
                                            <th>Nombre</th>
                                            <th>País Sede</th>
                                            <th>Campeón</th>
                                            <th>Publicaciones</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>2022</strong></td>
                                            <td>Qatar 2022</td>
                                            <td>
                                                <img src="https://flagcdn.com/w20/qa.png" alt="Qatar" class="flag-icon">
                                                Qatar
                                            </td>
                                            <td>
                                                <img src="https://flagcdn.com/w20/ar.png" alt="Argentina" class="flag-icon">
                                                Argentina
                                            </td>
                                            <td><span class="badge bg-info">234</span></td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" checked>
                                                    <label class="form-check-label status-active">Activo</label>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-info" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>2018</strong></td>
                                            <td>Rusia 2018</td>
                                            <td>
                                                <img src="https://flagcdn.com/w20/ru.png" alt="Rusia" class="flag-icon">
                                                Rusia
                                            </td>
                                            <td>
                                                <img src="https://flagcdn.com/w20/fr.png" alt="Francia" class="flag-icon">
                                                Francia
                                            </td>
                                            <td><span class="badge bg-info">456</span></td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" checked>
                                                    <label class="form-check-label status-active">Activo</label>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-info" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>2014</strong></td>
                                            <td>Brasil 2014</td>
                                            <td>
                                                <img src="https://flagcdn.com/w20/br.png" alt="Brasil" class="flag-icon">
                                                Brasil
                                            </td>
                                            <td>
                                                <img src="https://flagcdn.com/w20/de.png" alt="Alemania" class="flag-icon">
                                                Alemania
                                            </td>
                                            <td><span class="badge bg-info">389</span></td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label status-inactive">Inactivo</label>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-info" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>2010</strong></td>
                                            <td>Sudáfrica 2010</td>
                                            <td>
                                                <img src="https://flagcdn.com/w20/za.png" alt="Sudáfrica" class="flag-icon">
                                                Sudáfrica
                                            </td>
                                            <td>
                                                <img src="https://flagcdn.com/w20/es.png" alt="España" class="flag-icon">
                                                España
                                            </td>
                                            <td><span class="badge bg-info">267</span></td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" checked>
                                                    <label class="form-check-label status-active">Activo</label>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-info" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                        <!-- Usuarios Section -->
                        <section id="usuarios" class="content-section">
                            <div class="section-header">
                                <h3>
                                    <i class="fas fa-users"></i>
                                    Gestionar Usuarios
                                </h3>
                                <div class="search-box">
                                    <i class="fas fa-search"></i>
                                    <input type="text" class="form-control" placeholder="Buscar usuario...">
                                </div>
                            </div>

                            <!-- Users Table -->
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
                                        <tr>
                                            <td>
                                                <div class="user-info-cell">
                                                    <div class="user-avatar-sm">JP</div>
                                                    <span>Juan Pérez</span>
                                                </div>
                                            </td>
                                            <td>juan.perez@email.com</td>
                                            <td>
                                                <img src="https://flagcdn.com/w20/mx.png" alt="México" class="flag-icon">
                                                México
                                            </td>
                                            <td>15/10/2025</td>
                                            <td><span class="badge bg-primary">12</span></td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" checked>
                                                    <label class="form-check-label status-active">Activo</label>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info" title="Ver perfil">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" title="Desactivar">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="user-info-cell">
                                                    <div class="user-avatar-sm">MG</div>
                                                    <span>María García</span>
                                                </div>
                                            </td>
                                            <td>maria.garcia@email.com</td>
                                            <td>
                                                <img src="https://flagcdn.com/w20/es.png" alt="España" class="flag-icon">
                                                España
                                            </td>
                                            <td>10/10/2025</td>
                                            <td><span class="badge bg-primary">28</span></td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" checked>
                                                    <label class="form-check-label status-active">Activo</label>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info" title="Ver perfil">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" title="Desactivar">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="user-info-cell">
                                                    <div class="user-avatar-sm">CL</div>
                                                    <span>Carlos López</span>
                                                </div>
                                            </td>
                                            <td>carlos.lopez@email.com</td>
                                            <td>
                                                <img src="https://flagcdn.com/w20/ar.png" alt="Argentina" class="flag-icon">
                                                Argentina
                                            </td>
                                            <td>08/10/2025</td>
                                            <td><span class="badge bg-primary">45</span></td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox">
                                                    <label class="form-check-label status-inactive">Inactivo</label>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info" title="Ver perfil">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-success" title="Activar">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                        <!-- Categorías Section -->
                        <section id="categorias" class="content-section">
                            <div class="section-header">
                                <h3>
                                    <i class="fas fa-folder-open"></i>
                                    Gestionar Categorías
                                </h3>
                                <button class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Nueva Categoría
                                </button>
                            </div>

                            <!-- Categories Grid -->
                            <div class="categories-grid">
                                <div class="category-card">
                                    <div class="category-icon">
                                        <i class="fas fa-futbol"></i>
                                    </div>
                                    <h5>Jugadas</h5>
                                    <p>234 publicaciones</p>
                                    <div class="category-actions">
                                        <button class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="category-card">
                                    <div class="category-icon">
                                        <i class="fas fa-microphone"></i>
                                    </div>
                                    <h5>Entrevistas</h5>
                                    <p>156 publicaciones</p>
                                    <div class="category-actions">
                                        <button class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="category-card">
                                    <div class="category-icon">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                    <h5>Partidos</h5>
                                    <p>445 publicaciones</p>
                                    <div class="category-actions">
                                        <button class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="category-card">
                                    <div class="category-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <h5>Estadísticas</h5>
                                    <p>189 publicaciones</p>
                                    <div class="category-actions">
                                        <button class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="category-card">
                                    <div class="category-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <h5>Sedes</h5>
                                    <p>98 publicaciones</p>
                                    <div class="category-actions">
                                        <button class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="category-card">
                                    <div class="category-icon">
                                        <i class="fas fa-flag"></i>
                                    </div>
                                    <h5>Cultura</h5>
                                    <p>167 publicaciones</p>
                                    <div class="category-actions">
                                        <button class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Comentarios Section -->
                        <section id="comentarios" class="content-section">
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

                            <!-- Comments List -->
                            <div class="comments-list">
                                <div class="comment-item">
                                    <div class="comment-user">
                                        <div class="user-avatar-sm">JP</div>
                                        <div class="comment-info">
                                            <strong>Juan Pérez</strong>
                                            <span class="comment-date">Hace 2 horas</span>
                                        </div>
                                    </div>
                                    <div class="comment-content">
                                        <p>¡Qué jugada increíble! Sin duda uno de los mejores goles de la historia del fútbol.</p>
                                        <div class="comment-meta">
                                            En: <a href="#">Gol histórico de Maradona en México 86</a>
                                        </div>
                                    </div>
                                    <div class="comment-actions">
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </div>

                                <div class="comment-item">
                                    <div class="comment-user">
                                        <div class="user-avatar-sm">MG</div>
                                        <div class="comment-info">
                                            <strong>María García</strong>
                                            <span class="comment-date">Hace 5 horas</span>
                                        </div>
                                    </div>
                                    <div class="comment-content">
                                        <p>Gran recopilación de momentos históricos. Me encantaría ver más contenido así.</p>
                                        <div class="comment-meta">
                                            En: <a href="#">La final más emocionante: Brasil 2014</a>
                                        </div>
                                    </div>
                                    <div class="comment-actions">
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </div>

                                <div class="comment-item reported">
                                    <span class="reported-badge">
                                        <i class="fas fa-exclamation-triangle"></i> Reportado
                                    </span>
                                    <div class="comment-user">
                                        <div class="user-avatar-sm">CL</div>
                                        <div class="comment-info">
                                            <strong>Carlos López</strong>
                                            <span class="comment-date">Hace 1 día</span>
                                        </div>
                                    </div>
                                    <div class="comment-content">
                                        <p>Este comentario contiene lenguaje inapropiado y fue reportado por otros usuarios.</p>
                                        <div class="comment-meta">
                                            En: <a href="#">Estadio Azteca: Sede legendaria</a>
                                        </div>
                                    </div>
                                    <div class="comment-actions">
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                        <button class="btn btn-sm btn-secondary">
                                            <i class="fas fa-check"></i> Aprobar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
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
</body>
</html>