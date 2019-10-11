require('./bootstrap');

import vuetify from './plugins/vuetify'
import router from './plugins/router'

window.Vue = require('vue');

const app = new Vue({
    vuetify, router,
    el: '#app',
});
