/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
import Echo from 'laravel-echo';

import Pusher from 'pusher-js';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

window.Pusher = Pusher;


window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '1c0d73f2452a1f8c84a4',
    cluster: 'eu',
    encrypted: true,
    disableStats: true,
    forceTLS: true,

    wsHost: window.location.hostname,
    wsPort: 6001,
    wssPort: 443, // Порт для WSS (опционально)
});


