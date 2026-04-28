document.addEventListener('DOMContentLoaded', function() {
    
    const selector = document.getElementById('opcionesVista');
    
    if (selector) {
        selector.addEventListener('change', function() {
            this.form.submit();
        });
    }
});