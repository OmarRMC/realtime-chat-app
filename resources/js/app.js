import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

window.Echo.channel('canal-mensajes')
    .listen('MensajeEnviado', (e) => {
        console.log('Mensaje recibido:', e.mensaje);
    });
console.log(window.Echo)
Alpine.start();
