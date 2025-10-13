document.addEventListener('DOMContentLoaded', function() {
    const interruptor = document.getElementById('interruptorModoEscuro');
    if (interruptor) {
        interruptor.addEventListener('change', function() {
            document.body.classList.toggle('modo-escuro');
            let tema = document.body.classList.contains('modo-escuro') ? 'escuro' : 'claro';
            document.cookie = "tema=" + tema + ";path=/;max-age=" + 60*60*24*365;
        });
    }

    const inputFoto = document.getElementById('foto');
    const previewFoto = document.getElementById('previewFoto');

    if (inputFoto && previewFoto) {
        inputFoto.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewFoto.src = e.target.result;
                    previewFoto.style.display = 'block'; 
                }
                reader.readAsDataURL(file);
            }
        });
    }
});