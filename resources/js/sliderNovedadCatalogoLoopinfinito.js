document.addEventListener('DOMContentLoaded', () => {
    // Obtenemos el track que se mueve horizontalmente.
    const slider = document.getElementById('sliderContenido');

    // Obtenemos la ventana visible del slider (el contenedor con overflow oculto).
    const sliderWindow = document.querySelector('.sliderWindow');

    // Si el slider no existe en esta página, no ejecutamos nada para evitar errores.
    if (!slider || !sliderWindow) {
        return;
    }

    // Guardamos una copia estática de las tarjetas originales antes de clonar.
    // Esto es importante porque después agregaremos clones al DOM.
    const cards = Array.from(slider.querySelectorAll('.novedadCatalogoCard'));
    const totalOriginalCards = cards.length;

    // Si no hay tarjetas, no hay nada que animar.
    if (totalOriginalCards === 0) {
        return;
    }

    // Empezamos posicionados en el bloque central (tarjetas originales).
    // Estructura resultante: [clones-izq] [originales] [clones-der].
    let currentIndex = totalOriginalCards;

    // Bloquea la interacción durante la transición para evitar saltos visuales.
    let isTransitioning = false;

    // Referencia del intervalo de autoplay para poder pausar/reanudar sin duplicar timers.
    let autoPlay = null;

    // Clonamos todas las tarjetas originales al inicio y al final.
    // Esto permite "saltar" internamente sin que el usuario note el corte.
    cards.forEach((card) => {
        const cloneAtEnd = card.cloneNode(true);
        const cloneAtStart = card.cloneNode(true);

        slider.appendChild(cloneAtEnd);
        slider.insertBefore(cloneAtStart, slider.firstChild);
    });

    /**
     * Calcula el ancho de desplazamiento por paso.
     * Paso = ancho de tarjeta + gap CSS del track.
     * @returns {number}
     */
    const getCardWidth = () => {
        const firstCard = slider.querySelector('.novedadCatalogoCard');

        if (!firstCard) {
            return 0;
        }

        const sliderStyles = window.getComputedStyle(slider);
        const gap = parseFloat(sliderStyles.columnGap || sliderStyles.gap || '0');

        return firstCard.offsetWidth + gap;
    };

    /**
     * Aplica la posición actual del carrusel.
     * @returns {void}
     */
    const updatePosition = () => {
        const cardWidth = getCardWidth();

        if (cardWidth <= 0) {
            return;
        }

        slider.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
    };

    // Posicionamiento inicial sin animación para evitar parpadeo al cargar.
    slider.style.transition = 'none';
    updatePosition();

    /**
     * Mueve el carrusel una posición en la dirección indicada.
     * @param {number} direction 1 para avanzar, -1 para retroceder.
     * @returns {void}
     */
    const moveSlider = (direction) => {
        // Evitamos disparos durante la transición actual.
        if (isTransitioning) {
            return;
        }

        isTransitioning = true;
        slider.style.transition = 'transform 0.5s ease-in-out';
        currentIndex += direction;
        updatePosition();
    };

    // Al terminar cada animación verificamos si entramos a la zona de clones.
    // Si ocurre, saltamos sin transición al bloque original equivalente.
    slider.addEventListener('transitionend', () => {
        isTransitioning = false;

        // Límite derecho de clones: [0 ... totalOriginalCards*3 - 1]
        // El bloque original empieza en index totalOriginalCards.
        if (currentIndex >= totalOriginalCards * 2) {
            slider.style.transition = 'none';
            currentIndex = totalOriginalCards;
            updatePosition();
        }

        // Límite izquierdo de clones.
        if (currentIndex <= 0) {
            slider.style.transition = 'none';
            currentIndex = totalOriginalCards;
            updatePosition();
        }
    });

    /**
     * Inicia o reinicia el autoplay.
     * @returns {void}
     */
    const startAutoPlay = () => {
        if (autoPlay) {
            clearInterval(autoPlay);
        }

        autoPlay = setInterval(() => moveSlider(1), 3000);
    };

    /**
     * Detiene el autoplay si está activo.
     * @returns {void}
     */
    const stopAutoPlay = () => {
        if (!autoPlay) {
            return;
        }

        clearInterval(autoPlay);
        autoPlay = null;
    };

    // Inicializamos reproducción automática.
    startAutoPlay();

    // Pausamos en hover para mejorar lectura/interacción del usuario.
    sliderWindow.addEventListener('mouseenter', stopAutoPlay);
    sliderWindow.addEventListener('mouseleave', startAutoPlay);

    // Reajustamos el desplazamiento al cambiar el tamaño de pantalla.
    window.addEventListener('resize', updatePosition);

    // Exponemos la función en el objeto global para compatibilidad con onclick del Blade.
    window.moveSlider = moveSlider;
});