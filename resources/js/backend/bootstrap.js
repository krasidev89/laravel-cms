window._ = require('lodash');

try {
    window.$ = window.jQuery = require('jquery');
    window.Popper = require('@popperjs/core');
    window.bootstrap = require('bootstrap');
    require('bootstrap-datepicker');
    require('bootstrap-datetime-picker');
    require('bootstrap-timepicker');
    require('datatables.net-bs4');
    require('datatables.net-responsive-bs4');
    require('datatables.net-rowreorder-bs4');
    require('highcharts');
    require('nvd3');
    require('select2');
    window.Swal = require('sweetalert2');
    require('tinymce');
    require('tinymce/icons/default');
    require('tinymce/models/dom');
    require('tinymce/themes/silver');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: process.env.MIX_PUSHER_HOST ?? `ws-${process.env.MIX_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: process.env.MIX_PUSHER_PORT ?? 80,
//     wssPort: process.env.MIX_PUSHER_PORT ?? 443,
//     forceTLS: (process.env.MIX_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
