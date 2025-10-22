/**
 * MURO.JS - Funcionalidad del Muro de Publicaciones
 * Cumple con requisitos de validación y AJAX
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ==================== INICIALIZACIÓN ====================
    obtenerMundialActual();
    inicializarFiltros();
    inicializarAcciones();
    inicializarFormularioPublicacion();

    // ==================== OBTENER MUNDIAL DE URL ====================
    function obtenerMundialActual() {
        const urlParams = new URLSearchParams(window.location.search);
        const mundial = urlParams.get('mundial');
        
        if (mundial) {
            const nombresMundiales = {
                'qatar2022': 'Qatar 2022',
                'rusia2018': 'Rusia 2018',
                'brasil2014': 'Brasil 2014',
                'sudafrica2010': 'Sudáfrica 2010',
                'alemania2006': 'Alemania 2006',
                'mexico1986': 'México 1986'
            };
            
            const nombreMundial = nombresMundiales[mundial] || 'Mundial';
            document.title = `${nombreMundial} - Muro de Publicaciones`;
            
            // Actualizar textos en la página
            const titleElements = document.querySelectorAll('.mundial-header-title, #createPostModalLabel');
            titleElements.forEach(el => {
                if (el.classList.contains('mundial-header-title')) {
                    el.innerHTML = `<i class="fas fa-trophy me-3"></i>${nombreMundial.toUpperCase()}`;
                } else {
                    el.innerHTML = `<i class="fas fa-plus-circle me-2"></i>Crear Nueva Publicación en ${nombreMundial}`;
                }
            });
        }
    }

    // ==================== FILTROS Y CATEGORÍAS ====================
    function inicializarFiltros() {
        // Filtro de categorías
        const categoryPills = document.querySelectorAll('.category-pill');
        categoryPills.forEach(pill => {
            pill.addEventListener('click', function() {
                // Remover active de todos
                categoryPills.forEach(p => p.classList.remove('active'));
                // Agregar active al clickeado
                this.classList.add('active');
                
                const category = this.getAttribute('data-category');
                filtrarPublicaciones(category);
            });
        });

        // Filtro de ordenamiento
        const sortSelect = document.getElementById('sortSelect');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const sortType = this.value;
                ordenarPublicaciones(sortType);
            });
        }
    }

    function filtrarPublicaciones(categoria) {
        console.log('Filtrando por categoría:', categoria);
        
        // Mostrar mensaje de carga
        mostrarMensaje('Filtrando publicaciones...', 'info');
        
        // AQUÍ SE HARÍA LA LLAMADA AJAX AL BACKEND
        // Por ahora simulamos el filtrado
        
        setTimeout(() => {
            if (categoria === 'all') {
                mostrarMensaje('Mostrando todas las publicaciones', 'success');
            } else {
                mostrarMensaje(`Mostrando publicaciones de: ${categoria}`, 'success');
            }
        }, 500);
    }

    function ordenarPublicaciones(tipo) {
        console.log('Ordenando por:', tipo);
        mostrarMensaje(`Ordenando por: ${tipo}`, 'info');
        
        // AQUÍ SE HARÍA LA LLAMADA AJAX PARA REORDENAR
        setTimeout(() => {
            mostrarMensaje('Publicaciones ordenadas', 'success');
        }, 500);
    }

    // ==================== ACCIONES DE PUBLICACIONES ====================
    function inicializarAcciones() {
        // Likes
        const likeBtns = document.querySelectorAll('.action-btn-muro:has(.fa-heart)');
        likeBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                darLike(this);
            });
        });

        // Botón de enviar comentario
        const commentBtns = document.querySelectorAll('.btn-send-comment');
        commentBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const commentForm = this.closest('.comment-form');
                const input = commentForm.querySelector('.comment-input');
                enviarComentario(input.value, this);
            });
        });

        // Enter en input de comentario
        const commentInputs = document.querySelectorAll('.comment-input');
        commentInputs.forEach(input => {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const btn = this.closest('.comment-form').querySelector('.btn-send-comment');
                    enviarComentario(this.value, btn);
                }
            });
        });

        // Cargar más publicaciones
        const loadMoreBtn = document.querySelector('.btn-load-more-muro');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', cargarMasPublicaciones);
        }
    }

    function darLike(btn) {
        // Validar si el usuario está logueado
        const estaLogueado = validarSesion();
        if (!estaLogueado) {
            mostrarMensaje('Debes iniciar sesión para dar like', 'warning');
            setTimeout(() => {
                window.location.href = 'login.html';
            }, 1500);
            return;
        }

        // Toggle del like
        btn.classList.toggle('active-like');
        const icon = btn.querySelector('i');
        
        if (btn.classList.contains('active-like')) {
            icon.classList.remove('far');
            icon.classList.add('fas');
            
            // Incrementar contador
            const counter = btn.querySelector('span');
            const currentLikes = parseInt(counter.textContent.replace('K', '')) * 1000;
            counter.textContent = formatearNumero(currentLikes + 1);
            
            // Animación
            btn.style.transform = 'scale(1.2)';
            setTimeout(() => {
                btn.style.transform = 'scale(1)';
            }, 200);
            
            mostrarMensaje('¡Like agregado!', 'success');
            
            // AQUÍ LLAMADA AJAX PARA GUARDAR LIKE
            // guardarLike(idPublicacion);
            
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
            
            // Decrementar contador
            const counter = btn.querySelector('span');
            const currentLikes = parseInt(counter.textContent.replace('K', '')) * 1000;
            counter.textContent = formatearNumero(currentLikes - 1);
            
            mostrarMensaje('Like removido', 'info');
            
            // AQUÍ LLAMADA AJAX PARA QUITAR LIKE
            // quitarLike(idPublicacion);
        }
    }

    function enviarComentario(texto, btn) {
        // Validaciones
        if (!texto || texto.trim() === '') {
            mostrarMensaje('El comentario no puede estar vacío', 'warning');
            return;
        }

        if (texto.length > 500) {
            mostrarMensaje('El comentario no puede exceder 500 caracteres', 'warning');
            return;
        }

        const estaLogueado = validarSesion();
        if (!estaLogueado) {
            mostrarMensaje('Debes iniciar sesión para comentar', 'warning');
            setTimeout(() => {
                window.location.href = 'login.html';
            }, 1500);
            return;
        }

        // Deshabilitar botón mientras se envía
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        // AQUÍ LLAMADA AJAX PARA GUARDAR COMENTARIO
        // enviarComentarioAjax(texto, idPublicacion)
        
        setTimeout(() => {
            // Crear elemento de comentario
            const commentsList = btn.closest('.post-comments-section').querySelector('.comments-list');
            const nuevoComentario = crearElementoComentario('Tu Usuario', texto, 'Justo ahora');
            commentsList.appendChild(nuevoComentario);
            
            // Limpiar input
            const input = btn.closest('.comment-form').querySelector('.comment-input');
            input.value = '';
            
            // Restaurar botón
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-paper-plane"></i>';
            
            // Incrementar contador de comentarios
            const commentCounter = btn.closest('.post-muro').querySelector('.action-btn-muro:has(.fa-comment) span');
            const currentComments = parseInt(commentCounter.textContent);
            commentCounter.textContent = currentComments + 1;
            
            mostrarMensaje('¡Comentario publicado!', 'success');
            
            // Scroll suave al nuevo comentario
            nuevoComentario.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }, 1000);
    }

    function crearElementoComentario(autor, texto, tiempo) {
        const comentarioHTML = `
            <div class="comment-item" style="animation: fadeIn 0.5s ease;">
                <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(autor)}&background=6101eb&color=fff" 
                     class="comment-avatar" alt="${autor}">
                <div class="comment-content">
                    <h6 class="comment-author">${autor}</h6>
                    <p class="comment-text">${texto}</p>
                    <span class="comment-time">${tiempo}</span>
                </div>
            </div>
        `;
        
        const div = document.createElement('div');
        div.innerHTML = comentarioHTML;
        return div.firstElementChild;
    }

    function cargarMasPublicaciones() {
        const btn = document.querySelector('.btn-load-more-muro');
        const originalText = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Cargando...';
        
        // AQUÍ LLAMADA AJAX PARA CARGAR MÁS PUBLICACIONES
        setTimeout(() => {
            mostrarMensaje('Más publicaciones cargadas', 'success');
            btn.disabled = false;
            btn.innerHTML = originalText;
        }, 1500);
    }

    // ==================== FORMULARIO DE PUBLICACIÓN ====================
    function inicializarFormularioPublicacion() {
        const form = document.getElementById('createPostForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                procesarFormularioPublicacion();
            });

            // Validación en tiempo real
            const titulo = document.getElementById('postTitle');
            const descripcion = document.getElementById('postDescription');
            const categoria = document.getElementById('categoriaSelect');
            const imagen = document.getElementById('postImage');

            if (titulo) {
                titulo.addEventListener('input', function() {
                    validarCampo(this, this.value.length >= 5 && this.value.length <= 200, 
                        'El título debe tener entre 5 y 200 caracteres');
                });
            }

            if (descripcion) {
                descripcion.addEventListener('input', function() {
                    validarCampo(this, this.value.length >= 10 && this.value.length <= 1000, 
                        'La descripción debe tener entre 10 y 1000 caracteres');
                });
            }

            if (imagen) {
                imagen.addEventListener('change', function() {
                    validarArchivo(this);
                });
            }
        }
    }

    function procesarFormularioPublicacion() {
        // Validar sesión
        const estaLogueado = validarSesion();
        if (!estaLogueado) {
            mostrarMensaje('Debes iniciar sesión para crear publicaciones', 'warning');
            setTimeout(() => {
                window.location.href = 'login.html';
            }, 1500);
            return;
        }

        // Obtener datos del formulario
        const titulo = document.getElementById('postTitle').value.trim();
        const descripcion = document.getElementById('postDescription').value.trim();
        const categoria = document.getElementById('categoriaSelect').value;
        const seleccion = document.getElementById('seleccionSelect').value;
        const archivo = document.getElementById('postImage').files[0];

        // Validaciones
        if (!validarFormulario(titulo, descripcion, categoria, archivo)) {
            return;
        }

        // Crear FormData para envío
        const formData = new FormData();
        formData.append('titulo', titulo);
        formData.append('descripcion', descripcion);
        formData.append('categoria', categoria);
        formData.append('seleccion', seleccion);
        formData.append('archivo', archivo);
        formData.append('mundial', obtenerMundialDeURL());

        // Deshabilitar botón de envío
        const btnSubmit = document.querySelector('#createPostForm button[type="submit"]');
        const originalBtnText = btnSubmit.innerHTML;
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Publicando...';

        // AQUÍ LLAMADA AJAX PARA CREAR PUBLICACIÓN
        // crearPublicacionAjax(formData)
        
        setTimeout(() => {
            // Cerrar modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('createPostModal'));
            modal.hide();
            
            // Limpiar formulario
            document.getElementById('createPostForm').reset();
            
            // Restaurar botón
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = originalBtnText;
            
            // Mensaje de éxito
            mostrarMensaje('¡Publicación creada! Será visible después de ser aprobada por un administrador.', 'success', 5000);
        }, 2000);
    }

    function validarFormulario(titulo, descripcion, categoria, archivo) {
        // Validar título
        if (titulo.length < 5 || titulo.length > 200) {
            mostrarMensaje('El título debe tener entre 5 y 200 caracteres', 'warning');
            return false;
        }

        // Validar descripción
        if (descripcion.length < 10 || descripcion.length > 1000) {
            mostrarMensaje('La descripción debe tener entre 10 y 1000 caracteres', 'warning');
            return false;
        }

        // Validar categoría
        if (!categoria) {
            mostrarMensaje('Debes seleccionar una categoría', 'warning');
            return false;
        }

        // Validar archivo
        if (!archivo) {
            mostrarMensaje('Debes seleccionar una imagen o video', 'warning');
            return false;
        }

        // Validar tipo de archivo
        const tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'video/mp4', 'video/quicktime'];
        if (!tiposPermitidos.includes(archivo.type)) {
            mostrarMensaje('Solo se permiten imágenes (JPG, PNG, GIF) o videos (MP4, MOV)', 'warning');
            return false;
        }

        // Validar tamaño (10MB)
        const maxSize = 10 * 1024 * 1024; // 10MB en bytes
        if (archivo.size > maxSize) {
            mostrarMensaje('El archivo no puede superar los 10MB', 'warning');
            return false;
        }

        return true;
    }

    function validarArchivo(input) {
        const archivo = input.files[0];
        if (!archivo) return;

        const tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'video/mp4', 'video/quicktime'];
        const maxSize = 10 * 1024 * 1024;

        if (!tiposPermitidos.includes(archivo.type)) {
            input.value = '';
            mostrarMensaje('Tipo de archivo no permitido', 'warning');
            return false;
        }

        if (archivo.size > maxSize) {
            input.value = '';
            mostrarMensaje('El archivo excede los 10MB', 'warning');
            return false;
        }

        // Mostrar preview si es imagen
        if (archivo.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Aquí podrías mostrar un preview de la imagen
                console.log('Imagen cargada correctamente');
            };
            reader.readAsDataURL(archivo);
        }

        return true;
    }

    function validarCampo(campo, condicion, mensaje) {
        if (condicion) {
            campo.classList.remove('is-invalid');
            campo.classList.add('is-valid');
            return true;
        } else {
            campo.classList.remove('is-valid');
            campo.classList.add('is-invalid');
            return false;
        }
    }

    // ==================== UTILIDADES ====================
    function validarSesion() {
        // AQUÍ SE VALIDARÍA LA SESIÓN REAL
        // Por ahora simulamos que NO está logueado
        return false; // Cambiar a true para simular usuario logueado
    }

    function obtenerMundialDeURL() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('mundial') || 'qatar2022';
    }

    function formatearNumero(num) {
        if (num >= 1000) {
            return (num / 1000).toFixed(1) + 'K';
        }
        return num.toString();
    }

    function mostrarMensaje(mensaje, tipo = 'info', duracion = 3000) {
        // Crear elemento de mensaje
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${tipo} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = 'top: 100px; right: 20px; z-index: 9999; min-width: 300px; animation: slideInRight 0.5s ease;';
        alertDiv.innerHTML = `
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Auto-cerrar después de la duración
        setTimeout(() => {
            alertDiv.style.animation = 'slideOutRight 0.5s ease';
            setTimeout(() => {
                alertDiv.remove();
            }, 500);
        }, duracion);
    }

    // ==================== ANIMACIONES CSS ====================
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
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
    `;
    document.head.appendChild(style);

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

    console.log('🚀 Muro de publicaciones inicializado correctamente');
});

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