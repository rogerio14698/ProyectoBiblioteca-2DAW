// Desplegables del menu del usuario;
document.addEventListener('DOMContentLoaded', () => {
    // Desplegable de configuración del usuario.
    const btnConfigUsuario = document.getElementById('btnConfigUsuario');
    const menuConfigUsuario = document.querySelector('.configCuentaUsuario');

    if (btnConfigUsuario && menuConfigUsuario) {
        btnConfigUsuario.addEventListener('click', (e) => {
            e.stopPropagation();

            //La clase la ponemos al menu no al btn.
            const visibleConfig = menuConfigUsuario.classList.toggle('configVisible');
            btnConfigUsuario.setAttribute('aria-expanded', visibleConfig ? 'true' : 'false');
        });
    }
    // Cierre global al hacer click fuera del menu de configuración del usuario.
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.configCuentaUsuario') && !e.target.closest('#btnConfigUsuario')) {
            const menuConfigUsuario = document.querySelector('.configCuentaUsuario');

            if (menuConfigUsuario ) {
                menuConfigUsuario.classList.remove('configVisible');
                const btnConfigUsuario = document.getElementById('btnConfigUsuario');
                if (btnConfigUsuario) {
                    btnConfigUsuario.setAttribute('aria-expanded', 'false');
                }
            }
        }
    });

});