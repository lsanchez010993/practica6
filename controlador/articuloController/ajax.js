document.addEventListener("DOMContentLoaded", function () {
    const input = document.querySelector('.search-bar input[name="nombre_comun"]');
    const resultados = document.querySelector('#resultat'); // Seleccionar el contenedor existente

    let timeout = null; // Para evitar múltiples peticiones simultáneas

    input.addEventListener('input', function () {
        const query = input.value.trim();

        // Limpiar resultados si no hay texto
        if (!query) {
            resultados.innerHTML = '';
            return;
        }

        // Cancelar solicitudes previas si el usuario sigue escribiendo
        if (timeout) clearTimeout(timeout);

        // Esperar un breve momento antes de realizar la solicitud
        timeout = setTimeout(() => {
            fetch(`controlador/articuloController/buscarPorNombre.php?nombre_comun=${encodeURIComponent(query)}`)
                .then(response => response.text())
                .then(html => {
                    resultados.innerHTML = html; // Insertar directamente el HTML de los resultados
                })
                .catch(error => {
                    resultados.innerHTML = '<p>Ocurrió un error al realizar la búsqueda</p>';
                    console.error(error);
                });
        }, 300); // Retraso de 300ms para evitar múltiples solicitudes simultáneas
    });
});
