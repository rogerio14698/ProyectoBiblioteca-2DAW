document.addEventListener('DOMContentLoaded', () => {
    // Buscamos el contenedor interno que se desplaza horizontalmente.
    // Se soportan dos IDs para compatibilidad con versiones antiguas del HTML.
    const slider = document.getElementById('sliderContenido');

    // Buscamos la "ventana" visible del slider (la zona con overflow oculto).
    // También aceptamos dos nombres de clase por el mismo motivo de compatibilidad.
    const sliderWindow = document.querySelector('.sliderWindow');

    // Si no existe la estructura mínima, detenemos la ejecución sin lanzar errores.
    // Esto evita que falle el JS en páginas donde el slider no está presente.
    if (!slider || !sliderWindow) {
        return;
    }

    // Índice actual de desplazamiento (0 = primera posición visible).
    let currentIndex = 0;

    // Referencia al intervalo del autoplay.
    // Guardamos el ID para poder pausar/reanudar limpiamente.
    let autoPlayInterval = null;

    /**
     * Obtiene todas las tarjetas renderizadas dentro del slider.
     * @returns {NodeListOf<Element>} Lista de elementos .novedadCatalogoCard.
     */
    const getItems = () => slider.querySelectorAll('.novedadCatalogoCard');

    /**
     * Calcula el ancho real de desplazamiento por "paso".
     * Un paso = ancho de la tarjeta + separación (gap) entre tarjetas.
     * @returns {number} Pixels a mover por cada avance/retroceso.
     */
    const getCardWidth = () => {
        // Tomamos la primera tarjeta como referencia de dimensiones.
        const firstCard = slider.querySelector('.novedadCatalogoCard');

        // Si no hay tarjetas, no hay nada que mover.
        if (!firstCard) {
            return 0;
        }

        // Leemos los estilos computados para detectar el gap definido en CSS.
        const sliderStyles = window.getComputedStyle(slider);
        const gap = parseFloat(sliderStyles.columnGap || sliderStyles.gap || '0');

        // offsetWidth incluye padding y border visuales de la tarjeta.
        return firstCard.offsetWidth + gap;
    };

    /**
     * Calcula cuántas tarjetas entran al mismo tiempo en la ventana visible.
     * @param {number} cardWidth Ancho por paso (tarjeta + gap).
     * @returns {number} Cantidad mínima 1 de tarjetas visibles.
     */
    const getVisibleCards = (cardWidth) => {
        // Protección ante cálculos inválidos o división por cero.
        if (cardWidth <= 0) {
            return 1;
        }

        // Math.floor evita contar una tarjeta parcial como completa.
        // Math.max asegura que siempre devolvamos al menos 1.
        return Math.max(1, Math.floor(sliderWindow.offsetWidth / cardWidth));
    };

    /**
     * Mueve el slider una posición en la dirección indicada.
     * @param {number} direction Usa 1 para avanzar, -1 para retroceder y 0 para recalcular posición.
     * @returns {void}
     */
    const moveSlider = (direction) => {
        const totalItems = getItems().length;
        const cardWidth = getCardWidth();

        // Si no hay tarjetas o no se pudo calcular ancho, salimos sin tocar estilos.
        if (totalItems === 0 || cardWidth <= 0) {
            return;
        }

        const visibleCards = getVisibleCards(cardWidth);

        // Índice máximo permitido para no dejar "huecos" al final.
        // Ejemplo: 6 items, 3 visibles => maxIndex = 3.
        const maxIndex = Math.max(totalItems - visibleCards, 0);

        // Aplicamos la dirección solicitada por botón/autoplay.
        currentIndex += direction;

        // Comportamiento circular (infinito):
        // - Si retrocedemos desde 0, saltamos al último índice válido.
        // - Si avanzamos más allá del último, volvemos al inicio.
        if (currentIndex < 0) {
            currentIndex = maxIndex;
        } else if (currentIndex > maxIndex) {
            currentIndex = 0;
        }

        // Desplazamos el carrusel mediante transform para rendimiento fluido.
        slider.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
    };

    /**
     * Inicia o reinicia el autoplay del slider.
     * @returns {void}
     */
    const startAutoplay = () => {
        // Evitamos intervalos duplicados limpiando el anterior si existe.
        if (autoPlayInterval) {
            clearInterval(autoPlayInterval);
        }

        // Cada 3 segundos avanzamos una posición.
        autoPlayInterval = setInterval(() => moveSlider(1), 3000);
    };

    /**
     * Pausa el autoplay si está activo.
     * @returns {void}
     */
    const stopAutoplay = () => {
        // Si ya estaba detenido, no hacemos nada.
        if (!autoPlayInterval) {
            return;
        }

        clearInterval(autoPlayInterval);
        autoPlayInterval = null;
    };

    // Inicializamos autoplay al cargar la página.
    startAutoplay();

    // Mejor experiencia de usuario:
    // Pausamos al poner el mouse encima y reanudamos al salir.
    sliderWindow.addEventListener('mouseenter', stopAutoplay);
    sliderWindow.addEventListener('mouseleave', startAutoplay);

    // Cuando cambia el tamaño de pantalla, recalculamos desplazamiento.
    // Usamos direction=0 para mantener el índice actual y solo ajustar el cálculo.
    window.addEventListener('resize', () => moveSlider(0));

    // Exponemos la función en el objeto global para que funcionen los onclick del Blade.
    // Esto mantiene compatibilidad con botones como onclick="moveSlider(1)".
    window.moveSlider = moveSlider;
});