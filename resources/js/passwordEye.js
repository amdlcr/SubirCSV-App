document.addEventListener('DOMContentLoaded', () => {
    
    // Ojo en Password
    const toggleBtn = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');
    const eyeOpen = document.getElementById('ojo-abierto');
    const eyeClosed = document.getElementById('ojo-cerrado');

    if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                if (eyeOpen) eyeOpen.classList.add('hidden');
                if (eyeClosed) eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                if (eyeOpen) eyeOpen.classList.remove('hidden');
                if (eyeClosed) eyeClosed.classList.add('hidden');
            }
        });
    }

    //Ojo en Confirm Password
    const toggleConfirmBtn = document.getElementById('toggle-password-confirm');
    const confirmInput = document.getElementById('password_confirmation');
    const eyeOpenConfirm = document.getElementById('ojo-abierto-confirm');
    const eyeClosedConfirm = document.getElementById('ojo-cerrado-confirm');

    if (toggleConfirmBtn && confirmInput) {
        toggleConfirmBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (confirmInput.type === 'password') {
                confirmInput.type = 'text';
                if (eyeOpenConfirm) eyeOpenConfirm.classList.add('hidden');
                if (eyeClosedConfirm) eyeClosedConfirm.classList.remove('hidden');
            } else {
                confirmInput.type = 'password';
                if (eyeOpenConfirm) eyeOpenConfirm.classList.remove('hidden');
                if (eyeClosedConfirm) eyeClosedConfirm.classList.add('hidden');
            }
        });
    }
});