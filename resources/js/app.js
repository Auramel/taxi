import './bootstrap';

import {createApp} from 'vue';
import AppComponent from './Components/AppComponent';

const app = createApp({});

app
    .component('app-component', AppComponent)
;

app.mount('#app');
