/**
 * ticketEvento.js
 * Lógica del formulario de inscripción a eventos:
 * - Generar ticket PDF en nueva pestaña.
 * - Enviar ticket PDF por email al creador del evento (fetch/AJAX).
 * - Actualizar la vista previa del ticket en tiempo real.
 */

document.addEventListener('DOMContentLoaded', () => {
    // Referencia al formulario principal de inscripción.
    const formApuntarse = document.getElementById('formApuntarse');
    // Si no existe el formulario (usuario no autenticado), no ejecutamos nada.
    if (!formApuntarse) return;

    // Referencias a los botones de acción.
    const btnPdf = document.getElementById('btnGenerarPdf');
    const btnEmail = document.getElementById('btnEnviarEmail');

    // Formulario oculto para enviar POST con target="_blank" (pestaña nueva).
    const formPdfOculto = document.getElementById('formPdfOculto');

    // Contenedor de datos (rutas y CSRF) inyectados desde Blade.
    const dataSection = document.getElementById('ticketEventoData');

    // Div para mostrar mensajes de feedback al usuario.
    const feedbackEmail = document.getElementById('feedbackEmail');

    // Referencias a los campos del formulario principal.
    const campoNombre = document.getElementById('nombre');
    const campoApellido = document.getElementById('apellido');
    const campoEmail = document.getElementById('email');
    const campoNsocio = document.getElementById('nsocio');
    const campoTelefono = document.getElementById('telefono');

    // Referencias a los párrafos de vista previa del ticket.
    const previewNombre = document.getElementById('previewNombre');
    const previewApellido = document.getElementById('previewApellido');
    const previewEmail = document.getElementById('previewEmail');
    const previewNsocio = document.getElementById('previewNsocio');
    const previewTelefono = document.getElementById('previewTelefono');

    /**
     * Validar que todos los campos obligatorios del formulario estén rellenos.
     * Usa la API de validación nativa del navegador (reportValidity).
     * @returns {boolean} true si el formulario es válido.
     */
    const validarFormulario = () => {
        // reportValidity() muestra los mensajes de error nativos del navegador.
        return formApuntarse.reportValidity();
    };

    /**
     * Actualizar la vista previa del ticket con los valores actuales del formulario.
     * Se ejecuta en cada evento 'input' de los campos.
     */
    const actualizarPreview = () => {
        // Actualizamos cada párrafo del aside con el valor actual o un guión si está vacío.
        previewNombre.innerHTML = '<strong>Nombre:</strong> ' + (campoNombre.value || '—');
        previewApellido.innerHTML = '<strong>Apellido:</strong> ' + (campoApellido.value || '—');
        previewEmail.innerHTML = '<strong>Email:</strong> ' + (campoEmail.value || '—');
        previewNsocio.innerHTML = '<strong>Nº Socio:</strong> ' + (campoNsocio.value || '—');
        previewTelefono.innerHTML = '<strong>Teléfono:</strong> ' + (campoTelefono.value || '—');
    };

    // Escuchamos el evento 'input' en cada campo para actualizar la preview en tiempo real.
    [campoNombre, campoApellido, campoEmail, campoNsocio, campoTelefono].forEach((campo) => {
        campo.addEventListener('input', actualizarPreview);
    });

    /**
     * Mostrar mensaje de feedback al usuario (éxito o error) tras enviar email.
     * @param {string} mensaje  Texto a mostrar.
     * @param {boolean} esExito true = verde (éxito), false = rojo (error).
     */
    const mostrarFeedback = (mensaje, esExito) => {
        feedbackEmail.textContent = mensaje;
        // Aplicamos clase de éxito o error para cambiar el estilo visual.
        feedbackEmail.className = 'feedbackEmail ' + (esExito ? 'feedbackExito' : 'feedbackError');
        feedbackEmail.style.display = 'block';
    };

    // ============================================================
    // BOTÓN: Generar ticket PDF (abre en pestaña nueva)
    // ============================================================
    btnPdf.addEventListener('click', () => {
        // Primero validamos que los campos estén rellenos.
        if (!validarFormulario()) return;

        // Copiamos los valores del formulario principal al formulario oculto.
        formPdfOculto.querySelector('[name="nombre"]').value = campoNombre.value;
        formPdfOculto.querySelector('[name="apellido"]').value = campoApellido.value;
        formPdfOculto.querySelector('[name="email"]').value = campoEmail.value;
        formPdfOculto.querySelector('[name="nsocio"]').value = campoNsocio.value;
        formPdfOculto.querySelector('[name="telefono"]').value = campoTelefono.value;

        // Enviamos el formulario oculto con target="_blank" (se abre el PDF en nueva pestaña).
        formPdfOculto.submit();
    });

    // ============================================================
    // BOTÓN: Enviar ticket por email al creador del evento
    // ============================================================
    btnEmail.addEventListener('click', () => {
        // Validamos antes de enviar.
        if (!validarFormulario()) return;

        // Obtenemos la URL del endpoint y el token CSRF desde los data attributes.
        const urlEmail = dataSection.dataset.urlEmail;
        const csrfToken = dataSection.dataset.csrf;

        // Deshabilitamos el botón para evitar dobles envíos.
        btnEmail.disabled = true;
        btnEmail.textContent = 'Enviando...';

        // Construimos el cuerpo de la petición con los datos del formulario.
        const formData = new FormData();
        formData.append('nombre', campoNombre.value);
        formData.append('apellido', campoApellido.value);
        formData.append('email', campoEmail.value);
        formData.append('nsocio', campoNsocio.value);
        formData.append('telefono', campoTelefono.value);

        // Enviamos la petición AJAX (fetch) al endpoint de envío de email.
        fetch(urlEmail, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                // Mostramos feedback según la respuesta del servidor.
                mostrarFeedback(data.message, data.success);
            })
            .catch(() => {
                // Error de red o del servidor.
                mostrarFeedback('Error de conexión. Inténtalo de nuevo.', false);
            })
            .finally(() => {
                // Rehabilitamos el botón sea cual sea el resultado.
                btnEmail.disabled = false;
                btnEmail.textContent = 'Enviar ticket por email';
            });
    });
});
