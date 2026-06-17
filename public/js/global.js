

//Efecto ojos
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.toggle-password').forEach(toggle => {

        toggle.addEventListener('click', () => {

            const wrapper = toggle.closest('.password-wrapper');
            const input = wrapper.querySelector('.password-input');
            const icon = wrapper.querySelector('.password-icon');

            const isPassword = input.type === 'password';

            input.type = isPassword ? 'text' : 'password';

            icon.classList.toggle('fa-eye', !isPassword);
            icon.classList.toggle('fa-eye-slash', isPassword);
            
        });
    });
});

//Spinner
document.querySelectorAll('.form-con-spinner').forEach((form) => {
    form.addEventListener('submit', () => {

        if (!form.checkValidity()) return;

        const boton = form.querySelector('.boton-submit');
        if (!boton) return;

        boton.classList.add('cargando');
        boton.disabled = true;
    });
});