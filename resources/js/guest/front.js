window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Vue = require('vue');

import App from './App.vue';

// aggiungiamo l'import del file router.js
import router from "./router";

const app = new Vue({
    el: '#app',
    render: h => h(App),
    // aggiungiamo l'oggetto router all'istanza Vue
	router
});
