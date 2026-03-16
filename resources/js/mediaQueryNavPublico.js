/**
 * Control del menú desplegable para dispositivos móviles y tablets.
 * @description Escucha el click en el botón de hamburguesa y alterna la clase de visibilidad.
 */
const toggleMenu = () => {
    const btnMenu = document.getElementById('btnMenu');
    const navLista = document.getElementById('navLista');

    // Verificamos que ambos elementos existan en el DOM para evitar errores
    if (btnMenu && navLista) {
        btnMenu.addEventListener('click', () => {
            // Alternamos la clase CSS que controla el display
            navLista.classList.toggle('navListaVisible');

            // Mejora de accesibilidad: actualizamos el estado del atributo aria
            const esVisible = navLista.classList.contains('navListaVisible');
            btnMenu.setAttribute('aria-expanded', esVisible);
        });
    }
};
const setupAdminPrincipalMenu = () => {
    const btnMenuPrincipal = document.getElementById('btnMenuPrincipal');
    const navAdmin = document.querySelector('.navAdmin');

    if (!btnMenuPrincipal || !navAdmin) {
        return;
    }

    btnMenuPrincipal.addEventListener('click', (e) => {
        // Evitamos que el click del botón principal dispare el cierre global por click fuera.
        e.stopPropagation();

        const visible = navAdmin.classList.toggle('navAdminVisible');
        btnMenuPrincipal.setAttribute('aria-expanded', visible ? 'true' : 'false');

        // Si cerramos el contenedor principal, también reseteamos submenús y estados aria.
        if (!visible) {
            navAdmin.querySelectorAll('.menu-items').forEach(menu => menu.classList.remove('is-active'));
            navAdmin.querySelectorAll('.btnDesplegableAdmin button').forEach(boton => {
                boton.setAttribute('aria-expanded', 'false');
            });
        }
    });
};


const setupAdminMenus = () => {
    // Seleccionamos los botones que disparan cada submenú de administración.
    const btnsDesplegables = document.querySelectorAll('.btnDesplegableAdmin button');

    btnsDesplegables.forEach(boton => {
        boton.addEventListener('click', () => {
            const contenedorBoton = boton.closest('.btnDesplegableAdmin');
            const menu = contenedorBoton ? contenedorBoton.nextElementSibling : null;

            // Cada botón actúa de forma independiente sobre su ul.menu-items inmediato.
            if (menu && menu.classList.contains('menu-items')) {
                const expandido = menu.classList.toggle('is-active');
                boton.setAttribute('aria-expanded', expandido ? 'true' : 'false');
            }
        });
    });

    // Cierre global al hacer click fuera de .navAdmin.
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.navAdmin') && !e.target.closest('#btnMenuPrincipal')) {
            const navAdmin = document.querySelector('.navAdmin');

            if (navAdmin) {
                navAdmin.classList.remove('navAdminVisible');
                navAdmin.querySelectorAll('.menu-items').forEach(menu => menu.classList.remove('is-active'));
                navAdmin.querySelectorAll('.btnDesplegableAdmin button').forEach(boton => {
                    boton.setAttribute('aria-expanded', 'false');
                });
            }

            const btnMenuPrincipal = document.getElementById('btnMenuPrincipal');
            if (btnMenuPrincipal) {
                btnMenuPrincipal.setAttribute('aria-expanded', 'false');
            }
        }
    });
};

// Inicializamos las funciones al cargar el DOM
document.addEventListener('DOMContentLoaded', toggleMenu);
document.addEventListener('DOMContentLoaded', setupAdminPrincipalMenu);
document.addEventListener('DOMContentLoaded', setupAdminMenus);