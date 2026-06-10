const inputSubida = document.getElementById('entrada_archivo');
const botonSubida = document.getElementById('boton_subir');
const contenedorNombre = document.getElementById('nombre_archivo_elegido'); 

inputSubida.addEventListener('change', function() {
    if (inputSubida.files && inputSubida.files.length > 0) {
        const nombreArchivo = inputSubida.files[0].name;
        contenedorNombre.textContent = "Archivo: " + nombreArchivo;
        botonSubida.style.display = 'inline-block';
    } else {
        contenedorNombre.textContent = '';
        botonSubida.style.display = 'none';
    }
});
