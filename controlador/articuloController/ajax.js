document.addEventListener("DOMContentLoaded", function () {
    const input = document.querySelector('.search-bar input[name="nombre_comun"]');
    const resultados = document.querySelector('#resultat'); 

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

      
        timeout = setTimeout(() => {
            fetch(`controlador/articuloController/buscarPorNombre.php?nombre_comun=${encodeURIComponent(query)}`)
                .then(response => response.text())
                .then(html => {
                    resultados.innerHTML = html; 
                })
                .catch(error => {
                    resultados.innerHTML = '<p>Ocurrió un error al realizar la búsqueda</p>';
                    console.error(error);
                });
        }, 300); 
    });
});
