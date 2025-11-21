/**
 * VISTA_PUBLICACION.JS
 * Sistema de registro automático de vistas de publicaciones mediante AJAX
 *
 * Características:
 * - Detecta cuando una publicación entra en el viewport (50%+ visible)
 * - Registra la vista automáticamente mediante AJAX
 * - Evita registros duplicados
 * - Actualiza el contador de vistas en la UI
 * 
 * Requisitos:
 * - Usuario debe estar autenticado (verifica en backend)
 */

(function() {
    'use strict';

    // ==================== CONFIGURACIÓN ====================
    const CONFIG = {
        apiEndpoint: '../backend/api/vistaPublicacion.php',
        visibilityThreshold: 0.5, // 50% de la publicación debe estar visible
        enableDebug: true, // Cambiar a false en producción
        autoUpdateCounter: true // Actualizar contador de vistas automáticamente
    };

    // Set para almacenar IDs de publicaciones ya vistas
    const publicacionesVistas = new Set();

    // ==================== FUNCIONES AUXILIARES ===================
    
    /** 
     * Log en consola (solo si debug está activado)
     */
    function log(mensaje, tipo = 'info', datos = null) {
        if (!CONFIG.enableDebug) return;
        
        const emoji = {
            'info': 'ℹ️',
            'success': '✅',
            'warning': '⚠️',
            'error': '❌',
            'vista': '👁️'
        };
        
        console.log(`${emoji[tipo] || '📌'} [VistasPublicacion] ${mensaje}`, datos || '');
    }

    /**
     * Verificar si el usuario está autenticado (simple check del DOM)
     */
    function verificarAutenticacion() {
        // Si existe el botón de crear publicación (solo para usuarios autenticados)
        const btnCrear = document.querySelector('.btn-create-post[type="button"]');
        return btnCrear !== null;
    }

    /**
     * Registrar vista de publicación mediante AJAX
     */
    async function registrarVista(idPublicacion) {
        // Validar ID
        if (!idPublicacion || idPublicacion <= 0) {
            log('ID de publicación inválido', 'error', idPublicacion);
            return false;
        }

        // Verificar si ya se registró esta vista
        if (publicacionesVistas.has(idPublicacion)) {
            log(`Publicación ${idPublicacion} ya fue vista anteriormente`, 'info');
            return false;
        }

        try {
            log(`Registrando vista para publicación ${idPublicacion}...`, 'vista');

            // Enviar petición AJAX
            const response = await fetch(CONFIG.apiEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    accion: 'registrar',
                    id_publicacion: idPublicacion
                })
            });

            // Verificar si la respuesta es OK
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }

            // Parsear respuesta JSON
            const data = await response.json();

            // Procesar respuesta
            if (data.exitoso) {
                log(`Vista registrada exitosamente: ${data.mensaje}`, 'success', data);
                
                // Marcar como vista
                publicacionesVistas.add(idPublicacion);
                
                // Actualizar UI si está habilitado
                if (CONFIG.autoUpdateCounter) {
                    actualizarContadorVistas(idPublicacion);
                }
                
                return true;
            } else {
                log(`No se pudo registrar vista: ${data.mensaje}`, 'warning', data);
                return false;
            }

        } catch (error) {
            log(`Error al registrar vista: ${error.message}`, 'error', error);
            return false;
        }
    }

    /**
     * Actualizar el contador de vistas en la UI (opcional)
     */
    function actualizarContadorVistas(idPublicacion) {
        // Buscar el contador de vistas de esta publicación
        const contador = document.querySelector(`.views-count[data-publicacion-id="${idPublicacion}"]`);
        
        if (contador) {
            // Incrementar el número mostrado
            const valorActual = parseInt(contador.textContent) || 0;
            const nuevoValor = valorActual + 1;
            
            contador.textContent = nuevoValor;
            
            // Animación visual (opcional)
            contador.style.transition = 'all 0.3s ease';
            contador.style.transform = 'scale(1.2)';
            contador.style.color = '#6101eb';
            
            setTimeout(() => {
                contador.style.transform = 'scale(1)';
                contador.style.color = '';
            }, 300);
            
            log(`Contador actualizado: ${valorActual} → ${nuevoValor}`, 'success');
        }
    }

    /**
     * Marcar visualmente una publicación como vista (opcional)
     */
    function marcarPublicacionVista(elemento) {
        elemento.setAttribute('data-vista-registrada', 'true');
        
        // Agregar clase CSS si existe (opcional)
        if (elemento.classList) {
            elemento.classList.add('publicacion-vista');
        }
    }

    /**
     * Callback cuando una publicación entra/sale del viewport
     */
    function handleIntersection(entries, observer) {
        entries.forEach(entry => {
            // Solo procesar si la publicación está entrando en el viewport
            if (!entry.isIntersecting) return;

            const publicacion = entry.target;
            const idPublicacion = parseInt(publicacion.getAttribute('data-id-publicacion'));

            // Validar ID
            if (!idPublicacion || idPublicacion <= 0) {
                log('Publicación sin ID válido', 'warning', publicacion);
                return;
            }

            // Verificar si ya se procesó
            if (publicacionesVistas.has(idPublicacion)) {
                log(`Publicación ${idPublicacion} ya fue procesada`, 'info');
                return;
            }

            log(`Publicación ${idPublicacion} entró en viewport`, 'vista');

            // Registrar vista
            registrarVista(idPublicacion).then(registrado => {
                if (registrado) {
                    // Marcar visualmente (opcional)
                    marcarPublicacionVista(publicacion);
                    
                    // Dejar de observar esta publicación (ya fue vista)
                    observer.unobserve(publicacion);
                }
            });
        });
    }

    /**
     * Inicializar el sistema de detección de vistas
     */
    function inicializarSistemaVistas() {
        log('Inicializando sistema de vistas...', 'info');

        // Verificar autenticación
        if (!verificarAutenticacion()) {
            log('Usuario no autenticado - Sistema de vistas desactivado', 'warning');
            return;
        }

        // Buscar todas las publicaciones
        const publicaciones = document.querySelectorAll('.post-muro[data-id-publicacion]');
        
        if (publicaciones.length === 0) {
            log('No se encontraron publicaciones para monitorear', 'warning');
            return;
        }

        log(`Encontradas ${publicaciones.length} publicaciones para monitorear`, 'success');

        // Configurar Intersection Observer
        const observerOptions = {
            root: null, // Usar viewport como root
            rootMargin: '0px',
            threshold: CONFIG.visibilityThreshold // 50% visible para contar como vista
        };

        // Crear observer
        const observer = new IntersectionObserver(handleIntersection, observerOptions);

        // Observar cada publicación
        publicaciones.forEach((publicacion, index) => {
            const idPublicacion = publicacion.getAttribute('data-id-publicacion');
            
            if (idPublicacion) {
                observer.observe(publicacion);
                log(`Observando publicación ${index + 1}/${publicaciones.length} (ID: ${idPublicacion})`, 'info');
            } else {
                log(`Publicación sin ID en índice ${index}`, 'warning', publicacion);
            }
        });

        log('✅ Sistema de vistas inicializado correctamente', 'success');
    }

    // ==================== INICIALIZACIÓN ====================
    
    /**
     * Iniciar cuando el DOM esté listo
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', inicializarSistemaVistas);
    } else {
        // El DOM ya está listo
        inicializarSistemaVistas();
    }

    // ==================== API PÚBLICA (opcional) ====================
    
    /**
     * Exponer funciones útiles globalmente (solo para debugging)
     */
    window.SistemaVistas = {
        // Obtener publicaciones vistas
        getPublicacionesVistas: () => Array.from(publicacionesVistas),
        
        // Forzar registro manual de vista (para testing)
        registrarManual: (idPublicacion) => registrarVista(idPublicacion),
        
        // Ver configuración actual
        getConfig: () => CONFIG,
        
        // Versión del script
        version: '1.0.0'
    };

    log('📦 Sistema de vistas cargado (v1.0.0)', 'success');

})();

// ==================== ESTILOS OPCIONALES ====================
/**
 * Agregar estilos inline para animaciones (opcional)
 * Puedes mover esto a tu archivo CSS si prefieres
 */
const estilosVistas = document.createElement('style');
estilosVistas.textContent = `
    /* Animación sutil cuando se registra una vista */
    .publicacion-vista {
        position: relative;
    }
    
    .publicacion-vista::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 3px;
        height: 100%;
        background: linear-gradient(180deg, #6101eb 0%, transparent 100%);
        opacity: 0.3;
        pointer-events: none;
    }
    
    /* Animación del contador de vistas */
    .views-count {
        display: inline-block;
        font-weight: 500;
    }
    
    /* Estado hover del contador */
    .action-info:hover .views-count {
        color: #6101eb;
    }
`;
document.head.appendChild(estilosVistas);