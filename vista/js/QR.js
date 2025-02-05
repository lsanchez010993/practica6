
function mostrarModal(id) {


    const modalData = document.getElementById(`modal-data-${id}`);
    const modalBody = document.getElementById('modal-body');
    modalBody.innerHTML = modalData.innerHTML; 


    const elementos = modalBody.querySelectorAll('[id]');
    elementos.forEach((el) => {
        const nuevoId = `${el.id}-modal`;
        modalBody.innerHTML = modalBody.innerHTML.replaceAll(el.id, nuevoId);
        el.id = nuevoId; 
    });

    document.getElementById('qr-modal').style.display = 'block';

    const checkboxes = modalBody.querySelectorAll('.checkbox-qr');
    checkboxes.forEach(chk => {
        chk.addEventListener('change', () => {
            regenerarQR(id);
        });
    });
}



function regenerarQR(id) {
    
    const nombreComun = document.getElementById(`nombre-comun-${id}-modal`).checked;
    const nombreCientifico = document.getElementById(`nombre-cientifico-${id}-modal`).checked;
    const descripcion = document.getElementById(`descripcion-${id}-modal`).checked;

  
    const usuario_ID = document.getElementById(`usuario-${id}-modal`)?.checked || false;

    console.log(usuario_ID);


    const datos = {
        id: id, 
        incluirNombreComun: nombreComun,
        incluirNombreCientifico: nombreCientifico,
        incluirDescripcion: descripcion,
        incluirUsuario_ID: usuario_ID
    };

    console.log("Datos enviados:", datos);

  
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