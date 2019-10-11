require('./bootstrap');

window.Vue = require('vue');

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@fortawesome/fontawesome-free/css/all.css'

Vue.use(Vuetify)
const opts = {icons:{iconfont: 'fa',}}
const vuetify = new Vuetify(opts)

import VueRouter from 'vue-router'
import Landing from './components/LandingComponent.vue'
import Signin from './components/SigninComponent.vue'
import Signup from './components/SignupComponent.vue'
import Dashboard from './components/DashboardComponent.vue'
import Report from './components/ReportComponent.vue'
import Resident from './components/ResidentComponent.vue'
import Barangay from './components/BarangayComponent.vue'


Vue.use(VueRouter)
const routes = [    
    { 
        path: '/', 
        name: 'Landing', 
        component: Landing,
        // beforeEnter(to, from, next) {
        //     if(!sessionStorage.getItem('user-token')){
        //         next()
        //     } else {
        //         next({name: 'requests'})
        //     }
        // },
        children: [
            { path: '/signin', name: 'signin', components: {landing: Signin}},
        ]
    },
    { 
        path: '/dashboard', 
        name: 'dashboard', 
        component: Dashboard,
        // beforeEnter(to, from, next) {
        //     if(!sessionStorage.getItem('user-token')){
        //         next()
        //     } else {
        //         next({name: 'requests'})
        //     }
        // },
        children: [
            { path: '/reports', name: 'reports', components: {dashboard: Report}},
            { path: '/residents', name: 'residents', components: {dashboard: Resident}},
            { path: '/barangays', name: 'barangays', components: {dashboard: Barangay}},
        ]
    },
]

// Add a request interceptor to axios
axios.interceptors.request.use(function (config) {
    let authToken = localStorage.getItem('user-token') || ''
    if (authToken) {
        config.headers['Authorization'] = `Bearer ${authToken}`
    }   
    return config;
}, function (error) {
    return Promise.reject(error);
});

const router = new VueRouter({mode: 'history', routes})

const app = new Vue({
    vuetify, router,
}).$mount('#app')

// require('./bootstrap');

// import vuetify from './plugins/vuetify'
// import router from './plugins/router'

// window.Vue = require('vue');

// const app = new Vue({
//     vuetify, router,
//     el: '#app',
// });
