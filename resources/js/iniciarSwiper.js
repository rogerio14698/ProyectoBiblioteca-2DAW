/**
 * Inicialización del carrusel Swiper para la sección "Novedades del Catálogo".
 * Se usa la librería Swiper cargada localmente (global window.Swiper).
 * Los botones de navegación están DENTRO del contenedor .swiper para
 * garantizar compatibilidad táctil con iOS Safari.
 * Configuración responsive con breakpoints para móvil, tablet y escritorio.
 */
document.addEventListener('DOMContentLoaded', () => {
    // Verificamos que la librería Swiper se haya cargado
    if (typeof Swiper === 'undefined') {
        console.warn('Swiper no está disponible. Verifica que se cargó correctamente.');
        return;
    }

    // Buscamos el contenedor del carrusel de novedades
    const swiperElement = document.querySelector('.novedadesSwiper');

    if (!swiperElement) {
        return;
    }

    // Contamos cuántos slides hay para decidir si activar el modo loop
    const totalSlides = swiperElement.querySelectorAll('.swiper-slide').length;

    if (totalSlides === 0) {
        return;
    }

    // Inicializamos Swiper con configuración segura para iOS Safari
    new Swiper('.novedadesSwiper', {
        direction: 'horizontal',
        // Loop desactivado: evita clonación de slides que causa crashes en iOS
        loop: false,
        watchOverflow: true,
        slidesPerView: 1,
        spaceBetween: 16,
        // Evita conflictos entre touch del swiper y click de botones en iOS
        touchStartPreventDefault: false,
        // Los botones de navegación personalizados (dentro del .swiper)
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
});