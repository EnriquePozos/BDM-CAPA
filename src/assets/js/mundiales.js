/**
 * mundiales.js
 * Funcionalidad para la página de Mundiales
 * - Filtrado por país sede
 * - Ordenamiento (cronológico, likes, comentarios, país)
 * - Búsqueda en tiempo real
 * - Cambio de vista (Grid/Lista)
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ==================== ELEMENTOS DEL DOM ====================
    const filterPais = document.getElementById('filterPais');
    const sortSelect = document.getElementById('sortSelect');
    const searchInput = document.getElementById('searchMundial');
    const mundialesContainer = document.getElementById('mundialesContainer');
    const noResults = document.getElementById('noResults');
    const viewGrid = document.getElementById('viewGrid');
    const viewList = document.getElementById('viewList');
    
    // ==================== FILTRAR POR PAÍS SEDE ====================
    if (filterPais) {
        filterPais.addEventListener('change', function() {
            applyAllFilters();
        });
    }
    
    // ==================== ORDENAR ====================
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortType = this.value;
            const mundialItems = Array.from(document.querySelectorAll('.mundial-item'));
            
            // Ordenar según el criterio seleccionado
            mundialItems.sort((a, b) => {
                switch(sortType) {
                    case 'cronologico':
                        // Más reciente primero (default)
                        return parseInt(b.getAttribute('data-year')) - parseInt(a.getAttribute('data-year'));
                    
                    case 'cronologico-asc':
                        // Más antiguo primero
                        return parseInt(a.getAttribute('data-year')) - parseInt(b.getAttribute('data-year'));
                    
                    case 'likes':
                        // Más likes primero
                        return parseInt(b.getAttribute('data-likes')) - parseInt(a.getAttribute('data-likes'));
                    
                    case 'comentarios':
                        // Más comentarios primero
                        return parseInt(b.getAttribute('data-comments')) - parseInt(a.getAttribute('data-comments'));
                    
                    case 'pais':
                        // Orden alfabético por país
                        const paisA = a.getAttribute('data-pais').toLowerCase();
                        const paisB = b.getAttribute('data-pais').toLowerCase();
                        return paisA.localeCompare(paisB);
                    
                    default:
                        return 0;
                }
            });
            
            // Reorganizar los elementos en el DOM
            mundialItems.forEach(item => {
                mundialesContainer.appendChild(item);
            });
            
            // Animación suave al reordenar
            mundialItems.forEach((item, index) => {
                item.style.animation = 'none';
                setTimeout(() => {
                    item.style.animation = `fadeInUp 0.5s ease-out ${index * 0.05}s forwards`;
                }, 10);
            });
        });
    }
    
    // ==================== BÚSQUEDA EN TIEMPO REAL ====================
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            
            // Debounce de 300ms para no hacer búsquedas a cada tecla
            searchTimeout = setTimeout(() => {
                applyAllFilters();
            }, 300);
        });
    }
    
    // ==================== APLICAR TODOS LOS FILTROS ====================
    function applyAllFilters() {
        const paisFilter = filterPais ? filterPais.value.toLowerCase() : 'todos';
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const mundialItems = document.querySelectorAll('.mundial-item');
        let visibleCount = 0;
        
        mundialItems.forEach(item => {
            const itemPais = item.getAttribute('data-pais').toLowerCase();
            const year = item.getAttribute('data-year');
            const title = item.querySelector('.mundial-title').textContent.toLowerCase();
            const description = item.querySelector('.mundial-description').textContent.toLowerCase();
            
            // Verificar filtro de país
            const matchesPais = paisFilter === 'todos' || itemPais === paisFilter;
            
            // Verificar búsqueda (busca en año, país, título y descripción)
            const matchesSearch = searchTerm === '' ||
                year.includes(searchTerm) ||
                itemPais.includes(searchTerm) ||
                title.includes(searchTerm) ||
                description.includes(searchTerm);
            
            // Mostrar solo si cumple AMBOS criterios
            if (matchesPais && matchesSearch) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        // Mostrar/ocultar mensaje de "no hay resultados"
        if (visibleCount === 0) {
            noResults.style.display = 'block';
            mundialesContainer.style.display = 'none';
        } else {
            noResults.style.display = 'none';
            mundialesContainer.style.display = 'flex';
        }
        
        // Log para debug
        console.log(`Mostrando ${visibleCount} de ${document.querySelectorAll('.mundial-item').length} mundiales`);
    }
    
    // ==================== CAMBIAR VISTA (Grid/Lista) ====================
    if (viewGrid && viewList) {
        viewGrid.addEventListener('click', function() {
            mundialesContainer.classList.remove('list-view');
            viewGrid.classList.add('active');
            viewList.classList.remove('active');
            
            // Guardar preferencia en localStorage
            localStorage.setItem('mundialesView', 'grid');
        });
        
        viewList.addEventListener('click', function() {
            mundialesContainer.classList.add('list-view');
            viewList.classList.add('active');
            viewGrid.classList.remove('active');
            
            // Guardar preferencia en localStorage
            localStorage.setItem('mundialesView', 'list');
        });
        
        // Cargar vista guardada del usuario
        const savedView = localStorage.getItem('mundialesView');
        if (savedView === 'list') {
            viewList.click();
        }
    }
    
    // ==================== RESETEAR TODOS LOS FILTROS ====================
    window.resetFilters = function() {
        // Resetear selectores
        if (filterPais) filterPais.value = 'todos';
        if (sortSelect) sortSelect.value = 'cronologico';
        if (searchInput) searchInput.value = '';
        
        // Mostrar todos los mundiales
        const mundialItems = document.querySelectorAll('.mundial-item');
        mundialItems.forEach(item => {
            item.style.display = 'block';
        });
        
        // Ocultar mensaje de "no hay resultados"
        noResults.style.display = 'none';
        mundialesContainer.style.display = 'flex';
        
        // Reordenar cronológicamente
        if (sortSelect) {
            sortSelect.dispatchEvent(new Event('change'));
        }
        
        console.log('✓ Filtros reseteados');
    };
    
    // ==================== ANIMACIONES AL SCROLL ====================
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observar cards para animación al aparecer en viewport
    const mundialCards = document.querySelectorAll('.mundial-card-full');
    mundialCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease-out';
        observer.observe(card);
    });
    
    // ==================== SMOOTH SCROLL ====================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // ==================== TOOLTIPS DE BOOTSTRAP ====================
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // ==================== INICIALIZACIÓN ====================
    console.log('🌍 Página de Mundiales cargada correctamente');
    console.log(`📊 Total de mundiales: ${document.querySelectorAll('.mundial-item').length}`);
    
    // Aplicar orden inicial (cronológico por default)
    if (sortSelect && sortSelect.value === 'cronologico') {
        sortSelect.dispatchEvent(new Event('change'));
    }
    
    // Aplicar filtros iniciales (por si viene de un link con parámetros)
    applyAllFilters();
});

// ==================== FUNCIONES GLOBALES ====================

/**
 * Ir a página de detalle de mundial
 * @param {number} mundialId - ID del mundial
 */
function verDetalleMundial(mundialId) {
    window.location.href = `mundial-detail.html?id=${mundialId}`;
}

/**
 * Compartir mundial en redes sociales
 * @param {string} platform - Plataforma (facebook, twitter, whatsapp)
 * @param {number} mundialId - ID del mundial
 */
function compartirMundial(platform, mundialId) {
    const url = encodeURIComponent(window.location.origin + `/mundial-detail.html?id=${mundialId}`);
    const text = encodeURIComponent('¡Mira este mundial de la FIFA!');
    
    let shareUrl = '';
    
    switch(platform) {
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
            break;
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${text}`;
            break;
        case 'whatsapp':
            shareUrl = `https://wa.me/?text=${text}%20${url}`;
            break;
    }
    
    if (shareUrl) {
        window.open(shareUrl, '_blank', 'width=600,height=400');
    }
}

/**
 * Dar like a un mundial (cuando se implemente el backend)
 * @param {number} mundialId - ID del mundial
 */
function likeMundial(mundialId) {
    console.log(`Like al mundial ${mundialId}`);
    // Aquí irá la llamada AJAX cuando tengas backend
    // Por ahora solo muestra un mensaje
    if (window.showNotification) {
        window.showNotification('Función disponible cuando inicies sesión', 'info');
    }
}