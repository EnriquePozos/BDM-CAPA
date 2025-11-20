<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Dashboard - Mundiales FIFA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/dashboard-usuario.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="index.html">
                <img src="assets/logov3.png" alt="Logo FIFA Mundiales" style="height: 48px; vertical-align: middle;">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto" style="flex-direction: row; justify-content: center; width: 100%;">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html"><i class="fas fa-home me-1"></i>Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mundiales.html"><i class="fas fa-globe me-1"></i>Mundiales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="galeria.html"><i class="fas fa-images me-1"></i>Galería</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard-usuario.html"><i class="fas fa-user me-1"></i>Mi Dashboard</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto" style="flex-direction: row;">
                    <li class="nav-item">
                        <a class="nav-link btn-danger text-white ms-2" href="index.html">
                            <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                        </a>
                    </li>
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
                                <img src="assets/default-user.jpg" alt="Usuario" id="profileImg">
                            </div>
                            <h5 class="profile-name" id="userName">Juan Pérez</h5>
                            <span class="profile-role">Usuario</span>
                            <div class="profile-stats mt-3">
                                <div class="stat-item">
                                    <strong id="totalPublicaciones">12</strong>
                                    <span>Publicaciones</span>
                                </div>
                                <div class="stat-item">
                                    <strong id="totalLikes">248</strong>
                                    <span>Likes</span>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar Menu -->
                        <nav class="sidebar-menu">
                            <a href="#" class="menu-item active" data-section="publicaciones">
                                <i class="fas fa-images"></i>
                                <span>Mis Publicaciones</span>
                            </a>
                            <a href="#" class="menu-item" data-section="nueva-publicacion">
                                <i class="fas fa-plus-circle"></i>
                                <span>Nueva Publicación</span>
                            </a>
                            <a href="#" class="menu-item" data-section="perfil">
                                <i class="fas fa-user-edit"></i>
                                <span>Editar Perfil</span>
                            </a>
                            <a href="#" class="menu-item" data-section="configuracion">
                                <i class="fas fa-cog"></i>
                                <span>Configuración</span>
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="dashboard-content">

                        <!-- Publicaciones Section -->
                        <section id="publicaciones" class="content-section active">
                            <div class="section-header">
                                <h3>
                                    <i class="fas fa-images"></i>
                                    Mis Publicaciones
                                </h3>
                                <div class="search-box">
                                    <i class="fas fa-search"></i>
                                    <input type="text" class="form-control" placeholder="Buscar publicaciones...">
                                </div>
                            </div>

                            <!-- Filter Tabs -->
                            <div class="filter-tabs">
                                <button class="tab-item active" data-status="todas">
                                    Todas <span class="badge">12</span>
                                </button>
                                <button class="tab-item" data-status="aprobadas">
                                    Aprobadas <span class="badge">9</span>
                                </button>
                                <button class="tab-item" data-status="pendientes">
                                    Pendientes <span class="badge">3</span>
                                </button>
                            </div>

                            <!-- Publications Grid -->
                            <div class="publications-grid">
                                <!-- Publicación Aprobada -->
                                <div class="publication-card" data-status="aprobada">
                                    <div class="publication-image">
                                        <img src="assets/mundial-mexico-86.jpg" alt="Publicación">
                                        <span class="status-badge approved">
                                            <i class="fas fa-check-circle"></i> Aprobada
                                        </span>
                                    </div>
                                    <div class="publication-content">
                                        <h5>Gol histórico de Maradona</h5>
                                        <div class="publication-meta">
                                            <span><i class="fas fa-globe"></i> México 1986</span>
                                            <span><i class="fas fa-folder"></i> Jugadas</span>
                                        </div>
                                        <div class="publication-stats">
                                            <span><i class="fas fa-heart text-danger"></i> 45 likes</span>
                                            <span><i class="fas fa-comment text-info"></i> 12 comentarios</span>
                                            <span><i class="fas fa-eye text-secondary"></i> 234 vistas</span>
                                        </div>
                                    </div>
                                    <div class="publication-actions">
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> Ver
                                        </button>
                                        <button class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </div>

                                <!-- Publicación Pendiente -->
                                <div class="publication-card" data-status="pendiente">
                                    <div class="publication-image">
                                        <img src="assets/brasil-2014.jpg" alt="Publicación">
                                        <span class="status-badge pending">
                                            <i class="fas fa-clock"></i> Pendiente
                                        </span>
                                    </div>
                                    <div class="publication-content">
                                        <h5>Final Brasil 2014</h5>
                                        <div class="publication-meta">
                                            <span><i class="fas fa-globe"></i> Brasil 2014</span>
                                            <span><i class="fas fa-folder"></i> Partidos</span>
                                        </div>
                                        <div class="publication-stats">
                                            <span class="text-muted">En espera de aprobación</span>
                                        </div>
                                    </div>
                                    <div class="publication-actions">
                                        <button class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </div>

                                <!-- Publicación Aprobada 2 -->
                                <div class="publication-card" data-status="aprobada">
                                    <div class="publication-image">
                                        <img src="assets/francia-98.jpg" alt="Publicación">
                                        <span class="status-badge approved">
                                            <i class="fas fa-check-circle"></i> Aprobada
                                        </span>
                                    </div>
                                    <div class="publication-content">
                                        <h5>Celebración Francia 1998</h5>
                                        <div class="publication-meta">
                                            <span><i class="fas fa-globe"></i> Francia 1998</span>
                                            <span><i class="fas fa-folder"></i> Cultura</span>
                                        </div>
                                        <div class="publication-stats">
                                            <span><i class="fas fa-heart text-danger"></i> 67 likes</span>
                                            <span><i class="fas fa-comment text-info"></i> 23 comentarios</span>
                                            <span><i class="fas fa-eye text-secondary"></i> 456 vistas</span>
                                        </div>
                                    </div>
                                    <div class="publication-actions">
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> Ver
                                        </button>
                                        <button class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </div>

                                <!-- Publicación Aprobada 3 -->
                                <div class="publication-card" data-status="aprobada">
                                    <div class="publication-image">
                                        <img src="assets/alemania-2006.jpg" alt="Publicación">
                                        <span class="status-badge approved">
                                            <i class="fas fa-check-circle"></i> Aprobada
                                        </span>
                                    </div>
                                    <div class="publication-content">
                                        <h5>Estadio Olímpico de Berlín</h5>
                                        <div class="publication-meta">
                                            <span><i class="fas fa-globe"></i> Alemania 2006</span>
                                            <span><i class="fas fa-folder"></i> Sedes</span>
                                        </div>
                                        <div class="publication-stats">
                                            <span><i class="fas fa-heart text-danger"></i> 32 likes</span>
                                            <span><i class="fas fa-comment text-info"></i> 8 comentarios</span>
                                            <span><i class="fas fa-eye text-secondary"></i> 178 vistas</span>
                                        </div>
                                    </div>
                                    <div class="publication-actions">
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> Ver
                                        </button>
                                        <button class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <nav class="pagination-nav" aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Anterior</a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Siguiente</a>
                                    </li>
                                </ul>
                            </nav>
                        </section>

                        <!-- Nueva Publicación Section -->
                        <section id="nueva-publicacion" class="content-section">
                            <div class="section-header">
                                <h3>
                                    <i class="fas fa-plus-circle"></i>
                                    Nueva Publicación
                                </h3>
                            </div>

                            <div class="info-alert">
                                <i class="fas fa-info-circle"></i>
                                <p>Tu publicación será revisada por un administrador antes de ser visible para todos los usuarios.</p>
                            </div>

                            <form id="formNuevaPublicacion" class="publication-form">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tituloPublicacion" class="form-label">
                                            <i class="fas fa-heading"></i> Título de la Publicación *
                                        </label>
                                        <input type="text" class="form-control" id="tituloPublicacion" required 
                                               placeholder="Ej: Gol histórico de Pelé">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="mundialSelect" class="form-label">
                                            <i class="fas fa-globe"></i> Mundial *
                                        </label>
                                        <select class="form-select" id="mundialSelect" required>
                                            <option value="">Seleccionar mundial...</option>
                                            <option value="1">Uruguay 1930</option>
                                            <option value="2">Italia 1934</option>
                                            <option value="3">Francia 1938</option>
                                            <option value="4">Brasil 1950</option>
                                            <option value="5">Suiza 1954</option>
                                            <option value="6">Suecia 1958</option>
                                            <option value="7">Chile 1962</option>
                                            <option value="8">Inglaterra 1966</option>
                                            <option value="9">México 1970</option>
                                            <option value="10">Alemania 1974</option>
                                            <option value="11">Argentina 1978</option>
                                            <option value="12">España 1982</option>
                                            <option value="13">México 1986</option>
                                            <option value="14">Italia 1990</option>
                                            <option value="15">Estados Unidos 1994</option>
                                            <option value="16">Francia 1998</option>
                                            <option value="17">Corea-Japón 2002</option>
                                            <option value="18">Alemania 2006</option>
                                            <option value="19">Sudáfrica 2010</option>
                                            <option value="20">Brasil 2014</option>
                                            <option value="21">Rusia 2018</option>
                                            <option value="22">Qatar 2022</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="categoriaSelect" class="form-label">
                                            <i class="fas fa-folder"></i> Categoría *
                                        </label>
                                        <select class="form-select" id="categoriaSelect" required>
                                            <option value="">Seleccionar categoría...</option>
                                            <option value="jugadas">Jugadas</option>
                                            <option value="partidos">Partidos</option>
                                            <option value="entrevistas">Entrevistas</option>
                                            <option value="estadisticas">Estadísticas</option>
                                            <option value="sedes">Sedes</option>
                                            <option value="cultura">Cultura</option>
                                            <option value="polemicas">Polémicas</option>
                                            <option value="asistentes">Asistentes</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="seleccionInput" class="form-label">
                                            <i class="fas fa-flag"></i> Selección (Opcional)
                                        </label>
                                        <input type="text" class="form-control" id="seleccionInput" 
                                               placeholder="Ej: Brasil, Argentina, México...">
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="descripcionPublicacion" class="form-label">
                                            <i class="fas fa-align-left"></i> Descripción *
                                        </label>
                                        <textarea class="form-control" id="descripcionPublicacion" rows="4" required
                                                  placeholder="Describe tu publicación..."></textarea>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="tipoContenido" class="form-label">
                                            <i class="fas fa-photo-video"></i> Tipo de Contenido *
                                        </label>
                                        <select class="form-select" id="tipoContenido" required>
                                            <option value="">Seleccionar tipo...</option>
                                            <option value="imagen">Imagen</option>
                                            <option value="video">Video</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="archivoMultimedia" class="form-label">
                                            <i class="fas fa-cloud-upload-alt"></i> Archivo *
                                        </label>
                                        <input type="file" class="form-control" id="archivoMultimedia" required 
                                               accept="image/*,video/*">
                                        <small class="form-text text-muted">
                                            Formatos aceptados: JPG, PNG, GIF, MP4, AVI (Max: 50MB)
                                        </small>
                                    </div>

                                    <div class="col-12">
                                        <div class="preview-container" id="previewContainer" style="display: none;">
                                            <h5><i class="fas fa-eye"></i> Vista Previa</h5>
                                            <div id="preview"></div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-paper-plane"></i> Enviar Publicación
                                        </button>
                                        <button type="reset" class="btn btn-secondary btn-lg ms-2">
                                            <i class="fas fa-times"></i> Cancelar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </section>

                        <!-- Perfil Section -->
                        <section id="perfil" class="content-section">
                            <div class="section-header">
                                <h3>
                                    <i class="fas fa-user-edit"></i>
                                    Editar Mi Perfil
                                </h3>
                            </div>

                            <form id="formEditarPerfil" class="profile-form">
                                <div class="row">
                                    <!-- Foto de Perfil -->
                                    <div class="col-md-12 mb-4">
                                        <div class="profile-photo-section">
                                            <div class="profile-photo-preview">
                                                <img src="assets/default-user.jpg" alt="Foto de perfil" id="photoPreview">
                                            </div>
                                            <div class="profile-photo-upload">
                                                <h5>Foto de Perfil</h5>
                                                <p class="text-muted">Formato JPG, PNG. Tamaño máximo 5MB.</p>
                                                <input type="file" class="form-control" id="fotoPerfil" accept="image/*">
                                                <button type="button" class="btn btn-outline-danger btn-sm mt-2">
                                                    <i class="fas fa-trash"></i> Eliminar Foto
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Información Personal -->
                                    <div class="col-12 mb-3">
                                        <h5 class="section-subtitle">
                                            <i class="fas fa-id-card"></i> Información Personal
                                        </h5>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="nombreCompleto" class="form-label">
                                            <i class="fas fa-user"></i> Nombre Completo *
                                        </label>
                                        <input type="text" class="form-control" id="nombreCompleto" 
                                               value="Juan Pérez González" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="fechaNacimiento" class="form-label">
                                            <i class="fas fa-calendar"></i> Fecha de Nacimiento *
                                        </label>
                                        <input type="date" class="form-control" id="fechaNacimiento" 
                                               value="1995-05-15" required>
                                        <small class="form-text text-muted">Debes ser mayor de 12 años</small>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="genero" class="form-label">
                                            <i class="fas fa-venus-mars"></i> Género *
                                        </label>
                                        <select class="form-select" id="genero" required>
                                            <option value="masculino" selected>Masculino</option>
                                            <option value="femenino">Femenino</option>
                                            <option value="otro">Otro</option>
                                            <option value="prefiero-no-decir">Prefiero no decir</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="paisNacimiento" class="form-label">
                                            <i class="fas fa-map-marker-alt"></i> País de Nacimiento *
                                        </label>
                                        <input type="text" class="form-control" id="paisNacimiento" 
                                               value="México" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="nacionalidad" class="form-label">
                                            <i class="fas fa-flag"></i> Nacionalidad *
                                        </label>
                                        <input type="text" class="form-control" id="nacionalidad" 
                                               value="Mexicana" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="correoElectronico" class="form-label">
                                            <i class="fas fa-envelope"></i> Correo Electrónico *
                                        </label>
                                        <input type="email" class="form-control" id="correoElectronico" 
                                               value="juan.perez@email.com" required>
                                    </div>

                                    <!-- Cambio de Contraseña -->
                                    <div class="col-12 mb-3 mt-4">
                                        <h5 class="section-subtitle">
                                            <i class="fas fa-lock"></i> Cambiar Contraseña
                                        </h5>
                                        <p class="text-muted">Deja estos campos en blanco si no deseas cambiar tu contraseña</p>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="contrasenaActual" class="form-label">
                                            <i class="fas fa-key"></i> Contraseña Actual
                                        </label>
                                        <input type="password" class="form-control" id="contrasenaActual">
                                    </div>

                                    <div class="col-md-6 mb-3"></div>

                                    <div class="col-md-6 mb-3">
                                        <label for="contrasenaNueva" class="form-label">
                                            <i class="fas fa-lock"></i> Nueva Contraseña
                                        </label>
                                        <input type="password" class="form-control" id="contrasenaNueva">
                                        <small class="form-text text-muted">
                                            Mínimo 8 caracteres, debe incluir: mayúscula, minúscula, número y símbolo (Aa1!)
                                        </small>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="contrasenaConfirmar" class="form-label">
                                            <i class="fas fa-lock"></i> Confirmar Nueva Contraseña
                                        </label>
                                        <input type="password" class="form-control" id="contrasenaConfirmar">
                                    </div>

                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-save"></i> Guardar Cambios
                                        </button>
                                        <button type="reset" class="btn btn-secondary btn-lg ms-2">
                                            <i class="fas fa-undo"></i> Restablecer
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </section>

                        <!-- Configuración Section -->
                        <section id="configuracion" class="content-section">
                            <div class="section-header">
                                <h3>
                                    <i class="fas fa-cog"></i>
                                    Configuración
                                </h3>
                            </div>

                            <div class="settings-section">
                                <h5><i class="fas fa-bell"></i> Notificaciones</h5>
                                <div class="setting-item">
                                    <div class="setting-info">
                                        <strong>Notificaciones de Email</strong>
                                        <p>Recibir notificaciones por correo electrónico</p>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="emailNotif" checked>
                                    </div>
                                </div>

                                <div class="setting-item">
                                    <div class="setting-info">
                                        <strong>Notificar cuando aprueben mis publicaciones</strong>
                                        <p>Recibir notificación cuando un admin apruebe tu contenido</p>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="approvalNotif" checked>
                                    </div>
                                </div>

                                <div class="setting-item">
                                    <div class="setting-info">
                                        <strong>Notificar nuevos likes</strong>
                                        <p>Recibir notificación cuando alguien le dé like a tu publicación</p>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="likesNotif" checked>
                                    </div>
                                </div>

                                <div class="setting-item">
                                    <div class="setting-info">
                                        <strong>Notificar nuevos comentarios</strong>
                                        <p>Recibir notificación cuando alguien comente tu publicación</p>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="commentsNotif" checked>
                                    </div>
                                </div>
                            </div>

                            <div class="settings-section">
                                <h5><i class="fas fa-shield-alt"></i> Privacidad</h5>
                                <div class="setting-item">
                                    <div class="setting-info">
                                        <strong>Perfil Público</strong>
                                        <p>Permitir que otros usuarios vean tu perfil</p>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="publicProfile" checked>
                                    </div>
                                </div>

                                <div class="setting-item">
                                    <div class="setting-info">
                                        <strong>Mostrar estadísticas</strong>
                                        <p>Mostrar el número de publicaciones y likes en tu perfil</p>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="showStats" checked>
                                    </div>
                                </div>
                            </div>

                            <div class="settings-section danger-zone">
                                <h5><i class="fas fa-exclamation-triangle"></i> Zona de Peligro</h5>
                                <div class="setting-item">
                                    <div class="setting-info">
                                        <strong>Eliminar Cuenta</strong>
                                        <p>Eliminar permanentemente tu cuenta y todas tus publicaciones</p>
                                    </div>
                                    <button class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Eliminar Cuenta
                                    </button>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-primary btn-lg">
                                    <i class="fas fa-save"></i> Guardar Configuración
                                </button>
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
    <script src="assets/js/dashboard-usuario.js"></script>
</body>
</html>