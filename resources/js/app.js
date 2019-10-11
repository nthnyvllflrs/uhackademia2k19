require('./bootstrap');

window.Vue = require('vue');

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@fortawesome/fontawesome-free/css/all.css'

Vue.use(Vuetify)
const opts = {icons:{iconfont: 'fa',}}
const vuetify = new Vuetify(opts)

import VueRouter from 'vue-router'

import Home from './components/HomeComponent.vue'
import Login from './components/LoginComponent.vue'
import Dashboard from './components/DashboardComponent.vue'
import Report from './components/ReportComponent.vue'
import Barangay from './components/BarangayComponent.vue'
import Resident from './components/ResidentComponent.vue'

Vue.use(VueRouter)
const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
        children: [
            { path: '/login', name: 'login', components: { landing: Login}}
        ],
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        children: [
            { path: '/reports', name: 'report', components: { dashboard: Report}},
            { path: '/barangays', name: 'barangay', components: { dashboard: Barangay}},
            { path: '/residents', name: 'resident', components: { dashboard: Resident}},
        ]
    }
]

const router = new VueRouter({mode: 'history', routes})

const app = new Vue({
    vuetify, router,
}).$mount('#app')
