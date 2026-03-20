/**
 * Slider Vanilla JS para la sección "Novedades del Catálogo".
 * NO usa librerías externas — solo translateX + CSS Grid.
 *
 * Funcionamiento:
 * 1. Calcula cuántos items caben visibles según el ancho de la ventana.
 * 2. Al pulsar Prev/Next, desplaza la pista N items con translateX.
 * 3. Se recalcula en resize para ser responsive.
 *
 * @sideeffects Modifica el DOM: aplica transform a .sliderPista
 */
document.addEventListener('DOMContentLoaded', () => {
    // === ELEMENTOS DEL DOM ===
    // Buscamos la ventana visible del slider
    const ventana = document.querySelector('.sliderVentana');
    // Buscamos la pista que contiene todos los items
    const pista = document.querySelector('.sliderPista');
    // Botón para ir al grupo anterior
    const btnPrev = document.querySelector('.sliderBtnPrev');
    // Botón para ir al grupo siguiente
    const btnNext = document.querySelector('.sliderBtnNext');

    // Si no existe el slider en esta página, salimos sin hacer nada
    if (!ventana || !pista || !btnPrev || !btnNext) {
        return;
    }

    // Todos los items (cards de libros) dentro de la pista
    const items = pista.querySelectorAll('.sliderItem');

    // Si no hay items, no tiene sentido continuar
    if (items.length === 0) {
        return;
    }

    // === ESTADO DEL SLIDER ===
    // Índice del primer item visible actualmente (empieza en 0)
    let indiceActual = 0;

    /**
     * Calcula cuántos items caben en la ventana visible.
     * Usa el ancho real de un item + el gap entre ellos.
     * @return {number} Cantidad de items visibles (mínimo 1)
     */
    const calcularVisibles = () => {
        // Ancho de la ventana visible (columna central del grid)
        const anchoVentana = ventana.offsetWidth;
        // Ancho real de un item (incluye padding/border si los tiene)
        const anchoItem = items[0].offsetWidth;
        // Gap entre items — lo leemos del CSS computado de la pista
        const estilosPista = window.getComputedStyle(pista);
        const gap = parseFloat(estilosPista.gap) || 20;
        // Calculamos cuántos caben: dividimos el espacio disponible
        const caben = Math.floor((anchoVentana + gap) / (anchoItem + gap));
        // Mínimo 1 para evitar división por cero
        return Math.max(1, caben);
    };

    /**
     * Mueve la pista al índice indicado con una animación translateX.
     * También activa/desactiva los botones si estamos en los extremos.
     * @param {number} nuevoIndice - Índice del primer item visible
     * @sideeffects Modifica transform de .sliderPista, disabled de botones
     */
    const moverA = (nuevoIndice) => {
        const visibles = calcularVisibles();
        // Límite máximo: no podemos pasar del último grupo de items
        const maximo = Math.max(0, items.length - visibles);
        // Clamp: mantener el índice dentro de los límites [0, máximo]
        indiceActual = Math.min(Math.max(0, nuevoIndice), maximo);

        // Calculamos el desplazamiento en píxeles
        const anchoItem = items[0].offsetWidth;
        const estilosPista = window.getComputedStyle(pista);
        const gap = parseFloat(estilosPista.gap) || 20;
        // Cada item ocupa anchoItem + gap de desplazamiento
        const desplazamiento = indiceActual * (anchoItem + gap);

        // Aplicamos el desplazamiento con translateX (animado por CSS transition)
        pista.style.transform = `translateX(-${desplazamiento}px)`;

        // Desactivar botón si estamos en un extremo (feedback visual)
        btnPrev.disabled = (indiceActual === 0);
        btnNext.disabled = (indiceActual >= maximo);
    };

    // === EVENT LISTENERS ===
    // Al hacer click en "Anterior": retroceder 1 item
    btnPrev.addEventListener('click', () => {
        moverA(indiceActual - 1);
    });

    // Al hacer click en "Siguiente": avanzar 1 item
    btnNext.addEventListener('click', () => {
        moverA(indiceActual + 1);
    });

    // Al cambiar el tamaño de la ventana: recalcular posición
    // Usamos un pequeño debounce para no ejecutar en cada pixel
    let timerResize = null;
    window.addEventListener('resize', () => {
        clearTimeout(timerResize);
        timerResize = setTimeout(() => {
            moverA(indiceActual);
        }, 150);
    });

    // === INICIALIZACIÓN ===
    // Posicionar en el primer item y configurar estado de botones
    moverA(0);
});