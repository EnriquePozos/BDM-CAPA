<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - FIFA Mundiales</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/base.css" rel="stylesheet">
    <link href="assets/css/dashboard.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="index.php">
                <img src="assets/logov3.png" alt="Logo FIFA Mundiales" style="height: 48px;">
            </a>
            <div class="ms-auto">
                <span class="badge bg-danger me-3">ADMIN</span>
                <a class="btn btn-sm btn-outline-primary" href="index.php">
                    <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                </a>
            </div>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <section class="dashboard-section">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="dashboard-sidebar">
                        <h5 class="text-center mb-4">
                            <i class="fas fa-user-shield me-2"></i>Panel Admin
                        </h5>
                        <div class="sidebar-menu">
                            <a href="#publicaciones" class="menu-item active" data-section="publicaciones">
                                <i class="fas fa-check-circle"></i>
                                <span>Aprobar Publicaciones</span>
                            </a>
                            <a href="#categorias" class="menu-item" data-section="categorias">
                                <i class="fas fa-tags"></i>
                                <span>Gestionar Categorías</span>
                            </a>
                            <a href="#mundiales" class="menu-item" data-section="mundiales">
                                <i class="fas fa-trophy"></i>
                                <span>Gestionar Mundiales</span>
                            </a>
                            <a href="#usuarios" class="menu-item" data-section="usuarios">
                                <i class="fas fa-users"></i>
                                <span>Usuarios</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="dashboard-content">
                        
                        <!-- APROBAR PUBLICACIONES -->
                        <div class="content-section active" id="publicaciones">
                            <div class="section-header">
                                <h3><i class="fas fa-check-circle me-2"></i>Publicaciones Pendientes</h3>
                                <span class="badge bg-warning">3 pendientes</span>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="user-post-card">
                                        <img src="https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=400" class="post-image">
                                        <div class="post-content">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="post-title">Gol de Messi</h6>
                                                    <p class="post-category mb-1">Por: Juan Pérez</p>
                                                    <small class="text-muted">Qatar 2022 · Jugadas</small>
                                                </div>
                                            </div>
                                            <p class="mb-3">Increíble gol de Messi en la final del mundial...</p>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-success btn-sm flex-fill">
                                                    <i class="fas fa-check me-1"></i>Aprobar
                                                </button>
                                                <button class="btn btn-danger btn-sm flex-fill">
                                                    <i class="fas fa-times me-1"></i>Rechazar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="user-post-card">
                                        <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=400" class="post-image">
                                        <div class="post-content">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="post-title">Celebración Argentina</h6>
                                                    <p class="post-category mb-1">Por: María García</p>
                                                    <small class="text-muted">Qatar 2022 · Cultura</small>
                                                </div>
                                            </div>
                                            <p class="mb-3">La emoción de los argentinos tras ganar el mundial...</p>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-success btn-sm flex-fill">
                                                    <i class="fas fa-check me-1"></i>Aprobar
                                                </button>
                                                <button class="btn btn-danger btn-sm flex-fill">
                                                    <i class="fas fa-times me-1"></i>Rechazar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- GESTIONAR CATEGORÍAS -->
                        <div class="content-section" id="categorias">
                            <div class="section-header">
                                <h3><i class="fas fa-tags me-2"></i>Gestionar Categorías</h3>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevaCategoriaModal">
                                    <i class="fas fa-plus me-2"></i>Nueva Categoría
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Publicaciones</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><i class="fas fa-futbol me-2"></i>Jugadas</td>
                                            <td>Mejores jugadas y goles</td>
                                            <td><span class="badge bg-primary">124</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-trophy me-2"></i>Partidos</td>
                                            <td>Resúmenes de partidos</td>
                                            <td><span class="badge bg-primary">89</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-chart-bar me-2"></i>Estadísticas</td>
                                            <td>Datos y estadísticas</td>
                                            <td><span class="badge bg-primary">56</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- GESTIONAR MUNDIALES -->
                        <div class="content-section" id="mundiales">
                            <div class="section-header">
                                <h3><i class="fas fa-trophy me-2"></i>Gestionar Mundiales</h3>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoMundialModal">
                                    <i class="fas fa-plus me-2"></i>Nuevo Mundial
                                </button>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="info-card">
                                        <h6>Qatar 2022</h6>
                                        <p class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>Qatar</p>
                                        <p class="mb-3"><i class="fas fa-calendar me-2"></i>2022</p>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-primary flex-fill">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger flex-fill">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="info-card">
                                        <h6>Rusia 2018</h6>
                                        <p class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>Rusia</p>
                                        <p class="mb-3"><i class="fas fa-calendar me-2"></i>2018</p>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-primary flex-fill">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger flex-fill">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="info-card">
                                        <h6>Brasil 2014</h6>
                                        <p class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>Brasil</p>
                                        <p class="mb-3"><i class="fas fa-calendar me-2"></i>2014</p>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-primary flex-fill">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger flex-fill">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- USUARIOS -->
                        <div class="content-section" id="usuarios">
                            <div class="section-header">
                                <h3><i class="fas fa-users me-2"></i>Gestionar Usuarios</h3>
                                <span class="badge bg-info">850 usuarios</span>
                            </div>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Usuario</th>
                                            <th>Email</th>
                                            <th>Publicaciones</th>
                                            <th>Fecha Registro</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Juan Pérez</td>
                                            <td>juan.perez@email.com</td>
                                            <td><span class="badge bg-primary">24</span></td>
                                            <td>15/01/2024</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-ban"></i> Eliminar
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>María García</td>
                                            <td>maria.garcia@email.com</td>
                                            <td><span class="badge bg-primary">18</span></td>
                                            <td>20/01/2024</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-ban"></i> Eliminar
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Nueva Categoría -->
    <div class="modal fade" id="nuevaCategoriaModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-tags me-2"></i>Nueva Categoría</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Nombre de la Categoría</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Crear Categoría</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nuevo Mundial -->
    <div class="modal fade" id="nuevoMundialModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-trophy me-2"></i>Nuevo Mundial</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Nombre del Mundial</label>
                            <input type="text" class="form-control" placeholder="Ej: Qatar 2022" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Año</label>
                            <input type="number" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">País Sede</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Logo/Imagen</label>
                            <input type="file" class="form-control" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Crear Mundial</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/dashboard.js"></script>
</body>
</html>