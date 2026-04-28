document.addEventListener('DOMContentLoaded', function() {
    
    const selector = document.getElementById('selectorVistas');
    
    if (selector) {
        selector.addEventListener('change', function() {
            this.form.submit();
        });
    }
});