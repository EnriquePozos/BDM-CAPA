// Funcionalidades principales para la página de inicio
document.addEventListener('DOMContentLoaded', function() {
    
    // Navbar scroll effect
    const navbar = document.querySelector('.navbar');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.style.background = 'rgba(255, 255, 255, 0.98)';
            navbar.style.boxShadow = '0 2px 40px rgba(0, 0, 0, 0.15)';
        } else {
            navbar.style.background = 'rgba(255, 255, 255, 0.95)';
            navbar.style.boxShadow = '0 1px 30px rgba(0, 0, 0, 0.1)';
        }
    });
    
    
    
    
    // Countdown para el próximo mundial (2026)
    function initCountdown() {
        // Verificar que los elementos existan
        const daysEl = document.getElementById('days');
        const hoursEl = document.getElementById('hours');
        const minutesEl = document.getElementById('minutes');
        const secondsEl = document.getElementById('seconds');
        
        if (!daysEl || !hoursEl || !minutesEl || !secondsEl) {
            console.log('Elementos del countdown no encontrados');
            return;
        }
        
        // Fecha del Mundial 2026 (estimada: Junio 11, 2026)
        const worldCupDate = new Date('June 11, 2026 00:00:00').getTime();
        
        const updateCountdown = () => {
            const now = new Date().getTime();
            const distance = worldCupDate - now;
            
            if (distance > 0) {
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                // Actualizar elementos
                daysEl.textContent = String(days).padStart(3, '0');
                hoursEl.textContent = String(hours).padStart(2, '0');
                minutesEl.textContent = String(minutes).padStart(2, '0');
                secondsEl.textContent = String(seconds).padStart(2, '0');
            } else {
                // Si ya pasó la fecha
                daysEl.textContent = '000';
                hoursEl.textContent = '00';
                minutesEl.textContent = '00';
                secondsEl.textContent = '00';
            }
        };
        
        // Actualizar inmediatamente y luego cada segundo
        updateCountdown();
        const intervalId = setInterval(updateCountdown, 1000);
        
        // Guardar el interval para poder limpiarlo si es necesario
        window.countdownInterval = intervalId;
    }
    
    // Iniciar countdown
    initCountdown();
    
    // Intersection Observer para animaciones
    const observerOptions = {
        threshold: 0.3,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Agregar clase de animación
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observar elementos para animación
    const elementsToAnimate = document.querySelectorAll('.mundial-card, .quick-card, .next-mundial-info');
    elementsToAnimate.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s ease-out';
        observer.observe(el);
    });
    
    // Smooth scroll para enlaces internos
    const smoothScrollLinks = document.querySelectorAll('a[href^="#"]');
    smoothScrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
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
    
    // Efecto hover en cards
    const worldCups = [
        {
            year: '2014',
            country: 'Brasil',
            title: 'FIFA World Cup Brazil',
            description: '32 equipos, 64 partidos, y momentos inolvidables en el país del fútbol.',
            image: 'brasil-2014.jpg',
            color: '#10B981'
        },
        {
            year: '2018',
            country: 'Rusia',
            title: 'FIFA World Cup Russia',
            description: 'Francia campeón en un torneo lleno de emociones y tecnología VAR.',
            image: 'rusia-2018.jpg',
            color: '#EF4444'
        },
        {
            year: '2022',
            country: 'Qatar',
            title: 'FIFA World Cup Qatar',
            description: 'El primer Mundial en invierno y la consagración de Messi.',
            image: 'qatar-2022.jpg',
            color: '#8B5CF6'
        }
    ];
    
    // Aplicar colores dinámicos a las cards
    const mundialCards = document.querySelectorAll('.mundial-card');
    mundialCards.forEach((card, index) => {
        const cardImage = card.querySelector('.card-image');
        const year = card.querySelector('.year');
        
        if (worldCups[index]) {
            // Aplicar gradiente de color específico
            cardImage.style.background = `linear-gradient(135deg, ${worldCups[index].color} 0%, ${worldCups[index].color}CC 100%)`;
            year.style.background = worldCups[index].color;
        }
        
        // Efecto parallax en hover
        card.addEventListener('mousemove', function(e) {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = (y - centerY) / 10;
            const rotateY = (centerX - x) / 10;
            
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-10px)`;
        });
        
        card.addEventListener('mouseleave', function() {
            card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
        });
    });
    
    // Lazy loading para imágenes (si las hay)
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
    
    // Función para mostrar notificaciones
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} notification`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
        `;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Mostrar notificación
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Ocultar después de 5 segundos
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 5000);
    }
    
    // Event listeners para botones
    const exploreButton = document.querySelector('a[href="mundiales.html"]');
    const galleryButton = document.querySelector('a[href="galeria.html"]');
    
    if (exploreButton) {
        exploreButton.addEventListener('click', function(e) {
            // e.preventDefault(); // Descomenta si quieres manejar la navegación con JS
            showNotification('Cargando información de mundiales...', 'info');
        });
    }
    
    if (galleryButton) {
        galleryButton.addEventListener('click', function(e) {
            // e.preventDefault(); // Descomenta si quieres manejar la navegación con JS
            showNotification('Preparando galería multimedia...', 'info');
        });
    }
    
    // Preloader simple
    const showPreloader = () => {
        const preloader = document.createElement('div');
        preloader.className = 'preloader';
        preloader.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.5s ease;
        `;
        
        preloader.innerHTML = `
            <div style="text-align: center; color: white;">
                <i class="fas fa-trophy" style="font-size: 4rem; animation: spin 2s linear infinite;"></i>
                <h3 style="margin-top: 1rem;">Cargando...</h3>
            </div>
        `;
        
        document.body.appendChild(preloader);
        
        // Remover preloader después de 1 segundo
        setTimeout(() => {
            preloader.style.opacity = '0';
            setTimeout(() => {
                if (document.body.contains(preloader)) {
                    document.body.removeChild(preloader);
                }
            }, 500);
        }, 1000);
    };
    
    // Mostrar preloader solo en la primera carga
    if (!sessionStorage.getItem('visited')) {
        showPreloader();
        sessionStorage.setItem('visited', 'true');
    }
    
    console.log('🏆 FIFA Mundiales - Página de inicio cargada correctamente');
});