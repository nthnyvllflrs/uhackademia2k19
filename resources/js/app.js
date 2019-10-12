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
import Home from './components/HomeComponent.vue'
import Dashboard from './components/DashboardComponent.vue'
import Report from './components/ReportComponent.vue'
import Resident from './components/ResidentComponent.vue'
import Barangay from './components/BarangayComponent.vue'
import Collector from './components/CollectorComponent.vue'


Vue.use(VueRouter)
const routes = [    
    { 
        path: '/', 
        name: 'Landing', 
        component: Landing,
        beforeEnter(to, from, next) {
            if(!localStorage.getItem('user-token')){
                next()
            } else {
                next({name: 'reports'})
            }
        },
        children: [
            { path: '/', name: 'home', components: {landing: Home}},
            { path: '/signin', name: 'signin', components: {landing: Signin}},
        ]
    },
    { 
        path: '/dashboard', 
        name: 'dashboard', 
        component: Dashboard,
        beforeEnter(to, from, next) {
            if(localStorage.getItem('user-token')){
                if(to.name == 'dashboard') {next({name: 'reports'})}
                else {next()}
            } else {
                next({name: 'signin'})
            }
        },
        children: [
            { path: '/reports', name: 'reports', components: {dashboard: Report}},
            { path: '/residents', name: 'residents', components: {dashboard: Resident}},
            { path: '/barangays', name: 'barangays', components: {dashboard: Barangay}},
            { path: '/collectors', name: 'collectors', components: {dashboard: Collector}},
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

import * as VueGoogleMaps from 'vue2-google-maps'

Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyBLvHFeixDacvhmdX-L_0EoG4of6n0pM1A',
        libraries: 'places',
    },
    installComponents: true
})

const app = new Vue({
    vuetify, router,
}).$mount('#app')
