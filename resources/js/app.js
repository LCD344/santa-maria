import {createApp} from 'vue';
import App from './components/App.vue';

window.token = document.head.querySelector('meta[name="csrf-token"]').content;

import {library} from '@fortawesome/fontawesome-svg-core'
import {faEye, faTrash} from '@fortawesome/free-solid-svg-icons'

library.add(faEye, faTrash)

createApp({
    components: {
        App
    }
}).mount("#app");
