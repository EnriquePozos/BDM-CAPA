// galeria.js - Funcionalidades para la página de Galería
document.addEventListener('DOMContentLoaded', function() {
    
    // Variables globales
    let currentView = 'grid';
    let currentPage = 1;
    const itemsPerPage = 12;
    let filteredMedia = [];
    let selectedFiles = [];
    
    // Datos de ejemplo de contenido multimedia
    const mediaData = [
        {
            id: 1,
            type: 'foto',
            title: 'Gol de Messi en la Final',
            description: 'El momento histórico del gol de Messi en la final de Qatar 2022',
            mundial: '2022',
            categoria: 'goles',
            thumbnail: 'https://picsum.photos/400/300?random=1',
            url: 'https://picsum.photos/1200/800?random=1',
            views: 15420,
            likes: 892,
            tags: ['messi', 'argentina', 'final', 'gol'],
            uploadDate: '2022-12-18',
            author: 'FIFAOfficial'
        },
        {
            id: 2,
            type: 'video',
            title: 'Celebración de Francia 2018',
            description: 'Los jugadores franceses celebran el título mundial en Rusia',
            mundial: '2018',
            categoria: 'celebraciones',
            thumbnail: 'https://picsum.photos/400/300?random=2',
            url: 'https://sample-videos.com/zip/10/mp4/SampleVideo_720x480_1mb.mp4',
            views: 8765,
            likes: 543,
            tags: ['francia', 'celebracion', 'campeon'],
            uploadDate: '2018-07-15',
            author: 'WorldCupHighlights'
        },
        {
            id: 3,
            type: 'foto',
            title: 'Estadio Maracaná Lleno',
            description: 'Vista panorámica del icónico estadio durante Brasil 2014',
            mundial: '2014',
            categoria: 'estadios',
            thumbnail: 'https://picsum.photos/400/300?random=3',
            url: 'https://picsum.photos/1200/800?random=3',
            views: 12340,
            likes: 678,
            tags: ['maracana', 'brasil', 'estadio'],
            uploadDate: '2014-06-12',
            author: 'StadiumPhotos'
        },
        {
            id: 4,
            type: 'video',
            title: 'Atajada Espectacular de Neuer',
            description: 'La increíble atajada de Manuel Neuer en el Mundial de Brasil',
            mundial: '2014',
            categoria: 'jugadas',
            thumbnail: 'https://picsum.photos/400/300?random=4',
            url: 'https://sample-videos.com/zip/10/mp4/SampleVideo_720x480_2mb.mp4',
            views: 9876,
            likes: 445,
            tags: ['neuer', 'atajada', 'alemania'],
            uploadDate: '2014-07-08',
            author: 'GoalkeepingSaves'
        },
        {
            id: 5,
            type: 'foto',
            title: 'Aficionados Argentinos',
            description: 'La pasión de la hinchada argentina en las tribunas',
            mundial: '2022',
            categoria: 'aficionados',
            thumbnail: 'https://picsum.photos/400/300?random=5',
            url: 'https://picsum.photos/1200/800?random=5',
            views: 7654,
            likes: 321,
            tags: ['argentina', 'aficionados', 'hinchada'],
            uploadDate: '2022-12-10',
            author: 'FanPhotos'
        },
        {
            id: 6,
            type: 'audio',
            title: 'Himno Nacional Argentina',
            description: 'Interpretación del himno antes de la final',
            mundial: '2022',
            categoria: 'ceremonias',
            thumbnail: 'https://picsum.photos/400/300?random=6',
            url: '#',
            views: 5432,
            likes: 234,
            tags: ['himno', 'argentina', 'ceremonia'],
            uploadDate: '2022-12-18',
            author: 'CeremonialSounds'
        }
    ];
    
    // Elementos del DOM
    const filterTipo = document.getElementById('filter-tipo');
    const filterMundial = document.getElementById('filter-mundial');
    const filterCategoria = document.getElementById('filter-categoria');
    const searchGaleria = document.getElementById('search-galeria');
    const filterOrden = document.getElementById('filter-orden');
    const btnLimpiarFiltros = document.getElementById('btn-limpiar-filtros');
    const galleryContainer = document.getElementById('gallery-container');
    const resultsCount = document.getElementById('results-count');
    const gridViewBtn = document.getElementById('grid-view');
    const masonryViewBtn = document.getElementById('masonry-view');
    const listViewBtn = document.getElementById('list-view');
    const loadMoreBtn = document.getElementById('load-more-btn');
    const uploadZone = document.getElementById('upload-zone');
    const fileInput = document.getElementById('file-input');
    const uploadDetails = document.getElementById('upload-details');
    const btnConfirmarUpload = document.getElementById('btn-confirmar-upload');
    
    // Navbar scroll effect
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.style.background = '#6101eb';
            navbar.style.boxShadow = '0 4px 24px 0 rgba(97, 1, 235, 0.4)';
        } else {
            navbar.style.background = '#6101eb';
            navbar.style.boxShadow = '0 4px 24px 0 rgba(97, 1, 235, 0.25)';
        }
    });
    
    // Función para crear elemento de galería
    function createGalleryItem(item) {
        const typeIcon = {
            'foto': 'fas fa-image',
            'video': 'fas fa-play',
            'audio': 'fas fa-volume-up'
        };
        
        const playButton = item.type === 'video' ? 
            '<div class="play-button"><i class="fas fa-play"></i></div>' : '';
        
        return `
            <div class="col-lg-4 col-md-6 gallery-item-wrapper" data-type="${item.type}" data-mundial="${item.mundial}" data-categoria="${item.categoria}" data-title="${item.title.toLowerCase()}">
                <div class="gallery-item" onclick="openMediaModal('${item.id}')">
                    <div class="media-thumbnail">
                        ${item.type === 'video' ? 
                            `<video><source src="${item.thumbnail}" type="video/mp4"></video>` :
                            `<img src="${item.thumbnail}" alt="${item.title}" loading="lazy">`
                        }
                        <div class="media-type-badge ${item.type}">
                            <i class="${typeIcon[item.type]}"></i>
                            ${item.type}
                        </div>
                        ${playButton}
                        <div class="media-overlay">
                            <div class="overlay-content">
                                <h6 class="text-white">${item.title}</h6>
                                <p class="text-white-50 mb-0">${item.description}</p>
                            </div>
                        </div>
                    </div>
                    <div class="media-info">
                        <h6 class="media-title">${item.title}</h6>
                        <div class="media-meta">
                            <span class="mundial-badge">${item.mundial}</span>
                            <span class="categoria-badge">${item.categoria}</span>
                        </div>
                        <div class="media-stats">
                            <div class="stat-item">
                                <i class="fas fa-eye"></i>
                                <span>${formatNumber(item.views)}</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-heart"></i>
                                <span>${formatNumber(item.likes)}</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-user"></i>
                                <span>${item.author}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Función para formatear números
    function formatNumber(num) {
        if (num >= 1000000) {
            return (num / 1000000).toFixed(1) + 'M';
        } else if (num >= 1000) {
            return (num / 1000).toFixed(1) + 'K';
        }
        return num.toString();
    }
    
    // Función para filtrar contenido
    function filterMedia() {
        const typeFilter = filterTipo.value;
        const mundialFilter = filterMundial.value;
        const categoriaFilter = filterCategoria.value;
        const searchTerm = searchGaleria.value.toLowerCase();
        const ordenFilter = filterOrden.value;
        
        filteredMedia = mediaData.filter(item => {
            const matchesType = !typeFilter || item.type === typeFilter;
            const matchesMundial = !mundialFilter || item.mundial === mundialFilter || 
                                  (mundialFilter === 'clasicos' && parseInt(item.mundial) < 2000);
            const matchesCategoria = !categoriaFilter || item.categoria === categoriaFilter;
            const matchesSearch = !searchTerm || 
                                item.title.toLowerCase().includes(searchTerm) ||
                                item.description.toLowerCase().includes(searchTerm) ||
                                item.tags.some(tag => tag.toLowerCase().includes(searchTerm));
            
            return matchesType && matchesMundial && matchesCategoria && matchesSearch;
        });
        
        // Aplicar ordenamiento
        switch (ordenFilter) {
            case 'populares':
                filteredMedia.sort((a, b) => b.likes - a.likes);
                break;
            case 'antiguos':
                filteredMedia.sort((a, b) => new Date(a.uploadDate) - new Date(b.uploadDate));
                break;
            case 'alfabetico':
                filteredMedia.sort((a, b) => a.title.localeCompare(b.title));
                break;
            case 'recientes':
            default:
                filteredMedia.sort((a, b) => new Date(b.uploadDate) - new Date(a.uploadDate));
                break;
        }
        
        return filteredMedia;
    }
    
    // Función para renderizar galería
    function renderGallery(reset = true) {
        if (reset) {
            currentPage = 1;
        }
        
        const filtered = filterMedia();
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const itemsToShow = filtered.slice(0, endIndex);
        
        if (itemsToShow.length === 0) {
            galleryContainer.innerHTML = `
                <div class="col-12">
                    <div class="no-results-gallery">
                        <i class="fas fa-search"></i>
                        <h4>No se encontró contenido</h4>
                        <p>Intenta ajustar los filtros de búsqueda</p>
                        <button class="btn btn-primary" onclick="limpiarFiltros()">
                            <i class="fas fa-eraser me-2"></i>Limpiar Filtros
                        </button>
                    </div>
                </div>
            `;
        } else {
            if (reset) {
                galleryContainer.innerHTML = itemsToShow.map(createGalleryItem).join('');
            } else {
                const newItems = filtered.slice(startIndex, endIndex);
                galleryContainer.insertAdjacentHTML('beforeend', newItems.map(createGalleryItem).join(''));
            }
            
            // Aplicar vista actual
            galleryContainer.className = `row g-4 ${currentView}-view`;
        }
        
        // Actualizar contador
        resultsCount.textContent = filtered.length;
        
        // Mostrar/ocultar botón de cargar más
        loadMoreBtn.style.display = endIndex >= filtered.length ? 'none' : 'block';
        
        // Animar elementos
        const items = document.querySelectorAll('.gallery-item-wrapper');
        items.forEach((item, index) => {
            if (index >= startIndex) {
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, (index - startIndex) * 100);
            }
        });
    }
    
    // Event listeners para filtros
    [filterTipo, filterMundial, filterCategoria, filterOrden].forEach(filter => {
        filter.addEventListener('change', () => renderGallery());
    });
    
    searchGaleria.addEventListener('input', debounce(() => renderGallery(), 300));
    
    // Función debounce
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // Limpiar filtros
    function limpiarFiltros() {
        filterTipo.value = '';
        filterMundial.value = '';
        filterCategoria.value = '';
        searchGaleria.value = '';
        filterOrden.value = 'recientes';
        
        // Remover clases activas
        [filterTipo, filterMundial, filterCategoria, searchGaleria].forEach(el => {
            el.classList.remove('filter-active-gallery');
        });
        
        renderGallery();
        showNotification('Filtros limpiados correctamente', 'success');
    }
    
    btnLimpiarFiltros.addEventListener('click', limpiarFiltros);
    window.limpiarFiltros = limpiarFiltros;
    
    // Toggle de vistas
    gridViewBtn.addEventListener('click', () => setView('grid'));
    masonryViewBtn.addEventListener('click', () => setView('masonry'));
    listViewBtn.addEventListener('click', () => setView('list'));
    
    function setView(view) {
        currentView = view;
        
        // Actualizar botones activos
        document.querySelectorAll('.view-toggle .btn').forEach(btn => btn.classList.remove('active'));
        document.getElementById(`${view}-view`).classList.add('active');
        
        // Aplicar clase de vista
        galleryContainer.className = `row g-4 ${view}-view`;
        
        showNotification(`Vista cambiada a ${view}`, 'info');
    }
    
    // Cargar más contenido
    loadMoreBtn.addEventListener('click', function() {
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Cargando...';
        this.disabled = true;
        
        setTimeout(() => {
            currentPage++;
            renderGallery(false);
            this.innerHTML = '<i class="fas fa-plus me-2"></i>Cargar Más Contenido';
            this.disabled = false;
        }, 1000);
    });
    
    // Upload functionality
    uploadZone.addEventListener('click', () => fileInput.click());
    
    uploadZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadZone.classList.add('dragover');
    });
    
    uploadZone.addEventListener('dragleave', () => {
        uploadZone.classList.remove('dragover');
    });
    
    uploadZone.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadZone.classList.remove('dragover');
        handleFiles(e.dataTransfer.files);
    });
    
    fileInput.addEventListener('change', (e) => {
        handleFiles(e.target.files);
    });
    
    function handleFiles(files) {
        selectedFiles = Array.from(files);
        
        if (selectedFiles.length > 0) {
            uploadDetails.style.display = 'block';
            btnConfirmarUpload.disabled = false;
            
            // Mostrar preview del primer archivo
            const file = selectedFiles[0];
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    uploadZone.style.backgroundImage = `url(${e.target.result})`;
                    uploadZone.style.backgroundSize = 'cover';
                    uploadZone.style.backgroundPosition = 'center';
                };
                reader.readAsDataURL(file);
            }
            
            showNotification(`${selectedFiles.length} archivo(s) seleccionado(s)`, 'success');
        }
    }
    
    btnConfirmarUpload.addEventListener('click', function() {
        const titulo = document.getElementById('upload-titulo').value;
        const mundial = document.getElementById('upload-mundial').value;
        const categoria = document.getElementById('upload-categoria').value;
        
        if (!titulo || !mundial || !categoria) {
            showNotification('Por favor completa todos los campos obligatorios', 'warning');
            return;
        }
        
        // Simular upload
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Subiendo...';
        this.disabled = true;
        
        setTimeout(() => {
            showNotification('Archivo subido exitosamente. Pendiente de aprobación.', 'success');
            
            // Limpiar formulario
            document.getElementById('upload-form').reset();
            uploadDetails.style.display = 'none';
            uploadZone.style.backgroundImage = '';
            selectedFiles = [];
            
            // Cerrar modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('uploadModal'));
            modal.hide();
            
            this.innerHTML = '<i class="fas fa-upload me-2"></i>Subir Archivo';
            this.disabled = false;
        }, 2000);
    });
    
    // Función para abrir modal de media
    window.openMediaModal = function(itemId) {
        const item = mediaData.find(m => m.id == itemId);
        if (!item) return;
        
        const modal = document.getElementById('mediaModal');
        const modalTitle = document.getElementById('mediaModalTitle');
        const modalBody = document.getElementById('mediaModalBody');
        const mediaViews = document.getElementById('media-views');
        const mediaLikes = document.getElementById('media-likes');
        
        modalTitle.textContent = item.title;
        mediaViews.textContent = formatNumber(item.views);
        mediaLikes.textContent = formatNumber(item.likes);
        
        // Crear contenido según tipo
        let mediaContent = '';
        if (item.type === 'video') {
            mediaContent = `
                <video controls style="max-width: 100%; max-height: 80vh;">
                    <source src="${item.url}" type="video/mp4">
                    Tu navegador no soporta video HTML5.
                </video>
            `;
        } else if (item.type === 'audio') {
            mediaContent = `
                <div class="audio-player">
                    <audio controls style="width: 100%;">
                        <source src="${item.url}" type="audio/mpeg">
                        Tu navegador no soporta audio HTML5.
                    </audio>
                    <div class="audio-info mt-3">
                        <h4>${item.title}</h4>
                        <p>${item.description}</p>
                    </div>
                </div>
            `;
        } else {
            mediaContent = `<img src="${item.url}" alt="${item.title}" style="max-width: 100%; max-height: 80vh;">`;
        }
        
        modalBody.innerHTML = mediaContent;
        
        // Configurar botones de acción
        setupMediaActions(item);
        
        // Mostrar modal
        const mediaModal = new bootstrap.Modal(modal);
        mediaModal.show();
        
        // Incrementar vistas (simulado)
        item.views++;
        mediaViews.textContent = formatNumber(item.views);
    };
    
    function setupMediaActions(item) {
        const btnLike = document.getElementById('btn-like');
        const btnShare = document.getElementById('btn-share');
        const btnDownload = document.getElementById('btn-download');
        
        btnLike.onclick = () => {
            item.likes++;
            document.getElementById('media-likes').textContent = formatNumber(item.likes);
            btnLike.innerHTML = '<i class="fas fa-heart text-danger"></i> Me gusta';
            showNotification('¡Te gusta este contenido!', 'success');
        };
        
        btnShare.onclick = () => {
            if (navigator.share) {
                navigator.share({
                    title: item.title,
                    text: item.description,
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href);
                showNotification('Enlace copiado al portapapeles', 'success');
            }
        };
        
        btnDownload.onclick = () => {
            // Simular descarga
            showNotification('Iniciando descarga...', 'info');
            setTimeout(() => {
                showNotification('Descarga completada', 'success');
            }, 1500);
        };
    }
    
    // Función para mostrar notificaciones
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} notification`;
        notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            padding: 1rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        `;
        
        const colors = {
            'info': 'background: rgba(59, 130, 246, 0.9); color: white; border: 1px solid #3B82F6;',
            'success': 'background: rgba(16, 185, 129, 0.9); color: white; border: 1px solid #10B981;',
            'warning': 'background: rgba(245, 158, 11, 0.9); color: white; border: 1px solid #F59E0B;',
            'danger': 'background: rgba(239, 68, 68, 0.9); color: white; border: 1px solid #EF4444;'
        };
        
        notification.style.cssText += colors[type] || colors['info'];
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : type === 'danger' ? 'times-circle' : 'info-circle'} me-2"></i>
                <span>${message}</span>
                <button type="button" class="btn-close btn-close-white ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 5000);
    }
    
    // Efectos visuales para filtros activos
    [filterTipo, filterMundial, filterCategoria, searchGaleria].forEach(filter => {
        filter.addEventListener('input', function() {
            if (this.value) {
                this.classList.add('filter-active-gallery');
            } else {
                this.classList.remove('filter-active-gallery');
            }
        });
        
        filter.addEventListener('change', function() {
            if (this.value) {
                this.classList.add('filter-active-gallery');
            } else {
                this.classList.remove('filter-active-gallery');
            }
        });
    });
    
    // Animaciones de entrada
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    // Observar elementos para animación
    document.querySelectorAll('.media-stat, .upload-container, .collection-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s ease-out';
        observer.observe(el);
    });
    
    // Estadísticas animadas en hero
    function animateHeroStats() {
        const statNumbers = document.querySelectorAll('.media-stat .stat-number');
        statNumbers.forEach(stat => {
            const target = stat.textContent.replace(/[^\d]/g, '');
            const targetNum = parseInt(target);
            let current = 0;
            const increment = targetNum / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= targetNum) {
                    stat.textContent = formatNumber(targetNum);
                    clearInterval(timer);
                } else {
                    stat.textContent = formatNumber(Math.floor(current));
                }
            }, 30);
        });
    }
    
    // Configurar colecciones destacadas
    function setupCollections() {
        const collectionCards = document.querySelectorAll('.collection-card');
        collectionCards.forEach((card, index) => {
            const btn = card.querySelector('button');
            btn.addEventListener('click', function() {
                const collectionName = card.querySelector('h5').textContent;
                showNotification(`Cargando colección: ${collectionName}`, 'info');
                
                // Simular filtro de colección
                switch (index) {
                    case 0: // Goles Legendarios
                        filterCategoria.value = 'goles';
                        break;
                    case 1: // Finales Épicas
                        searchGaleria.value = 'final';
                        break;
                    case 2: // Afición Mundial
                        filterCategoria.value = 'aficionados';
                        break;
                }
                
                renderGallery();
                document.getElementById('gallery-section').scrollIntoView({ behavior: 'smooth' });
            });
        });
    }
    
    // Funcionalidad de búsqueda por teclado
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'f') {
            e.preventDefault();
            searchGaleria.focus();
            showNotification('Usa la búsqueda para encontrar contenido específico', 'info');
        }
        
        // Navegación con teclado en galería
        if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
            const modal = document.getElementById('mediaModal');
            if (modal.classList.contains('show')) {
                e.preventDefault();
                // Aquí se podría implementar navegación entre elementos
                showNotification('Navegación con teclado: Funcionalidad futura', 'info');
            }
        }
    });
    
    // Lazy loading para imágenes
    function setupLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src || img.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            // Observar todas las imágenes lazy
            document.querySelectorAll('img[loading="lazy"]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }
    
    // Funciones de utilidad
    function generateMoreSampleData() {
        // Generar más datos de ejemplo para demostración
        const mundiales = ['2022', '2018', '2014', '2010'];
        const categorias = ['goles', 'jugadas', 'celebraciones', 'estadios', 'aficionados', 'ceremonias'];
        const tipos = ['foto', 'video', 'audio'];
        
        for (let i = mediaData.length + 1; i <= 50; i++) {
            const randomMundial = mundiales[Math.floor(Math.random() * mundiales.length)];
            const randomCategoria = categorias[Math.floor(Math.random() * categorias.length)];
            const randomTipo = tipos[Math.floor(Math.random() * tipos.length)];
            
            mediaData.push({
                id: i,
                type: randomTipo,
                title: `Contenido ${i} - ${randomCategoria}`,
                description: `Descripción del contenido multimedia número ${i}`,
                mundial: randomMundial,
                categoria: randomCategoria,
                thumbnail: `https://picsum.photos/400/300?random=${i}`,
                url: `https://picsum.photos/1200/800?random=${i}`,
                views: Math.floor(Math.random() * 50000) + 1000,
                likes: Math.floor(Math.random() * 2000) + 100,
                tags: [`tag${i}`, randomCategoria, randomMundial],
                uploadDate: `2023-0${Math.floor(Math.random() * 9) + 1}-${Math.floor(Math.random() * 28) + 1}`,
                author: `Usuario${i}`
            });
        }
    }
    
    // Inicializar página
    setTimeout(() => {
        generateMoreSampleData(); // Generar más datos de ejemplo
        renderGallery();
        animateHeroStats();
        setupCollections();
        setupLazyLoading();
        
        showNotification('¡Explora nuestra galería multimedia de los Mundiales FIFA!', 'success');
    }, 500);
    
    console.log('📸 Página de Galería FIFA cargada correctamente');
});