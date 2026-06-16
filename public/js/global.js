document.addEventListener('alpine:init', () => {
    Alpine.data('formularioAutoSubmit', (storageKey, formRef) => ({
        cargando: false,

        init() {
            if (sessionStorage.getItem(storageKey) === '1') {
                sessionStorage.removeItem(storageKey);

                this.cargando = true;

                this.$nextTick(() => {
                    this.$refs[formRef].submit();
                });
            }
        },

        guardarIntento() {
            this.cargando = true;
            sessionStorage.setItem(storageKey, '1');
        }
    }));
});


//Efecto ojos
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.toggle-password').forEach(toggle => {

        toggle.addEventListener('click', () => {

            const wrapper = toggle.closest('.password-wrapper');
            const input = wrapper.querySelector('.password-input');
            const icon = wrapper.querySelector('.password-icon');

            const isPassword = input.type === 'password';

            if (isPassword) {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
});

//Spinner
document.addEventListener('submit', (e) => {
    const form = e.target;

    if (!form.checkValidity()) return;

    const boton = form.querySelector('.boton-submit');
    if (!boton) return;

    boton.classList.add('cargando');
    boton.disabled = true;
});