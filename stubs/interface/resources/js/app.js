import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import { createApp } from 'vue'
import MessengerComponent from "./components/Messenger/Chat/Messenger.vue";
import TemplateIndex from "./components/Messenger/Template/Index.vue";
import TemplateCreate from "./components/Messenger/Template/Create.vue";
import TemplateUpdate from "./components/Messenger/Template/Update.vue";
import TemplateDetail from "./components/Messenger/Template/Detail.vue";

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

let element = document.getElementById('messenger')
if (element !== null) {
    const app = createApp({});
    app.component('MessengerComponent', MessengerComponent)
    app.component('TemplateIndex', TemplateIndex)
    app.component('TemplateCreate', TemplateCreate)
    app.component('TemplateUpdate', TemplateUpdate)
    app.component('TemplateDetail', TemplateDetail)

    app.mount('#messenger');
}

// const files = require.context('../myFolder', true, /(Module|Utils)\.js$/)
