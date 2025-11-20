/**
 * MURO.JS - Funcionalidad del Muro de Publicaciones
 * Versión compatible con formularios PHP tradicionales
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ==================== INICIALIZACIÓN ====================
    inicializarFiltros();
    inicializarAnimaciones();

    // ==================== FILTROS Y CATEGORÍAS ====================
    function inicializarFiltros() {
        // Filtro de categorías (solo visual)
        const categoryPills = document.querySelectorAll('.category-pill');
        categoryPills.forEach(pill => {
            pill.addEventListener('click', function() {
                // Remover active de todos
                categoryPills.forEach(p => p.classList.remove('active'));
                // Agregar active al clickeado
                this.classList.add('active');
                
                const category = this.getAttribute('data-category');
                filtrarPublicacionesVisual(category);
            });
        });

        // Filtro de ordenamiento (solo visual)
        const sortSelect = document.getElementById('sortSelect');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const sortType = this.value;
                ordenarPublicacionesVisual(sortType);
            });
        }
    }

    /**
     * Filtrado visual (sin AJAX)
     * Solo oculta/muestra publicaciones según categoría
     */
    function filtrarPublicacionesVisual(categoria) {
        const posts = document.querySelectorAll('.post-muro');
        
        posts.forEach(post => {
            const categoryBadge = post.querySelector('.post-category-badge');
            const postCategory = categoryBadge ? categoryBadge.textContent.trim().toLowerCase() : '';
            
            if (categoria === 'all') {
                post.style.display = 'block';
            } else if (postCategory.includes(categoria.toLowerCase())) {
                post.style.display = 'block';
            } else {
                post.style.display = 'none';
            }
        });
        
        console.log(`Filtrando por categoría: ${categoria}`);
    }

    /**
     * Ordenamiento visual (sin AJAX)
     * Reordena posts por likes, comentarios, etc.
     */
    function ordenarPublicacionesVisual(tipo) {
        const postsContainer = document.querySelector('.posts-feed');
        if (!postsContainer) return;
        
        const posts = Array.from(document.querySelectorAll('.post-muro'));
        
        posts.sort((a, b) => {
            switch(tipo) {
                case 'likes':
                    const likesA = parseInt(a.querySelector('.action-btn-muro:has(.fa-heart)')?.textContent.match(/\d+/)?.[0] || 0);
                    const likesB = parseInt(b.querySelector('.action-btn-muro:has(.fa-heart)')?.textContent.match(/\d+/)?.[0] || 0);
                    return likesB - likesA;
                    
                case 'comentarios':
                    const commentsA = parseInt(a.querySelector('.action-btn-muro:has(.fa-comment)')?.textContent.match(/\d+/)?.[0] || 0);
                    const commentsB = parseInt(b.querySelector('.action-btn-muro:has(.fa-comment)')?.textContent.match(/\d+/)?.[0] || 0);
                    return commentsB - commentsA;
                    
                case 'reciente':
                default:
                    // Ya están ordenados por defecto (más reciente primero)
                    return 0;
            }
        });
        
        // Reorganizar en el DOM
        posts.forEach(post => postsContainer.appendChild(post));
        
        console.log(`Ordenando por: ${tipo}`);
    }

    // ==================== ANIMACIONES ====================
    function inicializarAnimaciones() {
        // Animación al hacer scroll
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
        
        // Observar posts
        const posts = document.querySelectorAll('.post-muro');
        posts.forEach(post => {
            post.style.opacity = '0';
            post.style.transform = 'translateY(30px)';
            post.style.transition = 'all 0.6s ease-out';
            observer.observe(post);
        });
    }

    // ==================== SCROLL SUAVE ====================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
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

    console.log('🚀 Muro de publicaciones inicializado correctamente');
});

// ==================== FUNCIÓN GLOBAL: TOGGLE COMMENTS ====================
/**
 * Función global para mostrar/ocultar comentarios
 * Se llama desde el HTML directamente: onclick="toggleComments('comments-123')"
 */
window.toggleComments = function(id) {
    const commentsSection = document.getElementById(id);
    if (commentsSection) {
        if (commentsSection.style.display === 'none' || commentsSection.style.display === '') {
            commentsSection.style.display = 'block';
            // Animación suave
            commentsSection.style.animation = 'fadeIn 0.3s ease-out';
        } else {
            commentsSection.style.display = 'none';
        }
    }
};

// ==================== ESTILOS DE ANIMACIÓN ====================
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .post-comments-section {
        animation: fadeIn 0.3s ease-out;
    }
`;
document.head.appendChild(style);

// ==================== FUNCIONES AJAX (PARA BACKEND) ====================
/**
 * Estas funciones se conectarán con el backend PHP cuando esté implementado
 */

// function cargarPublicacionesAjax(mundial, categoria, ordenamiento) {
//     fetch(`api/publicaciones.php?mundial=${mundial}&categoria=${categoria}&orden=${ordenamiento}`)
//         .then(response => response.json())
//         .then(data => {
//             renderizarPublicaciones(data);
//         })
//         .catch(error => {
//             console.error('Error:', error);
//             mostrarMensaje('Error al cargar publicaciones', 'danger');
//         });
// }

// function guardarLikeAjax(idPublicacion) {
//     fetch('api/likes.php', {
//         method: 'POST',
//         headers: { 'Content-Type': 'application/json' },
//         body: JSON.stringify({ id_publicacion: idPublicacion })
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.success) {
//             console.log('Like guardado');
//         }
//     });
// }

// function enviarComentarioAjax(texto, idPublicacion) {
//     fetch('api/comentarios.php', {
//         method: 'POST',
//         headers: { 'Content-Type': 'application/json' },
//         body: JSON.stringify({ 
//             texto: texto, 
//             id_publicacion: idPublicacion 
//         })
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.success) {
//             console.log('Comentario guardado');
//         }
//     });
// }

// function crearPublicacionAjax(formData) {
//     fetch('api/crear_publicacion.php', {
//         method: 'POST',
//         body: formData
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.success) {
//             mostrarMensaje('Publicación creada exitosamente', 'success');
//         }
//     });
// }