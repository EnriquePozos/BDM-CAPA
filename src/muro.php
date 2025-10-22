<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qatar 2022 - Muro de Publicaciones</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/base.css" rel="stylesheet">
    <link href="assets/css/muro.css" rel="stylesheet">
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
                        <a class="nav-link active" href="mundiales.php"><i class="fas fa-globe me-1"></i>Mundiales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="galeria.php"><i class="fas fa-images me-1"></i>Galería</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto" style="flex-direction: row;">
                    <li class="nav-item">
                        <a class="nav-link btn-outline-primary ms-2" href="login.php">
                            <i class="fas fa-sign-in-alt me-1"></i>Iniciar Sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-primary text-white ms-2" href="registro.php" style="background:#6101eb; color:#fff; border:none;">
                            <i class="fas fa-user-plus me-1"></i>Registrarse
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HEADER DEL MUNDIAL -->
    <section class="mundial-header">
        <div class="mundial-header-bg"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="mundial-info">
                        <div class="breadcrumb-custom">
                            <a href="mundiales.php"><i class="fas fa-arrow-left me-2"></i>Volver a Mundiales</a>
                        </div>
                        <h1 class="mundial-header-title">
                            <i class="fas fa-trophy me-3"></i>QATAR 2022
                        </h1>
                        <p class="mundial-header-desc">
                            <i class="fas fa-map-marker-alt me-2"></i>Qatar · 21 Nov - 18 Dic 2022
                        </p>
                        <div class="mundial-header-stats">
                            <span><i class="fas fa-images me-2"></i>245 Publicaciones</span>
                            <span><i class="fas fa-heart me-2"></i>12.5K Likes</span>
                            <span><i class="fas fa-comment me-2"></i>3.8K Comentarios</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <button class="btn-create-post" data-bs-toggle="modal" data-bs-target="#createPostModal">
                        <i class="fas fa-plus-circle me-2"></i>Crear Publicación
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- FILTROS Y ORDENAMIENTO -->
    <section class="filters-bar">
        <div class="container">
            <div class="filters-wrapper">
                <!-- Categorías -->
                <div class="categories-pills">
                    <button class="category-pill active" data-category="all">
                        <i class="fas fa-globe"></i> Todas
                    </button>
                    <button class="category-pill" data-category="jugadas">
                        <i class="fas fa-futbol"></i> Jugadas
                    </button>
                    <button class="category-pill" data-category="partidos">
                        <i class="fas fa-trophy"></i> Partidos
                    </button>
                    <button class="category-pill" data-category="estadisticas">
                        <i class="fas fa-chart-bar"></i> Estadísticas
                    </button>
                    <button class="category-pill" data-category="cultura">
                        <i class="fas fa-heart"></i> Cultura
                    </button>
                </div>

                <!-- Ordenar -->
                <div class="sort-dropdown">
                    <select class="filter-select" id="sortSelect">
                        <option value="reciente">🆕 Más reciente</option>
                        <option value="likes">❤️ Más likes</option>
                        <option value="comentarios">💬 Más comentarios</option>
                        <option value="vistas">👁️ Más vistas</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- MURO DE PUBLICACIONES -->
    <section class="muro-section">
        <div class="container">
            <div class="row">
                <!-- COLUMNA PRINCIPAL - FEED -->
                <div class="col-lg-8">
                    <div class="posts-feed">
                        
                        <!-- PUBLICACIÓN 1 -->
                        <article class="post-muro">
                            <div class="post-header">
                                <div class="post-author">
                                    <img src="https://ui-avatars.com/api/?name=Juan+Perez&background=6101eb&color=fff" class="author-avatar" alt="Juan Pérez">
                                    <div class="author-info">
                                        <h6 class="author-name">Juan Pérez</h6>
                                        <span class="post-time"><i class="far fa-clock me-1"></i>Hace 2 horas</span>
                                    </div>
                                </div>
                                <div class="post-category-badge">Jugadas</div>
                            </div>

                            <div class="post-body">
                                <h5 class="post-title-muro">El mejor gol de Messi en la final</h5>
                                <p class="post-description-muro">
                                    Increíble definición de Messi en el minuto 108. Argentina campeón del mundo después de 36 años. Un momento histórico que quedará para siempre.
                                </p>
                                
                                <!-- Imagen de la publicación -->
                                <div class="post-media-muro">
                                    <img src="https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=1200" alt="Publicación">
                                </div>

                                <!-- Match info -->
                                <div class="post-match-info">
                                    <span class="match-teams">🇦🇷 Argentina vs Francia 🇫🇷</span>
                                    <span class="match-stage">Final</span>
                                </div>
                            </div>

                            <div class="post-actions">
                                <button class="action-btn-muro active-like">
                                    <i class="fas fa-heart"></i>
                                    <span>1.2K</span>
                                </button>
                                <button class="action-btn-muro">
                                    <i class="far fa-comment"></i>
                                    <span>234</span>
                                </button>
                                <button class="action-btn-muro">
                                    <i class="far fa-share-square"></i>
                                    <span>Compartir</span>
                                </button>
                            </div>

                            <!-- Sección de comentarios -->
                            <div class="post-comments-section">
                                <div class="comments-list">
                                    <div class="comment-item">
                                        <img src="https://ui-avatars.com/api/?name=Maria+Garcia&background=3fe8c6&color=6101eb" class="comment-avatar" alt="Usuario">
                                        <div class="comment-content">
                                            <h6 class="comment-author">María García</h6>
                                            <p class="comment-text">¡Qué golazo! Messi es el mejor de todos los tiempos 🐐</p>
                                            <span class="comment-time">Hace 1 hora</span>
                                        </div>
                                    </div>
                                    <div class="comment-item">
                                        <img src="https://ui-avatars.com/api/?name=Carlos+Lopez&background=6101eb&color=fff" class="comment-avatar" alt="Usuario">
                                        <div class="comment-content">
                                            <h6 class="comment-author">Carlos López</h6>
                                            <p class="comment-text">Argentina campeón del mundo! 🏆🇦🇷</p>
                                            <span class="comment-time">Hace 30 min</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Formulario nuevo comentario -->
                                <div class="comment-form">
                                    <img src="https://ui-avatars.com/api/?name=Tu+Usuario&background=6101eb&color=fff" class="comment-avatar" alt="Tu avatar">
                                    <input type="text" class="comment-input" placeholder="Escribe un comentario...">
                                    <button class="btn-send-comment">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </article>

                        <!-- PUBLICACIÓN 2 -->
                        <article class="post-muro">
                            <div class="post-header">
                                <div class="post-author">
                                    <img src="https://ui-avatars.com/api/?name=Ana+Martinez&background=3fe8c6&color=6101eb" class="author-avatar" alt="Ana Martínez">
                                    <div class="author-info">
                                        <h6 class="author-name">Ana Martínez</h6>
                                        <span class="post-time"><i class="far fa-clock me-1"></i>Hace 5 horas</span>
                                    </div>
                                </div>
                                <div class="post-category-badge">Estadísticas</div>
                            </div>

                            <div class="post-body">
                                <h5 class="post-title-muro">Estadísticas de la final histórica</h5>
                                <p class="post-description-muro">
                                    La final más emocionante de la historia de los mundiales. 120 minutos de puro fútbol y definición por penales. Aquí las estadísticas completas del partido.
                                </p>
                                
                                <div class="post-media-muro">
                                    <img src="https://images.unsplash.com/photo-1522778119026-d647f0596c20?w=1200" alt="Estadísticas">
                                </div>

                                <div class="post-match-info">
                                    <span class="match-teams">🇦🇷 Argentina 3(4) - 3(2) Francia 🇫🇷</span>
                                    <span class="match-stage">Final · Penales</span>
                                </div>
                            </div>

                            <div class="post-actions">
                                <button class="action-btn-muro">
                                    <i class="far fa-heart"></i>
                                    <span>856</span>
                                </button>
                                <button class="action-btn-muro">
                                    <i class="far fa-comment"></i>
                                    <span>142</span>
                                </button>
                                <button class="action-btn-muro">
                                    <i class="far fa-share-square"></i>
                                    <span>Compartir</span>
                                </button>
                            </div>
                        </article>

                        <!-- PUBLICACIÓN 3 -->
                        <article class="post-muro">
                            <div class="post-header">
                                <div class="post-author">
                                    <img src="https://ui-avatars.com/api/?name=Roberto+Silva&background=6101eb&color=fff" class="author-avatar" alt="Roberto Silva">
                                    <div class="author-info">
                                        <h6 class="author-name">Roberto Silva</h6>
                                        <span class="post-time"><i class="far fa-clock me-1"></i>Hace 1 día</span>
                                    </div>
                                </div>
                                <div class="post-category-badge">Cultura</div>
                            </div>

                            <div class="post-body">
                                <h5 class="post-title-muro">La pasión de la hinchada argentina</h5>
                                <p class="post-description-muro">
                                    Miles de argentinos viajaron a Qatar para apoyar a su selección. La pasión y el color en las tribunas fue increíble durante todo el torneo.
                                </p>
                                
                                <div class="post-media-muro">
                                    <img src="https://images.unsplash.com/photo-1508098682722-e99c43a406b2?w=1200" alt="Hinchada">
                                </div>
                            </div>

                            <div class="post-actions">
                                <button class="action-btn-muro">
                                    <i class="far fa-heart"></i>
                                    <span>634</span>
                                </button>
                                <button class="action-btn-muro">
                                    <i class="far fa-comment"></i>
                                    <span>89</span>
                                </button>
                                <button class="action-btn-muro">
                                    <i class="far fa-share-square"></i>
                                    <span>Compartir</span>
                                </button>
                            </div>
                        </article>

                        <!-- Botón cargar más -->
                        <div class="text-center mt-4">
                            <button class="btn-load-more-muro">
                                <i class="fas fa-plus-circle me-2"></i>Cargar más publicaciones
                            </button>
                        </div>
                    </div>
                </div>

                <!-- SIDEBAR DERECHO -->
                <div class="col-lg-4">
                    <div class="sidebar-muro">
                        <!-- Info del Mundial -->
                        <div class="sidebar-card">
                            <h5 class="sidebar-title">
                                <i class="fas fa-info-circle me-2"></i>Sobre este Mundial
                            </h5>
                            <div class="mundial-side-info">
                                <p><strong>Sede:</strong> Qatar</p>
                                <p><strong>Fechas:</strong> 21 Nov - 18 Dic 2022</p>
                                <p><strong>Campeón:</strong> 🇦🇷 Argentina</p>
                                <p><strong>Subcampeón:</strong> 🇫🇷 Francia</p>
                                <p><strong>Partidos:</strong> 64</p>
                                <p><strong>Goles:</strong> 172</p>
                            </div>
                        </div>

                        <!-- Top Publicaciones -->
                        <div class="sidebar-card">
                            <h5 class="sidebar-title">
                                <i class="fas fa-fire me-2"></i>Más Populares
                            </h5>
                            <div class="trending-posts">
                                <div class="trending-item">
                                    <img src="https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=100" class="trending-thumb" alt="Trending">
                                    <div class="trending-info">
                                        <h6>Gol de Messi</h6>
                                        <span><i class="fas fa-heart me-1"></i>1.2K</span>
                                    </div>
                                </div>
                                <div class="trending-item">
                                    <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=100" class="trending-thumb" alt="Trending">
                                    <div class="trending-info">
                                        <h6>Final épica</h6>
                                        <span><i class="fas fa-heart me-1"></i>856</span>
                                    </div>
                                </div>
                                <div class="trending-item">
                                    <img src="https://images.unsplash.com/photo-1522778119026-d647f0596c20?w=100" class="trending-thumb" alt="Trending">
                                    <div class="trending-info">
                                        <h6>Celebración</h6>
                                        <span><i class="fas fa-heart me-1"></i>634</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Usuarios activos -->
                        <div class="sidebar-card">
                            <h5 class="sidebar-title">
                                <i class="fas fa-users me-2"></i>Usuarios Activos
                            </h5>
                            <div class="active-users">
                                <div class="active-user-item">
                                    <img src="https://ui-avatars.com/api/?name=Juan+Perez&background=6101eb&color=fff" class="user-avatar-small" alt="Usuario">
                                    <span>Juan Pérez</span>
                                </div>
                                <div class="active-user-item">
                                    <img src="https://ui-avatars.com/api/?name=Maria+Garcia&background=3fe8c6&color=6101eb" class="user-avatar-small" alt="Usuario">
                                    <span>María García</span>
                                </div>
                                <div class="active-user-item">
                                    <img src="https://ui-avatars.com/api/?name=Carlos+Lopez&background=6101eb&color=fff" class="user-avatar-small" alt="Usuario">
                                    <span>Carlos López</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MODAL CREAR PUBLICACIÓN -->
    <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPostModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>Crear Nueva Publicación en Qatar 2022
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createPostForm">
                        <div class="mb-3">
                            <label for="postTitle" class="form-label">Título de la Publicación *</label>
                            <input type="text" class="form-control" id="postTitle" required placeholder="Ej: El mejor gol de Messi">
                        </div>
                        
                        <div class="mb-3">
                            <label for="postDescription" class="form-label">Descripción *</label>
                            <textarea class="form-control" id="postDescription" rows="4" required placeholder="Describe tu publicación..."></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="categoriaSelect" class="form-label">Categoría *</label>
                                <select class="form-select" id="categoriaSelect" required>
                                    <option value="">Seleccione una categoría</option>
                                    <option value="jugadas">⚽ Jugadas</option>
                                    <option value="entrevistas">🎤 Entrevistas</option>
                                    <option value="partidos">🏆 Partidos</option>
                                    <option value="estadisticas">📊 Estadísticas</option>
                                    <option value="sedes">📍 Sedes</option>
                                    <option value="cultura">❤️ Cultura</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="seleccionSelect" class="form-label">Selección (Opcional)</label>
                                <select class="form-select" id="seleccionSelect">
                                    <option value="">Sin selección específica</option>
                                    <option value="argentina">🇦🇷 Argentina</option>
                                    <option value="francia">🇫🇷 Francia</option>
                                    <option value="brasil">🇧🇷 Brasil</option>
                                    <option value="alemania">🇩🇪 Alemania</option>
                                    <option value="espana">🇪🇸 España</option>
                                    <option value="portugal">🇵🇹 Portugal</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="postImage" class="form-label">Imagen o Video *</label>
                            <input type="file" class="form-control" id="postImage" accept="image/*,video/*" required>
                            <small class="text-muted">Formatos aceptados: JPG, PNG, MP4, MOV (Máx. 10MB)</small>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Tu publicación será revisada por un administrador antes de ser visible públicamente.
                        </div>
                        
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Publicar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="footer pb-2 pt-4">
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="text-white">FIFA Mundiales</h5>
                    <p class="text-white-50 mb-0">Proyecto académico - Bases de Datos Multimedia</p>
                    <p class="text-white-50">UANL - Facultad de Ciencias Físico Matemáticas</p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <p class="text-white-50 mt-2 mb-0">&copy; 2025 FIFA Mundiales. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="assets/js/muro.js"></script>
</body>
</html>