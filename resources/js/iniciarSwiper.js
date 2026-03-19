
/**
 * Inicialización del carrusel Swiper para la sección "Novedades del Catálogo".
 * Se usa la librería Swiper cargada desde CDN (global window.Swiper).
 * Configuración responsive con breakpoints para móvil, tablet y escritorio.
 */
document.addEventListener('DOMContentLoaded', () => {
    // Debug temporal (ELIMINAR después de resolver)
    const dbg = window._dbg || function() {};
    dbg('4. DOMContentLoaded OK');

    // Verificamos que la librería Swiper se haya cargado
    if (typeof Swiper === 'undefined') {
        dbg('ERROR: Swiper no definido');
        console.warn('Swiper no está disponible. Verifica que se cargó correctamente.');
        return;
    }
    dbg('5. Swiper class: OK');

    // Buscamos el contenedor del carrusel de novedades
    const swiperElement = document.querySelector('.novedadesSwiper');

    if (!swiperElement) {
        return;
    }

    // Contamos cuántos slides hay para decidir si activar el modo loop
    const totalSlides = swiperElement.querySelectorAll('.swiper-slide').length;
    dbg('6. Slides encontrados: ' + totalSlides);

    if (totalSlides === 0) {
        dbg('WARN: 0 slides, abortando');
        return;
    }

    // Inicializamos Swiper con configuración segura para iOS Safari
    try {
        const sw = new Swiper('.novedadesSwiper', {
            direction: 'horizontal',
            // Desactivar loop para evitar clonación de slides (causa crashes en iOS)
            loop: false,
            watchOverflow: true,
            slidesPerView: 1,
            spaceBetween: 16,
            // Evita conflictos entre touch del swiper y click de botones en iOS
            touchStartPreventDefault: false,
            // Deshabilitar precarga de imágenes para reducir memoria en móvil
            preloadImages: false,
            // Los botones de navegación personalizados
            navigation: {
            nextEl: '.swiper-button-next-custom',
            prevEl: '.swiper-button-prev-custom',
        },
        breakpoints: {
            360: {
                slidesPerView: 1,
                spaceBetween: 16,
            },
            480: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 24,
            },
            800: {
                slidesPerView: 3,
                spaceBetween: 24,
            },
            1000: {
                slidesPerView: 4,
                spaceBetween: 20,
            },
            1200: {
                slidesPerView: 5,
                spaceBetween: 20,
            },
        }
    });
    dbg('7. Swiper inicializado OK');
    } catch (err) {
        dbg('ERROR Swiper: ' + err.message);
    }
});