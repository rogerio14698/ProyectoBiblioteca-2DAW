/**
 * interfaz.js
 * Comportamiento común de la interfaz pública y del panel:
 * - Menú móvil de la cabecera y estado "desplazada".
 * - Desplegable de la cuenta del socio.
 * - Lateral del panel de administración en móvil.
 * - Revelado de secciones al hacer scroll.
 * - Carruseles con scroll-snap y botones anterior/siguiente.
 */

const iniciar = () => {
    document.documentElement.classList.remove('no-js');

    iniciarCabecera();
    iniciarCuenta();
    iniciarLateralAdmin();
    iniciarRevelado();
    document.querySelectorAll('[data-carrusel]').forEach(iniciarCarrusel);
};

function iniciarCabecera() {
    const cabecera = document.querySelector('.cabecera');
    if (!cabecera) return;

    const actualizar = () => {
        cabecera.dataset.desplazada = window.scrollY > 8 ? 'true' : 'false';
    };
    actualizar();
    window.addEventListener('scroll', actualizar, { passive: true });

    const boton = cabecera.querySelector('.cabecera__menu');
    const panel = document.getElementById(boton?.getAttribute('aria-controls') || '');
    if (!boton || !panel) return;

    const fijar = (abierto) => {
        boton.setAttribute('aria-expanded', String(abierto));
        panel.dataset.abierta = String(abierto);
        document.body.dataset.menuAbierto = String(abierto);
    };

    boton.addEventListener('click', () => fijar(boton.getAttribute('aria-expanded') !== 'true'));

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && boton.getAttribute('aria-expanded') === 'true') {
            fijar(false);
            boton.focus();
        }
    });

    window.matchMedia('(min-width: 900px)').addEventListener('change', (mq) => {
        if (mq.matches) fijar(false);
    });
}

function iniciarCuenta() {
    document.querySelectorAll('.cuenta').forEach((cuenta) => {
        const boton = cuenta.querySelector('.cuenta__boton');
        const menu = cuenta.querySelector('.cuenta__menu');
        if (!boton || !menu) return;

        const fijar = (abierto) => {
            boton.setAttribute('aria-expanded', String(abierto));
            menu.hidden = !abierto;
        };

        boton.addEventListener('click', (e) => {
            e.stopPropagation();
            fijar(menu.hidden);
        });

        document.addEventListener('click', (e) => {
            if (!cuenta.contains(e.target)) fijar(false);
        });

        cuenta.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !menu.hidden) {
                fijar(false);
                boton.focus();
            }
        });
    });
}

function iniciarLateralAdmin() {
    const boton = document.querySelector('.a-superior__menu');
    const lateral = document.getElementById('aLateral');
    const velo = document.querySelector('.a-velo');
    if (!boton || !lateral) return;

    const fijar = (abierto) => {
        boton.setAttribute('aria-expanded', String(abierto));
        lateral.dataset.abierto = String(abierto);
        if (velo) velo.dataset.visible = String(abierto);
    };

    boton.addEventListener('click', () => fijar(lateral.dataset.abierto !== 'true'));
    velo?.addEventListener('click', () => fijar(false));
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && lateral.dataset.abierto === 'true') {
            fijar(false);
            boton.focus();
        }
    });
}

function iniciarRevelado() {
    const elementos = document.querySelectorAll('[data-revelar]');
    if (!elementos.length) return;

    if (!('IntersectionObserver' in window)) {
        elementos.forEach((el) => el.classList.add('es-visible'));
        return;
    }

    const observador = new IntersectionObserver(
        (entradas) => {
            entradas.forEach((entrada) => {
                if (entrada.isIntersecting) {
                    entrada.target.classList.add('es-visible');
                    observador.unobserve(entrada.target);
                }
            });
        },
        { rootMargin: '0px 0px -10% 0px', threshold: 0.1 },
    );

    elementos.forEach((el) => observador.observe(el));
}

function iniciarCarrusel(carrusel) {
    const pista = carrusel.querySelector('.carrusel__pista');
    const anterior = carrusel.querySelector('[data-carrusel-anterior]');
    const siguiente = carrusel.querySelector('[data-carrusel-siguiente]');
    const contador = carrusel.querySelector('.carrusel__contador');
    if (!pista) return;

    const items = () => Array.from(pista.children);

    const paso = () => {
        const primero = pista.firstElementChild;
        if (!primero) return pista.clientWidth;
        const hueco = parseFloat(getComputedStyle(pista).columnGap) || 0;
        return primero.getBoundingClientRect().width + hueco;
    };

    const actualizar = () => {
        const max = pista.scrollWidth - pista.clientWidth - 2;
        if (anterior) anterior.disabled = pista.scrollLeft <= 2;
        if (siguiente) siguiente.disabled = pista.scrollLeft >= max;
        if (contador) {
            const indice = Math.min(items().length, Math.round(pista.scrollLeft / paso()) + 1);
            contador.textContent = `${String(indice).padStart(2, '0')} / ${String(items().length).padStart(2, '0')}`;
        }
    };

    anterior?.addEventListener('click', () => pista.scrollBy({ left: -paso(), behavior: 'smooth' }));
    siguiente?.addEventListener('click', () => pista.scrollBy({ left: paso(), behavior: 'smooth' }));

    let pendiente = false;
    pista.addEventListener(
        'scroll',
        () => {
            if (pendiente) return;
            pendiente = true;
            requestAnimationFrame(() => {
                actualizar();
                pendiente = false;
            });
        },
        { passive: true },
    );
    window.addEventListener('resize', actualizar);
    actualizar();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', iniciar);
} else {
    iniciar();
}
