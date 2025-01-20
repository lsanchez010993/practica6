// Confirmar eliminación
function confirmarEliminacion() {
    return confirm("¿Estás seguro de que deseas eliminar este artículo?");
}

// Mostrar el modal con los datos del artículo
function mostrarModal(id) {
    const modalData = document.getElementById(`modal-data-${id}`);
    const modalBody = document.getElementById('modal-body');
    modalBody.innerHTML = modalData.innerHTML;
    document.getElementById('qr-modal').style.display = 'block';
}

// Cerrar el modal
function cerrarModal() {
    document.getElementById('qr-modal').style.display = 'none';
}
