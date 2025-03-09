import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

window.Echo = new Echo({
    // Opción para usar Pusher
    // broadcaster: 'pusher',
    // // key: process.env.MIX_PUSHER_APP_KEY,
    // // cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    // key: import.meta.env.VITE_PUSHER_APP_KEY, // Usar import.meta.env
    // cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER, // Usar import.meta.env
    // forceTLS: true
    
    // Opción para usar Reverb
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

//import './echo';
