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

// Ejecutamos la función una vez el DOM esté cargado
document.addEventListener('DOMContentLoaded', toggleMenu);