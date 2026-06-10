//Spinner del Login
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-login');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            if (this.checkValidity()) {
                const btn = document.getElementById('btn-login');
                const icon = document.getElementById('icon-login');
                const spinner = document.getElementById('spinner-login');
                const text = document.getElementById('text-login');

                if (icon) icon.classList.add('hidden');
                if (spinner) spinner.classList.remove('hidden');
                if (text) text.innerText = 'Cargando...';
                
                if (btn) {
                    btn.disabled = true;
                    btn.classList.add('opacity-75', 'cursor-not-allowed');
                }
            }
        });
    }
});


//Spinner de Registro
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-register');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            if (this.checkValidity()) {
                const btn = document.getElementById('btn-register');
                const spinner = document.getElementById('spinner-register');
                const text = document.getElementById('text-register');

                if (spinner) spinner.classList.remove('hidden');
                if (text) text.innerText = 'Cargando...';
                
                if (btn) {
                    btn.disabled = true;
                    btn.classList.add('opacity-75', 'cursor-not-allowed');
                }
            }
        });
    }
});

//Spinner de Forgot Password

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-forgot-password');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            if (this.checkValidity()) {
                const btn = document.getElementById('btn-forgot-password');
                const spinner = document.getElementById('spinner-forgot-password');
                const text = document.getElementById('text-forgot-password');

                if (spinner) spinner.classList.remove('hidden');
                if (text) text.innerText = 'Cargando...';
                
                if (btn) {
                    btn.disabled = true;
                    btn.classList.add('opacity-75', 'cursor-not-allowed');
                }
            }
        });
    }
});