<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muro de Publicaciones - FIFA Mundiales</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/base.css" rel="stylesheet">
    <link href="assets/css/muro.css" rel="stylesheet">
    
    <!-- CSS para solucionar problema de z-index -->
    <style>
        .btn-create-post {
            position: relative !important;
            z-index: 1000 !important;
            pointer-events: auto !important;
            cursor: pointer !important;
        }
        
        /* Asegurar que el fondo no bloquee */
        .mundial-header-bg {
            pointer-events: none !important;
        }
        
        /* Asegurar que el header permita clicks en sus hijos */
        .mundial-header {
            position: relative;
        }
        
        .mundial-header * {
            pointer-events: auto;
        }
    </style>
</head>
<body>
<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si hay sesión activa
$sesionActiva = isset($_SESSION['usuario_id']);

// ========== VALIDAR QUE VENGA ID DE MUNDIAL ==========
if (!isset($_GET['id_mundial']) || empty($_GET['id_mundial'])) {
    header('Location: mundiales.php?error=Debes seleccionar un mundial');
    exit();
}

$idMundial = intval($_GET['id_mundial']);

// ========== CARGAR DATOS DESDE BASE DE DATOS ==========
require_once __DIR__ . '/../backend/controllers/PublicacionController.php';
require_once __DIR__ . '/../backend/controllers/ComentarioController.php';
require_once __DIR__ . '/../backend/controllers/ReaccionController.php';
require_once __DIR__ . '/../backend/controllers/CategoriaControler.php';
require_once __DIR__ . '/../backend/models/Mundial.php';

// Instanciar controladores
$publicacionController = new PublicacionController();
$comentarioController = new ComentarioController();
$reaccionController = new ReaccionController();
$categoriaController = new CategoriaController();

// Cargar información del mundial
$mundialModel = new Mundial();
$mundial = $mundialModel->obtenerPorId($idMundial);

// Si el mundial no existe, redirigir
if (!$mundial) {
    header('Location: mundiales.php?error=Mundial no encontrado');
    exit();
}

// Cargar publicaciones con multimedia (solo aprobadas para usuarios normales)
$publicaciones = $publicacionController->obtenerPublicacionesConMultimedia($idMundial, true);

// Cargar categorías para el formulario
$categorias = $categoriaController->listar();

// Convertir logo del mundial a Base64
$logoMundialBase64 = '';
if (!empty($mundial['Logo'])) {
    $logoMundialBase64 = base64_encode($mundial['Logo']);
}
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
                            <i class="fas fa-trophy me-3"></i><?php echo strtoupper(htmlspecialchars($mundial['Nombre'])); ?>
                        </h1>
                        <p class="mundial-header-desc">
                            <i class="fas fa-map-marker-alt me-2"></i><?php echo htmlspecialchars($mundial['Sede']); ?> · <?php echo $mundial['Anio']; ?>
                        </p>
                        <?php if (!empty($mundial['Descripcion'])): ?>
                            <p class="mundial-header-desc">
                                <?php echo htmlspecialchars($mundial['Descripcion']); ?>
                            </p>
                        <?php endif; ?>
                        <div class="mundial-header-stats">
                            <span><i class="fas fa-images me-2"></i><?php echo count($publicaciones); ?> Publicaciones</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <?php if ($sesionActiva): ?>
                        <button class="btn-create-post" type="button">
                            <i class="fas fa-plus-circle me-2"></i>Crear Publicación
                        </button>
                    <?php else: ?>
                        <a href="login.php" class="btn-create-post">
                            <i class="fas fa-sign-in-alt me-2"></i>Inicia sesión para publicar
                        </a>
                    <?php endif; ?>
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
                    <?php foreach ($categorias as $categoria): ?>
                        <button class="category-pill" data-category="<?php echo htmlspecialchars($categoria['Nombre']); ?>">
                            <i class="fas fa-tag"></i> <?php echo htmlspecialchars($categoria['Nombre']); ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <!-- Ordenar -->
                <div class="sort-dropdown">
                    <select class="filter-select" id="sortSelect">
                        <option value="reciente">🆕 Más reciente</option>
                        <option value="likes">❤️ Más likes</option>
                        <option value="comentarios">💬 Más comentarios</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- SECCIÓN DEL MURO -->
    <section class="muro-section">
        <div class="container">
            <div class="row">
                <!-- Feed de Publicaciones -->
                <div class="col-lg-8">
                    <div class="posts-feed">
                        <?php if (empty($publicaciones)): ?>
                            <!-- Sin publicaciones -->
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Aún no hay publicaciones aprobadas para este mundial. 
                                <?php if ($sesionActiva): ?>
                                    ¡Sé el primero en crear una!
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <?php foreach ($publicaciones as $publicacion): ?>
                                <?php
                                // Cargar comentarios de la publicación
                                $comentarios = $comentarioController->listarPorPublicacion($publicacion['id_Publicacion']);
                                
                                // Contar likes
                                $totalLikes = $reaccionController->contar($publicacion['id_Publicacion']);
                                
                                // Verificar si el usuario actual dio like
                                $tieneLike = false;
                                if ($sesionActiva) {
                                    $tieneLike = $reaccionController->verificar($_SESSION['usuario_id'], $publicacion['id_Publicacion']);
                                }
                                ?>
                                
                                <!-- POST -->
                                <div class="post-muro">
                                    <!-- Header del post -->
                                    <div class="post-header">
                                        <div class="post-author">
                                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($publicacion['Usuario_Nombre']); ?>&background=6101eb&color=fff" 
                                                 class="author-avatar" 
                                                 alt="<?php echo htmlspecialchars($publicacion['Usuario_Nombre']); ?>">
                                            <div class="author-info">
                                                <h5 class="author-name"><?php echo htmlspecialchars($publicacion['Usuario_Nombre']); ?></h5>
                                                <span class="post-time">
                                                    <i class="fas fa-clock me-1"></i>
                                                    <?php 
                                                    $fecha = new DateTime($publicacion['Fecha_Creacion']);
                                                    echo $fecha->format('d/m/Y H:i'); 
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                        <span class="post-category-badge">
                                            <?php echo isset($publicacion['Categorias']) ? htmlspecialchars($publicacion['Categorias']) : 'General'; ?>
                                        </span>
                                    </div>

                                    <!-- Body del post -->
                                    <div class="post-body">
                                        <h3 class="post-title-muro"><?php echo htmlspecialchars($publicacion['Titulo']); ?></h3>
                                        <p class="post-description-muro"><?php echo nl2br(htmlspecialchars($publicacion['Descripcion'])); ?></p>

                                        <!-- Multimedia -->
                                        <?php if (!empty($publicacion['multimedia'])): ?>
                                            <?php foreach ($publicacion['multimedia'] as $media): ?>
                                                <?php
                                                // Determinar tipo de archivo
                                                $extension = strtolower(pathinfo($media['Nombre_Archivo'], PATHINFO_EXTENSION));
                                                $esVideo = in_array($extension, ['mp4', 'avi', 'mov', 'webm']);
                                                ?>
                                                <div class="post-media-muro">
                                                    <?php if ($esVideo): ?>
                                                        <!-- Videos: Usar URL directa para mejor rendimiento -->
                                                        <video controls style="width: 100%; border-radius: 15px;">
                                                            <source src="../backend/api/multimedia.php?accion=servir&id=<?php echo $media['id_Multimedia']; ?>" 
                                                                    type="video/<?php echo $extension; ?>">
                                                            Tu navegador no soporta la reproducción de videos.
                                                        </video>
                                                    <?php else: ?>
                                                        <!-- Imágenes: Usar Base64 (archivos pequeños) -->
                                                        <?php
                                                        $mediaBase64 = base64_encode($media['File']);
                                                        ?>
                                                        <img src="data:image/jpeg;base64,<?php echo $mediaBase64; ?>" 
                                                             alt="<?php echo htmlspecialchars($publicacion['Titulo']); ?>">
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                        <!-- Info del partido (si hay selección) -->
                                        <?php if (!empty($publicacion['Seleccion'])): ?>
                                            <div class="post-match-info">
                                                <span class="match-teams">
                                                    <i class="fas fa-flag me-2"></i><?php echo htmlspecialchars($publicacion['Seleccion']); ?>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Acciones del post -->
                                    <div class="post-actions">
                                        <?php if ($sesionActiva): ?>
                                            <!-- Toggle Like -->
                                            <form action="../backend/api/reacciones.php" method="POST" style="flex: 1;">
                                                <input type="hidden" name="accion" value="toggle">
                                                <input type="hidden" name="id_publicacion" value="<?php echo $publicacion['id_Publicacion']; ?>">
                                                <button type="submit" class="action-btn-muro <?php echo $tieneLike ? 'active-like' : ''; ?>">
                                                    <i class="<?php echo $tieneLike ? 'fas' : 'far'; ?> fa-heart"></i>
                                                    <?php echo $totalLikes; ?> Likes
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <a href="login.php" class="action-btn-muro">
                                                <i class="far fa-heart"></i> <?php echo $totalLikes; ?> Likes
                                            </a>
                                        <?php endif; ?>

                                        <button class="action-btn-muro" onclick="toggleComments('comments-<?php echo $publicacion['id_Publicacion']; ?>')">
                                            <i class="fas fa-comment"></i> 
                                            <?php echo is_array($comentarios) ? count($comentarios) : 0; ?> Comentarios
                                        </button>
                                    </div>

                                    <!-- Sección de comentarios -->
                                    <div class="post-comments-section" id="comments-<?php echo $publicacion['id_Publicacion']; ?>" style="display: none;">
                                        <!-- Lista de comentarios -->
                                        <?php if (!empty($comentarios) && is_array($comentarios)): ?>
                                            <div class="comments-list">
                                                <?php foreach ($comentarios as $comentario): ?>
                                                    <div class="comment-item">
                                                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($comentario['Usuario_Nombre']); ?>&background=3fe8c6&color=6101eb" 
                                                             class="comment-avatar" 
                                                             alt="<?php echo htmlspecialchars($comentario['Usuario_Nombre']); ?>">
                                                        <div class="comment-content">
                                                            <h6 class="comment-author"><?php echo htmlspecialchars($comentario['Usuario_Nombre']); ?></h6>
                                                            <p class="comment-text"><?php echo nl2br(htmlspecialchars($comentario['Contenido'])); ?></p>
                                                            <span class="comment-time">
                                                                <?php 
                                                                $fechaComentario = new DateTime($comentario['Fecha_Creacion']);
                                                                echo $fechaComentario->format('d/m/Y H:i'); 
                                                                ?>
                                                                
                                                                <!-- Botón eliminar (solo si es del usuario o es admin) -->
                                                                <?php if ($sesionActiva && ($comentario['id_Usuario'] == $_SESSION['usuario_id'] || $_SESSION['usuario_tipo'] == 1)): ?>
                                                                    <form action="../backend/api/comentarios.php" method="POST" style="display: inline; margin-left: 10px;">
                                                                        <input type="hidden" name="accion" value="eliminar">
                                                                        <input type="hidden" name="id_comentario" value="<?php echo $comentario['id_Comentario']; ?>">
                                                                        <input type="hidden" name="id_publicacion" value="<?php echo $publicacion['id_Publicacion']; ?>">
                                                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0" 
                                                                                onclick="return confirm('¿Eliminar este comentario?')">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                        </button>
                                                                    </form>
                                                                <?php endif; ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Formulario para nuevo comentario -->
                                        <?php if ($sesionActiva): ?>
                                            <form action="../backend/api/comentarios.php" method="POST" class="comment-form">
                                                <input type="hidden" name="accion" value="crear">
                                                <input type="hidden" name="id_publicacion" value="<?php echo $publicacion['id_Publicacion']; ?>">
                                                <input type="text" 
                                                       name="contenido" 
                                                       class="comment-input" 
                                                       placeholder="Escribe un comentario..." 
                                                       required>
                                                <button type="submit" class="btn-send-comment">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <div class="alert alert-sm alert-info">
                                                <a href="login.php">Inicia sesión</a> para comentar
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="sidebar-muro">
                        <!-- Info del mundial -->
                        <div class="sidebar-card">
                            <h5 class="sidebar-title">
                                <i class="fas fa-info-circle me-2"></i>Sobre este Mundial
                            </h5>
                            <div class="mundial-side-info">
                                <?php if (!empty($logoMundialBase64)): ?>
                                    <img src="data:image/jpeg;base64,<?php echo $logoMundialBase64; ?>" 
                                         alt="<?php echo htmlspecialchars($mundial['Nombre']); ?>"
                                         style="width: 100%; border-radius: 10px; margin-bottom: 15px;">
                                <?php endif; ?>
                                <p><strong>Sede:</strong> <?php echo htmlspecialchars($mundial['Sede']); ?></p>
                                <p><strong>Año:</strong> <?php echo $mundial['Anio']; ?></p>
                                <p><strong>Publicaciones:</strong> <?php echo count($publicaciones); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MODAL CREAR PUBLICACIÓN -->
    <?php if ($sesionActiva): ?>
    <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPostModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>Crear Nueva Publicación en <?php echo htmlspecialchars($mundial['Nombre']); ?>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../backend/api/publicaciones.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="accion" value="crear">
                        <input type="hidden" name="id_mundial" value="<?php echo $idMundial; ?>">
                        
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título de la Publicación *</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required 
                                   placeholder="Ej: El mejor gol de Messi">
                        </div>
                        
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción *</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required 
                                      placeholder="Describe tu publicación..."></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="categorias" class="form-label">Categorías</label>
                                <select class="form-select" id="categorias" name="categorias[]" multiple size="4">
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?php echo $categoria['id_Categoria']; ?>">
                                            <?php echo htmlspecialchars($categoria['Nombre']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="seleccion" class="form-label">Selección (Opcional)</label>
                                <input type="text" class="form-control" id="seleccion" name="seleccion" 
                                       placeholder="Ej: Argentina, Brasil...">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="archivos" class="form-label">Imágenes o Videos</label>
                            <input type="file" class="form-control" id="archivos" name="archivos[]" 
                                   accept="image/*,video/*" multiple>
                            <small class="text-muted">Formatos: JPG, PNG, MP4, MOV (Máx. 100MB por archivo)</small>
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
    <?php endif; ?>

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

    <!-- Bootstrap JS (DEBE IR PRIMERO) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script inline para toggleComments y modal -->
    <script>
    // Función global para mostrar/ocultar comentarios
    window.toggleComments = function(id) {
        const commentsSection = document.getElementById(id);
        if (commentsSection) {
            if (commentsSection.style.display === 'none' || commentsSection.style.display === '') {
                commentsSection.style.display = 'block';
            } else {
                commentsSection.style.display = 'none';
            }
        }
    };
    
    // Inicializar modal cuando Bootstrap esté listo
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof bootstrap === 'undefined') {
            console.error('⚠️ Bootstrap no está cargado correctamente');
            return;
        }
        
        console.log('✅ Bootstrap 5 cargado correctamente');
        
        // Inicializar modal manualmente
        const modalElement = document.getElementById('createPostModal');
        const btnCreatePost = document.querySelector('.btn-create-post');
        
        if (modalElement && btnCreatePost) {
            console.log('✅ Botón y modal encontrados');
            
            // DIAGNÓSTICO: Verificar propiedades del botón
            const btnStyles = getComputedStyle(btnCreatePost);
            console.log('📊 Propiedades del botón:', {
                'z-index': btnStyles.zIndex,
                'position': btnStyles.position,
                'pointer-events': btnStyles.pointerEvents,
                'display': btnStyles.display,
                'visibility': btnStyles.visibility,
                'opacity': btnStyles.opacity
            });
            
            // DIAGNÓSTICO: Detectar qué elemento está en la posición del botón
            const btnRect = btnCreatePost.getBoundingClientRect();
            const btnCenterX = btnRect.left + btnRect.width / 2;
            const btnCenterY = btnRect.top + btnRect.height / 2;
            const elementAtPoint = document.elementFromPoint(btnCenterX, btnCenterY);
            
            console.log('🎯 Elemento en el centro del botón:', {
                'elemento': elementAtPoint,
                'clase': elementAtPoint?.className,
                'es el botón?': elementAtPoint === btnCreatePost
            });
            
            if (elementAtPoint !== btnCreatePost) {
                console.warn('⚠️ HAY UN ELEMENTO BLOQUEANDO EL BOTÓN:', elementAtPoint);
                console.warn('Propiedades del bloqueador:', {
                    'z-index': getComputedStyle(elementAtPoint).zIndex,
                    'position': getComputedStyle(elementAtPoint).position,
                    'pointer-events': getComputedStyle(elementAtPoint).pointerEvents
                });
            }
            
            // Crear instancia del modal
            const myModal = new bootstrap.Modal(modalElement, {
                backdrop: true,
                keyboard: true,
                focus: true
            });
            
            // Event listener en el botón (funcionará con Tab + Enter)
            btnCreatePost.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('🔘 Click detectado - Abriendo modal');
                myModal.show();
            });
            
            // WORKAROUND: Si hay un elemento bloqueador, agregar listener ahí también
            if (elementAtPoint && elementAtPoint !== btnCreatePost) {
                console.log('🔧 Aplicando workaround: agregando listener al bloqueador');
                elementAtPoint.addEventListener('click', function(e) {
                    // Verificar si el click fue sobre el área del botón
                    const clickX = e.clientX;
                    const clickY = e.clientY;
                    
                    if (clickX >= btnRect.left && clickX <= btnRect.right &&
                        clickY >= btnRect.top && clickY <= btnRect.bottom) {
                        console.log('🔘 Click redirigido al botón');
                        myModal.show();
                    }
                });
            }
            
            console.log('✅ Event listener configurado');
        }
    });
    </script>
    
    <!-- Muro.js (OPCIONAL - solo para filtros visuales) -->
    <script src="assets/js/muro.js"></script>
</body>
</html>