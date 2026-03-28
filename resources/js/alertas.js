

// Crear una alerta para que al intentar acceder a una pagina, se muestre un mensaje de mantenimiento.
window.mostrarAlertaMantenimiento = (event) => {
    if (event) {
        event.preventDefault();
    }

    alert("¡Lo sentimos! Esta función está actualmente en mantenimiento. Por favor, inténtalo de nuevo más tarde.");
};  