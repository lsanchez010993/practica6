
function mostrarModal(id) {


    const modalData = document.getElementById(`modal-data-${id}`);
    const modalBody = document.getElementById('modal-body');
    modalBody.innerHTML = modalData.innerHTML; // Copiamos el contenido

    // Actualizamos los IDs del contenido copiado para evitar duplicados
    const elementos = modalBody.querySelectorAll('[id]');
    elementos.forEach((el) => {
        const nuevoId = `${el.id}-modal`;
        modalBody.innerHTML = modalBody.innerHTML.replaceAll(el.id, nuevoId);
        el.id = nuevoId; // Actualizamos el ID directamente
    });

    document.getElementById('qr-modal').style.display = 'block';

    // Enlazamos los checkboxes del modal al evento para regenerar QR
    const checkboxes = modalBody.querySelectorAll('.checkbox-qr');
    checkboxes.forEach(chk => {
        chk.addEventListener('change', () => {
            regenerarQR(id);
        });
    });
}


// Función que hace la petición AJAX/fetch para regenerar el QR
function regenerarQR(id) {
    // Accedemos al modal actual y buscamos sus checkboxes:
    const nombreComun = document.getElementById(`nombre-comun-${id}`).checked;
    const nombreCientifico = document.getElementById(`nombre-cientifico-${id}`).checked;
    const descripcion = document.getElementById(`descripcion-${id}`).checked;
    const rutaImagen = document.getElementById(`rutaImagen-${id}`).checked;
    const usuario_ID = document.getElementById(`usuario_id-${id}`).checked;


 
    const datos = {
        id: id, // opcional, por si el backend necesita saber qué animal es
        incluirNombreComun: nombreComun,
        incluirNombreCientifico: nombreCientifico,
        incluirDescripcion: descripcion,
        incluirRutaImangen: rutaImagen,
        incluirUsuario_ID:usuario_ID
    };


    fetch('controlador/articuloController/generarQR.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(datos)
        })
        .then(response => response.json())
        .then(data => {

            console.log('Respuesta del servidor:', data.qr_url);
            // Encuentra el elemento <img> y actualiza el atributo src
            const imgElement = document.getElementById("insertarQR-modal");
            imgElement.setAttribute("src", data.qr_url);
        })
        .catch(error => {
            console.error('Error:', error);
        });

}

function cerrarModal() {
    document.getElementById('qr-modal').style.display = 'none';
}
window.mostrarModal = mostrarModal;
window.cerrarModal = cerrarModal;