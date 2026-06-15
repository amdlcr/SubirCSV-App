
document.addEventListener('alpine:init', () => {
    //Para que cargue automaticamente la acción y no espere al activar el 2FA 
    Alpine.data('formularioDosFactor', () => ({
        cargando: false,
        init() {
            if (sessionStorage.getItem('intentando_activar_2fa') === 'true') {
                sessionStorage.removeItem('intentando_activar_2fa');
                this.cargando = true;
                this.$refs.form2fa.submit();
            }
        },
        guardarIntento() {
            sessionStorage.setItem('intentando_activar_2fa', 'true');
        }
    }));

    //Para que cargue automaticamente la acción y no espere al regenerar los Códigos de Recuperación
    Alpine.data('formularioCodigos', () => ({
        cargando: false,
        init() {
            if (sessionStorage.getItem('intentando_regenerar_codigos') === 'true') {
                sessionStorage.removeItem('intentando_regenerar_codigos');
                this.cargando = true;
                this.$refs.formCodigos.submit();
            }
        },
        guardarIntento() {
            sessionStorage.setItem('intentando_regenerar_codigos', 'true');
        }
    }));
});