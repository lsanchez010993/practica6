
    // Función para mostrar el modal y cargar su contenido
    function mostrarModal(id) {
        // Mostramos el contenido existente en el div de datos
        const modalData = document.getElementById(`modal-data-${id}`);
        const modalBody = document.getElementById('modal-body');
        modalBody.innerHTML = modalData.innerHTML;
        
        // Mostramos el modal
        document.getElementById('qr-modal').style.display = 'block';

        // Una vez que hemos "inyectado" el contenido en el modal,
        // necesitamos enlazar los checkboxes de este modal
        // para que, cuando cambien, regeneren el QR:
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

        // Preparamos los datos que queremos enviar al backend
        const datos = {
            id: id,  // opcional, por si el backend necesita saber qué animal es
            incluirNombreComun: nombreComun,
            incluirNombreCientifico: nombreCientifico,
            incluirDescripcion: descripcion
        };

        // Llamamos al script que genera el QR (ruta de ejemplo: generar_qr.php)
        // Suponiendo que responda con algo como: { success: true, qr_url: "ruta/o/base64" }
        fetch('ruta/al/script/generar_qr.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(datos)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizamos la imagen del QR en el modal:
                const qrImg = document.getElementById(`qr-img-${id}`);
                // Si el backend genera un base64, sería: qrImg.src = data.qr_url;
                // Si solo devuelve una ruta (ej. "/images/qr_temp.png"), ajusta según necesites:
                qrImg.src = data.qr_url;
            } else {
                alert('No se pudo generar el código QR.');
            }
        })
        .catch(error => {
            console.error('Error al regenerar el QR:', error);
        });
    }

    function cerrarModal() {
        document.getElementById('qr-modal').style.display = 'none';
    }

