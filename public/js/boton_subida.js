const inputSubida = document.getElementById('entrada_archivo');
const iconoSubida = document.getElementById('icono_subir');
const botonSubida = document.getElementById('boton_subir');

inputSubida.addEventListener('change', function() {
   
    if (inputSubida.files.length > 0) {
        const nombreArchivo = inputSubida.files[0].name;

        iconoSubida.textContent = nombreArchivo;
        botonSubida.style.display = 'inline-block';
    } 
});