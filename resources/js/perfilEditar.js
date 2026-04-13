// Funcionalidad de la página de edición de perfil.
// Previsualización de la foto y toggle de la sección de contraseña.
document.addEventListener('DOMContentLoaded', () => {

    // ===== Previsualización de la foto de perfil =====
    const inputFoto = document.getElementById('profile_photo');
    const previewFoto = document.getElementById('previewFoto');

    if (inputFoto && previewFoto) {
        inputFoto.addEventListener('change', (evento) => {
            // Obtenemos el primer archivo seleccionado.
            const archivo = evento.target.files[0];
            if (archivo) {
                // Creamos una URL temporal para mostrar la imagen seleccionada.
                const urlTemporal = URL.createObjectURL(archivo);
                previewFoto.src = urlTemporal;
            }
        });
    }

    // ===== Toggle para mostrar/ocultar la sección de cambio de contraseña =====
    const seccionPassword = document.getElementById('seccionPassword');
    const btnMostrar = document.getElementById('btnMostrarPassword');
    const btnOcultar = document.getElementById('btnOcultarPassword');

    if (btnMostrar && seccionPassword) {
        btnMostrar.addEventListener('click', () => {
            // Mostramos la sección y hacemos scroll hacia ella.
            seccionPassword.classList.add('seccionPasswordVisible');
            seccionPassword.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    }

    if (btnOcultar && seccionPassword) {
        btnOcultar.addEventListener('click', () => {
            // Ocultamos la sección de contraseña.
            seccionPassword.classList.remove('seccionPasswordVisible');
        });
    }

    // Si hay errores de validación de contraseña, mostramos la sección automáticamente.
    // El atributo data-password-errors se establece desde Blade en el HTML.
    if (seccionPassword && seccionPassword.dataset.passwordErrors === 'true') {
        seccionPassword.classList.add('seccionPasswordVisible');
    }
});
